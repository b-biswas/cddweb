<header id="header">
	
	<div class="logo">
		<?php
			echo '<a class="imagea" href=index.php?lang=fr><img src="Images/logos/logoCDD_NB.jpg"></a>';
		?>
	</div>

	<div class="content">
		<div class="inner">
			<h1>
				Congrès des doctorants
			</h1>
			<h2>
				13 - 15 Avril 2022
			</h2>
		</div>
	</div>

	<nav id="nav">
		<ul>
			<?php
				echo '<li> <a href=./index.php?page=infos&lang=fr>Infos</a> </li>';
				echo '<li> <a href=./index.php?page=program>Program</a> </li>';
				echo '<li> <a href=./index.php?page=access&lang=fr>Accès</a> </li>';
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
				echo '<li> <a href=./index.php?page=program>Program</a> </li>';
				echo '<li> <a href=./index.php?page=contact&lang=fr>Contact</a> </li>';
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
