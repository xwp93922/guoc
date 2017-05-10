<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t('app', 'Create Cms Article');
?>

<div class="row">
    <div class="col-md-12">
    	<div class="box box-success bg-color-2">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="box-body ">
                	<?= $this->render('_form', [
                        'model' => $model,
                	    'categoryOptions' => $categoryOptions,
                			'statusMap' => $statusMap,
                    ]) ?>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>

<?php $this->beginBlock('test') ?>  
setSideBarActive('article');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>