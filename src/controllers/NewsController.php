<?php

namespace snor\web\mobile\controllers;

use Yii;
use snor\web\mobile\models\HomeIndex;
use snor\web\mobile\models\News;
use snor\web\mobile\models\NewsCate;
use snor\web\mobile\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 */
class NewsController extends Controller
{
    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new HomeIndex();
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cate_lists = NewsCate::getCateList();
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cate_lists' => $cate_lists,
            'code' => Yii::$app->request->get('code'),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('指定的新闻不存在。');
    }
}
