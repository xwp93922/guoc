<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CmsServiceConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-service-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'homepage_name')->textInput(['maxlength' => true,'style'=>'width:50%;']) ?>

    <?= $form->field($model, 'homepage_desc')->textInput(['maxlength' => true,'style'=>'width:80%;']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
