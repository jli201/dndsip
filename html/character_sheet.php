
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Character Sheet</title>
  <link rel="stylesheet" href="character_sheet.css">
  <link rel="stylesheet" href="stupid.css">
</head>
<body>
	<div id="namePlate">
		<div id="innerbox">
		<!--	<input style="height: 80%;" type="text" name="charname" placeholder="Character Name"> -->
		<form id="nameform">
			<label style="font-size: 14px;"> Player Name: </label>
			<input type="text" placeholder="Player Name">
			<label style="font-size: 14px;">Character Name: </label>
			<input type="text" placeholder="Character Name">
			<label style="font-size: 14px;"> Class & Level: </label>
			<input type="text" placeholder="Class & Level">
			<label style="font-size: 14px;"> Race: </label>
			<input type="text" placeholder="Race">
			<label style="font-size: 14px;"> Alignment: </label>
			<input type="text" placeholder="Alignment">
			<label style="font-size: 14px;"> Experience Points: </label>
			<input type="text" placeholder="Experience Points">
		</form>
		</div>
	</div>
	<div class="column">
		<div id="stats">
			<p>This is the color that I would like to have the internal divs use.</p>
		</div>
		<div id="passiveWisdom">
			<p>This is the last color in the color pallete that I had generated. I think it is neat too.</p>
		</div>
	</div>
	<div class="column">
		<div class = "container">
			<!--AC/Initiative/Speed Block -->
			<div class = "third">
				<img class = "center three-quarter" src="img/Sheild.png"/>
			</div>
			
			<div class = "third">
				<img class = "center three-quarter" src="img/Sheild.png"/>
			</div>
			
			<div class = "third">
				<img class = "center three-quarter" src="img/Sheild.png"/>
			</div>
		</div>
		
		<div id="stats">
			<!--HP Block-->
			<!-- This peice of code from https://www.dummies.com/web-design-development/site-development/how-to-put-text-boxes-in-an-html5-form/ -->
			Maximum Hp
			<p>
				<input type = "text"
					id = "myText"
					class = "center"/>
			</p>
			
			Current Hp
			<p>
				<input type = "text"
					id = "myText"
					class = "center"/>
			</p>
		
			<!--Temp HP Block-->
			Temp Hp
			<p>
				<input type = "text"
					id = "myText"
					class = "center"/>
			</p>
			<!--Hit Dice/Death Saves Block-->
			<!--This code from W3Schools-->
			<div class = "container">
				<div class = "half">
					Hit Dice
					<p>
						<input type = "text"
							id = "myText"
							class = "center"/>
					</p>
				</div>
				<div class = "half">
					<form action="/action_page.php">
						Successes	<input type="checkbox">
									<input type="checkbox">
									<input type="checkbox">
						<br>    
						Failures  	<input type="checkbox">
									<input type="checkbox">
									<input type="checkbox">
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="column">
		<p>Content here</p>
	</div>
</body>
</html>
