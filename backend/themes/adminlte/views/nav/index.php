<?php
use backend\themes\adminlte\NavAsset;
use yii\helpers\Url;
use common\helpers\ThemeHelper;

NavAsset::register($this);
?>
<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo Yii::t('app', 'Nav list');?></h3>
            </div>
            <div class="box-body">
              <div id="nav-list" class="box box-solid">
              	<ul class="nav nav-stacked">
              		<?php echo $navsHtml?>
              		
              	</ul>
                </div>
                
                <button type="button" id="save-navs-btn" class="btn bg-olive pull-right"><?php echo Yii::t('app', 'Save')?></button>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
		<div class="col-md-3">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo Yii::t('app', 'Add to nav');?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-footer no-padding no-border">
              <ul id="add-nav" class="nav nav-stacked">
              	<li class="no-border" type="7001" rel="0" name="<?php echo Yii::t('app', 'Homepage')?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                    		<span class="name"><?php echo Yii::t('app', 'Homepage')?></span>
                    		<span class="text-gray">-<?php echo Yii::t('app', 'Homepage')?></span>
                    	</div>
                    	<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                </li>
                <?php if (in_array(ThemeHelper::$THEME_FEATURE_CATEGORY, $features)){?>
              	<?php foreach ($topCategorys as $c) {?>
                <li class="no-border" type="1001" rel="<?php echo $c['id']?>" name="<?php echo $c['name']?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                    		<span class="name"><?php echo $c['name']?></span>
                    		<span class="text-gray">-<?php echo Yii::t('app', 'Top category')?></span>
                    	</div>
                    	<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                	<?php if (count($c['sub']) > 0) {?>
                	<div class="sub-list hide">
                		<?php foreach ($c['sub'] as $s){?>
                		<div class="sub-item" rel="<?php echo $s['id']?>" name="<?php echo $s['name']?>"></div>
                		<?php }?>
                	</div>
                	<?php }?>
                </li>
                <?php }?>
                <?php }?>
                <?php if (in_array(ThemeHelper::$THEME_FEATURE_PAGE, $features)){?>
                <?php foreach ($pages as $p) {?>
                <li class="no-border" type="2001" rel="<?php echo $p['id']?>" name="<?php echo $p['name']?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                			<span class="name"><?php echo $p['name']?></span>
                			<span class="text-gray">-<?php echo Yii::t('app', 'Single page')?></span>
                		</div>
                		<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                </li>
                <?php }?>
                <?php }?>
                <?php if (in_array(ThemeHelper::$THEME_FEATURE_PAGE_CONTACT, $features)){?>
                <?php foreach ($page_contact as $p) {?>
                <li class="no-border" type="2003" rel="<?php echo $p['id']?>" name="<?php echo Yii::t('app', 'Contact us')?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                			<span class="name"><?php echo Yii::t('app', 'Contact us')?></span>
                			<span class="text-gray">-<?php echo Yii::t('app', 'Single page')?></span>
                		</div>
                		<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                </li>
                <?php }?>
                <?php }?>
                <?php if (in_array(ThemeHelper::$THEME_FEATURE_PAGE_ABOUT, $features)){?>
                <?php foreach ($page_about as $p) {?>
                <li class="no-border" type="2002" rel="<?php echo $p['id']?>" name="<?php echo Yii::t('app', 'About us')?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                			<span class="name"><?php echo Yii::t('app', 'About us')?></span>
                			<span class="text-gray">-<?php echo Yii::t('app', 'Single page')?></span>
                		</div>
                		<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                </li>
                <?php }?>
                <?php }?>
                <?php if (in_array(ThemeHelper::$THEME_FEATURE_ALBUM, $features)){?>
                <li class="no-border" type="5001" rel="0" name="<?php echo Yii::t('app', 'Album')?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                    		<span class="name"><?php echo Yii::t('app', 'Album')?></span>
                    		<span class="text-gray">-<?php echo Yii::t('app', 'Album List')?></span>
                    	</div>
                    	<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                </li>
                <?php }?>
                <?php if (in_array(ThemeHelper::$THEME_FEATURE_CASE, $features)){?>
                <li class="no-border" type="6001" rel="0" name="<?php echo Yii::t('app', 'Case')?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                    		<span class="name"><?php echo Yii::t('app', 'Case')?></span>
                    		<span class="text-gray">-<?php echo Yii::t('app', 'Cms Cases')?></span>
                    	</div>
                    	<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                </li>
                <?php }?>
                <?php if (in_array(ThemeHelper::$THEME_FEATURE_PRODUCT, $features)){?>
                <li class="no-border" type="8001" rel="0" name="<?php echo Yii::t('app', 'Product')?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                    		<span class="name"><?php echo Yii::t('app', 'Product')?></span>
                    		<span class="text-gray">-<?php echo Yii::t('app', 'Product List')?></span>
                    	</div>
                    	<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                	<?php if (!empty($productCategorys)) {?>
                	<div class="sub-list hide">
                		<?php foreach ($productCategorys as $s){?>
                		<div class="sub-item" rel="<?php echo $s['id']?>" name="<?php echo $s['name']?>"></div>
                		<?php }?>
                	</div>
                	<?php }?>
                </li>
                <?php }?>
                <?php foreach ($preDefinedLinks as $p) {?>
                <li class="no-border" type="4001" rel="<?php echo $p['id']?>" name="<?php echo $p['name']?>" url="<?php echo $p['ext_content']?>">
                	<a class="row row-nomargin">
                		<div class="col-md-9 no-padding cut">
                			<span class="name"><?php echo $p['name']?></span>
                			<span class="text-gray">-<?php echo Yii::t('app', 'Customer link')?></span>
                		</div>
                		<div class="col-md-3 no-padding cut">
                    		<i class="pull-right fa fa-plus pointer"></i>
                    	</div>
                	</a>
                </li>
                <?php }?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
          <div class="box box-success">
                <div class="box-header with-border">
                  <h3 id="customer-link-box-title" class="box-title"><?php echo Yii::t('app', 'Add new customer link');?></h3>
                </div>
                <div id="customer_link_form" class="box-body">
                	<div class="form-group hide">
                      <label><?php echo Yii::t('app', 'ID');?></label>
                      <input type="text" class="form-control inputID">
                    </div>
                    
                  	<div class="form-group">
                      <label><?php echo Yii::t('app', 'Name');?></label>
                      <input type="text" class="form-control inputName" placeholder="<?php echo Yii::t('app', 'Name');?>">
                      <div class="hint-block"><?php echo Yii::t('app', 'Required').', '.Yii::t('app', 'The link\'s name.')?></div>
                    </div>
                    
                    <div class="form-group">
                      <label><?php echo Yii::t('app', 'Url');?></label>
                      <input type="text" class="form-control inputUrl" placeholder="<?php echo Yii::t('app', 'Url');?>">
                      <div class="hint-block"><?php echo Yii::t('app', 'Required').', '.Yii::t('app', 'Foramt like as: ').'http://www.gohoc.com'?></div>
                    </div>
                    
                    <div class="text-right">
                    	<button type="button" id="save-customerlink-btn" class="btn bg-olive "><?php echo Yii::t('app', 'Save')?></button>
                    	<button type="button" id="delete-customerlink-btn" class="btn btn-danger hide"><?php echo Yii::t('app', 'Delete')?></button>
                    </div>
                    
                </div>
                <!-- /.box-body -->
              </div>
          <!-- /.box -->
        </div>
