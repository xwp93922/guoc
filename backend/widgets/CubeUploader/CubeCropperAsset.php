<?php
namespace backend\widgets\CubeUploader;
use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/21
 * Time: 14:21
 */
class CubeCropperAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/CubeUploader/dist';
    public $css = [
        'css/cropper.min.css',
        'css/bootstrap-spinner.min.css',

    ];
    public $js = [
        'js/cropper.min.js',
        'js/jquery.spinner.min.js',
        'js/cubecropper.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}