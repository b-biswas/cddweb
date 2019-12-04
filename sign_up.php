<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="test.css" />
		<title>Title</title>
	</head>

	<h2>
		Registration:
	</h2>
	<body>
		<form action="check_registration.php" method="POST">
			<p> <label> First name : <input type="text" name="fname" /> </label> <br /> </p>
			<p> <label> Last name : <input type="text" name="lname" /> </label> <br /> </p>
			<p> <label> Email : <input type="text" name="pseudo" /> </label> <br /> </p>
			<p>	<label> Password : <input type="password" name="password"/> </label> <br /> </p>
			<p>	<label> Confirm password : <input type="password" name="conf_password"/> </label> <br /> </p>
			<p> <label> Status:
				<select name="Status">
					<option value="phd_SU"> PhD student (STEP'UP) </option>
					<option value="phd_other"> PhD student (other) </option>
					<option value="prof_SU"> Professor (STEP'UP) </option>
					<option value="prof_other"> Professor (other) </option>
					<option value="researcher"> Researcher </option>
				</select>
			</label><br/></p>
			<p>	<label> <input type="submit" value="Submit"/> </label> <br/> </p>

		</form>

	</body>
</html>