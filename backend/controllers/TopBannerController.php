<?php

namespace backend\controllers;

use Yii;
use common\models\CmsTopBanner;
use common\models\searchs\CmsTopBannerSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\helpers\DataHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;

/**
 * TopBannerController implements the CRUD actions for CmsTopBanner model.
 */
class TopBannerController extends Controller
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
     * Lists all CmsTopBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $this->getView()->title = Yii::t('app', 'Banner management');
        
        $searchModel = new CmsTopBannerSearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $statusMap = DataHelper::getGeneralStatus();
        $posMap = DataHelper::getTopBannerPosMap();
        if (!empty($searchModel->pos) && isset($posMap[$searchModel->pos]))
        {
            $model = CmsTopBanner::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'pos'=>$searchModel->pos])->one();
            if (is_object($model))
            {
                return $this->redirect(['update','id'=>$model->id]);
            }
            else
            {
                return $this->redirect(['create','pos'=>$searchModel->pos]);
            }
        }
        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
            'posMap' => $posMap,
        ]);
    }

    /**
     * Displays a single CmsTopBanner model.
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
     * Creates a new CmsTopBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        $posMap = DataHelper::getTopBannerPosMap();
        
        $pos = isset($_REQUEST['pos']) ? $_REQUEST['pos'] : '';
        
        $model = CmsTopBanner::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'pos'=>$pos])->one();
        if (is_object($model))
        {
            return $this->redirect(['update','id'=>$model->id]);
        }
        
        $model = new CmsTopBanner();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->pos = $pos;

        if (Yii::$app->request->isPost) {
            $model->pic_file = UploadedFile::getInstance($model, 'pic_file');
            if (($file = $model->uploadPic($site_id))!=false) {
                $model->pic = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index','CmsTopBannerSearch[pos]'=>$model->pos]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
            'posMap' => $posMap
        ]);
    }

    /**
     * Updates an existing CmsTopBanner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        $posMap = DataHelper::getTopBannerPosMap();
        
        $model = $this->findModel($id);
        if ($model->lang_id != $lang_id)
        {
            throw new NotFoundHttpException('404');
        }

        if (Yii::$app->request->isPost) {
            $model->pic_file = UploadedFile::getInstance($model, 'pic_file');
            if (($file = $model->uploadPic($site_id))!=false) {
                UtilHelper::DeleteImg($model->pic);
                $model->pic = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index','CmsTopBannerSearch[pos]'=>$model->pos]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
            'posMap' => $posMap
        ]);
    }

    /**
     * Deletes an existing CmsTopBanner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        UtilHelper::DeleteImg($model->pic);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsTopBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsTopBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsTopBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
