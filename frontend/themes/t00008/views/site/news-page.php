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
                <div class="aside-box aside-right">
                    <div class="aside-block-right">
	                    <?php if(!empty($recommendList)){?>
	                        <p class="title-df">相关推荐</p>
	                        <ul class="aside-right-content">
	                        <?php foreach ($recommendList as $k => $v) {
	                        if($k<10){?>
	                            <li class="aside-right-row">
	                                <i class="label-df"><?= $k+1?></i>
	                                <p><a href="<?= Url::toRoute(['site/news','sname'=>$_SESSION['serial_id'],'id'=>$v['id']]) ?>"><?=$v['name'] ?></a></p>
	                            </li>
	                        <?php } }?>  
	                        </ul>
	                    <?php }?>
                    </div>

                    <div class="aside-block-right">
                    <?php if(!empty($newsList)){ ?>
                        <p class="title-df">最新咨询文章</p>
                        <ul class="aside-right-content">
                        <?php foreach ($newsList as $key => $val) {?>
                            <li class="aside-right-row">
                                <i class="label-df"><?= $key+1 ?></i>
                                <p><a href="<?= Url::toRoute(['site/news','sname'=>$_SESSION['serial_id'],'id'=>$val['id']]) ?>"><?=$val['name'] ?></a></p>
                            </li>
                        <?php } ?>
                        </ul>
                    <?php }?>
                    </div>
				</div>
                <div class="content-box content-box-left">
                    <p class="article-title clearfix"><em class=" line-df"></em><span>资讯详情</span><i class="float-rt title-position">您的位置:首页>>资讯>>资讯详情</i></p>                    
                    <div class="article-content">
                        <div class="article-detail">
                        <?php if(is_object($news)){ ?>
                                <p class="article-detail-title"><?php echo $news->name; ?></p>
                                <p class="article-detail-subTitle">发表时间：<?php echo date('Y-m-d',$news->created_at); ?>   <span class="pad-L10"><?php echo date('H-i',$news->created_at); ?></span></p>
                            </div>
                            <p><?php echo $news['content']?></p>
                            <img src="<?= $bundle->baseUrl ?>/img/itemH_slide.jpg">
                        <?php } ?>
                    </div>
                    <div class="content-bottom-info">
                        <span class="content-info-label">此文关键词：</span><p><?= $news['meta_keywords'] ?>  </p><span class="visit-counts">访问量：<?php if(is_object($news)){echo $news->view_count;}else{echo '0';} ?></span>
                    </div>
                </div>
                 <div class="aside-block aside-recommend newsDescribe_btRecommend">
                    <p class="title-df">相关推荐</p>
                    <?php if(!empty($recommend_pro)){?>
                    <ul class="list-df  clearfix">
                    <?php foreach ($recommend_pro as $key=>$pro)
                    	if($key<4){?>
                        <li class="li-img-df">
                            <i class="img-case43"><img  src="<?= $bundle->baseUrl ?>/img/aside-block.jpg"></i>
                            <a href="<?= Url::to(['site/product','sname'=>$_SESSION['serial_id'],'id'=>$pro['id']]) ?>" class="row-describe"><?= $pro['product_name'] ?></a>
                        </li> 
                        <?php }?>                    
                    </ul>
					<?php }?>
                </div>
            </div>
        </div>

    </div>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_NEWS?>');

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>