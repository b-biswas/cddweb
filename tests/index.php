<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="main.css" />
		<title>CdD 2020</title>
		<link rel="shortcut icon" type="image/png" href="Images/favicon.png"/>
	</head>


	<body onload="check_redirection();">


		<?php session_start(); ?>
		<?php
			require("password_compat-master/lib/password.php");
		?>
		<?php include("header.php"); ?>

		<div id="wrapper">
			<?php include("navigation.php"); ?>
			
			<div id="maino"> <br/>
				<div id="page">
					
					<?php
						// Uncommented the following line the first time it's uploaded on the server to make sure it's compatible. Must return "Pass"
						//require("password_compat-master/version-test.php");
					?>

					<?php
						if(array_key_exists('page', $_GET))
						{
							if($_GET['page']=="index")
							{
								include("home.php");
							}
							else
							{
								include($_GET['page'].'.php');
							}
						}
						else
						{
							include("home.php");
						}
					?>
				</div>
			</div>
			<?php include("footer.php"); ?>
		</div>
	</body>

</html>