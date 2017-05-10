<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsProductCategory */

$this->title = Yii::t('app', 'Create Cms Product Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-product-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
