<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GhPlan */

$this->title = Yii::t('app', 'Create Gh Plan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gh Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gh-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
