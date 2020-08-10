<?php

namespace klintlili\mobile\models\console\sitemap;

use Yii;
use shushi100\yii\sitemap\SitemapEntityInterface;
use klintlili\mobile\models\Product as BaseProduct;
use yii\db\ActiveQuery;

/**
 * Class Product
 */
class Product extends BaseProduct implements SitemapEntityInterface
{
    /**
     * Get lastmod value for sitemap file.
     *
     * @return string
     */
    public function getSitemapLastmod()
    {
        return date('c', $this->updated_at);
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
        return Yii::$app->urlManagerMobile->createAbsoluteUrl(['product/view', 'id' => $this->id]);
    }

    /**
     * Get data source for sitemap file generation.
     *
     * @return ActiveQuery $dataSource
     */
    public static function getSitemapDataSource()
    {
        return self::find()->where(['is_show' => self::STATE_SHOW])->select([
            'id',
            'updated_at'
        ])->orderBy(['created_at' => SORT_ASC]);
    }
}
