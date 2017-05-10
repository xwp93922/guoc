<?php
namespace common\helpers;
use Yii;
use common\models\CmsTheme;
use yii\web\NotAcceptableHttpException;
use backend;
use common\models\CmsConfigType;
use common\models\GhTheme;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/6
 * Time: 16:34
 */
class ThemeHelper {
    /*
     * features
     * 指主题包含的功能列表，比如是否包含常规的文章系统，联系我们，或者另外一种文章系统
     * 后台根据此变量的值来生成侧边栏
     */
    
    static public $THEME_FEATURE_NAV                = 1001;
    static public $THEME_FEATURE_CATEGORY           = 2001;
    static public $THEME_FEATURE_ARTICLE            = 3001;
    static public $THEME_FEATURE_PAGE               = 4001;
    static public $THEME_FEATURE_PAGE_CONTACT       = 4002;
    static public $THEME_FEATURE_PAGE_ABOUT         = 4003;
    static public $THEME_FEATURE_BANNER             = 5001;
    static public $THEME_FEATURE_CASE               = 6001;
    static public $THEME_FEATURE_ALBUM              = 7001;
    static public $THEME_FEATURE_SERVICE            = 8001;
    static public $THEME_FEATURE_PRODUCT            = 9001;
    static public $THEME_FEATURE_FRIENDLINK         = 10001;
    static public $THEME_FEATURE_TAOKE        		= 10002;
    static public $THEME_FEATURE_OHTHER        		= 20001;
    
    static public function getFeatureNames($feature='')
    {
    	if(!$feature){
    		return [
    				self::$THEME_FEATURE_NAV => \Yii::t('app', 'Nav'),
    				self::$THEME_FEATURE_CATEGORY => \Yii::t('app', 'Category'),
    				self::$THEME_FEATURE_ARTICLE => \Yii::t('app', 'Article'),
    				self::$THEME_FEATURE_PAGE => \Yii::t('app', 'Page'),
    				self::$THEME_FEATURE_PAGE_CONTACT => \Yii::t('app', 'Page Contact'),
    				self::$THEME_FEATURE_PAGE_ABOUT => \Yii::t('app', 'Page About'),
    				self::$THEME_FEATURE_BANNER => \Yii::t('app', 'Banner'),
    				self::$THEME_FEATURE_CASE => \Yii::t('app', 'Case'),
    				self::$THEME_FEATURE_ALBUM => \Yii::t('app', 'Album'),
    				self::$THEME_FEATURE_SERVICE => \Yii::t('app', 'Service'),
    				self::$THEME_FEATURE_PRODUCT => \Yii::t('app', 'Product'),
    				self::$THEME_FEATURE_FRIENDLINK => \Yii::t('app', 'friendlink'),
    				self::$THEME_FEATURE_TAOKE => \Yii::t('app', 'taoke'),
    				self::$THEME_FEATURE_OHTHER => \Yii::t('app', 'other'),
    		];
    	}else{
    		foreach (self::getFeatureNames() as $key=>$val){
    			if($key==$feature){
    				return $val;
    			}
    		}
    	}
        
    }

    static public function getThemeCodeById($theme_id) {
        return "t" . str_pad($theme_id,5,"0",STR_PAD_LEFT);
    }

    static public function setThemeById($id) {
        /*
        $model = \common\models\GhTheme::findOne($id);
        if (!is_object($model)) {
            return false;
        }

        return ThemeHelper::setThemeByCode($model->code);
        */
        $code = ThemeHelper::getThemeCodeById($id);
        return ThemeHelper::setThemeByCode($code);
    }

    static public function setThemeByCode($code) {

        if (empty($code)) {
            return false;
        }

        Yii::$app->params['theme'] = $code;
        Yii::$app->view->theme = new \yii\base\Theme([
            'basePath' => '@app/themes/'. $code , //指定包含主题资源（CSS, JS, images, 等等）的基准目录
            'baseUrl' => '@web/themes/' . $code , //指定主题资源的基准URL。
            'pathMap' => ['@app/views' => '@app/themes/'. $code . '/views'], //指定视图文件的替换规则。 更多细节将在下面介绍

        ]);

        return true;
    }

