<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cms Site Langs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-site-lang-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cms Site Lang'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'site_id',
            'lang_id',
            'theme_id',
            'name',
            // 'flag',
            // 'default',
            // 'sort_val',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
