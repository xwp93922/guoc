<ul class="example-takePage-bar" >
    <li class="example-takePage-item"><a class="example_takePage_btn"  href="<?= $pagination->createUrl($prePage['page']) ?>" style="color:inherit"><span class="fy_st"><<</span></a></li>
    <?php foreach( $buttons as  $val ){ ?>
    <li class="example-takePage-item <?php if( $val['active'] ){ echo 'example-page-choice'; } ?>"><a class="example_takePage_btn" href="<?= $pagination->createUrl($val['page']) ?>" style="color:inherit"><span class="fy_st"><?= $val['label'] ?></span></a></li>
    <?php } ?>
    <li class="example-takePage-item"><a class="example_takePage_btn" href="<?= $pagination->createUrl($nextPage['page']) ?>" style="color:inherit"><span class="fy_st">>></span></a></li>
</ul>

