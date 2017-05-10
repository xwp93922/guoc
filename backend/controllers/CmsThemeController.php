<?php

namespace backend\controllers;

use Yii;
use common\models\CmsTheme;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use backend\helpers\SiteHelper;
use common\helpers\DataHelper;
use common\models\GhTheme;
use common\helpers\CacheHelper;
use common\helpers\ThemeHelper;
use yii\filters\AccessControl;
use common\helpers\InitHelper;

/**
 * CmsThemeController implements the CRUD actions for CmsTheme model.
 */
class CmsThemeController extends Controller
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
                        'actions' => ['index', 'more', 'buy', 'use', 'set-theme', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsTheme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $statusMap = DataHelper::getGeneralStatus();
        
        $themes = ThemeHelper::getSiteThemes($site_id);
        return $this->render('index', [
            'themes' => $themes,
        ]);
    }
    
    public function actionMore()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $themes = GhTheme::find()->where(['status'=>GhTheme::STATUS_ACTIVE])->andWhere(['not in','id',CmsTheme::find()->select('theme_id')->where(['site_id'=>$site_id])])->orderBy('sort_val asc')->asArray()->all();
        return $this->render('more', [
            'themes' => $themes,
        ]);
    }
    
    public function actionBuy($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        if (CmsTheme::find()->where(['theme_id'=>$id])->count() == 0)
        {
            
            $model = new CmsTheme();
            $model->site_id = $site_id;
            $model->theme_id = $id;
            $model->save();
        }
        
        CacheHelper::deleteCache('cms_theme_'.$site_id);
        CacheHelper::deleteCache('currentTheme_'.$site_id);
        return $this->redirect(['index']);
    }
    
    public function actionUse($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $model = CmsTheme::findOne($id);
        if (is_object($model))
        {
            CmsTheme::updateAll(['status'=>CmsTheme::STATUS_ACTIVE],'site_id=:site_id',[':site_id'=>$site_id]);
            $model->status = CmsTheme::STATUS_USED;
            $model->save();
        }
        CacheHelper::deleteCache('cms_theme_'.$site_id);
        CacheHelper::deleteCache('currentTheme_'.$site_id);
        
        SiteHelper::setThemeId($model->theme_id);
        InitHelper::initThemeData();
        
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing CmsTheme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsTheme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsTheme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsTheme::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
