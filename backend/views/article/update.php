<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsArticle */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cms Article',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cms-article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
