<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsAlbum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-album-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The friendlink\'s name.')) ?>
    
    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->logo)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->logo;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>

    <?= $form->field($model, 'site_id')->textInput() ?>
    <?= $form->field($model, 'site_url')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'logo')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
