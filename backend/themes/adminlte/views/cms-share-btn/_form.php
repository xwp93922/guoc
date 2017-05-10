<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\helpers\DataHelper;
use common\models\CmsShareBtn;

/* @var $this yii\web\View */
/* @var $model common\models\CmsShareBtn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-share-btn-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The share btn\'s name.')) ?>

    <?= $form->field($model, 'type')->dropDownList(DataHelper::getShareBtnTypes(),['onchange'=>'setContent(this);','prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

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
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>

	<div id="content_type_<?php echo CmsShareBtn::TYPE_LINK?>" class="content_type <?php if ($model->type != CmsShareBtn::TYPE_LINK)echo 'hide';?>">
	<?= $form->field($model, 'content')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The share btn\'s link.')) ?>
	</div>
	<div id="content_type_<?php echo CmsShareBtn::TYPE_QRCODE?>" class="content_type <?php if ($model->type != CmsShareBtn::TYPE_QRCODE)echo 'hide';?>">
	<?php 
        		$pluginOptions = [
        		    'showPreview' => true,
        		    'showCaption' => true,
        		    'showRemove' => false,
        		    'showUpload' => false,
        		];
        		if (!$model->isNewRecord && !empty($model->content)) {
        		    $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->content;
        		    $pluginOptions['initialPreviewAsData'] = true;
        		}
        		?>
                <?= $form->field($model, 'content_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>
	</div>
    

    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>

    <?= $form->field($model, 'status')->dropDownList(DataHelper::getGeneralStatus(),['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>  
function setContent(obj)
{
	$('.content_type').addClass('hide');
	$('#content_type_'+$(obj).val()).removeClass('hide');
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>