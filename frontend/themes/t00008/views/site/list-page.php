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
                        <p class="title-df">新闻中心<img src="<?= $bundle->baseUrl ?>/img/ico_square_white.png"></p>
                        <?php if(!empty($categoryList)){ ?>
                        <ul class="list-df">
                        <?php foreach ($categoryList as $v) { ?>
                            <li class="li-df"><a class="row-item  <?php if($cate_now['id']==$v['id']) echo 'choice-on'?>" 
                            href="<?= Url::toRoute(['site/list','sname'=>$_SESSION['serial_id'],'cid'=>$v['id']]) ?>"><?= $v['name']?><i class="case-df"><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png"></i></a></li>
                         <?php } ?>
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
                    <p class="article-title clearfix"><em class=" line-df"></em><span>企业动态</span><i class="float-rt title-position">您的位置:首页>><?php if($category){echo $category['name'];}else{echo '';} ?></i></p>

                    <!--ipad 竖屏显示-->
                    <div class="ipad-display ipad-article-title">
                        <a class="title-back-black ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_back.png"></a>
                        <p class="title-df" >新闻中心</p>
                        <a class="class-btn ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_class_btn.png"><span>分类</span></a>
                        <?php if(!empty($categoryList)){ ?>
                        <ul class="phone-class-list">
                        <?php foreach ($categoryList as $v) { ?>
                            <li><a class="class-item" href="<?= Url::toRoute(['site/list','sname'=>$_SESSION['serial_id'],'cid'=>$v['id']]) ?>"><?= $v['name']?><img class="class-right" src="<?= $bundle->baseUrl ?>/img/ico_right_back.png"></a></li>
                        <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                    <?php if(!empty($list)){ ?>
                    <ul class="article-content">
                            <?php foreach ($list as $key=>$l){
								if($key==0){?>
								<li class="news-li news-li-first clearfix" >
                                    <a class="" href="<?= Url::to(['site/news','sname'=>$_SESSION['serial_id'],'id'=>$l['id']]) ?>">
		                            <i class="img-case-df"><img src="<?= SiteHelper::getImgSrc($l['image_main']) ?>"></i>
		                            <div class="news-li-describe">
		                                <div class="news-list-title">
		                                    <p> <em >[<?= $cate_now['name'] ?>]<?= $l['name'] ?></em></p>
		                                    <span class="time-df"><?= date('Y-m-d',$l['created_at']) ?></span>
		                                </div>
		                                <p class="news-list-row"><?php $l['summary']?></p>
		                            </div>
                                    </a>
                        		</li>
                            <?php }else{ ?>
                            <li class="news-li">
                                <div class="news-list-title">
                                    <img class="ico_route" src="<?= $bundle->baseUrl ?>/img/ico_route.png">
                                    <p><a href="<?= Url::to(['site/news','sname'=>$_SESSION['serial_id'],'id'=>$l['id']]) ?>"> [<?= $cate_now['name'] ?>]<?= $l['name'] ?> </a></p>
                                    <span class="time-df"> [ <?php echo date('Y-m-d',$l['created_at']);?> ]</span>
                                </div>
                            </li>
                            <?php }}?>                       
                    </ul>
                    <?php }?>
                           <?= NewLinkPager::widget(['pagination' => $pagination]) ?>
                </div>
            </div>
        </div>

    </div>


<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_NEWS?>');

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
