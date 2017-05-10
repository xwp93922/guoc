<?php
use common\helpers\SiteHelper;
use common\models\CmsNav;
use yii\helpers\Url;
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
                        	 <li class="li-df"><a href="<?= Url::to(['site/team','sname'=>$_SESSION['serial_id']]) ?>" class="row-item choice-on">精英团队<i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                       		 <?php foreach ($about_list as $l){?>
                            <li class="li-df"><a href="<?= Url::to(['site/about', 'sname'=>$_SESSION['serial_id'],'about_id' => $l['id']]) ?>" class="row-item"><?= $l['name'] ?><i class="case-df"><img src="<?= SiteHelper::getImgSrc($l['cover']) ?>"></i></a></li>
                            <?php }?>
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
                    <p class="article-title clearfix"><em class=" line-df"></em><span>精英团队</span>
                    <i class="float-rt title-position">您的位置:首页>>芋见甜品>>精英团队</i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">
                        <a class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p class="title-df" >关于芋见甜品</p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                        <ul class="phone-class-list">
                        	<li><a class="class-item" href="<?= Url::to(['site/team', 'sname'=>$_SESSION['serial_id']])?>">精英团队<img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                            <?php foreach ($about_list as $l){?>
                            <li ><a class="class-item" href="<?= Url::to(['site/about', 'sname'=>$_SESSION['serial_id'],'about_id' => $l['id']]) ?>"><?= $l['name'] ?>
                             <img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></i></a></li>
                            <?php }?>
                        </ul>
                    </div>	
                    <?php if(!empty($teams)){?>	 
                     <ul class="article-content clearfix">
                     <?php foreach ($teams as $team){?>
                        <li class="good-team">
                            <dl>
                                <dt class="img-case32"><img src="<?= SiteHelper::getImgSrc($team['headnode']) ?>"></dt>
                                <dd class="Item-describe"><?= $team['name'] ?>/dd>
                            </dl>
                        </li>
                        <?php }?>
                    </ul>
                    <?php }?>
                </div>
            </div>
        </div>

    </div>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsNav::TYPE_PAGE_ABOUT?>');
$('body').css('background-color','#fff');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
