<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Friendlinks');
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo Yii::t('app', 'Friendlinks');?></h3>
                </div>
                <div class="box-body ">
                    <p>
                        <?= Html::a(Yii::t('app', 'Create Friend Link'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-hover'],
                        'columns' => [
                            'id',
                            'name',
                            'site_id',
                            'site_url:url',
                            [
                                'attribute'=>'logo',
                                'value' => function($data){
                                    return '<img src="'.\Yii::getAlias('@web').$data->logo.'" class="thumbnail" width="100" />';
                                },
                                'format'=>'html',
                                'filterInputOptions' => ['class' => 'form-control','disabled'=>true]
                            ],
                            
                            // 'updated_at',
                
                            [
                                'class' => 'yii\grid\ActionColumn',
                                /*'template'=>'{user-update} {user-delete}',
                                'user-update' => function ($url, $model, $key) {
                                      return Html::button(Yii::t('yii', 'Update'), ['class'=>'btn btn-success','onclick'=>'window.location.href="'.Url::toRoute(['friend-link/update','id'=>$model->id]).'";']);
                                    },
                                'user-delete' => function ($url, $model, $key) {
                                      return Html::button(Yii::t('yii', 'Delete'), ['class'=>'btn btn-danger','onclick'=>'if (confirm("'.Yii::t('yii', 'Are you sure you want to delete this item?').'")){window.location.href="'.Url::toRoute(['friend-link/delete','id'=>$model->id]).'";}']);
                                    },*/
                              
                            ],
                        ],
                    ]); ?>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>

<?php $this->beginBlock('test') ?>  
setSideBarActive('friendlink');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>