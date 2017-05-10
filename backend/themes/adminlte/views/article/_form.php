<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use common\helpers\DataHelper;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageAbout */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-nav">
	<div class="form-nav-item active sel" id="form-tab-1" rel="tab-1"><?php echo Yii::t('app', 'Basic Content')?></div>
	<div class="form-nav-item sel" id="form-tab-2" rel="tab-2"><?php echo Yii::t('app', 'Other content')?></div>
	<div class="clear"></div>
</div>

<div class="cms-page-about-form padding-2">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div class="form-tab tab-1">
        <div class="row">
        	<div class="col-md-6 padding-1">
        		<?= $form->field($model, 'category_id')->dropDownList($categoryOptions,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:50%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The article\'s category.')) ?>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-6 padding-1">
        		<?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The article\'s name.')) ?>
        	</div>
        	<div class="col-md-6 pull-right padding-1">
        		<?= $form->field($model, 'summary')->textarea(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The summary of this article.')) ?>
        	</div>
        </div>
    
        <div class="row">
        	<div class="col-md-12 padding-1">
        		<?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor')->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Specific content.')); ?>
        	</div>
        </div>
    </div>
    
    <div class="form-tab tab-2 hide">
        <div class="row">
        	<div class="col-md-6 padding-1">
        		<?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true, 'style'=>'width:60%;'])->hint(Yii::t('app', 'Meta keywords must be splited by ","')) ?>
        		<?php 
        		$pluginOptions = [
        		    'showPreview' => true,
        		    'showCaption' => true,
        		    'showRemove' => false,
        		    'showUpload' => false,
        		];
        		if (!$model->isNewRecord && !empty($model->image_main)) {
        		    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->image_main;
        		    $pluginOptions['initialPreviewAsData'] = true;
        		}
        		?>
                <?= $form->field($model, 'image_main_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
                <?= $form->field($model, 'sort_val')->textInput()->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>
                
        	</div>
        	<div class="col-md-6 pull-right padding-1">
        		<?= $form->field($model, 'meta_description')->textarea(['maxlength' => true])->hint(Yii::t('app', 'Simply describe this article.')) ?>
        		<?php 
        		$pluginOptions = [
        		    'showPreview' => true,
        		    'showCaption' => true,
        		    'showRemove' => false,
        		    'showUpload' => false,
        		];
        		if (!$model->isNewRecord && !empty($model->image_node)) {
        		    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->image_node;
        		    $pluginOptions['initialPreviewAsData'] = true;
        		}
        		?>
        		<?= $form->field($model, 'image_node_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
               	<?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:50%;']) ?>
               	<?= $form->field($model, 'recommend')->dropDownList(DataHelper::getYesOrNo(),['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:50%;']) ?>
        	</div>
        </div>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>  
$("#w0").on("afterValidate", function (event, messages) {
  if (messages['cmsarticle-category_id'].length > 0 || 
  messages['cmsarticle-name'].length > 0 || 
  messages['cmsarticle-summary'].length > 0 || 
  messages['cmsarticle-content'].length > 0) {
  	showTab($('#form-tab-1'));
  }
  if (messages['cmsarticle-meta_keywords'].length > 0 || 
  messages['cmsarticle-image_main_file'].length > 0 || 
  messages['cmsarticle-meta_description'].length > 0 || 
  messages['cmsarticle-image_node_file'].length > 0 || 
  messages['cmsarticle-status'].length > 0) {
  	showTab($('#form-tab-2'));
  }
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>