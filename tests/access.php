<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/access_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/access_en.php");
	}
?>