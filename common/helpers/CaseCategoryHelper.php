<?php
namespace common\helpers;

use common\models\CmsCategory;
use yii\helpers\ArrayHelper;
use common\models\GhThemeCategory;
use common\models\CmsCaseCategory;
use common\models\CmsCaseConfig;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class CaseCategoryHelper
{

    static public function getSubCategorys($site_id, $lang_id, $options = [], $pid = 0, $level = 0,$maxlevel=0)
    {
        $level++;
        
        if (!empty($maxlevel))
        {
            if ($level >= $maxlevel)
            {
                return $options;
            }
        }
        
        $categorys = CmsCaseCategory::find()->where('site_id=:site_id and lang_id=:lang_id and parent_id=:pid',[':site_id'=>$site_id,':lang_id'=>$lang_id,':pid'=>$pid])->all();
        
        if (count($categorys) > 0)
        {
            foreach ($categorys as $c)
            {
                $options[$c->id] = self::getLevelLine($level).' '.$c->name;
        
                $options = self::getSubCategorys($site_id, $lang_id, $options, $c->id, $level, $maxlevel);
            }
        }
        
        return $options;
    }
    
    static public function getLevelLine($level)
    {
        $s = '';
        for ($i=1;$i<=$level;$i++)
        {
            $s .= '--';
        }
        
        return $s;
    }
    
    static public function getCategoryMap($site_id,$lang_id)
    {
        $categoryMap = CacheHelper::getCache('case_categoryMap_'.$site_id.'_'.$lang_id);
        if (empty($categoryMap))
        {
            $categoryMap = ArrayHelper::map(CmsCaseCategory::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->all(), 'id', 'name');
            CacheHelper::setCache('case_categoryMap_'.$site_id.'_'.$lang_id,$categoryMap);
        }
        return $categoryMap;
    }
    
    static public function getCategoryOptions($site_id,$lang_id)
    {
        $categoryOptions = CacheHelper::getCache('case_categoryOptions_'.$site_id.'_'.$lang_id);
        if (empty($categoryOptions))
        {
            $categoryOptions = self::getSubCategorys($site_id,$lang_id,[],0,0,3);
            CacheHelper::setCache('case_categoryOptions_'.$site_id.'_'.$lang_id,$categoryOptions);
        }
        return $categoryOptions;
    }
    
    static public function deleteCache($site_id,$lang_id)
    {
        CacheHelper::deleteCache('case_categoryMap_'.$site_id.'_'.$lang_id);
        CacheHelper::deleteCache('case_categoryOptions_'.$site_id.'_'.$lang_id);
    }
    
    static public function getCaseConfigCache($site_id,$lang_id)
    {
        $caseConfig = CacheHelper::getCache('case_config_'.$site_id.'_'.$lang_id);
        if (empty($caseConfig))
        {
            $caseConfig = CmsCaseConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->asArray()->one();
            CacheHelper::setCache('case_config_'.$site_id.'_'.$lang_id, $caseConfig);
        }
        
        return $caseConfig;
    }
}