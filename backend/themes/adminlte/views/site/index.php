<?php

use common\helpers\ThemeHelper;
use common\models\CmsCategory;
use common\models\CmsArticle;
use common\models\CmsPage;
use common\models\CmsBanner;
use common\models\CmsCase;
use common\models\CmsAlbum;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Dashboard');
?>
<section class="content-header">
      <h1>
        <?php echo Yii::t('app', 'AppName')?>
        <small></small>
      </h1>
</section>

<section class="content">
      <div class="row">
      	<div class="col-md-3">
          <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo Yii::t('app', 'Current theme：').$theme_arr['name']?></h3>
                </div>
                <div class="box-body no-padding">
                	<div class="index-box-1">
                		<img src="<?php echo \Yii::getAlias('@web').$theme_arr['image_pc'];?>" />
                	</div>
                </div>
              </div>
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa  fa-language"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?php echo Yii::t('app', 'Current lang：');?></span>
                  <span class="info-box-number m-t-10"><?php echo $lang_arr['name'];?></span>
                </div>
              </div>
        </div>
        <div class="col-md-6">
          <div class="box box-success">
            <!-- /.box-header -->
            <div class="box-body relative">

              <!-- <div class="box-tools box-tools-2">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div> -->
              <div class="table-responsive">
                <table class="table no-margin table-vertical-middle">
                  <thead>
                  <tr>
                    <th><?php echo Yii::t('app', 'Statistic')?></th>
                    <th><?php echo Yii::t('app', 'Name')?></th>
                    <th><?php echo Yii::t('app', 'Count')?></th>
                  </tr>
                  </thead>
                  <tbody>
        		  <?php if (in_array(ThemeHelper::$THEME_FEATURE_NAV, $features)){?>
                  <tr>
                    <td><span class="info-box-icon2 bg-aqua"><i class="fa fa-map-signs"></i></span></td>
                    <td><?php echo Yii::t('app', 'Category Num')?></td>
                    <td><?php echo CmsCategory::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsCategory::STATUS_ACTIVE])->count();?></td>
                  </tr>
                  <?php }?>
                  <?php if (in_array(ThemeHelper::$THEME_FEATURE_ARTICLE, $features)){?>
        	 	  <tr>
                    <td><span class="info-box-icon2 bg-red"><i class="fa fa-file-text-o"></i></span></td>
                    <td><?php echo Yii::t('app', 'Article Num')?></td>
                    <td><?php echo CmsArticle::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsArticle::STATUS_ACTIVE])->count();?></td>
                  </tr>
        		  <?php }?>
        		  <?php if (in_array(ThemeHelper::$THEME_FEATURE_PAGE, $features)){?>
                  <tr>
                    <td><span class="info-box-icon2 bg-green"><i class="fa fa-files-o"></i></span></td>
                    <td><?php echo Yii::t('app', 'Page Num')?></td>
                    <td><?php echo CmsPage::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsPage::STATUS_ACTIVE])->count();?></td>
                  </tr>
                  <?php }?>
                  <?php if (in_array(ThemeHelper::$THEME_FEATURE_BANNER, $features)){?>
                  <tr>
                    <td><span class="info-box-icon2 bg-yellow"><i class="fa fa-film"></i></span></td>
                    <td><?php echo Yii::t('app', 'Banner Num')?></td>
                    <td><?php echo CmsBanner::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsBanner::STATUS_ACTIVE])->count();?></td>
                  </tr>
                  <?php }?>
                  <?php if (in_array(ThemeHelper::$THEME_FEATURE_CASE, $features)){?>
        		  <tr>
                    <td><span class="info-box-icon2 bg-teal"><i class="fa fa-folder"></i></span></td>
                    <td><?php echo Yii::t('app', 'Case Num')?></td>
                    <td><?php echo CmsCase::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsCase::STATUS_ACTIVE])->count();?></td>
                  </tr>
        		  <?php }?>
        		  <?php if (in_array(ThemeHelper::$THEME_FEATURE_ALBUM, $features)){?>
                  <tr>
                    <td><span class="info-box-icon2 bg-maroon"><i class="fa fa-image"></i></span></td>
                    <td><?php echo Yii::t('app', 'Album Num')?></td>
                    <td><?php echo CmsAlbum::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'status'=>CmsAlbum::STATUS_ACTIVE])->count();?></td>
                  </tr>
                  <?php }?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
</section>

<?php $this->beginBlock('test') ?>  
setSideBarActive('dashboard');
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>