<?php

use yii\helpers\Url;

/* @var $model snor\web\models\HomeIndex */

$this->title = "关于我们 – 施诺官网";
$this->registerMetaTag(["name"=> "description", "content" => "施诺,为用户提供热水、采暖、空调、新风、除湿等家庭和公装解决方案,10W用户的大数据积累,为您提供亲近自然的舒适!"]);
?>
<div class="wrap">
    <?= $this->render('/site/index/_slider', ['models' => $model->aboutSlide]) ?>
    <div class="snor_w about_box">
        <div><img src="<?=Url::to('@web/img/about/about1.jpg');?>" /></div>
        <div><img src="<?=Url::to('@web/img/about/about2.jpg');?>" /></div>
        <div><img src="<?=Url::to('@web/img/about/about3.jpg');?>" /></div>
        <div style="margin-top:61px"><img src="<?=Url::to('@web/img/about/about_intrdus.jpg');?>" /></div>
        <div style="margin-top:59px"><img src="<?=Url::to('@web/img/about/about4.jpg');?>" /></div>
        <div><img src="<?=Url::to('@web/img/about/about5.jpg');?>" /></div>
    </div>
</div>
