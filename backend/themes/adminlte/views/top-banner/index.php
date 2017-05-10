<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\DataHelper;

?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo Yii::t('app', 'Cms Top Banners');?></h3>
            </div>
            <div class="box-body ">
            	<p>
                    <?= Html::a(Yii::t('app', 'Create Cms Top Banner'), ['create','pos'=>$searchModel->pos], ['class' => 'btn btn-success']) ?>
                </p>
            	
              <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover'],
                'columns' => [
                    'id',
                    [
                        'attribute'=>'pic',
                        'value' => function($data){
                            return '<img src="'.\Yii::getAlias('@web').$data->pic.'" class="thumbnail" width="100" />';
                        },
                        'format'=>'html',
                        'filterInputOptions' => ['class' => 'form-control','disabled'=>true]
                    ],
                    [
                        'attribute'=>'pos',
                        'value' => function($data) use ($posMap){
                            return DataHelper::getValue($posMap, $data->pos);
                        },
                        'filter' => $posMap
                    ],
                    [
                        'attribute'=>'status',
                        'value' => function($data) use ($statusMap){
                            return isset($statusMap[$data->status])?$statusMap[$data->status]:Yii::t('app', 'Undefined');
                        },
                        'filter' => $statusMap
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
                                    return Html::button(Yii::t('yii', 'Update'), ['class'=>'btn btn-success','onclick'=>'window.location.href="'.Url::toRoute(['top-banner/update','id'=>$model->id]).'";']);
                                },
                                'user-delete' => function ($url, $model, $key) {
                                    return Html::button(Yii::t('yii', 'Delete'), ['class'=>'btn btn-danger','onclick'=>'if (confirm("'.Yii::t('yii', 'Are you sure you want to delete this item?').'")){window.location.href="'.Url::toRoute(['top-banner/delete','id'=>$model->id]).'";}']);
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
setSideBarActive('<?php echo !empty($searchModel->pos)?$searchModel->pos:'banner'?>');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>