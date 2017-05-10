<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CmsTheme */

$this->title = Yii::t('app', 'Update Cms Theme');
?>
<div class="cms-theme-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
