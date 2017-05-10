<?php

namespace backend\controllers;

use Yii;
use common\models\CmsServiceConfig;
use backend\components\Controller;
use yii\filters\AccessControl;
use common\helpers\CacheHelper;

/**
 * CmsServiceConfigController implements the CRUD actions for CmsServiceConfig model.
 */
class CmsServiceConfigController extends Controller
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
        
        $model = CmsServiceConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        if (!is_object($model))
        {
            $model = new CmsServiceConfig();
            $model->site_id = $site_id;
            $model->lang_id = $lang_id;
            $model->save();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            CacheHelper::deleteCache('service_config_'.$site_id.'_'.$lang_id);
            return $this->redirect(['update']);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
