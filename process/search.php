<?php 
include_once('../connect/connect.php');
include_once('../config/config.php');

 $recption_id = $_SESSION['recipit_id']['New'];
 $query = "select recipit_id,cash_gift,gender,age,ocassion,email from ".tbl_recipient." where recipit_id = '".$recption_id."'";
 $get_info = $db->get_row($query,ARRAY_A);
 $cash = $get_info['cash_gift'];
 $gender = $get_info['gender'];
 $age = $get_info['age'];
 $ocassion = $get_info['ocassion'];
 $get_price = get_price($cash);
 $get_data = get_category($gender,$age);
 $get_occassion_data = get_ocassion($ocassion);
 $price_less = $cash - ($cash * 10/100);
 $price_add = $cash + ($cash * 10/100);

 $keyword = $_POST['search'];
 $price_from	=	$_POST['price_from'] - ($_POST['price_from'] * 10/100);
 $price_to = $_POST['price_to'] - ($_POST['price_to'] * 10/100);
 $control = $_POST['location'];

$chk_users = mysql_query("select userId,email from ".tbl_user." where email = '".$get_info['email']."'");
 	if(mysql_num_rows($chk_users) > 0) {
 	$get_userid = mysql_fetch_array($chk_users);
	$uId = $get_userid['userId'];
	$owndata = "and own_id not like '%".$uId."%'";
	$hidedata = "and hide_id not like '%".$uId."%'";
	$lovedata = "ORDER BY love_id DESC";
}
 
 if($price_from != '' && $price_to != '') {
 	$price = "AND (price >= '".$price_from."' AND price <= '".$price_to."')";
 } else if($price_from != '' &&  $price_to == '') {
 	$price = "AND price <= '".$price_from."'";
 } else if($price_from == '' &&  $price_to != '') {
 	$price = "AND price <= '".$price_to."'";
 }else {
 	$price = "AND (price >= '".$price_less."' AND price <= '".$price_add."')";
 }
 
 ?>
<div role="main" class="ui-content jqm-content jqm-content-c product_bar">
 	<div tabindex="-1" id="horizontal-scrollbar-demo" class="default-skin demo scrollable">
			<div class="viewport">
				<div style="top:0px; left:0;" class="overview">
					 <?php
					if($control == 1){
						 $search_query = "select * from ".tbl_product." where (sub_category like '%".mysql_real_escape_string(stripslashes(trim($keyword)))."%' or category like '%".mysql_real_escape_string(stripslashes(trim($keyword)))."%' or pro_name like '%".mysql_real_escape_string(stripslashes(trim($keyword)))."%') $get_data $price $owndata $hidedata  and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
					} else if($control == 2){
						 $search_query = "select * from ".tbl_product." where (sub_category like '%".mysql_real_escape_string(stripslashes(trim($keyword)))."%' or category like '%".mysql_real_escape_string(stripslashes(trim($keyword)))."%' or pro_name like '%".mysql_real_escape_string(stripslashes(trim($keyword)))."%') $get_data $price $get_occassion_data and (status = 1 or status = 0) and hide_id not like '%".$_SESSION['LOGINDATA']['USERID']."%'";
					}
					$view_pro = $db->get_results($search_query,ARRAY_A);
					//echo '<pre>';print_r($view_pro);
					if($view_pro)
					{
						foreach($view_pro as $product)
						{
						?>
						<div class="list">
							<a href="<?php echo ru;?>step_2b/<?php echo $product['proid'];?>" data-ajax="false"><img src="<?php  get_image($product['image_code']);?>" alt="<?php echo substr($product['pro_name'],0,20);?>"></a>
							<h4><?php echo substr($product['pro_name'],0,20);?></h4>
							<h4 class="price">$&nbsp;<?php echo $product['price']?></h4>
						</div>
					<?php
						}
					} else { 
					?>
					<div style="margin-left:20px;">
					No Any Product Match Your Criteria
					</div>
					<?php	
					}	  
					?>
				</div>
		   </div>
	</div>
</div>