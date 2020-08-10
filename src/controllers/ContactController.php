<?php

namespace klintlili\mobile\controllers;

use klintlili\mobile\forms\BusinessForm;
use klintlili\mobile\models\District;
use yii\web\Controller;

/**
 * Class ContactController
 */
class ContactController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new BusinessForm();
        $json = District::getDistrictJson();
        $parent_id = $district_id = 0;
        return $this->render('index', [
            'model' => $model,
            'json' => $json,
            'parent_id' => $parent_id,
            'district_id' => $district_id,
        ]);
    }
}
