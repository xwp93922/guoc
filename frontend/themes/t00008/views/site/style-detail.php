<?php

use yii\helpers\Url;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use common\models\CmsCategory;
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
                          <li class="li-df"><a href="<?= Url::toRoute(['site/policy','sname'=>$_SESSION['serial_id']]) ?>" class="row-item ">加盟代理政策<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/show','sname'=>$_SESSION['serial_id']]) ?>"class="row-item ">加盟店展示<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/adv','sname'=>$_SESSION['serial_id']]) ?>"class="row-item ">加盟优势<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/profiti','sname'=>$_SESSION['serial_id']]) ?>"class="row-item ">盈利分析<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                            <li class="li-df"><a href="<?= Url::toRoute(['site/style','sname'=>$_SESSION['serial_id']]) ?>"class="row-item choice-on">加盟方式<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
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
                    <p class="article-title clearfix"><em class=" line-df"></em><span>加盟方式</span><i class="float-rt title-position">您的位置:首页>>加盟代理政策>>加盟方式</i></p>

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
					<?= $joinStyle['content']?>
                    <div class="content-bottom-info">
                        <span class="content-info-label">此文关键词：</span><p><?= $joinStyle['meta_keywords'] ?>  </p><span class="visit-counts">访问量：<?= $joinStyle['view_count'] ?></span>
                    </div>
                </div>
        </div>
    </div>



<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_JOIN?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
