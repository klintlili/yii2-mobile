<?php /** @noinspection PhpUnhandledExceptionInspection */

use yii\helpers\Url;
use snor\web\models\ProductCate;
use snor\web\models\CaseCate;
use snor\web\models\NewsCate;
?>
<footer class="snor_wrap footer">
    <div class="footer_about snor_w clearfix">
        <dl class="fl ft_menu">
            <dd class="border-box">
                <div class="f_title">关于施诺</div>
                <ul>
                    <li><a href="<?=Url::to(['/mobile/about/index'])?>">关于施诺</a></li>
                </ul>
            </dd>
            <?php $product_cate = ProductCate::getCateList();?>
            <?php if(!empty($product_cate)){ ?>
                <dd class="border-box">
                    <div class="f_title">解决方案</div>
                    <ul>
                        <?php /** @var $model \snor\web\models\ProductCate */  ?>
                        <?php foreach ($product_cate as $model){ ?>
                            <li><a href="<?=Url::to(['/mobile/product/index', 'code' => $model->code])?>"><?=$model->name;?></a></li>
                        <?php } ?>
                    </ul>
                </dd>
            <?php } ?>
            <?php unset($product_cate); ?>
            <?php $project_cate = CaseCate::getCateList();?>
            <?php if(!empty($project_cate)){ ?>
                <dd class="border-box">
                    <div class="f_title">工程案例</div>
                    <ul>
                        <?php /** @var $model \snor\web\models\CaseCate */  ?>
                        <?php foreach ($project_cate as $model){ ?>
                            <li><a href="<?=Url::to(['/mobile/project/index', 'code' => $model->code])?>"><?=$model->name;?></a></li>
                        <?php } ?>
                    </ul>
                </dd>
            <?php } ?>
            <?php unset($project_cate); ?>
            <?php $news_cate = NewsCate::getCateList();?>
            <?php if(!empty($news_cate)){ ?>
                <dd class="border-box">
                    <div class="f_title">新闻中心</div>
                    <ul>
                        <?php /** @var $model \snor\web\models\NewsCate */  ?>
                        <?php foreach ($news_cate as $model){ ?>
                            <li><a href="<?=Url::to(['/mobile/news/index', 'code' => $model->code])?>"><?=$model->name;?></a></li>
                        <?php } ?>
                    </ul>
                </dd>
            <?php } ?>
            <?php unset($news_cate); ?>
        </dl>
        <div class="fr code_box">
            <div class="code"><img src="<?=Url::to('@web/img/code.png');?>" alt="二维码" /></div>
            <div class="code_name">关注施诺官方微信</div>
            <div class="call_number">4000-660-918</div>
        </div>
    </div>

    <div class="last_bot_box">
        <div class="snor_w">
            <?= isset($this->blocks['links']) ? $this->blocks['links'] : '' ?>
            <div class="copyright">
                Copyright©<?=date('Y')?> 施诺 All rights reserved.
            </div>
            <div class="beianhao">
                <a href="http://beian.miit.gov.cn/" target="_blank"><img src="<?=Url::to('@web/img/snor_bot_beian.png');?>" alt="备案号" /></a>
            </div>
        </div>
    </div>

</footer>

