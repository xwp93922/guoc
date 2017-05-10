<?php
namespace backend\widgets\SideBar;

use yii\base\Widget;
use backend\helpers\SiteHelper;
use yii\web\NotAcceptableHttpException;
use common\helpers\ThemeHelper;
/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/21
 * Time: 13:56
 */

class SideBar extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $features = ThemeHelper::getFeatures();
        
        $site_info = SiteHelper::getSiteInfo();
        
        return $this->render('sidebar',['features'=>$features,'site_info'=>$site_info]);
    }
}