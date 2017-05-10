<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsProductSku */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-product-sku-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:50%;'])->hint(Yii::t('app', 'Required')); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true, 'style'=>'width:50%;'])->hint(Yii::t('app', 'Required')); ?>

    			<?php 
        		$pluginOptions = [
        		    'showPreview' => true,
        		    'showCaption' => true,
        		    'showRemove' => false,
        		    'showUpload' => false,
        		];
        		if (!$model->isNewRecord && !empty($model->pic)) {
        		    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->pic;
        		    $pluginOptions['initialPreviewAsData'] = true;
        		}
        		?>
                <?= $form->field($model, 'pic_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>

    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:30%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>
    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:30%;']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
