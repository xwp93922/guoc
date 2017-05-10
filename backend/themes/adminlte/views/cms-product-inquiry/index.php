<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Cms Product Inquiries');
?>

<div class="row">
    <div class="col-md-12">
    	<div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo Yii::t('app', 'Cms Product Inquiries');?></h3>
                </div>
                <div class="box-body ">
                	<?= GridView::widget([
                        'dataProvider' => $dataProvider,
                	    'tableOptions' => ['class' => 'table table-hover'],
                        'columns' => [
                            'id',
                            [
                                'attribute'=>'product_id',
                                'value' => function($data){
                                    return is_object($data->product)?$data->product->product_name:Yii::t('app', 'Undefined');
                                },
                            ],
                            'inquiry_detail',
                            [
                                'attribute' => 'created_at',
                                'format' => ['date', 'php:Y-m-d H:i:s'],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template'=>'{sku} {user-update} {user-delete}',
                                'buttons'=>[
                                    'user-delete' => function ($url, $model, $key) {
                                      return Html::button(Yii::t('yii', 'Delete'), ['class'=>'btn btn-danger','onclick'=>'if (confirm("'.Yii::t('yii', 'Are you sure you want to delete this item?').'")){window.location.href="'.Url::toRoute(['cms-product-inquiry/delete','id'=>$model->id]).'";}']);
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