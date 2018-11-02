
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
		
		<div id="stats">

			<div id="statsBoxFormat">
				<!-- stats boxes -->
				<div id="statsboxLeftCol">
					<h4> Strength </h4>
					<div id="strMod">str mod</div>
					<input type="number">
				</div>
				<div id="statsboxLeftCol">
					<h4> Dexterity </h4>
					<div id="dexMod">dex mod</div>
					<input type="number">
				</div>
				<div id="statsboxLeftCol">
					<h4> Constitution </h4>
					<div id="conMod">con mod</div>
					<input type="number">
				</div>
				<div id="statsboxLeftCol">
					<h4> Intelligence </h4>
					<div id="intMod">int mod</div>
					<input type="number">
				</div>
				<div id="statsboxLeftCol">
					<h4> Wisdom </h4>
					<div id="wisMod">wis mod</div>
					<input type="number">
				</div>
				<div id="statsboxLeftCol">
					<h4> Charisma </h4>
					<div id="chaMod">cha mod</div>
					<input type="number">
				</div>

			</div>

			<div id="insp-prof-st-skills">
			
			<!-- inspiration and proficiency bonus -->
				<div id="insp-prof"> 
					<input for="inspiration" type="checkbox">
					<label id="inspiration">Inspiration</label>
				</div>
				<div id="insp-prof"> 
					<input for="profBonus" type="number">
					<label id="profBonus">Proficiency Bonus</label>
				</div>

				<!-- saving throws -->
				<div id="savingThrowsBackground">
					<div id="savingThrows">
						<form id="ST-form">
							<h4> Saving Throws </h4>
							<input type="checkbox"> <input type="number"> Strength <br>
							<input type="checkbox"> <input type="number"> Dexterity <br>
							<input type="checkbox"> <input type="number"> Constitution <br>
							<input type="checkbox"> <input type="number"> Intelligence <br>
							<input type="checkbox"> <input type="number"> Wisdom <br>
							<input type="checkbox"> <input type="number"> Charisma <br>
						</form>
					</div>
				</div> 
				
				<div id="skillsBox">
					<div id="skills"> 
						<h4>Skills</h4>
						<table id="skillsList">
							<tr>
								<td> <input type="checkbox"> <input type="number"> Acrobatics</td>
								<td> <input type="checkbox"> <input type="number"> Animal Handling</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Arcana</td>
								<td> <input type="checkbox"> <input type="number"> Athletics</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Deception</td>
								<td> <input type="checkbox"> <input type="number"> History</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Insight</td>
								<td> <input type="checkbox"> <input type="number"> Intimidation</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Investigation</td>
								<td> <input type="checkbox"> <input type="number"> Medicine</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Nature</td>
								<td> <input type="checkbox"> <input type="number"> Perception</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Performance</td>
								<td> <input type="checkbox"> <input type="number"> Persuasion</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Religion</td>
								<td> <input type="checkbox"> <input type="number"> Sleight of Hand</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input type="number"> Stealth</td>
								<td> <input type="checkbox"> <input type="number"> Survival</td>
							</tr>
						</table>
					</div>
				</div>

			</div>

		</div>
		
		
		<div id="passiveWisdom">
			<input for="profBonus" type="number">
			<label id="profBonus">Passive Wisdom (Perception)</label>
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