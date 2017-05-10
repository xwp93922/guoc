<?php

use yii\helpers\Url;
use common\models\CmsTheme;

$this->title = Yii::t('app', 'My themes');
?>

<div class="row">
    <div class="col-md-12">
    	<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo Yii::t('app', 'My theme');?></h3>
                </div>
                <div class="box-body ">
                	<div class="theme-list">
                	<?php foreach ($themes as $t) {?>
                	<div class="theme pull-left box_shadow_1<?php if ($t['status'] == CmsTheme::STATUS_USED) {echo ' active';}?>">
                		<div class="cover">
                			<?php if (!empty($t['theme']['image_pc'])) {?>
                			<img src="<?php echo \Yii::getAlias('@web').$t['theme']['image_pc']?>" />
                			<?php }?>
                		</div>
                		<div class="main">
                			<div class="info pull-left">
                				<span class="name"><?php echo $t['theme']['name']?></span>
                			</div>
                			
                			<div class="operate pull-right">
                				<?php if ($t['status'] == CmsTheme::STATUS_USED) {?>
                				<a class="text-green" href="javascript:;"><?php echo Yii::t('app', 'Using theme')?></a>
                				<?php }else {?>
                				<a href="<?php echo Url::toRoute(['cms-theme/use','id'=>$t['id']])?>"><?php echo Yii::t('app', 'Use theme')?></a>
                				<?php }?>
							</div>
                		</div>
                	</div>
                	<?php }?>
                	<div class="theme pull-left box_shadow_1 pointer" onclick="window.location.href='<?php echo Url::toRoute(['cms-theme/more'])?>';">
                		<div class="add-more">
                			<img src="<?php echo \Yii::getAlias('@web') ?>/images/more_theme.png" />
                		</div>
                	</div>
                	</div>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>

<?php $this->beginBlock('test') ?>  
setSideBarActive('settings');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>