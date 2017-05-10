<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 15/2/18
 * Time: 下午20:32
 */

namespace common\helpers;

use Yii;
use yii\helpers\Url;
use yii\imagine\Image;
use dosamigos\qrcode\QrCode; 
use common\models\GhSite;

class UtilHelper
{
    static public function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    static public function guid($separated = true)
    {
        // 生成一个随机的md5串, 然后通过分割来 获得guid
        mt_srand(( double )microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        if (!$separated) {
            return $charid;
        }

        $hyphen = chr(45); //'-'
        $uuid = substr($charid, 0, 8)
            . $hyphen
            . substr($charid, 8, 4)
            . $hyphen
            . substr($charid, 12, 4)
            . $hyphen
            . substr($charid, 16, 4)
            . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }
    
    static public function getUniqueId()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        
        return $orderSn;
    }

    static public function getSaveFilePath()
    {
        $folderPath = Yii::getAlias('@webroot') . '/uploads/images/' . date('Ymd') . '/' . date('H') . '/';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        return file_exists($folderPath) ? $folderPath : null;
    }

    static public function saveRemoteImgae($imageUrl) {
        $destFileName = UtilHelper::guid() . '.png';
        $destFilePath = '/uploads/images/' . date('Ymd') . '/' . date('H') . '/';

        $saveFilePath = Yii::getAlias('@webroot') . $destFilePath;
        if (!file_exists($saveFilePath))
        {
            mkdir($saveFilePath, 0777, true);
        }

        $filePath = Yii::getAlias('@webroot') . $destFilePath . $destFileName;
        $content = file_get_contents($imageUrl);
        file_put_contents($filePath, $content);


        $thumbnailPath =  $filePath . ".thumb.png";
        Image::thumbnail($filePath, 120, 120)->save($thumbnailPath, ['quality' => 50]);

        return  Yii::getAlias('@web') . $destFilePath . $destFileName;
    }

