<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CmsSiteLang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-site-lang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'site_id')->textInput() ?>

    <?= $form->field($model, 'lang_id')->textInput() ?>

    <?= $form->field($model, 'theme_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default')->textInput() ?>

    <?= $form->field($model, 'sort_val')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
