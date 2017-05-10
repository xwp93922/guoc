<?php
namespace common\helpers;

use common\models\CmsAlbumConfig;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class AlbumHelper
{
    static public function getAlbumConfigCache($site_id,$lang_id)
    {
        $config = CacheHelper::getCache('album_config_'.$site_id.'_'.$lang_id);
        if (empty($config))
        {
            $config = CmsAlbumConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->asArray()->one();
            CacheHelper::setCache('album_config_'.$site_id.'_'.$lang_id, $config);
        }
        
        return $config;
    }
}