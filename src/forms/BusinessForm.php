<?php

namespace klintlili\mobile\forms;

use shushi100\yii\validators\MobileValidator;
use klintlili\mobile\models\Business;
use klintlili\mobile\models\District;
use yii\base\Model;

/**
 * 留言集客
 */
class BusinessForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $mobile;

    /**
     * @var string
     */
    public $district_id;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $desc;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['mobile', 'name'], 'required'],
            [['district_id'], 'integer'],
            [['desc'], 'string'],
            [['mobile', 'name', 'url'], 'string', 'max' => 255],
            ['mobile', MobileValidator::class],
            [['district_id'], 'exist',
                'targetClass' => District::class,
                'targetAttribute' => 'id',
                'filter' => ['is_city' => 1],
            ],
            ['mobile', 'validateMobile'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => '您的姓名',
            'mobile' => '您的手机号码',
            'district_id' => '城市',
            'desc' => '需求'
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateMobile($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $model = Business::find()->where(["mobile" => $this->$attribute, "FROM_UNIXTIME(created_at,'%Y%m%d')" => date('Ymd')])->limit(1)->one();
            if ($model) {
                $this->addError($attribute, '您今天已经提交需求，请勿重复提交需求哦。');
            }
        }
    }

    /**
     * @return bool
     */
    public function add()
    {
        if ($this->validate()) {
            $model = new Business();
            $model->attributes = $this->attributes;
           if($model->save()) {
               return true;
           }
        }

        return false;
    }
}