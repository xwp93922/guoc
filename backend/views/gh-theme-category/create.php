<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GhThemeCategory */

$this->title = Yii::t('app', 'Create Gh Theme Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gh Theme Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gh-theme-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
