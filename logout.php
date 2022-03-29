<?php
if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/logout_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/logout_en.php");
	}
?>