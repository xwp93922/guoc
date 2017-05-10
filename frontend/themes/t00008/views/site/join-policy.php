<?php

use yii\helpers\Url;
use common\models\CmsCategory;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use frontend\widgets\SiderBar\SiderBar;
$bundle = frontend\themes\t00008\AppAsset::register($this);

?>

<div class="content_df">
        <!--subPage-banner-->
        <div class="subPage-banner">
           <img src="<?php if (isset($category['banner'])) {echo SiteHelper::getImgSrc($category['banner']);}?>">
        </div>

        <div class="subPage-wrap">
            <div class="con_1200 clearfix">
                <div class="aside-box">
                    <div class="aside-block">
                        <p class="title-df">加盟政策<img src="<?= $bundle->baseUrl ?>/img/ico_square_white.png"></p>
                        <ul class="list-df">
                            <li class="li-df"><a href="<?= Url::toRoute(['site/policy','sname'=>$_SESSION['serial_id']]) ?>" class="row-item choice-on">加盟代理政策<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/show','sname'=>$_SESSION['serial_id']]) ?>"class="row-item ">加盟店展示<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/adv','sname'=>$_SESSION['serial_id']]) ?>"class="row-item ">加盟优势<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/profiti','sname'=>$_SESSION['serial_id']]) ?>"class="row-item ">盈利分析<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/style','sname'=>$_SESSION['serial_id']]) ?>"class="row-item ">加盟方式<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                        </ul>
                        <div class="tel-block">
                            <img class="tel-white" src="<?= $bundle->baseUrl ?>/img/item_white_tel.png">
                            <p class="row-1s">免费咨询热线</p>
                            <p class="row-2s"><?= $_SESSION['phone'] ?></p>
                        </div>
                    </div>
					<?= SiderBar::widget(['recommend_list'=>$recommend,'type'=>2])?>

                </div>


                <div class="content-box">
                    <p class="article-title clearfix"><em class=" line-df"></em><span>加盟代理政策<</span><i class="float-rt title-position">您的位置:首页>>加盟政策>>加盟代理政策<</i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">
                        <a class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p class="title-df" >加盟政策</p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                        <ul class="phone-class-list">
                            <li><a href="<?= Url::toRoute(['site/policy','sname'=>$_SESSION['serial_id']]) ?>" class="class-item">加盟代理政策<img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                            <li><a href="<?= Url::toRoute(['site/show','sname'=>$_SESSION['serial_id']]) ?>" class="class-item">加盟店展示<img  class="class-right"  src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                            <li><a href="<?= Url::toRoute(['site/adv','sname'=>$_SESSION['serial_id']]) ?>" class= "class-item">加盟优势<img class="class-right"  src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                            <li><a href="<?= Url::toRoute(['site/profiti','sname'=>$_SESSION['serial_id']]) ?>" class="class-item">盈利分析<img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                            <li><a href="<?= Url::toRoute(['site/style','sname'=>$_SESSION['serial_id']]) ?>" class="class-item">加盟方式<img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                        </ul>
                    </div>
                    <div class="article-content clearfix">
                        <p class="title-form">2016年蜜萨奇代理政策</p>
                        <p class="subtitle-form">（第二版）</p>
                        <p>一、代理政策：</p>

                        <table class="policy_form" cellpadding="0" cellspacing="0">
                            <colgroup>
                                <col class="row-1c">
                                <col class="row-2c">
                                <col class="row-3c">
                                <col class="row-4c">
                                <col class="row-5c">
                            </colgroup>
                            <tr class="ht_bold">
                                <td>代理级别</td>
                                <td>一级代理</td>
                                <td>二级代理</td>
                                <td>三级代理</td>
                                <td>四级代理</td>
                            </tr>

                            <tr>
                                <td class="ht_bold">代理地区</td>
                                <td>北京、上海、广州、深圳、天津、重庆</td>
                                <td>北京、上海、广州、深圳、天津、重庆、北京、上海、广州、深圳、天津、重庆、北京、上海、广州、深圳、天津、重庆、北京、上海、广州、深圳、天津、重庆</td>
                                <td>地级市</td>
                                <td>县、县级市以上市级区</td>
                            </tr>

                            <tr class="ht_bold">
                                <td class="ht_bold">代理费</td>
                                <td>180万元</td>
                                <td>80万元</td>
                                <td>40万元</td>
                                <td>县级市/县/市级区20万元</td>
                            </tr>

                            <tr>
                                <td class="ht_bold">保证金</td>
                                <td>5万元</td>
                                <td>2万元</td>
                                <td>1万元</td>
                                <td>1万元</td>
                            </tr>

                            <tr>
                                <td class="ht_bold">品牌使用费</td>
                                <td>免</td>
                                <td>免</td>
                                <td>免</td>
                                <td>免</td>
                            </tr>

                            <tr>
                                <td class="ht_bold">合同期</td>
                                <td>5年</td>
                                <td>5年</td>
                                <td>5年</td>
                                <td>5年</td>
                            </tr>

                            <tr>
                                <td class="ht_bold">公司支持</td>
                                <td>1、送价值10万元的店面装修；1、送价值10万元的店面装修；1、送价值10万元的店面装修</td>
                                <td>1、送价值6万多元的店面设备一套；2、送价值6万多元的店面设备一套</td>
                                <td>1、送价值5万元设备；2、送价值1.5万元原材料</td>
                                <td>1、送价值5万元设备；2、送价值1.5万元原材料</td>
                            </tr>

                        </table>

                        <p>我是富文本！！！！！</p>
                    </div>
                    <div class="content-bottom-info">
                        <span class="content-info-label">此文关键词：</span><p>芋见甜品加盟店排行榜芋见甜品排行榜,芋见甜品排行榜,芋见甜品加盟店10大品牌,甜品店加盟10大品牌  </p><span class="visit-counts">访问量：1203</span>
                    </div>
                </div>
            </div>
        </div>

    </div>



<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_JOIN?>');
$('.list-aside-row').hover(function(){
	$(this).find('img').attr('src','<?= $bundle->baseUrl ?>/img/ico_right_on.png');
	$(this).find('a').css('color','#19a5b7');
},function(){
	$(this).find('img').attr('src','<?= $bundle->baseUrl ?>/img/ico_right_gray.png');
	$(this).find('a').css('color','#333');
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
