<?php /** @noinspection PhpUnhandledExceptionInspection */

/* @var $this yii\web\View */
/* @var $model \snor\web\forms\BusinessForm */
/* @var $form yii\bootstrap\ActiveForm */

use snor\web\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = "联系我们 – 施诺官网";
$this->registerMetaTag(["name"=> "description", "content"=> "施诺,为用户提供热水、采暖、空调、新风、除湿等家庭和公装解决方案,10W用户的大数据积累,为您提供亲近自然的舒适!"]);
$this->registerJsFile("@web/js/levelDistrict.js",["depends" => ["snor\\web\\assets\\AppAsset"]]);
$this->registerJsFile("@web/js/submit.js",["depends" => ["snor\\web\\assets\\AppAsset"]]);
?>
<div class="wrap">
    <div class="contact_head"></div>
    <div class="snor_w">
        <div class="contact_box border-box clearfix">
            <div class="contact_form_box">
                <div class="cfb_tittle"></div>
                <?php $form = ActiveForm::begin([
                    'id' => 'xj_business_form',
                    'action' => Url::to(['/site/ajax-business']),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'enableClientScript' => false
                ]); ?>
                    <div class="contact_form">
                        <?= Html::activeHiddenInput($model,'district_id',["class" => "hide_district_val", 'value'=> $district_id]);?>
                        <?= Html::activeHiddenInput($model, 'url', ['value' => Yii::$app->request->absoluteUrl]); ?>
                        <div class="input_box">
                            <div><?= Html::activeInput('text', $model, 'name', ["placeholder"=>"您的姓名", "class" => "username"]);?></div>
                            <div><?= Html::activeInput('text', $model, 'mobile', ["placeholder"=>"您的手机号码", "class" => "usernumber"]);?></div>
                        </div>
                        <div class="select_box" id="selectDistrict"></div>
                        <div class="conct_area_box">
                            <?= Html::activeTextarea($model, 'desc', ["placeholder"=>"请输入..."]);?>
                        </div>
                        <div class="button_box">
                            <?= Html::button('提交留言', ['class' => 'submit_button border-box']) ?>
                            <?= Html::tag('p', '', ['class' => 'errorinfo']); ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="conct_address_box">
                <div class="cab_tittle">施诺中国总部：</div>
                <p>电话：4000-660-918</p>
                <p>邮箱：snor@snor-china.com</p>
                <p>地址：武汉市江岸区石桥一路5号</p>
                <div class="cab_tittle" style="margin-top:42px;">施诺中国分支机构：</div>
                <p>北京 010-53670030 北京市朝阳区久文路6号宇达创意中心4号楼</p>
                <p>上海 021-64063517 上海市徐汇区田林路418弄A栋一楼</p>
                <p>深圳 0755-29058100 深圳市龙华新区民治牛栏前U创谷港深国际中心641</p>
                <p>武汉 027-50757986  武汉市江汉区民生金融中心21楼01-02室</p>
                <p>成都 028-89548100  成都市高新区天仁路259号南晶国际A座3楼</p>
                <p>重庆 023-68151283  重庆市渝北区金开大道1226号附1号</p>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJs('
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
            businessformdesc=$.trim($("#businessform-desc").val());
       
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
    })
', yii\web\View::POS_END); ?>