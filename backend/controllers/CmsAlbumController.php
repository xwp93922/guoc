<?php

namespace backend\controllers;

use Yii;
use common\models\CmsAlbum;
use common\models\searchs\CmsAlbumSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use common\helpers\CacheHelper;
use yii\filters\AccessControl;

/**
 * CmsAlbumController implements the CRUD actions for CmsAlbum model.
 */
class CmsAlbumController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsAlbum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $searchModel = new CmsAlbumSearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Displays a single CmsAlbum model.
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
     * Creates a new CmsAlbum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = new CmsAlbum();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;
        $statusMap = DataHelper::getGeneralStatus();

        if (Yii::$app->request->isPost) {
            $model->cover_file = UploadedFile::getInstance($model, 'cover_file');
            if (($file = $model->uploadCover($site_id))!=false) {
                $model->cover = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('album_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsAlbum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = $this->findModel($id);
        $statusMap = DataHelper::getGeneralStatus();

        if (Yii::$app->request->isPost) {
            $model->cover_file = UploadedFile::getInstance($model, 'cover_file');
            if (($file = $model->uploadCover($site_id))!=false) {
                UtilHelper::DeleteImg($model->cover);
                $model->cover = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('album_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Deletes an existing CmsAlbum model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        UtilHelper::DeleteImg($model->cover);
        $model->delete();
        CacheHelper::deleteCache('album_'.$model->site_id.'_'.$model->lang_id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsAlbum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsAlbum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsAlbum::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
