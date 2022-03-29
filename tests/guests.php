<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/guests_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/guests_en.php");
	}
?>