<?php
namespace backend\widgets\CubeFileUploader;

use yii\base\Widget;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/21
 * Time: 13:56
 */

class CubeFileUploader extends Widget
{
    public function init()
    {
        parent::init();

        $this->registerAsset();
    }

    public function run()
    {
        return $this->render('uploader');
    }

    public function registerAsset() {
        $view = $this->getView();
        CubeFileUploaderAsset::register($view);
    }
}