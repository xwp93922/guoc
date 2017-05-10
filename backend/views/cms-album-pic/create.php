<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsAlbumPic */

$this->title = Yii::t('app', 'Create Cms Album Pic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Album Pics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-album-pic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
