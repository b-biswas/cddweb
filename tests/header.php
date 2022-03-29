<div id="topbox">
	<!-- Choice of the language -->
	<?php
	if(array_key_exists('page', $_GET))
	{
		?>
		<div id="langbox">
			<?php echo '<a href=index.php?page='.$_GET['page'].'&lang=en>En</a>' ?>
			&#x2502;
			<?php echo '<a href=index.php?page='.$_GET['page'].'&lang=fr>Fr</a>' ?>
			&#x2502;
			<?php echo '<a href=index.php?page='.$_GET['page'].'&lang=de>De</a>' ?>
		</div>
		<?php
	}
	else
	{
		?>
		<div id="langbox">
			<a href="index.php?page=home&lang=en">En</a>
			&#x2502;
			<a href="index.php?page=home&lang=fr">Fr</a>
			&#x2502;
			<a href="index.php?page=home&lang=de">De</a>
		</div>
		<?php
	}
	?>

	<!-- Registration -->

	<?php
		if(array_key_exists('page', $_GET))
		{
			if(array_key_exists('lang', $_GET))
			{
				include($_GET['lang'].'/header_'.$_GET['lang'].'.php');
			}
			else
			{
				include("en/header_en.php");
			}
		}
		else
		{
			if(array_key_exists('lang', $_GET))
			{
				include($_GET['lang'].'/header_'.$_GET['lang'].'.php');
			}
			else
			{
				include("en/header_en.php");
			}
		}
	?>
</div>
