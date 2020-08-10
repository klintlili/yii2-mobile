<?php

namespace snor\web\mobile\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%links}}".
 *
 * @property int $id id
 * @property string $name 名称
 * @property string $url 链接
 * @property int $link_cate_id 添加页面
 * @property string $qq QQ/MSN
 * @property string $pr PR值
 * @property string $br BR值
 * @property int $position 排序
 * @property int $state 状态,1=显示，0=隐藏
 * @property string $note 备注
 * @property int $created_at 创建时间
 * @property string $stateName
 * @property mixed $cateName
 */
class Links extends ActiveRecord
{
    /**
     * @var array
     */
    static public $cate = [
        '首页',
    ];

    const STATE_SHOW = 1;//显示

    const STATE_HIDE = 0;//隐藏

    static public $stateType = [
        self::STATE_SHOW => '显示',
        
        self::STATE_HIDE => '隐藏',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%links}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url', 'link_cate_id', 'state'], 'required'],
            [['link_cate_id', 'position', 'state', 'created_at'], 'integer'],
            ['note', 'string'],
            [['name', 'url', 'qq', 'pr', 'br'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
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
            'url' => '链接',
            'link_cate_id' => '添加页面',
            'qq' => 'QQ/MSN',
            'pr' => 'PR值',
            'br' => 'BR值',
            'position' => '排序',
            'state' => '状态',
            'stateName' => '状态',
            'note' => '备注',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @return mixed
     */
    public function getCateName()
    {
        return ArrayHelper::getValue(self::$cate, $this->link_cate_id);
    }

    /**
     * @return string
     */
    public function getStateName()
    {
        return ArrayHelper::getValue(self::$stateType, $this->state);
    }
}
