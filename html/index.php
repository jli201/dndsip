<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</script>
</head>
<body>
	<?php
	//Runs when the user clicks login
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = parse_input($_POST["username"]);
		$password = parse_input($_POST["password"]);

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
			$checkLogin = "SELECT * FROM Users WHERE Username='$username' AND Password='$password'";
			$result = $conn->query($checkLogin);
			if($result->num_rows) {
				echo("Found match!");
			} else {
				$submitError = "Invalid username or password.";
				$registeredMessage = "";
			}
		}
		$conn->close();
	}

	//If the user created an account on the register page, ask them to log in.
	if(strcmp($_SESSION["accountCreated"], "true") == 0) {
		$registeredMessage = "New account registered. Login below.";
	}

	//Making it harder to hack us with SQL
	function parse_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	?>

	<div id="diceroll"></div>
	<div id="login">
		<p id="errorText"><?php echo($submitError);?></p>
		<p><?php echo($registeredMessage);?>
		<form id="loginForm" method="post" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"]));?>">
			Username: <input class="loginText" type="text" name="username">
			<br>
			Password: <input class="loginText" type="password" name="password">
			<br>
			<input id="submit" type="submit" value="Login">
		</form>
		<br>
		<a id="register" href="register.php">Sign-up for an account</a>
	</div>
	<?php
		unset($_SESSION["accountCreated"]);
	?>
</body>
</html>
