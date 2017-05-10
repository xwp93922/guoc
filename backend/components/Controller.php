<?php
namespace backend\components;

use common\helpers\ThemeHelper;
use Yii;
use backend\helpers\SiteHelper;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/6
 * Time: 16:39
 */

class Controller extends \yii\web\Controller {
    public function beforeAction($action)
    {
        
        if (parent::beforeAction($action)) {
			\Yii::$app->cache->flush();
            if (!ThemeHelper::setThemeByCode("adminlte")) {
                return false;
            }
            
            \Yii::$app->language = 'zh-CN';
    
            \Yii::$app->params['site_id'] = SiteHelper::getSiteId();
            \Yii::$app->params['lang_id'] = SiteHelper::getLangId();
            
            ThemeHelper::checkAccess();

            return true;
        } else {
            return false;
        }
    }
}