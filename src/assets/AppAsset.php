<?php

namespace klintlili\mobile\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/mobile/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        \snor\web\assets\AppAsset::class,
    ];
}
