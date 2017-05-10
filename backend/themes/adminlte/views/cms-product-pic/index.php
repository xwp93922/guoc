<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\themes\adminlte\AlbumAsset;
use backend\themes\adminlte\ViewerAsset;
use kartik\file\FileInput;

AlbumAsset::register($this);
ViewerAsset::register($this);
?>

<div class="row">
    <div class="col-md-12">
    	<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo Yii::t('app', 'Cms Product Sku').'：'.$sku->name;?></h3>
                  <p><?= Html::a(Yii::t('app', 'Back to Product Sku'), ['cms-product-sku/index','product_id'=>$sku->product_id], ['class' => 'btn btn-success']) ?></p>
                </div>
                <div class="box-body ">
                	<div class="album-pic-list">
                      <ul id="images" class="pull-left">
                      	<?php foreach ($pics as $p) {?>
                		<li class="album-pic pull-left pointer">
                			<img src="<?php echo \Yii::getAlias('@web').$p->image?>" />
                			<!-- <div class="name">
                    			<?php //echo $p->name?>
                    		</div> -->
                			<div class="delete" rel="<?php echo $p->id;?>"><i class="fa fa-times"></i></div>
                    		<div class="showbig" rel="<?php echo \Yii::getAlias('@web').$p->image;?>"><i class="fa fa-search-plus"></i></div>
                    		<div class="mask_layout">&nbsp;</div>
                		</li>
                		<?php }?>
                		<div class="clear"></div>
                      </ul>
                	<div id="add-pic" class="album-pic pull-left pointer box_shadow_1">
                		<div class="add-more text-green" data-toggle="modal" data-target="#myModal">
                			<i class="fa fa-plus"></i>
                		</div>
                	</div>
                	<div class="clear"></div>
                	</div>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo Yii::t('app', 'Add pic')?></h4>
            </div>
            <div class="modal-body">
            	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            		<input type="hidden" name="sku_id" value="<?php echo $sku->id?>" />
                    <?php 
                    $pluginOptions = [
                        'showPreview' => true,
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                        'maxFileCount' => 4
                    ];
                    ?>
                    <?= $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), ['options' => ['multiple'=>true, 'accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
                	<?= Html::submitButton(Yii::t('app', 'upload'), ['class'=>'btn btn-success']) ?>
                <?php ActiveForm::end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app', 'close')?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="page-data hide">
	<span id="delete-pic-url"><?php echo Url::to(['cms-product-pic/delete'],true);?></span>
</div>

<?php $this->beginBlock('test') ?>  
setSideBarActive('product');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>