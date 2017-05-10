<?php

use yii\helpers\Url;
use common\models\CmsCategory;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use common\widgets\NewLinkPager;
use yii\base\Widget;
use common\widgets\NewLinkPager1;
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
                            <li class="li-df"><a href="<?= Url::toRoute(['site/brand','sname'=>$_SESSION['serial_id'],'cat_id'=>$val['id']]) ?>" class="row-item <?php if($list_now['id']==$val['id']){echo 'choice-on';}?>"><?= $val['name']?><i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
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
                    <p class="article-title clearfix"><em class=" line-df"></em><span><?= $list_now['name']?></span><i class="float-rt title-position">您的位置:品牌形象>><?= $list_now['name']?></i></p>

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

                    <ul class="article-content clearfix">
                        <?php if($brand){ ?>
	                        <?php foreach ($brand as $v){ ?>
	                        <li class="good-team">
	                            <dl>
	                                <dt class="img-case32"><a href="<?= Url::toRoute(['site/brand-detail','sname'=>$_SESSION['serial_id'],'id'=>($v->id)]) ?>"><img src="<?php echo $v->image_main ?>"></a></dt>
	                                <dd class="Item-describe"><a href="<?= Url::toRoute(['site/brand-detail','sname'=>$_SESSION['serial_id'],'id'=>($v->id)]) ?>"><?php echo $v->name ?></a></dd>
	                            </dl>
							</li>
	                        <?php } ?>
                        <?php } ?>
                    </ul>


                            <?= NewLinkPager::widget(['pagination' => $pagination]) ?>
                        	<?= NewLinkPager1::widget(['pagination' => $pagination]) ?>



                </div>
            </div>
        </div>

    </div>


<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_BRAND?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>