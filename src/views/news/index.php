<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;
use snor\web\models\News;

/* @var $this yii\web\View */
/* @var $model snor\web\models\HomeIndex */
/* @var $searchModel snor\web\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = "新闻中心";
$this->registerMetaTag(["name" => "description", "content" => "施诺,为用户提供热水、采暖、空调、新风、除湿等家庭和公装解决方案,10W用户的大数据积累,为您提供亲近自然的舒适!"]);
$code = Yii::$app->request->get('code');
if(!empty($code)) {
    $codeName = (new News())->getCateNameByCode($code);
    if (!empty($codeName)) {
        $title = "{$codeName}";
    }
}
?>
<div class="wrap">
    <?= $this->render('/site/index/_slider', ['models' => $model->newsSlide]) ?>
    <?php if(!empty($cate_lists)){ ?>
        <div class="news_index_head">
            <div class="snor_w">
                <ul class="clearfix flex">
                    <li<?=empty($code)?" class='current'":"";?>>
                        <a href="<?=Url::to(['/mobile/news/index']);?>">全部</a>
                    </li>
                    <?php /* @var $cate_list snor\web\models\NewsCate */ ?>
                    <?php foreach ($cate_lists as $key => $cate_list){ ?>
                        <li<?=!empty($code)&&$code==$cate_list->code?' class="current"':''?>>
                            <a href="<?=Url::to(['/mobile/news/index', 'code' => $cate_list->code]);?>"><?=$cate_list->name;?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="news_index_ct">
            <div class="snor_w">
                <?php if ($dataProvider->totalCount > 0) { ?>
                    <dl>
                        <?php /** @var $list \snor\web\models\News */  ?>
                        <?php foreach ($dataProvider->models as $list) { ?>
                            <dd class="clearfix">
                                <a href="<?=Url::to(['/mobile/news/view', 'id' => $list->id])?>" class="block_a">
                                    <div class="fl news_time border-box">
                                        <div class="news_date"><?=date('d', $list->created_at)?></div>
                                        <div class="news_year_month"><?=date('Y-m', $list->created_at)?></div>
                                    </div>
                                    <div class="fl news_item_img"><img src="<?=$list->picUrl;?>" alt="<?=$list->title;?>"/></div>
                                    <div class="fr news_item_ct">
                                        <div class="news_item_tittle ellipse1"><?=$list->title;?></div>
                                        <div class="news_item_txt ellipse3">
                                            <?=$list->intro;?>
                                        </div>
                                        <div class="news_viewto_box">更多 &gt;</div>
                                    </div>
                                </a>
                            </dd>
                        <?php } ?>
                    </dl>
                    <div class="fenye_box" style="padding-top:31px;">
                        <?= LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                            'options' => ['id'=>"pager-container", 'class'=>"page-navi page-navi-item"],
                            'firstPageLabel' => "首页",
                            'firstPageCssClass' => "myfirst",
                            'prevPageLabel' => "<",
                            'prevPageCssClass' => "mypre",
                            'nextPageLabel' => ">",
                            'nextPageCssClass' => "mynext",
                            'lastPageLabel' => "末页",
                            'lastPageCssClass' => "mylast",
                            'disableCurrentPageButton' => true
                        ]);
                        if($dataProvider->pagination->page>0){
                            $page = ($dataProvider->pagination->page+1);
                            $this->title = $title. " – 第{$page}页 – 施诺官网";
                            unset($page);
                        }else{
                            $this->title = $title. ' – 施诺官网';
                        }
                        ?>
                    </div>
                <?php } else { ?>
                    <p style="text-align: center;margin-top: 50px;margin-bottom: 50px;">暂无新闻信息！</p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
