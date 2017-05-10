<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsSite */

$this->title = Yii::t('app', 'Create Cms Site');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
