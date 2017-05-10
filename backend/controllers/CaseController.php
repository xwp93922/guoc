<?php

namespace backend\controllers;

use Yii;
use common\models\CmsCase;
use common\models\searchs\CmsCaseSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\CaseCategoryHelper;
use common\helpers\DataHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use common\helpers\CacheHelper;
use backend\helpers\SiteHelper;
use yii\filters\AccessControl;

/**
 * CaseController implements the CRUD actions for CmsCase model.
 */
class CaseController extends Controller
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
                    "imagePathFormat" => "/uploads/{$site_id}/ueditor/images/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }

    /**
     * Lists all CmsCase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $searchModel = new CmsCaseSearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $categoryMap = CaseCategoryHelper::getCategoryMap($site_id,$lang_id);
        $categoryOptions = CaseCategoryHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryMap' => $categoryMap,
            'statusMap' => $statusMap,
            'categoryOptions' => $categoryOptions
        ]);
    }

    /**
     * Displays a single CmsCase model.
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
     * Creates a new CmsCase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $categoryOptions = CaseCategoryHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();
        $caseConfig = CaseCategoryHelper::getCaseConfigCache($site_id, $lang_id);
        $use_case_category = !empty($caseConfig) ? $caseConfig['use_category'] : 0;
        
        $model = new CmsCase();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;
        
        if (Yii::$app->request->isPost) {
            $model->image_main_file = UploadedFile::getInstance($model, 'image_main_file');
            if (($file = $model->uploadImageMain($site_id))!=false) {
                $model->image_main = $file['src'];
            }
            $model->image_node_file = UploadedFile::getInstance($model, 'image_node_file');
            if (($file = $model->uploadImageNode($site_id))!=false) {
                $model->image_node = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('case_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'categoryOptions' => $categoryOptions,
            'statusMap' => $statusMap,
			'use_case_category' => $use_case_category
         ]);
    }

    /**
     * Updates an existing CmsCase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $categoryOptions = CaseCategoryHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();
        $caseConfig = CaseCategoryHelper::getCaseConfigCache($site_id, $lang_id);
        $use_case_category = !empty($caseConfig) ? $caseConfig['use_category'] : 0;
        
        $model = $this->findModel($id);
        if ($model->lang_id != $lang_id)
        {
            throw new NotFoundHttpException('404');
        }

        if (Yii::$app->request->isPost) {
            $model->image_main_file = UploadedFile::getInstance($model, 'image_main_file');
            if (($file = $model->uploadImageMain($site_id))!=false) {
                if (strpos($model->image_main, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->image_main);
                }
                $model->image_main = $file['src'];
            }
            $model->image_node_file = UploadedFile::getInstance($model, 'image_node_file');
            if (($file = $model->uploadImageNode($site_id))!=false) {
                if (strpos($model->image_node, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->image_node);
                }
                $model->image_node = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('case_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'categoryOptions' => $categoryOptions,
            'statusMap' => $statusMap,
			'use_case_category' => $use_case_category
        ]);
    }

    /**
     * Deletes an existing CmsCase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (strpos($model->image_main, 'default') === false)
        {
            UtilHelper::DeleteImg($model->image_main);
        }
        if (strpos($model->image_node, 'default') === false)
        {
            UtilHelper::DeleteImg($model->image_node);
        }
        $model->delete();
        CacheHelper::deleteCache('case_'.$model->site_id.'_'.$model->lang_id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsCase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsCase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsCase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
