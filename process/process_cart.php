<?php
include_once("../connect/connect.php");
include_once("../config/config.php");
mysql_query("SET NAMES 'utf8'");
$last_visted_page = $_SERVER['HTTP_REFERER'];
$category_name = explode('/',$last_visted_page);
if(isset($_POST['type']) && $_POST['type']=='add')
{
	
	$proId = filter_var($_POST['proId'], FILTER_SANITIZE_STRING);
	$userId = filter_var($_POST['userId'], FILTER_SANITIZE_STRING);
	$qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);
	
	$get_pro = mysql_query("select * from ".tbl_product." where proid = '".$proId."'");
	$obj = mysql_fetch_object($get_pro);
	if ($get_pro) {
		/*--------------Function Used For Gift Suggestion Points-------------------*/
		user_suggest_points($userId);
		/*--------------Function Used For Gift Suggestion Points-------------------*/
		$new_product = array(array('proid'=>$proId, 'name'=>$obj->pro_name, 'qty'=>$qty, 'price'=>$obj->price, 'image'=>$obj->image_code));
		if(count($_SESSION["products"]) >= 6)
		{ 
			header('Location:'.ru.'cart/');
		} else {
		if(isset($_SESSION["products"])) 
		{
			$found = false; 
			
			foreach ($_SESSION["products"] as $cart_itm)
			{
				if($cart_itm["proid"] == $proId){ 
					
					$product[] = array('proid'=>$cart_itm["proid"], 'name'=>$cart_itm["name"], 'image'=>$cart_itm["image"], 'qty'=>$qty, 'price'=>$cart_itm["price"]);
					$found = true;
				}else{
				
					$product[] = array('proid'=>$cart_itm["proid"], 'name'=>$cart_itm["name"], 'image'=>$cart_itm["image"], 'qty'=>$qty, 'price'=>$cart_itm["price"]);
				}
			}
			
			if($found == false) 
			{
				
				$_SESSION["products"] = array_merge($product, $new_product);
			}else{
				
				$_SESSION["products"] = $product;
			}
			
		}else{
			
			$_SESSION["products"] = $new_product;
		}
	  }
	}
	//echo ru.'listings/'.encodeURL($category_name[5]);exit;
	if($last_visted_page == ru.'listings/'.encodeURL($category_name[5]) || $last_visted_page == ru.'product_detail/'.$proId) { 
	header('Location:'.ru.'category/'.encodeURL($obj->category));
	} else {
	header('Location:'.ru.'step_2b/'.encodeURL($obj->sub_category));
	}
}


if(isset($_GET["removep"]) && isset($_SESSION["products"]))
{
	$proId 	= $_GET["removep"];

	
	foreach ($_SESSION["products"] as $cart_itm) 
	{
		
		if($cart_itm["proid"] != $proId){
		
			$product[] = array('proid'=>$cart_itm["proid"], 'name'=>$cart_itm["name"], 'image'=>$cart_itm["image"], 'qty'=>$qty, 'price'=>$cart_itm["price"]);
		}
		
		$_SESSION["products"] = $product;
	}
	
	header('Location:'.ru.'step_2a/');
}

?>