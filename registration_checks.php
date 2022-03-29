<?php

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

	    $database = new dbConnect();
	    $db = $database->openConnection();
        
        if($valid == true)
        {
            // Password matching validation
            if ($password != $password2)
            {
                if(array_key_exists('lang', $_GET))
                {
                    if ($_GET['lang'] == 'fr')
                    {
                        $errorMessage[] = 'Les mots de passe doivent être identiques.';
                    }
                    elseif($_GET['lang'] == 'de')
                    {
                        $errorMessage[] = 'Passwords should be the same.';
                    }
                    else
                    {
                        $errorMessage[] = 'Passwords should be the same.';
                    }                        
                }
                else
                {
                    $errorMessage[] = 'Passwords should be the same.';
                }
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
                if(array_key_exists('lang', $_GET))
                {
                    if ($_GET['lang'] == 'fr')
                    {
                        $errorMessage[] = "L'adresse e-mail est invalide.";
                    }
                    elseif($_GET['lang'] == 'de')
                    {
                        $errorMessage[] = "Invalid email address.";
                    }
                    else
                    {
                        $errorMessage[] = "Invalid email address.";
                    }                        
                }
                else
                {
                    $errorMessage[] = "Invalid email address.";
                }
            }
        }
        else
        {
            $errorMessage[] = "All fields are required.";
        }

        if (empty($errorMessage))
        {
		    //$sql = "select * from registered_users where email = '$email'";

			$sql = "select * from registered_users where email = (:email)";
			$query = $db->prepare($sql);
			$user = $query->execute(array('email' => $email));

		    //$user = $db->query($sql);
			$result = $user->fetchAll(PDO::FETCH_ASSOC);

		    if (count($result) == 1)
		    {
		    	$errorMessage[] = "The user already exists.";
		    }
		    else
		    {
			    //$sql = "select * FROM allowed_users WHERE (email)=('$email')";
				$sql = "select * FROM allowed_users WHERE (email)=(:email)";
				$query = $db->prepare($sql);
				$user = $query->execute(array('email' => $email));

			    //$user = $db->query($sql);
				$result = $user->fetchAll(PDO::FETCH_ASSOC);
				if (!count($result) == 1)
				{
					$errorMessage[] = "You're not allowed to register. If you think it's an error, please contact us. ";
				}

				if (empty($errorMessage))
				{
					//$sql = "SELECT status FROM allowed_users WHERE email = '$email'";
					$sql = "SELECT status FROM allowed_users WHERE (email) = (:email)";
					$query = $db->prepare($sql);
					$user = $query->execute(array('email' => $email));
					//$user = $db->query($sql);
					$result = $user->fetchAll(PDO::FETCH_ASSOC);
					$status = $result[0]['status'];

					try
					{
						$options = array(['cost' => 12]);
			            $passwordHash = password_hash($password, PASSWORD_DEFAULT, $options);
						$sql = "INSERT INTO registered_users (first_name, last_name, email, password, status) VALUES (:first_name, :last_name, :email, :password, :status)";
						$query = $db->prepare($sql);
						$query->execute(array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'password' => $passwordHash, 'status' => $status));

						$database->closeConnection();

						if(array_key_exists('lang', $_GET))
						{
						   	header('location: index.php?page=login&lang='.$_GET['lang']);
						}
						else
						{
							header('location: index.php');
						}


					}
					catch(PDOException $e)
					{
						echo "There is some connection issue: " . $e->getMessage();
					}
				}
			}
		}
	
?>