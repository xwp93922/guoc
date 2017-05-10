<?php
namespace common\core;
use common\models\CmsSite;
use common\models\GhSite;
use Yii;
use yii\web\NotFoundHttpException;
use common\helpers\ThemeHelper;
use common\helpers\NavHelper;
use common\models\CmsPageContact;
use common\helpers\CaseCategoryHelper;
use common\models\CmsCaseCategory;
use common\helpers\AlbumHelper;
use common\models\CmsAlbumConfig;
use common\models\CmsServiceConfig;
use common\models\CmsShareBtn;
use common\helpers\CacheHelper;
use backend\helpers\SiteHelper;
use common\helpers\InitHelper;
use common\models\CmsCaseConfig;
use common\helpers\UtilHelper;
use common\models\CmsCategory;
use common\models\CmsPage;
use common\models\FriendLink;
use common\models\CmsBanner; 

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/3/25
 * Time: 00:27
 */
/*
 * site,lang,theme之间的关系
 * site可以有多个theme和lang，但只有一个处于激活状态
 * lang表中也有theme_id，当此theme_id > 0 时，可以覆盖site表中的theme_id设置，这样可以为不同的语言设置不同的主题
 *
 * theme的设置流程
 * 1. theme被购买或被设置到用户账户中时，存储在site_theme表中
 * 2. 当用户生成站点时，默认初始化lang数据时，以site表中的theme_id初始化
 * 3. 用户可以为具体的lang设置不同的theme
 *
 * 从数据库里面读取数据的函数，以load起始
 * 返回当前变量中存储数据的函数，已get起始
 */
class SiteCore {
    static public $SITE_TYPE_DEMO = 1;
    static public $SITE_TYPE_STANDARD = 2;
	static  public $THEME_COUNT=10;
    private $siteObj;
    function init() {
    	//获取参数
        $request = Yii::$app->request;
        $hostName = $request->hostInfo;
      	if(isset($_GET['sname'])){
      		\Yii::$app->session['serial_id']=$_GET['sname'];
      		$paramSiteId=GhSite::find()->where(['serial_id'=>$_GET['sname']])->asArray()->one()['id'];
      		if(empty($paramSiteId)){
      			$paramSiteId=8;
      		}
      	}else{
      		\Yii::$app->session['serial_id']='';
      		$paramSiteId=8;
      	}
      	//中英文切换
      	\Yii::$app->language= isset(Yii::$app->session['lang'])?Yii::$app->session['lang']:'zh-CN';
        $userId=yii::$app->user->id;
        $paramLangId = isset(\Yii::$app->session['lang_id'])?\Yii::$app->session['lang_id']:0;
        $paramThemeId = $request->get('theme', 0);
        //去掉前缀
        if (strpos($hostName, "http://") === 0) {
            $hostName = str_replace("http://", '', $hostName);
        }

        if (strpos($hostName, "https://") === 0) {
            $hostName = str_replace("https://", '', $hostName);
        }

        $site = [];
        if ($hostName == "demo.bothsite.com") {
        	//InitHelper::initDefalutData($paramSiteId,'http://'.$hostName);
            if ($paramSiteId != 0) {
                $site = $this->loadGhSiteById($paramSiteId);
            }
        }
        else {
        	$site = $this->loadGhSiteByHostName('http://'.$hostName);
        	if (empty($site)) {
        		//不存在对应的站点
        		InitHelper::initDefalutData($paramSiteId,'http://'.$hostName);
        	}
        	$site = $this->loadGhSiteByHostName('http://'.$hostName); 
        }              
       
        //初始化theme
        $siteId = $site['id'];
        $siteInfo['cmsSite'] = CmsSite::find()->where(['site_id'=>$siteId])->asArray()->one();
        $lang_id=$siteInfo['cmsSite']['lang_id'];
        if (empty($siteInfo)) {
            throw new NotFoundHttpException(\Yii::t('app', '您访问的站点暂时无法显示'));
        }
        //根据用户输入的参数设置site info
        if ($paramLangId > 0) {
        	$lang_id=$paramLangId;
            $siteInfo['cmsSite']['lang_id'] = $paramLangId;
        }        
        if(CmsSite::find()->where(['lang_id'=>$paramLangId,'site_id'=>$siteId])->count()==0){
        	//InitHelper::initDefalutData($site['id'],$site['host_name'],$paramLangId);
        	$siteInfo['cmsSite']=CmsSite::find()->where(['site_id'=>$siteId,'lang_id'=>$lang_id])->asArray()->one();
        }
        //获取其他数据
        $info=$this->loadCmsSiteInfo($siteId,$lang_id);
        $session = Yii::$app->session;
        if (!$session->has('phone'))
        {
           $session->set('phone',isset($info['contact']['phone'])?$info['contact']['phone']:'');
        }        
        foreach ($info as $key=>$val){
        	if(is_array($val)){
        		$siteInfo[$key]=$val;
        	}
        }
        if ($paramThemeId > 0) {
            $siteInfo['cmsSite']['theme_id'] = $paramThemeId;
        }
        if($nav=NavHelper::getNavs($siteId, $lang_id)){
        	$siteInfo['navs']=$nav;
        }else{
        	$siteInfo['navs']=NavHelper::getNavs(1, $lang_id);
        }
       		
        if($banners = CmsBanner::find()->with('images')->where(['site_id'=>$siteId,'lang_id'=>$lang_id])->andWhere(['like','pos',',homepage,'])->orderBy('sort_val asc')->asArray()->one()){
        	$siteInfo['banner']=$banners;
        }
        //var_dump($siteInfo);die();
        $this->siteObj = new SiteObj();
        $this->siteObj->setSiteId($siteId);
        $this->siteObj->setSiteInfo($siteInfo);
    }

    function loadGhSiteByHostName($hostName) {
        $ghSite = GhSite::find()->where(['host_name' => $hostName, 'type' => SiteCore::$SITE_TYPE_STANDARD])->asArray()->one();
        return $ghSite;
    }

    function loadGhSiteById($id) {
        $ghSite = GhSite::find()->where(['id' => $id, 'type' => SiteCore::$SITE_TYPE_DEMO])->asArray()->one();
        return $ghSite;
    }

    function loadCmsSiteInfo($site_id,$lang_id=1) {
        $cmsSite = CmsSite::find()->with(['contact','caseConfig','albumConfig','serviceConfig','shareBtns','page','link'])->where(['site_id' => $site_id,'lang_id'=>$lang_id])->asArray()->one();
        return $cmsSite;
    }

    function getSiteId() {
        if (!is_object($this->siteObj)) {
            return 0;
        }

        return $this->siteObj->getSiteId();
    }

    function getSiteInfo() {
        if (!is_object($this->siteObj)) {
            return 0;
        }

        return $this->siteObj->getSiteInfo();
    }

    function getSiteLangId() {
        if (!is_object($this->siteObj)) {
            return 0;
        }

        $info = $this->siteObj->getSiteInfo();
        return $info['cmsSite']['lang_id'];
    }

    function getSiteThemeId($siteId) {
        if (!is_object($this->siteObj)) {
            return 0;
        }
        $info = $this->siteObj->getSiteInfo();
        if($theme=ThemeHelper::getCurrentTheme($siteId)){
        	if($theme['theme_id']>self::$THEME_COUNT){
        		return $info['cmsSite']['theme_id'];
        	}else{
        		return $theme['theme_id'];
        	}       	
        }   
        return $info['cmsSite']['theme_id'];
    }

}