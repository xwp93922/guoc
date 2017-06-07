<?php

use yii\helpers\Url;
use common\helpers\SiteHelper;
use common\models\CmsNav;
use common\helpers\NavHelper;
use common\models\CmsPage;
$bundle = frontend\themes\t00008\AppAsset::register($this);

?>
 <!--content_df-->
        <div class="content_df">
            <!--home-banner-->
            <div class=" home-banner">
                <div class=" banner-slider">
	                 <?php if (isset($banners['images'])){ foreach( $banners['images'] as $image ){ ?>
	                	<div class=" slide"><img src="<?= SiteHelper::getImgSrc($image['image']) ?>"></div>
	                <?php }} ?>
                </div>
                <!--<div class="ho_nextBtn"></div>-->
                <!--<div class="ho_prevBtn"></div>-->
            </div>
            <!--ipad-->
            <ul class="ipad-display ipad-nav clearfix">
            	<?php foreach( $this->context->mainDatas['navs'] as $key => $nav ){ ?>
            		<li><a href="<?= NavHelper::getNavUrl($nav)?>" class="nav-ipad-item ht_click-active"><?= $nav['name']?></a></li>
	            <?php }?>
            </ul>
            <!--home-itemA-->
            <div class="home-itemA">
            <div class="item-box">
                <div class="item-bar">
                    <p class="item-bar-txt cr_second-df"><span class="cr_first-df">芋见甜品</span><em> ·</em> 没有噱头，实实在在的辉煌沉淀</p>
                    <div class="item-bar-tel">
                        <p class="tel-top">港式甜品24小时加盟热线</p>
                        <p class="tel-bottom">4006-782-781</p>
                        <img src="<?= $bundle->baseUrl ?>/img/item_tel.jpg">
                    </div>
                </div>
            </div>
		<?php if((!empty($freeCate))&&count($freeCate)==2){?>
            <div class="home-item-content clearfix">
                <div class="item-lt">
                   <?= $freeCate[0]['content'] ?>
                </div>
                <div class="item-rt">
                    <i class="img-case43"><img src="<?= SiteHelper::getImgSrc($freeCate[0]['image_main']  )?>"/></i>
                    
                </div>
            </div>
       		 </div>

            <!--home-itemB-->
            <div class="home-itemB">
                <div class="home-item-content clearfix">
                    <div class="item-lt">
                        <i class="img-case1_3"><img src="<?= SiteHelper::getImgSrc($freeCate[1]['image_main'] ) ?>"/></i>
                     </div>

                    <div class="item-rt">
                      <?= $freeCate[1]['content'] ?>
                        <a class="item-btn ht_click-active"><span>加盟咨询</span><i><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png" /></i></a>
                    </div>

                </div>
            </div>
		<?php }?>
            <!--home-itemC-->
            <div class="home-itemC">
                <div class="item-box">
                    <div class="item-bar">
                        <img src="<?= $bundle->baseUrl ?>/img/ho_itemC.png">
                    </div>
                </div>

		<?php if(!empty($product_cate)){?>
                <div class="item-wrap" >
                    <div class="item-nav">
                        <ul id='product' class="navList clearfix">
                        	<?php foreach ($product_cate as $key=>$val){?>
                            <li rel=<?= $key?> ><a class="navItem"><?= $val['name'] ?><i class="item-triangle"></i></a></li>
                            <?php }?>
                            <li  class="  ipad-item">
                                <a class="navItem ht_click-active" href="<?= Url::to(['site/products','sname'=>$_SESSION['serial_id']]) ?>">查看更多</a>
                            </li>
                            <li  class="navItem-rtBtn">
                                <a class="item-btn ht_click-active" href="<?= Url::to(['site/products','sname'=>$_SESSION['serial_id']])?>"><span>查看更多产品</span><i><img src="<?= $bundle->baseUrl ?>/img/ico_white_add.png" /></i></a>
                            </li>
                        </ul>
                    </div>
				<?php foreach ($product_cate as $val){?>	
                    <ul class="ItemList-contain clearfix product " >
                    	<?php foreach ($products as $produt){
                    	if($produt['category_id']==$val['id']){?>
                        <li>
                            <dl>
								<dt class="img-case43"><img onclick="window.location.href='<?= Url::to(["site/product","sname"=>$_SESSION["serial_id"],"id"=>$produt["id"]]) ?> '"
								src="<?= SiteHelper::getImgSrc($produt['product_cover'])?>"></dt>
                                <dd class="ItemC-describe"><?= $produt['product_name'] ?></dd>
                            </dl>
                        </li>
                        <?php } }?>
                    </ul>
                <?php }?>    
                </div>
                <?php }?>
            </div>
           
            <!--home-itemD-->
             <?php if( !empty($cases) ){ ?>
            <div class="home-itemD">
                <div class="home-topBox">
                    <img class="itemD-ft-img" src="<?= $bundle->baseUrl ?>/img/ho_itemD_fl.png">

                </div>
                <div class="item-bar">
                    <p class="item-bar-txt cr_first-df"><?php if(!empty($cases_config['homepage_name'])){echo $cases_config['homepage_name'];}else{echo 'REAL  BRILLIANT';}?></p>
                    <p class="item-bar-txt cr_second-df"><?php if(!empty($cases_config['homepage_desc'])){echo $cases_config['homepage_desc'];}else{echo '没有噱头，实实在在的辉煌沉淀';}?></p>
                    <i class="itemD-logo ">
                        <img src="<?= $bundle->baseUrl ?>/img/logo.png"/>
                    </i>
                </div>

                <ul class="ItemList-contain clearfix">
                	<?php foreach ($cases as $case){?>
                    <li >
                        <dl class="shadow-df">
                            <dt class="img-case55"><img src="<?= SiteHelper::getImgSrc($case['image_main'])?>"></dt>
                            <dd class="ItemD-describe"><span class="font16"><?= $case['name'] ?></span><span class="font16"><?= $case['summary'] ?></span></dd>
                        </dl>
                    </li>
                    <?php }?>
                </ul>
            </div>
            <?php }?>

            <!--home-itemE-->
            <div class="home-itemE">
                    <img src="<?= $bundle->baseUrl ?>/img/ho_itemE_bg.jpg">
            </div>

            <!--home-itemF-->
            <div class="home-itemF">
                    <img src="<?= $bundle->baseUrl ?>/img/itemF-bg.jpg">
            </div>
            
 			<?php if(!empty($systems))?>
            <!--home-itemG-->           
            <div class="home-itemG">
                <div class="itemG-box">
                    <div class="itemTitle_style">
                        <p class="title-first ">新时代甜品，芋圆火爆来袭</p>
                        <p class="title-second"><i class="line-left"></i>甜品行业首创“深度扶持”模式<i class="line-right"></i></p>
                    </div>

                    <div class="ho-slide-wrap1 clearfix">
                        <ul class="ho-wrap1-list clearfix">
                        <?php foreach ($systems as $system){?>
                            <li><a class="half"><i ><?=$system['name'] ?></i></a></li>
                        <?php }?>
                        </ul>
                        <div class="ho-slider1">
                        <?php foreach ($systems as $system){?>
                            <dl class="slide clearfix">
                                <dt class="slide-item-half"><i class="img-case54"><img src="<?= SiteHelper::getImgSrc($system['image_main']) ?>"></i></dt>
                                <dd class="slide-item-half slide-txt">
                                    <p class="title-imgCase"><img src="<?= SiteHelper::getImgSrc($system['image_node']) ?>"></p>
                                    <div class="describe-content">
                                       <?= $system['content'] ?>
                                    </div>
                                </dd>
                            </dl>
                        <?php }?>
                        </div>
                        <div class="tel-blockBg">
                            <p>芋见甜品24小时加盟热线：<span><?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'] ;?></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!--home-itemH-->
            <?php if(!empty($brand_list)){?>
            <div class="home-itemH">
                <div class="itemH-box">
                    <div class="itemTitle_style">
                        <p class="title-first ">新时代甜品，芋圆火爆来袭</p>
                        <p class="title-second"><i class="line-left"></i>多种加盟方式可供选择<i class="line-right"></i></p>
                    </div>
                    <ul class="slider-H ">
                    <?php foreach($brand_list as $list){?>
                        <li class="slide ">
                            <i class="img-case21"><img src="<?= SiteHelper::getImgSrc($list['image_main'])?>"></i>
                        </li>
                     <?php }?>   
                    </ul>
                    <ul class="slider-H-nav clearfix">
                    <?php foreach ($brand_list as $list){?>
                        <li >
                            <i class="itemH-triangle"></i>
                            <a href="<?= Url::toRoute(['site/brand','sname'=>$_SESSION['serial_id'],'cat_id'=>$list['id']]) ?>">
                                <img src="<?= $bundle->baseUrl ?>/img/slider-H-item.png" />
                                <span><?= $list['name'] ?></span>
                            </a>
                        </li>
					<?php }?>
                    </ul>
                </div>
            </div>
			<?php }?>
            <!--home-itemI-->
            <?php if(!empty($joinModels)){?>
	            <div class="home-itemI">
	            
	                <div class="itemI-box">
	                    <div class="itemTitle_style">
	                        <p class="title-first ">开店与做代理，<span class="title-rt">多种加盟方式供选择</span></p>
	                        <p class="title-sub">欲了解详情，请立即拨打招商热线：<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'] ;?></p>
	                        <p class="title-sub">我们将有专门的招商经理为您详细讲解。</p>
	                    </div>
					<?php foreach ($joinModels as $joinModel){?>
	                    <div class=" txt-img-img">
	                        <div class=" item-contain">
	                            <div class="item-first">
	                                <p class="font30_bold"><?= $joinModel['name'] ?></p>
	                                <p class="describe"><?= $joinModel['summary']?></p>
	                            </div>
	                            <p class="item-second"><img   src="<?= SiteHelper::getImgSrc($joinModel['image_main'])?>"></p>
	                            <p class="item-third"><img  src="<?= SiteHelper::getImgSrc($joinModel['image_node'])?>"></p>
	                        </div>
	                      </div>  
	                  <?php }?>          
	                </div>
	            </div>
            <?php }?>

            <!--home-itemJ-->
            <div class="home-itemJ">
                <div class="itemI-box">
                    <div class="itemTitle_style">
                        <i class="lt-line-long"></i>
                        <i class="lt-line-short"></i>
                        <p class="title-first ">热烈祝贺芋见甜品<span class="title-rt">加盟店成功突破100家</span></p>
                        <i class="rt-line-long"></i>
                        <i class="rt-line-short"></i>
                    </div>
                </div>
                <?php if (!empty($services)){?>
                <ul class="ItemList-contain clearfix" style>
                	<?php foreach ($services as $service){?> 
	                    <li onclick="window.location.href='<?= Url::toRoute(['site/show-detail','sname'=>$_SESSION['serial_id'],'id'=>$service['id']]) ?>'">
	                        <dl class="shadow-df">
	                            <dt class="img-case43"><img src="<?= SiteHelper::getImgSrc($service['cover'])?>"></dt>
	                            <dd class="ItemD-describe"><?= $service['name'] ?>
	                    </li>
                    <?php } ?>
                </ul>
	<?php }?>
                <div class="tel-blockBg">
                    <p>芋见甜品24小时加盟热线：<span><?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'] ;?></span></p>
                </div>
            </div>

            <!--home-itemK-->
            <div class="home-itemK">
                <div class="itemK-box">
                     <img class="itemK_banner" src="<?= $bundle->baseUrl ?>/img/ho_itemK.jpg">
                    <div class="itemK-contain clearfix">
                        <!--itemK-lt-->
                        <div class="itemK-lt">
                            <p class="row-1s">留言免费获取详细加盟资料</p>
                            <p class="row-2s">现在填写加盟需求，总部还有2000元大礼包相送！</p>

                            <form class="itemK_form">
                                <p class="txt"><img src="<?= $bundle->baseUrl ?>/img/itemK_man.jpg"><input id='name' type="text"  placeholder="联系人"></p>
                                <p class="txt"><img src="<?= $bundle->baseUrl ?>/img/itemK_tel.jpg"><input id='phone' type="text"  placeholder="联系电话"></p>
                                <p class="txt"><img src="<?= $bundle->baseUrl ?>/img/itemK_mail.jpg"><input id='mail' type="text"  placeholder="联系邮箱"></p>

                                <textarea  placeholder="问题留言"></textarea>
                                <p class=" check"><input id="cap" type="text"  placeholder="验证码">
                                 <img onclick="changeImg()" src="<?php echo Url::toRoute(['site/sign-captcha','sname'=>$_SESSION['serial_id']])?>"></p>
                            </form>
                            <a id='join' class="item-btn ht_click-active"><span>立即加盟</span><i><img src="<?= $bundle->baseUrl ?>/img/ico_white_right.png" /></i></a>
                        </div>
                        <!--itemK-rt-->
                        <div class="itemK-rt">
                            <p class="title-24">甜品加盟常见问题解答</p>
                            <ul class="questionList" rel='<?= $questions_count ?>'>
                            <?php foreach ($questions as $question){?>
                                <li>
                                    <p class="question"><label>问</label><?= $question['name'] ?></p>
                                    <div class="answer"><label>答</label><?= $question['content']?></div>
                                </li>
                            <?php }?>    
                            </ul>
                            <p class="pageBox"><a class="goPage ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_left_white.png"></a><a class="goPage ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/ico_right_white.png"></a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!--home-itemL-->
            <div class="home-itemL">
                <div class="itemL-box">
                    <div class="itemTitle_style">
                        <p class="title-first ">芋见甜品加盟动态</p>
                        <p class="title-second"><i class="line-left"></i>多种加盟方式可供选择<i class="line-right"></i></p>
                    </div>
                    <div class="itemL-contain clearfix">
                        <div class="item-lt">
                            <p class="itemL-contain-title">加盟动态</p>
                            <div class="goUp-lt">
                                <ul >
                                <?php foreach ($join_infos as $join_info){?>
                                    <li class="clearfix">
                                        <div class="person">
                                            <img src="<?= $bundle->baseUrl ?>/img/person.png">
                                            <p><?= $join_info['name'] ?></p>
                                        </div>

                                        <div class="content">
                                            <p><?= $join_info['content'] ?></p>
                                        </div>
                                    </li>
								<?php }?>
                                </ul>
                            </div>
                        </div>

                        <div class="item-rt">
                            <p class="itemL-contain-title">新闻动态</p>
                            <div class="goUp-rt">
                            <?php if(!empty($articles)){?>
                            <ul >
                            <?php foreach($articles as $article){?>
                                <li >
                                    <p class="content"><?= "[".$article['name']."] ".$article['summary'] ?></p>
                                </li>
                            <?php }?>    
                            </ul>
                           <?php }?> 
                            </div>

                        </div>

                    </div>


                </div>
            </div>
				
            <div class="join-box ipad-display">
                <p class="join-bar">
                    <i class="join-bar-tel"><img src="<?= $bundle->baseUrl ?>/img/itemK_tel.jpg">加盟热线<span><?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'] ;?></span> </i>
                    <a class="join-bar-goTop ht_click-active"><img src="<?= $bundle->baseUrl ?>/img/goTop.png"></a>
                </p>
            </div>


        </div>
		<div class="float-box-rt">
		    <div class=" cooperation-df"><a class="fl-box-item " id="go-top-item" ></a><i class="triangle-df"></i></div>
		</div>
