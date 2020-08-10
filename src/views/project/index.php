<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use snor\web\models\News;
use snor\web\models\Project;

/* @var $this yii\web\View */
/* @var $searchModel snor\web\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model snor\web\models\HomeIndex */

$title = "服务案例";
$this->registerMetaTag(["name" => "description", "content" => "施诺,为用户提供热水、采暖、空调、新风、除湿等家庭和公装解决方案,10W用户的大数据积累,为您提供亲近自然的舒适!"]);
$code = Yii::$app->request->get('code');
if(!empty($code)) {
    $codeName = (new Project())->getCateNameByCode($code);
    if (!empty($codeName)) {
        $title = "{$codeName}";
    }
}
?>
<div class="wrap">
    <?= $this->render('/site/index/_slider', ['models' => $model->projectSlide]) ?>
    <div class="project_index_head">
        <div class="snor_w">
            <?php if(!empty($case_lists)){ ?>
                <ul class="pih_list clearfix">
                    <li<?=empty($code)?" class='current'":"";?>>
                        <a href="<?=Url::to(['/project/index']);?>" class="block_a">
                        <div style="padding-top:8px;">
                            <img src="<?=Url::to('@web/img/anli/qb.png');?>" alt="全部" />
                            <img src="<?=Url::to('@web/img/anli/qb_on.png');?>" alt="全部" class="on" />
                        </div>
                        <p>全部</p>
                        </a>
                    </li>
                    <?php /** @var $case_list \snor\web\models\CaseCate */  ?>
                    <?php foreach ($case_lists as $case_list){ ?>
                        <li<?=!empty($code)&&$code==$case_list->code?" class='current'":"";?>>
                            <a href="<?=Url::to(['/project/index', 'code' => $case_list->code]);?>" class="block_a">
                            <div>
                                <img src="<?=$case_list->grayIconUrl;?>"  alt="<?=$case_list->name;?>"/>
                                <img src="<?=$case_list->violetIconUrl;?>" alt="<?=$case_list->name;?>" class="on" />
                            </div>
                            <p><?=$case_list->name;?></p>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <?php unset($case_lists); ?>
        </div>
    </div>

    <div class="project_index_body">
        <div class="snor_w">

            <div class="project_list_box">
                <?php if ($dataProvider->totalCount > 0) { ?>
                    <ul class="project_list clearfix current">
                        <?php /** @var $list \snor\web\models\Project */  ?>
                        <?php foreach ($dataProvider->models as $list) { ?>
                            <li>
                                <a href="<?=Url::to(['/project/view', 'id' => $list->id]);?>" class="block_a">
                                <img src="<?=$list->picUrl;?>" alt="<?=$list->title;?>" />
                                <div class="border-box">
                                    <p class="ellipse2">
                                        <?=$list->title;?>
                                    </p>
                                </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                    <div class="fenye_box">
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
                    <p style="text-align: center;margin-top: 50px;">暂无服务案例！</p>
                <?php } ?>
            </div>

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
</div>
