<?php

namespace backend\controllers;

use Yii;
use common\models\CmsCaseCategory;
use common\models\searchs\CmsCaseCategorySearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use common\helpers\CaseCategoryHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\web\NotAcceptableHttpException;
use yii\filters\AccessControl;
use common\models\CmsCaseConfig;
use common\helpers\CacheHelper;

/**
 * CaseCategoryController implements the CRUD actions for CmsCaseCategory model.
 */
class CaseCategoryController extends Controller
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
     * Lists all CmsCaseCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $caseConfig = CaseCategoryHelper::getCaseConfigCache($site_id, $lang_id);
        $use_case_category = !empty($caseConfig) ? $caseConfig['use_category'] : 0;
        
        $searchModel = new CmsCaseCategorySearch();
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
            'categoryOptions' => $categoryOptions,
            'use_case_category' => $use_case_category
        ]);
    }

    /**
     * Displays a single CmsCaseCategory model.
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
     * Creates a new CmsCaseCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $caseConfig = CaseCategoryHelper::getCaseConfigCache($site_id, $lang_id);
        $use_case_category = !empty($caseConfig) ? $caseConfig['use_category'] : 0;
        if ($use_case_category == 0)
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Case Category is not opened.'));
        }
        $categoryOptions = CaseCategoryHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = new CmsCaseCategory();
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
                CaseCategoryHelper::deleteCache($site_id,$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'categoryOptions' => $categoryOptions,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsCaseCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $caseConfig = CaseCategoryHelper::getCaseConfigCache($site_id, $lang_id);
        $use_case_category = !empty($caseConfig) ? $caseConfig['use_category'] : 0;
        if ($use_case_category == 0)
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Case Category is not opened.'));
        }
        $categoryOptions = CaseCategoryHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = $this->findModel($id);
        if ($model->lang_id != $lang_id)
        {
            throw new NotFoundHttpException('404');
        }
        
        if (Yii::$app->request->isPost) {
            $model->image_main_file = UploadedFile::getInstance($model, 'image_main_file');
            if (($file = $model->uploadImageMain($site_id))!=false) {
                UtilHelper::DeleteImg($model->image_main);
                $model->image_main = $file['src'];
            }
            $model->image_node_file = UploadedFile::getInstance($model, 'image_node_file');
            if (($file = $model->uploadImageNode($site_id))!=false) {
                UtilHelper::DeleteImg($model->image_node);
                $model->image_node = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CaseCategoryHelper::deleteCache($site_id,$lang_id);
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'categoryOptions' => $categoryOptions,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Deletes an existing CmsCaseCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $caseConfig = CaseCategoryHelper::getCaseConfigCache($model->site_id, $model->lang_id);
        $use_case_category = !empty($caseConfig) ? $caseConfig['use_category'] : 0;
        if ($use_case_category == 0)
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Case Category is not opened.'));
        }
        CaseCategoryHelper::deleteCache($model->site_id,$model->lang_id);
        UtilHelper::DeleteImg($model->image_main);
        UtilHelper::DeleteImg($model->image_node);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsCaseCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsCaseCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsCaseCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
