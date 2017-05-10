<?php
namespace frontend\widgets\SiderBar;

use yii\base\Widget;
use common\models\CmsSite;
class SiderBar extends Widget{
	public $recommend_list;
	public $type;
	public function init()
	{
		parent::init();
	
		$this->registerAsset();
	}
	public function run(){
		return $this->render('SiderBar',[
				'recommend_list'=>$this->recommend_list,
				'type'=>$this->type]);
	}
	public function registerAsset() {
		$view = $this->getView();
	}
}