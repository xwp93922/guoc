<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsAboutTeam */

$this->title = Yii::t('app', 'Create Cms About Team');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms About Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-about-team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
