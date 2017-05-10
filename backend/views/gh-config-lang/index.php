<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Gh Config Langs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gh-config-lang-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Gh Config Lang'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'name18n',
            'flag',
            'sort_val',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
