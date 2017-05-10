<?php
namespace frontend\components;

use common\core\SiteCore;
use common\helpers\SiteHelper;
use common\helpers\ThemeHelper;
use Yii;
use yii\helpers\ArrayHelper;
use common\helpers\NavHelper;
use common\models\CmsSite;
use yii\web\NotFoundHttpException;
use yii\web\NotAcceptableHttpException;
use common\helpers\LangHelper;
use common\helpers\CacheHelper;
use common\models\CmsPageContact;
use common\helpers\CaseCategoryHelper;
use common\helpers\AlbumHelper;
use common\helpers\ServiceHelper;
use common\helpers\ShareHelper;
use common\helpers\InitHelper;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/6
 * Time: 16:39
 */

class Controller extends \yii\web\Controller {
    public $hostName;
    public $siteCore;
	public $siteId;
	public $langId;
	public $themeId;
	public $mainDatas;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            $siteCore = new SiteCore();
            $siteCore->init();
	
            $this->hostName = Yii::$app->request->hostInfo;
            $this->siteCore = $siteCore;
			$this->siteId = $siteCore->getSiteId();
			$this->langId = $siteCore->getSiteLangId();	
			/* 
            $themeId = $siteCore->getSiteThemeId();
            $themeCode = ThemeHelper::getThemeCodeById($themeId);
            
            if(!ThemeHelper::setThemeByCode($themeCode)){
            	return false;
            } */
			Yii::$app->cache->flush();
			$this->themeId = $siteCore->getSiteThemeId($this->siteId);
			  //$themeId=yii::$app->request->get('theme');
			$themeCode = ThemeHelper::getThemeCodeById($this->themeId);
			/* if($themeCode=='t00009'){
				InitHelper::initPage($this->siteId,$this->langId);
			} */
			if (!ThemeHelper::setThemeByCode($themeCode) ){
					return false;
			}
			
			$this->mainDatas=CacheHelper::getArrayList('siteinfo2'.$this->siteCore->getSiteInfo()['cmsSite']['site_id'], $this->siteCore->getSiteInfo());
			return true;
        } else {
            return false;
        }
    }
}
