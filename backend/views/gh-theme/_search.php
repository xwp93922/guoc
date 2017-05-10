<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchs\GhThemeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gh-theme-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'price_origin') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'features') ?>

    <?php // echo $form->field($model, 'image_pc') ?>

    <?php // echo $form->field($model, 'image_pad') ?>

    <?php // echo $form->field($model, 'image_phone') ?>

    <?php // echo $form->field($model, 'image_addon') ?>

    <?php // echo $form->field($model, 'type') ?>

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
