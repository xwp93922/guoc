<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use backend\helpers\SiteHelper;
use common\helpers\LangHelper;
use backend\themes\adminlte\LangAsset;
use backend\themes\adminlte\LayerAsset;
use common\helpers\ThemeHelper;
use backend\widgets\SideBar\SideBar;
use yii\base\Widget;
$bundle = backend\themes\adminlte\AppAsset::register($this);
backend\assets\LtIE9::register($this);
LangAsset::register($this);
LayerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - 博赛建站系统 - 光合科技</title>
    <?php $this->head() ?>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
<?php $this->beginBody() ?>

<?php 
$site_id = SiteHelper::getSiteId();
$lang_id = SiteHelper::getLangId();
$lang_arr = SiteHelper::getLangArr();
$cmsLangs = LangHelper::getLangsWithoutDefault($lang_id);
$theme_arr = SiteHelper::getThemeArr();
$siteThemes = ThemeHelper::getSiteThemes($site_id);
?>
            	
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo Url::toRoute(['site/index'])?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><?php echo Yii::t('app', 'Mini CompanyName')?></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?php echo Yii::t('app', 'CompanyName')?></b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
                <ul class="nav navbar-nav lang-menu-ul">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle lang-title" data-toggle="dropdown">
                            <div class="pull-left lang-name"><?php echo $lang_arr['name']?></div>
                        	<div class="clear"></div>
                        </a>
                        <?php if (!empty($cmsLangs)) {?>
                        
                        <ul class="dropdown-menu lang-menu">
                            <li>
                                <ul class="menu">
                                	<?php foreach ($cmsLangs as $c) {
                                	if($c['lang_id']!=$lang_id){?>
                                    <li><!-- start notification -->
                                        <a href="<?php echo Url::toRoute(['cms-site-lang/set-default','id'=>$c['id']])?>" class="sel-lang-item" class="lang-title">
                                            <div class="pull-left lang-name text-muted"><?php echo $c['name']?></div>
                            				<div class="clear"></div>
                                        </a>
                                    </li>
                                    <?php }}?>
                                    <!-- end notification -->
                                </ul>
                                <!-- /.menu -->
                            </li>
                        </ul>
                        <?php }?>
                    </li>
            	</ul>
            	<ul class="nav navbar-nav theme-menu-ul">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle theme-title" data-toggle="dropdown">
                        	<?php echo Yii::t('app', 'Current theme：').$theme_arr['name']?>
                        </a>
                        <?php if (!empty($siteThemes)) {?>
                        <ul class="dropdown-menu theme-menu">
                            <li>
                           
                                <ul class="menu">
                                	<?php 
                                	foreach ($siteThemes as $t) {
                                	    if ($t['theme_id'] != $theme_arr['id']) {
                                	?>
                                    <li><!-- start notification -->
                                        <a href="<?php echo Url::toRoute(['cms-theme/use','id'=>$t['id']])?>" class="sel-theme-item" class="lang-title">
                                            <span class="text-muted"><?php echo $t['theme']['name']?></span>
                                        </a>
                                    </li>
                                    <?php }}?>
                                    <!-- end notification -->
                                </ul>
                                <!-- /.menu -->
                            </li>
                        </ul>
                        <?php }?>
                    </li>
            	</ul>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Notifications Menu -->
<!--                     <li class="dropdown notifications-menu"> -->
                        <!-- Menu toggle button -->
<!--                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> -->
<!--                             <i class="fa fa-bell-o"></i> -->
<!--                             <span class="label label-warning">10</span> -->
<!--                         </a>  -->
<!--                         <ul class="dropdown-menu"> -->
<!--                             <li class="header">You have 10 notifications</li> -->
<!--                             <li> -->
                                <!-- Inner Menu: contains the notifications -->
<!--                                 <ul class="menu"> -->
                                    <li><!-- start notification -->
<!--                                         <a href="#"> -->
<!--                                             <i class="fa fa-users text-aqua"></i> 5 new members joined today -->
<!--                                         </a> -->
<!--                                     </li> -->
                                    <!-- end notification -->
<!--                                 </ul> -->
<!--                             </li> -->
<!--                             <li class="footer"><a href="#">View all</a></li> -->
<!--                         </ul> -->
<!--                     </li> -->
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="<?php echo \common\helpers\SiteHelper::getUserAvatar(Yii::$app->user->identity->avatar);?>" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?php echo Yii::$app->user->identity->username?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="<?php echo \common\helpers\SiteHelper::getUserAvatar(Yii::$app->user->identity->avatar);?>" class="img-circle" alt="User Image">

                                <p>
                                    <?php echo Yii::$app->user->identity->username?>
                                    <small><?php echo Yii::t('app', 'Member since ').date('Y-m-d',Yii::$app->user->identity->created_at);?></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo Url::toRoute(['user/update'])?>" class="btn btn-default btn-flat"><?php echo Yii::t('app', 'User settings')?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo Url::toRoute(['site/logout'])?>" class="btn btn-default btn-flat"><?php echo Yii::t('app', 'Sign out');?></a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo \common\helpers\SiteHelper::getUserAvatar(Yii::$app->user->identity->avatar);?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo Yii::t('app', 'Welcome')?></p>
                    <!-- Status -->
                    <a href="javascript:;"><?php echo Yii::$app->user->identity->username?></a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <div class="sidebar-form">
                <div class="input-group">
                    <input type="text" id="sidebar-search-val" class="form-control" placeholder="<?php echo Yii::t('app', 'Search...')?>">
              <span class="input-group-btn">
                <button id="sidebar-search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </div>
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <?php echo SideBar::widget();?>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- <section class="content-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>Optional description</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section> -->

        <!-- Main content -->
        <section class="content">
        	<?php if (Yii::$app->session->hasFlash('cms.theme_update')) {?>
            <div class="alert-2 alert-success-2" role="alert">
              <?php echo Yii::$app->session->getFlash('cms.theme_update')?>
            </div>
            <?php }?>
            <?php if (Yii::$app->session->hasFlash('cms.lang_update')) {?>
            <div class="alert-2 alert-success-2" role="alert">
              <?php echo Yii::$app->session->getFlash('cms.lang_update')?>
            </div>
            <?php }?>
            <!-- Your Page Content Here -->
            <?= $content ?>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <!-- <div class="pull-right hidden-xs">
        </div> -->
        <!-- Default to the left -->
        <strong>Copyright &copy; 2017 光合科技.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<div id="mask-layout" class="hide"></div>
<div class="page-data hide">
	<span id="web-url"><?php echo \Yii::getAlias('@web')?></span>
	<span id="success-title"><?php echo Yii::t('app', 'Success')?></span>
	<span id="info-title"><?php echo Yii::t('app', 'Info')?></span>
	<span id="warning-title"><?php echo Yii::t('app', 'Warning')?></span>
	<span id="danger-title"><?php echo Yii::t('app', 'Danger')?></span>
	<span id="saving-text"><?php echo Yii::t('app', 'Saving...')?></span>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
