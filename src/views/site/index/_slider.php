<?php

use yii\helpers\Url;
?>
<style>
    /*slide_banner*/
    body{width:100%;}
     #slide_banner, #slide_banner .slide_stage{position:relative;width:100%;height:430px;overflow:hidden;}
    #slide_banner{background:url(<?=Url::to('@web/img/loading.gif');?>) #f5f5f5 no-repeat center center;}
    .slide_stage ul{height:430px;}
    .slide_stage li{float:left;outline:none;}
    .slide_stage li a{display:block;width:100%;height:430px;}
    .index #slide_banner, .index #slide_banner .slide_stage,.index .slide_stage ul,.index .slide_stage li a{height:610px;}
    .slide_stage .slide_handdler{margin-top:-30px;}
    .slide_handdler{position:absolute;width:100%;height:12px;margin-top:-24px;text-align:center;}
    .slide_handdler a{display:inline-block;width:12px;height:12px;margin:0 5px;background:#b5b5b5;overflow:hidden;border-radius:14px;}
    .slide_handdler a.current{background:#005EA6;color:#fff !important;}
</style>
<div id="slide_banner">
    <div class="slide_stage">
        <ul id="JS_side_stage">
            <?php $total = count($models); ?>
            <?php foreach ($models as $model) : ?>
                <li>
                    <a href="<?= $model->url ?>" target="_blank" title="<?= Yii::$app->formatter->asText($model->title) ?>"  style="background: url(<?= $model->picUrl ?>) center center no-repeat;" ></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="slide_handdler">
            <div class="w_new" id="JS_side_nav">
                <?php for ($n = 0; $n < $total; $n++) : ?>
                    <a class="<?= $n == 0 ? 'current' : '' ?>" href="javascript:;"></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
<?php unset($total,$models);?>
<?php $this->registerJs('
    function JS_Nav_Img(js_nav,js_img,js_width,scroll){var pro_img=$("#"+js_img),pro_img_li=$("#"+js_img+" li"),pro_img_a=$("#"+js_nav+" a");if(pro_img_a.length==1){pro_img_a.hide();return}var pro_nav_current=0,pro_nav_index=1;pro_img.css("width",js_width*pro_img_li.length+"px");pro_img_a.each(function(index){this._key=index;this.onmouseover=function(){pro_nav_index=this._key;pro_auto ? clearInterval(pro_auto):pro_auto;pro_autoRun()};if(scroll!==false){this.onmouseout=function(){pro_auto=setInterval(function(){pro_autoRun()},5000)}}});var pro_autoRun=function(){pro_img_a.eq(pro_nav_current).removeClass("current");pro_img_a.eq(pro_nav_index).addClass("current");pro_img.animate({marginLeft:(0-pro_nav_index)*js_width+"px"},500);pro_nav_current=pro_nav_index;pro_nav_index=(pro_nav_index>=pro_img_a.length-1)?0:pro_nav_index+1};if(scroll!==false){var pro_auto=setInterval(function(){pro_autoRun()},5000)}};
    //宽屏轮换图
    var side_stage = $("#JS_side_stage"), side_stage_li = $("#JS_side_stage li"), side_stage_a = $("#JS_side_nav a"), side_width = document.body.clientWidth; var nav_current = 0, nav_index = 1; side_stage_li.css("width", side_width + "px"); $(window).on("resize load",function () { side_width = document.body.clientWidth; side_stage.css("width", side_width * side_stage_li.length + "px"); side_stage_li.css("width", side_width + "px"); nav_index = 0; autoRun() }); side_stage_a.each(function (index) { this._key = index; this.onmouseover = function () { nav_index = this._key; clearInterval(auto); autoRun() }; this.onmouseout = function () { auto = setInterval(function () { autoRun() }, 5000) } }); var autoRun = function () { side_stage_a.eq(nav_current).removeClass("current"); side_stage_a.eq(nav_index).addClass("current"); side_stage.animate({ marginLeft: (0 - nav_index) * side_width + "px" }, 500); nav_current = nav_index; nav_index = (nav_index >= side_stage_a.length - 1) ? 0 : nav_index + 1 }; var auto = setInterval(function () { autoRun() }, 5000);
', yii\web\View::POS_END); ?>
