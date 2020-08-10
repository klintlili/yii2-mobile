<?php

namespace snor\web\mobile\models\console\sitemap;

use Yii;
use shushi100\yii\sitemap\SitemapEntityInterface;
use snor\web\commands\base\FakerQuery;
use snor\web\mobile\models\ProductCate as BaseProductCate;
use yii\base\InvalidConfigException;

/**
 * Class ProductCate
 */
class ProductCate extends BaseProductCate implements SitemapEntityInterface
{
    /**
     * @var integer
     */
    public $page;

    /**
     * Get lastmod value for sitemap file.
     *
     * @return string
     */
    public function getSitemapLastmod()
    {
        return date('c');
    }

    /**
     * Get changefreq value for sitemap file.
     *
     * @return string
     */
    public function getSitemapChangefreq()
    {
        return 'monthly';   // 'hourly', 'weekly', 'monthly', 'yearly', 'never'
    }

    /**
     * Get priority value for sitemap file.
     *
     * @return string
     */
    public function getSitemapPriority()
    {
        return 0.5;
    }

    /**
     * Get loc value for sitemap file.
     *
     * @return string
     */
    public function getSitemapLoc()
    {
        $url = ['product/index'];
        if(!empty($this->code)){
            $url['code'] = $this->code;
        }
        
        if (!empty($this->page) && $this->page > 1) {
            $url['page'] = $this->page;
        }

        return Yii::$app->urlManagerMobile->createAbsoluteUrl($url);
    }

    /**
     * Get data source for sitemap file generation.
     *
     * @throws InvalidConfigException
     */
    public static function getSitemapDataSource()
    {
        return Yii::createObject([
            'class' => FakerQuery::class,
            'modelClass' => static::class,
        ]);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     * @throws InvalidConfigException
     */
    public static function fakerData($offset, $limit)
    {
        /** @var static[] $models */
        //具体分类
        $models = self::find()
            ->leftJoin('product', 'product.cate_id = product_cate.id')
            ->select(['ANY_VALUE(`product_cate`.code) AS code', 'ceil(count(product.id)/8) as page'])
            ->where(['product_cate.is_show' => self::STATE_SHOW])
            ->groupBy('`product_cate`.code')
            ->offset($offset)
            ->limit($limit)
            ->all();
        $values = [];
        foreach ($models as $model) {
            if ($model->page == 0) {
                $values[] = Yii::createObject([
                    'class' => static::class,
                    'code' => $model->code,
                    'page' => 1,
                ]);
            }else {
                for ($page = 0; $page < $model->page; $page++) {
                    $values[] = Yii::createObject([
                        'class' => static::class,
                        'code' => $model->code,
                        'page' => $page + 1,
                    ]);
                }
            }
        }
        unset($models);


        //全部分类
        $models = self::find()
            ->leftJoin('product', 'product.cate_id = product_cate.id')
            ->select(['ceil(count(product.id)/8) as page'])
            ->where(['product_cate.is_show' => self::STATE_SHOW])
            ->offset($offset)
            ->limit($limit)
            ->all();
        foreach ($models as $model) {
            if ($model->page == 0) {
                $values[] = Yii::createObject([
                    'class' => static::class,
                    'code' => '',
                    'page' => 1,
                ]);
            }else {
                for ($page = 0; $page < $model->page; $page++) {
                    $values[] = Yii::createObject([
                        'class' => static::class,
                        'code' => '',
                        'page' => $page + 1,
                    ]);
                }
            }
        }
        unset($models);

        return $values;
    }
}
