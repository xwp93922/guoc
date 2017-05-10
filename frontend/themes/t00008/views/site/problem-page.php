<?php

use yii\helpers\Url;
use common\helpers\SiteHelper;
use common\models\CmsNav;
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
	                    <?php if(!empty($recommend)){?>
	                        <p class="title-df">相关推荐</p>
	                        <ul class="aside-right-content">
	                        <?php foreach ($recommend as $k => $v) {
	                        if($k<10){?>
	                            <li class="aside-right-row">
	                                <i class="label-df"><?= $k+1?></i>
	                                <p><?=$v['name'] ?></p>
	                            </li>
	                        <?php } }?>  
	                        </ul>
	                    <?php }?>
                    </div>

                    <div class="aside-block-right">
                    <?php if(!empty($newslist)){ ?>
                        <p class="title-df">最新咨询文章</p>
                        <ul class="aside-right-content">
                        <?php foreach ($newslist as $key => $val) {?>
                            <li class="aside-right-row">
                                <i class="label-df">$key+1</i>
                                <p><?=$val['name'] ?></p>
                            </li>
                        <?php } ?>
                        </ul>
                    <?php }?>
                    </div>
				</div>

                <div class="content-box content-box-left">
                    <p class="article-title clearfix"><em class=" line-df"></em><span>常见问题</span><i class="float-rt title-position">您的位置:首页>>常见问题>>问题详情</i></p>
                    
                    <div class="article-content">
                    <?php if(is_object($info)){ ?>
                        <div class="article-detail">                        
                            <p class="article-detail-title"><?php echo $info->name; ?></p>
                            <p class="article-detail-subTitle">发表时间：<?php echo date('Y-m-d',$info->created_at); ?>   <span class="pad-L10"><?php echo date('H:i',$info->created_at); ?></span></p>                        
                        </div>
                        <p><?php echo $info->content; ?></p>
                        <?php } ?>

                    </div>
                    <div class="content-bottom-info">
                        <span class="content-info-label">此文关键词：</span><p><?= $info['meta_keywords']?> </p><span class="visit-counts">访问量：<?php echo is_object($info) ? $info['view_count'] : '0'; ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsCategory::CATE_QUESTION?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>