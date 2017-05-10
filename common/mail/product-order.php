<?php 
use common\helpers\SiteHelper;
?>

<style>
th{min-width:130px;padding:10px 0;}
td{min-width:550px;padding:10px 5px;}
</style>

<h2>A New Order</h2>

<table border="1" cellspacing="0" cellpadding="0">
	<?php foreach ($inquiry_detail as $key=>$val) {?>
	<tr>
		<th><?php echo $key?></th>
		<td><?php echo $val?></td>
	</tr>
	<?php }?>
</table>