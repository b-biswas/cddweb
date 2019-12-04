<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/contact_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/contact_en.php");
	}
?>