    /**
     * 多维数组去重
     * @param $arr
     * @param $key
     * @return mixed
     */
    static function assoc_unique($arr, $key)
    {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr))//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
            {
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }


    /**
     * 远程获取数据
     * @param $url
     * @param string $time_out
     * @param string $charset
     * @return string
     */
    static public function getHttpResponse($url, $time_out = "60", $charset = '')
    {
        $urlarr = parse_url($url);
        $errno = "";
        $errstr = "";
        $transports = "";
        $responseText = "";
        if ($urlarr["scheme"] == "https") {
            $transports = "ssl://";
            $urlarr["port"] = "443";
        } else {
            $transports = "tcp://";
            $urlarr["port"] = "80";
        }
        $fp = @fsockopen($transports . $urlarr['host'], $urlarr['port'], $errno, $errstr, $time_out);
        if (!$fp) {
            die("ERROR: $errno - $errstr<br />\n");
        } else {
            if (trim($charset) == '') {
                fputs($fp, "POST " . $urlarr["path"] . " HTTP/1.1\r\n");
            } else {
                fputs($fp, "POST " . $urlarr["path"] . '?_input_charset=' . $charset . " HTTP/1.1\r\n");
            }
            fputs($fp, "Host: " . $urlarr["host"] . "\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: " . strlen($urlarr["query"]) . "\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $urlarr["query"] . "\r\n\r\n");
            while (!feof($fp)) {
                $responseText .= @fgets($fp, 1024);
            }
            fclose($fp);
            $responseText = trim(stristr($responseText, "\r\n\r\n"), "\r\n");
            return $responseText;
        }
    }

    /**
     * 根据已有的筛选条件和新增的筛选条件生成对应的URL查询参数
     * @param array $newCon 新增的筛选条件
     * @param array $selected 已有的筛选条件
     */
    static public function newQueryParam($newCon, $selected)
    {
        $queryParams = "";
        //所有的筛选条件
        foreach ($newCon as $key => $val) {
            $selected[$key] = $val;
        }
        if (count($selected)) {
            $queryParams .= "&sl_attr=";
            $allVal = "";
            foreach ($selected as $key => $val) {
                $allVal .= "$key.$val,";
            }
            if ($allVal) {
                $allVal = substr($allVal, 0, -1);
                $allVal = base64_encode($allVal);
                $queryParams .= $allVal;
            }
        }

        return $queryParams;
    }


    /**
     * 生成大小写字母和数字组成的指定长度的随机字符串
     * @param integer $len 需要的字符串长度
     * @return string 生成的随机字符串
     */
    static public function generateRandString($len){
        $result = '';
        $charLibs = [ 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        while($len--){
            $result .= $charLibs[array_rand($charLibs)];
        }

        return $result;
    }

    /**
     * 通过curl发起http请求
     * @param string $url 请求的url
     * @param array|string $data 请求的参数
     * @param string $method 请求的方法
     * @return mixed 返回的信息
     */
    static public function sendHttpRequest($url, $data = [], $method ='get'){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $method = strtolower($method);
        //通过post发送时，设置发送的方法和数据
        if( $method == 'post' ){
            curl_setopt($ch, CURLOPT_POST, 1);

            if( is_array($data) && !empty($data) ){
                $data = http_build_query($data);
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    
    static public function getFirstWord($str)
    {
        $str = iconv("UTF-8", "gb2312", $str);
        
        for ($i=0;$i<strlen($str);$i++)
        {
            $fchar = ord($str{$i});
            if ($fchar>=ord("A") && $fchar<=ord("z"))return strtoupper($str{$i});
            $a = $str;
            $val=ord($a{$i})*256+ord($a{$i+1})-65536;
            if ($val>=-20319 && $val<=-20284)return "A";
            if ($val>=-20283 && $val<=-19776)return "B";
            if ($val>=-19775 && $val<=-19219)return "C";
            if ($val>=-19218 && $val<=-18711)return "D";
            if ($val>=-18710 && $val<=-18527)return "E";
            if ($val>=-18526 && $val<=-18240)return "F";
            if ($val>=-18239 && $val<=-17923)return "G";
            if ($val>=-17922 && $val<=-17418)return "H";
            if ($val>=-17417 && $val<=-16475)return "J";
            if ($val>=-16474 && $val<=-16213)return "K";
            if ($val>=-16212 && $val<=-15641)return "L";
            if ($val>=-15640 && $val<=-15166)return "M";
            if ($val>=-15165 && $val<=-14923)return "N";
            if ($val>=-14922 && $val<=-14915)return "O";
            if ($val>=-14914 && $val<=-14631)return "P";
            if ($val>=-14630 && $val<=-14150)return "Q";
            if ($val>=-14149 && $val<=-14091)return "R";
            if ($val>=-14630 && $val<=-13319)return "S";
            if ($val>=-13318 && $val<=-12839)return "T";
            if ($val>=-12838 && $val<=-12557)return "W";
            if ($val>=-12556 && $val<=-11848)return "X";
            if ($val>=-11847 && $val<=-11056)return "Y";
            if ($val>=-11055 && $val<=-10247)return "Z";
        }
    }
    
    /**
     *计算某个经纬度的周围某段距离的正方形的四个点
     *
     *@param lng float 经度
     *@param lat float 纬度
     *@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
     *@return array 正方形的四个点的经纬度坐标
     */
    static public function returnSquarePoint($lng, $lat,$distance = 0.5){
    
        $EARTH_RADIUS = 6371;
        $dlng =  2 * asin(sin($distance / (2 * $EARTH_RADIUS)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
    
        $dlat = $distance/$EARTH_RADIUS;
        $dlat = rad2deg($dlat);
    
        return array(
            'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
            'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
            'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
            'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
        );
    }
    
    //计算经纬度之间的距离，返回米
    //latitude维度
    //longitude精度
    static function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
        $latitude1 = doubleval($latitude1);
        $longitude1 = doubleval($longitude1);
        $latitude2 = doubleval($latitude2);
        $longitude2 = doubleval($longitude2);
        
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        //return compact('miles','feet','yards','kilometers','meters');
        return $meters;
    }
    
    static public function getKeyValue($arr,$key)
    {
        if (isset($arr[$key]))
        {
            return $arr[$key];
        }
        else
        {
            return null;
        }
    }


    static public function getIp()
    {
        if(getenv('HTTP_CLIENT_IP')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR')) {
            $onlineip = getenv('REMOTE_ADDR');
        } else {
            $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
        }
        return $onlineip;
    }
    
    static public function get_extension($file)
    {
        substr(strrchr($file, '.'), 1);
    }
    
    static public function createRq($dirname,$filename,$data)
    {
        $destFileName = $filename.'.png';
        $destFilePath = '/uploads/'.$dirname.'/';
        $saveFilePath = \Yii::getAlias('@webroot') . $destFilePath;
        if (!file_exists($saveFilePath))
        {
            mkdir($saveFilePath, 0777, true);
        }
        if (!file_exists($saveFilePath . $destFileName))
        {
            QrCode::png(json_encode($data),$saveFilePath . $destFileName);
        }
        
        return \Yii::getAlias('@web') . $destFilePath . $destFileName;
    }
    
    static public function getThumb($pic)
    {
        $a = explode('.', $pic);
        if (isset($a[1]))
        {
            return $pic.'.thumb.'.$a[1];
        }
    
        return '';
    }
    
    static public function DeleteImg($pic)
    {
        if (!empty($pic))
        {
            @unlink(Yii::getAlias('@webroot').$pic);
            @unlink(Yii::getAlias('@webroot').self::getThumb($pic));
        }
    }
    
    static public function upload($uploadedFile,$site_id,$dirName,$tW=120,$tH=120)
    {
        $destFilePath = '/uploads/'.$site_id.'/'.$dirName.'/' . date('Ymd') . '/';
        $saveFilePath = Yii::getAlias('@webroot') . $destFilePath;
        if (!file_exists($saveFilePath))
        {
            mkdir($saveFilePath, 0777, true);
        }
    
        $fileName = UtilHelper::guid() . "." . $uploadedFile->extension;
    
        $uploadedFile->saveAs($saveFilePath . $fileName);
    
        $thumbnailPath =  $saveFilePath . $fileName . ".thumb.".$uploadedFile->extension;
        Image::thumbnail($saveFilePath . $fileName, $tW, $tH)->save($thumbnailPath, ['quality' => 50]);
    
        return [
            'src' => $destFilePath . $fileName,
            'name' => $fileName,
            'size' => $uploadedFile->size
        ];
    }
    
    static public function subtext($text, $length)
    {
        if(mb_strlen($text, 'utf8') > $length)
            return mb_substr($text, 0, $length, 'utf8').'...';
            return $text;
    }
    static public function get_order_sn()
    {
    	/* 选择一个随机的方案 */
    	$yCode = array('A','B','C','D','E','F','G','H','I','J','L','M','N');
    	$order_sn = $yCode[intval(date('Y'))-2011]. strtoupper(dechex(date('m'))). date('d'). substr(time(),-5). substr(microtime(),2,5). sprintf('%02d', rand(0,99)).rand(1000,9999);
    	$count=GhSite::find()->Where(['key'=>$order_sn])->count();
    	if($count>0){
    		self::get_order_sn();
    	}
    	return $order_sn;
    }

    static public function random($len) {
    	$srcstr = "1a2s3d4f5g6hj8k9qwertyupzxcvbnm";
    	mt_srand();
    	$strs = "";
    	for ($i = 0; $i < $len; $i++) {
    		$strs .= $srcstr[mt_rand(0, 30)];
    	}
    	return $strs;
    }
    static public function captcha()
    {
    	$str = UtilHelper::random(4);
    
    	//验证码图片的宽度
    	$width  = 50;
    	
    	//验证码图片的高度
    	$height = 25;
    
    	//声明需要创建的图层的图片格式
    	@ header("Content-Type:image/png");
    
    	//创建一个图层
    	$im = imagecreate($width, $height);
    
    	//背景色
    	$back = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);
    
    	//模糊点颜色
    	$pix  = imagecolorallocate($im, 187, 230, 247);
    
    	//字体色
    	$font = imagecolorallocate($im, 41, 163, 238);
    
    	//绘模糊作用的点
    	mt_srand();
    	for ($i = 0; $i < 1000; $i++) {
    		imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pix);
    	}
    
    	//输出字符
    	imagestring($im, 5, 7, 5, $str, $font);
    
    	//输出矩形
    	imagerectangle($im, 0, 0, $width -1, $height -1, $font);
    
    	//输出图片
    	imagepng($im);
    
    	imagedestroy($im);
    
    	$str = md5($str);
    
    	return $str;
    }
} 
