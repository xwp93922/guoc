<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsPageContact */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Page Contact',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Page Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-page-contact-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
