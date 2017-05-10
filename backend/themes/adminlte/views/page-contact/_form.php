<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use backend\assets\MapAsset;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageAbout */
/* @var $form yii\widgets\ActiveForm */
MapAsset::register($this);
?>

<div class="cms-page-about-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div class="form-tab tab-1">
    	<div class="row">
        	<div class="col-md-12 padding-1">
        		<?php 
                $pluginOptions = [
                    'showPreview' => true,
                    'showCaption' => true,
                    'showRemove' => false,
                    'showUpload' => false,
                ];
                if (!$model->isNewRecord && !empty($model->banner)) {
                    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->banner;
                    $pluginOptions['initialPreviewAsData'] = true;
                }
                ?>
                <?= $form->field($model, 'banner_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                    'pluginOptions' => $pluginOptions
                ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-6 padding-1">
        		<?= $form->field($model, 'top_banner_name')->textInput(['maxlength' => true]) ?>
        		<?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Your company\'s link man.')) ?>
        		<?= $form->field($model, 'qq')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s qq.')) ?>
        		<?php 
        		$pluginOptions = [
        		    'showPreview' => true,
        		    'showCaption' => true,
        		    'showRemove' => false,
        		    'showUpload' => false,
        		];
        		if (!$model->isNewRecord && !empty($model->wxopenid)) {
        		    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->wxopenid;
        		    $pluginOptions['initialPreviewAsData'] = true;
        		}
        		?>
                <?= $form->field($model, 'wxopenid_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
                    
                <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s Zipcode.')) ?>
                <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:50%;']) ?>
        	</div>
        	<div class="col-md-6 pull-right padding-1">
    			<?= $form->field($model, 'top_banner_desc')->textInput(['maxlength' => true]) ?>
        		<?= $form->field($model, 'phone')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Your company\'s link phone.')) ?>
        		<?= $form->field($model, 'telephone')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s link telephone.')) ?>
				<?= $form->field($model, 'email')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s email.')) ?>        		
        		<div class="form-group">
                    <label class="control-label"><?php echo Yii::t('app', 'Address');?></label>
                    <div class="input-group" id="id_address_input">
                    	<input type="text" id="cmspagecontact-address" class="form-control" name="CmsPageContact[address]" readonly="" value="<?php echo $model->address?>">
                    	<span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                    </div>
                    <div class="help-block"></div>
                </div>
                <?php 
        		$pluginOptions = [
        		    'showPreview' => true,
        		    'showCaption' => true,
        		    'showRemove' => false,
        		    'showUpload' => false,
        		];
        		if (!$model->isNewRecord && !empty($model->map_img)) {
        		    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->map_img;
        		    $pluginOptions['initialPreviewAsData'] = true;
        		}
        		?>
                <?= $form->field($model, 'map_img_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
                
        	</div>
        </div>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>  
var p = $("#id_address_input").AMapPositionPicker({
	<?php if (!empty($model->longitude) && !empty($model->latitude) && !empty($model->address)) {?>
	value:{longitude:<?php echo $model->longitude?>, latitude:<?php echo $model->latitude?>, address:'<?php echo $model->address?>'},
	<?php }?>
    fields: [
        {
            selector: '#id_lnglat',
            name: 'lnglat',
            formatter: '{longitude},{latitude}'
        }
    ]
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>