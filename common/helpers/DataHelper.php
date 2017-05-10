<?php

namespace common\helpers;

use common\models\CmsNav;
use common\models\User;
use common\models\GhSite;
use common\models\CmsSite;
use common\models\CmsShareBtn;
use common\models\CmsPage;
use common\models\CmsCategory;
use common\models\CmsArticle;
use common\models\CmsIndexConfig;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 16/9/26
 * Time: 22:23
 */
class DataHelper {
    static public function getValue($data,$key)
    {
        if (isset($data[$key]))
        {
            return $data[$key];
        }
        else
        {
            return '未定义';
        }
    }
    
    static public function getNavTypeNames()
    {
        return [
            CmsNav::TYPE_HOMEPAGE => \Yii::t('app', 'Homepage'),
            CmsNav::TYPE_CATEGORY => \Yii::t('app', 'Top category'),
            CmsNav::TYPE_CATEGORY_SUB => \Yii::t('app', 'Sub category'),
            CmsNav::TYPE_PAGE => \Yii::t('app', 'Single page'),
            CmsNav::TYPE_PAGE_ABOUT => \Yii::t('app', 'About us'),
            CmsNav::TYPE_PAGE_CONTACT => \Yii::t('app', 'Contact us'),
            CmsNav::TYPE_CUSTOMER_LINK => \Yii::t('app', 'Customer link'),
            CmsNav::TYPE_PREDEFINED_LINK => \Yii::t('app', 'Predefined link'),
            CmsNav::TYPE_CASE => \Yii::t('app', 'Cms Cases'),
            CmsNav::TYPE_ALBUM => \Yii::t('app', 'Album List'),
            CmsNav::TYPE_PRODUCT => \Yii::t('app', 'Product List'),
            CmsNav::TYPE_PRODUCT_CATEGORY => \Yii::t('app', 'Cms Product Category'),
        ];
    }
    
    static public function getGeneralStatus()
    {
        return [
            User::STATUS_ACTIVE=>\Yii::t('app', 'Active'),
            User::STATUS_DELETED=>\Yii::t('app', 'Deleted'),
        ];
    }
    static public function getPageType()
    {
    	return [
    			CmsPage::TYPE_ABOUT=>\Yii::t('app', 'About'),
    			CmsPage::TYPE_CHANGE=>\Yii::t('app', 'Onload'),
    			CmsPage::TYPE_COMPARE=>\Yii::t('app', 'compare'),
    			CmsPage::TYPE_EXAMPLE=>\Yii::t('app', 'School'),
    			CmsPage::TYPE_NEWS=>\Yii::t('app', 'News'),
    			CmsPage::TYPE_ONBASE=>\Yii::t('app', 'Onbase'),
    	];
    }
    static public function getCateType()
    {
    	return [
    			CmsCategory::CATE_LOGIN=>\Yii::t('app', 'login'),
    			CmsCategory::CATE_JOIN=>\Yii::t('app', 'Join'),
    			CmsCategory::CATE_NEWS=>\Yii::t('app', 'news'),
    			CmsCategory::CATE_QUESTION=>\Yii::t('app', 'question'),
    			CmsCategory::CATE_SYSTEM=>\Yii::t('app', 'system'),
    			CmsCategory::CATE_FREECATE=>\Yii::t('app', 'freecate'),
                CmsCategory::CATE_BRAND=>\Yii::t('app', 'brand'),
    	];
    }
    static public function getYesOrNo()
    {
        return [
            0=>\Yii::t('app', 'No'),
            1=>\Yii::t('app', 'Yes'),
        ];
    }
    
    static public function getBannerPosNames($pos,$posMap)
    {
        $pos = explode(',', substr($pos, 1, -1));
        $posStr = '';
        foreach ($pos as $p)
        {
            if (isset($posMap[$p]))
                $posStr .= $posMap[$p].', ';
        }
        if (!empty($posStr))
        {
            $posStr = substr($posStr, 0, -2);
        }
        return $posStr;
    }
    
    static public function getBannerPosMap()
    {
        return [
            'homepage'=>\Yii::t('app', 'Homepage'),
        ];
    }
    
    static public function getTopBannerPosMap()
    {
        $features = ThemeHelper::getFeatures();
        $posMap = [];
        if (in_array(ThemeHelper::$THEME_FEATURE_ALBUM, $features)){
            $posMap['album'] = \Yii::t('app', 'Album');
        }
        if (in_array(ThemeHelper::$THEME_FEATURE_CASE, $features)){
            $posMap['case'] = \Yii::t('app', 'Case');
        }
        
        return $posMap;
    }
    
