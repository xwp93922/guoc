<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchs\CmsIndexConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-index-config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'site_id') ?>

    <?= $form->field($model, 'lang_id') ?>

    <?= $form->field($model, 'config_id') ?>

    <?= $form->field($model, 'value') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'feature') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
