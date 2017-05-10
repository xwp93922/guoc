<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsProductCategory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Product Category',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-product-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
