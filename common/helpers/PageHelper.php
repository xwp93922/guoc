<?php
namespace common\helpers;

use common\models\CmsNav;
use common\helpers\DataHelper;
use yii\helpers\Url;
use common\models\CmsCategory;
use backend;
use common\models\CmsProductCategory;
use common\models\CmsPage;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class PageHelper
{    
static public function getPageUrl($page){
    	$id=isset(\Yii::$app->session['serial_id'])?\Yii::$app->session['serial_id']:'';
    	if($id){
    		switch ($page['type'])
    		{
    			case CmsPage::TYPE_ABOUT:
    				return Url::to(['site/about','sname'=>$id,'about_id'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_CHANGE:
    				return Url::to(['site/change','sname'=>$id,'cid'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_EXAMPLE:
    				return Url::to(['site/example','sname'=>$id,'cid'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_NEWS:
    				return Url::to(['site/list','sname'=>$id,'id'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_ONBASE:
    				return Url::to(['site/onbase','sname'=>$id,'cut_id'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_COMPARE:
    				return Url::to(['site/compare','sname'=>$id,'cid'=>$page['id']]);
    				break;
    			default: return Url::to(['site/single-page','sname'=>$id,'id'=>$page['id']]);
    				
    		}
    	}else{
    		switch ($page['type'])
    		{
    			case CmsPage::TYPE_ABOUT:
    				return Url::to(['site/about','about_id'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_CHANGE:
    				return Url::to(['site/change','cid'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_EXAMPLE:
    				return Url::to(['site/example','cid'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_NEWS:
    				return Url::to(['site/list','id'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_ONBASE:
    				return Url::to(['site/onbase','cut_id'=>$page['id']]);
    				break;
    			case CmsPage::TYPE_COMPARE:
    				return Url::to(['site/compare','id'=>$tid]);
    				break;
    			default: return Url::to(['site/single-page','cid'=>$page['id']]);
    		}
    	}
        
        return '';
    }
    static public function isCustomPage( $type ){
        if( $type == 400 ){
            return true;
        }

        return false;
    }

}
