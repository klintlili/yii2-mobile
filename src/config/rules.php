<?php
/**
 * mobile Url 规则
 */
//把本问内容不能单独使用，不是常规的不能单独使用
//以下规则是只想给mobile模块，m站子域名使用，那么我们使用UrlManager配置引用这些rules内容的时候，切记一定是require的rules-m
//到一定要是GroupUrlRule里面引用本规则文件，那样会跟我们自动加上route前缀，是真正的去找mobile下的这些route
//直接引用本文件，那么route就是route
//试试 我们去掉只能子域名访问，这个配置会不会有问题了
//var_dump($this->mode);die;
return [
//    'http://www.shushi100.com/site/index' => 'mobile',
//    [
////        'pattern' => 'http://m.dev.snor.shushi100.net/<sss_:[sys|w]>/<action:site>/index',
//        'pattern' => '<sss_:[sys|w]>/<action:site>/index',
//        'route' => $this->id. '/<sss_>/mobile/<action>',
////        'host' => 'http://www.xiongxi.net/',
//        'defaults' => ['id' =>1, 'sss_' => 'sys']
//    ],
//    'GET,POST,PUT ' => 'mobile/site/index',
    '' => 'site/index',
//    '/' => 'site/index',
//    '/' => 'site/index', //这样写不对，下面才行http://m.dev.snor.shushi100.net/就是匹配的紧接着的下面的规则
    [
        'pattern' => '<action:site>',
        'route' => $this->id. '/site/index',
        'suffix' => '/',
    ],
    [
        'pattern' => '',
        'route' => $this->id. '/site/index',
        'suffix' => '/',
    ],
//name也就是key不能结尾是/
//二维的时候 pattern就是相当于填写的一维的name， UrlRule数据中的 pattern就是根据name生成的， 真正程序去做比对是拿UrlRule数据中的pattern内容进行匹配
    'site/index' => 'site/index',
    [
        'pattern' => 'site/index',
        'route' => $this->id. '/site/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'product/<code:[\w-]+>/page-<page:\d+>',
        'route' => $this->id. '/product/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'product/<code:[\w-]+>',
        'route' => $this->id. '/product/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'product',
        'route' => $this->id. '/product/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'product/<id:\d+>',
        'route' => $this->id. '/product/view',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'services/<code:[\w-]+>/page-<page:\d+>',
        'route' => $this->id. '/project/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'services/<code:[\w-]+>',
        'route' => $this->id. '/project/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'services',
        'route' => $this->id. '/project/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'services/<id:\d+>',
        'route' => $this->id. '/project/view',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'article/<code:[\w-]+>/page-<page:\d+>',
        'route' => $this->id. '/news/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'article/<code:[\w-]+>',
        'route' => $this->id. '/news/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'article',
        'route' => $this->id. '/news/index',
        'suffix' => '/',
    ],
    [
        'pattern' => 'article/<id:\d+>',
        'route' => $this->id. '/news/view',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'about',
        'route' => $this->id. '/about/index',
        'suffix' => '.html',
    ],
    [
        'pattern' => 'contact',
        'route' => $this->id. '/contact/index',
        'suffix' => '.html',
    ],
    '<action:error>' => 'site/<action>',
    '<controller:[\w-/]+>/<id:\d+>' => '<controller>/view',
    '<controller:[\w-/]+>/<id:\d+>/<action:[\w-]+>' => '<controller>/<action>',
];
