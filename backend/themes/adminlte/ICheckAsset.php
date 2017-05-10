<?php

namespace backend\themes\adminlte;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class ICheckAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/dist/plugins/iCheck';
    public $css = [
        'all.css',
    ];
    public $js = [
        'icheck.min.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
