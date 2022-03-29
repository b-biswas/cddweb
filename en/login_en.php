<?php
	if (isset($_POST["submit"]))
	{
	    include_once 'DBConnect.php';
	    
	    $email = $_POST['email'];
	    $password = $_POST['password'];
	    $database = new dbConnect();

	    $db = $database->openConnection();
	    $sql = "select * from registered_users where email = ?";
	    $query = $db->prepare($sql);
	    $user = $query->execute(array($email));

		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$nb = count($result);

		if ($nb > 1)
		{
			$errorMessage[] = "There is a problem your your account. Please contact us.";
		}

	    else if ($nb == 1)
	    {
		    $id = $result[0]['id'];
		    $first_name = $result[0]['first_name'];
		    $last_name = $result[0]['last_name'];
		    $email = $result[0]['email'];
		    $passwordHashDB = $result[0]['password'];
		    $status = $result[0]['status'];
		    $passwordHash = $result[0]['password'];

		    if (password_verify($password, $passwordHash))
		    {
			    $_SESSION['id'] = $id;
			    $_SESSION['first_name'] = $first_name;
			    $_SESSION['last_name'] = $last_name;
			    $_SESSION['email'] = $email;
			    $_SESSION['status'] = $status;

			    $database->closeConnection();

			    header('location: index.php');	    	
		    }
		    else
		    {
		    	$errorMessage[] = "Incorrect password.";
		    }
		}
		else
		{
			$errorMessage[] = "Unknown email address.";
		}
	}
?>

<h2 class="major">Sign in</h2>

<form id="login_form" action="" method="post">


    <?php
        if (! empty($errorMessage) && is_array($errorMessage))
        {
    ?>
            <div class="error-message">
	            <?php 
                    foreach($errorMessage as $message)
                    {
                        echo "<strong>" . $message . "</strong><br/>";
                    }
                ?>
            </div>
    <?php
        }
    ?>

	<div class="field">
		<label for="login">Email:</label>
		<input type="text" name="email" id="email" required/>
	</div></br>
	<div class="field">
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required/>
	</div></br>
	<input type="submit" name="submit" value="Login"/>
</form>
