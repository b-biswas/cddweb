<h2 class="major">Contact</h2>

<?php
if(!empty($_SESSION))
    {
    #$sendToEmail = array('foreign' => 'bouih@ipgp.fr,cdd_foreignstudents_2020@googlegroups.com', 'job' => 'mathilde.espinasse@cea.fr,sylvain.breton@cea.fr', 'program' => 'cdd_programmeeting_2020@googlegroups.com', 'logistics' => "cdd_logistics_2020@googlegroups.com", 'communication' => 'lmaderer@apc.in2p3.fr,farge@ipgp.fr,sandeepthapa.geo@gmail.com,bohidar.soumya26@gmail.com,mailsouradeep@gmail.com,quocviet.nguyen@lpnhe.in2p3.fr', 'web' => 'gatelet@apc.in2p3.fr,teyssendier@ipgp.fr,leo.petit@ens.fr,sahmedma@lpnhe.in2p3.fr,laag@ipgp.fr,demasy@ipgp.fr');

    #$sendToButton = array('foreign' => 'Foreign students', 'job' => 'Job day', 'program' => 'Program', 'logistics' => 'Logistics', 'communication' => 'Communication', 'web' => 'Web');

    $sendToEmail = array('web' => 'gatelet@apc.in2p3.fr')#,teyssendier@ipgp.fr,leo.petit@ens.fr,sahmedma@lpnhe.in2p3.fr,laag@ipgp.fr,demasy@ipgp.fr');

    $sendToButton = array('web' => 'Web');

	$errorMessage = array();
	if (isset($_POST['send-mail']) && $_POST['receiver'] !== 'all')
	{
        $email = $_POST['userEmail'];
        $to = $sendToEmail[$_POST['receiver']];
        $subject = "New message from " . $email;
        $message .= htmlspecialchars(stripslashes(utf8_decode($_POST['mail'])));
        $header = "From:cdd.webmail@cdd2020.com";// \r\n";

        $retval = mail ($to, $subject, $message, $header);
        if($retval == true)
        {
           $errorMessage[] = "Le message a bien été envoyé.";
        }
        else
        {
           $errorMessage[] = "Le message n'a pas été envoyé.";
        }
	}	
    elseif (isset($_POST['send-mail']) && $_POST['receiver'] == 'all')
    {
     	include_once 'DBConnect.php';
       	$database = new DBConnect();
       	$db = $database->openConnection();

       	$sql = "SELECT email FROM registered_users";
       	$query = $db->prepare($sql);
       	$exec = $query->execute();
       	$result = $query->fetchAll(PDO::FETCH_ASSOC);
       	$nb = count($result);

       	$emailList = array();
       	for ($i = 0; $i < $nb; $i++)
       	{
       		$emailList[] = $result[$i]['email'];
       	}
       	$to = implode(',', $emailList);
	    $subject = "CDD News";
	    $message .= $_POST['mail'];
	    $header = "From:cdd.webmail@cdd2020.com";

        $retval = mail ($to, $subject, $message, $header);
        if($retval == true)
        {
           $errorMessage[] = "Le message a bien été envoyé.";
        }
        else
        {
           $errorMessage[] = "Le message n'a pas été envoyé.";
        }
    }

?>

<div>Ci-dessous se trouve un formulaire pour nous contacter. Veuillez choisir le destinataire en fonction de votre demande :</div>
<ul>
	<li>Si vous êtes un étudiant étranger et voulez nous rejoindre, choisissez <strong>Foreign student</strong></li>
	<li>Si vous travaillez dans les domaines académique ou industriel et voulez participer à la journée emploi, choisissez <strong>Job day</strong> </li>
	<li>Si vous souhaitez participer d'une autre manière, choisissez <strong>Program</strong></li>
	<li>Si vous êtes étudiant à l'École Doctorale STEP'UP et que vous ne pouvez pas participer au congrès, choisissez <strong>Program</strong></li>
    <li>Si vous souhaitez transmettre un message à tous les participants, veuillez choisir <strong>Communication</strong></li>
	<li>Si vous rencontrez un problème sur ce site ou êtes un membre de STEP'UP et ne pouvez pas vous inscrire, choisissez <strong>Web</strong> </li>
</ul>

<?php
    if(!empty($_SESSION))
    {
    	if ($_SESSION['status'] == "admin" || $_SESSION['status'] == 'communication')
    	{
    		?>
    		<p>
    			Si vous êtes dans l'équipe <strong>Communication</strong>, vous avez accès à une option supplémentaire : « Tous les membres enregistrés ». Cela vous permet d'envoyer un message à tous les utilisateurs ayant créé un compte sur ce site (y compris les utilisateurs extérieurs à STEP'UP).
    		</p>
    		<?php
    	}
    }
?>

<form id="contact_form" action="" method="post">

    <?php
        if (! empty($errorMessage) && is_array($errorMessage))
        {
		    ?>
            <div class="error-message">
	            <?php 
                    foreach($errorMessage as $message)
                    {
                        echo "<strong>" . $message . "</strong></br>";
                    }
                ?>
            </div>
		    <?php
        }
    ?>

	<div class="field">
		<label for="login">Votre adresse e-mail :</label>
		<input type="text" name="userEmail" id="userEmail" required/>
	</div></br>
	<div class="select">
		<label>Destinataire :</label>
		<select name="receiver">
			<option></option>
			<?php
				foreach ($sendToButton as $key => $value)
				{
					echo '<option value='.$key.'>'.$value.'</option>';
				}
                if(!empty($_SESSION))
                {
    				if ($_SESSION['status'] == "admin" || $_SESSION['status'] == 'communication')
    				{
    					echo '<option value="all">Tous les membres enregistrés</option>';
    				}
                }
			?>
		</select>
	</div>
	<div class="field"></br>
		<label>Votre message :</label>
		<textarea name="mail", rows="15" cols="30"></textarea>
	</div>
	</br>
	<input type="submit" name="send-mail" id="send-mail" value="Envoyer"/>
</form>

    <?php
    }

else{
  echo 'Access denied.'
  ?>
}
