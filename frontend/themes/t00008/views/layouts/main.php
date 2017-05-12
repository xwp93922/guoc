<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use common\helpers\NavHelper;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use common\models\CmsCategory;
use common\helpers\UtilHelper;

$bundle = frontend\themes\t00008\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="author" content="深圳市光合科技有限公司">  
    <meta http-equiv = "X-UA-Compatible" content = "chrome=1" />
    <meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1, user-scalable=no" />
    <meta name= "format-detection" content= "telephone=no" />
      
    <link rel="icon" href="<?= $bundle->baseUrl ?>/img/site8.ico" type="image/x-icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title).' - '.$this->context->mainDatas['cmsSite']['name'] ?></title>
    <?php $this->head() ?>
</head>
<body class="home_frame" name="<?= $bundle->baseUrl ?>/js/jquery.bxslider.js">
<?php $this->beginBody() ?>
	<div class="flex-frame">
	        <!--header_df-->
	        <div class="header_df">
	            <!--header-wrap-->
	            <div class="header-wrap">
	                <a class="logo-box" href="<?= Url::to(['site/index']) ?>">
	                    <p class="logo-square"></p>
	                    <i class="logo-triangle"></i>
	                    <img class="img-logo" src="<?= SiteHelper::getImgSrc($this->context->mainDatas['cmsSite']['logo']) ?>">
	                </a>
	                <div class="tel-box">
	                    <p class="tel-label"><img src="<?= $bundle->baseUrl ?>/img/ico_tel.png">加盟热线</p>
	                    <p class="tel-num"><?= $this->context->mainDatas['contact']['phone'] ?></p>
	                </div>
	                <ul class="nav-box clearfix">
	                	<?php foreach( $this->context->mainDatas['navs'] as $key => $nav ){ ?>
	                		<li><a  rel="<?php if($nav['type']==CmsNav::TYPE_CATEGORY){ echo $nav['categroy'][0]['type'];}else{echo $nav['type'];} ?>" ext="<?= $nav['ext_id'] ?>"  href="<?= NavHelper::getNavUrl($nav)?>" class="nav-item"><?= $nav['name']?></a></li>
	                	<?php }?>
	                    <!-- <li><a class="nav-item nav-item-on">首页</a></li> -->
	                </ul>
	            </div>
	            <!--header-phone-->
	            <div class="header-phone">
	                <a href="<?= Url::to(['site/index']) ?>" class="phone-logoBox">
	                    <img src="<?= SiteHelper::getImgSrc($this->context->mainDatas['cmsSite']['logo']) ?>">
	                </a>
	                <div class="phone-hd-rt">
	                    <p class="rt-first">甜品中的风尚</p>
	                    <p class="rt-second">台湾经典味道</p>
	                    <p class="rt-third">加盟热线：<?= $this->context->mainDatas['contact']['phone'] ?></p>
	                </div>
	            </div>
	        </div>    
	<?= $content ?>
	
	 <div class="footer_df">
            <div class="footer-wrap">
                <p class="footer-title"><?= $this->context->mainDatas['cmsSite']['name'] ?></p>
                <p class="footer-nav">
                    <i >友情链接 /link: </i>
                    <?php if(!empty($this->context->mainDatas['links'])){
                    	foreach ($this->context->mainDatas['links'] as $link){?>
                    	<a class="ht_click-active" href="<?= $link['site_url'] ?>" ><?= $link['name'] ?></a>
                    <?php
                    	 }
                    }?>
                </p>
                <div class="footer-content">
                    <ul class="ft-content-nav ">
                        <li><a href="<?= Url::to(['site/index']) ?>" class="ht_click-active">芋见甜品首页</a>|</li>
                        <li><a href="<?= Url::to(['site/about']) ?>" class="ht_click-active">品牌起源</a>|</li>
                        <li><a href="<?= Url::to(['site/products']) ?>" class="ht_click-active">甜品展示</a>|</li>
                        <li><a href="<?= Url::to(['site/adv']) ?>" class="ht_click-active">加盟优势</a>|</li>
                        <li><a href="<?= Url::to(['site/policy']) ?>" class="ht_click-active">加盟政策</a>|</li>
                        <li><a href="<?= Url::to(['site/index']) ?>" class="ht_click-active">在线加盟</a>|</li>
                        <li><a href="<?= Url::to(['site/list']) ?>" class="ht_click-active">加盟资讯</a>|</li>
                        <li><a href="<?= Url::to(['site/index']) ?>" class="ht_click-active">荣誉证书</a>|</li>
                        <li><a href="<?= Url::to(['site/problem']) ?>" class="ht_click-active">加盟问题</a>|</li>
                        <li><a href="<?= Url::to(['site/about']) ?>" class="ht_click-active">关于我们</a></li>
                    </ul>
                    <div class="footer-info">
                        <img class="footer-logo" src="<?= SiteHelper::getImgSrc($this->context->mainDatas['cmsSite']['footer_logo']) ?>">
                        <p class="ft-info-title">甜品加盟热线</p>
                        <p class="ft-info-num"><?= $this->context->mainDatas['contact']['phone'] ?></p>
                        <p class="ft-info-describe"><?= $this->context->mainDatas['cmsSite']['name']?></p>
                        <p class="ft-info-describe">地址：<?= $this->context->mainDatas['contact']['address'] ?></p>
                        <img class="footer-QR" src="<?= $bundle->baseUrl ?>/img/footer_QR.png">
                    </div>
                </div>
                <p class="footer-about-row"><a class="tec-support" target="_blank" href="http://www.bothsite.com/">博赛云站</a></p>
            </div>
        </div>	
	</div>

<?php $this->endBody() ?>
</body>
</html>
<<script type="text/javascript">
//***************    首页加盟咨询**************************
function changeImg(){
	$('#cap').next().attr('src','<?php echo Url::toRoute(['site/sign-captcha'])?>')
}
$('#join').on('click',function(){
	 var name=$('#name').val();
	 var phone=$('#phone').val();
	 var mail=$('#mail').val();
	 var txt=$('textarea ').val();
	 var cap=$('#cap').val();
	 $.post(
	            '<?php echo Url::toRoute(['site/info'])?>',
	            {
	                name:name,
	                phone:phone,
	                mail:mail,
	                txt:txt,
	                cap:cap
	            },
	            function (data){
	                alert(data.msg);
	            },
	            'json'
	   	);
})
</script>
<?php $this->endPage() ?>
