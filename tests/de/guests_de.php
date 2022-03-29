<?php
	if(array_key_exists('status', $_SESSION))
	{
		if($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'job' || $_SESSION['status'] == 'program' || $_SESSION['status'] == 'program')
		{


			if (! empty($_POST["allowed-user"]))
			{
	    		include_once 'DBConnect.php';
			    $database = new dbConnect();

			    $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
	    
			    $db = $database->openConnection();
			    $sql = "select * from allowed_users where email = ?";
			    $query = $db->prepare($sql);
			    $user = $query->execute(array($email));
				$result = $query->fetchAll(PDO::FETCH_ASSOC);

			    if (count($result) == 0)
		    	{
		    		if (!empty($_POST["status"]))
		    		{
		    			$status = $_POST['status'];
			            $query = $db->prepare("INSERT INTO allowed_users (email, status) VALUES (:email, :status)");
			            $query->execute(array('email' => $email, 'status' => $status));		    			
		    		}
		    		else
		    		{
			            $query = $db->prepare("INSERT INTO allowed_users (email) VALUES (:email)");
			            $query->execute(array('email' => $email));
		    		}

	                $message[] = "<strong>" . $email . "</strong> now has the permission to register.";

					$to = $email;
					$subject = "CDD registration";
					$mailMessage = "Welcome to the CDD 2020.\r\n\r\nYour email address can now be used from registration on the website https://cdd.ens.fr.\r\n\r\nThank you for your interest,\r\nThe CDD 2020 Web team.";
					$header = "From:noreply@cdd2020.com";

					$retval = mail ($to, $subject, $mailMessage, $header);
					if($retval == true)
					{
						$message[] = "An email has been sent to this address.";
					}
					else
					{
						$message[] = "No email could be sent to this address.";
					}
		        }
		        else
		        {
		            $message[] = "User already allowed.";
		        }
		    }

		    ?>
			<form id="login_form" action="" method="post">


			    <?php
			        if (! empty($message) && is_array($message))
			        {
			    ?>
			            <div class="error-message">
				            <?php 
			                    foreach($message as $msg) {
			                        echo "<strong>" . $msg . "</strong><br/>";
			                    }
			                ?>
			            </div>
			    <?php
			        }
			    ?>

		    <h2 class="major">Guests</h2>

		    <p>Dieses Formular kann nur von folgenden Mitgliedern gesehen werden <strong>Programm</strong>, <strong>Ausländische Studenten</strong> und <strong>Job</strong> teams. Um sich zu registrieren müssen die Nutzer eine für eine Registrierung zulässige Email haben. Falls Sie Wissenschaftler kennen, die an der Teilnahme interessiert sein könnten, füllen Sie bitte dieses Formular mit deren Email Adresse aus um teilnehmen zu können. </p>
		    
				<div class="field">
					<label for="login">Email address:</label>
					<input type="text" name="email" id="email" required/>
				</div>

				<?php
					if ($_SESSION['status'] == 'admin')
					{
						?>
						<div class="select">
							<label>Status:</label>
							<select name="status">
								<option></option>
								<option value="Gast">Guest</option>
								<option value="Management">STEP'UP: Administration</option>
							    <option value="Ältere">STEP'UP: D2, D3</option>
							    <option value="Koordination">STEP'UP: D1, Coordination</option>
							    <option value="Programm">STEP'UP: D1, Program</option>
							    <option value="Kommunikation">STEP'UP: D1, Communication</option>
							    <option value="Ausländisch">STEP'UP: D1, Foreign</option>
							    <option value="Job">STEP'UP: D1, Job</option>
							    <option value="Logistik">STEP'UP: D1, Logistics</option>
							    <option value="Administrator">STEP'UP: D1, Web</option>
							</select>
						</div> </br>
						<?php
					}
				?>

				<input type="submit" name="allowed-user" value="Berechtigung hinzufügen"/>
			</form>





		<?php

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