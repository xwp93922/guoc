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
                        <p class="title-df">常见问题<img src="<?= $bundle->baseUrl ?>/img/ico_square_white.png"></p>
                        <?php if($problem_child){ ?>
                            <ul class="list-df">                            
                                <?php foreach ($problem_child as $l){?>
                                <li class="li-df"><a href="<?= Url::to(['site/problem', 'sname'=>$_SESSION['serial_id'],'cat_id' => $l['id']]) ?>" 
                                class="row-item <?php if($problem_now['id']==$l['id']) echo 'choice-on'?>"><?= $l['name'] ?><i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                                <?php }?>
                            </ul>
                        <?php }?>
                        <div class="tel-block">
                            <img class="tel-white" src="<?= $bundle->baseUrl ?>/img/item_white_tel.png">
                            <p class="row-1s">免费咨询热线</p>
                            <p class="row-2s"><?= $_SESSION['phone'] ?></p>
                        </div>
                    </div>
					<?= SiderBar::widget(['recommend_list'=>$recommendList,'type'=>1])?>

                </div>


                <div class="content-box">
                    <p class="article-title clearfix"><em class=" line-df"></em><span><?= $problem_now['name'] ?></span><i class="float-rt title-position">您的位置:首页>><?= $problem_now['name'] ?></i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">
                        <a class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p class="title-df" >常见问题</p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                    <?php if($problem_child){ ?>
                        <ul class="phone-class-list">
                            <?php foreach ($problem_child as $l){?>
                            <li class="li-df"><a href="<?= Url::to(['site/problem', 'sname'=>$_SESSION['serial_id'],'cat_id' => $l['id']]) ?>" class="row-item <?php if(isset($_GET['cat_id'])&&($_GET['cat_id']==$l['id'])) echo 'choice-on'?>"><?= $l['name'] ?><i class="case-df"><img src="<?= SiteHelper::getImgSrc($l['image_node']) ?>"></i></a></li>
                            <?php }?>
                        </ul>
                    <?php }?>
                    </div>
                    <?php if (!empty($problem_list)){ ?>
                    <ul>
                       <?php foreach ($problem_list as $key=> $p){ 
							if($key==0){ ?>
								<li class="news-li news-li-first clearfix">
		                            <i class="img-case-df"><img src="<?= SiteHelper::getImgSrc($p['image_node'])?>"></i>
		                            <div class="news-li-describe">
		                                <div class="news-list-title">
		                                    <p> [<?= $p['name'] ?>]<a href="<?= Url::to(['site/problem-page','sname'=>$_SESSION['serial_id'],'id'=>$p['id']]) ?>"><?= $p['name']?></a> </p>
		                                    <span class="time-df"> [ <?=date('Y-m-d',$p['created_at'])?> ]</span>
		                                </div>		
		                                <p class="news-list-row"><a href="<?= Url::to(['site/problem-page','sname'=>$_SESSION['serial_id'],'id'=>$p['id']]) ?>"><?= $p['summary'] ?></a></p>
		                            </div>
		                        </li>	
							<?php }else{?>
                              <li class="news-li">
                           	  	<div class="news-list-title">
                              		<img class="ico_route" src="<?= $bundle->baseUrl ?>/img/ico_route.png">
                              		<p> [<?= $problem_now['name'] ?>]<a href="<?= Url::to(['site/problem-page','sname'=>$_SESSION['serial_id'],'id'=>$p['id']]) ?>"><?php echo $p['name']; ?> </a></p>
                              		<span class="time-df"> [ <?php echo date('Y-m-d',$p['created_at']); ?> ]</span>
                              	</div>
                              </li>
                           <?php }} ?>
                    </ul>
                    <?php }?>
                    <div class="content-bottom-goPage clearfix">
                        <div class="goPage-bar clearfix">
                            <?= NewLinkPager::widget(['pagination' => $pagination]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_QUESTION?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
