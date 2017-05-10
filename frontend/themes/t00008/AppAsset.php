<?php

namespace frontend\themes\t00008;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    const THEME_CODE = 't00008';
    public $sourcePath = '@app/themes/t00008/dist';
    public $css = [
        'css/jquery.bxslider.css?code=t00008',
        'css/bx_style.css?code=t00008',
        'css/default.css?code=t00008',
        'css/my_style.css?code=t00008',
    ];
    public $js = [
        'js/jquery.min.js?code=t00008',
    	'js/jquery.liMarquee.js?code=t00008', 
    	'js/jquery.bxslider.js?code=t00008',
        'js/bxDefault.js?code=t00008',   	
    	'js/myJs.js?code=t00008',
    	'js/respond.src.js?code=t00008',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
