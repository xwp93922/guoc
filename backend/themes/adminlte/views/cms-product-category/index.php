<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Cms Product Categories');

?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo Yii::t('app', 'Cms Product Categories');?></h3>
            </div>
            <div class="box-body ">
            	<p>
                    <?= Html::a(Yii::t('app', 'Create Cms Product Category'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            	
              <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover'],
                'columns' => [
                    'id',
                    [
                        'attribute'=>'parent_id',
                        'value' => function($data) use ($categoryMap){
                            return isset($categoryMap[$data->parent_id])?$categoryMap[$data->parent_id]:Yii::t('app', 'Top category');
                        },
                        'filter' => $categoryOptions
                    ],
                    'name',
                    [
                        'attribute'=>'status',
                        'value' => function($data) use ($statusMap){
                            return isset($statusMap[$data->status])?$statusMap[$data->status]:Yii::t('app', 'Undefined');
                        },
                        'filter' => $statusMap
                    ],
                    [
                        'attribute' => 'sort_val',
                        'filterInputOptions' => ['class' => 'form-control','disabled'=>true]
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:Y-m-d H:i:s'],
                        'filterInputOptions' => ['class' => 'form-control','disabled'=>true]
                    ],
                    [
                            'class' => 'yii\grid\ActionColumn',
                            'template'=>'{user-update} {user-delete}',
                            'buttons'=>[
                                'user-update' => function ($url, $model, $key) {
                                  return Html::button(Yii::t('yii', 'Update'), ['class'=>'btn btn-success','onclick'=>'window.location.href="'.Url::toRoute(['cms-product-category/update','id'=>$model->id]).'";']);
                                },
                                'user-delete' => function ($url, $model, $key) {
                                  return Html::button(Yii::t('yii', 'Delete'), ['class'=>'btn btn-danger','onclick'=>'if (confirm("'.Yii::t('yii', 'Are you sure you want to delete this item?').'")){window.location.href="'.Url::toRoute(['cms-product-category/delete','id'=>$model->id]).'";}']);
                                },
                            ]
                        ],
                ],
            ]); ?>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
</div>

<?php $this->beginBlock('test') ?>  
setSideBarActive('product');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>