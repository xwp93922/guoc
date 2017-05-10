<?php
use common\widgets\NewLinkPager;
use yii\helpers\Url;
use common\helpers\SiteHelper;
use common\models\CmsNav;

?>
<div class="example-frame-page">
<div class="example-frame-banner"<?php if (!empty($topBanner)) {echo ' style="background-image: url('.SiteHelper::getImgSrc($topBanner['pic']).');"';}?>>
    <div class="example-banner-info">
        <p class="example-banner-title"><?php if (!empty($mainDatas['albumConfig']['top_banner_name']))echo $mainDatas['albumConfig']['top_banner_name'];else echo '图册列表';?></p>
        <p class="example-banner-line"></p>
        <p class="example-banner-subTitle"><?php if (!empty($mainDatas['albumConfig']['top_banner_desc']))echo $mainDatas['albumConfig']['top_banner_desc'];else echo '专业的设计以及高规格开发';?></p>
    </div>
</div>

<div class="content-df">
    <div class="main-content clearfix">
        <ul class="example-content-list clearfix">
            <?php foreach( $albums as $a ){ ?>
                <li class="example-content-row" onclick="window.location.href='<?= Url::to(['site/album', 'sname'=>$_SESSION['serial_id'],'aid' => $a['id']]) ?>';">
                    <i class="example-triangle-df"></i>
                    <a class="example-content-item"><img src="<?= SiteHelper::getImgSrc($a['cover']); ?>"></a>
                </li>
            <?php } ?>
        </ul>
        <?= NewLinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>
</div>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsNav::TYPE_ALBUM?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>