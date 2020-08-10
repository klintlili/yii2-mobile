<?php

namespace snor\web\mobile\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form of `snor\web\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var int
     */
    public $pageSize = 8;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pageSize'], 'integer'],
            [['code'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params, '');
        $query = Product::find();
        $query->joinWith(['cate cate'], false);
        $query->where(['product.is_show' => self::STATE_SHOW]);
        $query->andWhere(['cate.is_show' => ProductCate::STATE_SHOW]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
                'defaultPageSize' => $this->pageSize,
                'forcePageParam' => false,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'cate_id' => $this->cate_id,
            'cate.code' => $this->code,
        ]);

        return $dataProvider;
    }
}
