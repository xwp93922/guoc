<?php

namespace backend\controllers;

use Yii;
use common\models\CmsProductCategory;
use common\models\searchs\CmsProductCategorySearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\ProductHelper;
use common\helpers\DataHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\filters\AccessControl;

/**
 * CmsProductCategoryController implements the CRUD actions for CmsProductCategory model.
 */
class CmsProductCategoryController extends Controller
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
     * Lists all CmsProductCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $searchModel = new CmsProductCategorySearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $categoryMap = ProductHelper::getCategoryMap($site_id,$lang_id);
        $categoryOptions = ProductHelper::getCategoryOptions($site_id,$lang_id);
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
     * Displays a single CmsProductCategory model.
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
     * Creates a new CmsProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $categoryOptions = ProductHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = new CmsProductCategory();
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
                ProductHelper::deleteCache($site_id,$lang_id);
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
     * Updates an existing CmsProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];

        $categoryOptions = ProductHelper::getCategoryOptions($site_id,$lang_id);
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
                ProductHelper::deleteCache($site_id,$lang_id);
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
     * Deletes an existing CmsProductCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        ProductHelper::deleteCache($model->site_id,$model->lang_id);
        UtilHelper::DeleteImg($model->image_main);
        UtilHelper::DeleteImg($model->image_node);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsProductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
