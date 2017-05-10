<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cms Product Configs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-product-config-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cms Product Config'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'lang_id',
            'site_id',
            'product_field:ntext',
            'product_order_btn',
            // 'product_detail_title',
            // 'product_detail_more_title',
            // 'homepage_name',
            // 'homepage_desc',
            // 'more_btn_name',
            // 'inquiry_field:ntext',
            // 'inquiry_email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
