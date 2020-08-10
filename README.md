<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">mobile module Extension for Yii 2</h1>
    <br>
</p>

This extension provides a mobile module for [Yii framework 2.0](http://www.yiiframework.com) applications yii2-app-basic template.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist klintlili/yii2-mobile
```

or add

```
"klintlili/yii2-mobile": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'bootstrap' => ['mobile'],
    'modules' => [
        'mobile' => [
            'class' => 'klintlili\mobile\Module'
        ],
        // ...
    ],
    ...
];
```