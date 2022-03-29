<?php
	if(array_key_exists('page', $_GET))
	{
		if ($_GET['page'] = 'admin')
		{
			$pfile = "admin.php";
		}
		elseif($_GET['page']=="index")
		{
			$pfile = "fr/home_fr.php";
		}
		else
		{
			$pfile = 'fr/'.$_GET['page'].'_fr.php';
		}
	}
	else
	{
		$pfile = "fr/home_fr.php";
	}
?>

<p>
	<?php
		echo "Dernière modification : " . date("d/m/Y",filemtime($pfile));
	?>
</p>

<p class="copyright">
	&copy; Untitled. Design: <a href="https://html5up.net">HTML5 UP</a>.
</p>

<p class="copyright">
	Crédits image de fond: ESO/M. Kornmesser/Nick Risinger/ L. Calcada.
</p>