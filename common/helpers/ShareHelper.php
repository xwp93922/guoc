<?php
namespace common\helpers;

use common\models\CmsShareBtn;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class ShareHelper
{
    static public function getShareConfigCache($site_id,$lang_id)
    {
        $config = CacheHelper::getCache('share_btns_'.$site_id.'_'.$lang_id);
        if (empty($config))
        {
            $config = CmsShareBtn::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->orderBy('sort_val asc,created_at asc')->asArray()->all();
            CacheHelper::setCache('share_btns_'.$site_id.'_'.$lang_id, $config);
        }
        
        return $config;
    }
}