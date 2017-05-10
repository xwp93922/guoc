<?php

namespace backend\controllers;

use backend\components\Controller;
use Yii;
use common\models\CmsPage;
use common\models\searchs\CmsPageSearch;
use yii\web\NotFoundHttpException;
use backend\helpers\SiteHelper;
use common\helpers\DataHelper;
use common\helpers\CacheHelper;
use common\helpers\UtilHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\helpers\CategoryHelper;

/**
 * PageController implements the CRUD actions for CmsPage model.
 */
class PageController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'upload'],
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
                    "imagePathFormat" => "/uploads/{$site_id}/page/images/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }

    /**
     * Lists all CmsPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $this->getView()->title = Yii::t('app', 'Page management');
        $searchModel = new CmsPageSearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $statusMap = DataHelper::getGeneralStatus();
        $pagetype=DataHelper::getPageType();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
        	'pagetype'	=>$pagetype
        ]);
    }

    /**
     * Displays a single CmsPage model.
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
     * Creates a new CmsPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        $parent =$parent =CategoryHelper::getSubPage($site_id, $lang_id,[],0,0,3);
        $pagetype=DataHelper::getPageType();
       
        $model = new CmsPage();       
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;
        
        if (Yii::$app->request->isPost) {
            $model->cover_file = UploadedFile::getInstance($model, 'cover_file');
            if (($file = $model->uploadCover($site_id))!=false) {
                $model->cover = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('pages_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        	'parent'  =>$parent,
        		'pagetype'	=>$pagetype,
        ]);
    }

    /**
     * Updates an existing CmsPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        $parent =CategoryHelper::getSubPage($site_id, $lang_id,[],0,0,3);
        $pagetype=DataHelper::getPageType();
        $model = $this->findModel($id);
        if ($model->lang_id != $lang_id)
        {
            throw new NotFoundHttpException('404');
        }
        if (Yii::$app->request->isPost) {
            $model->cover_file = UploadedFile::getInstance($model, 'cover_file');
            if (($file = $model->uploadCover($site_id))!=false) {
                UtilHelper::DeleteImg($model->cover);
                $model->cover = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('pages_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        	'parent'  =>$parent	,
        		'pagetype'	=>$pagetype,
        ]);
    }

    /**
     * Deletes an existing CmsPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        CacheHelper::deleteCache('pages_'.$model->site_id.'_'.$model->lang_id);
        UtilHelper::DeleteImg($model->cover);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
