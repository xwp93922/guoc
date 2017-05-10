<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-page-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The page\'s name.')) ?>
    <?= $form->field($model, 'parent_id')->dropDownList($parent,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>
    <?= $form->field($model, 'type')->dropDownList($pagetype,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>
    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->cover)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->cover;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'cover_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>

    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor')->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The page\'s details.')); ?>
    
	<?= $form->field($model, 'other')->widget('kucha\ueditor\UEditor')->hint(Yii::t('app', 'The page\'s details.')); ?>
	
    <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true, 'style'=>'width:60%;'])->hint(Yii::t('app', 'Meta keywords must be splited by ","'),['class'=>'hint-block text-muted']) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Simply describe this article.')) ?>
    
    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>

    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
