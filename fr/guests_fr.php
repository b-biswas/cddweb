<?php
	if(array_key_exists('status', $_SESSION))
	{
		if($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'job' || $_SESSION['status'] == 'program' || $_SESSION['status'] == 'foreign')
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

	                $message[] = "<strong>" . $email . "</strong> peut désormais s'inscrire.";

					$to = $email;
					$subject = "CDD registration";
					$mailMessage = htmlspecialchars(stripslashes(utf8_decode("Bienvenue au CDD 2020.\r\n\r\nVotre adresse e-mail peut désormais être utilisée pour vous inscrire sur le site https://cdd.ens.fr.\r\n\r\nMerci pour l'intérêt que vous portez pour cet événement,\r\nL'équipe web du CDD 2020.")));
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
		            $message[] = "Cet utilisateur a déjà la permission de s'inscrire.";
		        }
		    }

		    ?>

   		    <h2 class="major">Invités</h2>

		    <p>Ce formulaire ne peut être vu que par les membres des groupes <strong>program</strong>, <strong>foreign students</strong> et <strong>job day</strong>. Pour s'inscrire, les utilisateurs doivent avoir une adresse e-mail autorisée pour l'inscription. Si vous trouvez des chercheurs qui pourraient être interessés, vous pouvez renseigner leur adresse e-mail dans le champ ci-dessous pour leur permettre de nous rejoindre.</p>

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

				<div class="field">
					<label for="login">Adresse e-mail :</label>
					<input type="text" name="email" id="email" required/>
				</div>
				</br>
				<?php
					if ($_SESSION['status'] == 'admin')
					{
						?>
						<div class="select">
							<label>Statut :</label>
							<select name="status">
								<option></option>
								<option value="guest">Invité</option>
								<option value="management">STEP'UP: Administration</option>
							    <option value="elder">STEP'UP: D2, D3</option>
							    <option value="coordination">STEP'UP: D1, Coordination</option>
							    <option value="program">STEP'UP: D1, Program</option>
							    <option value="communication">STEP'UP: D1, Communication</option>
							    <option value="foreign">STEP'UP: D1, Foreign</option>
							    <option value="job">STEP'UP: D1, Job</option>
							    <option value="logistics">STEP'UP: D1, Logistics</option>
							    <option value="admin">STEP'UP: D1, Web</option>
							</select>
						</div> </br>
						<?php
					}
				?>

				<input type="submit" name="allowed-user" value="Ajouter la permission"/>
			</form>





		<?php

		}
		else
		{
			echo '<strong>Accès refusé.</strong>';
		}
	}
	else
	{
		echo '<strong>Accès refusé.</strong>';
	}
?>