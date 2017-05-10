<?php

namespace backend\controllers;

use Yii;
use common\models\CmsAlbumConfig;
use backend\components\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use common\helpers\CacheHelper;

/**
 * CmsAlbumConfigController implements the CRUD actions for CmsAlbumConfig model.
 */
class CmsAlbumConfigController extends Controller
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
        
        $model = CmsAlbumConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        if (!is_object($model))
        {
            $model = new CmsAlbumConfig();
            $model->site_id = $site_id;
            $model->lang_id = $lang_id;
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
                CacheHelper::deleteCache('album_config_'.$site_id.'_'.$lang_id);
                return $this->redirect(['update']);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
