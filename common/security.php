<?php
	if (!isset($_SESSION['LOGINDATA']['ISLOGIN'])) {
		header('location:'.ru); exit;
	}
?>