<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsTheme */

$this->title = Yii::t('app', 'Create Cms Theme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-theme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
