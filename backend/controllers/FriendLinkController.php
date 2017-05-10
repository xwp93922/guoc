<?php

namespace backend\controllers;

use Yii;
use common\models\FriendLink;
use common\models\searchs\FriendLinkSearch;
//use yii\web\Controller;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
//use common\helpers\DataHelper;

/**
 * FriendLinkController implements the CRUD actions for FriendLink model.
 */
class FriendLinkController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all FriendLink models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$site_id = \Yii::$app->params['site_id'];
    	$lang_id = \Yii::$app->params['lang_id'];
        $searchModel = new FriendLinkSearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FriendLink model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

     /**
     * Creates a new Friendlink model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Friendlink();     

        if (Yii::$app->request->isPost) {

            //var_dump(Yii::$app->request->post());die;
            //var_dump($_POST);die;
            $lang_id = \Yii::$app->params['lang_id'];
            $friendlink = Yii::$app->request->post('FriendLink');

            $model->site_id = $friendlink['site_id'];
            $model->lang_id = $lang_id;
            $model->site_url = $friendlink['site_url'];
            $model->name = $friendlink['name'];
         

            $model->logo = UploadedFile::getInstance($model, 'logo');
                 //var_dump($model);die;
            if (($file = $model->uploadLogo($friendlink['site_id']))!=false) {
                $model->logo = $file['src'];
            }

             //var_dump($model->logo);die;
            /*if ($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }*/

            if ($model->validate() && $model->save()){
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('create', [
                'model' => $model,
            ]);
        
    }

    /**
     * Updates an existing FriendLink model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {

            //var_dump(Yii::$app->request->post());die;
            //var_dump($_POST);die;
            $lang_id = \Yii::$app->params['lang_id'];
            $friendlink = Yii::$app->request->post('FriendLink');

            $model->site_id = $friendlink['site_id'];
            $model->lang_id = $lang_id;
            $model->site_url = $friendlink['site_url'];
            $model->name = $friendlink['name'];
         

            $model->logo = UploadedFile::getInstance($model, 'logo');
                 //var_dump($model);die;
            if (($file = $model->uploadLogo($friendlink['site_id']))!=false) {
                $model->logo = $file['src'];
            }

             //var_dump($model->logo);die;
            /*if ($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }*/

            if ($model->validate() && $model->save()){
                return $this->redirect(['index']);
            }
        }

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/

        return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing FriendLink model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        UtilHelper::DeleteImg($model->logo);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FriendLink model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FriendLink the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FriendLink::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
