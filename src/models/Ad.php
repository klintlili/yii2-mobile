<?php

namespace klintlili\mobile\models;

use Yii;
use shushi100\yii\behaviors\UploadBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%ad}}".
 *
 * @property int $id 广告 ID
 * @property int $cate_id 广告位
 * @property string $title 标题
 * @property string $url 链接
 * @property string $pic 图片
 * @property int $position 优先级
 * @property mixed $cateName
 * @property string $picUrl
 * @property boolean $hasPic
 * @method getUploadedUrl($attribute)
 */
class Ad extends \yii\db\ActiveRecord
{
    /**
     * @var array
     */
    static public $cate = [
        1 => '官网顶部幻灯片广告',
        2 => '服务案例列表-顶部幻灯片广告',
        3 => '新闻中心-顶部幻灯片广告',
        4 => '关于我们-顶部幻灯片广告',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ad}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cate_id', 'title', 'url'], 'required'],
            [['cate_id', 'position'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
            [['pic'], 'image', 'mimeTypes' => 'image/*'],
            ['position', 'default', 'value' => 0],
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_id' => '广告位',
            'title' => '标题',
            'url' => '链接',
            'pic' => '图片',
            'picUrl' => '图片',
            'position' => '优先级',
        ];
    }

    /**
     * @return mixed
     */
    public function getCateName()
    {
        return ArrayHelper::getValue(self::$cate, $this->cate_id);
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
     * @param $cate_id
     * @param bool $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findByCateId($cate_id, $limit = false)
    {
        $query = static::find()->where(['cate_id' => $cate_id])->orderBy('position');
        if ($limit !== false) {
            $query->limit($limit);
        }

        return $query->all();
    }
}
