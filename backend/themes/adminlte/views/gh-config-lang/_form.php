<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\helpers\DataHelper;

/* @var $this yii\web\View */
/* @var $model common\models\GhConfigLang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gh-config-lang-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The language name.')) ?>

    <?= $form->field($model, 'name18n')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The language\'s il8n name.')) ?>

    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
