<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FriendLink */

$this->title = Yii::t('app', 'Create Friend Link');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Friend Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friend-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
