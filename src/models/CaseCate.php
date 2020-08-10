<?php

namespace snor\web\mobile\models;

use shushi100\yii\behaviors\PinyinSlugBehavior;
use shushi100\yii\behaviors\UploadBehavior;
use snor\web\helpers\Html;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%case_cate}}".
 *
 * @property int $id 分类 ID
 * @property string $name 名称
 * @property string $code 拼音
 * @property int $is_show 是否显示
 * @property string $white_icon 白色图标
 * @property string $gray_icon 灰色图标
 * @property string $violet_icon 紫色图标
 * @property int $position 排序
 * @property string $whiteIconUrl
 * @property string $grayIconUrl
 * @property string $violetIconUrl
 * @property boolean $hasWhiteIcon
 * @property boolean $hasGrayIcon
 * @property boolean $hasVioletIcon
 * @method getUploadedUrl($attribute)
 * @property mixed $showName
 */
class CaseCate extends ActiveRecord
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
        return '{{%case_cate}}';
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
            [['white_icon', 'gray_icon', 'violet_icon'], 'image', 'maxSize' => 2097152, 'extensions' => ['png', 'jpg', 'jpeg']],
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
                'class' => UploadBehavior::class,
                'attributes' => ['white_icon', 'gray_icon', 'violet_icon'],
                'gd' => false,
            ],
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
            'white_icon' => '白色图标',
            'gray_icon' => '灰色图标',
            'violet_icon' => '紫色图标',
            'whiteIconUrl' => '白色图标',
            'grayIconUrl' => '灰色图标',
            'violetIconUrl' => '紫色图标',
            'position' => '排序',
        ];
    }

    /**
     * @return boolean
     */
    public function getHasWhiteIcon()
    {
        return is_string($this->white_icon) && !empty($this->white_icon);
    }

    /**
     * @return string
     */
    public function getWhiteIconUrl()
    {
        if (strncmp($this->white_icon, '//', 2) == 0) {
            return $this->white_icon;
        }
        return $this->getUploadedUrl('white_icon');
    }

    /**
     * @return boolean
     */
    public function getHasGrayIcon()
    {
        return is_string($this->gray_icon) && !empty($this->gray_icon);
    }

    /**
     * @return string
     */
    public function getGrayIconUrl()
    {
        if (strncmp($this->gray_icon, '//', 2) == 0) {
            return $this->gray_icon;
        }
        return $this->getUploadedUrl('gray_icon');
    }

    /**
     * @return boolean
     */
    public function getHasVioletIcon()
    {
        return is_string($this->violet_icon) && !empty($this->violet_icon);
    }

    /**
     * @return string
     */
    public function getVioletIconUrl()
    {
        if (strncmp($this->violet_icon, '//', 2) == 0) {
            return $this->violet_icon;
        }
        return $this->getUploadedUrl('violet_icon');
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
        if($filter) return ArrayHelper::map(self::find()->where(['is_show' => self::STATE_SHOW])->orderBy('position')->asArray()->all(), 'id', 'name');
        return ArrayHelper::map(self::find()->orderBy('position')->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getCateList()
    {
        return self::find()->where(['is_show' => self::STATE_SHOW])->orderBy('position')->all();
    }

    //得到前台导航结构
    /**
     * @return array|ActiveRecord[]
     */
    public static function getNav()
    {
        $model = self::find()->where(['is_show' => self::STATE_SHOW])->orderBy('position')->all();
        $data = [];
        $parentActive = false;
        /** @var self $cate */
        foreach ($model as $key => $cate){
            $data[$key]['label'] = $cate->name;
            $data[$key]['url'] = ['project/index', 'code' => $cate->code];
            $data[$key]['data-url'] = ['/project/index', 'code' => $cate->code];
            $active = Html::isItemActive($data[$key]);
            $data[$key]['active'] = $active;
            if(!$parentActive && $active){
                $parentActive = true;
            }
        }

        return [$data, $parentActive];
    }
}
