<?php

namespace backend\controllers;

use Yii;
use common\models\CmsBanner;
use common\models\searchs\CmsBannerSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use yii\filters\AccessControl;

/**
 * BannerController implements the CRUD actions for CmsBanner model.
 */
class BannerController extends Controller
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
     * Lists all CmsBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $this->getView()->title = Yii::t('app', 'Banner management');
        
        $searchModel = new CmsBannerSearch();
        $searchModel->site_id = $site_id;
        $searchModel->lang_id = $lang_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $statusMap = DataHelper::getGeneralStatus();
        $posMap = DataHelper::getBannerPosMap();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
            'posMap' => $posMap,
        ]);
    }

    /**
     * Displays a single CmsBanner model.
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
     * Creates a new CmsBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        $posMap = DataHelper::getBannerPosMap();
        
        $model = new CmsBanner();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;

        if ($model->load(Yii::$app->request->post())) {
            if (count($_POST['CmsBanner']['pos']) > 0)
            {
                $model->pos = ','.implode(',', $_POST['CmsBanner']['pos']).',';
            }
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
            'posMap' => $posMap
        ]);
    }

    /**
     * Updates an existing CmsBanner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        $posMap = DataHelper::getBannerPosMap();
        
        $model = $this->findModel($id);
        if ($model->lang_id != $lang_id)
        {
            throw new NotFoundHttpException('404');
        }

        if ($model->load(Yii::$app->request->post())) {
            if (count($_POST['CmsBanner']['pos']) > 0)
            {
                $model->pos = ','.implode(',', $_POST['CmsBanner']['pos']).',';
            }
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
            return $this->redirect(['index']);
        }
        $model->pos = explode(',', substr($model->pos, 1, -1));
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
            'posMap' => $posMap
        ]);
    }

    /**
     * Deletes an existing CmsBanner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->necessary == 0)
        {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
