<?php
	if(!empty($_SESSION))
	{
	?>

	<div id="loginbox">
		<button>
			<a href="index.php?page=profile"> Profile </a>
		</button>
		<button>
			<a href="index.php?page=logout"> Log out </a>
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