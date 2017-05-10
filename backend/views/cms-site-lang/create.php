<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsSiteLang */

$this->title = Yii::t('app', 'Create Cms Site Lang');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Site Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-site-lang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
