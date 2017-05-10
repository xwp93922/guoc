<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsAlbum */

$this->title = Yii::t('app', 'Create Cms Album');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-album-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
