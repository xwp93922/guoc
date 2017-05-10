<?php
use common\widgets\NewLinkPager;
use yii\helpers\Url;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use frontend\widgets\SiderBar\SiderBar;
$bundle = frontend\themes\t00008\AppAsset::register($this);
?>
    <!--content_df-->
    <div class="content_df">
        <!--subPage-banner-->
        <div class="subPage-banner">
            <img src="<?= $bundle->baseUrl ?>/img/subPage_banner.jpg">
        </div>

        <div class="subPage-wrap">
            <div class="con_1200 clearfix">
                <div class="aside-box">
                    <div class="aside-block">
                        <p class="title-df">甜品展示<img src="<?= $bundle->baseUrl ?>/img/ico_square_white.png"></p>
                        <ul class="list-df">
                        <?php foreach ($cts as $ct){?>
                            <li class="li-df"><a href="<?= Url::to(['site/products','sname'=>$_SESSION['serial_id'],'cid'=>$ct['id']]) ?> "class="row-item "><?= $ct['name'] ?><i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
						<?php }?>
                        </ul>
                        <div class="tel-block">
                            <img class="tel-white" src="<?= $bundle->baseUrl ?>/img/item_white_tel.png">
                            <p class="row-1s">免费咨询热线</p>
                            <p class="row-2s"><?= $_SESSION['phone'] ?></p>
                        </div>
                     </div>
					<?= SiderBar::widget(['recommend_list'=>$recommendList,'type'=>1])?>
                </div>


                <div class="content-box">
                    <p class="article-title clearfix"><em class=" line-df"></em><span>天然果茶</span><i class="float-rt title-position">您的位置:首页>>甜品展示</i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">
                        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p class="title-df" ><?= $model['product_name'] ?></p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                        <ul class="phone-class-list">
                        <?php foreach ($cts as $ct){?>
                           <li ><a href="<?= Url::to(['site/products','sname'=>$_SESSION['serial_id'],'cid'=>$ct['id']]) ?> "class="class-item ">
                           <?= $ct['name'] ?><img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
						<?php }?>
                        </ul>
                    </div>

                    <div class="article-content">
                                <div class="gd-box clearfix">
                                    <div class="gd-box-left">
                                        <i class="img-case43">
                                            <img id='product_url' src="<?= SiteHelper::getImgSrc($model['product_cover'])?>">
                                        </i>
                                        <!--slider-->
                                        <div class=" shop-slider-box clearfix" >
                                            <ul class="shop-slider-content">
                                            <?php if(!empty($model['skus'])){
                                            	foreach ($model['skus'] as $sku){
                                            	?>
                                                <li class=" slide" >
                                                    <i class="ht-slide-case on-slider"><img src="<?= SiteHelper::getImgSrc($sku['pic']) ?>"></i>
                                                </li>
											<?php }}?>
                                            </ul>
                                            <div class="swiper-button-prev swiper-df-left"></div>
                                            <div class="swiper-button-next swiper-df-right"></div>
                                        </div>
                                    </div>
                                    <div class="gd-box-right">
                                        <p class="title-df"><?= $model['product_name'] ?></p>
                                        <div class="shop-right-describe">
                                            <p class="shop-tel-p">咨询热线：<span class="tel-df">4006-782-781</span></p>
                                            <P class="shop-online-btn ht_click-active">在线咨询</P>

                                        </div>
                                    </div>
                                </div>
                        <div class="shopDrink-list">
                            <p class="shopDrink-title">相关推荐</p>
                            <ul class="shop-color-list clearfix">
                            	<?php foreach ($recommendList as $key=>$re)
                        		if($key<4){{?>
		                            <li class="li-img-df">
		                                <i class="img-case43"><img  src="<?= SiteHelper::getImgSrc($re['product_cover'])?>"></i>
		                                <p><?= $re['product_name'] ?></p>
		                            </li>
                         		<?php }}?>  
                            </ul>
                        </div>
                        <div class="proDetail-contactUs">
                            <p class="btn-bar clearfix">
                                <i class="btn-df btn-choice-on" id="pro-detail-btn">产品详情</i>
                                <i class="btn-df" id="list-contact-btn">联系我们</i>
                            </p>
                            <div class="tab-pro">
                                <?= $model['product_content'] ?>
                            </div>
                            <div class="tab-contact">
                                <p class="content-subTitle font18">甜品的新世代，一定要抓紧这次商机！</p>
                                <p>财富热线：<?= $contact['phone'] ?></p>
					            <p>邮      箱：<?= $contact['email'] ?></p>
					            <p>公司网址：<?= $web['host_name']?></p>
					            <p>运营中心：<?= $contact['address'] ?></p>
                                <img src="<?= $contact['map_img'] ?>">
                            </div>
                        </div>

                        <div class="pro-info">
                            <p class="pro-info-title">香橙沙冰</p>
                            <div class="pro-info-content clearfix" >
                                <p>咨询：香橙沙冰</p>
                                <div class="box-left">
                                    <p class="pro-info-row"><label>联系人</label><input type="text" placeholder="请填写联系人" autocomplete="off"></p>
                                    <p class="pro-info-row"><label>手机号码</label><input type="text" placeholder="请填写正确的手机号码" autocomplete="off"></p>
                                    <p class="pro-info-row"><label>电子邮箱</label><input type="text" placeholder="请填写正确的电子邮箱" autocomplete="off"></p>
                                    <div class="clearfix">
                                        <p class="pro-info-row check-df"><label>验证码</label><input type="text" placeholder="请填写验证码" autocomplete="off"></p>
                                        <img class="check-img" onclick="changeImg()" src="<?php echo Url::toRoute(['site/sign-captcha','sname'=>$_SESSION['serial_id']])?>">
                                    </div>
                                    <button type="button" class="pro_submit_btn ht_click-active">提交您的咨询信息</button>
                                </div>
                                <div class="box-right">
                                    <textarea class="pro-info-area" placeholder="请填写你要咨询的信息" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

    </div>
 <?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsNav::TYPE_PRODUCT?>');
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>