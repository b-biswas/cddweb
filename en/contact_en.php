<h2 class="major">Contact</h2>

<?php
if(!empty($_SESSION))
    {

	#$sendToEmail = array('foreign' => 'bouih@ipgp.fr,cdd_foreignstudents_2020@googlegroups.com', 'job' => 'mathilde.espinasse@cea.fr,sylvain.breton@cea.fr', 'program' => 'cdd_programmeeting_2020@googlegroups.com', 'logistics' => "cdd_logistics_2020@googlegroups.com", 'communication' => 'lmaderer@apc.in2p3.fr,farge@ipgp.fr,sandeepthapa.geo@gmail.com,bohidar.soumya26@gmail.com,mailsouradeep@gmail.com,quocviet.nguyen@lpnhe.in2p3.fr', 'web' => 'gatelet@apc.in2p3.fr,teyssendier@ipgp.fr,leo.petit@ens.fr,sahmedma@lpnhe.in2p3.fr,laag@ipgp.fr,demasy@ipgp.fr');

	#$sendToButton = array('foreign' => 'Foreign students', 'job' => 'Job day', 'program' => 'Program', 'logistics' => 'Logistics', 'communication' => 'Communication', 'web' => 'Web');

    $sendToEmail = array('web' => 'gatelet@apc.in2p3.fr)'#,teyssendier@ipgp.fr,leo.petit@ens.fr,sahmedma@lpnhe.in2p3.fr,laag@ipgp.fr,demasy@ipgp.fr');

    $sendToButton = array('web' => 'Web');


	$errorMessage = array();
	if (isset($_POST['send-mail']) && $_POST['receiver'] !== 'all')
	{
	    $email = $_POST['userEmail'];
	    $to = $sendToEmail[$_POST['receiver']];
	    $subject = "New message from " . $email;
	    $message .= htmlspecialchars(stripslashes(utf8_decode($_POST['mail'])));
	    $header = "From:noreply@cdd2020.com";

        $retval = mail ($to, $subject, $message, $header);
        if($retval == true)
        {
           $errorMessage[] = "Message sent successfully.";
        }
        else
        {
           $errorMessage[] = "Message could not be sent.";
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
	    $header = "From:noreply@cdd2020.com";

        $retval = mail ($to, $subject, $message, $header);
        if($retval == true)
        {
           $errorMessage[] = "Message sent successfully.";
        }
        else
        {
           $errorMessage[] = "Message could not be sent.";
        }
    }

?>

Here is a form to contact us. Please, choose the receiver depending on your what you need:
<ul>
	<li>If you're a foreign student and want to join us, choose <strong>Foreign student</strong></li>
	<li>If you work in academia or industry and want to participate to the job day, please choose <strong>Job day</strong> </li>
	<li>If you want to participate in any other way, choose <strong>Program</strong></li>
	<li>If you're a student from the Doctoral School STEP'UP and you can't attend the congress, choose <strong>Program</strong></li>
	<li>If you have a message to send to all the participants, please choose <strong>Communication</strong></li>
	<li>If you encounter an issue on this website or if you're a STEP'UP member and can't register, choose <strong>Web</strong> </li>
</ul>

<?php
	if(!empty($_SESSION))
	{
		if ($_SESSION['status'] == "admin" || $_SESSION['status'] == 'communication')
		{
			?>
			<p>
				If you're in the <strong>Communication</strong> team, you have an additional option in this form: "All registered users". With this option, the message will be sent to all the users who created an account on this website (including those who are not related to STEP'UP).
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
		<label for="login">Your email address:</label>
		<input type="text" name="userEmail" id="userEmail" required/>
	</div></br>
	<div class="select">
		<label>Receiver:</label>
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
						echo '<option value="all">All registered members</option>';
					}
				}
			?>
		</select>
	</div>
	<div class="field"></br>
		<label>Your message:</label>
		<textarea name="mail", rows="15" cols="30"></textarea>
	</div>
	</br>
	<input type="submit" name="send-mail" id="send-mail" value="Send message"/>
</form>

    <?php
    }

else{
  echo 'Access denied.'
  ?>
}
