<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\themes\adminlte\Select2Asset;
use common\helpers\ThemeHelper;

/* @var $this yii\web\View */
/* @var $model common\models\CmsConfigType */
/* @var $form yii\widgets\ActiveForm */
Select2Asset::register($this);
?>

<div class="cms-config-type-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'feature')->dropDownList(ThemeHelper::getFeatureNames(),['data-placeholder'=>Yii::t('app', 'Please select'),'class'=>'form-control select2','multiple'=>true,'style'=>'width:100%;'])->hint(Yii::t('app', 'The theme\'s feature list.')) ?>    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'style'=>'width:20%;']) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true,'style'=>'width:20%;']) ?>

	<?= $form->field($model, 'type')->dropDownList($configType,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>
    

    <?= $form->field($model, 'status')->textInput(['style'=>'width:20%;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('test') ?>  
$(".select2").select2();
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>  