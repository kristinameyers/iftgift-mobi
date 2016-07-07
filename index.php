<?php 

	include('connect/connect.php');	
	include('config/config.php');	
	
	$page ='home';
	
	foreach($_GET as $key => $val){
		$$key = $val;
	}

	
if (!file_exists($rootpath . 'inc/' .  $page .'.php' ) ){
			$page='home';

}

	include(ru_common . 'header.php');
	if($page == 'dashboard' || $page == 'listings' || $page == 'cash_stash' || $page == 'profile' || $page == 'step_1' || $page == 'step_2a' || $page == 'step_2b' || $page == 'cart' || $page == 'detail' || $page == 'delivery_detail' || $page == 'giver_info' || $page == 'recp_info' || $page == 'notify_datetime' || $page == 'unlock_datetime' || $page == 'review_gift' || $page == 'personal_note' || $page == 'checkout' || $page == 'confirmation' || $page == 'upload_image' || $page == 'unwrap' || $page == 'search' || $page == 'locked' || $page == 'open_iftgift' || $page == 'unwraped' || $page == 'only' || $page == 'iftClique' || $page == 'similar_persons' || $page == 'search' || $page == 'search_result' || $page == 'controls' || $page == 'reminder' || $page == 'inbox' || $page == 'outbox' || $page == 'personalinformation' || $page == 'iftcliques' || $page == 'product_detail' || $page == 'category' || $page == 'transfercashstash' || $page == 'deposit_cashstash' || $page == 'withdraw_cashstash' || $page == 'checkoutshop')
	{
		include(ru_common . 'security.php'); 
	}
	if($page == 'step_2a' || $page == 'step_2b' || $page == 'listings' || $page == 'cart' || $page == 'detail' || $page == 'delivery_detail' || $page == 'giver_info' || $page == 'recp_info' || $page == 'notify_datetime' || $page == 'unlock_datetime' || $page == 'review_gift' || $page == 'personal_note' || $page == 'checkout' || $page == 'confirmation' || $page == 'locked' || $page == 'open_iftgift' || $page == 'unwraped' || $page == 'only' || $page == 'iftClique' || $page == 'similar_persons' || $page == 'search' || $page == 'search_result' || $page == 'category' || $page == 'product_detail' || $page == 'checkoutshop')
	{
		include(ru_common . 'top.php');
	}
	/*if($page == 'checkout') {
		include('stripe/lib/Stripe.php');
	}*/
	include(ru_inc .$page.'.php');
	include(ru_common . 'footer.php'); 
?>