<?php

namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\models\CmsNav;
use common\helpers\CacheHelper;
use common\helpers\DataHelper;
use common\models\CmsPage;
use common\helpers\NavHelper;
use common\models\CmsPageContact;
use common\helpers\CategoryHelper;
use common\models\CmsPageAbout;
use common\models\CmsAlbum;
use common\models\CmsCase;
use yii\filters\AccessControl;
use common\helpers\ThemeHelper;
use common\helpers\ProductHelper;

/**
 * CmsNavController implements the CRUD actions for CmsNav model.
 */
class NavController extends Controller
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
                        'actions' => ['index', 'save', 'save-link', 'delete-link'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsNav models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $this->getView()->title = Yii::t('app', 'Nav management');
        $topCategorys = $topCategorys = CategoryHelper::getTopCategorys($site_id,$lang_id);
        
        $pages = CacheHelper::getQueryList('pages_'.$site_id.'_'.$lang_id, CmsPage::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsPage::STATUS_ACTIVE])->orderBy('sort_val asc'));
        $page_contact = CacheHelper::getQueryList('page_contact_'.$site_id.'_'.$lang_id, CmsPageContact::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsPageContact::STATUS_ACTIVE]));
        $page_about = CacheHelper::getQueryList('page_about_'.$site_id.'_'.$lang_id, CmsPageAbout::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsPageAbout::STATUS_ACTIVE]));
        $album = CacheHelper::getQueryList('album_'.$site_id.'_'.$lang_id, CmsAlbum::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsAlbum::STATUS_ACTIVE]));
        
        $preDefinedLinks = CacheHelper::getQueryList('predefinedLinks_'.$site_id.'_'.$lang_id, CmsNav::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'type'=>CmsNav::TYPE_PREDEFINED_LINK,'status'=>CmsNav::STATUS_ACTIVE]));
        
        $productCategorys = ProductHelper::getTopCategorys($site_id, $lang_id);
        
        $navTypeNames = DataHelper::getNavTypeNames();
        
        $navs = NavHelper::getCacheNavs($site_id, $lang_id);
        
        $navsHtml = CacheHelper::getCache('navsHtml_'.$site_id.'_'.$lang_id);
        if (empty($navsHtml))
        {
            $navsHtml = NavHelper::getNavsHtml($navs, $navTypeNames);
            CacheHelper::setCache('navsHtml_'.$site_id.'_'.$lang_id,$navsHtml);
        }
        
        $features = ThemeHelper::getFeatures();

        return $this->render('index', [
            'topCategorys' => $topCategorys,
            'pages' => $pages,
            'navs'=>$navs,
            'navsHtml'=>$navsHtml,
            'preDefinedLinks'=>$preDefinedLinks,
            'page_contact'=>$page_contact,
            'page_about' => $page_about,
            'album'=>$album,
            'productCategorys' => $productCategorys,
            'features'=>$features
        ]);
    }

    public function actionSave()
    {
        if (Yii::$app->user->isGuest) {
            return json_encode(['c'=>1001,'msg'=>\Yii::t('app', 'No login')]);
        }
        
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        if (isset($_POST['navs']))
        {
            $navs = $_POST['navs'];
            NavHelper::saveNavs($navs);
        }
        
        if (isset($_POST['deleteNavIds']))
        {
            $deleteNavIds = $_POST['deleteNavIds'];
            NavHelper::deleteNavs($deleteNavIds);
        }
        
        CacheHelper::deleteCache('navs_'.$site_id.'_'.$lang_id);
        CacheHelper::deleteCache('navsHtml_'.$site_id.'_'.$lang_id);
        
        return json_encode(['c'=>0,'msg'=>\Yii::t('app', 'Save success, please wait <span class="timer">2</span> seconds...')]);
    }

    public function actionSaveLink()
    {
        if (Yii::$app->user->isGuest) {
            return json_encode(['c'=>1001,'msg'=>\Yii::t('app', 'No login')]);
        }
        
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $request = \Yii::$app->request;
        $id = $request->post('id', 0);
        $name = $request->post('name', '');
        $url = $request->post('url', '');
        
        if (!empty($id))
        {
            $model = CmsNav::findOne($id);
            if (!is_object($model))
            {
                return json_encode(['c'=>1002,'msg'=>\Yii::t('app', 'Error Params')]);
            }
        }
        else
        {
            $model = new CmsNav();
            $model->site_id = $site_id;
            $model->lang_id = $lang_id;
            $model->type = CmsNav::TYPE_PREDEFINED_LINK;
        }
        
        $model->name = $name;
        $model->ext_content = $url;
        
        if ($model->save())
        {
            CacheHelper::deleteCache('predefinedLinks_'.$site_id.'_'.$lang_id);
            return json_encode(['c'=>0]);
        }
        else 
        {
            return json_encode(['c'=>1003,'msg'=>json_encode($model->getFirstErrors())]);
        }
    }

    public function actionDeleteLink()
    {
        if (Yii::$app->user->isGuest) {
            return json_encode(['c'=>1001,'msg'=>\Yii::t('app', 'No login')]);
        }
        
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $request = \Yii::$app->request;
        $id = $request->post('id', 0);
        
        if (!empty($id))
        {
            CmsNav::deleteAll('id=:id and type=:type',[':id'=>$id,':type'=>CmsNav::TYPE_PREDEFINED_LINK]);
            CacheHelper::deleteCache('predefinedLinks_'.$site_id.'_'.$lang_id);
            return json_encode(['c'=>0]);
        }
        else
        {
            return json_encode(['c'=>1002,'msg'=>\Yii::t('app', 'Error Params')]);
        }
    }
    
    

    /**
     * Finds the CmsNav model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsNav the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsNav::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
