<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/infos_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/infos_en.php");
	}
?>