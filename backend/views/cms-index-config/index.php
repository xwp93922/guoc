<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\CmsIndexConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cms Index Configs');
$this->params['breadcrumbs'][] = $this->title;
?>
<<style>
	.
</style>
<div class="cms-index-config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cms Index Config'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div>
    	<ul >
    		<?php foreach ($features as $feature){?>
    			<li><?= $feature ?>
    				<div></div>
    			</li>
    		<?php }?>
    	</ul>
    </div>
</div>
