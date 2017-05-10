<?php
use yii\helpers\Url;
use common\helpers\SiteHelper;
use frontend\assets\ViewerAsset;
use frontend\assets\AlbumAsset;
use common\models\CmsNav;

AlbumAsset::register($this);
ViewerAsset::register($this);
?>
<div class="news-frame-page">
<div class="example-frame-banner"<?php if (!empty($topBanner)) {echo ' style="background-image: url('.SiteHelper::getImgSrc($topBanner['pic']).');"';}?>>
    <div class="example-banner-info">
        <p class="example-banner-title"><?php echo $album['name']?></p>
        <p class="example-banner-line"></p>
        <p class="example-banner-subTitle"><?php echo $album['desc']?></p>
    </div>
</div>
<div class="content-df">
    <div class="main-content clearfix">
        <div class="news-article-box" style="width:100%;">
            <div class="album-pic-list">
                      <ul id="images" class="pull-left">
                      	<?php foreach ($album->pics as $p) {?>
                		<li class="album-pic pull-left pointer">
                			<img src="<?php echo SiteHelper::getImgSrc($p->url)?>" />
                			<div class="name">
                    			<?php echo $p->name?>
                    		</div>
                    		<div class="showbig" rel="<?php echo \Yii::getAlias('@web').$p->url;?>">预览</div>
                    		<div class="mask_layout">&nbsp;</div>
                		</li>
                		<?php }?>
                		<div class="clear"></div>
                      </ul>
                	<div class="clear"></div>
                	</div>
        </div>
    </div>

</div>
</div>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsNav::TYPE_ALBUM?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>