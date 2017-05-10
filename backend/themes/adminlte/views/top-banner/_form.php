<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsTopBanner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-top-banner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'pos')->dropDownList($posMap,['data-placeholder'=>Yii::t('app', 'Please select'),'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The top banner\'s position.')) ?>

    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->pic)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->pic;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'pic_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The top banner\'s name.')) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true, 'style'=>'width:60%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The top banner\'s description.')) ?>
    
    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
