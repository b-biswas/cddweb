<?php

	if (array_key_exists('status', $_SESSION))
	{
		if($_SESSION['status'] == 'admin')
		{


			$passwordMessage = array();
			$message = array();
			?>
			<h1>Change the password of an user</h1>

			<?php
				if (isset($_POST['reset-password']))
				{
					include_once 'DBConnect.php';
					$database = new dbConnect();
					$db = $database->openConnection();

					// Test here if the email exists in the database
					
					if (empty($passwordMessage))
					{
						$email = $_POST['email'];
						$password = $_POST['password'];

						$passwordHash = password_hash($password, PASSWORD_DEFAULT);

						try
						{
							$sql = "UPDATE registered_users SET password = '" . $passwordHash . "' WHERE email = '" . $email . "'";
							$query = $db->prepare($sql);
							$exec = $query->execute();
							$passwordMessage[] = "The password has been successfully changed.";

						}
						catch (PDOException $e)
						{
							$passwordMessage[] = "The password couldn't be changed: " . $e->getMessage(	);
						}

						// If the update worked, send an email to the user

						$to = $email;
						$subject = "CDD new password";
						$mailMessage = htmlspecialchars(stripslashes(utf8_decode("Your password has been changed. It is now: " . $password . " \r\n\r\n You can now log in and change your password in the Profile section.\r\n\r\nBest regards,\r\nThe CDD 2020 Web team.")));
                        $header = "From:noreply@cdd2020.com";
                        $retval = mail($to, $subject, $mailMessage, $header);
					}
				}
			?>


			<form id="reset-password-form" action="" method="post">

			    <?php
			        if (! empty($passwordMessage) && is_array($passwordMessage))
			        {
			    	?>
			        <div class="error-message">
				        <?php 
			                foreach($passwordMessage as $msg)
			                {
			                    echo "<strong>" . $msg . "</strong><br/>";
			                }
			        }
			            ?>
		        </div>
				<div class="field">
					<label for="table">User email:</label>
					<input type="text" name="email" id="email" required/>
				</div>
				<div class="field">
					<label for="table">New password:</label>
					<input type="text" name="password" id="password" required/>
				</div> </br>
				<input type="submit" name="reset-password" value="Reset"/>
			</form>



			<h1>Database management</h1>

			<h2>Set tables up</h2>

			<ul>
				<li><a href="admin/create_table.php">Create tables</a></li> Creates all the required tables of the database before the first use of the server (modify 'admin/create_table.php' if you want a template to add a new table).
				<li><a href="admin/step_up_members.php">Allow STEP'UP members to register</a></li> When the tables are created, use this script to add a large amount of email addresses allowed to be used for registration. If you just have to add a few addresses, use the "Guests" section which is more convenient or use the form below.
			</ul>

			<h2>MySQL queries</h2>

			<p>To get a better control on the database, you can use SQL queries.</p>

			<h3>Examples of queries</h3>

			<p>If you're not familiar with MySQL or have a doubt for the syntax of a query, you can read these examples.</p>

			<ul>
				<li><strong>Add an element in a table (in this example, we reproduce the query performed in the "Guests" section):</strong></li>INSERT INTO allowed_users (email, status) VALUES ('example@example.com', 'meeting')
				<li><strong>Delete a table:</strong></li> DROP TABLE allowed_users
				<li><strong>If the user with the email example@example.com made a mistake in the title of their abstract:</strong></li>UPDATE uploaded_abstracts SET title='Example of new title' WHERE email='example@example.com'
				<li><strong>Delete an element in a table:</strong></li>DELETE FROM uploaded_abstract WHERE id=41
			</ul>

			<h3>Queries form</h3>

			<p>This form will let you perform any SQL query.</p>

			<?php
			if (isset($_POST['insert-query']))
			{

			    include_once 'DBConnect.php';
	    
			    $email = $_SESSION['email'];
			    $password = $_POST['password'];

			    $database = new dbConnect();
			    $db = $database->openConnection();

			    $sql = "select * from registered_users where email = (:email)";
			    $query = $db->prepare($sql);
			    $user = $query->execute(array('email' => $email));
				$result = $query->fetchAll(PDO::FETCH_ASSOC);

				$passwordHashDB = $result[0]['password'];

				if (password_verify($password, $passwordHashDB))
				{
					$sql_input = htmlspecialchars(stripslashes($_POST['sql-input']));
					try
					{
						$query_input = $db->prepare($sql_input);
						$query_input->execute();
					    $message[] = 'The query succeeded. See the result below.';
					}
					catch (PDOException $e)
					{
					    $message[] = 'The query failed: ' . $e->getMessage();
					}
				}
				else
				{
					$message[] = 'The password is incorrect.';
				}
			}
			?>

			<form id="insert-form" action="" method="post">

			    <?php
			        if (! empty($message) && is_array($message))
			        {
			    	?>
			        <div class="error-message">
				        <?php 
			                foreach($message as $msg)
			                {
			                    echo "<strong>" . $msg . "</strong><br/>";
			                }
			        }
			            ?>

				<div class="field">
					<label for="table">Query:</label>
					<input type="text" name="sql-input" id="sql-input" required/>
				</div>
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" required/>
				</div> </br>
				<input type="submit" name="insert-query" value="Send query"/>
			</form> </br>

	   		<?php

	   		if (isset($_POST['insert-query']))
	   		{
	   			if (password_verify($password, $passwordHashDB))
	   			{
					echo "<strong>Your query is:</strong></br>";
					echo $sql_input . "</br>";
					try
					{
						echo "<strong>Result:</strong></br>";
				    	$qresult = $query_input->fetchAll(PDO::FETCH_ASSOC);
						echo "<ul>";
						foreach($qresult as $col)
						{
							echo "<li>";
							print_r($col);
							echo "</li>";
						}
						echo "</ul>";
					}
					catch (PDOException $e)
					{
					    $message[] = 'No result to print.';
					}
	   			}
	   		}

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