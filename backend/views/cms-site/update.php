<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsSite */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Site',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-site-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
