<?php
namespace backend\widgets\CubeFileUploader;
use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/21
 * Time: 14:21
 */
class CubeFileUploaderAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/CubeFileUploader/dist';
    public $css = [
        'css/fileinput.min.css'
    ];
    public $js = [
        'js/fileinput.js',
        'js/cubefileuploader.js',
        'themes/fa/theme.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}