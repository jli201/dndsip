<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Login</title>
	<style>
		body{
			background-color: #2EC4B6;
		}
		#login{
			margin-top: 9%;
			margin-left: 30%;
			padding: 1%;
			width: 40%;
			height: 60%;
			background-color: #CBF3F0;
			text-align: center;
			
		}
		
		.loginText{
			font-size: .5em;
		}
		
		#loginForm{
			font-size: 2em;
		}
		
		#submit{
			width: 33.333%;
		}
		
		#errorText{
			color: red;
		}
	</style>
</head>
<body>
	<?php
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

	<div id="login">
		<p id="errorText"><?php echo($submitError);?></p>
		<p><?php echo($registeredMessage);?>
		<form id="loginForm" method="post" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"]));?>">
			Username: <input class="loginText" type="text" name="username">
			<br>
			Password: <input class="loginText" type="password" name="password">
			<br>
			<input id="submit" type="Submit" value="Login">
		</form>
		<br>
		<a id="register" href="register.php">Sign-up for an account</a>
	</div>
	<?php
		unset($_SESSION["accountCreated"]);
	?>
</body>
</html>
