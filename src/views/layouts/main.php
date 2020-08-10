<?php /** @noinspection PhpUnhandledExceptionInspection */

use klintlili\mobile\assets\AppAsset;
use snor\web\helpers\Html;
use snor\web\models\UrlSeo;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php if (empty(UrlSeo::urlTitle())) { ?>
        <title><?= Html::encode($this->title) ?></title>
    <?php }else{ ?>
        <title><?= Html::encode(UrlSeo::urlTitle()) ?></title>
    <?php } ?>
    <?php $this->head() ?>
    <?= Yii::$app->params['baidu_tongji']; ?><!-- 百度统计代码 -->
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('header') ?>
<?= $content ?>
<?= $this->render('footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
