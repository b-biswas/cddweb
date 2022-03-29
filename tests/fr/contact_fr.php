<h2 class="major">Contact</h2>

<?php

    $sendToEmail = array('foreign' => 'cdd2020.foreign@ipgp.fr', 'job' => 'mathilde.espinasse@cea.fr,sylvain.breton@cea.fr', 'program' => 'cdd2020.program@ipgp.fr', 'web' => 'cdd2020.web@ipgp.fr', 'coordination' => "cdd2020.coordination@ipgp.fr");

    $sendToButton = array('foreign' => 'Foreign students', 'job' => 'Job day', 'program' => 'Program', 'web' => 'Web', 'coordination' => 'Coordination');

	$errorMessage = array();
	if (isset($_POST['send-mail']) && $_POST['receiver'] !== 'all')
	{
        $email = $_POST['userEmail'];
        $to = $sendToEmail[$_POST['receiver']];
        $subject = "New message from " . $email;
        $message .= $_POST['mail'];
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
           $errorMessage[] = "le message a bien été envoyé.";
        }
        else
        {
           $errorMessage[] = "Le message n'a pas été envoyé.";
        }
    }

?>

Ci-dessous se trouve un formulaire pour nous contacter. Veuillez choisir le destinataire en fonction de votre demande:
<ul>
	<li>Si vous êtes un étudiant étranger et voulez nous rejoindre, choisissez <strong>Foreign student</strong></li>
	<li>Si vous travaillez dans les domaines académique ou industriel et voulez participer à la journée emploi, choisissez <strong>Job day</strong> </li>
	<li>Si vous souhaitez participer d'une autre manière, choisissez <strong>Program</strong></li>
	<li>Si vous rencontrez un problème sur ce site ou êtes un membre de STEP'UP et ne pouvez pas vous inscrire, choisissez <strong>Web</strong> </li>
</ul>

<?php
	if ($_SESSION['status'] == "admin" || $_SESSION['status'] == 'communication')
	{
		?>
		<p>
			Si vous êtes dans l'équipe <strong>Communication</strong>, vous avez accès à une option supplémentaire : « Tous les membres enregistrés ». Cela vous permet d'envoyer un message à tous les utilisateurs ayant créé un compte sur ce site (y compris les utilisateurs extérieurs à STEP'UP).
		</p>
		<?php
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
	</div>
	<div class="select">
		<label>Destinataire :</label>
		<select name="receiver">
			<option></option>
			<?php
				foreach ($sendToButton as $key => $value)
				{
					echo '<option value='.$key.'>'.$value.'</option>';
				}
				if ($_SESSION['status'] == "admin" || $_SESSION['status'] == 'communication')
				{
					echo '<option value="all">Tous les membres enregistrés</option>';
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