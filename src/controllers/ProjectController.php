<?php

namespace klintlili\mobile\controllers;

use Yii;
use yii\web\Controller;
use klintlili\mobile\models\CaseCate;
use klintlili\mobile\models\HomeIndex;
use klintlili\mobile\models\Project;
use klintlili\mobile\models\ProjectSearch;
use yii\web\NotFoundHttpException;

/**
 * Class ProjectController
 */
class ProjectController extends Controller
{
    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new HomeIndex();
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $case_lists = CaseCate::getCateList();
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'case_lists' => $case_lists,
            'code' => Yii::$app->request->get('code'),
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('指定的工程案例不存在。');
    }
}
