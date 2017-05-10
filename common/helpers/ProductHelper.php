<?php
namespace common\helpers;

use yii\helpers\ArrayHelper;
use common\models\CmsProductCategory;
use common\models\CmsProductConfig;
use common\models\CmsProductInfo;
use common\models\CmsProductSku;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class ProductHelper
{
    static public function getTopCategorys($site_id,$lang_id)
    {
        $topCategorys = CacheHelper::getCache('product_topCategorys_'.$site_id.'_'.$lang_id);
        if (empty($categoryOptions))
        {
            $topCategorys = CmsProductCategory::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'parent_id'=>0,'status'=>CmsProductCategory::STATUS_ACTIVE])->orderBy('sort_val asc')->asArray()->all();
            CacheHelper::setCache('product_topCategorys_'.$site_id.'_'.$lang_id,$topCategorys);
        }
        return $topCategorys;
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
        
        $categorys = CmsProductCategory::find()->where('site_id=:site_id and lang_id=:lang_id and parent_id=:pid',[':site_id'=>$site_id,':lang_id'=>$lang_id,':pid'=>$pid])->all();
        
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
        $categoryMap = CacheHelper::getCache('product_categoryMap_'.$site_id.'_'.$lang_id);
        if (empty($categoryMap))
        {
            $categoryMap = ArrayHelper::map(CmsProductCategory::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->all(), 'id', 'name');
            CacheHelper::setCache('product_categoryMap_'.$site_id.'_'.$lang_id,$categoryMap);
        }
        return $categoryMap;
    }
    
    static public function getCategoryOptions($site_id,$lang_id)
    {
        $categoryOptions = CacheHelper::getCache('product_categoryOptions_'.$site_id.'_'.$lang_id);
        if (empty($categoryOptions))
        {
            $categoryOptions = self::getSubCategorys($site_id,$lang_id,[],0,0,3);
            CacheHelper::setCache('product_categoryOptions_'.$site_id.'_'.$lang_id,$categoryOptions);
        }
        return $categoryOptions;
    }
    
    static public function deleteCache($site_id,$lang_id)
    {
        CacheHelper::deleteCache('product_categoryMap_'.$site_id.'_'.$lang_id);
        CacheHelper::deleteCache('product_categoryOptions_'.$site_id.'_'.$lang_id);
        CacheHelper::deleteCache('product_topCategorys_'.$site_id.'_'.$lang_id);
    }
    
    static public function getProductConfigCache($site_id,$lang_id)
    {
        $config = CacheHelper::getCache('product_config_'.$site_id.'_'.$lang_id);
        if (empty($config))
        {
            $config = CmsProductConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->asArray()->one();
            CacheHelper::setCache('product_config_'.$site_id.'_'.$lang_id, $config);
        }
        
        return $config;
    }
    
    static public function getProductCache($product_id)
    {
        $product = CacheHelper::getCache('product_'.$product_id);
        if (empty($product))
        {
            $product = CmsProductInfo::find()->where(['id'=>$product_id])->asArray()->one();
            $product['skus'] = CmsProductSku::find()->with(['pics'])->where(['product_id'=>$product_id])->asArray()->all();
            CacheHelper::setCache('product_'.$product_id, $product);
        }
        
        return $product;
    }
    
    static public function getProductRecommendCache($site_id,$lang_id)
    {
        $products = CacheHelper::getCache('product_recommend_'.$site_id.'_'.$lang_id);
        if (empty($products))
        {
            $products = CmsProductInfo::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'recommend'=>1,'status'=>CmsProductInfo::STATUS_ACTIVE])->orderBy('sort_val asc')->asArray()->all();
            CacheHelper::setCache('product_recommend_'.$site_id.'_'.$lang_id, $products);
        }
        
        return $products;
    }
}