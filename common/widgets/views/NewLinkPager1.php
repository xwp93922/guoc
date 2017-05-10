<div class="phone-page ">
     <i  class="btn-left ht_click-active"><a href="<?= $pagination->createUrl($prePage['page']) ?>" style="color:inherit"><span class="fy_st">上一页</span></a></i>
     <i class="btn-mid">
       <?= $pageCount ?>/<select class="page-select" onchange="window.location=this.value" >
        <?php foreach( $buttons as  $val ){ ?>
        <option value="<?= $pagination->createUrl($val['page']) ?>"><?= $val['label'] ?></option>
	    <?php } ?>
		</select>
     </i>
     <i class="btn-right ht_click-active"> <a href="<?= $pagination->createUrl($nextPage['page']) ?>" style="color:inherit"><span class="fy_st">下一页</span></i>
</div>