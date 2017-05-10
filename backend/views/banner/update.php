<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsBanner */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Banner',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-banner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
