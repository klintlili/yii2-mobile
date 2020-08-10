<?php

namespace klintlili\mobile\models;

use Yii;
use shushi100\yii\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\caching\DbDependency;

/**
 * This is the model class for table "{{%case}}".
 *
 * @property int $id ID
 * @property string $title 标题
 * @property string $intro 简介
 * @property string $desc 描述
 * @property string $pic 项目图片
 * @property int $cate_id 分类
 * @property string $content 主体内容
 * @property int $is_show 是否显示
 * @property int $created_at 创建时间
 * @property int $updated_at 最后修改时间
 * @property mixed $cateName
 * @property mixed $showName
 * @property string $picUrl
 * @property string $picUrlByPath
 * @property boolean $hasPic
 * @method getUploadedUrl($attribute)
 * @property CaseCate $cate
 * @property mixed $code
 * @property integer $is_comm 是否推荐
 * @property Project $preProject
 * @property Project $nextProject
 * @property Project[] $topNewProjects
 * @property Project[] $relatedProjects
 */
class Project extends \yii\db\ActiveRecord
{
    const STATE_SHOW = 1;//显示

    const STATE_HIDE = 0;//隐藏

    static public $showType = [
        self::STATE_SHOW => '显示',

        self::STATE_HIDE => '隐藏',
    ];

    const COMM_YES = 1;//是

    const COMM_NO = 0;//否

    static public $commType = [
        self::COMM_YES => '是',

        self::COMM_NO => '否',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%case}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'cate_id'], 'required'],
            [['desc', 'content'], 'string'],
            [['cate_id', 'is_show', 'is_comm', 'created_at', 'updated_at'], 'integer'],
            [['title', 'intro'], 'string', 'max' => 255],
            ['pic', 'image', 'maxSize' => 2097152, 'extensions' => ['png', 'jpg', 'jpeg']],
            [['cate_id'], 'exist',
                'targetClass' => CaseCate::class,
                'targetAttribute' => 'id',
                'filter' => ['is_show' => CaseCate::STATE_SHOW],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attributes' => ['pic'],
                'gd' => true,
            ],
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'intro' => '简介',
            'desc' => '描述',
            'pic' => '项目图片',
            'picUrl' => '项目图片',
            'cate_id' => '分类',
            'cateName' => '分类',
            'content' => '主体内容',
            'is_show' => '是否显示',
            'showName' => '是否显示',
            'is_comm' => '是否推荐',
            'commName' => '是否推荐',
            'created_at' => '创建时间',
            'updated_at' => '最后修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCate()
    {
        return $this->hasOne(CaseCate::class, ['id' => 'cate_id']);
    }

    /**
     * @return mixed
     */
    public function getCateName()
    {
        return ArrayHelper::getValue($this, 'cate.name');
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return ArrayHelper::getValue($this, 'cate.code');
    }

    /**
     * @return mixed
     */
    public function getShowName()
    {
        return ArrayHelper::getValue(self::$showType, $this->is_show);
    }

    /**
     * @return mixed
     */
    public function getCommName()
    {
        return ArrayHelper::getValue(self::$commType, $this->is_comm);
    }

    /**
     * @return boolean
     */
    public function getHasPic()
    {
        return is_string($this->pic) && !empty($this->pic);
    }

    /**
     * @return string
     */
    public function getPicUrl()
    {
        if (strncmp($this->pic, '//', 2) == 0) {
            return $this->pic;
        }
        return $this->getUploadedUrl('pic');
    }

    /**
     * @return mixed
     */
    public static function getSiteData()
    {
        $cache = Yii::$app->cache;
        $query = self::find()
            ->joinWith(['cate cate'], false)
            ->select([
                'ANY_VALUE (`case`.id) AS id',
                'ANY_VALUE (`case`.title) AS title',
                'ANY_VALUE (`case`.intro) AS intro',
                'ANY_VALUE (`case`.pic) AS pic',
                'ANY_VALUE (`cate`.white_icon) AS white_icon',
                'ANY_VALUE (`cate`.gray_icon) AS gray_icon',
                'ANY_VALUE (`cate`.`name`) AS name',
                '`case`.cate_id AS cate_id'
            ])
            ->where([
                'case.is_show' => self::STATE_SHOW,
                'case.is_comm' => self::COMM_YES
            ])->andWhere(['cate.is_show' => CaseCate::STATE_SHOW])
            ->groupBy(['cate_id'])
            ->orderBy(['cate.position' => SORT_ASC])
            ->asArray()
            ->limit(6);

        $dependency = new DbDependency(['sql'=> 'select max(updated_at) from `case` where is_show='.self::STATE_SHOW.' and is_comm='.self::COMM_YES]);

        $data = $cache->getOrSet('site_project_data', function () use ($query) {
            return $query->all();
        }, 3600, $dependency);

        return $data;
    }

    //上一个案例
    public function getPreProject()
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->select([
            '`case`.id AS id',
            '`case`.title AS title'
        ]);
        $query->where(['case.is_show' => self::STATE_SHOW]);
        $query->andWhere(['<', 'case.id', $this->id]);
        $query->andWhere(['cate.is_show' => CaseCate::STATE_SHOW]);
        $query->orderBy(['case.id' => SORT_DESC]);
        $query->limit(1);
        return $query->one();
    }

    //下一个案例
    public function getNextProject()
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->select([
            '`case`.id AS id',
            '`case`.title AS title'
        ]);
        $query->where(['case.is_show' => self::STATE_SHOW]);
        $query->andWhere(['>', 'case.id', $this->id]);
        $query->andWhere(['cate.is_show' => CaseCate::STATE_SHOW]);
        $query->orderBy(['case.id' => SORT_ASC]);
        $query->limit(1);
        return $query->one();
    }

    /**
     * 最新案例 读取2条数据
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getTopNewProjects()
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->where(['case.is_show' => self::STATE_SHOW]);
        $query->andWhere(['<>', 'case.id', $this->id]);
        $query->andWhere(['cate.is_show' => CaseCate::STATE_SHOW]);
        $query->orderBy(['case.id' => SORT_DESC]);
        $query->limit(2);
        return $query->all();
    }

    /**
     * 相关服务案例
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRelatedProjects($limit = 8)
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->where(['case.is_show' => self::STATE_SHOW]);
        $query->where(['case.cate_id' => $this->cate_id]);
        $query->andFilterWhere(['<>', 'case.id', $this->id]);
        $query->andWhere(['cate.is_show' => CaseCate::STATE_SHOW]);
        $query->orderBy(new Expression('rand()'));
        if($limit) {
            $query->limit($limit);
        }
        return $query->all();
    }

    /**
     * @param $code
     * @return string
     */
    public function getCateNameByCode($code)
    {
        if(!empty($code)){
            $model = CaseCate::find()->where(['code' => $code])->limit(1)->one();
            /** @var $model CaseCate */
            if(!empty($model)){
                return $model->name;
            }
        }

        return '';
    }
}
