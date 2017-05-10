<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsBannerPic */

$this->title = Yii::t('app', 'Create Cms Banner Pic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Banner Pics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-banner-pic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
