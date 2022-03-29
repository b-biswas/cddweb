<?php
	if(!empty($_SESSION))
	{
	?>

	<div id="loginbox">
		<button>
			<a href="index.php?page=profile&lang=fr"> Profil</a>
		</button>
		<button>
			<a href="index.php?page=logout&lang=fr">Se déconnecter</a>
		</button>

	</div>
	<?php
	}
	else
	{
	?>
	<div id="loginbox">
		<button>
			<a href="index.php?page=registration&lang=fr">S'inscrire</a>
		</button>
		<button>
			<a href="index.php?page=login&lang=fr">Se connecter</a>
		</button>
	</div>
	<?php
	}
?>