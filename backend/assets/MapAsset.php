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
class MapAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/dist';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD, 'charset'=>"UTF-8"];
    public $css = [
    ];
    public $js = [
        'http://webapi.amap.com/maps?v=1.3&key=ed1fafa0307bb4991da41f54d8a88b46',
        'js/bootstrap.AMapPositionPicker.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}        