<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsIndexConfig */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Index Config',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Index Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-index-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
