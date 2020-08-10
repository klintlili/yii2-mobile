<?php

namespace klintlili\mobile\models\console\sitemap;

use Yii;
use shushi100\yii\sitemap\SitemapEntityInterface;
use snor\web\commands\base\FakerQuery;
use yii\base\InvalidConfigException;
use yii\base\Model;

class StaticPage extends Model implements SitemapEntityInterface
{
    public $url;
    public $priority;

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
        return 'hourly';
    }

    /**
     * Get priority value for sitemap file.
     *
     * @return string
     */
    public function getSitemapPriority()
    {
        return $this->priority;
    }

    /**
     * Get loc value for sitemap file.
     *
     * @return string
     */
    public function getSitemapLoc()
    {
        return Yii::$app->urlManagerMobile->createAbsoluteUrl($this->url);
    }

    /**
     * {@inheritdoc}
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
        if (empty($offset)) {
            /** @noinspection PhpIncludeInspection */
            return static::fakerValues(require(Yii::getAlias('@snor/web/commands/data/static_pages.php')));
        }
        return [];
    }

    /**
     * @param $values
     * @return array
     * @throws InvalidConfigException
     */
    protected static function fakerValues($values)
    {
        $models = [];
        foreach ($values as $value) {
            list($url, $priority) = $value;
            $models[] = Yii::createObject([
                'class' => static::class,
                'url' => $url,
                'priority' => $priority,
            ]);
        }
        return $models;
    }
}
