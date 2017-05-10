<?php

namespace backend\themes\adminlte;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class ViewerAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/dist/plugins/viewer';
    public $css = [
        'viewer.min.css'
    ];
    public $js = [
        'viewer.min.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
