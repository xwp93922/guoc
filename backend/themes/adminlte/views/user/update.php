<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageContact */

$this->title = Yii::t('app', 'Update User');
?>
<div class="row">
    <div class="col-md-6">
    	<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="box-body ">
                	<div class="user-form">

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                
                    <?php 
                    $pluginOptions = [
                        'showPreview' => true,
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                    ];
                    if (!$model->isNewRecord && !empty($model->avatar)) {
                        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->avatar;
                        $pluginOptions['initialPreviewAsData'] = true;
                    }
                    ?>
                    <?= $form->field($model, 'avatar_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
                        'pluginOptions' => $pluginOptions
                    ])->hint(Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>

                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'style'=>'width:50%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Please fill username')) ?>
                    
					<?= $form->field($model, 'newpwd1')->textInput(['style'=>'width:50%;','onfocus'=>"this.type='password'"])->hint(Yii::t('app', 'Please fill password')); ?>
					<?= $form->field($model, 'newpwd2')->textInput(['style'=>'width:50%;','onfocus'=>"this.type='password'"])->hint(Yii::t('app', 'Please fill password')); ?>
                
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>
                
                    <?php ActiveForm::end(); ?>
                
                </div>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>