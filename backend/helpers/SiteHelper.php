<?php
namespace backend\helpers;
use Yii;
use yii\helpers\Url;
use common\models\GhSite;
use yii\web\NotAcceptableHttpException;
use common\models\CmsSiteLang;
use common\helpers\LangHelper;
use common\models\GhConfigLang;
use common\models\CmsTheme;
use common\models\GhTheme;
use common\models\CmsSite;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/8
 * Time: 14:53
 */
class SiteHelper {
    /* static public function getCurrentSiteId() {
        //先判断请求参数中是否带有，如果带了，则以此更新session中的site_id，如果没有，则以session中的为准
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $site_id = intval($request->get('site_id', 0));
        if ($site_id != 0) {
            $session->set('cms.site_id', $site_id);
        } else {
            if ($session->has('cms.site_id')) {
                $site_id = $session->get('cms.site_id');
            }
        }

        return $site_id;
    } */
    
    static public function setSiteId($user_id) {

        $site = GhSite::find()->where(['user_id'=>$user_id])->one();
        if (!is_object($site))
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined site.'));
        }
        $site_info = CmsSite::find()->where(['site_id'=>$site->id])->asArray()->one();
        if (empty($site_info))
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined site.'));
        }
        
        $session = Yii::$app->session;
        $session->set('cms.site_id',$site->id);
        $session->set('cms.site_info',$site_info);
    }
    
    static public function getSiteId() {

        $session = Yii::$app->session;
        if (!$session->has('cms.site_id'))
        {
            header('Location: '.Url::to(['site/login',true]));
            exit();
        }
        
        return $session->get('cms.site_id');
    }
    
    static public function getSiteInfo()
    {
        $session = Yii::$app->session;
        if (!$session->has('cms.site_info'))
        {
            header('Location: '.Url::to(['site/login',true]));
            exit();
        }
        
        return $session->get('cms.site_info');
    }
    
    static public function setLangId($cms_lang_id='') {
        $site_id = SiteHelper::getSiteId();
        $session = Yii::$app->session;
        if (!empty($cms_lang_id))
        {
            $old_lang_id = SiteHelper::getLangId();
            $old_lang_arr = SiteHelper::getLangArr();
            
            $lang = CmsSiteLang::find()->where(['id'=>$cms_lang_id,'status'=>CmsSiteLang::STATUS_ACTIVE])->one();
            if (!is_object($lang))
            {
                throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined lang.'));
            }
            $lang->default = 1;
            $lang->save();
            CmsSiteLang::updateAll(['default'=>0],'site_id=:site_id and id!=:id',[':site_id'=>$site_id,'id'=>$cms_lang_id]);
            $session->set('cms.lang_id',$lang->lang_id);
            $session->set('cms.lang_arr',[
                'id'=>$lang->id,
                'site_id'=>$lang->site_id,
                'lang_id'=>$lang->lang_id,
                'theme_id'=>$lang->theme_id,
                'name'=>$lang->name,
                'flag'=>$lang->flag,
                'default'=>$lang->default,
                'status'=>$lang->status,
                'sort_val'=>$lang->sort_val
            ]);

            $session->setFlash('cms.lang_update', \Yii::t('app', 'You change lang from "{old_lang_name}" to "{new_lang_name}"',[
                'old_lang_name'=>$old_lang_arr['name'],
                'new_lang_name'=>$lang->name,
            ]));
        }
        else 
        {
            $cmsLangs = LangHelper::getCmsSiteLangCache($site_id);
            if (empty($cmsLangs))
            {
            	
                $ghLang = GhConfigLang::find()->orderBy('sort_val asc')->limit(1)->asArray()->all();
                if (empty($ghLang))
                {
                    throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined lang.'));
                }
                $lang = new CmsSiteLang();
                $lang->site_id = $site_id;
                $lang->lang_id = $ghLang[0]['id'];
                $lang->name = $ghLang[0]['name'];
                $lang->flag = $ghLang[0]['flag'];
                $lang->default = 1;
                
                if ($lang->save())
                {
                    $session->set('cms.lang_id',$lang->lang_id);
                    $session->set('cms.lang_arr',[
                        'id'=>$lang->id,
                        'site_id'=>$lang->site_id,
                        'lang_id'=>$lang->lang_id,
                        'theme_id'=>$lang->theme_id,
                        'name'=>$lang->name,
                        'flag'=>$lang->flag,
                        'default'=>$lang->default,
                        'status'=>$lang->status,
                        'sort_val'=>$lang->sort_val
                    ]);
                }
            }
            else 
            {
                $session->set('cms.lang_id',$cmsLangs[0]['lang_id']);
                $session->set('cms.lang_arr',$cmsLangs[0]);
            }
        }
    }
    
    static public function getLangId() {
        $session = Yii::$app->session;
        if (!$session->has('cms.lang_id'))
        {
            header('Location: '.Url::to(['site/login',true]));
            exit();
        }
        
        return $session->get('cms.lang_id');
    }
    
    static public function getLangArr() {
        $session = Yii::$app->session;
        if (!$session->has('cms.lang_arr'))
        {
            header('Location: '.Url::to(['site/login',true]));
            exit();
        }
        
        return $session->get('cms.lang_arr');
    }
    
    static public function setThemeId($theme_id='')
    {

        $site_id = SiteHelper::getSiteId();
        $session = Yii::$app->session;
        if (!empty($theme_id))
        {
            $old_theme_id = SiteHelper::getThemeId();
            $old_theme_arr = SiteHelper::getThemeArr();
            
            $session->set('cms.theme_id',$theme_id);
            
            $theme = GhTheme::find()->where(['id'=>$theme_id])->asArray()->one();
            $session->set('cms.theme_arr',$theme);

            $session->setFlash('cms.theme_update', \Yii::t('app', 'You change theme from "{old_theme_name}" to "{new_theme_name}"',[
                'old_theme_name'=>$old_theme_arr['name'],
                'new_theme_name'=>$theme['name'],
            ]));
        }
        else
        {
            $themes = CmsTheme::find()->select(['theme_id'])->where(['site_id'=>$site_id])->orderBy('status desc,sort_val asc')->limit(1)->asArray()->all();
            if (!empty($themes))
            {
                $theme_id = $themes[0]['theme_id'];
                $session->set('cms.theme_id',$theme_id);
            }            
            else
            {
                $ghTheme = GhTheme::find()->select(['id'])->where(['status'=>GhTheme::STATUS_ACTIVE])->orderBy('sort_val asc')->limit(1)->asArray()->all();
                if (empty($ghTheme))
                {
                    throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined theme.'));
                }
                $newTheme = new CmsTheme();
                $newTheme->site_id = $site_id;
                $newTheme->theme_id = $ghTheme[0]['id'];
                $newTheme->status = CmsTheme::STATUS_USED;
                if ($newTheme->save())
                {
                    $theme_id = $ghTheme[0]['id'];
                    $session->set('cms.theme_id',$theme_id);
                }
                else
                {
                    throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined theme.'));
                }
            }
            if (!empty($theme_id))
            {
                $theme = GhTheme::find()->where(['id'=>$theme_id])->asArray()->one();
                if(empty($theme)){
                	$theme=GhTheme::find()->where(['code'=>'t' . str_pad($theme_id,5,"0",STR_PAD_LEFT)])->asArray()->one();
                }
                $session->set('cms.theme_arr',$theme);
            }
        }
    }
    
    static public function getThemeId()
    {
        $session = Yii::$app->session;
        if (!$session->has('cms.theme_id'))
        {
            header('Location: '.Url::to(['site/login',true]));
            exit();
        }
        
        return $session->get('cms.theme_id');
    }


    static public function getThemeArr()
    {

        $session = Yii::$app->session;
        if (!$session->has('cms.theme_arr'))
        {
            header('Location: '.Url::to(['site/login',true]));
            exit();
        }
    
        return $session->get('cms.theme_arr');
    }

    
}