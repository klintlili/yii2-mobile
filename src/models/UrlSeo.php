<?php

namespace klintlili\mobile\models;

use Yii;
use snor\web\helpers\Html;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%url_seo}}".
 *
 * @property int $id id
 * @property string $url 链接
 * @property string $description description
 * @property int $created_at 创建时间
 * @property null|string $aUrl
 */
class UrlSeo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%url_seo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'description'], 'required'],
            [['description'], 'string'],
            [['created_at'], 'integer'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => '链接',
            'description' => '标题',
            'created_at' => '创建时间',
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

    //获取当前路由，判断是否有动态的url的title
    public static function urlTitle(){
        /** @var UrlSeo $model */
        $model = UrlSeo::find()->where(['url'=>Yii::$app->request->url])->limit(1)->one();
        if(!empty($model)){
            return $model->description;
        }

        return "";
    }


    /**
     * @return null|string
     */
    public function getAUrl()
    {
        if ($this->url) {
            return Html::a(Yii::$app->request->getHostInfo() . $this->url,
                Yii::$app->request->getHostInfo() . $this->url);
        }

        return null;
    }
}
