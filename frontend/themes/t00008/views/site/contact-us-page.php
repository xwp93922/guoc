<?php

use common\helpers\SiteHelper;
use common\models\CmsNav;
use yii\helpers\Url;
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
                        <p class="title-df">芋见甜品简介<img src="<?= $bundle->baseUrl ?>/img/ico_square_white.png"></p>
                        <ul class="list-df">
                            <?php if($about_list){ ?>
                            <?php foreach ($about_list as $l){?>
                            <li class="li-df"><a href="<?= Url::to(['site/contact', 'sname'=>$_SESSION['serial_id'],'con_id' => $l['id']]) ?>" 
                            class="row-item <?php if($list_now['id']==$l['id']) echo 'choice-on'?>"><?= $l['name'] ?><i class="case-df"><img src="<?= SiteHelper::getImgSrc($l['cover']) ?>"></i></a></li>
                            <?php }?>
                            <?php }?>
                        </ul>
                        <div class="tel-block">
                            <img class="tel-white" src="<?= $bundle->baseUrl ?>/img/item_white_tel.png">
                            <p class="row-1s">免费咨询热线</p>
                            <p class="row-2s"><?= $_SESSION['phone'] ?></p>
                        </div>
                     </div>
					<?= SiderBar::widget(['recommend_list'=>$articles,'type'=>2])?>

                </div>


                <div class="content-box">
                    <p class="article-title clearfix"><em class=" line-df"></em><span><?= isset($list_now['name'])?$list_now['name']:'联系我们' ?></span><i class="float-rt title-position">您的位置: 首页>><?= isset($list_now['name'])?$list_now['name']:'联系我们' ?></i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">
                        <a class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p class="title-df" ><?= isset($list_now['name'])?$list_now['name']:'联系我们' ?></p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                        <ul class="phone-class-list">
                           <?php if($about_list){ ?>
                            <?php foreach ($about_list as $l){?>
                            <li class="li-df"><a href="<?= Url::to(['site/contact', 'sname'=>$_SESSION['serial_id'],'about_id' => $l['id']]) ?>" class="row-item <?php if(isset($_GET['about_id'])&&($_GET['about_id']==$l['id'])) echo 'choice-on'?>"><?= $l['name'] ?><i class="case-df"><img src="<?= SiteHelper::getImgSrc($l['cover']) ?>"></i></a></li>
                            <?php }?>
                            <?php }?>
                        </ul>
                    </div>

                    <div class="article-content">
                    
                    <?php if($list_now['parent_id']==0){ ?>
                        <p class="content-subTitle font18"><?php echo $info['name']; ?></p>
                        <p class="font18">财富热线：<?php echo $info['phone']; ?></p>
                        <p class="font18">邮      箱：<?php echo $info['email']; ?></p>
                        <p class="font18">公司网址：<?php echo 'http://www.gohoc.com'; ?></p>
                        <p class="font18">运营中心：<?php echo $info['address']; ?></p>
                        <img src="<?= SiteHelper::getImgSrc($info['map_img']) ?>">
                    <?php  }else{?>
                    <?= $list_now['content'];} ?>
                    </div>
                    <div class="content-bottom-info">
                        <span class="content-info-label">此文关键词：</span><p><?= isset($list_now['meta_keywords'])?$list_now['meta_keywords']:'' ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsNav::TYPE_PAGE_CONTACT?>');
$('body').css('background-color','#fff');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>