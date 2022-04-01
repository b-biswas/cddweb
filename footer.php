<footer id="footer">

	<figure>
		<a class="imagea" href="https://ed560.ed.univ-paris-diderot.fr/en/the-doctoral-school/" target="_blank">
			<img src="Images/logos/logoED560.png" width=100px alt="ED560"/>
		</a>
		<a class="imagea" href="https://u-paris.fr/en/" target="_blank">
			<img src="Images/logos/logoUP.png" width=100px alt="UP"/>
		</a>
		<a class="imagea" href="http://www.ipgp.fr" target="_blank">
			<img src="Images/logos/logoIPGP.png" width=100px alt="IPGP"/>
		</a>
		<a class="imagea" href="http://www.cnrs.fr/en/cnrs" target="_blank">
			<img src="Images/logos/logoCNRS.png" width=100px alt="P7"/>
		</a>
		<a class="imagea" href="http://www.geosciences.ens.fr" target="_blank">
			<img src="Images/logos/logoENS.png" width=100px alt="ENS"/>
		</a>
		<a class="imagea" href="https://www.sorbonne-universite.fr/en" target="_blank">
			<img src="Images/logos/logoSU.png" width=100px alt="SU"/>
		</a>
		</br>
		<a class="imagea" href="https://www.psl.eu/en" target="_blank">
			<img src="Images/logos/logoPSL.png" width=100px alt="logoPSL"/>
		</a>
		<a class="imagea" href="https://www.apc.univ-paris7.fr/APC_CS/en/" target="_blank">
			<img src="Images/logos/logoAPC.png" width=100px alt="APC"/>
		</a>
		<a class="imagea" href="http://lpnhe.in2p3.fr/?lang=en" target="_blank">
			<img src="Images/logos/logoLPNHE.png" width=100px alt="LPNHE"/>
		</a>
		<a class="imagea" href="http://www.lpthe.jussieu.fr/spip/?lang=en" target="_blank">
			<img src="Images/logos/logoLPTHE.png" width=100px alt="LPTHE"/>
		</a>
		<a class="imagea" href="https://www.universite-paris-saclay.fr/en/recherche/laboratoire/service-dastrophysique-sap-laboratoire-aim" target="_blank">
			<img src="Images/logos/logoAIM.png" width=100px alt="AIM"/>
		</a>
		<a class="imagea" href="https://irfu.cea.fr/" target="_blank">
			<img src="Images/logos/logoCEA.png" width=100px alt="IFRU-CEA"/>
		</a>
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