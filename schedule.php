<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/schedule_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/schedule_en.php");
	}
?>