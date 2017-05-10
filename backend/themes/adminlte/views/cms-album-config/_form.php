<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsAlbumConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-album-config-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

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

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
