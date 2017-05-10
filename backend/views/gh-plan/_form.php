<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GhPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gh-plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_origin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'suggest')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'equipments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'space')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'flow')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'month')->textInput() ?>

    <?= $form->field($model, 'remarks')->textInput() ?>

    <?= $form->field($model, 'image_addon')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
