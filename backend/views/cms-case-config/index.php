<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cms Case Configs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-case-config-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cms Case Config'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'lang_id',
            'site_id',
            'top_banner',
            'top_banner_name',
            // 'top_banner_desc',
            // 'homepage_name',
            // 'homepage_desc',
            // 'more_btn_name',
            // 'use_category',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
