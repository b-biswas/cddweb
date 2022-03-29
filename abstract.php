<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/abstract_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/abstract_en.php");
	}
?>