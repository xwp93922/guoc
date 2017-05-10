<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\themes\adminlte\Select2Asset;
use common\helpers\ThemeHelper;
use kartik\file\FileInput;
use common\helpers\DataHelper;

/* @var $this yii\web\View */
/* @var $model common\models\GhTheme */
/* @var $form yii\widgets\ActiveForm */
Select2Asset::register($this);
?>

<div class="gh-theme-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $form->field($model, 'id')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The theme\'s id.')) ?>
	
    <?= $form->field($model, 'category_id')->dropDownList($categoryMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;'])->hint(Yii::t('app', 'The theme\'s category.')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The theme\'s name.')) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The theme\'s code.')) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true, 'style'=>'width:60%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The theme\'s description.')) ?>

    <?= $form->field($model, 'price_origin')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'The theme\'s original price.')) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'The theme\'s price.')) ?>

    <?= $form->field($model, 'features')->dropDownList(ThemeHelper::getFeatureNames(),['data-placeholder'=>Yii::t('app', 'Please select'),'class'=>'form-control select2','multiple'=>true,'style'=>'width:100%;'])->hint(Yii::t('app', 'The theme\'s feature list.')) ?>
	<?php $model->home_features=$model->home_features;?>
	<?= $form->field($model, 'home_features')->dropDownList(ThemeHelper::getFeatureNames(),['placeholder'=>Yii::t('app', 'Please select'),'class'=>'form-control select2','multiple'=>true,'style'=>'width:100%;'])->hint(Yii::t('app', 'The theme\'s feature list.')) ?>
    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->image_pc)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->image_pc;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'image_pc_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
    
    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->image_pad)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->image_pad;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'image_pad_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->image_phone)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->image_phone;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'image_phone_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
    
    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->image_addon)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->image_addon;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'image_addon_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
    
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
