<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsSiteLang */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Site Lang',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Site Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-site-lang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
