<?php

namespace backend\themes\adminlte;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/dist/plugins/select2';
    public $css = [
        'select2.min.css',
    ];
    public $js = [
        'select2.min.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
