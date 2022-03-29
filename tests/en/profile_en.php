<?php
	if ($_SESSION['status'] == 'admin')
	{

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
			$sql = "UPDATE registered_users SET (first_name, last_name) = (:first_name, :last_name) WHERE email = $S_SESSION(['email'])";
			$query = $db->prepare($sql);
			$exec = $query->execute(array('first_name' => $new_first_name, 'last_name' => $new_last_name));

			// Change in session
			$_SESSION['first_name'] = $new_first_name;
			$_SESSION['last_name'] = $new_last_name;
		}

		// Change email address
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change-email"]))
		{
			$new_email = $_POST['email'];

			// Change in DB
			$sql = "UPDATE registered_users SET (email) = (:email) WHERE email = $S_SESSION(['email'])";
			$query = $db->prepare($sql);
			$exec = $query->execute(array('email' => $new_email));

			// Change in session
			$_SESSION['email'] = $new_email;
		}

		// Change password
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change-password"]))
		{
			$oldpassword = $_POST['oldpassword'];
			$new_password = $_POST['password'];
			$new_password2 = $_POST['password2'];

			// Check old password
            //$salt = '-i&[FeVR/8h8w;mdaQG73haHc")#^!';
			//$passwordHash = crypt($oldpassword, $salt);

			//$passwordHash = password_hash($oldpassword, PASSWORD_DEFAULT)

			$sql = "select * from registered_users where (email) = (:email)";
		    $query = $db->prepare($sql);
		    $user = $query->execute(array('email' => $email));
		    $result = $query->fetchAll(PDO::FETCH_ASSOC);
		    $passwordHashDB = $result[0]['password'];

	    	//if ($passwordHash == $passwordHashDB)
	    	if (password_verify($oldpassword, $passwordHashDB))
	    	{

				// Check new password and cange in DB
				if ($new_password == $new_password2)
				{
					//$salt = '-i&[FeVR/8h8w;mdaQG73haHc")#^!';
					//$new_passwordHash = crypt($new_password, $salt);
					$new_passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
					try
					{				
						//$sql = "UPDATE registered_users SET (password) = (:password) WHERE email = '" . $email . "'";
						$sql = "UPDATE registered_users SET password = '" . $new_passwordHash . "' WHERE email = '" . $email . "'";
						$query = $db->prepare($sql);
						//$exec = $query->execute(array('password' => $new_passwordHash, 'email' => $email));
						//$exec = $query->execute(array('password' => $new_passwordHash));
						$exec = $query->execute();
						$passwordMessage[] = "Your password has been successfully changed.";
					}
					catch(PDOException $e)
					{
						$passwordMessage[] = "There is an issue: " . $e->getMessage();
					}
				}
				else
				{
					$passwordMessage[] = "Passwords should the same.";
				}
	    	}
	    	else
	    	{
	    		$passwordMessage[] = "Incorrect password.";
	    	}

		}


	}
?>

<h2 class="major">Profile</h2>

<h3 class="major">Personal data</h3>

<ul>
	<?php
		echo "<li><strong>First name: </strong>" . $first_name . "</li>";
		echo "<li><strong>Last name: </strong>" . $last_name . "</li>";
		echo "<li><strong>Email address: </strong>" . $email . "</li>";
	?>
</ul>

<h3 class="major">Change your personal data</h3>

<h4>Change your name</h4>

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
		<label for="fname">First name:</label>
		<input type="text" name="first_name" id="first_name" required/>
	</div>
	<div class="field">
		<label for="lname">Last name:</label>
		<input type="text" name="last_name" id="last_name" required/>
	</div>

	<input type="submit" name="change-name" id="change-name" value="Change names"/>
</form>


<h4>Change your email address</h4>

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
		<label for="login">New email address:</label>
		<input type="text" name="email" id="email" required/>
	</div>

	<input type="submit" name="change-email" id="change-email" value="Change email"/>
</form>


<h4>Change your password</h4>

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
		<label for="password">Current password:</label>
		<input type="password" name="oldpassword" id="oldpassword" required/>
	</div>
	<div class="field">
		<label for="password">New password:</label>
		<input type="password" name="password" id="password" required/>
	</div>
	<div class="field">
		<label for="password">Confirm new password:</label>
		<input type="password" name="password2" id="password2" required/>
	</div>
	<input type="submit" name="change-password" id="change-password" value="Change password"/>
</form>
