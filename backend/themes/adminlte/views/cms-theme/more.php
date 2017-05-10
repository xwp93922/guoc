<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-md-12">
    	<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo Yii::t('app', 'More theme');?></h3>
                </div>
                <div class="box-body">
                	<div class="theme-list">
                	<?php foreach ($themes as $t) {?>
                	<div class="theme pull-left box_shadow_1">
                		<div class="cover">
                			<?php if (!empty($t['image_pc'])) {?>
                			<img src="<?php echo \Yii::getAlias('@web').$t['image_pc']?>" />
                			<?php }?>
                		</div>
                		<div class="main">
                			<div class="info pull-left">
                				<span class="name"><?php echo $t['name']?></span>
                				<span class="price">￥<?php echo $t['price']?></span>
                				<span class="price-origin"><?php echo $t['price_origin']?></span>
                			</div>
                			
                			<div class="operate pull-right">
                				<a class="text-yellow" href="<?php echo Url::toRoute(['cms-theme/buy','id'=>$t['id']])?>"><?php echo Yii::t('app', 'Buy')?></a>
							</div>
                		</div>
                	</div>
                	<?php }?>
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