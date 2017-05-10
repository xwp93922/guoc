<?php

namespace backend\themes\adminlte;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class LangAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/dist';
    public $css = [
    ];
    public $js = [
        'js/lang.js',
    ];
    public $depends = [
        'backend\themes\adminlte\ICheckAsset'
    ];
}
