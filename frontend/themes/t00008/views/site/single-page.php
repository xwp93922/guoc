<?php
use common\models\CmsNav;
?>

<div class="news-frame-page">
<div class="content-df">
    <div class="main-content clearfix">
        <div class="news-article-box" style="width:100%;">
            <?php echo $model['content']?>
        </div>
    </div>

</div>
</div>

<?php $this->beginBlock('test') ?>  
setNavActive('<?php echo CmsNav::TYPE_PAGE?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>