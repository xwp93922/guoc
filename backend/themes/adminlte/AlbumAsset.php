<?php

namespace backend\themes\adminlte;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class AlbumAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/dist';
    public $css = [
    ];
    public $js = [
        'js/album.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
