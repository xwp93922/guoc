<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageAbout */
/* @var $form yii\widgets\ActiveForm */
?>

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
        		if (!$model->isNewRecord && !empty($model->headnode)) {
        		    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->headnode;
        		    $pluginOptions['initialPreviewAsData'] = true;
        		}
        		?>
                <?= $form->field($model, 'headnode_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-6 padding-1">
        		<?= $form->field($model, 'profession')->textInput(['maxlength' => true])->hint(Yii::t('app', 'His profession.')) ?>
        		<?= $form->field($model, 'sort_val')->textInput()->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>
            	<?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select')]) ?>
        	</div>
        	<div class="col-md-6 pull-right padding-1">
        		<?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Full name, for example: Paul.')); ?>
            	<?= $form->field($model, 'desc')->textInput(['maxlength' => true])->hint(Yii::t('app', 'A short introduce.')) ?>
        	</div>
        </div>
    </div>
    
    <div class="form-group text-center">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
