<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SwitchAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/dist';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD, 'charset'=>"UTF-8"];
    public $css = [
        'css/bootstrap-switch.min.css',
    ];
    public $js = [
        'js/bootstrap-switch.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}        