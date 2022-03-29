<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/registration_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/registration_en.php");
	}
?>

