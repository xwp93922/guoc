<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageAbout */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Page About',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Page Abouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-page-about-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
