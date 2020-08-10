<?php

namespace snor\web\mobile\models;

use Yii;
use shushi100\yii\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id ID
 * @property string $title 标题
 * @property string $desc 特性描述
 * @property string $pic 商品图片
 * @property int $cate_id 分类
 * @property string $content 主体内容
 * @property int $is_show 是否显示
 * @property int $created_at 创建时间
 * @property int $updated_at 最后修改时间
 * @property string $picUrl
 * @property mixed $showName
 * @property boolean $hasPic
 * @method getUploadedUrl($attribute)
 * @property ProductCate $cate
 * @property mixed $cateName
 * @property mixed $code
 */
class Product extends \yii\db\ActiveRecord
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
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'cate_id'], 'required'],
            [['desc', 'content'], 'string'],
            [['cate_id', 'is_show', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['pic', 'image', 'maxSize' => 2097152, 'extensions' => ['png', 'jpg', 'jpeg']],
            [['cate_id'], 'exist',
                'targetClass' => ProductCate::class,
                'targetAttribute' => 'id',
                'filter' => ['is_show' => ProductCate::STATE_SHOW],
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
            'desc' => '特性描述',
            'pic' => '商品图片',
            'picUrl' => '商品图片',
            'cate_id' => '分类',
            'cateName' => '分类',
            'content' => '主体内容',
            'is_show' => '是否显示',
            'showName' => '是否显示',
            'created_at' => '创建时间',
            'updated_at' => '最后修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCate()
    {
        return $this->hasOne(ProductCate::class, ['id' => 'cate_id']);
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
     * @param $code
     * @return string
     */
    public function getCateNameByCode($code)
    {
        if(!empty($code)){
            $model = ProductCate::find()->where(['code' => $code])->limit(1)->one();
            /** @var $model ProductCate */
            if(!empty($model)){
                return $model->name;
            }
        }

        return '';
    }
}
