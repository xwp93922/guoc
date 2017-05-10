<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsAboutTimeline */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms About Timeline',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms About Timelines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-about-timeline-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
