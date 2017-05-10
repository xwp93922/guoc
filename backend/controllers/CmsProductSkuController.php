<?php

namespace backend\controllers;

use Yii;
use common\models\CmsProductSku;
use common\models\CmsProductSkuSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\CmsProductInfo;
use common\helpers\DataHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use common\helpers\CacheHelper;
use common\models\CmsProductPic;

/**
 * CmsProductSkuController implements the CRUD actions for CmsProductSku model.
 */
class CmsProductSkuController extends Controller
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

    /**
     * Lists all CmsProductSku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        if (!isset($_REQUEST['product_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $product = CmsProductInfo::findOne($_REQUEST['product_id']);
        if (!is_object($product))
        {
            throw new NotFoundHttpException('404');
        }
        $searchModel = new CmsProductSkuSearch();
        $searchModel->product_id = $_REQUEST['product_id'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Displays a single CmsProductSku model.
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
     * Creates a new CmsProductSku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!isset($_REQUEST['product_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $product = CmsProductInfo::findOne($_REQUEST['product_id']);
        if (!is_object($product))
        {
            throw new NotFoundHttpException('404');
        }
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = new CmsProductSku();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->product_id = $_REQUEST['product_id'];
        $model->sort_val = 10;
        $statusMap = DataHelper::getGeneralStatus();

        if (Yii::$app->request->isPost) {
            $model->pic_file = UploadedFile::getInstance($model, 'pic_file');
            if (($file = $model->uploadPic($site_id))!=false) {
                $model->pic = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('product_'.$model->product_id);
                return $this->redirect(['cms-product-sku/index','product_id'=>$model->product_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsProductSku model.
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
            $model->pic_file = UploadedFile::getInstance($model, 'pic_file');
            if (($file = $model->uploadPic($site_id))!=false) {
                UtilHelper::DeleteImg($model->pic);
                $model->pic = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('product_'.$model->product_id);
                return $this->redirect(['cms-product-sku/index','product_id'=>$model->product_id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Deletes an existing CmsProductSku model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        UtilHelper::DeleteImg($model->pic);
        $pics = CmsProductPic::find()->where(['sku_id'=>$id])->all();
        foreach ($pics as $p)
        {
            UtilHelper::DeleteImg($p->image);
            $p->delete();
        }
        CacheHelper::deleteCache('product_'.$model->product_id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsProductSku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsProductSku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsProductSku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
