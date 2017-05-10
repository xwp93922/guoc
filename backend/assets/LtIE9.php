<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LtIE9 extends AssetBundle
{
    public $sourcePath = '@app/assets/dist';
    public $jsOptions = ['condition' => 'lte IE9', 'position' => \yii\web\View::POS_HEAD];
    public $css = [
        //'css/site.css',
    ];
    public $js = [
        'js/html5shiv.min.js',
        'js/respond.min.js',
    ];
    public $depends = [

    ];
}
