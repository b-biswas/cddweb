<header id="header">
	
	<div class="logo">
		
		<?php
			echo '<a class="imagea" href=index.php?lang=de><img src="Images/logos/logo_cdd2020_transparent.png"></a>';
		?>
	</div>

	<div class="content">
		<div class="inner">
			<h1>
				Congrès des doctorants
			</h1>
			<h2>
				23 - 27 mars 2020
			</h2>
		</div>
	</div>

	<nav id="nav">
		<ul>
			<?php
				echo '<li> <a href=./index.php?page=infos&lang=fr>Infos</a> </li>';
				echo '<li> <a href=./index.php?page=program&lang=fr>Programme</a> </li>';
			    echo '<li> <a href=./index.php?page=jobs&lang=fr>Emploi</a> </li>';
				echo '<li> <a href=./index.php?page=access&lang=fr>Accès</a> </li>';
				echo '<li> <a href=./index.php?page=contact&lang=fr>Contact</a> </li>';
			?>
		</ul>
	</nav>

	<?php
		if(!empty($_SESSION))
		{
		?>

		<nav id="nav">
			<ul>
				<?php
				echo '<li> <a href=./index.php?page=abstract&lang=fr>Résumés</a> </li>';
				?>

			<?php
				if($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'job' || $_SESSION['status'] == 'program' || $_SESSION['status'] == 'foreign')
				{
					echo '<li> <a href=./index.php?page=guests&lang=fr>Invités</a> </li>';
				}
				if($_SESSION['status'] == 'admin')
				{
					echo '<li> <a href=./index.php?page=admin>Admin</a> </li>';
				}
			?>
			</ul>
		</nav>

		<?php
		}
	?>

</header>
