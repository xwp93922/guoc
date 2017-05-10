<?php
namespace common\widgets\KefuBox;

use yii\base\Widget;
use Yii;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/4/23
 * Time: 09:50
 */
class KefuBox extends Widget
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        return $this->render('kefubox');
    }

}