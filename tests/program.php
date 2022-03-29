<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/program_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/program_en.php");
	}
?>