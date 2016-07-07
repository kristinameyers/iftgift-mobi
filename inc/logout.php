<?php
		session_start();
		unset($_SESSION["LOGINDATA"]);
		unset($_SESSION['recipit_id']['New']);
		unset($_SESSION['products']);
		unset($_SESSION['delivery_id']['New']);
		header("location:".ru."login?loggedout=true");
	
?>