<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/home_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/home_en.php");
	}
?>