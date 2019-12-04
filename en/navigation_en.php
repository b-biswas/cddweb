<header id="header">
	
	<div class="logo">
		<!--	<span class="icon fa-diamond"></span>	-->
		<?php
		if(array_key_exists('lang', $_GET))
		{
			echo '<a class="imagea" href=index.php?lang=en><img src="Images/asteroid1.png"></a>';
		}
		else
		{
			echo '<a class="imagea" href=index.php><img src="images/logos/logoCDD_border.svg"></a>';
		}
		?>

	</div>

	<div class="content">
		<div class="inner">
			<h1>
				PhD Student Conference
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
				if(array_key_exists('lang', $_GET))
				{
					echo '<li> <a href=./index.php?page=infos&lang=en>Infos</a> </li>';
					echo '<li> <a href=./index.php?page=program&lang=en>Program</a> </li>';
				    echo '<li> <a href=./index.php?page=jobs&lang=en>Jobs</a> </li>';
					echo '<li> <a href=./index.php?page=access&lang=en>Access</a> </li>';
					echo '<li> <a href=./index.php?page=contact&lang=en>Contact</a> </li>';
				}
				else
				{
					echo '<li> <a href=./index.php?page=infos>Infos</a> </li>';
					echo '<li> <a href=./index.php?page=program>Program</a> </li>';
				    echo '<li> <a href=./index.php?page=jobs>Jobs</a> </li>';
					echo '<li> <a href=./index.php?page=access>Access</a> </li>';
					echo '<li> <a href=./index.php?page=contact>Contact</a> </li>';	
				}
			?>
		</ul>
	</nav>

</header>
