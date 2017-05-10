<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
$bundle = backend\themes\adminlte\AppAsset::register($this);
backend\assets\LtIE9::register($this);
backend\themes\adminlte\ICheckAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - 博赛建站系统 - 光合科技</title>
    <?php $this->head() ?>
</head>

<body class="hold-transition login-page">
<?php $this->beginBody() ?>

<?= $content ?>
<!-- ./wrapper -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
