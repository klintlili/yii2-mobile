<?php

namespace snor\web\mobile;

use Yii;
use snor\web\BaseModule;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * mobile module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'snor\web\mobile\controllers';

    /**
     * @var bool
     */
    public $onlyChildDomain = false;

    /**
     * @var bool
     */
    public $https = false;

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        var_dump(11221);die;
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<id:\w+>', 'route' => $this->id . '/default/view'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => $this->id . '/<controller>/<action>'],
            ], false);
        }
    }

    /**
     * @throws ExitException
     * @throws InvalidConfigException
     */
    public function init()
    {
//        if($this->onlyChildDomain){
//            $this->filterDomainUrl();
//        }
        parent::init();
        Yii::$app->name .= '施诺官网 - 触屏版';
        $this->defaultRoute = 'site';
//        Yii::$app->errorHandler->errorAction = '/mobile/site/error';
        Yii::$app->set('urlManager', $this->get('urlManager'));
    }

    /**
     * 只允许子域名http://m.snor-china.com的形式访问m站mobile模块
     * 自动301跳转到 m站首页
     */
//    protected function filterDomainUrl()
//    {
//        if (stripos(Yii::$app->request->hostInfo, '//m.') !== false) {
//            if (stripos(Yii::$app->request->getAbsoluteUrl(), 'mobile') !== false) {
//                Yii::$app->getResponse()->redirect(Yii::$app->request->hostInfo, 301);
//                Yii::$app->end();
//            }
//        }else{
//            Yii::$app->getResponse()->redirect(Yii::$app->params['m_website'], 301);
//            Yii::$app->end();
//        }
//    }
}
