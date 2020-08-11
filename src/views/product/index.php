<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use snor\web\models\News;
use snor\web\models\Product;

/* @var $this yii\web\View */
/* @var $searchModel snor\web\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = "产品中心";
$this->registerMetaTag(["name" => "description", "content" => "施诺,为用户提供热水、采暖、空调、新风、除湿等家庭和公装解决方案,10W用户的大数据积累,为您提供亲近自然的舒适!"]);
$code = Yii::$app->request->get('code');
if(!empty($code)) {
    $codeName = (new Product())->getCateNameByCode($code);
    if (!empty($codeName)) {
        $title = "{$codeName}";
    }
}
?>
<div class="wrap product_list_box">
    <div class="snor_w">
        <?php if ($dataProvider->totalCount > 0) { ?>
            <dl class="product_list clearfix">
                <?php /** @var $list \snor\web\models\Product */  ?>
                <?php foreach ($dataProvider->models as $list) { ?>
                    <dd>
                        <a href="<?=Url::to(['/mobile/product/view', 'id' => $list->id])?>" class="block_a">
                            <div class="pl_title"><?=$list->title;?></div>
                            <div class="pl_desc"><?=Yii::$app->formatter->asText($list->desc)?></div>
                            <span class="viewto">查看详情</span>
                            <div class="product_img_box">
                                <img src="<?=$list->picUrl;?>" alt="<?=$list->title;?>" />
                            </div>
                        </a>
                    </dd>
                <?php } ?>

            </dl>
            <div class="fenye_box" style="padding-top:32px;">
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
            <p style="text-align: center;margin-top: 50px;">暂无产品！</p>
        <?php } ?>

        <?php $news = new News(); ?>
        <?php $bottom_slider = $news->getTopNewArticles(3); ?>
        <?php if(!empty($bottom_slider)){ ?>
            <div class="zixun_box border-box">
                <div class="zixun_title">相关资讯</div>
                <?= $this->render('/layouts/_bottom_slider', ['bottom_slider' => $bottom_slider]) ?>
            </div>
        <?php } ?>
        <?php unset($news,$bottom_slider); ?>

    </div>
</div>

