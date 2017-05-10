<?php

namespace backend\controllers;

use Yii;
use common\models\CmsSite;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\UtilHelper;
use yii\web\UploadedFile;
use backend\helpers\SiteHelper;
use yii\filters\AccessControl;
use common\models\GhSite;
use yii\web\NotAcceptableHttpException;
use common\helpers\CacheHelper;

/**
 * CmsSiteController implements the CRUD actions for CmsSite model.
 */
class CmsSiteController extends Controller
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
                        'actions' => ['index', 'update', 'use-casecategory'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsSite models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = CmsSite::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        if (!is_object($model))
        {
            $model = new CmsSite();
            $model->site_id = $site_id;
            $model->lang_id = $lang_id;
            $model->save();
        }
        return $this->redirect(['cms-site/update','id'=>$model->id]);
    }

    /**
     * Updates an existing CmsSite model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $model = $this->findModel($id);

        $gh_site = GhSite::findOne($site_id);
        if (!is_object($gh_site))
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined site.'));
        }
        $model->host_name = $gh_site->host_name;

        if (Yii::$app->request->isPost) {
            $model->logo_file = UploadedFile::getInstance($model, 'logo_file');
            if (($file = $model->uploadLogo($site_id))!=false) {
                if (strpos($model->logo, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->logo);
                }
                $model->logo = $file['src'];
            }
            $model->footer_logo_file = UploadedFile::getInstance($model, 'footer_logo_file');
            if (($file = $model->uploadFooterLogo($site_id))!=false) {
                if (strpos($model->footer_logo, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->footer_logo);
                }
                $model->footer_logo = $file['src'];
            }
            $model->homepage_news_banner_file = UploadedFile::getInstance($model, 'homepage_news_banner_file');
            if (($file = $model->uploadHomePageBanner($site_id))!=false) {
                if (strpos($model->homepage_news_banner, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->homepage_news_banner);
                }
                $model->homepage_news_banner = $file['src'];
            }
            
            if (GhSite::find()->where('id!=:site_id',[':site_id'=>$site_id])->andWhere(['host_name'=>$model->host_name])->count()>0)
            {
                $model->addError('host_name',\Yii::t('app', 'Host name has exist.'));
            }
            else
            {
                if ($model->load(Yii::$app->request->post()) && $model->save())
                {
                    $gh_site->host_name = $model->host_name;
                    $gh_site->save();
                    
                    CacheHelper::deleteCache('site_id_'.$gh_site->host_name);
                    CacheHelper::deleteCache('siteConfig_'.$site_id);
                    CacheHelper::deleteCache('siteInfo_'.$site_id.'_'.$lang_id);
                    SiteHelper::setSiteId(Yii::$app->user->id);
                    
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the CmsSite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsSite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsSite::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
