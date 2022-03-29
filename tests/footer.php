<footer id="footer">

	<figure>
		<a class="imagea" href="https://ed560.ed.univ-paris-diderot.fr/en/the-doctoral-school/" target="_blank"><img src="Images/logos/logoED560_rond.png" width=100px alt="ED560"/></a>
		<a class="imagea" href="http://www.ipgp.fr" target="_blank"><img src="Images/logos/logoIPGP_rond.png" width=100px alt="IPGP"/></a>
		<a class="imagea" href="http://www.univ-paris-diderot.fr" target="_blank"><img src="Images/logos/logoP7_rond.png" width=100px alt="P7"/></a>
		<a class="imagea" href="http://www.geosciences.ens.fr" target="_blank"><img src="Images/logos/logoENS_rond.png" width=100px alt="ENS"/></a>
		<a class="imagea" href="http://www.sorbonne-paris-cite.fr" target="_blank"><img src="Images/logos/logoPRES_rong.png" width=100px alt="PRES"/></a>
	</figure>
	
	
<?php
	if(array_key_exists('lang', $_GET))
	{
		include($_GET['lang'].'/footer_'.$_GET['lang'].'.php');
	}
	else
	{
		include("en/footer_en.php");
	}
?>

</footer>