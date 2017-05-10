<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsService */

$this->title = Yii::t('app', 'Create Cms Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
