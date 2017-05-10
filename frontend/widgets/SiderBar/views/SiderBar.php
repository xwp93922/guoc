<?php
use yii\helpers\Url;
use common\helpers\SiteHelper;
$bundle = frontend\themes\t00008\AppAsset::register($this);?>
                        <?php if(!empty($recommend_list)){
                        	if($type==1){?>
                        <div class="aside-block aside-recommend ">
	                        <p class="title-df">相关推荐</p>
	                        <ul class="list-df">	                        
	                        <?php foreach ($recommend_list as $key=>$re){
	                            if($key<4){
	                        ?>
	                            <li class="li-img-df">
	                                <a href="<?= Url::to(['site/product','sname'=>$_SESSION['serial_id'],'id'=>$re['id']]) ?>">
                                        <i class="img-case43"><img  src="<?= SiteHelper::getImgSrc($re['product_cover'])?>"></i>
                                        <span    class="row-describe"><?= $re['product_name'] ?></span>
                                    </a>
	                             </li>
	                         <?php }}?>   
	                        </ul>
                   		 </div>
                        <?php }else if($type==2){?>
                        	<div class="aside-block aside-recommend ">
                        	     <p class="title-df">相关推荐</p>
                        	     <ul class="list-df">
                        	     <?php foreach ($recommend_list as $val){?>
                        	     <li class="li-df-a"><img  class="ico-pot" src="<?= $bundle->baseUrl ?>/img/pots.png">
                        	     <a href="<?= Url::toRoute(['site/news','sname'=>$_SESSION['serial_id'],'id'=>$val['id']]) ?>" class="row-item"><?=$val['name'] ?></a></li>
                        	     <?php }?>
                        	     </ul>
                        	</div>
                        <?php }}?>	