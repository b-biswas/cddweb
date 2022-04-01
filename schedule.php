<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/outline_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/outline_en.php");
	}
?>