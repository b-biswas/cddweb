<?php
	if(!empty($_SESSION))
	{
	?>

	<div id="loginbox">
		<button>
			<a href="index.php?page=en/profile_de"> Profile </a>
		</button>
		<button>
			<a href="index.php?page=de/logout_en"> Einloggen </a>
		</button>

	</div>
	<?php
	}
	else
	{
	?>
	<div id="loginbox">
		<button>
			<a href="index.php?page=registration&lang=de"> Registrieren </a>
		</button>
		<button>
			<a href="index.php?page=login&lang=de"> Einloggen </a>
		</button>
	</div>
	<?php
	}
?>