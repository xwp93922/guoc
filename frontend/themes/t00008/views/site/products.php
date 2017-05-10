<?php
use common\widgets\NewLinkPager;
use yii\helpers\Url;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use frontend\widgets\SiderBar\SiderBar;
$bundle = frontend\themes\t00008\AppAsset::register($this);
?>
<div class="content_df">
        <!--subPage-banner-->
        <div class="subPage-banner">
            <img src="<?= $bundle->baseUrl ?>/img/subPage_banner.jpg">
        </div>

        <div class="subPage-wrap">
            <div class="con_1200 clearfix">
                <div class="aside-box">
                    <div class="aside-block">
                        <p class="title-df">芋见甜品简介<img src="<?= $bundle->baseUrl ?>/img/ico_square_white.png"></p>
                        <ul class="list-df">
                        <?php foreach ($cts as $ct){?>
                            <li class="li-df"><a href="<?= Url::to(['site/products','sname'=>$_SESSION['serial_id'],'cid'=>$ct['id']]) ?> "class="row-item 
                            <?php if($procate_now['id']==$ct['id']) echo 'choice-on'?>"><?= $ct['name'] ?><i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
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
                    <p class="article-title clearfix"><em class=" line-df"></em><span><?= $procate_now['name'] ?></span><i class="float-rt title-position">您的位置:首页>><?= $procate_now['name'] ?></i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">
                        <a class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p href="<?= $_SERVER['HTTP_REFERER'] ?>" class="title-df" ><?= $procate_now['name'] ?></p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                        <ul class="phone-class-list">
                          <?php foreach ($cts as $ct){?>
                           <li ><a href="<?= Url::to(['site/products','sname'=>$_SESSION['serial_id'],'cid'=>$ct['id']]) ?> "class="class-item ">
                           <?= $ct['name'] ?><img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
						<?php }?>
                        </ul>
                    </div>

                    <div class="article-content">
                        <ul class="drinks-list clearfix">
                        <?php foreach ($products as $product){?>                      
                            <li class="drinks-row">
                                <div class="row-case"><i class=" img-case43"><img onclick="window.location.href='<?= Url::to(["site/product","sname"=>$_SESSION["serial_id"],"id"=>$product["id"]]) ?> '"src="<?= SiteHelper::getImgSrc($product['product_cover']) ?>"></i></div>
                                <p class="row-describe describe-words"><?= $product['product_name'] ?></p>
                                <p class="row-describe describe-btn"><a class="ask-now-btn ht_click-active">立即咨询+</a><a href="<?= Url::to(['site/product','sname'=>$_SESSION['serial_id'],'id'=>$product['id']]) ?> " class="understand-infoBtn ht_click-active">了解详情+</a></p>
                            </li>
                           <?php }?> 
                        </ul>
                    </div>


                            <?= NewLinkPager::widget(['pagination' => $pagination]) ?>



                            <?= NewLinkPager::widget(['pagination' => $pagination]) ?>


                </div>
            </div>
        </div>
    </div>
<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsNav::TYPE_PRODUCT?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>