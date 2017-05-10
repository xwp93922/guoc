<?php

namespace backend\controllers;

use Yii;
use common\models\CmsBannerPic;
use common\models\searchs\CmsBannerPicSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use common\helpers\UtilHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * CmsBannerPicController implements the CRUD actions for CmsBannerPic model.
 */
class CmsBannerPicController extends Controller
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
     * Lists all CmsBannerPic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsBannerPicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap
        ]);
    }

    /**
     * Displays a single CmsBannerPic model.
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
     * Creates a new CmsBannerPic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($banner_id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $model = new CmsBannerPic();
        $model->banner_id = $banner_id;
        $model->sort_val = 10;
        $statusMap = DataHelper::getGeneralStatus();

        if (Yii::$app->request->isPost) {
            $model->image_file = UploadedFile::getInstance($model, 'image_file');
            if (($file = $model->uploadImage($site_id))!=false) {
                $model->image = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index','CmsBannerPicSearch[banner_id]'=>$model->banner_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap
        ]);
    }

    /**
     * Updates an existing CmsBannerPic model.
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
            $model->image_file = UploadedFile::getInstance($model, 'image_file');
            if (($file = $model->uploadImage($site_id))!=false) {
                if (strpos($model->image, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->image);
                }
                $model->image = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index','CmsBannerPicSearch[banner_id]'=>$model->banner_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap
        ]);
    }

    /**
     * Deletes an existing CmsBannerPic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (strpos($model->image, 'default') === false)
        {
            UtilHelper::DeleteImg($model->image);
        }
        
        $model->delete();
    }

    /**
     * Finds the CmsBannerPic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsBannerPic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsBannerPic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
