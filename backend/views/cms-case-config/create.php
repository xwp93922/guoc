<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsCaseConfig */

$this->title = Yii::t('app', 'Create Cms Case Config');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Case Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-case-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
