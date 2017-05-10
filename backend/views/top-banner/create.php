<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsTopBanner */

$this->title = Yii::t('app', 'Create Cms Top Banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Top Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-top-banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
