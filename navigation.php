<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/navigation_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/navigation_en.php");
	}
?>