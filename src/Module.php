<?php

namespace klintlili\mobile;

use Yii;
use snor\web\BaseModule;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\base\BootstrapInterface;

/**
 * mobile module definition class
 */
class Module extends BaseModule implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'klintlili\mobile\controllers';

    /**
     * @var bool
     */
    public $onlyChildDomain = true;

    /**
     * @var bool
     */
    public $https = false;

    /**
     * @var array
     */
    public $rules = [];

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        if(empty($this->rules)){
            $this->rules = require dirname(__FILE__).'/config/rules.php';
        }

        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules($this->rules, false);
        }
    }

    /**
     * @throws ExitException
     * @throws InvalidConfigException
     */
    public function init()
    {
        if($this->onlyChildDomain){
            $this->filterDomainUrl();
        }
        parent::init();
        Yii::$app->name .= '施诺官网 - 触屏版';
        $this->defaultRoute = 'site';
        Yii::$app->errorHandler->errorAction = '/mobile/site/error';
        Yii::$app->set('urlManager', $this->get('urlManager'));
    }

    /**
     * 通过子域名http://m.snor-china.com的形式访问m站mobile模块的话，pathInfo中就不要出现mobile字眼了
     * 自动301跳转到 m站首页
     * 假如onlyChildDomain设置为false,也就可以通过http://www.snor-china.com/mobile/XXXX的形式访问mobile模块
     */
    protected function filterDomainUrl()
    {
        if (stripos(Yii::$app->request->hostInfo, '//m.') !== false) {
            if (stripos(Yii::$app->request->getAbsoluteUrl(), 'mobile') !== false) {
                Yii::$app->getResponse()->redirect(Yii::$app->request->hostInfo, 301);
                Yii::$app->end();
            }
        } elseif ($this->onlyChildDomain) {
            Yii::$app->getResponse()->redirect(Yii::$app->params['m_website'], 301);
            Yii::$app->end();
        }
    }
}
