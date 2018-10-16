<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>D&D SIP</title>
  <style>
	  body{
		  background-color: rgb(153,50,204);
	  }
	  #signupForm{
		  padding-top: 200px;
		  text-align: center;
		  font-size: 30px;
		  color: orange;
	  }
	  .registerText{
		  width: 240px;
		  font-size: 30px;
	  }
	  #register{
		  width: 100px;
		  background-color: lightgreen;
	  }
	  #redText{
		  color: red;
		  font-size: 3em;
	  }
  </style>
</head>
<body>
	<?php
		$username = $password = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = parse_input($_POST["username"]);
			$password = parse_input($_POST["password"]);

			$host = "localhost";
			$dbuser = "mhypnaro";
			$dbpassword = "Pial-9-tiop";
			$dbname = "test_database";

			$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
			if (mysqli_connect_error()) {
				echo ("Unable to connect to database!");
			} else {
				if (!empty($username) && !empty($password)) {
					$newUser = "INSERT INTO Users values ('$username', '$password')";
					if ($conn->query($newUser)){
						echo("A new user has been inserted!");
					} else {
						echo("Error: " . $newUser . " " . $conn->error);
					}
				} else {
					if (empty($username)) {
						echo("Please fill out a username.<br>");
					}
					if (empty($password)) {
						echo("Please fill out a password.<br>");
					}
				}
			}
			$conn->close();
		}

		function parse_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	?>

	<form id="signupForm" method="post" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"]));?>">
		Username: <input class="registerText" type="text" name="username">
		<br>
		<br>
		Password: <input class="registerText" type="password" name="password">
		<br>
		<br>
		<input id="register" type="submit" value="Register">
		<p id="redText"><?php echo($data);?></p>
	</form>
</body>
</html>
