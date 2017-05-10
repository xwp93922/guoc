<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsPage */

$this->title = Yii::t('app', 'Create Cms Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
