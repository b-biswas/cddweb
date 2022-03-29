<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/jobs_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/jobs_en.php");
	}
?>