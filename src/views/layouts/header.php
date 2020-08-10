<?php /** @noinspection PhpUnhandledExceptionInspection */

use yii\helpers\Url;
use snor\web\helpers\Html;
use snor\web\mobile\models\CaseCate;
use snor\web\mobile\models\ProductCate;
//var_dump(Url::to(['product/index', 'code' => 'diyuan']));die;
?>
<header class="snor_wrap header">
    <div class="snor_w clearfix">
        <div class="logo fl border-box">
            <a href="/">
                <img src="<?=Url::to('@web/img/snor_logo.png');?>" alt="snor" />
            </a>
        </div>
        <dl class="head_menu fr">
            <dd><a<?=Html::isItemActive(['url' => ['site/index']])?' class="border-box submenu active"':' class="border-box submenu"';?> href="<?=Url::to(['/site/index']);?>">首页</a></dd>
            <dd>
                <?php $product_cate_items = ProductCate::getNav()[0];?>
                <?php $product_cate_parent_active = ProductCate::getNav()[1];?>
                <a<?=$product_cate_parent_active||Html::isItemActive(['url' => ['product/index']])?' class="border-box submenu active"':' class="border-box submenu"';?> href="<?=Url::to(['/product/index']);?>">产品中心</a>
                <?php if(!empty($product_cate_items)){ ?>
                    <ul class="border-box">
                        <?php foreach ($product_cate_items as $product_cate_item){ ?>
                            <li><a<?=$product_cate_item['active']?' class="active"':'';?> href="dd<?=Url::to($product_cate_item['url']);?>"><?=$product_cate_item['label'];?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php unset($product_cate_items);?>
                <?php unset($product_cate_parent_active);?>
            </dd>
            <dd>
                <?php $case_cate_items = CaseCate::getNav()[0];?>
                <?php $case_cate_parent_active = CaseCate::getNav()[1];?>
                <a<?=$case_cate_parent_active||Html::isItemActive(['url' => ['project/index']])?' class="border-box submenu active"':' class="border-box submenu"';?> href="<?=Url::to(['/project/index']);?>">服务案例</a>
                <?php if(!empty($case_cate_items)){ ?>
                    <ul class="border-box">
                        <?php foreach ($case_cate_items as $case_cate_item){ ?>
                            <li><a<?=$case_cate_item['active']?' class="active"':'';?> href="<?=Url::to($case_cate_item['data-url']);?>"><?=$case_cate_item['label'];?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php unset($case_cate_items);?>
                <?php unset($case_cate_parent_active);?>
            </dd>
            <dd><a<?=Html::isItemActive(['url' => ['news/index']])?' class="border-box submenu active"':' class="border-box submenu"';?> href="<?=Url::to(['/news/index']);?>">新闻中心</a></dd>
            <dd><a<?=Html::isItemActive(['url' => ['about/index']])?' class="border-box submenu active"':' class="border-box submenu"';?> href="<?=Url::to(['/about/index']);?>">关于我们</a></dd>
            <dd><a<?=Html::isItemActive(['url' => ['contact/index']])?' class="border-box submenu active"':' class="border-box submenu"';?> href="<?=Url::to(['/contact/index']);?>">联系我们</a></dd>
        </dl>
    </div>
</header>
