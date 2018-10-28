
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
		
			<!-- inspiration and proficiency bonus -->
			<div id="insp-prof"> 
				<input type="number" style="margin-bottom: 2px;">
				<label style="font-size: 20px;">Inspiration</label>
			</div>
			<div id="insp-prof"> 
				<input type="number">
				<label style="font-size: 20px;">Proficiency Bonus</label>
			</div>
			
			<!-- stats boxes -->
			<div id="statsboxLeftCol">
				<h2> Strength </h2>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h2> Dexterity </h2>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h2> Constitution </h2>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h2> Intelligence </h2>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h2> Wisdom </h2>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h2> Charisma </h2>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			
			<!-- saving throws -->
			<div id="savingThrows">
				<form id="ST-form">
					<input id="ST-form-checkbox" type="checkbox"> <input type="number" id="ST-form-spacing" style="width: 20px;"> Strength <br>
					<input id="ST-form-checkbox" type="checkbox"> <input type="number" id="ST-form-spacing" style="width: 20px;"> Dexterity <br>
					<input id="ST-form-checkbox" type="checkbox"> <input type="number" id="ST-form-spacing" style="width: 20px;"> Constitution <br>
					<input id="ST-form-checkbox" type="checkbox"> <input type="number" id="ST-form-spacing" style="width: 20px;"> Intelligence <br>
					<input id="ST-form-checkbox" type="checkbox"> <input type="number" id="ST-form-spacing" style="width: 20px;"> Wisdom <br>
					<input id="ST-form-checkbox" type="checkbox"> <input type="number" id="ST-form-spacing" style="width: 20px;"> Charisma <br>
				</form>
			</div>

		</div>
		<div id="passiveWisdom">
			<p>This is the last color in the color pallete that I had generated. I think it is neat too.</p>
		</div>
	</div>
	<div class="column">
		<div class = "container">
			<!--AC/Initiative/Speed Block -->
			<div class = "third">
				<img class = "center three-quarter" src="img/Sheild2.png"/>
			</div>
			
			<div class = "third">
				<img class = "center three-quarter" src="img/Sheild2.png"/>
			</div>
			
			<div class = "third">
				<img class = "center three-quarter" src="img/Sheild2.png"/>
			</div>
		</div>
		
		<div id="stats">
			<!--HP Block-->
			<div id="genericHpBox">
				<div class = "container">
					<div class = "quarter right">
						<h6><font size = "-1"> Maximum Hp </font></h6>
					</div>
					<div class = "threequarters">
						<input type="number" margin-top: 2px;>
					</div>
				</div>
				<input type="number">
				<div class = "center">
					<h6><font size = "-1"> Current Hitpoints </font></h6>
				</div>
			</div>
		
			<!--Temp HP Block-->
			<div id="genericHpBox">
				<br>
				<br>
				<input type="number">
				<div class = "center">
					<h6><font size = "-1"> Temporary Hitpoints </font></h6>
				</div>
			</div>
			<!--Hit Dice/Death Saves Block-->
			<!--This I referenced W3Schools to make this code-->
			<div class = "container">
				<div class = "half">
					<div class="container" id="genericHpBox">
						<div class = "third right">
							<h6><font size = "-1"> Hit Dice </font></h6>
						</div>
						<div class = "twothirds">
							<input type="number" margin-top: 2px;>
						</div>
						<input type="number" margin-top: 2px;>
						<div class="center">
							<h6><font size = "-1"> Current Hit Dice </font></h6>
						</div>
					</div>
				</div>
				<div class = "half">
					<div id="genericHpBox">
						<div class = "container">
							<br>
							<div class = "half right">
								Successes
							</div>
							<div class = "half center">
								<form action="/action_page.php">
									<input type="checkbox">
									<input type="checkbox">
									<input type="checkbox">
							</div>
							<br>
							<br>
							<div class = "half right">
								Failures
							</div>
							<div class = "half center">
								<form action="/action_page.php">
									<input type="checkbox">
									<input type="checkbox">
									<input type="checkbox">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="column">
		<p>Content here</p>
	</div>
</body>
</html>
