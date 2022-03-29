<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/profile_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/profile_en.php");
	}
?>