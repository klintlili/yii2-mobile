<?php

namespace snor\web\mobile\models;

use shushi100\yii\behaviors\PinyinSlugBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%district}}".
 *
 * @property int $id ID
 * @property string $subname 名称(市)
 * @property int $parent_id 上级地区 ID
 * @property string $code 拼音
 * @property string $name 名称
 * @property int $is_city 是否城市
 * @property District $parent
 * @property string[] $parentName
 * @property string $fullName
 * @property District[] $children
 */
class District extends ActiveRecord
{
    const NAME = '直辖市/特别行政区';
    static protected $_parents;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%district}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'subname', 'code'], 'trim'],
            [['name', 'subname'], 'required'],
            [['code'], 'required',
                'whenClient' => 'function(attribute,value){return ' . ($this->isNewRecord ? 'false' : 'true') . '}'],
            [['parent_id'], 'integer'],
            [['name', 'subname', 'code'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['code'], 'match', 'pattern' => '/^[\w\-\._]+$/'],
            ['parent_id', 'exist', 'targetClass' => static::class, 'targetAttribute' => 'id',
                'skipOnEmpty' => true, 'isEmpty' => function ($value) {
                return empty($value);
            }],
            ['is_city', 'default', 'value' => true],
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
            'subname' => '名称(市)',
            'parent_id' => '省/自治区',
            'parentName' => '省/自治区',
            'code' => '拼音',
            'name' => '名称',
            'is_city' => '是否城市',
        ];
    }

    /**
     * @return mixed
     */
    public static function getParentOptions()
    {
        if (empty(static::$_parents)) {
            static::$_parents = ArrayHelper::merge([
                0 => static::NAME
            ], ArrayHelper::map(static::find()->where(['is_city' => false])->all(), 'id', 'name'));
        }
        return static::$_parents;
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @return string
     */
    public function getParentName()
    {
        return (empty($this->parent) ? static::NAME : $this->parent->name);
    }
    
    /**
     * @return string
     */
    public function getFullName()
    {
        return (empty($this->parent) ? '' : $this->parent->name) . $this->name;
    }

    /**
     * @return ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->fullName;
    }

    /**
     * {@inheritDoc}
     */
    public function fields()
    {
        return ['id', 'text'];
    }

    /**
     * @param bool $json
     * @return mixed
     */
    public static function getDistrictJson($json = true)
    {
        $data = [];
        $province = District::find()->where(['parent_id' => 0])->with('children')->all();
        $n = 0;
        foreach ($province as $key => $val) {
            /** @var static $val */
            $data[$n] = [
                'id' => $val->id,
                'name' => $val->name,
            ];
            if ($val->is_city == 1 && $val->parent_id == 0) {
                $city = [
                    'id' => $val->id,
                    'name' => $val->name,
                ];
                $data[$n]['child'][] = $city;
            } else {
                foreach ($val->children as $k => $v) {
                    $city = [
                        'id' => $v->id,
                        'name' => $v->name,
                    ];
                    $data[$n]['child'][] = $city;
                }
            }
            $n++;
        }
        if ($json) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
