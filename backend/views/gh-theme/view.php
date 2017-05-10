<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GhTheme */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gh Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gh-theme-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'name',
            'code',
            'desc',
            'price_origin',
            'price',
            'features',
            'image_pc',
            'image_pad',
            'image_phone',
            'image_addon',
            'type',
            'status',
            'sort_val',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
