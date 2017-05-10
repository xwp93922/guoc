<?php
namespace backend\widgets\CubeUploader;
use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/21
 * Time: 14:21
 */
class CubeUploaderAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/CubeUploader/dist';
    public $css = [
        'css/cubeuploader.css'
    ];
    public $js = [
        'js/cubeuploader.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}