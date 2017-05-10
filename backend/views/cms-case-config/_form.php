<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CmsCaseConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-case-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang_id')->textInput() ?>

    <?= $form->field($model, 'site_id')->textInput() ?>

    <?= $form->field($model, 'top_banner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'top_banner_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'top_banner_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'homepage_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'homepage_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'more_btn_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'use_category')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