    static public function getShareBtnTypes()
    {
        return [
            CmsShareBtn::TYPE_LINK=>\Yii::t('app', 'Link'),
            CmsShareBtn::TYPE_QRCODE=>\Yii::t('app', 'Qrcode'),
        ];
    }
    
    static public function getRecommend($lenght,$where){
    	$category = CmsCategory::find()->where($where)->andWhere(['type'=>'news','necessary'=>1])->one();
    	$articles = [];
    	$sub_categorys = [];
    	if (is_object($category))
    	{
    		//新闻资讯
    		$articles =CmsArticle::find()->where($where)->andWhere(['category_id'=>$category->id,'recommend'=>1])->orderBy('sort_val asc')->asArray()->all();
    		$sub_categorys = CmsCategory::find()->with(['indexArticles'])->where($where)->andWhere(['parent_id'=>$category->id])->all();
    		foreach ($sub_categorys as $sub_category){
    			foreach (CmsArticle::find()->where($where)->andWhere(['category_id'=>$sub_category['id'],'recommend'=>1])->orderBy('sort_val asc')->asArray()->all() as $val){
    				array_push($articles,$val);
    			}
    		}
    	}
    	if(count($articles)>$lenght){
    		return array_slice($articles,0,$lenght-1);
    	}
    	return $articles;
    }

    //获取最新文章
    static public function getNewArtical($lenght,$where,$type='news'){
     	$category = CmsCategory::find()->where($where)->andWhere(['type'=>'news','parent_id'=>0])->one();
        $articles = [];
        $sub_categorys = [];
        if (is_object($category))
        {
            //新闻资讯
            $articles = CmsArticle::find()->where($where)->andWhere(['category_id'=>$category->id])->orderBy('created_at desc')->asArray()->all();
            $sub_categorys = CmsCategory::find()->with(['indexArticles'])->where($where)->andWhere(['parent_id'=>$category->id])->all(); 
            foreach ($sub_categorys as $sub_category){
    			foreach (CmsArticle::find()->where($where)->andWhere(['category_id'=>$sub_category['id']])->orderBy('created_at desc')->asArray()->all() as $val){
    				array_push($articles,$val);
    			}
            }
        }
        if(count($articles)>$lenght){
        	return array_slice($articles,0,$lenght-1);
        }
        return $articles;
    }
    static public function getCateArticle($cate_id,$where,$lenght=12){
    	$category = CmsCategory::find()->where($where)->andWhere(['id'=>$cate_id])->one();
    	$articles = [];
    	$sub_categorys = [];
    	if (is_object($category))
    	{
    		//新闻资讯
    		$articles = CmsArticle::find()->where($where)->andWhere(['category_id'=>$category->id])->orderBy('created_at desc')->asArray()->all();
    		$sub_categorys = CmsCategory::find()->with(['indexArticles'])->where($where)->andWhere(['parent_id'=>$category->id])->all();
    		foreach ($sub_categorys as $sub_category){
    			foreach (CmsArticle::find()->where($where)->andWhere(['category_id'=>$sub_category['id']])->orderBy('created_at desc')->asArray()->all() as $val){
    				array_push($articles,$val);
    			}
    		}
    	}
    	if(count($articles)>$lenght){
    		return array_slice($articles,0,$lenght-1);
    	}
    	return $articles;
    }
    //后台获取配置信息
    
    static public function getFeatureInfos($site_id,$lang_id){   	
    	$features=ThemeHelper::getFeatures('home_features');
    	//获取配置项
    	$config_info=ThemeHelper::getConfigType();
    	//获取每一个feature对应的配置项
    	$configs=[];
    	foreach ($features as $val){
    		foreach ($config_info as $key=>$info){
    			if(in_array($val, $info['feature'])){
    				//$info['value']=CmsIndexConfig::find()->where(['config_id'=>$info['id'],'feature'=>$val])->asArray()->one();
    				$info['model']=CmsIndexConfig::find()->where(['config_id'=>$info['id'],'feature'=>$val,'site_id'=>$site_id,'lang_id'=>$lang_id])->one();
    				$configs[$val][$key]=$info;
    			}
    		}
    	}
    	return $configs;
    }
}