
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="main.css" />
		<title>CdD 2020 (tutorial)</title>
	</head>


	<body onload="check_redirection();">

		<?php include("header.php"); ?>

		<div id="wrapper">
			<?php include("navigation.php"); ?>
			
			<div id="maino"> <br/>
				<div id="page">

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