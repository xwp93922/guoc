<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsCase */

$this->title = Yii::t('app', 'Create Cms Case');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-case-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
