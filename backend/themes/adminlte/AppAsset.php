<?php

namespace backend\themes\adminlte;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/dist';
    public $css = [
        'css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/adminlte.css',
        'css/skins/skin-green-light.min.css',
        'css/site.css',
    ];
    public $js = [
        'js/app.min.js',
        'js/params.js',
        'js/main.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
    
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
    
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
}
