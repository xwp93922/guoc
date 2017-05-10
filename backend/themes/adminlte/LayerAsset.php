<?php

namespace backend\themes\adminlte;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class LayerAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/dist/plugins/layer';
    public $css = [
    ];
    public $js = [
        'layer.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