</div>

						<div id="nav_cms_box" class="box box-solid nav-edit-box hide bg-color-1 no-shadow no-margin">
                      		<div class="form-group">
                              <label><?php echo Yii::t('app', 'Name')?></label>
                              <input type="text" class="form-control inputName bg-color-1" placeholder="<?php echo Yii::t('app', 'Name')?>">
                              <div class="hint-block"><?php echo Yii::t('app', 'Required').', '.Yii::t('app', 'The link\'s name.')?></div>
                            </div>
                            <div class="form-group">
                              <button type="button" class="removeBtn btn btn-danger btn-flat"><i class="fa fa-times"></i></button>
                              <button type="button" class="upBtn btn btn-success btn-flat"><i class="fa fa-arrow-up"></i></button>
                              <button type="button" class="downBtn btn btn-success btn-flat"><i class="fa fa-arrow-down"></i></button>
                              <button type="button" class="leftBtn btn btn-success btn-flat"><i class="fa fa-arrow-left"></i></button>
                              <button type="button" class="rightBtn btn btn-success btn-flat"><i class="fa fa-arrow-right"></i></button>
                            </div>
                  		</div>
                  		
                  		<div id="nav_customer_box" class="box box-solid nav-edit-box hide bg-color-1 no-shadow no-margin">
                  			<div class="form-group">
                              <label><?php echo Yii::t('app', 'Name')?></label>
                              <input type="text" class="form-control inputName bg-color-1" placeholder="<?php echo Yii::t('app', 'Name')?>">
                              <div class="hint-block"><?php echo Yii::t('app', 'Required').', '.Yii::t('app', 'The link\'s name.')?></div>
                            </div>
                      		<div class="form-group">
                              <label><?php echo Yii::t('app', 'Url')?></label>
                              <input type="email" class="form-control inputUrl bg-color-1">
                              <div class="hint-block"><?php echo Yii::t('app', 'Required').', '.Yii::t('app', 'Foramt like as: ').'http://www.gohoc.com'?></div>
                            </div>
                            <div class="form-group">
                              <button type="button" class="removeBtn btn btn-danger btn-flat"><i class="fa fa-times"></i></button>
                              <button type="button" class="upBtn btn btn-success btn-flat"><i class="fa fa-arrow-up"></i></button>
                              <button type="button" class="downBtn btn btn-success btn-flat"><i class="fa fa-arrow-down"></i></button>
                              <button type="button" class="leftBtn btn btn-success btn-flat"><i class="fa fa-arrow-left"></i></button>
                              <button type="button" class="rightBtn btn btn-success btn-flat"><i class="fa fa-arrow-right"></i></button>
                            </div>
                  		</div>
        
        <div class="page-data hide">
        	<span id="save-navs-url"><?php echo Url::to(['nav/save'],true);?></span>
        	<span id="save-customerlink-url"><?php echo Url::to(['nav/save-link'],true);?></span>
        	<span id="delete-customerlink-url"><?php echo Url::to(['nav/delete-link'],true);?></span>
        	<span id="top-category-lang"><?php echo Yii::t('app', 'Top category')?></span>
        	<span id="second-category-lang"><?php echo Yii::t('app', 'Second category')?></span>
        	<span id="single-page-lang"><?php echo Yii::t('app', 'Single page')?></span>
        	<span id="customer-link-lang"><?php echo Yii::t('app', 'Customer link')?></span>
        	<span id="name-blank-error-lang"><?php echo Yii::t('app', 'Name').' '.Yii::t('app', 'can not be blank.');?></span>
        	<span id="url-blank-error-lang"><?php echo Yii::t('app', 'Url').' '.Yii::t('app', 'can not be blank.')?></span>
        	<span id="url-valid-error-lang"><?php echo Yii::t('app', 'Url').' '.Yii::t('app', 'format error.')?></span>
        	<span id="new-customerlink-lang"><?php echo Yii::t('app', 'Add new customer link');?></span>
        	<span id="update-customerlink-lang"><?php echo Yii::t('app', 'Update customer link');?></span>
        	<span id="sub-category-lang"><?php echo Yii::t('app', 'Sub category');?></span>
        	<span id="product-category-lang"><?php echo Yii::t('app', 'Cms Product Category');?></span>
        </div>
	