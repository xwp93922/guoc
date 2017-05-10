<?php

namespace backend\controllers;

use Yii;
use common\models\CmsProductConfig;
use backend\components\Controller;
use yii\filters\AccessControl;
use common\helpers\CacheHelper;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;

/**
 * CmsProductConfigController implements the CRUD actions for CmsProductConfig model.
 */
class CmsProductConfigController extends Controller
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
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionUpdate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = CmsProductConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        if (!is_object($model))
        {
            $model = new CmsProductConfig();
            $model->site_id = $site_id;
            $model->lang_id = $lang_id;
            $model->product_field = 'name,description';
            $model->inquiry_field = json_encode([
                ['label'=>'name','type'=>'input-text','required'=>1,'maxlength'=>'20'],
                ['label'=>'phone','type'=>'input-text','rule'=>'phone','required'=>1],
                ['label'=>'email','type'=>'input-text','rule'=>'email','required'=>1],
                ['label'=>'address','type'=>'input-text','maxlength'=>'200'],
                ['label'=>'content','type'=>'textarea','maxlength'=>'200'],
            ]);
            $model->inquiry_email = 'example@example.com';
            $model->save();
        }
        
        if (Yii::$app->request->isPost) {
            $model->top_banner_file = UploadedFile::getInstance($model, 'top_banner_file');
            if (($file = $model->uploadTopBanner($site_id))!=false) {
                if (strpos($model->top_banner, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->top_banner);
                }
                $model->top_banner = $file['src'];
            }
        
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                CacheHelper::deleteCache('product_config_'.$site_id.'_'.$lang_id);
                return $this->redirect(['update']);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
