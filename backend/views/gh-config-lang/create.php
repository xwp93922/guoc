<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GhConfigLang */

$this->title = Yii::t('app', 'Create Gh Config Lang');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gh Config Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gh-config-lang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
