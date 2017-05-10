<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsTheme */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Theme',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-theme-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
