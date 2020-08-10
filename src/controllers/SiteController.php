<?php

namespace snor\web\mobile\controllers;

use Yii;
use snor\web\forms\BusinessForm;
use snor\web\mobile\models\District;
use yii\web\Controller;
use yii\web\ErrorAction;
use snor\web\mobile\models\HomeIndex;

/**
 * Class SiteController
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new HomeIndex();
        $formModel = new BusinessForm();
        $json = District::getDistrictJson();
        $parent_id = $district_id = 0;
        return $this->render('index',[
            'model' => $model,
            'formModel' => $formModel,
            'json' => $json,
            'parent_id' => $parent_id,
            'district_id' => $district_id
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionAjaxBusiness()
    {
        $model = new BusinessForm();
        $data = ['ok' => 0, 'error' => "提交失败"];
        if ($model->load(Yii::$app->request->post(), "") && $model->add()) {
            $data = ['ok' => 1, 'error' => ''];
        }

        if ($model->hasErrors()) {
            $data = ['ok' => 0, 'error' => current($model->firstErrors)];
        }

        return $this->asJson($data);
    }
}
