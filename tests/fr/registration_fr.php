<?php
	//namespace Phppot;
	//use \Phppot\Member;

	if (isset($_POST["register-user"]))
	{
        include_once 'DBConnect.php';

        $valid = true;
        $errorMessage = array();
        foreach ($_POST as $key => $value)
        {
            if (empty($_POST[$key]))
            {
                $valid = false;
            }
        }

	    $email = $_POST['userEmail'];
	    $first_name = $_POST['firstName'];
	    $last_name = $_POST['lastName'];
	    $password = $_POST['password'];
	    $password2 = $_POST['password2'];

	    $database = new DBConnect();
	    $db = $database->openConnection();
        
        if($valid == true)
        {
            // Password matching validation
            if ($password != $password2)
            {
                $errorMessage[] = 'Les mots de passe doivent être identiques.';
            }

            // Email Validation
            $checkEmail = true;
            if (! isset($error_message))
               {
                $email = $_POST['userEmail'];

                if (filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    list($userEmail, $mailDomain) = explode("@", $email); 
                    if (!checkdnsrr($mailDomain, "MX"))
                    {
                        $checkEmail = false;
                    }
                }
                else
                {
                    $checkEmail = false;
                }
            }

            if ($checkEmail == false)
            {
                $errorMessage[] = "L'adresse e-mail est invalide.";
            }
        }
        else
        {
            $errorMessage[] = "Tous les champs sont requis.";
        }

        if (empty($errorMessage))
        {
			$sql = "select * from registered_users where email = (:email)";
			$query = $db->prepare($sql);
			$user = $query->execute(array('email' => $email));

			$result = $query->fetchAll(PDO::FETCH_ASSOC);

		    if (count($result) == 1)
		    {
		    	$errorMessage[] = "L'utilisateur existe déjà.";
		    }
		    else
		    {
				$sql = "select * FROM allowed_users WHERE (email)=(:email)";
				$query = $db->prepare($sql);
				$user = $query->execute(array('email' => $email));

				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!count($result) == 1)
				{
					$errorMessage[] = "Vous n'êtes pas autorité à vous enregistrer. Si vous pensez qu'il s'agit d'une erreur, veuillez nous contacter.";
				}

				if (empty($errorMessage))
				{
					$sql = "SELECT status FROM allowed_users WHERE (email) = (:email)";
					$query = $db->prepare($sql);
					$user = $query->execute(array('email' => $email));
					$result = $query->fetchAll(PDO::FETCH_ASSOC);
					$status = $result[0]['status'];

					try
					{
			            $salt = '-i&[FeVR/8h8w;mdaQG73haHc")#^!';
						$passwordHash = crypt($password, $salt);
						$sql = "INSERT INTO registered_users (first_name, last_name, email, password, status) VALUES (:first_name, :last_name, :email, :password, :status)";
						$query = $db->prepare($sql);
						$query->execute(array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'password' => $passwordHash, 'status' => $status));

						$database->closeConnection();

	                    $to = $email;
                        $subject = "Inscription CDD";
                        $mailMessage = "Bienvenue au CDD 2020.\r\n\r\nVotre inscription a bien été prise en compte. Vous pouvez dès maintenant vous connecter et soumettre un résumé.\r\n\r\nMerci pour l'intérêt que vous portez pour cet événement,\r\nL'équipe Web du CDD 2020.";
                        $header = "From:noreply@cdd2020.com";
                        $retval = mail ($to, $subject, $mailMessage, $header);

						header('location: index.php?page=login&lang=fr');
					}
					catch(PDOException $e)
					{
						echo "Il y a un problème de connexion à la base de données : " . $e->getMessage();
					}
				}
			}
		}
	
    }
?>

<form id="registration_form" action="" method="post">

    <?php
        if (! empty($errorMessage) && is_array($errorMessage))
        {
    	?>
            <div class="error-message">
	            <?php 
                    foreach($errorMessage as $message) {
                        echo "<strong>" . $message . "</strong><br/>";
                    }
                ?>
            </div>
    	<?php
        }
    ?>
	<div class="field">
		<label for="login">Adresse e-mail :</label>
		<input type="text" name="userEmail" id="userEmail" required/>
	</div>
	<div class="field">
		<label for="login">Prénom :</label>
		<input type="text" name="firstName" id="firstName" required/>
	</div>
	<div class="field">
		<label for="login">Nom de famille :</label>
		<input type="text" name="lastName" id="lastName" required/>
	</div>
	<div class="field">
		<label for="password">Mot de passe :</label>
		<input type="password" name="password" id="password" required/>
	</div>
	<div class="field">
		<label for="password">Confirmer le mot de passe :</label>
		<input type="password" name="password2" id="password2" required/>
	</div>
	<input type="submit" name="register-user" id="Register" value="S'enregistrer"/>
</form>
