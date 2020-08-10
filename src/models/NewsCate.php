<?php

namespace klintlili\mobile\models;

use shushi100\yii\behaviors\PinyinSlugBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%news_cate}}".
 *
 * @property int $id 分类 ID
 * @property string $name 名称
 * @property string $code 拼音
 * @property int $is_show 是否显示
 * @property int $position 排序
 * @property mixed $showName
 */
class NewsCate extends ActiveRecord
{
    const STATE_SHOW = 1;//显示

    const STATE_HIDE = 0;//隐藏

    static public $showType = [
        self::STATE_SHOW => '显示',

        self::STATE_HIDE => '隐藏',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news_cate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'trim'],
            [['name'], 'required'],
            [['code'], 'required',
                'whenClient' => 'function(attribute,value){return ' . ($this->isNewRecord ? 'false' : 'true') . '}'],
            [['is_show', 'position'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['code'], 'match', 'pattern' => '/^[\w\-\._]+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => PinyinSlugBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'code',
                'delimiter' => '', // 不需要分隔符
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'code' => '拼音',
            'is_show' => '是否显示',
            'showName' => '是否显示',
            'position' => '排序',
        ];
    }

    /**
     * @return mixed
     */
    public function getShowName()
    {
        return ArrayHelper::getValue(self::$showType, $this->is_show);
    }

    /**
     * @param bool $filter
     * @return array
     */
    public static function getOptions($filter = false)
    {
        if ($filter) {
            return ArrayHelper::map(self::find()->where(['is_show' => self::STATE_SHOW])->orderBy('position')->asArray()->all(),
                'id', 'name');
        }
        return ArrayHelper::map(self::find()->orderBy('position')->asArray()->all(), 'id', 'name');
    }

    /**
     * @param bool|int $limit
     * @return array|ActiveRecord[]
     */
    public static function getCateList($limit = false)
    {
        $query = self::find()->where(['is_show' => self::STATE_SHOW]);
        if($limit){
            $query->limit($limit);
        }

        return $query->orderBy('position')->all();
    }

    //得到顶级code
    /**
     * @return mixed
     */
    public static function getTopCode()
    {
        $key = 0;
        return ArrayHelper::getValue(static::getCateList(), "$key.code");
    }
}
