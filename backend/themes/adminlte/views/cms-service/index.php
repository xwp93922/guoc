<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Cms Services');
?>

<div class="row">
    <div class="col-md-12">
    	<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo Yii::t('app', 'Cms Services');?></h3>
                </div>
                <div class="box-body ">
                	<p>
                        <?= Html::a(Yii::t('app', 'Create Cms Service'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                	
                	<?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                	    'tableOptions' => ['class' => 'table table-hover'],
                        'columns' => [
                            'id',
                            [
                                'attribute'=>'cover',
                                'value' => function($data){
                                    return '<img src="'.\Yii::getAlias('@web').$data->cover.'" class="thumbnail" width="100" />';
                                },
                                'format'=>'html',
                                'filterInputOptions' => ['class' => 'form-control','disabled'=>true]
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
                            // 'updated_at',
                
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template'=>'{user-update} {user-delete}',
                                'buttons'=>[
                                    'user-update' => function ($url, $model, $key) {
                                      return Html::button(Yii::t('yii', 'Update'), ['class'=>'btn btn-success','onclick'=>'window.location.href="'.Url::toRoute(['cms-service/update','id'=>$model->id]).'";']);
                                    },
                                    'user-delete' => function ($url, $model, $key) {
                                      return Html::button(Yii::t('yii', 'Delete'), ['class'=>'btn btn-danger','onclick'=>'if (confirm("'.Yii::t('yii', 'Are you sure you want to delete this item?').'")){window.location.href="'.Url::toRoute(['cms-service/delete','id'=>$model->id]).'";}']);
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
setSideBarActive('service');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>