<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\DataHelper;

/* @var $this yii\web\View */
/* @var $model common\models\GhThemeCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gh-theme-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The category\'s name.')) ?>

    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>

    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
