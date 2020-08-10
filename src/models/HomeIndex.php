<?php

namespace klintlili\mobile\models;

use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class HomeIndex
 * @property Ad[] $slide
 * @property Ad[] $projectSlide
 * @property Ad[] $newsSlide
 * @property Ad[] $aboutSlide
 */
class HomeIndex extends Model
{
    /**
     * @var int 官网顶部幻灯片广告 ID
     */
    public $slide_id = 1;
    /**
     * @var Ad[] 官网顶部幻灯片广告
     */
    private $_slide;

    /**
     * @var int 服务案例列表-顶部幻灯片广告 ID
     */
    public $project_slide_id = 2;
    /**
     * @var Ad[] 服务案例列表-顶部幻灯片广告
     */
    private $_project_slide;

    /**
     * @var int 新闻中心-顶部幻灯片广告 ID
     */
    public $news_slide_id = 3;
    /**
     * @var Ad[] 新闻中心-顶部幻灯片广告
     */
    private $_news_slide;

    /**
     * @var int 关于我们-顶部幻灯片广告 ID
     */
    public $about_slide_id = 4;
    /**
     * @var Ad[] 关于我们-顶部幻灯片广告
     */
    private $_about_slide;

    /**
     * @return Ad[]
     */
    public function getSlide()
    {
        if ($this->_slide == null) {
            $this->_slide = Ad::findByCateId($this->slide_id, false);
        }
        return $this->_slide;
    }

    /**
     * @param int $link_cate_id
     * @return array|ActiveRecord[]
     */
    public static function getLinks($link_cate_id = 0)
    {
        $query = Links::find()->select(['name', 'url'])->where([
            'link_cate_id' => $link_cate_id,
            'state' => Links::STATE_SHOW
        ]);
        return $query->orderBy('position')->all();
    }

    /**
     * 首页-服务案例
     * @return mixed
     */
    public static function getIndexProjectData()
    {
        return Project::getSiteData();
    }

    /**
     * 首页-新闻中心
     * @return array
     */
    public static function getIndexNewsData()
    {
        $newsListsLeft = News::getHomeLeftData();
        $newsListsRightCate = NewsCate::getCateList(3);
        $newsListsRightData = News::getHomeRightData($newsListsRightCate);
        return [$newsListsLeft, $newsListsRightCate, $newsListsRightData];
    }

    /**
     * @return array|Ad[]|ActiveRecord[]
     */
    public function getProjectSlide()
    {
        if ($this->_project_slide == null) {
            $this->_project_slide = Ad::findByCateId($this->project_slide_id, false);
        }
        return $this->_project_slide;
    }

    /**
     * @return array|Ad[]|ActiveRecord[]
     */
    public function getNewsSlide()
    {
        if ($this->_news_slide == null) {
            $this->_news_slide = Ad::findByCateId($this->news_slide_id, false);
        }
        return $this->_news_slide;
    }

    /**
     * @return array|Ad[]|ActiveRecord[]
     */
    public function getAboutSlide()
    {
        if ($this->_about_slide == null) {
            $this->_about_slide = Ad::findByCateId($this->about_slide_id, false);
        }
        return $this->_about_slide;
    }
}