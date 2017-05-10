<?php
use yii\helpers\Url;
$bundle = backend\themes\adminlte\AppAsset::register($this);

$this->title = Yii::t('app', 'Lang settings');
?>
<div class="row">
	<div class="col-md-4">
		<div class="box box-success set-lang-box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo Yii::t('app', 'Lang list');?></h3>
            </div>
            <div class="box-body">
            	<div class="lang-list">
            		<?php foreach ($cmsLangs as $l) {?>
                	<div class="lang-item form-group row" cms_lang_id="<?php echo $l['id'];?>" lang_id="<?php echo $l['lang_id'];?>" name="<?php echo $l['name'];?>" flag="<?php echo $l['flag'];?>">
                		<div class="col-xs-5 text">
                          <input type="text" class="form-control no-bg text-center no-border" value="<?php echo $l['name'];?>" readonly>
                        </div>
                        <div class="col-xs-2 check text-center">
                            <span class="btn btn-success btn-xs set-check pointer"><?php echo Yii::t('app', 'Used');?></span>
                        </div>
                		<div class="col-xs-1 edit pointer">
                            <img class="fa-edit pointer" src="<?= $bundle->baseUrl ?>/img/edit_icon.png" />
                        </div>
                        <div class="col-xs-1 up pointer">
                            <img class="fa-arrow-up pointer" src="<?= $bundle->baseUrl ?>/img/up_icon.png" />
                        </div>
                        <div class="col-xs-1 down pointer">
                            <img class="fa-arrow-down pointer" src="<?= $bundle->baseUrl ?>/img/down_icon.png" />
                        </div>
                	</div>
                	<?php }?>
                	<?php foreach ($langs as $l) {?>
                	<div class="lang-item form-group row" cms_lang_id="" lang_id="<?php echo $l->id;?>" name="<?php echo $l->name;?>" flag="<?php echo $l->flag;?>">
                		<div class="col-xs-5 text">
                          <input type="text" class="form-control no-bg text-center no-border" value="<?php echo $l->name;?>" readonly>
                        </div>
                        <div class="col-xs-2 check text-center">
                            <span class="btn btn-default btn-xs set-check pointer"><?php echo Yii::t('app', 'Unused');?></span>
                        </div>
                		<div class="col-xs-1 edit pointer">
                            <img class="fa-edit pointer" src="<?= $bundle->baseUrl ?>/img/edit_icon.png" />
                        </div>
                        <div class="col-xs-1 up pointer">
                            <img class="fa-arrow-up pointer" src="<?= $bundle->baseUrl ?>/img/up_icon.png" />
                        </div>
                        <div class="col-xs-1 down pointer">
                            <img class="fa-arrow-down pointer" src="<?= $bundle->baseUrl ?>/img/down_icon.png" />
                        </div>
                	</div>
                	<?php }?>
            	</div>
            	<button type="button" id="save-langlist-btn" class="btn bg-olive pull-right"><?php echo Yii::t('app', 'Save')?></button>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
	
	<div class="col-md-3 hide set-lang-box">
		<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo Yii::t('app', 'Update lang');?></h3>
            </div>
            <div class="box-body">
                <div class="lang-edit-box">
                	<div class="form-group hide">
                      <label><?php echo Yii::t('app', 'ID');?></label>
                      <input type="text" class="form-control inputID">
                    </div>
                    
                    <div class="form-group hide">
                      <label><?php echo Yii::t('app', 'Flag');?></label>
                      <img class="thumbnail inputFlag hide" src="" width="100" />
                    </div>
                    
                  	<div class="form-group">
                      <label><?php echo Yii::t('app', 'Name');?></label>
                      <input type="text" class="form-control inputName" placeholder="<?php echo Yii::t('app', 'Name');?>">
                    </div>
                    
                    <div class="text-right">
                    	<button type="button" id="save-cmslang-btn" class="btn bg-olive "><?php echo Yii::t('app', 'Save')?></button>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
</div>
        
<div class="page-data hide">
	<span id="save-langlist-url"><?php echo Url::to(['cms-site-lang/save-list'],true);?></span>
	<span id="save-langitem-url"><?php echo Url::to(['cms-site-lang/save-item'],true);?></span>
	<span id="save-lang-error1"><?php echo Yii::t('app', 'Please select and save this lang.')?></span>
	<span id="save-lang-error2"><?php echo Yii::t('app', 'Please fill the name.')?></span>
	<span id="save-lang-error3"><?php echo Yii::t('app', 'Please select at least one.')?></span>
	<span id="used-lang"><?php echo Yii::t('app', 'Used')?></span>
	<span id="unused-lang"><?php echo Yii::t('app', 'Unused')?></span>
</div>
	
	
<?php $this->beginBlock('test') ?>  
setSideBarActive('settings');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>