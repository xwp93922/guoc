<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsShareBtn */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Share Btn',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Share Btns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-share-btn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
