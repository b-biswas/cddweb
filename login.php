<?php
if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/login_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/login_en.php");
	}

?>