<?php

namespace backend\controllers;

use backend\components\Controller;
use Yii;
use common\models\CmsPageContact;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use common\helpers\CacheHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use backend\helpers\SiteHelper;
use yii\filters\AccessControl;

/**
 * PageContactController implements the CRUD actions for CmsPageContact model.
 */
class PageContactController extends Controller
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
     * Lists all CmsPageContact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = CmsPageContact::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        if (is_object($model))
        {
            return $this->redirect(['page-contact/update','id'=>$model->id]);
        }
        else
        {
            return $this->redirect(['page-contact/create']);
        }
    }

    /**
     * Displays a single CmsPageContact model.
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
     * Creates a new CmsPageContact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = new CmsPageContact();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;
        
        if (Yii::$app->request->isPost) {
            $model->wxopenid_file = UploadedFile::getInstance($model, 'wxopenid_file');
            if (($file = $model->uploadWxopenid($site_id))!=false) {
                $model->wxopenid = $file['src'];
            }
            
            $model->banner_file = UploadedFile::getInstance($model, 'banner_file');
            if (($file = $model->uploadBanner($site_id))!=false) {
                $model->banner = $file['src'];
            }
            
            $model->map_img_file = UploadedFile::getInstance($model, 'map_img_file');
            if (($file = $model->uploadMapImg($site_id))!=false) {
                $model->map_img = $file['src'];
            }
            
            if (isset($_POST['lnglat'])) {
                $lnglat = $_POST['lnglat'];
                if (!empty($lnglat)) {
                    $lnglat = explode(',', $lnglat);
                    if (is_array($lnglat) && count($lnglat) == 2) {
                        $model->longitude = $lnglat[0];
                        $model->latitude = $lnglat[1];
                    }
                }
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('page_contact_'.$site_id.'_'.$lang_id);
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsPageContact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = $this->findModel($id);
        if ($model->lang_id != $lang_id)
        {
            throw new NotFoundHttpException('404');
        }
        
        if (Yii::$app->request->isPost) {
            $model->wxopenid_file = UploadedFile::getInstance($model, 'wxopenid_file');
            if (($file = $model->uploadWxopenid($site_id))!=false) {
                UtilHelper::DeleteImg($model->wxopenid);
                $model->wxopenid = $file['src'];
            }
            
            $model->banner_file = UploadedFile::getInstance($model, 'banner_file');
            if (($file = $model->uploadBanner($site_id))!=false) {
                UtilHelper::DeleteImg($model->banner);
                $model->banner = $file['src'];
            }
            
            $model->map_img_file = UploadedFile::getInstance($model, 'map_img_file');
            if (($file = $model->uploadMapImg($site_id))!=false) {
                UtilHelper::DeleteImg($model->map_img);
                $model->map_img = $file['src'];
            }
            
            if (isset($_POST['lnglat'])) {
                $lnglat = $_POST['lnglat'];
                if (!empty($lnglat)) {
                    $lnglat = explode(',', $lnglat);
                    if (is_array($lnglat) && count($lnglat) == 2) {
                        $model->longitude = $lnglat[0];
                        $model->latitude = $lnglat[1];
                    }
                }
            }
        
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('page_contact_'.$site_id.'_'.$lang_id);
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Deletes an existing CmsPageContact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        CacheHelper::deleteCache('pages_'.$model->site_id.'_'.$model->lang_id);
        UtilHelper::DeleteImg($model->wxopenid);
        UtilHelper::DeleteImg($model->banner);
        $model->delete();
    }

    /**
     * Finds the CmsPageContact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsPageContact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsPageContact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
