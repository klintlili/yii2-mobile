<?php

namespace klintlili\mobile\models\console\sitemap;

use Yii;
use shushi100\yii\sitemap\SitemapEntityInterface;
use snor\web\commands\base\FakerQuery;
use klintlili\mobile\models\CaseCate as BaseCaseCate;
use yii\base\InvalidConfigException;

/**
 * Class CaseCate
 */
class CaseCate extends BaseCaseCate implements SitemapEntityInterface
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
        $url = ['project/index'];
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
            ->leftJoin('`case`', '`case`.cate_id = case_cate.id')
            ->select(['ANY_VALUE(`case_cate`.`code`) AS `code`', 'ceil(count(`case`.id)/8) as page'])
            ->where(['case_cate.is_show' => self::STATE_SHOW])
            ->groupBy('`case_cate`.`code`')
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
            ->leftJoin('`case`', '`case`.cate_id = case_cate.id')
            ->select(['ceil(count(`case`.id)/8) as page'])
            ->where(['case_cate.is_show' => self::STATE_SHOW])
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
