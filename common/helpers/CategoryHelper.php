<?php
namespace common\helpers;

use common\models\CmsCategory;
use yii\helpers\ArrayHelper;
use common\models\GhThemeCategory;
use common\models\CmsPage;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class CategoryHelper
{
	static public function getSubPage($site_id, $lang_id, $options = [], $pid = 0, $level = 0,$maxlevel=0)
	{
		$level++;	
		if (!empty($maxlevel))
		{
			if ($level >= $maxlevel)
			{
				return $options;
			}
		}
	
		$pages = CmsPage::find()->where('site_id=:site_id and lang_id=:lang_id and parent_id=:pid',[':site_id'=>$site_id,':lang_id'=>$lang_id,':pid'=>$pid])->all();
	
		if (count($pages) > 0)
		{
			foreach ($pages as $c)
			{
				$options[$c->id] = self::getLevelLine($level).' '.$c->name;
	
				$options = self::getSubCategorys($site_id, $lang_id, $options, $c->id, $level, $maxlevel);
			}
		}
	
		return $options;
	}

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
        
        $categorys = CmsCategory::find()->where('site_id=:site_id and lang_id=:lang_id and parent_id=:pid',[':site_id'=>$site_id,':lang_id'=>$lang_id,':pid'=>$pid])->all();
        
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
        $categoryMap = CacheHelper::getCache('categoryMap_'.$site_id.'_'.$lang_id);
        if (empty($categoryMap))
        {
            $categoryMap = ArrayHelper::map(CmsCategory::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->all(), 'id', 'name');
            CacheHelper::setCache('categoryMap_'.$site_id.'_'.$lang_id,$categoryMap);
        }
        return $categoryMap;
    }
    
    static public function getCategoryOptions($site_id,$lang_id)
    {
        $categoryOptions = CacheHelper::getCache('categoryOptions_'.$site_id.'_'.$lang_id);
        if (empty($categoryOptions))
        {
            $categoryOptions = self::getSubCategorys($site_id,$lang_id,[],0,0,3);
            CacheHelper::setCache('categoryOptions_'.$site_id.'_'.$lang_id,$categoryOptions);
        }
        return $categoryOptions;
    }
    
    static public function deleteCache($site_id,$lang_id)
    {
        CacheHelper::deleteCache('topCategorys_'.$site_id.'_'.$lang_id);
        CacheHelper::deleteCache('categoryMap_'.$site_id.'_'.$lang_id);
        CacheHelper::deleteCache('categoryOptions_'.$site_id.'_'.$lang_id);
    }
    
    static public function getTopCategorys($site_id,$lang_id)
    {
        $topCategorys = CacheHelper::getCache('topCategorys_'.$site_id.'_'.$lang_id);
        if (empty($categoryOptions))
        {
            $topCategorys = CmsCategory::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'parent_id'=>0,'status'=>CmsCategory::STATUS_ACTIVE])->orderBy('sort_val asc')->asArray()->all();
            $count = count($topCategorys);
            for ($i=0;$i<$count;$i++)
            {
                $topCategorys[$i]['sub'] = CmsCategory::find()->where(['parent_id'=>$topCategorys[$i]['id'],'status'=>CmsCategory::STATUS_ACTIVE])->orderBy('sort_val asc')->asArray()->all();
            }
            CacheHelper::setCache('topCategorys_'.$site_id.'_'.$lang_id,$topCategorys);
        }
        return $topCategorys;
    }
    
    static public function getThemeCategory()
    {
        return CacheHelper::getQueryList('gh_theme_category',GhThemeCategory::find()->where(['status'=>GhThemeCategory::STATUS_ACTIVE])->orderBy('sort_val asc'));
    }
    
    static public function getThemeCategoryMap()
    {
        $categoryMap = ArrayHelper::map(self::getThemeCategory(), 'id', 'name');
        return $categoryMap;
    }
}