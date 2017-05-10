<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsProductInquiry */

$this->title = Yii::t('app', 'Create Cms Product Inquiry');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Inquiries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-product-inquiry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
