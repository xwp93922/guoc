<?php

namespace backend\controllers;

use Yii;
use common\models\CmsSiteLang;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\models\GhConfigLang;
use backend\helpers\SiteHelper;
use yii\helpers\ArrayHelper;
use common\helpers\CacheHelper;
use common\helpers\LangHelper;
use yii\filters\AccessControl;
use common\helpers\InitHelper;

/**
 * CmsSiteLangController implements the CRUD actions for CmsSiteLang model.
 */
class CmsSiteLangController extends Controller
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
                        'actions' => ['index', 'save-list', 'save-item', 'set-default'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsSiteLang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $cmsLangs = LangHelper::getCmsSiteLangCache($site_id);
        $langs = GhConfigLang::find()->where(['not in','id',CmsSiteLang::find()->select('lang_id')->where(['site_id'=>$site_id,'status'=>CmsSiteLang::STATUS_ACTIVE])])->orderBy('sort_val asc')->all();

        return $this->render('index', [
            'cmsLangs' => $cmsLangs,
            'langs' => $langs,
        ]);
    }
    
    public function actionSaveList()
    {
        if (Yii::$app->user->isGuest) {
            return json_encode(['c'=>1001,'msg'=>\Yii::t('app', 'No login')]);
        }
        
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        if (isset($_POST['itemList']))
        {
            $itemList = $_POST['itemList'];
            $count = count($itemList);
            $myLangs = ArrayHelper::map(LangHelper::getCmsSiteLangCache($site_id), 'lang_id', 'id');
            
            $newLangIds = [];
            for ($i=0;$i<$count;$i++)
            {
                if (!empty($itemList[$i]['cms_lang_id']))
                {
                    $model = CmsSiteLang::findOne($itemList[$i]['cms_lang_id']);
                    if (is_object($model))
                    {
                        $model->sort_val = $i;
                        $model->save();
                    }
                }
                else
                {
                    $model = CmsSiteLang::find()->where(['site_id'=>$site_id,'lang_id'=>$itemList[$i]['lang_id']])->one();
                    if (!is_object($model))
                    {
                        $model = new CmsSiteLang();
                        $model->site_id = $site_id;
                        $model->lang_id = $itemList[$i]['lang_id'];
                        $model->name = $itemList[$i]['name'];
                        $model->flag = $itemList[$i]['flag'];
                    }
                    $model->status = CmsSiteLang::STATUS_ACTIVE;
                    $model->sort_val = $i;
                    $model->save();
                }
                $newLangIds[] = $model->lang_id;
            }
            
            $deleteIds = [];
            foreach ($myLangs as $key=>$val)
            {
                if (!in_array($key, $newLangIds))
                {
                    $deleteIds[] = $val;
                }
            }
            
            CmsSiteLang::updateAll(['status'=>CmsSiteLang::STATUS_DELETED],['in','id',$deleteIds]);
            CacheHelper::deleteCache('cms_langs_'.$site_id);
            CacheHelper::deleteCache('currentLang_'.$site_id);
            
            if (in_array(SiteHelper::getLangId(), $deleteIds))
            {
                SiteHelper::setLangId();
            }
        }
        
        return json_encode(['c'=>0,'msg'=>\Yii::t('app', 'Save success, please wait <span class="timer">2</span> seconds...')]);
    }
    
    public function actionSaveItem()
    {
        if (Yii::$app->user->isGuest) {
            return json_encode(['c'=>1001,'msg'=>\Yii::t('app', 'No login')]);
        }
    
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
    
        if (isset($_POST['id']) && isset($_POST['name']))
        {
            $model = CmsSiteLang::findOne($_POST['id']);
            if (is_object($model))
            {
                $model->name = $_POST['name'];
                $model->save();
                CacheHelper::deleteCache('cms_langs_'.$site_id);
                CacheHelper::deleteCache('currentLang_'.$site_id);
                
                if (SiteHelper::getLangId() == $_POST['id'])
                {
                    SiteHelper::setLangId();
                }
            }
        }
        
    
        return json_encode(['c'=>0,'msg'=>\Yii::t('app', 'Save success, please wait 2 seconds...')]);
    }
    
    public function actionSetDefault()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        $request = Yii::$app->request;
        $id = $request->get('id','');
        if (empty($id))
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        SiteHelper::setLangId($id);
        CacheHelper::deleteCache('cms_langs_'.$site_id);
        CacheHelper::deleteCache('currentLang_'.$site_id);
        InitHelper::initThemeData();
        
        return $this->redirect(['site/index']);
    }

    /**
     * Finds the CmsSiteLang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsSiteLang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsSiteLang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
