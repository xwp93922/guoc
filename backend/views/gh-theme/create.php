<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GhTheme */

$this->title = Yii::t('app', 'Create Gh Theme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gh Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gh-theme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
