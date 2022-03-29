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
                $errorMessage[] = 'Passwörter müssen übereinstimmen.';
            }

            // Email validation
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
                $errorMessage[] = "Ungültige Email-Adresse.";
            }
        }
        else
        {
            $errorMessage[] = "Sie müssen alle Felder korrekt ausfüllen.";
        }

        if (empty($errorMessage))
        {
			$sql = "select * from registered_users where email = (:email)";
			$query = $db->prepare($sql);
			$user = $query->execute(array('email' => $email));

			$result = $query->fetchAll(PDO::FETCH_ASSOC);

		    if (count($result) == 1)
		    {
		    	$errorMessage[] = "Dieser Nutzer existiert bereits.";
		    }
		    else
		    {
				$sql = "select * FROM allowed_users WHERE (email)=(:email)";
				$query = $db->prepare($sql);
				$user = $query->execute(array('email' => $email));

				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!count($result) == 1)
				{
					$errorMessage[] = "Ihnen wird es nicht gestattet sich zu registrieren. Falls Sie denken, es handelt sich um einen Fehler dann kontaktieren Sie uns bitte.";
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
                        $subject = "CDD registration";
                        $mailMessage = "Welcome to the CDD 2020.\r\n\r\nYour registration has been taken into account. You can now sign in and submit an abstract.\r\n\r\nThank you for your interest,\r\nThe CDD 2020 Web team.";
                        $header = "From:noreply@cdd2020.com";
                        $retval = mail ($to, $subject, $mailMessage, $header);

						header('location: index.php?page=login&lang=de');
					}
					catch(PDOException $e)
					{
						echo "Es gibt ein Problem mit Ihrer Verbindung: " . $e->getMessage();
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
		<label for="login">Email address:</label>
		<input type="text" name="userEmail" id="userEmail" required/>
	</div>
	<div class="field">
		<label for="login">First name:</label>
		<input type="text" name="firstName" id="firstName" required/>
	</div>
	<div class="field">
		<label for="login">Last name:</label>
		<input type="text" name="lastName" id="lastName" required/>
	</div>
	<div class="field">
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required/>
	</div>
	<div class="field">
		<label for="password">Confirm password:</label>
		<input type="password" name="password2" id="password2" required/>
	</div>
	<input type="submit" name="register-user" id="Register" value="Register"/>
</form>
