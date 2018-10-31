<?php
	session_start();
	if($_SESSION["user"]) {
		unset($_SESSION["user"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
	<?php
		//Pulling the data from the page when it is submitted.
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = parse_input($_POST["username"]);
			$password = parse_input($_POST["password"]);
			$confirmPassword = parse_input($_POST["confirmPassword"]);

			//database credentials
			$host = "localhost";
			$dbuser = "mhypnaro";
			$dbpassword = "CMPS115rjullig";
			$dbname = "test_database";

			//establishing a connection to the database
			$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
			if (mysqli_connect_error()) {
				echo ("Unable to connect to database!");

			} else {

				//checking if the form has any errors and then uploading to the database if it doesn't
				if (checkInput($username, $password, $confirmPassword, $conn)) {
					$newUser = "INSERT INTO Users values ('$username', '$password')";
					if ($conn->query($newUser)){
						$_SESSION["accountCreated"] = True;
						header("Location:index.php");
					} else {
						echo("Error: " . $newUser . " " . $conn->error);
					}

				//if there was an error, tell the user
				} else {
					if (strcmp($password, $confirmPassword) != 0) {
						$submitError = "Passwords do not match. Please try again.";
					}
					if (strlen($username) < 6 || strlen($username) > 30) {
						$submitError = "Username must be between 6 and 30 characters.";
					}
					if (strlen($password) < 6 || strlen($password) > 30) {
						$submitError = "Password must be between 6 and 30 characters.";
					}
					$result = $conn->query("SELECT * FROM Users WHERE Username='$username'");
					if ($result->num_rows) {
						$submitError = "That username is already taken.";
					}
				}
			}
			$conn->close();
		}

		//Making it harder to hack us with SQL
		function parse_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		//Checking to see if the form has any errors
		function checkInput($user, $pass, $confirmPass, $conn) {
			$userLength = strlen($user);
			$passLength = strlen($pass);
			$checkDuplicate = "SELECT * FROM Users WHERE Username='$user'";
			if ($userLength < 6 || $userLength > 30) {
				return false;
			}
			if ($passLength  < 6 || $passLength > 30) {
				return false;
			}
			if (strcmp($pass, $confirmPass) != 0) {
				return false;
			}
			$result = $conn->query($checkDuplicate);
			if($result->num_rows) {
				return false;
			}
			return true;
		}
	?>

	<div id="registerDiv">
		<p id="errorText"><?php echo($submitError);?></p>
		<form id="registerForm" method="post" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"]));?>">
			Username: <input class="registerText" type="text" name="username">
			<br>
			Password: <input class="registerText" type="password" name="password">
			<br>
			Confirm Password: <input class="registerText" type="password" name="confirmPassword">
			<br>
			<input id="registerButton" type="submit" value="Register">
		</form>
	</div>
</body>
</html>

