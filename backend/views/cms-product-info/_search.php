<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchs\CmsProductInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-product-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'lang_id') ?>

    <?= $form->field($model, 'site_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'product_name') ?>

    <?php // echo $form->field($model, 'product_info') ?>

    <?php // echo $form->field($model, 'product_cover') ?>

    <?php // echo $form->field($model, 'product_content') ?>

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
