<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model snor\web\models\Project */

$this->title = "{$model->title} – 施诺官网";
?>
<div class="wrap project_view">
    <div class="snor_w clearfix">
        <div class="snor_path"><a href="<?=Url::to(['/mobile/project/index'])?>">服务案例</a>&gt;<a href="<?=Url::to(['/mobile/project/index', 'code' => $model->code])?>"><?=$model->cateName;?></a>&gt;<span><?=$model->title;?></span></div>
        <div class="view_left">
            <div class="project_example clearfix">
                <div class="example_lf fl"><img src="<?=$model->picUrl;?>" alt="<?=$model->title;?>" /></div>
                <div class="example_rg fr">
                    <div class="example_tittle1 ellipse1"><?=$model->title;?></div>
                    <p class="ellipse2"><?=$model->intro;?></p>
                    <div class="example_tittle2">项目描述</div>
                    <?=Yii::$app->formatter->asText($model->desc);?>
                </div>
                <a href="<?=Url::to(['/mobile/project/view', 'id' => $model->id]);?>" class="block_a"></a>
            </div>
            <div class="project_desc_tittle">项目描述</div>
            <div class="project_view_content">
                <?=Yii::$app->formatter->asHtml($model->content);?>
            </div>
            <div class="pre_next_box">
                <?php $preProject = $model->preProject; ?>
                <?php /* @var $preProject snor\web\models\Project */ ?>
                <?php if (!empty($preProject)) { ?>
                    <a href="<?=Url::to(['/mobile/project/view', 'id' => $preProject->id])?>" class="ellipse1" title="<?=$preProject->title;?>">上一案例：<?=$preProject->title;?></a>
                <?php } ?>
                <?php $nextProject = $model->nextProject; ?>
                <?php /* @var $nextProject snor\web\models\Project */ ?>
                <?php if (!empty($nextProject)) { ?>
                    <a href="<?=Url::to(['/mobile/project/view', 'id' => $nextProject->id])?>" class="ellipse1" title="<?=$nextProject->title;?>">下一案例：<?=$nextProject->title;?></a>
                <?php } ?>
                <?php unset($preProject,$nextProject); ?>
            </div>

            <?php $relatedProjects = $model->relatedProjects;?>
            <?php if(!empty($relatedProjects)){ ?>
                <div class="project_about_box">
                    <div class="project_about_tt">相关案例</div>
                    <ul class="clearfix">
                        <?php /* @var $relatedProject snor\web\models\Project */ ?>
                        <?php foreach ($relatedProjects as $relatedProject){?>
                            <li><a href="<?=Url::to(['/mobile/project/view', 'id' => $relatedProject->id])?>" class="ellipse1"><?=$relatedProject->title;?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <?php unset($relatedProjects);?>

        </div>

        <?php $topNewProjects = $model->topNewProjects;?>
        <?php if(!empty($topNewProjects)){ ?>
            <div class="view_right">
                <div class="vr_title">最新案例</div>
                <dl  class="new_projects">
                    <?php /* @var $topNewProject snor\web\models\Project */ ?>
                    <?php foreach ($topNewProjects as $topNewProject){ ?>
                        <dd>
                            <div class="new_project_img"><img src="<?=$topNewProject->picUrl;?>" alt="<?=$topNewProject->title;?>" /></div>
                            <p><?=$topNewProject->title;?></p>
                            <div class="new_project_bot clearfix">
                                <span><?=date('Y-m-d', $topNewProject->created_at);?></span>
                                <a href="<?=Url::to(['/mobile/project/view', 'id' => $topNewProject->id]);?>">更多 &gt;</a>
                            </div>
                            <a href="<?=Url::to(['/mobile/project/view', 'id' => $topNewProject->id]);?>" class="block_a"></a>
                        </dd>
                    <?php } ?>
                </dl>
            </div>
        <?php } ?>
        <?php unset($topNewProjects); ?>
    </div>

</div>

