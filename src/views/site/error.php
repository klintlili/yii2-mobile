<?php /** @noinspection PhpUnhandledExceptionInspection */

use snor\web\helpers\Html;
use yii\web\HttpException;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception|HttpException */

$this->title = $name;
$err = ($exception instanceof HttpException) ? $exception->statusCode : 500;
$this->params['breadcrumbs'][] = $err . ' 错误';
?>
<div class="wrap flex error_page">
    <div class="error_img"><img src="<?=Url::to('@web/img/error.png');?>" alt="404" /></div>
    <p>对不起，您访问的页面已失效！</p>
    <p> ......</p>
</div>
