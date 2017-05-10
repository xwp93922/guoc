<?php

namespace backend\controllers;

use Yii;
use common\models\CmsService;
use common\models\searchs\CmsServiceSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\filters\AccessControl;
use backend\helpers\SiteHelper;


/**
 * CmsServiceController implements the CRUD actions for CmsService model.
 */
class CmsServiceController extends Controller
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
     * Lists all CmsService models.
     * @return mixed
     */
    
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
    
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $searchModel = new CmsServiceSearch();
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
     * Displays a single CmsService model.
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
     * Creates a new CmsService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = new CmsService();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;
        $statusMap = DataHelper::getGeneralStatus();
        
        if (Yii::$app->request->isPost) {
            $model->cover_file = UploadedFile::getInstance($model, 'cover_file');
            if (($file = $model->uploadCover($site_id))!=false) {
                $model->cover = $file['src'];
            }
            $model->cover_hover_file = UploadedFile::getInstance($model, 'cover_hover_file');
            if (($file = $model->uploadCoverHover($site_id))!=false) {
            	$model->cover_hover = $file['src'];
            }
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsService model.
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
                if (strpos($model->cover, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->cover);
                }
                $model->cover = $file['src'];
            }
            $model->cover_hover_file = UploadedFile::getInstance($model, 'cover_hover_file');
            if (($file = $model->uploadCoverHover($site_id))!=false) {
            	if (strpos($model->cover_hover, 'default') === false)
            	{
            		UtilHelper::DeleteImg($model->cover_hover);
            	}
            	$model->cover_hover = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Deletes an existing CmsService model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (strpos($model->cover, 'default') === false)
        {
            UtilHelper::DeleteImg($model->cover);
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsService::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
