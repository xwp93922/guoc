<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsProductConfig */

$this->title = Yii::t('app', 'Create Cms Product Config');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-product-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
