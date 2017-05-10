<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsIndexConfig */

$this->title = Yii::t('app', 'Create Cms Index Config');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Index Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-index-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
