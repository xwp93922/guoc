<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchs\GhPlanOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gh-plan-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'plan_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'site_id') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'count') ?>

    <?php // echo $form->field($model, 'need_pay') ?>

    <?php // echo $form->field($model, 'payed') ?>

    <?php // echo $form->field($model, 'discount_money') ?>

    <?php // echo $form->field($model, 'discount_note') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'plan_expired_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
