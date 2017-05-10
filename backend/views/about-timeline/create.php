<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsAboutTimeline */

$this->title = Yii::t('app', 'Create Cms About Timeline');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms About Timelines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-about-timeline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
