<?php

namespace app\modules\shorts\controllers;

use app\modules\shorts\models\Link;
use app\modules\shorts\models\Ip;
use app\modules\shorts\models\Log;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Da\QrCode\QrCode;

/**
 * LinkController implements the CRUD actions for Link model.
 */
class LinkController extends Controller
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
     * Lists all Link models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Link::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Link model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Link model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Link();

        

        if ($this->request->isPost) {

            if ($this->request->isAjax and $model->load($this->request->post())) {

                $this->response->format = Response::FORMAT_JSON;

                //return ActiveForm::validate($model);

                $t = ActiveForm::validate($model);

                if (count($model->errors) > 0) {
                    return $t;
                 } else {//save and response json
                    $model->save();
                    $new_id = $model->id;
                    $short_url = Html::a(\Yii::$app->urlManager->hostInfo . Url::to(['goto','q'=>$new_id]),Url::to(['goto','q'=>$new_id]));
                    $qr_url = Url::to(['qr','q'=>$new_id]);
                    $data = [                        
                        'id' => $model->id,
                        'short_url' => $short_url,
                        'qr_url' => $qr_url,
                                                
                    ];
                                        
                    return $data;

                 }

            }
        

            if (0 && $model->load($this->request->post()) && $model->save()) {

                if(\Yii::$app->request->isAjax){
                    //return $model->id;

                    
                }


                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Link model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Link model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Redirect by a short Link
     * @param int $q ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGoto($q)
    {
        $link = $this->findModel($q);
        $link_url = $link->url;
        $link_id = $link->id;

        $user_ip = $_SERVER['REMOTE_ADDR'];

        if (($ip = Ip::findOne(['ip' => $user_ip])) !== null) {
            $ip_id = $ip->id;
        }
        else {
            $ip = new Ip;
            $ip->ip = $user_ip;
            $ip->save();
            $ip_id = $ip->id;

        }

        $log = Log::findOne([
            'link_id' => $link_id,
            'ip_id' => $ip_id,
        ]);

        if ($log !== null) {
            $log->count = $log->count + 1;

        } else{
            $log = new Log;
            $log->count =  1;
            $log->link_id = $link_id;
            $log->ip_id = $ip_id;
        }
        $log->save();
        
        return $this->redirect($link_url);
    }


    /**
     * Generates QR, writes it and return its url  
     * @param int $q 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionQr($q)
    {
        $link = $this->findModel($q);

        $link_url = $link->url;

        $ourUrl = \Yii::$app->urlManager->hostInfo . Url::to(['goto','q'=>$q]);

        $qrCode = (new QrCode($ourUrl))
            ->setSize(250)
            ->setMargin(5)
            ->setBackgroundColor(255, 255, 255);
        
        $this->response->format = Response::FORMAT_RAW;//Response::FORMAT_HTML 
        $path = \Yii::$app->assetManager->basePath."/qr_${q}.png";
        $qrCode->writeFile($path); 
        $this->response->data = \Yii::$app->urlManager->hostInfo .'/assets'."/qr_${q}.png";      
               

        return $this->response;
    }




    /**
     * Finds the Link model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Link the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Link::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
