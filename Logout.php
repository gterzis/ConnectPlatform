<?php
	session_start();
	unset($_SESSION['user_id']);
	unset($_SESSION['user_email']);
	unset($_SESSION['user_pass']);
	session_destroy();
	header("Location: http://localhost/Local%20Server/ConnectPlatform/Login/Login.php");
?>