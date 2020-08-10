<?php

use yii\helpers\Url;
use snor\web\models\UrlSeo;

/* @var $this yii\web\View */
/* @var $model snor\web\models\Product */

$this->title = "{$model->title} – 施诺官网";
?>
<div class="wrap product_view">
    <div class="snor_w">
        <div class="snor_path"><a href="<?=Url::to(['/product/index'])?>">产品中心</a>&gt;<a href="<?=Url::to(['/product/index', 'code' => $model->code])?>"><?=$model->cateName;?></a>&gt;<span><?=$model->title;?></span></div>
    </div>
    <div class="product_view_ct">
        <div class="snor_w">
            <?= Yii::$app->formatter->asHtml($model->content);?>
        </div>
    </div>
    <a href="<?=Url::to(['/contact/index'])?>" class="contact_us">联系我们</a>
</div>