<?php $this->beginBlock('test') ?>  
     setNavActive('<?php echo CmsNav::TYPE_HOMEPAGE?>');
var page=1;
	$('#next').on('click',function(){
		page++;
		if(page>$('.questionList').attr('rel')){
			page=$('.questionList').attr('rel');
		}
		$.get(
			'<?= Url::toRoute(['site/index','sname'=>$_SESSION['serial_id']]) ?>',
			{
				'page':page
			},
			function(data){
				var msg=eval('(' + data + ')');
				var html='';
				$.each(msg,function(index,value){
					html+="<li><p class='question'><label>问</label>"+value['name']+"</p><div class='answer'><label>答</label>"+value['content']+"...</div></li>"
					$('.questionList').html(html);
				})
			}
		)
	})
	$('#prev').on('click',function(){
		page--;
		if(page<1){
			page=1;
		}
		$.get(
			'<?= Url::toRoute(['site/index','sname'=>$_SESSION['serial_id']]) ?>',
			{
				'page':page
			},
			function(data){
				var msg=eval('(' + data + ')');
				var html='';
				$.each(msg,function(index,value){
					html+="<li><p class='question'><label>问</label>"+value['name']+"</p><div class='answer'><label>答</label>"+value['content']+"...</div></li>"
					$('.questionList').html(html);
				})
			}
		)
	})
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>

