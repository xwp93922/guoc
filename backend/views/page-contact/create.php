<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsPageContact */

$this->title = Yii::t('app', 'Create Cms Page Contact');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Page Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-page-contact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
