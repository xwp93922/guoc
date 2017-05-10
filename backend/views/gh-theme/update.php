<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GhTheme */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Gh Theme',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gh Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="gh-theme-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
