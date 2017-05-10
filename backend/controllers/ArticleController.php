<?php

namespace backend\controllers;

use backend\components\Controller;
use Yii;
use common\models\CmsArticle;
use common\models\searchs\CmsArticleSearch;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use common\helpers\CategoryHelper;
use common\helpers\UtilHelper;
use yii\web\UploadedFile;
use backend\helpers\SiteHelper;
use yii\filters\AccessControl;

/**
 * ArticleController implements the CRUD actions for CmsArticle model.
 */
class ArticleController extends Controller
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
     * Lists all CmsArticle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $this->getView()->title = Yii::t('app', 'Article management');
        
        $searchModel = new CmsArticleSearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $categoryMap = CategoryHelper::getCategoryMap($site_id,$lang_id);
        $categoryOptions = CategoryHelper::getCategoryOptions($site_id,$lang_id);
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
     * Displays a single CmsArticle model.
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
     * Creates a new CmsArticle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $categoryOptions = CategoryHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = new CmsArticle();
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
     * Updates an existing CmsArticle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $categoryOptions = CategoryHelper::getCategoryOptions($site_id,$lang_id);
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
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'categoryOptions' => $categoryOptions,
            'statusMap' => $statusMap
        ]);
    }

    /**
     * Deletes an existing CmsArticle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        UtilHelper::DeleteImg($model->image_main);
        UtilHelper::DeleteImg($model->image_node);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsArticle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsArticle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
