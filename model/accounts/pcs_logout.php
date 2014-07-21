<?php
	/****************************************************************************************
	 *								Script Executed When Loaded								*
	 ****************************************************************************************/

	session_name("cleo_usr");
	session_start();
	unset($_SESSION["cleo_usr"]);

	header("Location: ../../web/login.php?form_message=Log-out%20successful!");
?>