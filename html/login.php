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
	<div id="login">
		<p id="errorText"><?php echo($submitError);?>This is an error!</p>
		<form id="loginForm">
			Username: <input class="loginText" type="text" name="username">
			<br>
			Password: <input class="loginText" tpye="text" name="password">
			<br>
			<input id="submit" type="Submit" value="Login">
		</form>
		<br>
		<a id="register" href="https://www.dndsip.ga">Sign-up for an account</a>
		<br>
		<br>
		<a id="forgotPassword" href="https://www.google.com">Forgot password?</a>
	</div>
</body>
</html>
