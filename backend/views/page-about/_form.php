<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageAbout */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-page-about-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang_id')->textInput() ?>

    <?= $form->field($model, 'site_id')->textInput() ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_slogan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_idea')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_wish')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_culture')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
