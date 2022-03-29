<?php
	if(!empty($_SESSION))
	{
	?>

	<div id="loginbox">
		<button>
			<a href="index.php?page=en/profile_en"> Profile </a>
		</button>
		<button>
			<a href="index.php?page=en/logout_en"> Log out </a>
		</button>

	</div>
	<?php
	}
	else
	{
	?>
	<div id="loginbox">
		<button>
			<a href="index.php?page=registration"> Sign up </a>
		</button>
		<button>
			<a href="index.php?page=login"> Sign in </a>
		</button>
	</div>
	<?php
	}
?>