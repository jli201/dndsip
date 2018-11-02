
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Character Sheet</title>
  <link rel="stylesheet" href="character_sheet.css">
  <link rel="stylesheet" href="stupid.css">

  <!-- include this before any js file that uses jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 

  <script type = "text/javascript" src="character_sheet.js"></script>

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
				<input type="number" placeholder="Experience Points">
			</form>
		</div>
	</div>
	<div class="column">
	
		<!-- inspiration and proficiency bonus -->
		<div id="insp-prof-background">
			<div id="insp-prof"> 
				<input for="inspiration" type="checkbox">
				<label style="font-size: 20px">Inspiration</label>
			</div>
			<div id="insp-prof"> 
				<input type="number">
				<label style="font-size: 20px;">Proficiency Bonus</label>
			</div>
		</div>
		
		<!-- stats left column -->
		<div id="stats">
			<!-- stats boxes -->
			<div id="statsboxLeftCol">
				<h4> Strength </h4>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h4> Dexterity </h4>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h4> Constitution </h4>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h4> Intelligence </h4>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h4> Wisdom </h4>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
			<div id="statsboxLeftCol">
				<h4> Charisma </h4>
				<input type="number">
				<input type="number" style="width: 50px; margin-top: 2px;">
			</div>
		</div>
		
		<!-- saving throws -->
		<div id="savingThrowsBackground">
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
		
		<!-- Other Proficiencies and Languages -->
		<div id="otherProfLanguagesWrapper">
			<div> 
			<label class="otherProfLanguagesHeading">Other Proficiencies & Languages</label>
			</div>
			<div>
				<textarea class="profLanguagesInput"></textarea>
			</div>
		</div>
	</div>
	
<!--Middle Column-->
	<div class="column">
		<!--AC/Initiative/Speed Section-->
		<div class = "middleColumnContainer">
			<div class = "midColSection center midColThird">
				<img class = "center" src="img/Sheild2.png" style="max-width: 95%; height:auto"/>
			</div>
			<div class = "midColSection midColThird">
				<img class = "center" src="img/textBox.png" style="max-width: 95%; height:auto"/>
			</div>
			<div class = "midColSection midColThird">
				<img class = "center" src="img/textBox.png" style="max-width: 95%; height:auto"/>
			</div>
		</div>

		<!--Hp Block-->
		<div class = "genericHpBox">
			<div class = "middleColumnContainer">
				<div class = "midColSection midColQuarter center">
					<h6><font size = "-1"> Maximum Hp </font></h6>
				</div>
				<div class = "midColSection midCol3Quarter center">
					<input style = "max-width: 85%">
				</div>
			</div>
			<div class = "midColSection center">
				<input style = "max-width: 90%; text-align: center;>
			</div>
			<div class = "midColSection center" >
				<h6><font size = "-1"> Current Hitpoints </font></h6>
			</div>
		</div>

		<!--Temp HP Block-->
		<div class = "genericHpBox">
			<div class = "midColSection center">
				<input style = "margin-top: 7%; max-width: 90%; text-align: center;">
			</div>
			<div class = "midColSection center">
				<h6><font size = "-1"> Temporary Hitpoints </font></h6>
			</div>
		</div>

		<!--Hit Dice and Saving Throws-->
		<!--I referenced W3Schools to make this code-->
		<div class= "middleColumnContainer">
			<div class = "genericHpBox halvesBoxes" style = "margin-right: 1%;">
				<div class = "middleColumnContainer">
					<div class = "midColSection midColQuarter center">
						<h6><font size = "-1"> Hit Dice </font></h6>
					</div>
					<div class = "midColSection midCol3Quarter center">
						<input style = "max-width: 85%">
					</div>
				</div>
				<div class = "midColSection center">
					<input style = "max-width: 90%; text-align: center;">
				</div>
				<div class = "midColSection center">
					<h6><font size = "-1"> Current Hit Dice </font></h6>
				</div>
			</div>
			<div class = "genericHpBox halvesBoxes">
				<div class = "middleColumnContainer">
					<div class = "midColSection halvesBoxes" style = "margin-top: 8%; margin-bottom: 4%">
						Successes
					</div>
					<div class = "midColSection halvesBoxes right" style = "margin-top: 8%; margin-bottom: 4%">
						<input type="checkbox">
						<input type="checkbox">
						<input type="checkbox">
					</div>
				</div>
				<br>
				<div class = "middleColumnContainer">
					<div class = "midColSection halvesBoxes">
						Failures
					</div>
					<div class = "midColSection halvesBoxes right">
						<input type="checkbox">
						<input type="checkbox">
						<input type="checkbox">
					</div>
				</div>
			</div>
		</div>
		<!--Weapons Table-->
		<div class= "middleColumnContainer">
			<div class = "midColWepBox">
				<table id="weaponTable">
					<tr>
						<th>Name</th>
						<th>Atk Bonus</th>
						<th>Damage/Type</th>
					</tr>
					<tr>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
					</tr>
					<tr>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
					</tr>
				</table>
				<input type = "button" value = "Add Row" onclick="weaponTableAddRow()">
				<input type = "button" value = "Delete Row" onclick="weaponTableDeleteRow()">
			</div>
		</div>
		<!--Spells Table-->
		<div class= "middleColumnContainer">
			<div class = "midColWepBox">
				<table id="spellTable">
					<tr>
						<th>Spell</th>
						<th>Level</th>
						<th>Description</th>
					</tr>
					<tr>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
					</tr>
					<tr>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
					</tr>
				</table>
				<input type = "button" value = "Add Row" onclick="spellTableAddRow()">
				<input type = "button" value = "Delete Row" onclick="spellTableDeleteRow()">
			</div>
		</div>
	</div>
	
	<div class="column" id="col3">
		<!-- Structure: Wrapper contains N boxes -->
		<!-- Each box has a label and input/textarea -->
		<!-- It is possible to have only 1 box (only personality has more) -->
		<!-- Personality Traits -->
		<div class="personality-wrapper">
			<div class="personality-box">
				<label class="input-label">Traits</label>
				<textarea class="input-field"></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Ideals</label>
				<textarea class="input-field"></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Bonds</label>
				<textarea class="input-field"></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Flaws</label>
				<textarea class="input-field"></textarea>
			</div>
		</div>
		<!-- Features / Special Traits -->
		<div class="features-traits-wrapper">
			<div class="features-traits-box">
				<label class="input-label">Features & Traits</label>
				<textarea class="input-field"></textarea>
			</div>
		</div>
		<!-- Inventory Table -->
		<div class="inventory-wrapper">
			<div class="inventory-box">
				<label class="input-label">Inventory</label>
				
				<div id="inventory-table-wrapper"><table id="inventory-table">
					<!-- Table Entry Format:
					<tr>
						<td><input type="number" value="0" id="inv-num-#"></input></td>
						<td><input type="text" value="Item" id="inv-obj-#"></input></td>
					</tr> 
					Each new row must have an iterating # - check character_sheet.js
					If changing format, you must change the related js.-->
					<tr>
						<td colspan="2">
							<input type="text" value="Gold!" id="inv-gold"></input>
						</td>
					</tr>
					<tr>
						<td>#</td>
						<td>Item</td>
					</tr>
				</table></div>

				<div class="inv-buttons">
					<input type="button" onclick="addInvRow()" value="+"></input>
					<input type="button" onclick="delInvRow()" value="-"></input>
				</div>
			</div>
		</div>
	</div>


</body>
</html>