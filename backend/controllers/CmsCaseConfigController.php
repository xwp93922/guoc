<?php

namespace backend\controllers;

use Yii;
use common\models\CmsCaseConfig;
use backend\components\Controller;
use yii\filters\AccessControl;
use common\helpers\UtilHelper;
use yii\web\UploadedFile;
use common\helpers\CacheHelper;

/**
 * CmsCaseConfigController implements the CRUD actions for CmsCaseConfig model.
 */
class CmsCaseConfigController extends Controller
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
                        'actions' => ['update', 'use-category'],
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
        
        $model = CmsCaseConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        if (!is_object($model))
        {
            $model = new CmsCaseConfig();
            $model->site_id = $site_id;
            $model->lang_id = $lang_id;
            $model->use_category = 0;
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
                CacheHelper::deleteCache('case_config_'.$site_id.'_'.$lang_id);
                return $this->redirect(['update']);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionUseCategory()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $model = CmsCaseConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        
        if (!is_object($model))
        {
            return json_encode(['c'=>1002,'msg'=>\Yii::t('app', 'Error Params')]);
        }
        $state = intval($_POST['state'],10);
        $model->use_category = $state;
        if ($model->save())
        {
            CacheHelper::deleteCache('case_config_'.$site_id.'_'.$lang_id);
            return json_encode(['c'=>0]);
        }
        else
        {
            return json_encode(['c'=>1003,'msg'=>json_encode($model->getFirstErrors())]);
        }
    }
}
