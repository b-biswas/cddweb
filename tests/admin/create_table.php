<?php
	// To add a new table in the database, add a new element in $sql[] by using the syntax:
	// sql[] = "CREATE TABLE ..."

	session_start();

	if(array_key_exists('status', $_SESSION))
	{
		if($_SESSION['status'] == 'admin')
		{

			include_once '../DBConnect.php';
			$database = new dbConnect();
			$db = $database->openConnection();

			$sql[] = "CREATE TABLE IF NOT EXISTS `registered_users` (
			`id` int(8) NOT NULL AUTO_INCREMENT,
			`first_name` varchar(255) NOT NULL,
			`last_name` varchar(255) NOT NULL,
			`email` varchar(55) NOT NULL UNIQUE,
			`password` varchar(255) NOT NULL,
			`status` varchar(55) DEFAULT 'guest',
			PRIMARY KEY (`id`)
			);";
			
			$sql[] = "CREATE TABLE IF NOT EXISTS `allowed_users` (
			`id` int(8) NOT NULL AUTO_INCREMENT,
			`email` varchar(55) NOT NULL UNIQUE,
			`status` varchar(55) NOT NULL DEFAULT 'guest',
			PRIMARY KEY (`id`)
			);";

			$sql[] = "CREATE TABLE IF NOT EXISTS `uploaded_abstracts` (
			`id` int(8) NOT NULL,
			`title` varchar(255) NOT NULL,
			`email` varchar(55) NOT NULL UNIQUE,
			`first_name` varchar(255) NOT NULL,
			`last_name` varchar(255) NOT NULL,
			`category` varchar(55) NOT NULL,
			PRIMARY KEY (`id`)
			);";

			foreach($sql as $query)
			{			
				if ($db->query($query) == TRUE)
				{
				    echo "Table created successfully if it didn't exist. </br>";
				}
				else
				{
				    echo "Error creating table: " . $db->error . ".</br>";
				}

			}
		}

		//else
		{
			echo '<strong>Access denied.</strong>';
		}
	}
	else
	{
		echo '<strong>Access denied.</strong>';
	}


?>


</p>
