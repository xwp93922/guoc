<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsProductInfo */

$this->title = Yii::t('app', 'Create Cms Product Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-product-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