    static public function parseTheme($themeStr) {
        return explode('|', $themeStr);
    }

    static public function stringifyTheme($themeArray) {
        return implode('|', $themeArray);
    }
    
    static public function getSiteThemes($site_id)
    {
        $themes = CacheHelper::getQueryList('cms_theme_'.$site_id, CmsTheme::find()->with(['theme'])->where(['site_id'=>$site_id])->orderBy('status desc,sort_val asc'));
        return $themes;
    }
    
    static public function getCurrentTheme($site_id)
    {
        $currentTheme = CacheHelper::getCache('currentTheme_'.$site_id);
        if (empty($currentTheme))
        {
        	
            $themes = self::getSiteThemes($site_id);
            if (!empty($themes))
            {
                foreach ($themes as $t)
                {
                    if ($t['status'] == CmsTheme::STATUS_USED)
                    {
                        $currentTheme = $t;
                        break;
                    }
                }
            }
            CacheHelper::setCache('currentTheme_'.$site_id, $currentTheme);
        }
        
        return $currentTheme;
    }
    
    static public function getFeatureId($rel)
    {
        $feature = '';
        switch ($rel)
        {
            case 'nav':
                $feature = self::$THEME_FEATURE_NAV;
                break;
            case 'category':
                $feature = self::$THEME_FEATURE_CATEGORY;
                break;
            case 'article':
                $feature = self::$THEME_FEATURE_ARTICLE;
                break;
            case 'page':
                $feature = self::$THEME_FEATURE_PAGE;
                break;
            case 'page-contact':
                $feature = self::$THEME_FEATURE_PAGE_CONTACT;
                break;
            case 'page-about':
                $feature = self::$THEME_FEATURE_PAGE_ABOUT;
                break;
            case 'banner':
                $feature = self::$THEME_FEATURE_BANNER;
                break;
            case 'case':
                $feature = self::$THEME_FEATURE_CASE;
                break;
            case 'cms-album':
                $feature = self::$THEME_FEATURE_ALBUM;
                break;
            case 'cms-service':
                $feature = self::$THEME_FEATURE_SERVICE;
                break;
            case 'cms-product':
                $feature = self::$THEME_FEATURE_PRODUCT;
                break;
            case 'friendlink':
                $feature = self::$THEME_FEATURE_FRIENDLINK;
                break;
        }
        
        return $feature;
    }
    
    static public function checkAccess()
    {
        $feature = self::getFeatureId(Yii::$app->controller->id);
        
        if (!empty($feature))
        {
            $theme_arr = backend\helpers\SiteHelper::getThemeArr();
            $features = explode(',', $theme_arr['features']);
            if (!is_array($features))
            {
                throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined theme.'));
            }
            
            if (!in_array($feature, $features))
            {
                throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined feature.'));
            }
        }
    }
    
    static public function frontendCheckAccess($rel,$site_id)
    {
		$theme = ThemeHelper::getCurrentTheme($site_id);
		$features = $theme['theme']['features'];
        $feature = self::getFeatureId($rel);
        
        if (!empty($feature))
        {
            $features = explode(',', $features);
            if (!is_array($features))
            {
                throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined theme.'));
            }
            
            if (!in_array($feature, $features))
            {
                throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined feature.'));
            }
        }
    }
    
    static public function getFeatures($type='features')
    {
        $theme_arr = backend\helpers\SiteHelper::getThemeArr();      
        $features = explode(',', $theme_arr[$type]);
        if (!is_array($features))
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined theme.'));
        }
        
        return $features;
    }
    
    static public function getFeaturesById($theme_id){
    	$theme = GhTheme::find()->where(['id'=>$theme_id])->asArray()->one();
    	$features = explode(',', $theme['home_features']);
    	if (!is_array($features))
    	{
    		throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined theme.'));
    	}    	
    	return $features;
    }
    static public function getConfigType(){
    	$infos=CmsConfigType::find()->asArray()->all();
    	foreach ($infos as $key=>$info){
    		if(isset($info['feature'])){
    			$infos[$key]['feature']=explode(',', $info['feature']);
    		}
    	}    	
    	return $infos;
    }    
}
