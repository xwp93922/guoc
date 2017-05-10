<?php

namespace frontend\assets;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class ViewerAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD, 'charset'=>"UTF-8"];
    public $css = [
        'css/viewer.min.css'
    ];
    public $js = [
        'js/viewer.min.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
