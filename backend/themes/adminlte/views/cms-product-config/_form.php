<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsProductConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-product-config-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div class="form-group field-cmsproductconfig-product_field required<?php if ($model->hasErrors('product_field'))echo ' has-error';?>">
        <label class="control-label" for="cmsproductconfig-product_field"><?php echo Yii::t('app', 'Product Field')?></label>
        <textarea id="cmsproductconfig-product_field" class="form-control hide" name="CmsProductConfig[product_field]"><?php echo $model->product_field?></textarea>
        <div style="padding:10px 20px;background-color:#f2f2f2;">
            <?php $model->product_field = explode(',', $model->product_field); foreach ($model->product_field as $f) {?>
            <div class="input-group m-t-10" style="width:30%;">
            	<input type="text" class="form-control" value="<?php echo $f?>">
            	<span class="input-group-addon pointer delete-field"><i class="fa fa-times"></i></span>
            </div>
            <?php }?>
            <div class="input-group m-t-10" style="width:30%;">
            	<input type="text" class="form-control" value="">
            	<span class="input-group-addon pointer add-field"><i class="fa fa-plus"></i></span>
            </div>
        </div>
        <div class="help-block"><?php if ($model->hasErrors('product_field'))echo $model->getErrors('product_field')[0];?></div>
    </div>

    <?= $form->field($model, 'product_order_btn')->textInput(['maxlength' => true,'style'=>'width:50%;']) ?>

    <?= $form->field($model, 'product_detail_title')->textInput(['maxlength' => true,'style'=>'width:50%;']) ?>

    <?= $form->field($model, 'product_detail_more_title')->textInput(['maxlength' => true,'style'=>'width:50%;']) ?>
    
    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->top_banner)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->top_banner;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'top_banner_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>

    <?= $form->field($model, 'top_banner_name')->textInput(['maxlength' => true,'style'=>'width:50%;']) ?>

    <?= $form->field($model, 'top_banner_desc')->textInput(['maxlength' => true,'style'=>'width:80%;']) ?>
    
    

    <?= $form->field($model, 'homepage_name')->textInput(['maxlength' => true,'style'=>'width:50%;']) ?>

    <?= $form->field($model, 'homepage_desc')->textInput(['maxlength' => true,'style'=>'width:80%;']) ?>

    <?= $form->field($model, 'more_btn_name')->textInput(['maxlength' => true,'style'=>'width:50%;']) ?>
    
    <?= $form->field($model, 'inquiry_title')->textInput(['maxlength' => true,'style'=>'width:60%;']) ?>
    
    <?= $form->field($model, 'inquiry_submit')->textInput(['maxlength' => true,'style'=>'width:60%;']) ?>

    <div class="form-group field-cmsproductconfig-inquiry_field required <?php if ($model->hasErrors('inquiry_field'))echo ' has-error';?>">
        <label class="control-label" for="cmsproductconfig-inquiry_field"><?php echo Yii::t('app','Inquiry Field');?></label>
        <textarea id="cmsproductconfig-inquiry_field" class="form-control hide" name="CmsProductConfig[inquiry_field]"></textarea>
       	<div style="padding:10px 20px;background-color:#f2f2f2;">
        <?php 
        $model->inquiry_field = json_decode($model->inquiry_field, true); 
        foreach ($model->inquiry_field as $f) {?>
        <div class="input-group-parent input-group m-t-10" style="width:30%;">
        	<div class="input-group">
                <div class="input-group-btn" rel="label">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'Field Name')?></button>
                </div>
                <!-- /btn-group -->
                <input type="text" class="form-control field-label" value="<?php echo $f['label']?>" required="required">
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="required">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'required')?></button>
                </div>
                <!-- /btn-group -->
                <select class="form-control field-required">
                	<option value="0"<?php if (isset($f['required']) && $f['required'] == 0)echo ' selected="selected"';?>><?php echo Yii::t('app', 'No')?></option>
                	<option value="1"<?php if (isset($f['required']) && $f['required'] == 1)echo ' selected="selected"';?>><?php echo Yii::t('app', 'Yes')?></option>
                </select>
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="type">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'type')?></button>
                </div>
                <!-- /btn-group -->
                <select class="form-control field-type">
                	<option value=""></option>
                		<option value="input-text"<?php if (isset($f['type']) && $f['type'] == 'input-text')echo ' selected="selected"';?>><?php echo Yii::t('app', 'input-text')?></option>
                		<option value="textarea"<?php if (isset($f['type']) && $f['type'] == 'textarea')echo ' selected="selected"';?>><?php echo Yii::t('app', 'textarea')?></option>
                	</select>
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="rule">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'rule')?></button>
                </div>
                <!-- /btn-group -->
                <select class="form-control field-rule">
                	<option value=""></option>
                		<option value="mobile"<?php if (isset($f['rule']) && $f['rule'] == 'mobile')echo ' selected="selected"';?>><?php echo Yii::t('app', 'mobile')?></option>
                		<option value="email"<?php if (isset($f['rule']) && $f['rule'] == 'email')echo ' selected="selected"';?>><?php echo Yii::t('app', 'email')?></option>
                	</select>
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="maxlength">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'maxlength')?></button>
                </div>
                <!-- /btn-group -->
                <input type="text" class="form-control field-maxlength" value="<?php echo isset($f['maxlength']) ? $f['maxlength']:'';?>">
              </div>
        	<span class="input-group-addon pointer delete-inquiry-field"><i class="fa fa-times"></i></span>
        </div>
        <?php }?>
        <div class="input-group-parent input-group m-t-10" style="width:30%;">
        	<div class="input-group">
                <div class="input-group-btn" rel="label">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'label')?></button>
                </div>
                <!-- /btn-group -->
                <input type="text" class="form-control field-label">
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="required">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'required')?></button>
                </div>
                <!-- /btn-group -->
                <select class="form-control field-required">
                		<option value="0"><?php echo Yii::t('app', 'No')?></option>
                		<option value="1"><?php echo Yii::t('app', 'Yes')?></option>
                	</select>
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="type">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'type')?></button>
                </div>
                <!-- /btn-group -->
                <select class="form-control field-type">
                	<option value=""></option>
                		<option value="input-text"><?php echo Yii::t('app', 'input-text')?></option>
                		<option value="textarea"><?php echo Yii::t('app', 'textarea')?></option>
                	</select>
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="rule">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'rule')?></button>
                </div>
                <!-- /btn-group -->
                <select class="form-control field-rule">
                	<option value=""></option>
                		<option value="mobile"><?php echo Yii::t('app', 'mobile')?></option>
                		<option value="email"><?php echo Yii::t('app', 'email')?></option>
                	</select>
              </div>
              <div class="input-group">
                <div class="input-group-btn" rel="maxlength">
                  <button type="button" class="btn btn-default"><?php echo Yii::t('app', 'maxlength')?></button>
                </div>
                <!-- /btn-group -->
                <input type="text" class="form-control field-maxlength">
              </div>
        	<span class="input-group-addon pointer add-inquiry-field"><i class="fa fa-plus"></i></span>
        </div>
        </div>
        <div class="help-block"><?php if ($model->hasErrors('inquiry_field'))echo $model->getErrors('inquiry_field')[0];?></div>
    </div>

    <?= $form->field($model, 'inquiry_email')->textInput(['maxlength' => true,'style'=>'width:60%;']) ?>
    
    <?= $form->field($model, 'blank_error')->textInput(['maxlength' => true,'style'=>'width:60%;']) ?>
    <?= $form->field($model, 'mobile_error')->textInput(['maxlength' => true,'style'=>'width:60%;']) ?>
    <?= $form->field($model, 'email_error')->textInput(['maxlength' => true,'style'=>'width:60%;']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>  
$('.delete-field').click(function(){
	deleteField($(this));
});
$('.add-field').click(function(){
	addField($(this));
});
function deleteField(obj)
{
	obj.parent().remove();
}
function addField(obj)
{
	var cl = obj.parent().clone();
    
    obj.find('i').removeClass('fa-plus').addClass('fa-times');
    obj.removeClass('add-field').addClass('delete-field');
    obj.parent().after(cl);
    
    $('.delete-field').unbind('click').click(function(){
    	deleteField($(this));
    });
    $('.add-field').unbind('click').click(function(){
    	addField($(this));
    });
}

$('.delete-inquiry-field').click(function(){
	deleteInquiryField($(this));
});
$('.add-inquiry-field').click(function(){
	addInquiryField($(this));
});
function deleteInquiryField(obj)
{
	obj.parent().remove();
}
function addInquiryField(obj)
{
	var cl = obj.parent().clone();
    
    obj.find('i').removeClass('fa-plus').addClass('fa-times');
    obj.removeClass('add-inquiry-field').addClass('delete-inquiry-field');
    obj.parent().after(cl);
    
    $('.delete-inquiry-field').unbind('click').click(function(){
    	deleteInquiryField($(this));
    });
    $('.add-inquiry-field').unbind('click').click(function(){
    	addInquiryField($(this));
    });
}

$("#w0").on("afterValidate", function (event, messages) {
  var fields = '';
  $('.field-cmsproductconfig-product_field').find('.input-group').each(function(){
  if ($(this).find('.form-control').val() != '')
  	fields += $(this).find('.form-control').val()+',';
  });
  if (fields != '')
  {
  	fields = fields.substr(0,fields.length-1);
  }
  $('#cmsproductconfig-product_field').val(fields);
  
  
  var inquiryFields = '';
  $('.field-cmsproductconfig-inquiry_field').find('.input-group-parent').each(function(){
  	var inquiryField = '';
  	if ($(this).find('.field-label').val() != '')
  	{
  		$(this).find('.input-group').each(function(){
          	inquiryField += '"'+$(this).find('.input-group-btn').attr('rel')+'":"'+$(this).find('.form-control').val()+'",';     
   		});
   	}
  	if (inquiryField != '')
   	{
		inquiryField = inquiryField.substr(0,inquiryField.length-1);
		inquiryFields += '{'+inquiryField+'},';
  	}
  });
  if (inquiryFields != '')
  {
	inquiryFields = inquiryFields.substr(0,inquiryFields.length-1);
	inquiryFields = '['+inquiryFields+']';
  }
  $('#cmsproductconfig-inquiry_field').val(inquiryFields);
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
