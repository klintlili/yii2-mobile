<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model snor\web\models\News */

$this->title = "{$model->title} – 施诺官网";
?>
<div class="wrap news_view">
    <div class="snor_w clearfix">
        <div class="view_left">
            <div class="snor_path"><a href="<?=Url::to(['/mobile/news/index']);?>">新闻中心</a>&gt;<a href="<?=Url::to(['/mobile/news/index', 'code' => $model->code]);?>"><span><?=$model->cateName;?></span></a></div>
            <div class="news_view_tittle">
                <div><?=$model->title;?></div>
                <p>发布时间：<?=date('Y-m-d H:i:s', $model->created_at);?></p>
            </div>
            <div class="news_view_content">
                <?=Yii::$app->formatter->asHtml($model->content);?>
            </div>
            <div class="pre_next_box">
                <?php $preArticle = $model->preArticle; ?>
                <?php /* @var $preArticle snor\web\models\News */ ?>
                <?php if (!empty($preArticle)) { ?>
                    <a href="<?=Url::to(['/mobile/news/view', 'id' => $preArticle->id])?>" class="ellipse1" title="<?=$preArticle->title;?>">上一新闻：<?=$preArticle->title;?></a>
                <?php } ?>
                <?php $nextArticle = $model->nextArticle; ?>
                <?php /* @var $nextArticle snor\web\models\News */ ?>
                <?php if (!empty($nextArticle)) { ?>
                    <a href="<?=Url::to(['/mobile/news/view', 'id' => $nextArticle->id])?>" class="ellipse1" title="<?=$nextArticle->title;?>">下一新闻：<?=$nextArticle->title;?></a>
                <?php } ?>
                <?php unset($preArticle,$nextArticle); ?>
            </div>

            <?php $relatedArticles = $model->relatedArticles;?>
            <?php if(!empty($relatedArticles)){ ?>
                <div class="project_about_box">
                    <div class="project_about_tt">相关文章</div>
                    <ul class="clearfix">
                        <?php /* @var $relatedArticle snor\web\models\News */ ?>
                        <?php foreach ($relatedArticles as $relatedArticle){?>
                            <li><a href="<?=Url::to(['/mobile/news/view', 'id' => $relatedArticle->id])?>" class="ellipse1"><?=$relatedArticle->title;?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <?php unset($relatedArticles);?>

        </div>

        <?php $topNewArticles = $model->topNewArticles;?>
        <?php if(!empty($topNewArticles)){ ?>
            <div class="view_right">
                <div class="vr_title">最新文章</div>
                <dl  class="new_projects">
                    <?php /* @var $topNewArticle snor\web\models\News */ ?>
                    <?php foreach ($topNewArticles as $topNewArticle){ ?>
                        <dd>
                            <a href="<?=Url::to(['/mobile/news/view', 'id' => $topNewArticle->id]);?>" class="block_a">
                            <div class="new_project_img"><img src="<?=$topNewArticle->picUrl;?>" alt="<?=$topNewArticle->title;?>" /></div>
                            <p><?=$topNewArticle->title;?></p>
                            <div class="new_project_bot clearfix">
                                <span><?=date('Y-m-d', $topNewArticle->created_at);?></span>
                                <span class="more" href="<?=Url::to(['/mobile/news/view', 'id' => $topNewArticle->id]);?>">更多 &gt;</span>
                            </div>
                            </a>
                        </dd>
                    <?php } ?>
                </dl>
            </div>
        <?php } ?>
        <?php unset($topNewArticles); ?>
    </div>

</div>
