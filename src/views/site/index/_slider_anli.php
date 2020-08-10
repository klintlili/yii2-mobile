<?php

use yii\helpers\Url;
use snor\web\helpers\Html;

/* @var $newsLists array */

$this->registerJsFile("@web/js/TouchSlide.1.1.js",["depends" => ["snor\\web\\assets\\AppAsset"]]);
?>
<style>
    .focus{ width:560px; height:540px;  margin:0 auto; position:relative; overflow:hidden; color:#757778}
    .focus .hd{ width:470px; height:34px;  position:absolute; z-index:5; left:28px; bottom:10px; text-align:right;  }
    .focus .hd ul{ display:block; width:100%; height:10px; padding:12px 0px; font-size:0; vertical-align:top;
    }
    .focus .hd ul li{ display:inline-block; width:10px; height:10px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; background:#8C8C8C; margin:0 5px;  vertical-align:top; overflow:hidden; cursor: pointer;   }
    .focus .hd ul .on{ background:#FE6C9C;  }

    .focus .bd{ position:relative; z-index:0; }
    .focus .bd li{ position:relative; width:100%; height:540px;}
    .focus .bd li a{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */left:0; top:0; position:absolute; display:block; width:100%; height:485px;}
    .focus .bd li img{ width:100%;  height:400px; background:url(<?=Url::to('@web/img/loading.gif');?>) center center no-repeat;  }
    .slide_desc{width:502px; height:179px; box-sizing: border-box; border:1px solid #f3f3f3; background:#fff; position:absolute; left:28px; bottom:0px; padding:20px 35px; justify-content: space-between;}
    .slide_time{width:65px; text-align: center; color:#ef1c90;}
    .time_date{height:42px; line-height:42px; font-size: 50px;}
    .time_year_month{width:100%; border-top:1px solid #ef1c90; border-bottom:1px solid #ef1c90; height:32px; line-height: 32px; margin-top:10px; font-size:16px;}
    .slide_txt{width:340px;}
    .slide_title{ font-size:20px; color:#2d2c2d; margin-bottom:5px; height:25px; line-height: 25px;}
    .slide_txt_ct{color:#757778; text-indent: 29px; line-height: 24px; height:72px; overflow:hidden;}
</style>
<div id="focus" class="focus">
    <div class="hd">
        <ul></ul>
    </div>
    <div class="bd">
        <ul>
            <?php foreach ($newsLists as $newsList){ ?>
            <li>
                <a href="<?=Url::to(['/news/view', 'id' => $newsList['id']])?>">
                    <img src="<?=Url::to(Html::getPicUrlByPath($newsList['pic']));?>" alt="<?=$newsList['title']?>"/>
                    <div class="slide_desc flex">
                        <div class="slide_time">
                            <div class="time_date"><?=date('d', $newsList['created_at']);?></div>
                            <div class="time_year_month"><?=date('Y-m', $newsList['created_at']);?></div>
                        </div>
                        <div class="slide_txt">
                            <div class="slide_title ellipse1"><?=$newsList['title']?></div>
                            <div class="slide_txt_ct ellipse3"><?=Yii::$app->formatter->asText($newsList['intro'])?></div>
                        </div>
                    </div>
                </a>
            </li>
            <?php } ?>
            <?php unset($newsLists); ?>
        </ul>
    </div>
</div>
<?php $this->registerJs('
TouchSlide({ 
    slideCell:"#focus",
    titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
    mainCell:".bd ul", 
    effect:"left", 
    autoPlay:true,//自动播放
    autoPage:true, //自动分页
    delayTime:500,//切换速度
    interTime:3000,//滞留间隔
    switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});
', yii\web\View::POS_END); ?>
