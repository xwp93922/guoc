<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\DateTimePickerAsset;

/* @var $this yii\web\View */
/* @var $model common\models\CmsAboutTimeline */
/* @var $form yii\widgets\ActiveForm */

DateTimePickerAsset::register($this);
?>

<div class="cms-about-timeline-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The time for this matter.')) ?>

    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor')->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Specific content.')); ?>

    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>  
$('#cmsabouttimeline-date').datetimepicker({
	format: 'yyyy-mm-dd',
	language:  'zh-CN',
	weekStart: 1,
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	minView:2,
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
