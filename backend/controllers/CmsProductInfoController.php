<?php

namespace backend\controllers;

use Yii;
use common\models\CmsProductInfo;
use common\models\searchs\CmsProductInfoSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\helpers\ProductHelper;
use common\helpers\DataHelper;
use yii\web\UploadedFile;
use common\helpers\CacheHelper;
use common\helpers\UtilHelper;
use backend\helpers\SiteHelper;
use common\models\CmsProductPic;
use common\models\CmsProductSku;

/**
 * CmsProductInfoController implements the CRUD actions for CmsProductInfo model.
 */
class CmsProductInfoController extends Controller
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
     * Lists all CmsProductInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $searchModel = new CmsProductInfoSearch();
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
     * Displays a single CmsProductInfo model.
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
     * Creates a new CmsProductInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $categoryOptions = ProductHelper::getCategoryOptions($site_id,$lang_id);
        $statusMap = DataHelper::getGeneralStatus();
        
        $model = new CmsProductInfo();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;
        
        if (Yii::$app->request->isPost) {
            $model->product_cover_file = UploadedFile::getInstance($model, 'product_cover_file');
            if (($file = $model->uploadProductCover($site_id))!=false) {
                $model->product_cover = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('product_'.$model->id);
                CacheHelper::deleteCache('product_recommend_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        
        $config = ProductHelper::getProductConfigCache($site_id, $lang_id);
        $config = explode(',', $config['product_field']);
        $product_info = [];
        foreach ($config as $c)
        {
            $product_info[$c] = '';
        }
        $model->product_info = $product_info;
        
        return $this->render('create', [
            'model' => $model,
            'categoryOptions' => $categoryOptions,
            'statusMap' => $statusMap
         ]);
    }

    /**
     * Updates an existing CmsProductInfo model.
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
            $model->product_cover_file = UploadedFile::getInstance($model, 'product_cover_file');
            if (($file = $model->uploadProductCover($site_id))!=false) {
                if (strpos($model->product_cover, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->product_cover);
                }
                $model->product_cover = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('product_'.$model->id);
                CacheHelper::deleteCache('product_recommend_'.$site_id.'_'.$lang_id);
                return $this->redirect(['index']);
            }
        }
        
        $now_info = [];
        if (!empty($model->product_info))
        {
            $now_info = json_decode($model->product_info, true);
        }
        
        $config = ProductHelper::getProductConfigCache($site_id, $lang_id);
        $config = explode(',', $config['product_field']);
        $product_info = [];
        foreach ($config as $c)
        {
            if (isset($now_info[$c]))
            {
                $product_info[$c] = $now_info[$c];
            }
            else 
            {
                $product_info[$c] = '';
            }
        }
        $model->product_info = $product_info;
        
        return $this->render('update', [
            'model' => $model,
            'categoryOptions' => $categoryOptions,
            'statusMap' => $statusMap
        ]);
    }

    /**
     * Deletes an existing CmsProductInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (strpos($model->product_cover, 'default') === false)
        {
            UtilHelper::DeleteImg($model->product_cover);
        }
        
        $skus = CmsProductSku::find()->where(['product_id'=>$id])->all();
        foreach ($skus as $s)
        {
            UtilHelper::DeleteImg($s->pic);
            $s->delete();
        }
        
        $pics = CmsProductPic::find()->where(['product_id'=>$id])->all();
        foreach ($pics as $p)
        {
            UtilHelper::DeleteImg($p->image);
            $p->delete();
        }

        CacheHelper::deleteCache('product_'.$model->id);
        CacheHelper::deleteCache('product_recommend_'.$model->site_id.'_'.$model->lang_id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsProductInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsProductInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsProductInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
