<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsBanner */

$this->title = Yii::t('app', 'Create Cms Banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
