<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsProductPic */

$this->title = Yii::t('app', 'Create Cms Product Pic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Product Pics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-product-pic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
