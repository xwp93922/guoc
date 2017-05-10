<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CmsConfigType */

$this->title = Yii::t('app', 'Create Cms Config Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Config Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-config-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    		'featureType' =>$featureType,
    		'configType'=>$configType
    ]) ?>

</div>
