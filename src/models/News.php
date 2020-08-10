<?php

namespace snor\web\mobile\models;

use Yii;
use shushi100\yii\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\caching\DbDependency;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id ID
 * @property string $title 标题
 * @property string $intro 简介
 * @property string $pic 新闻图片
 * @property int $cate_id 分类
 * @property string $content 主体内容
 * @property int $is_show 是否显示
 * @property int $created_at 创建时间
 * @property int $updated_at 最后修改时间
 * @property string $picUrl
 * @property mixed $showName
 * @property boolean $hasPic
 * @method getUploadedUrl($attribute)
 * @property  ProductCate $cate
 * @property mixed $cateName
 * @property mixed $commName
 * @property integer $is_comm 是否推荐
 * @property News $preArticle
 * @property News $nextArticle
 * @property News[] $topNewArticles
 * @property News[] $relatedArticles
 * @property mixed $code
 */
class News extends \yii\db\ActiveRecord
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
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'cate_id'], 'required'],
            [['cate_id', 'is_show', 'is_comm', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title', 'intro'], 'string', 'max' => 255],
            ['pic', 'image', 'maxSize' => 2097152, 'extensions' => ['png', 'jpg', 'jpeg']],
            [['cate_id'], 'exist',
                'targetClass' => NewsCate::class,
                'targetAttribute' => 'id',
                'filter' => ['is_show' => NewsCate::STATE_SHOW],
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
            'pic' => '新闻图片',
            'picUrl' => '新闻图片',
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
        return $this->hasOne(NewsCate::class, ['id' => 'cate_id']);
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
     * 首页-新闻中心板块左侧数据
     * @return mixed
     */
    public static function getHomeLeftData()
    {
        $cache = Yii::$app->cache;
        $query = self::find()
            ->joinWith(['cate cate'], false)
            ->select([
                '`news`.id AS id',
                '`news`.title AS title',
                '`news`.intro AS intro',
                '`news`.pic AS pic',
                '`news`.created_at AS created_at'
            ])
            ->where([
                'news.is_show' => self::STATE_SHOW,
                'news.is_comm' => self::COMM_YES
            ])->andWhere(['cate.is_show' => NewsCate::STATE_SHOW])
            ->orderBy(['news.id' => SORT_DESC])
            ->asArray()
            ->limit(5);

        $dependency = new DbDependency(['sql'=> 'select max(updated_at) from `news` where is_show='.self::STATE_SHOW.' and is_comm='.self::COMM_YES]);

        $data = $cache->getOrSet('site_news_data', function () use ($query) {
            return $query->all();
        }, 3600, $dependency);

        return $data;
    }

    /**
     * 首页-新闻中心板块右侧数据
     * @param $news_cate
     * @return array
     */
    public static function getHomeRightData($news_cate)
    {
        $cache = Yii::$app->cache;
        $data = [];
        /** @var $cate NewsCate */
        foreach ($news_cate as $cate) {
            $query = self::find()
                ->joinWith(['cate cate'], false)
                ->select([
                    '`news`.id AS id',
                    '`news`.title AS title',
                    '`news`.intro AS intro',
                    '`news`.pic AS pic',
                    '`news`.created_at AS created_at'
                ])
                ->where([
                    'news.is_show' => self::STATE_SHOW,
                    'news.cate_id' => $cate->id,
                ])->andWhere(['cate.is_show' => NewsCate::STATE_SHOW])
                ->orderBy(['news.id' => SORT_DESC])
                ->limit(10);

            $dependency = new DbDependency(['sql'=> 'select max(updated_at) from `news` where cate_id='.$cate->id.' and is_show='.self::STATE_SHOW]);

            $data[$cate->code] = $cache->getOrSet("site_news_data{$cate->id}", function () use ($query) {
                return $query->all();
            }, 3600, $dependency);
        }

        return $data;
    }

    //上一篇文章
    public function getPreArticle()
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->select([
            '`news`.id AS id',
            '`news`.title AS title'
        ]);
        $query->where(['news.is_show' => self::STATE_SHOW]);
        $query->andWhere(['<', 'news.id', $this->id]);
        $query->andWhere(['cate.is_show' => NewsCate::STATE_SHOW]);
        $query->orderBy(['news.id' => SORT_DESC]);
        $query->limit(1);
        return $query->one();
    }

    //下一篇文章
    public function getNextArticle()
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->select([
            '`news`.id AS id',
            '`news`.title AS title'
        ]);
        $query->where(['news.is_show' => self::STATE_SHOW]);
        $query->andWhere(['>', 'news.id', $this->id]);
        $query->andWhere(['cate.is_show' => NewsCate::STATE_SHOW]);
        $query->orderBy(['news.id' => SORT_ASC]);
        $query->limit(1);
        return $query->one();
    }

    /**
     * 最新新闻文章 读取n条数据,默认2条
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getTopNewArticles($limit = 2)
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->where(['news.is_show' => self::STATE_SHOW]);
        $query->andFilterWhere(['<>', 'news.id', $this->id]);
        $query->andWhere(['cate.is_show' => NewsCate::STATE_SHOW]);
        $query->orderBy(['news.id' => SORT_DESC]);
        if($limit) {
            $query->limit($limit);
        }
        return $query->all();
    }

    /**
     * 相关文章
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRelatedArticles($limit = 8)
    {
        $query = self::find();
        $query->joinWith(['cate cate'], false);
        $query->where(['news.is_show' => self::STATE_SHOW]);
        $query->where(['news.cate_id' => $this->cate_id]);
        $query->andFilterWhere(['<>', 'news.id', $this->id]);
        $query->andWhere(['cate.is_show' => NewsCate::STATE_SHOW]);
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
            $model = NewsCate::find()->where(['code' => $code])->limit(1)->one();
            /** @var $model NewsCate */
            if(!empty($model)){
                return $model->name;
            }
        }

        return '';
    }
}
