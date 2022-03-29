<?php

	if (array_key_exists('status', $_SESSION))
	{
		if($_SESSION['status'] == 'admin')
		{
			?>
			<h1>Database management</h1>

			<h2>Set tables up</h2>

			<ul>
				<li><a href="admin/create_table.php">Create tables</a></li> Creates all the required tables of the database before the first use of the server (modify 'admin/create_table.php' if you want a template to add a new table).
				<li><a href="admin/step_up_members.php">Allow STEP'UP members to register</a></li> When the tables are created, use this script to add a large amount of email addresses allowed to be used for registration. If you just have to add a few addresses, use the "Guests" section which is more convenient or use the form below.
			</ul>

			<h2>MySQL queries</h2>

			<p>To get a better control on the database, you can use SQL queries.</p>

			<h4>Examples of queries</h4>

			<p>If you're not familiar with MySQL or have a doubt for the syntax of a query, you can read these examples.</p>

			<ul>
				<li><strong>Add an element in a table (in this example, we reproduce the query performed in the "Guests" section):</strong></li>INSERT INTO allowed_users (email, status) VALUES ('example@example.com', 'meeting')
				<li><strong>Delete a table:</strong></li> DROP TABLE allowed_users
				<li><strong>If the user with the email example@example.com made a mistake in the title of their abstract:</strong></li>UPDATE uploaded_abstracts SET title='Example of new title' WHERE email='example@example.com'
				<li><strong>Delete an element in a table:</strong></li>DELETE FROM uploaded_abstract WHERE id=41
			</ul>


			<p><strong>Remark:</strong> Since the code has been adapted for the database to work online, using <em>email='user@example.com'</em> doesn't work anymore. We need to use the ID instead, and to find why it's not working.</p>

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
	            $salt = '-i&[FeVR/8h8w;mdaQG73haHc")#^!';
				$passwordHash = crypt($password, $salt);

				if ($passwordHash == $passwordHashDB)
				{
					$sql_input = $_POST['sql-input'];
					try 
					{
						$query_input = $db->prepare($sql_input);
						$query_input->execute();
					    $message[] = 'The query succeeded.';
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
		        </div>

				<div class="field">
					<label for="table">Query:</label>
					<input type="text" name="sql-input" id="sql-input" required/>
				</div>
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" required/>
				</div>
				<input type="submit" name="insert-query" value="Login"/>
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