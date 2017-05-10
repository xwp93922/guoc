<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GhPlanOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gh-plan-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'plan_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'site_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'need_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_expired_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
