<?php

use yii\helpers\Url;

$this->registerJsFile("@web/js/TouchSlide.1.1.js",["depends" => ["snor\\web\\assets\\AppAsset"]]);
?>
<style>
    .focus{ width:100%; height:203px; margin:0 auto; position:relative; overflow:hidden; color:#757778}
    .focus .hd{ width:100%; height:10px;  position:absolute; z-index:5; left:0px; bottom:20px; text-align:center;  }
    .focus .hd ul{ display:block; width:100%; height:10px; font-size:0; vertical-align:top;  }
    .focus .hd ul li{ display:inline-block; width:10px; height:10px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; background:#ddd; margin:0 5px;  vertical-align:top; overflow:hidden; cursor: pointer;   }
    .focus .hd ul .on{ background:#535353;  }

    .focus .bd{ position:relative; z-index:0; }
    .focus .bd li{ position:relative; width:100%;}
    .focus .bd li a.viewto{ -webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */display:block; width:100%; height:100%}
    .news_img_box{ width:210px;  height:142px; float:left; display:flex; justify-content: center; align-items: center;}
    .news_img_box img{display:block; width: 100%; height:100%; margin:0 auto;}
    .slide_desc{width:895px;float:right}
    .slide_time{justify-content: space-between; align-items: center;}
    .slide_time span{font-size:12px; color:#ccc;}
    .slide_time span.news_more{display:block; height:32px; line-height: 32px; font-size: 16px; color:#ee1b8f;}
    .slide_title{ font-size:16px; color:#2d2c2d; margin:12px 0 5px; height:32px; line-height: 32px;}
    .slide_txt_ct{line-height: 24px; height:72px; overflow:hidden;  color: #757778;}
    a:hover .slide_txt_ct{color:#ee1b8f;}
</style>
<div id="focus" class="focus">
    <div class="hd">
        <ul></ul>
    </div>
    <div class="bd">
        <ul>
            <?php /** @var $model \snor\web\models\News */  ?>
            <?php foreach ($bottom_slider as $model){ ?>
                <li class="clearfix">
                    <a href="<?=Url::to(['/mobile/news/view', 'id' => $model->id]);?>" class="viewto" data-pjax="0">
                        <div class="news_img_box"><img src="<?=$model->picUrl;?>" alt="<?=$model->title;?>"/></div>
                        <div class="slide_desc">
                            <div class="slide_title ellipse1"><?=$model->title;?></div>
                            <div class="slide_txt_ct ellipse3">
                                <?=$model->intro;?>
                            </div>
                            <div class="slide_time flex"><span><?=date('Y-m-d H:i:s', $model->created_at);?></span><span class="news_more" data-pjax="0">更多&gt;</span></div>
                        </div>
                    </a>
                </li>
            <?php } ?>
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
