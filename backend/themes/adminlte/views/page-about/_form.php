<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageAbout */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-nav">
	<div class="form-nav-item active"><?php echo Yii::t('app', 'Basic Content')?></div>
	<div class="form-nav-item"<?php if (!$model->isNewRecord) {?> onclick="window.location.href='<?php echo Url::toRoute(['page-about/other','about_id'=>$model->id])?>';"<?php }?>><?php echo Yii::t('app', 'Other content')?></div>
	<div class="clear"></div>
</div>

<div class="cms-page-about-form padding-2">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div class="form-tab">
    	<div class="row">
        	<div class="col-md-6 padding-1">
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
        	<div class="col-md-6 padding-1">
        		<?php 
                $pluginOptions = [
                    'showPreview' => true,
                    'showCaption' => true,
                    'showRemove' => false,
                    'showUpload' => false,
                ];
                if (!$model->isNewRecord && !empty($model->homepage_left_pic)) {
                    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->homepage_left_pic;
                    $pluginOptions['initialPreviewAsData'] = true;
                }
                ?>
                <?= $form->field($model, 'homepage_left_pic_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                    'pluginOptions' => $pluginOptions
                ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-6 padding-1">
        		<?= $form->field($model, 'top_banner_name')->textInput(['maxlength' => true]) ?>
    			<?= $form->field($model, 'top_banner_desc')->textInput(['maxlength' => true]) ?>
        		<?= $form->field($model, 'company_name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Your company\'s name.')) ?>
        		<?= $form->field($model, 'company_slogan')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s slogan.')) ?>
        		<?= $form->field($model, 'company_keywords')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s keywords.')) ?>
        	</div>
        	<div class="col-md-6 pull-right padding-1">
        		<?= $form->field($model, 'homepage_name')->textInput(['maxlength' => true]) ?>
        		<?= $form->field($model, 'more_btn_name')->textInput(['maxlength' => true]) ?>
        		<?= $form->field($model, 'company_idea')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s idea.')) ?>
            	<?= $form->field($model, 'company_wish')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s wish.')) ?>
            	<?= $form->field($model, 'company_culture')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Your company\'s culture.')) ?>
        	</div>
        </div>
    
        <div class="row">
        	<div class="col-md-12 padding-1">
        		<?= $form->field($model, 'company_desc')->widget('kucha\ueditor\UEditor')->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Your company\'s introduce.')); ?>
        	</div>
        </div>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
