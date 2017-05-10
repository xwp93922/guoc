<?php

namespace frontend\assets;

use yii\web\AssetBundle;
/**
 * Main frontend application asset bundle.
 */
class AlbumAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist';
    public $css = [
    ];
    public $js = [
        'js/album.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
