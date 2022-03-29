<?php
	if(array_key_exists('page', $_GET))
	{
		if ($_GET['page'] = 'admin')
		{
			$pfile = "admin.php";
		}
		elseif($_GET['page']=="index")
		{
			$pfile = "en/home_en.php";
		}
		else
		{
			$pfile = 'en/'.$_GET['page'].'_en.php';
		}
	}
	else
	{
		$pfile = "en/home_en.php";
	}
?>

<p>
	<?php
		echo "Last modified: " . date("d/m/Y",filemtime($pfile));
	?>
</p>

<p class="copyright">
	&copy; Untitled. Design: <a href="https://html5up.net">HTML5 UP</a>.
</p>

<p class="copyright">
	Background image credits: ESO/M. Kornmesser/Nick Risinger/ L. Calcada.
</p>
