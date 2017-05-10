<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchs\GhPlanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gh-plan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'price_origin') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'suggest') ?>

    <?php // echo $form->field($model, 'equipments') ?>

    <?php // echo $form->field($model, 'space') ?>

    <?php // echo $form->field($model, 'flow') ?>

    <?php // echo $form->field($model, 'month') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'image_addon') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sort_val') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
