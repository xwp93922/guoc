<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\themes\adminlte\Select2Asset;

/* @var $this yii\web\View */
/* @var $model common\models\CmsBanner */
/* @var $form yii\widgets\ActiveForm */

Select2Asset::register($this);
?>

<div class="cms-banner-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?= $form->field($model, 'pos')->dropDownList($posMap,['data-placeholder'=>Yii::t('app', 'Please select'),'class'=>'form-control select2','multiple'=>true,'style'=>'width:100%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The banner\'s position.')) ?>

    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>
    
    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>  
$(".select2").select2();
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>  