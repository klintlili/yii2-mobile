<?php /** @noinspection PhpUnhandledExceptionInspection */

/* @var $this yii\web\View */
/* @var $model \snor\web\models\HomeIndex */
/* @var $formModel \snor\web\forms\BusinessForm */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use snor\web\helpers\Html;
use snor\web\models\HomeIndex;

$this->title = "地暖空调一体机，空气源热泵，冷凝壁挂炉，全热除霾新风除湿机，酒窖空调 – 施诺官网";
$this->registerMetaTag(["name" => "description", "content" => "施诺,为用户提供热水、采暖、空调、新风、除湿等家庭和公装解决方案,10W用户的大数据积累,为您提供亲近自然的舒适!"]);
$this->registerJsFile("@web/js/levelDistrict.js",["depends" => ["snor\\web\\assets\\AppAsset"]]);
$this->registerJsFile("@web/js/submit.js",["depends" => ["snor\\web\\assets\\AppAsset"]]);
?>

<div class="wrap index">
    <?= $this->render('index/_slider', ['models' => $model->slide]) ?>
    <div class="zb">
        <ul class="snor_w clearfix">
            <li>
                <div class="icon"><img src="<?=Url::to('@web/img/yf.png');?>" alt="研发" /></div>
                <div class="item_title">3年+</div>
                <div class="item_desc">研发技术测试</div>
            </li>
            <li>
                <div class="icon"><img src="<?=Url::to('@web/img/bz.png');?>" alt="标准" /></div>
                <div class="item_title">7项+</div>
                <div class="item_desc">欧洲标准认证</div>
            </li>
            <li>
                <div class="icon"><img src="<?=Url::to('@web/img/fx.png');?>" alt="分析" /></div>
                <div class="item_title">10年+</div>
                <div class="item_desc">数据分析</div>
            </li>
            <li>
                <div class="icon"><img src="<?=Url::to('@web/img/al.png');?>" alt="优秀案例" /></div>
                <div class="item_title">100例+</div>
                <div class="item_desc">优秀案例</div>
            </li>
            <li>
                <div class="icon"><img src="<?=Url::to('@web/img/yh.png');?>" alt="用户积累" /></div>
                <div class="item_title">1000000个+ </div>
                <div class="item_desc">用户积累</div>
            </li>
        </ul>
    </div>
    <!--第一部分完-->
    <div class="house_box">
        <div class="snor_w">
            <div class="index_title">
                <div>亲近自然的舒适</div>
                <p>Enioy Comfort In Nature</p>
            </div>
            <div class="house_img">
                <img src="<?=Url::to('@web/img/house.png');?>" alt="房子" />
                <div class="house1">
                    <!--施诺全直流变频智能空气源热泵-->
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'kongqiyuanrebeng'])?>" class="point"></a>
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'kongqiyuanrebeng'])?>" class="blk"></a>
                </div>
                <div class="house2">
                    <!--施诺酒窖空调-->
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'jiujiaokongtiao'])?>" class="point"></a>
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'jiujiaokongtiao'])?>" class="blk"></a>
                </div>
                <div class="house3">
                    <!--施诺纳米碳热膜-->
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'namitanremo'])?>" class="point"></a>
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'namitanremo'])?>" class="blk"></a>
                </div>
                <div class="house4">
                    <!--施诺防霾全热交换新风除湿机-->
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'xinfengchushiji'])?>" class="point"></a>
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'xinfengchushiji'])?>" class="blk"></a>
                </div>
                <div class="house5">
                    <!--施诺环境智能系统-->
                    <a href="javascript:void(0)" class="point"></a>
                    <a href="javascript:void(0)" class="blk"></a>
                </div>
                <div class="house6">
                    <!--施诺全屋净水-->
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'jingshuiji'])?>" class="point"></a>
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'jingshuiji'])?>" class="blk"></a>
                </div>
                <div class="house7">
                    <!--施诺厨房垃圾处理器-->
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'lajichuliqi'])?>" class="point"></a>
                    <a href="<?=Url::to(['/mobile/product/index', 'code' => 'lajichuliqi'])?>" class="blk"></a>
                </div>
            </div>
        </div>
    </div>
    <!--第二部分完-->
    <?php $projectLists = HomeIndex::getIndexProjectData();?>
    <?php if(!empty($projectLists)){ ?>
        <div class="anli_box">
            <div class="snor_w">
                <div class="index_title">
                    <div>服务案例</div>
                    <p>A Selection Of Signature Projects</p>
                </div>
                <div class="anli_ct">
                    <ul class="hover_item">
                        <?php foreach ($projectLists as $key => $projectList){ ?>
                            <li <?=$key==0?'class="current"':'class=""';?>>
                                <img src="<?=Url::to(Html::getPicUrlByPath($projectList['gray_icon']));?>"/>
                                <img src="<?=Url::to(Html::getPicUrlByPath($projectList['white_icon']));?>" class="focus_img"/>
                                <p><?=$projectList['name'];?></p>
                            </li>
                        <?php } ?>
                    </ul>
                    <ul class="show_item">
                        <?php foreach ($projectLists as $key => $projectList){ ?>
                            <li <?=$key==0?'class="current"':'class=""';?>>
                                <a href="<?=Url::to(['/mobile/project/view', 'id' => $projectList['id']]);?>" class="block_a">
                                    <img src="<?=Url::to(Html::getPicUrlByPath($projectList['pic']));?>" alt="<?=$projectList['title'];?>"/>
                                    <div class="item_desc border-box">
                                        <div class="item_tt"><?=$projectList['title'];?></div>
                                        <p><?=Yii::$app->formatter->asText($projectList['intro']);?></p>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php unset($projectLists); ?>
    <!--第三部分完-->

    <?php $news_data = HomeIndex::getIndexNewsData();?>
    <?php if(!empty(array_filter($news_data))){ ?>
        <div class="news_center">
            <div class="snor_w">
                <div class="index_title">
                    <div>新闻中心</div>
                    <p>The Latest And Greatest Project News</p>
                </div>
                <div class="news_box clearfix">
                    <div class="news_left fl">
                        <!--幻灯片-->
                        <?php $news_data_left = $news_data[0];?>
                        <?php if (!empty($news_data_left)){ ?>
                            <?= $this->render('index/_slider_anli', ['newsLists' => $news_data_left]) ?>
                        <?php } ?>
                        <?php unset($news_data_left);?>
                    </div>
                    <div class="news_right fr">
                        <?php $news_data_right_cate = $news_data[1];?>
                        <?php if (!empty($news_data_right_cate)){ ?>
                            <div class="news_head flex">
                                <?php /* @var $newsCate \snor\web\models\NewsCate */ ?>
                                <?php foreach ($news_data_right_cate as $key => $newsCate) { ?>
                                    <div<?=$key==0?' class="current"':'';?>><?=$newsCate->name?></div>
                                <?php } ?>
                            </div>
                            <div class="news_ct">
                                <?php $news_data_right_data = $news_data[2];?>
                                <?php $down_i = 0;?>
                                <?php foreach ($news_data_right_data as $key => $newsList){ ?>
                                    <dl<?=$down_i==0?' class="current"':'';?>>
                                        <?php if (!empty($newsList)){ ?>
                                            <?php /* @var $item \snor\web\models\News */ ?>
                                            <?php foreach ($newsList as $item){ ?>
                                                <dd>
                                                    <a href="<?=Url::to(['/mobile/news/view', 'id' => $item->id]);?>" class="block_a">
                                                        <p class="ellipse1"><?=$item->title?></p>
                                                        <span><?=date('Y-m-d', $item->created_at)?></span>
                                                    </a>
                                                </dd>
                                            <?php } ?>
                                            <div><a href="<?=Url::to(['/mobile/news/index', 'code' => $key]);?>" class="news_more">更多&gt;</a></div>
                                        <?php }else{ ?>
                                            <p>暂无数据!</p>
                                        <?php } ?>
                                        <?php unset($newsList) ?>
                                    </dl>
                                    <?php $down_i++; ?>
                                <?php } ?>
                                <?php unset($news_data_right_data) ?>
                            </div>
                        <?php } ?>
                        <?php unset($news_data_right_cate); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php unset($news_data); ?>
    <!--第四部分完-->
    <div class="message_wrap">
        <div class="snor_w">
            <div class="index_title">
                <div>留言</div>
                <p>Leave Us A Message.</p>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'xj_business_form',
                'action' => Url::to(['/mobile/site/ajax-business']),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'enableClientScript' => false
            ]); ?>
                <div class="message_box">
                    <div class="message_ct border-box">
                        <div class="quote_left"><img src="<?=Url::to('@web/img/quote_left.png');?>"/></div>
                        <p class="msg_beizhu">提交您的需求，我们将会马上给您回复~</p>
                        <div class="message_form">
                            <?= Html::activeHiddenInput($formModel,'district_id',["class"=>"hide_district_val", 'value'=> $district_id]);?>
                            <?= Html::activeHiddenInput($formModel, 'url', ['value' => Yii::$app->request->absoluteUrl]); ?>
                            <div class="input_box flex">
                                <div>
                                    <?= Html::activeInput('text', $formModel, 'name', ["placeholder"=>"您的姓名", 'style' => 'width:336px;',"class"=>"username"]);?>
                                </div>
                                <div>
                                    <?= Html::activeInput('text', $formModel, 'mobile', ["placeholder"=>"您的手机号码","class"=>"usernumber"]);?>
                                </div>
                            </div>
                            <div class="select_box flex" id="selectDistrict"><!--级联--></div>
                            <div class="area_box">
                                <?= Html::activeTextarea($formModel, 'desc', ["placeholder"=>"请描述您的需求"]);?>
                            </div>
                            <div class="button_box">
                                <?= Html::button('提交留言', ['class' => 'submit_button border-box']) ?>
								<?= Html::tag('p', '', ['class' => 'errorinfo']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!--第五部分完-->
</div>
<?php $this->beginBlock('links'); ?>
<?= $this->render('/layouts/_links', ['link_cate_id' => 0]) ?>
<?php $this->endBlock();?>
<?php $this->registerJs('
$(".news_head div").click(function(){
    var index=$(this).index();
    $(this).addClass("current").siblings().removeClass("current");
    $(".news_ct dl").eq(index).addClass("current").siblings().removeClass("current");
});
$(".hover_item li").hover(function(){
    var index=$(this).index();
    $(this).addClass("current").siblings().removeClass("current");
    $(".show_item li").eq(index).addClass("current").siblings().removeClass("current");
})
var json='.$json.';
var levelDst=new LevelDistrict({parentNode:$("#selectDistrict"),level:2,defaultValue:["'.$parent_id.'","'.$district_id.'"],json:json,placeholder:["所在省份","所在城市"]});
levelDst.on("assign",function(new_list){//创建监听事件，把值赋到指定文本框
    var valArray=[];
    for(var i=0;i<new_list.length;i++){
        valArray[i]=new_list.eq(i).val();
    }
    $(".hide_district_val").val(valArray.pop());    
});
function clearInput(){
    $(".username").val("");
    $(".usernumber").val("");
    $(".hide_district_val").val("");
    $("#businessform-desc").val("");
    
}
$(".submit_button").click(function(){
    var error_box=$(".errorinfo");
    var obj=this;
    var username=$.trim($(".username").val()),
        usernumber=$.trim($(".usernumber").val())
        userdistrict=$.trim($(".hide_district_val").val())
        businessurlval=$("#businessform-url").val()
        businessformdesc=$("#businessform-desc").val();
   
    var zero=checkNotZero(userdistrict,error_box,"请选择省市");
    var mobile=checkMobile(usernumber,error_box,"请输入正确的手机号码");
    var empty=checkNotEmpty(username,error_box,"姓名不能为空");

    if(!empty||!mobile||!zero)return;
    var json_data={
        name:username,
        mobile:usernumber,
        district_id:userdistrict,
        desc:businessformdesc,
        url:businessurlval
    }
    jike_sub(obj,json_data,error_box,null,clearInput);
})', yii\web\View::POS_END); ?>
