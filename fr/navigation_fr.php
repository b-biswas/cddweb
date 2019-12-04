<header id="header">
	
	<div class="logo">
		<!--	<span class="icon fa-diamond"></span>	-->
		
		<?php
			echo '<a class="imagea" href=index.php?lang=fr><img src="Images/asteroid1.png"></a>';
		?>
	</div>

	<div class="content">
		<div class="inner">
			<h1>
				Congrès des doctorant
			</h1>
			<h2>
				23 - 27 mars 2020
			</h2>
			<h2>
				(Tutoriel HTML - CSS - PHP)
			</h2>
		</div>
	</div>

	<nav id="nav">
		<ul>
			<?php
				echo '<li> <a href=./index.php?page=infos&lang=fr>Infos</a> </li>';
				echo '<li> <a href=./index.php?page=program&lang=fr>Programme</a> </li>';
			    echo '<li> <a href=./index.php?page=jobs&lang=fr>Métiers</a> </li>';
				echo '<li> <a href=./index.php?page=access&lang=fr>Accès</a> </li>';
				echo '<li> <a href=./index.php?page=contact&lang=fr>Contact</a> </li>';
			?>
		</ul>
	</nav>

</header>
