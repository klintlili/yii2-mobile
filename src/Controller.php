<?php

namespace klintlili\mobile;

use Yii;
use yii\web\Controller as BaseController;

/**
 * Class Controller
 */
class Controller extends BaseController
{
    function beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            return false;
        }

        if (stripos(Yii::$app->request->hostInfo, $this->module->host) !== false) {
            if (stripos(Yii::$app->request->getAbsoluteUrl(), 'mobile') !== false) {
                Yii::$app->getResponse()->redirect($this->module->host, 301);
                Yii::$app->end();
            }
        } elseif ($this->module->onlyChildDomain) {
            Yii::$app->getResponse()->redirect($this->module->host, 301);
            Yii::$app->end();
        }

        return true;
    }
}
