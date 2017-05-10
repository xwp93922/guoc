<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsProductSku */

$this->title = Yii::t('app', 'Create Cms Product Sku');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Skus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-product-sku-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
