<?php
		$email = $_SESSION['email'];
		$first_name = $_SESSION['first_name'];
		$last_name = $_SESSION['last_name'];

		$nameMessage = array();
		$emailMessage = array();
		$passwordMessage = array();

		include_once 'DBConnect.php';
		$database = new DBConnect();
		$db = $database->openConnection();

		// Change name
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change-name"]))
		{
			$new_first_name = $_POST['first_name'];
			$new_last_name = $_POST['last_name'];

			// Change in DB
			$sql = "UPDATE registered_users SET first_name = '".$new_first_name."', last_name = '".$new_last_name."' WHERE email = '". $email."'";
			$query = $db->prepare($sql);
			$exec = $query->execute();

			// Change in session
			$_SESSION['first_name'] = $new_first_name;
			$_SESSION['last_name'] = $new_last_name;
			header("Refresh:0");
		}

		// Change email address
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change-email"]))
		{
			$new_email = $_POST['email'];

			// Change in DB
			$sql = "UPDATE registered_users SET email = ? WHERE email = '".$email."'";
			$query = $db->prepare($sql);
			$exec = $query->execute(array($new_email));

			// Change in session
			$_SESSION['email'] = $new_email;
			header("Refresh:0");
		}

		// Change password
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change-password"]))
		{
			$oldpassword = $_POST['oldpassword'];
			$new_password = $_POST['password'];
			$new_password2 = $_POST['password2'];

			// Check old password
			$sql = "select * from registered_users where (email) = (:email)";
		    $query = $db->prepare($sql);
		    $user = $query->execute(array('email' => $email));
		    $result = $query->fetchAll(PDO::FETCH_ASSOC);
		    $passwordHashDB = $result[0]['password'];

	    	if (password_verify($oldpassword, $passwordHashDB))
	    	{

				// Check new password and change it in the DB
				if ($new_password == $new_password2)
				{
					$new_passwordHash = password_hash($new_password, PASSWORD_DEFAULT);

					if (strlen($new_password) > 7)
					{

						try
						{
							$sql = "UPDATE registered_users SET password = '" . $new_passwordHash . "' WHERE email = '" . $email . "'";
							$query = $db->prepare($sql);
							$exec = $query->execute();
							$passwordMessage[] = "Votre mot de passe a été changé avec succès.";
						}
						catch(PDOException $e)
						{
							$passwordMessage[] = "Un problème s'est produit lors du changement de mot de passe.";
						}
					}
				}
				else
				{
					$passwordMessage[] = "Les nouveaux mots de passe doivent être identiques.";
				}
	    	}
	    	else
	    	{
	    		$passwordMessage[] = "Mot de passe incorrect.";
	    	}

		}

?>

<h2 class="major">Profil</h2>

<h3 class="major">Informations personnelles</h3>

<ul>
	<?php
		echo "<li><strong>Prénom : </strong>" . $first_name . "</li>";
		echo "<li><strong>Nom de famille : </strong>" . $last_name . "</li>";
		echo "<li><strong>Adresse e-mail : </strong>" . $email . "</li>";
	?>
</ul>

<h3 class="major">Modifier vos informations personnelles</h3>

<h4>Modifier votre nom</h4>

<form id="change_name" action="" method="post">

    <?php
        if (! empty($nameMessage) && is_array($nameMessage))
        {
    	?>
            <div class="error-message">
	            <?php 
                    foreach($nameMessage as $message) {
                        echo "<strong>" . $message . "</strong><br/>";
                    }
                ?>
            </div>
    	<?php
        }
    ?>
	<div class="field">
		<label for="fname">Prénom :</label>
		<input type="text" name="first_name" id="first_name" required/>
	</div>
	</br>
	<div class="field">
		<label for="lname">Nom de famille :</label>
		<input type="text" name="last_name" id="last_name" required/>
	</div>
	</br>
	<input type="submit" name="change-name" id="change-name" value="Modifier le nom"/>
</form>


<h4>Modifier votre adresse e-mail</h4>

<form id="change_email" action="" method="post">

    <?php
        if (! empty($emailMessage) && is_array($emailMessage))
        {
    	?>
            <div class="error-message">
	            <?php 
                    foreach($emailMessage as $message) {
                        echo "<strong>" . $message . "</strong><br/>";
                    }
                ?>
            </div>
    	<?php
        }
    ?>
	<div class="field">
		<label for="login">Nouvelle adresse e-mail:</label>
		<input type="text" name="email" id="email" required/>
	</div>
	</br>
	<input type="submit" name="change-email" id="change-email" value="Modifier l'e-mail"/>
</form>


<h4>Modifier votre mot de passe</h4>

<form id="change_password" action="" method="post">

    <?php
        if (! empty($passwordMessage) && is_array($passwordMessage))
        {
    	?>
            <div class="error-message">
	            <?php 
                    foreach($passwordMessage as $message) {
                        echo "<strong>" . $message . "</strong><br/>";
                    }
                ?>
            </div>
    	<?php
        }
    ?>
	<div class="field">
		<label for="password">Mot de passe actuel :</label>
		<input type="password" name="oldpassword" id="oldpassword" required/>
	</div>
	</br>
	<div class="field">
		<label for="password">Nouveau mot de passe :</label>
		<input type="password" name="password" id="password" required/>
	</div>
	</br>
	<div class="field">
		<label for="password">Confirer le nouveau mot de passe :</label>
		<input type="password" name="password2" id="password2" required/>
	</div></br>
	<input type="submit" name="change-password" id="change-password" value="Modifier le mot de passe"/>
</form>
