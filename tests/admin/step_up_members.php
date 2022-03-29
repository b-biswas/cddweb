<?php

	session_start();

	if (array_key_exists('status', $_SESSION))
	{
		if($_SESSION['status'] == 'admin')
		{
			//////////////
			// Web team //
			//////////////

			$email = array('gatelet@apc.in2p3.fr', 'teyssendier@ipgp.fr', 'leo.petit@ens.fr', 'sahmedma@lpnhe.in2p3.fr', 'laag@ipgp.fr', 'demasy@ipgp.fr');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'admin';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			//////////////////
			// Program team //
			//////////////////
			
			$email = array('romain.bouquet04@gmail.com', 'tassin@ipgp.fr', 'alexandre.janin@ens.fr', 'tissandier@ipgp.fr', 'gaugarde@lpnhe.in2p3.fr', 'bajou@apc.in2p3.fr', 'jost@apc.in2p3.fr');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'program';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			////////////////////////
			// Communication team //
			////////////////////////

			$email = array('thapa@ipgp.fr', 'souradeep.mahato.c2017@iitbombay.org', 'farge@ipgp.fr', 'quocviet.nguyen@lpnhe.in2p3.fr');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'communication';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			//////////////////////////
			// Foreign student team //
			//////////////////////////

			$email = array('menina@ipgp.fr', 'michelangelotraina@yahoo.com', 'yajun.he@lpnhe.in2p3.fr', 'keisuke.onodera@etu.univ-paris-diderot.fr', 'bouih@ipgp.fr');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'foreign';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			//////////////
			// Job team //
			//////////////

			$email = array('dhabaria@ipgp.fr', 'sylvain.breton@cea.fr', 'mathilde.espinasse@cea.fr', 'dupiau@ipgp.fr');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'job';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			////////////////////
			// Logistics team //
			////////////////////

			$email = array('alaurent@ipgp.fr', 'heraibi@ipgp.fr', 'zouari@apc.in2p3.fr', 'robin.gpre@gmail.com', 'dqnam1995@gmail.com', 'ostorero@ipgp.fr', 'leon75vidal@gmail.com');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'logistics';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			///////////////////////
			// Coordination team //
			///////////////////////

			$email = array('caurant@ipgp.fr', 'perron@ipgp.fr', 'hugo.roussille@apc.in2p3.fr', 'julie.rode@lpnhe.in2p3.fr', 'emilie.pirot@gmail.com');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'coordination';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			/////////////////////
			// D2, D3 students //
			/////////////////////

			$email = array('freiss@lpnhe.in2p3.fr', 'gstagnit@lpthe.jussieu.fr', 'dayu.tou@lpnhe.in2p3.fr', 'cverges@apc.in2p3.fr', 'yufeng.wang@lpnhe.in2p3.fr', 'jad.zahreddine@lpnhe.in2p3.fr', 'jzopouni@lpnhe.in2p3.fr', 'zhu@ipgp.fr', 'rozier@ipgp.fr', 'Michela.Lai@ca.infn.it', 'federico.versari@bo.infn.it', 'bieber@ipgp.fr', 'adourian@ipgp.fr', 'habel@ipgp.fr', 'dejean@ipgp.fr ', 'mensahadjei@ipgp.fr', 'benbelkacem@ipgp.fr', 'ajacob@ipgp.fr', 'ropp@ipgp.fr', 'delmanzo@ipgp.fr', 'arcelin@apc.in2p3.fr', 'pierre.auclair@apc.in2p3.fr', 'makarim@apc.in2p3.fr', 'francesco.carotenuto@cea.fr', 'chalumeau.aurelien@apc.in2p3.fr', 'chardonn@apc.in2p3.fr', 'nchau@apc.in2p3.fr', 'munoz@ipgp.fr', 'lai@ipgp.fr', 'zwang@ipgp.fr', 'elbouha@apc.in2p3.fr', 'asanchez@ipgp.fr', 'thomas.grammatico@lpnhe.in2p3.fr', 'korochki@apc.in2p3.fr', 'christelle.levy@lpnhe.in2p3.fr', 'ariel.matalon@lpnhe.in2p3.fr', 'thomas.montandon@apc.in2p3.fr', 'santoine@ipgp.fr', 'baptiste.faure@cea.fr', 'roquebernard@ipgp.fr', 'genot@ipgp.fr', 'louise.mousset@apc.in2p3.fr', 'catherine.nguyen@apc.in2p3.fr', 'theodoros.papanikolaou@apc.in2p3.fr', 'valentine@lefils.net', 'sturtz@ipgp.fr', 'toubiana@apc.in2p3.fr', 'guibourdenche@ipgp.fr', 'thibault.vieu@apc.in2p3.fr', 'moarefvand@ipgp.fr', 'julianna.stermer@lpnhe.in2p3.fr', 'giunti@apc.in2p3.fr', 'chenjie@ipgp.fr', 'liudeze@ipgp.fr', 'tian@ipgp.fr', 'metcalfe@ipgp.fr', 'falcin@ipgp.fr', 'benatre@ipgp.fr ', 'guillaume.stankowiak@apc.in2p3.fr', 'cordrie@ipgp.fr', 'manon.dalaison@gmail.com', 'poulain@ipgp.fr ', 'georgios.papadopoulos@lpnhe.in2p3.fr', 'chao@geologie.ens.fr');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
			    {
					$status = 'elder';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}

			////////////////////////////
			// STEP'UP administration //
			////////////////////////////

			$email = array('yannick.giraud-heraud@apc.univ-paris-diderot.fr', 'tonazzo@in2p3.fr', 'irena.nikolic-audit@lpnhe.in2p3.fr', 'girault.frederic.fg@gmail.com', 'lacassin@ipgp.fr', 'coleiro@apc.in2p3.fr', 'balland@lpnhe.in2p3.fr', 'Helene.Lyon-Caen@ens.fr', 'narteau@ipgp.fr', 'alissa.marteau@univ-paris-diderot.fr', 'cannat@ipgp.fr', 'isabelle.grenier@cea.fr', 'sophie.violette@ens.fr');

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			foreach($email as $e)
			{
				$sql = "select * from allowed_users where email = '$e'";
				$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0)
				{
					$status = 'management';
					$query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
					$query->execute(array('email' => $e, 'status' => $status));
					echo $e . ' is now allowed to create an account.</br>';
				}
				else
				{
					echo $e . ' is already allowed to create an account.</br>';
				}
			}
			
		}
		else
		{
			echo '<strong>Access denied.</strong>';
		}
	}
	else
	{
		echo '<strong>Access denied.</strong>';
	}
?>