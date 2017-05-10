<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsPageAbout */

$this->title = Yii::t('app', 'Create Cms Page About');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Page Abouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-page-about-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
