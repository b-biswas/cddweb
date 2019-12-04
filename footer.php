<footer id="footer">
	<figure>
		<a class="imagea" href="https://ed560.ed.univ-paris-diderot.fr/en/the-doctoral-school/" target="_blank"><img src="images/logos/logoED560_rond.png" width=100px alt="ED560"/></a>
		<a class="imagea" href="http://www.ipgp.fr" target="_blank"><img src="images/logos/logoIPGP_rond.png" width=100px alt="IPGP"/></a>
		<a class="imagea" href="http://www.univ-paris-diderot.fr" target="_blank"><img src="images/logos/logoP7_rond.png" width=100px alt="P7"/></a>
		<a class="imagea" href="http://www.geosciences.ens.fr" target="_blank"><img src="images/logos/logoENS_rond.png" width=100px alt="ENS"/></a>
		<a class="imagea" href="http://www.sorbonne-paris-cite.fr" target="_blank"><img src="images/logos/logoPRES_rong.png" width=100px alt="PRES"/></a>
	</figure>
	
	<p>
		<?php
		$file = $_SERVER["SCRIPT_NAME"];
		$break = Explode('/', $file);
		$pfile = $break[count($break) - 1];
		//echo $pfile;
		echo "Last modified: " .date("d F Y",filemtime($pfile));
		?>
	</p>
		
	<p class="copyright">&copy; Untitled. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
</footer>