<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsAboutTeam */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms About Team',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms About Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-about-team-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
