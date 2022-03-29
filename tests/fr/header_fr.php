<?php
	if(!empty($_SESSION))
	{
	?>

	<div id="loginbox">
		<button>
			<a href="index.php?page=en/profile_fr"> Profil</a>
		</button>
		<button>
			<a href="index.php?page=fr/logout_fr">Se déconnecter</a>
		</button>

	</div>
	<?php
	}
	else
	{
	?>
	<div id="loginbox">
		<button>
			<a href="index.php?page=registration&lang=fr">S'enregistrer</a>
		</button>
		<button>
			<a href="index.php?page=login&lang=fr">Se connecter</a>
		</button>
	</div>
	<?php
	}
?>