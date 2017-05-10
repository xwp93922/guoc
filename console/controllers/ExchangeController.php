<?php
namespace  console\controllers;

use yii\web\Controller;
use common\helpers\ExchangeHelper;
use common\models\CmsExchange;
use yii\base\Object;
use common\models\TkTotal;
class ExchangeController extends Controller{
	
	static public function getExchange(){
		$data = ExchangeHelper::getExchange();
		$current_data= ExchangeHelper::getExchangeList();
		if(!empty($current_data)){
			$curren=$current_data['result']['list'];
		}
		if(!empty($data)){
			$exchange_data=$data['result']['list'];
		}
		if(!$data['error_code']){
			foreach ($exchange_data as $val){
				$info['name']=$val[0];
				$info['unit']=$val[1];
				$info['exc_buy']=$val[2];
				$info['cash_buy']=$val[3];
				$info['cash_sale']=$val[4];
				$info['dicount']=$val[5];
				$info['updated_at']=$data['result']['update'];
				foreach ($curren as $l){
					if($info['name']==$l['name']){
						$info['code']=$l['code'];
					}
				}
				$exchange=CmsExchange::find()->where(['name'=>$info['name']])->one();
				if(is_object($exchange)){
					CmsExchange::updateAll($info,['name'=>$info['name']]);
					//\Yii::$app->db->createCommand()->update('cms_excahnge', $info,'name='.$info['name']);
				}else{
					\Yii::$app->db->createCommand()->batchInsert('cms_exchange', ['name','code','unit','exc_buy','cash_buy','cash_sale','dicount','updated_at'], [$info])->execute();
// 					$model=new CmsExchange();
// 					$model->attributes=$info;
// 					$model->save();
				}
			}
		}
	}
	
	static public function getTaokeInfo(){
		$data=ExchangeHelper::getTaokeInfo()['data'];
		if(!empty($data)){
			foreach ($data['result'] as $key=>$val){
				$model=TkTotal::find()->where(['GoodsID'=>$val['GoodsID'],'Quan_id'=>$val['Quan_id']])->one();
				 if(is_object($model)){				 	
					TkTotal::updateAll($val,['Quan_id'=>$val['Quan_id']]);
				}else{ 
					$model=new TkTotal();
					$model->attributes=$val;
					$model->save(false);
			 	} 
			}
		}
	}
}