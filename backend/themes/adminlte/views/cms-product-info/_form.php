<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use common\helpers\DataHelper;

/* @var $this yii\web\View */
/* @var $model common\models\CmsProductInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-product-info-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryOptions,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The product\'s category.')) ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true, 'style'=>'width:30%;'])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'The product\'s name.')) ?>

    <div class="form-group field-cmsproductinfo-product_info required<?php if ($model->hasErrors('product_info'))echo ' has-error';?>">
        <label class="control-label" for="cmsproductinfo-product_info"><?php echo Yii::t('app', 'Product Info')?></label>
        <textarea id="cmsproductinfo-product_info" class="hide" name="CmsProductInfo[product_info]"></textarea>
       	<div class="product-info-box">
           	<?php foreach ($model->product_info as $key=>$val) {?>
           	<div class="form-group">
           		<label class="control-label"><?php echo $key?></label>
           		<input class="form-control" type="text" value="<?php echo $val?>" />
           	</div>
           	<?php }?>
       	</div>
        <div class="help-block"><?php if ($model->hasErrors('product_info'))echo $model->getErrors('product_info')[0];?></div>
    </div>

    <?php 
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!$model->isNewRecord && !empty($model->product_cover)) {
        $pluginOptions['initialPreview'] = \Yii::getAlias('@web').$model->product_cover;
        $pluginOptions['initialPreviewAsData'] = true;
    }
    ?>
    <?= $form->field($model, 'product_cover_file')->widget(FileInput::classname(), ['options' => ['accept' => 'image/jpg,image/jpeg,image/png'],
        'pluginOptions' => $pluginOptions
    ])->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'File type: ').'jpg\png,'.Yii::t('app', 'File max size: ').' 2MB');?>

    <?= $form->field($model, 'product_content')->widget('kucha\ueditor\UEditor')->hint(Yii::t('app', 'Required').', '.Yii::t('app', 'Specific content.')); ?>

    <?= $form->field($model, 'sort_val')->textInput(['style'=>'width:20%;'])->hint(Yii::t('app', 'Sort val, in ascending order.')) ?>
    
    <?= $form->field($model, 'recommend')->dropDownList(DataHelper::getYesOrNo(),['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

    <?= $form->field($model, 'status')->dropDownList($statusMap,['prompt'=>Yii::t('app', 'Please select'),'style'=>'width:20%;']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?php 
        if (!$model->isNewRecord) {
            echo Html::button(Yii::t('app', 'Cms Product Skus'),['class'=>'btn btn-info','onclick'=>'window.location.href="'.Url::toRoute(['cms-product-sku/index','product_id'=>$model->id]).'";']);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>  
$("#w0").on("afterValidate", function (event, messages) {
  var productInfo = '';
  $('.product-info-box').find('.form-group').each(function(){
  	productInfo += '"'+$(this).find('.control-label').text()+'":"'+$(this).find('.form-control').val()+'",';
  });
  if (productInfo != '')
  {
  	productInfo = '{'+productInfo.substr(0,productInfo.length-1)+'}';
  }
  $('#cmsproductinfo-product_info').val(productInfo);
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>