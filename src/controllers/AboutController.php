<?php

namespace snor\web\mobile\controllers;

use snor\web\models\HomeIndex;
use yii\web\Controller;

/**
 * Class AboutController
 */
class AboutController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new HomeIndex();
        return $this->render('index', compact('model'));
    }
}
