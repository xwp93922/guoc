<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsProductCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-product-category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'parent_id')->dropDownList($categoryOptions,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;'])->hint(Yii::t('app', 'This item\'s parent node.')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The category\'s name.')) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'style'=>'width:60%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The category\'s description.')) ?>

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

    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>

    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
