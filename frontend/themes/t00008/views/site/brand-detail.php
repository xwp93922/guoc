<?php

use yii\helpers\Url;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use common\widgets\NewLinkPager;
use common\models\CmsCategory;
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
                        <p class="title-df">品牌形象<img src="<?= $bundle->baseUrl ?>/img/ico_square_white.png"></p>
                        
                        <?php if (!empty($list)){?>
                        <ul class="list-df">
                        <?php foreach ($list as $val) {?>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/brand','sname'=>$_SESSION['serial_id'],'cat_id'=>$val['id']]) ?>" class="row-item choice-on"><?= $val['name']?><i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                        <?php } ?>
                        </ul>
                        <?php } ?>
                        <div class="tel-block">
                            <img class="tel-white" src="<?= $bundle->baseUrl ?>/img/item_white_tel.png">
                            <p class="row-1s">免费咨询热线</p>
                            <p class="row-2s"><?= $_SESSION['phone'] ?></p>
                        </div>
                    </div>
					<?= SiderBar::widget(['recommend_list'=>$recommend,'type'=>2])?>
                </div>
            


                <div class="content-box">
                    <p class="article-title clearfix"><em class=" line-df"></em><span>品牌形象</span><i class="float-rt title-position">您的位置:首页>>品牌形象>>品牌形象详情</i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">

                        <a class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p class="title-df" >品牌形象</p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                       <?php if (!empty($list)){?>
                        <ul class="phone-class-list">
                            <?php foreach ($list as $val) {?>
                            <li><a class="class-item" href="<?= Url::toRoute(['site/brand','sname'=>$_SESSION['serial_id'],'cat_id'=>$val['id']]) ?>"><?= $val['name']?><img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                        <?php } ?>  
                        </ul>
                        <?php } ?>
                    </div>

                    <div class="article-content clearfix">
                    	<?php if($brand_detail){?>
                        	<?php echo $brand_detail['content']; ?>
                        <?php } ?>
                    </div>
                    <div class="content-bottom-info">
                        <span class="content-info-label">此文关键词：</span><p><?= $brand_detail['meta_keywords'] ?>  </p><span class="visit-counts">访问量：<?php if($brand_detail){echo $brand_detail['view_count'];}else{echo '0';} ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>


<script src="js/jquery.min.js"></script>
<script src="js/jquery.liMarquee.js"></script>
<script src="js/myJs.js"></script>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_BRAND?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>