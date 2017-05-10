<?php

namespace backend\controllers;

use Yii;
use common\models\CmsProductPic;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\models\CmsAlbum;
use common\helpers\DataHelper;
use common\models\UploadForm;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\filters\AccessControl;
use common\models\CmsProductSku;
use common\helpers\CacheHelper;

/**
 * CmsProductPicController implements the CRUD actions for CmsProductPic model.
 */
class CmsProductPicController extends Controller
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
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsProductPic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        if (!isset($_REQUEST['sku_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $sku = CmsProductSku::findOne($_REQUEST['sku_id']);
        if (!is_object($sku))
        {
            throw new NotFoundHttpException('404');
        }
        
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if (($files = $model->uploadMultiple($site_id, 'product/images')) != false) {
                foreach ($files as $f)
                {
                    $pic = new CmsProductPic();
                    $pic->site_id = $site_id;
                    $pic->lang_id = $lang_id;
                    $pic->product_id = $sku->product_id;
                    $pic->sku_id = $sku->id;
                    $pic->image = $f['src'];
                    $pic->save();
                }
                CacheHelper::deleteCache('product_'.$sku->product_id);
                return $this->redirect(['cms-product-pic/index','sku_id'=>$sku->id]);
            }
        }
        
        $pics = CmsProductPic::find()->where(['sku_id'=>$_REQUEST['sku_id']])->all();
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'pics' => $pics,
            'statusMap' => $statusMap,
            'sku' => $sku,
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing CmsProductPic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if (!isset($_REQUEST['id']))
        {
            return json_encode(['c'=>-1,'msg'=>\Yii::t('app', 'Error Params')]);
        }
        $model = $this->findModel($_REQUEST['id']);
        if (is_object($model))
        {
            UtilHelper::DeleteImg($model->image);
            CacheHelper::deleteCache('product_'.$model->product_id);
            
            $model->delete();
            return json_encode(['c'=>0]);
        }
        else
        {
            return json_encode(['c'=>-1,'msg'=>\Yii::t('app', 'Error Params')]);
        }
    }

    /**
     * Finds the CmsProductPic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsProductPic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsProductPic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
