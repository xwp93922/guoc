<?php
namespace common\widgets\KefuBox;
use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/4/23
 * Time: 09:53
 */
class KefuBoxAsset extends AssetBundle
{
    public $sourcePath = '@app/../common/widgets/KefuBox/dist';
    public $css = [
        'css/kefubox.css'
    ];
    public $js = [
        'js/kefubox.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}