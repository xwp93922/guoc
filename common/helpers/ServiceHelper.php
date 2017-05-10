<?php
namespace common\helpers;

use common\models\CmsServiceConfig;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class ServiceHelper
{
    static public function getServiceConfigCache($site_id,$lang_id)
    {
        $config = CacheHelper::getCache('service_config_'.$site_id.'_'.$lang_id);
        if (empty($config))
        {
            $config = CmsServiceConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->asArray()->one();
            CacheHelper::setCache('service_config_'.$site_id.'_'.$lang_id, $config);
        }
        
        return $config;
    }
}