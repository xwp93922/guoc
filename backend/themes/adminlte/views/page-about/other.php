<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\DateTimePickerAsset;
use backend\themes\adminlte\PageAsset;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageContact */
$bundle = backend\themes\adminlte\AppAsset::register($this);
DateTimePickerAsset::register($this);
PageAsset::register($this);
$this->title = Yii::t('app', 'Update Cms Page About');
?>
<div class="row">
    <div class="col-md-12">
    	<div class="box box-success  bg-color-2">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="box-body ">
                	<div class="form-nav">
                    	<div class="form-nav-item" onclick="window.location.href='<?php echo Url::toRoute(['page-about/update','id'=>$about_id])?>';"><?php echo Yii::t('app', 'Basic Content')?></div>
                    	<div class="form-nav-item active"><?php echo Yii::t('app', 'Other content')?></div>
                    	<div class="clear"></div>
                    </div>
                    
                    <div class="cms-page-about-form padding-2">
                    	<div class="team-box">
                        	<div class="team-title"><?php echo Yii::t('app', 'Our teams');?></div>
                        	<div class="team-list">
                            	<?php foreach ($teams as $t) {?>
                            	<div class="team-item" onclick="window.location.href='<?php echo Url::toRoute(['about-team/update','id'=>$t->id])?>';">
                            		<div class="img" style="background-image:url(<?php echo \Yii::getAlias('@web').$t->headnode?>);"></div>
                            		<div class="name"><?php echo $t->name;?></div>
                            		<div class="profession"><?php echo $t->profession;?></div>
                            	</div>
                            	<?php }?>
                            	<div class="team-item" onclick="window.location.href='<?php echo Url::toRoute(['about-team/create','about_id'=>$about_id])?>';">
                            		<div class="img"><img class="add" src="<?= $bundle->baseUrl ?>/img/add_big_icon.png" /></div>
                            		<div class="name">&nbsp;</div>
                            		<div class="profession">&nbsp;</div>
                            	</div>
                            	<div class="clear"></div>
                            </div>
                        </div>
                        
                       	<div class="timeline-box">
                       		<div class="timeline-title"><?php echo Yii::t('app', 'Our timelines');?></div>
                       		<div class="timeline-list">
                       			<div class="timeline-item active">
                            		<div class="pull-left timeline-item-1">
                            			<div class="circle">&nbsp;</div>
                            			<div class="column-line">&nbsp;</div>
                            		</div>
                            		<div class="pull-left timeline-item-2">
                            			<textarea class="timeline-content" placeholder="<?php echo Yii::t('app', 'Required').', '.Yii::t('app', 'Specific content.');?>"></textarea>
                            		</div>
                            		<div class="pull-left timeline-item-3">
                            			<input type="text" readonly class="timeline-date pointer" placeholder="<?php echo Yii::t('app', 'Please select');?>" />
                            		</div>
                            		<div timeline_id="" class="pull-left timeline-item-4 save-timeline">
                            			<i class="fa fa-plus pointer"></i>
                            		</div>
                            		<div class="clear"></div>
                            	</div>
                            	<?php
                            	$count = count($timelines);
                            	$i=1;
                            	foreach ($timelines as $t) {?>
                            	<div class="timeline-item">
                            		<div class="pull-left timeline-item-1">
                            			<div class="circle">&nbsp;</div>
                            			<?php if ($i<$count) {?>
                            			<div class="column-line">&nbsp;</div>
                            			<?php }?>
                            		</div>
                            		<div class="pull-left timeline-item-2">
                            			<textarea class="timeline-content" placeholder="<?php echo Yii::t('app', 'Required').', '.Yii::t('app', 'Specific content.');?>"><?php echo $t->content?></textarea>
                            		</div>
                            		<div class="pull-left timeline-item-3">
                            			<input type="text" class="timeline-date pointer" readonly value="<?php echo $t->date;?>" placeholder="<?php echo Yii::t('app', 'Please select');?>" />
                            		</div>
                            		<div timeline_id="<?php echo $t->id?>" class="save-timeline pull-left timeline-item-4">
                            			<i class="fa fa-check pointer"></i>
                            		</div>
                            		<div class="pull-left timeline-item-4 delete-timeline" timeline_id="<?php echo $t->id?>">
                            			<i class="fa fa-times pointer"></i>
                            		</div>
                            		<div class="clear"></div>
                            	</div>
                            	<?php $i++;}?>
                            </div>
                       	</div>
                        
                        <div class="form-group text-center">
                            <?= Html::button(Yii::t('app', 'Pre page'), ['class' => 'btn btn-success btn-1','onclick'=>'window.location.href="'.Url::toRoute(['page-about/update','id'=>$about_id]).'";']) ?>
                        </div>
                    
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>

		<div class="page-data hide">
        	<span id="about_id"><?php echo $about_id;?></span>
        	<span id="save-timeline-url"><?php echo Url::to(['about-timeline/save'],true);?></span>
        	<span id="delete-timeline-url"><?php echo Url::to(['about-timeline/delete'],true);?></span>
        	<span id="delete-confirm-text"><?php echo Yii::t('yii', 'Are you sure you want to delete this item?');?></span>
        	<span id="new-timeline-error1"><?php echo Yii::t('app', 'Content').' '.Yii::t('app', 'can not be blank.');?></span>
        	<span id="new-timeline-error2"><?php echo Yii::t('app', 'Date').' '.Yii::t('app', 'can not be blank.')?></span>
        </div>

<?php $this->beginBlock('test') ?>  
setSideBarActive('page');
$('.timeline-date').datetimepicker({
	format: 'yyyy-mm-dd',
	language:  'zh-CN',
	weekStart: 1,
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	minView:2,
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>