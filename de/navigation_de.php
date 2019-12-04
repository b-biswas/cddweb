<header id="header">
	
	<div class="logo">
		<!--	<span class="icon fa-diamond"></span>	-->
		
		<?php
		if(array_key_exists('page', $_GET))
		{
			echo '<a class="imagea" href=index.php?'.$_GET['page'].'&lang=de><img src="Images/asteroid1.png"></a>';
		}
		else
		{
			echo '<a class="imagea" href=index.php?lang=de><img src="images/logos/logoCDD_border.svg"></a>';
		}
		?>	</div>

	<div class="content">
		<div class="inner">
			<h1>
				PhD Student Conference<br/>
				Page to be translated
			</h1>
			<h2>
				March 23 - 27 2020
			</h2>
			<h2>
				(HTML - CSS - PHP tutorial)
			</h2>
		</div>
	</div>

	<nav id="nav">
		<ul>
			<?php
				echo '<li> <a href=./index.php?page=infos&lang=de>Infos</a> </li>';
				echo '<li> <a href=./index.php?page=program&lang=de>Program</a> </li>';
			    echo '<li> <a href=./index.php?page=jobs&lang=de>Jobs</a> </li>';
				echo '<li> <a href=./index.php?page=access&lang=de>Access</a> </li>';
				echo '<li> <a href=./index.php?page=contact&lang=de>Contact</a> </li>';
			?>
		</ul>
	</nav>

</header>
