<?php

namespace app\modules\shorts\controllers;

use app\modules\shorts\models\Log;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Log models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Log::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'link_id' => SORT_DESC,
                    'ip_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Log model.
     * @param int $link_id Link ID
     * @param int $ip_id Ip ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($link_id, $ip_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($link_id, $ip_id),
        ]);
    }

    /**
     * Creates a new Log model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Log();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'link_id' => $model->link_id, 'ip_id' => $model->ip_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Log model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $link_id Link ID
     * @param int $ip_id Ip ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($link_id, $ip_id)
    {
        $model = $this->findModel($link_id, $ip_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'link_id' => $model->link_id, 'ip_id' => $model->ip_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Log model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $link_id Link ID
     * @param int $ip_id Ip ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($link_id, $ip_id)
    {
        $this->findModel($link_id, $ip_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $link_id Link ID
     * @param int $ip_id Ip ID
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($link_id, $ip_id)
    {
        if (($model = Log::findOne(['link_id' => $link_id, 'ip_id' => $ip_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
