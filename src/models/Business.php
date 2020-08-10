<?php

namespace klintlili\mobile\models;

use shushi100\yii\behaviors\IpBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%business}}".
 *
 * @property int $id ID
 * @property string $mobile 手机号码
 * @property string $name 姓名
 * @property int $district_id 城市
 * @property string $ip ip地址
 * @property string $desc 描述
 * @property string $url 来源链接
 * @property int $created_at 提交时间
 * @property District $district
 * @property string $districtFullName
 */
class Business extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%business}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile', 'name'], 'required'],
            [['district_id', 'created_at'], 'integer'],
            [['desc'], 'string'],
            [['mobile', 'name', 'ip', 'url'], 'string', 'max' => 255],
            //防止重复提交
            [['mobile'], 'unique', 'targetAttribute' => ['created_at', 'mobile'], 'message' => '请勿重复提交数据'],
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
            [
                'class' => IpBehavior::class,
                'createdFromAttribute' => 'ip',
                'updatedFromAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => '手机号码',
            'name' => '姓名',
            'district_id' => '城市',
            'ip' => 'IP 地址',
            'desc' => '描述',
            'url' => '来源链接',
            'created_at' => '提交时间',
            'districtFullName' => '城市',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::class, ['id' => 'district_id']);
    }

    /**
     * @return string
     */
    public function getDistrictFullName()
    {
        return ArrayHelper::getValue($this->district, 'fullName', "");
    }
}
