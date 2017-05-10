<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsServiceConfig */

$this->title = Yii::t('app', 'Create Cms Service Config');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Service Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-service-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
