<?php
/**
 * mobile Url 规则
 */
return [
    '' => 'mobile/site/index',
    'site/index' => 'mobile/site/index',
    [
        'pattern' => 'site/index',
        'route' => 'mobile/site/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'site',
        'route' => 'mobile/news/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'product/<code:[\w-]+>/page-<page:\d+>',
        'route' => 'mobile/product/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'product/<code:[\w-]+>',
        'route' => 'mobile/product/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'product',
        'route' => 'mobile/product/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'product/<id:\d+>',
        'route' => 'mobile/product/view',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'services/<code:[\w-]+>/page-<page:\d+>',
        'route' => 'mobile/project/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'services/<code:[\w-]+>',
        'route' => 'mobile/project/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'services',
        'route' => 'mobile/project/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'services/<id:\d+>',
        'route' => 'mobile/project/view',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'article/<code:[\w-]+>/page-<page:\d+>',
        'route' => 'mobile/news/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'article/<code:[\w-]+>',
        'route' => 'mobile/news/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'article',
        'route' => 'mobile/news/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'article/<id:\d+>',
        'route' => 'mobile/news/view',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'about',
        'route' => 'mobile/about/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'contact',
        'route' => 'mobile/contact/index',
        'suffix' => '.html',
    ],
    '<action:error>' => 'mobile/site/<action>',
    '<controller:[\w-]+>' => 'mobile/<controller>/index',
    '<controller:[\w-/]+>/<id:\d+>' => 'mobile/<controller>/view',
    '<controller:[\w-/]+>/<id:\d+>/<action:[\w-]+>' => 'mobile/<controller>/<action>',
];
