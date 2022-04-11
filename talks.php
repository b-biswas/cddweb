<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/talks_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/talks_en.php");
	}
?>
