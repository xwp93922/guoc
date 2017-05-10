<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t('app', 'Update Category');
?>
<div class="row">
    <div class="col-md-8">
    	<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="box-body ">
                	<?= $this->render('_form', [
                        'model' => $model,
                	    'categoryOptions' => $categoryOptions,
                	    'statusMap' => $statusMap,
                			'cateType'	=>$cateType,
                    ]) ?>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>

<?php $this->beginBlock('test') ?>  
setSideBarActive('category');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>