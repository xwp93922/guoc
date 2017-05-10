<?php

namespace backend\controllers;

use Yii;
use common\models\CmsPageAbout;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use common\helpers\CacheHelper;
use backend\helpers\SiteHelper;
use common\models\CmsAboutTeam;
use common\models\CmsAboutTimeline;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;

/**
 * PageAboutController implements the CRUD actions for CmsPageAbout model.
 */
class PageAboutController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'other', 'delete', 'upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        $site_id = SiteHelper::getSiteId();
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    //"imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                    "imagePathFormat" => "/uploads/{$site_id}/ueditor/images/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }

    /**
     * Lists all CmsPageAbout models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = CmsPageAbout::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        if (is_object($model))
        {
            return $this->redirect(['page-about/update','id'=>$model->id]);
        }
        else
        {
            return $this->redirect(['page-about/create']);
        }
    }

    /**
     * Displays a single CmsPageAbout model.
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
     * Creates a new CmsPageAbout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = new CmsPageAbout();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;

        if (Yii::$app->request->isPost) {
            $model->banner_file = UploadedFile::getInstance($model, 'banner_file');
            if (($file = $model->uploadBanner($site_id))!=false) {
                $model->banner = $file['src'];
            }
            $model->homepage_left_pic_file = UploadedFile::getInstance($model, 'homepage_left_pic_file');
            if (($file = $model->uploadLeftPic($site_id))!=false) {
                $model->homepage_left_pic = $file['src'];
            }
        
            if ($model->load(Yii::$app->request->post()))
            {
                if ($model->save())
                {
                    CacheHelper::deleteCache('page_about_'.$site_id.'_'.$lang_id);
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsPageAbout model.
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
            $model->banner_file = UploadedFile::getInstance($model, 'banner_file');
            if (($file = $model->uploadBanner($site_id))!=false) {
                UtilHelper::DeleteImg($model->banner);
                $model->banner = $file['src'];
            }
            
            $model->homepage_left_pic_file = UploadedFile::getInstance($model, 'homepage_left_pic_file');
            if (($file = $model->uploadLeftPic($site_id))!=false) {
                UtilHelper::DeleteImg($model->homepage_left_pic);
                $model->homepage_left_pic = $file['src'];
            }
        
            if ($model->load(Yii::$app->request->post()))
            {
                if ($model->save())
                {
                    CacheHelper::deleteCache('page_about_'.$site_id.'_'.$lang_id);
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }
    
    public function actionOther()
    {
        if (!isset($_REQUEST['about_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $about_id = intval($_REQUEST['about_id'],10);
        $about = CmsPageAbout::findOne($about_id);
        
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
    
        $teams = CmsAboutTeam::find()->where(['about_id'=>$about_id])->orderBy('sort_val asc')->all();
        $timelines = CmsAboutTimeline::find()->where(['about_id'=>$about_id])->orderBy('date asc')->all();
        
        return $this->render('other', [
            'teams' => $teams,
            'timelines'=>$timelines,
            'about_id' => $about_id
        ]);
    }

    /**
     * Deletes an existing CmsPageAbout model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        CacheHelper::deleteCache('pages_'.$model->site_id.'_'.$model->lang_id);
        UtilHelper::DeleteImg($model->banner);
        $model->delete();
    }

    /**
     * Finds the CmsPageAbout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsPageAbout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsPageAbout::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
