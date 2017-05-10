<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsArticle */

$this->title = Yii::t('app', 'Create Cms Article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
