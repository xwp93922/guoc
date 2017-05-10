<?php

namespace backend\controllers;

use Yii;
use common\models\CmsAboutTeam;
use common\models\searchs\CmsAboutTeamSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use common\models\CmsPageAbout;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\filters\AccessControl;

/**
 * AboutTeamController implements the CRUD actions for CmsAboutTeam model.
 */
class AboutTeamController extends Controller
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
     * Lists all CmsAboutTeam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        if (!isset($_REQUEST['about_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $about = CmsPageAbout::findOne($_REQUEST['about_id']);
        if (!is_object($about))
        {
            throw new NotFoundHttpException('404');
        }
        $searchModel = new CmsAboutTeamSearch();
        $searchModel->about_id = $_REQUEST['about_id'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Displays a single CmsAboutTeam model.
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
     * Creates a new CmsAboutTeam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!isset($_REQUEST['about_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $about = CmsPageAbout::findOne($_REQUEST['about_id']);
        if (!is_object($about))
        {
            throw new NotFoundHttpException('404');
        }
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = new CmsAboutTeam();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->about_id = $_REQUEST['about_id'];
        $model->sort_val = 10;
        $statusMap = DataHelper::getGeneralStatus();

        if (Yii::$app->request->isPost) {
            $model->headnode_file = UploadedFile::getInstance($model, 'headnode_file');
            if (($file = $model->uploadHeadnode($site_id))!=false) {
                $model->headnode = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['page-about/other','about_id'=>$model->about_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsAboutTeam model.
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
            $model->headnode_file = UploadedFile::getInstance($model, 'headnode_file');
            if (($file = $model->uploadHeadnode($site_id))!=false) {
                UtilHelper::DeleteImg($model->headnode);
                $model->headnode = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['page-about/other','about_id'=>$model->about_id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Deletes an existing CmsAboutTeam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        UtilHelper::DeleteImg($model->headnode);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsAboutTeam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsAboutTeam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsAboutTeam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
