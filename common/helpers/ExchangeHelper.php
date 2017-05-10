<?php
namespace common\helpers;
use common\models\CmsConfigType;
use phpDocumentor\Reflection\Type;
use common\models\CmsIndexConfig;
use backend\helpers\SiteHelper;
// +----------------------------------------------------------------------
// | JuhePHP [ NO ZUO NO DIE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2015 http://juhe.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Juhedata <info@juhe.cn-->
// +----------------------------------------------------------------------

//----------------------------------
// 汇率调用示例代码 － 聚合数据
// 在线接口文档：http://www.juhe.cn/docs/80
//----------------------------------
class ExchangeHelper{

	
	/**
	 * 请求接口返回内容
	 * @param  string $url [请求的URL地址]
	 * @param  string $params [请求的参数]
	 * @param  int $ipost [是否采用POST形式]
	 * @return  string
	 */
	static private function juhecurl($url,$params=false,$ispost=0){
		$httpInfo = array();
		$ch = curl_init();
	
		curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if( $ispost )
		{
			curl_setopt( $ch , CURLOPT_POST , true );
			curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
			curl_setopt( $ch , CURLOPT_URL , $url );
		}
		else
		{
			if($params){
				curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
			}else{
				curl_setopt( $ch , CURLOPT_URL , $url);
			}
		}
		$response = curl_exec( $ch );
		if ($response === FALSE) {
			//echo "cURL Error: " . curl_error($ch);
			return false;
		}
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		return $response;
	}
		
	//************1.常用汇率查询************
	static public function getExchange(){
		$url = "http://op.juhe.cn/onebox/exchange/query";
		$params = array(
				"key" => \Yii::$app->params['appkey'],
		);
		$paramstring = http_build_query($params);
		$content = self::juhecurl($url,$paramstring);
		$result = json_decode($content,true);
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	
	//**************************************************
	

	//************2.货币列表************
	static public function getExchangeList(){
		$url = "http://op.juhe.cn/onebox/exchange/list";
		$params = array(
				"key" => \Yii::$app->params['appkey'],
		);
		$paramstring = http_build_query($params);
		$content = self::juhecurl($url,$paramstring);
		$result = json_decode($content,true);
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	
	//**************************************************
	
			
	//************3.实时汇率查询换算************
	static public function getExchangeCurrency(){
		$url = "http://op.juhe.cn/onebox/exchange/currency";
		$params = array(
				"from" => "",//转换汇率前的货币代码
				"to" => "",//转换汇率成的货币代码
				"key" => \Yii::$app->params['appkey'],
		);
		$paramstring = http_build_query($params);
		$content = self::juhecurl($url,$paramstring);
		$result = json_decode($content,true);
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	
	//**********4.淘客领券数据查询***************
	static public function getTaokeInfo(){
		$config_id=CmsConfigType::find()->select('id')->where(['feature'=>'10002','code'=>'appkey'])->asArray()->one();
		$appkey=CmsIndexConfig::find()->select('value')->where(['config_id'=>$config_id])->limit(1)->asArray()->one();
		$url='http://api.dataoke.com/index.php';
		$params=array(
				'r'=>'goodsLink/www',
				'type'=>'www_quan',
				'appkey'=>$appkey['value'],
				'v'=>2
		);
		$content = self::juhecurl($url,http_build_query($params));
		$result = json_decode($content,true);
		if($result){
			return $result;
		}else{
			return false;
		}
	}
}