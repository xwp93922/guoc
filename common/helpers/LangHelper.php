<?php
namespace common\helpers;


use common\models\CmsSiteLang;
use backend;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class LangHelper
{
    static public function getCmsSiteLangCache($site_id)
    {
        return CacheHelper::getQueryList('cms_langs_'.$site_id, CmsSiteLang::find()->where(['site_id'=>$site_id,'status'=>CmsSiteLang::STATUS_ACTIVE])->orderBy('default desc,sort_val asc'));
    }
    
    static public function getLangsWithoutDefault($default_lang_id)
    {
        $cmsLangs = LangHelper::getCmsSiteLangCache(backend\helpers\SiteHelper::getSiteId());
        $count = count($cmsLangs);
        for ($i=0;$i<$count;$i++)
        {
            if ($cmsLangs[$i]['id'] == $default_lang_id)
            {
                unset($cmsLangs[$i]);
                break;
            }
        }
        return $cmsLangs;
    }
    
    static public function getDefaultLang($site_id){
        $currentLang = CacheHelper::getCache('currentLang_'.$site_id);
        if (empty($currentLang))
        {
            $langs = self::getCmsSiteLangCache($site_id);
            if (!empty($langs))
            {
                foreach ($langs as $l)
                {
                    if ($l['default'] == 1)
                    {
                        $currentLang = $l;
                        break;
                    }
                }
            }
            CacheHelper::setCache('currentLang_'.$site_id, $currentLang);
        }
        
        return $currentLang;
    }
    
    static public function setCurrentLangId($lang_id)
    {
        $session = \Yii::$app->session;
        $session->set('frontend.lang_id',$lang_id);
    }
    
    static public function getCurrentLangId()
    {
        return \Yii::$app->session->has('frontend.lang_id') ? \Yii::$app->session->get('frontend.lang_id') : '';
    }
}
