<?php
namespace common\helpers;
use common\models\GhSite;
use Yii;
use common\models\CmsSite;
use yii\web\NotFoundHttpException;
use common\models\FriendLink;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/7
 * Time: 11:26
 */

class SiteHelper {
    static public $SITE_TYPE_DEMO = 1;
    static public $SITE_TYPE_STANDARD = 2;

    static public function getDefaultSiteConfig() {
        return [
            'id' => 0,
            'user_id' => 0,
            'host_name' => '',
            'type' => 0,
            'theme_id' => 0,
            'theme_code' => 'red',
            'theme_start_at' => 0,
            'theme_expired_at' => 0,
            'plan_id' => 0,
            'plan_start_at' => 0,
            'plan_expired_at' => 0,
            'status' => 10,
        ];
    }


    static public function loadCurrentSiteConfig() {
        $request = Yii::$app->request;
        $hostName = $request->hostInfo;
        //用户传入的site id
        $paramSiteId = $request->get('id', 0);

        //去掉前缀
        if (strpos($hostName, "http://") === 0) {
            $hostName = str_replace("http://", '', $hostName);
        }

        if (strpos($hostName, "https://") === 0) {
            $hostName = str_replace("https://", '', $hostName);
        }

        $site = [];
        if ($hostName == "localhost" || $hostName == "127.0.0.1" || $hostName == "demo.bothsite.com") {
            if ($paramSiteId != 0) {
                $site = GhSite::find()->where(['id' => $paramSiteId, 'type' => SiteHelper::$SITE_TYPE_DEMO])->asArray()->one();
            }
        }
        else {
            $site = GhSite::find()->where(['host_name' => $hostName, 'type' => SiteHelper::$SITE_TYPE_STANDARD])->asArray()->one();
        }

        if (empty($site)) {
            //不存在对应的站点
            throw new NotFoundHttpException(\Yii::t('app', '您访问的站点不存在或已过期'));
        }

        return $site;
    }

    static public function loadSiteTheme($site_id) {

    }

    static public function loadSiteLang($site_id) {

    }

    static public function setCurrentSiteConfig($a) {
        CacheHelper::setCache('siteConfig_'.$a['id'], $a);
    }

    static public function getCurrentSiteConfig($site_id) {
        return CacheHelper::getCache('siteConfig_'.$site_id);
    }

    static public function getCurrentSiteId($hostName) {
        return CacheHelper::getCache('site_id_'.$hostName);
    }

    static public function setCurrentSiteId($hostName, $site_id) {
        CacheHelper::setCache('site_id_'.$hostName, $site_id);
    }

    static public function setCurrentSiteInfo($site_id, $lang_id) {
        $cms_site = CmsSite::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        CacheHelper::setCache('siteInfo_'.$site_id.'_'.$lang_id, $cms_site);
        return $cms_site;
    }

    static public function getCurrentSiteInfo($site_id, $lang_id) {
        return CacheHelper::getCache('siteInfo_'.$site_id.'_'.$lang_id);
    }
    
    static public function getUserAvatar($avatar) { 
        if (!empty($avatar))
        {
            return \Yii::getAlias('@web').$avatar;
        }
        else {
            return \Yii::getAlias('@web').'/images/avatar-default.png';
        }
    }
    
    static public function getImgSrc($img) { 
        if (!empty($img))
        {
            return \Yii::getAlias('@web').'../../backend/web'.$img;
            
            //return 'http://localhost:8080/ocean/backend/web'.$img;
        }
        else
        {
            return '';
        }
    }

    static public function getFriendlinkInfo()
    {
        $friend_link = FriendLink::find()->one();

        $friend_link->logo = "/ocean/backend/web".$friend_link->logo;

        return $friend_link;
    }
    
    static public function getTkUrl($val,$rel='',$value=''){
    	$info=[];
    	if(isset($val['cid'])){
    		return Url::to(['site/list','sname'=>$_SESSION['serial_id'],
    				'cid'=>$val['cid'],
    				$rel=>$value]);
    	}elseif (isset($val['txt'])){
    		return Url::to(['site/list','sname'=>$_SESSION['serial_id'],
    				'txt'=>$val['txt'],
    				$rel=>$value]);
    	}
    	elseif (isset($val['cid'])&&isset($val['txt'])){
    		return Url::to(['site/list','sname'=>$_SESSION['serial_id'],
    				'txt'=>$val['txt'],
    				'cid'=>$val['cid'],
    				$rel=>$value]);
    	}else{
    		return Url::to(['site/list','sname'=>$_SESSION['serial_id'],
    				$rel=>$value]);
    	}
    }
    
    static public function getListClass(){
    	return ['Sales_num','Sales_num','Quan_time','Quan_receive','Price'];
    }
}
