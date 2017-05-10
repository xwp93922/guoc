<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\themes\adminlte\LoginAsset;

$bundle = backend\themes\adminlte\AppAsset::register($this);
LoginAsset::register($this);
?>

<div class="login-box">
  <div class="login-logo">
    <img src="<?= $bundle->baseUrl ?>/img/logo.png" />
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo Yii::t('app', 'Register')?></p>

	<?php $form = ActiveForm::begin(['id' => 'register-form',
	    'fieldConfig'=>[
	        'template'=> "<div class=\"form-group has-feedback\">{input}{hint}</div>\n{error}",
	    ]
	]); ?>
		<?= $form->field($model, 'username')->textInput(['class'=>'form-control login-input','placeholder'=>Yii::t('app', 'Please fill username')]); ?>

		<?= $form->field($model, 'password')->textInput(['class'=>'form-control login-input','placeholder'=>Yii::t('app', 'Please fill password'),'onfocus'=>"this.type='password'"]); ?>

		<div class="row">
            <div class="col-xs-12">
            	<?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'login-btn', 'name' => 'register-button']) ?>
            </div>
		</div>

	<?php ActiveForm::end(); ?>

	<div class="row">
    	<div class="col-xs-12 text-center m-t-10">
        	<a href="<?php echo Url::toRoute(['site/login'])?>" class="text-center"><?php echo Yii::t('app', 'Login')?></a>
    	</div>
	</div>
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->