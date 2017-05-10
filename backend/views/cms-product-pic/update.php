<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsProductPic */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Product Pic',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Pics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-product-pic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
