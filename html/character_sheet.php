
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

  <script>
  $(document).ready(function(){
    $('#diceroller').load("diceroller.html");
  });
  </script>

</head>
<body>
	<div id="diceroller"></div>
	<div id="namePlate">
		<div id="innerbox">
			<form id="nameform">
				<button> Save </button>
				<button> Characters </button>
				<button> Logout </button>
				<label for="pName"> Player Name: </label>
				<input name="playerName" id="pName" type="text" placeholder="Player Name">
				<label for="cName">Character Name: </label>
				<input name="characterName" id="cName" type="text" placeholder="Character Name">
				<label for="class"> Class: </label>
				<input name="class" id="class" type="text" placeholder="Class">
				<label for="level"> Level: </label>
				<input name="level" id="level" type="text" placeholder="Level">
				<label for="race"> Race: </label>
				<input name="race" id="race" type="text" placeholder="Race">
				<label for="alignment"> Alignment: </label>
				<input name="alignment" id="alignment" type="text" placeholder="Alignment">
				<label for="exp"> Experience Points: </label>
				<input name="experiencePoints" id="exp" type="number" placeholder="Experience Points">
			</form>
		</div>
	</div>
	<div class="column">
		
		<div id="stats">

			<div id="statsBoxFormat">
				<!-- stats boxes -->
				<div id="statsboxLeftCol">
					<h4> Strength </h4>					
					<input name="strength" id="strength" type="number">
					<div name="strengthMod" id="strMod">str mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Dexterity </h4>
					<input name="dexterity" id="dexterity" type="number">
					<div name="dexterityMod" id="dexMod">dex mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Constitution </h4>
					<input name="constitution" id="constitution" type="number">
					<div name="constitutionMod" id="conMod">con mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Intelligence </h4>
					<input name="intelligence" id="intelligence" type="number">
					<div name="intelligenceMod" id="intMod">int mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Wisdom </h4>
					<input name="wisdom" id="wisdom" type="number">
					<div name="wisdomMod" id="wisMod">wis mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Charisma </h4>
					<input name="charisma" id="charisma" type="number">
					<div name="charismaMod" id="chaMod">cha mod</div>
				</div>

			</div>

			<div id="insp-prof-st-skills">
			
			<!-- inspiration and proficiency bonus -->
				<div id="insp-prof" style="margin-top: 0;"> 
					<input for="inspiration" type="checkbox">
					<label name="inspiration" id="inspiration">Inspiration</label>
				</div>
				<div id="insp-prof"> 
					<input for="profBonus" type="number">
					<label name="proficiencyBonus" id="profBonus">Proficiency Bonus</label>
				</div>

				<!-- saving throws -->
				<div id="savingThrowsBackground">
					<div id="savingThrows">
						<form id="ST-form">
							<h4> Saving Throws </h4>
							<input type="checkbox"> <input name="strengthSavingThrow" id="strengthSavingThrow" type="number"> Strength <br>
							<input type="checkbox"> <input name="dexteriySavingThrow" id="dexteriySavingThrow" type="number"> Dexterity <br>
							<input type="checkbox"> <input name="constitutionSavingThrow" id="constitutionSavingThrow" type="number"> Constitution <br>
							<input type="checkbox"> <input name="intelligenceSavingThrow" id="intelligenceSavingThrow" type="number"> Intelligence <br>
							<input type="checkbox"> <input name="wisdomSavingThrow" id="wisdomSavingThrow" type="number"> Wisdom <br>
							<input type="checkbox"> <input name="charismaSavingThrow" id="charismaSavingThrow" type="number"> Charisma <br>
						</form>
					</div>
				</div> 
				
				<div id="skillsBox">
					<div id="skills"> 
						<h4>Skills</h4>
						<div id="manualInputDiv">
						 <div id="manualEntry"> <input name="manualEntry" type="checkbox"> Manual Entry
							<span id="manualInputText">Manual Entry disables the automatic calculation of skills.  Checkboxes for proficiency and expertise do not do anything, and you instead enter your skills into text boxes.</span>
						 </div>
						</div>
						<table id="skillsList">
							<tr>
								<td> <input type="checkbox"> <input name="acrobatics" id="acrobatics" type="number"> Acrobatics</td>
								<td> <input type="checkbox"> <input name="animalHandling" id="animal" type="number"> Animal Handling</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="arcana" id="arcana" type="number"> Arcana</td>
								<td> <input type="checkbox"> <input name="athletics" id="athletics" type="number"> Athletics</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="deception" id="deception" type="number"> Deception</td>
								<td> <input type="checkbox"> <input name="history" id="history" type="number"> History</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="insight" id="insight" type="number"> Insight</td>
								<td> <input type="checkbox"> <input name="intimidation" id="intimidation" type="number"> Intimidation</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="investigation" id="investigation" type="number"> Investigation</td>
								<td> <input type="checkbox"> <input name="medicine" id="medicine" type="number"> Medicine</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="nature" id="nature" type="number"> Nature</td>
								<td> <input type="checkbox"> <input name="perception" id="perception" type="number"> Perception</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="performance" id="performance" type="number"> Performance</td>
								<td> <input type="checkbox"> <input name="persuasion" id="persuasion" type="number"> Persuasion</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="religion" id="religion" type="number"> Religion</td>
								<td> <input type="checkbox"> <input name="sleightOfHand" id="sleight" type="number"> Sleight of Hand</td>
							</tr>
							<tr>
								<td> <input type="checkbox"> <input name="stealth" id="stealth" type="number"> Stealth</td>
								<td> <input type="checkbox"> <input name="survival" id="survival" type="number"> Survival</td>
							</tr>
						</table>
					</div>
				</div>

			</div>

		</div>
		
		<div id="passiveWisdomBox">
			<input for="passiveWisdom" type="number">
			<label name="passivePerception" id="passiveWisdom">Passive Wisdom (Perception)</label>
		</div>
		
		<!-- Other Proficiencies and Languages -->
		<div id="otherProfLanguagesWrapper">
			<div> 
			<label class="otherProfLanguagesHeading">Other Proficiencies & Languages</label>
			</div>
			<div>
				<textarea name="other" class="profLanguagesInput"></textarea>
			</div>
		</div>
	</div>
	
<!--Middle Column-->
	<div class="column">
		<!--AC/Initiative/Speed Section-->

		<!--
		this section uses "middleColumnContainer" as a sort of wrapper, and works to sort of replace "container" from stupid.css
		All code in the same "middleColumnContainer" will appear on the same line and be spaced evenly according to flexbox
		On that note, flexbox is the main thing used for spacing in this section
		-->

		<div class = "middleColumnContainer">
			<!--
			All 3 boxes for AC/Init/Speed follow a simple formula: Picture then Input area then Bottom label (if any)
			-->

			<!--Box for Armor Class-->
			<div class = "midColSection center midColThird">
				<div class = "imgTextOverlay">
					<img class = "center midColImgSize" src="img/Sheild2.png"/>
					<input name = "ac varchar(255)" type="sheildTextBox" style="width:2vw; text-align: center;" placeholder="AC">
				</div>
			</div>
			<!--Box for Initiative-->
			<div class = "midColSection midColThird">
				<div class = "imgTextOverlay">
					<img class = "center midColImgSize" src="img/textBox.png"/>
					<input name = "initiative varchar(255)" type="speedBox" style="width:2vw; text-align: center;">
					<div class = "imgTextBot2">
						<b>Initiative</b>
					</div>
				</div>
			</div>
			<!--Box for Speed-->
			<div class = "midColSection midColThird">
				<div class = "imgTextOverlay">
					<img class = "center midColImgSize" src="img/textBox.png"/>
					<input name = "speed varchar(255)" type="speedBox" style="width:2vw; text-align: center;">
					<div class = "imgTextBot2">
						<b>Speed</b>
					</div>
				</div>
			</div>
		</div>
		
		<div class= "middleColumnContainer">
			<!--Hp Block-->
			<div class = "genericHpBox" style = "margin-right: 0.5%;">
				<div class = "middleColumnContainer">
					<div class = "midColSection midColQuarter center">
						<h6><font size = "-1"> Hp: </font></h6>
					</div>
					<div class = "midColSection midCol3Quarter center">
						<div class = "middleColumnContainer">
							<div class = "midColSection">
								<input name = "hpCurrent varchar(255)" style = "max-width: 62%; margin-top: 5.5%; text-align: right; margin-left: 6%; margin-right: 2%">
							</div>
							<div class = "midColSection center">
								<h6>/</h6>
							</div>
							<div class = "midColSection">
								<input name = "hpMax varchar(255)" style = "max-width: 62%; margin-top: 5.5%; margin-right: 6%">
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Temp HP Block-->
			<div class = "genericHpBox">
				<div class = "middleColumnContainer">
					<div class = "midColSection midColThird center">
						<h6><font size = "-1"> Temp Hp: </font></h6>
					</div>
					<div class = "midColSection midCol2Third">
						<input name = "tempHpCurrent varchar(255)" style = "max-width: 80%; margin-top: 5.5%; margin-right: 5%">
					</div>
				</div>
			</div>
		</div>
		<!--Hit Dice and Saving Throws-->
		<!--I referenced W3Schools to make this code-->
		<div class= "middleColumnContainer">
			<div class = "genericHpBox halvesBoxes" style = "margin-right: 0.5%;">
				<div class = "middleColumnContainer">
					<div class = "midColSection midColQuarter center">
						<h6><font size = "-1"> Hit Dice: </font></h6>
					</div>
					<div class = "midColSection midCol3Quarter center">
						<div class = "middleColumnContainer">
							<div class = "midColSection">
								<input name = "hitDiceCurrent varchar(255)" style = "max-width: 66%; margin-top: 18%; text-align: right; margin-left: 2%; margin-right: 2%">
							</div>
							<div class = "midColSection center" style = "margin-top: 8%">
								<h6>/</h6>
							</div>
							<div class = "midColSection">
								<input name = "hitDiceMax varchar(255)" style = "max-width: 66%; margin-top: 18%; margin-right: 2%">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "genericHpBox halvesBoxes">
				<div class = "middleColumnContainer">
					<div class = "midColSection halvesBoxes" style = "margin-bottom: -6%">
						Successes
					</div>
					<div class = "midColSection halvesBoxes right" style = "margin-bottom: -6%">
						<input name = "deathSuccessOne varchar(255)" type="checkbox">
						<input name = "deathSuccessTwo varchar(255)" type="checkbox">
						<input name = "deathSuccessThree varchar(255)" type="checkbox">
					</div>
				</div>
				<br>
				<div class = "middleColumnContainer">
					<div class = "midColSection halvesBoxes">
						Failures
					</div>
					<div class = "midColSection halvesBoxes right">
						<input name = "deathFailOne varchar(255)" type="checkbox">
						<input name = "deathFailTwo varchar(255)" type="checkbox">
						<input name = "deathFailThree varchar(255)" type="checkbox">
					</div>
				</div>
			</div>
		</div>
		<!-- Spell Slots -->
		
		<div class= "midColSpellSlotBox">
			<div class = "middleColumnContainer" style = "margin-bottom: 5px">
				<b><u>Spell Slots</u></b>
			</div>
			<div class = "middleColumnContainer">
				<div class = "midColSection">
					1st
				</div>
				<div class = "midColSection">
					2nd
				</div>
				<div class = "midColSection">
					3rd
				</div>
			</div>
			<div class = "middleColumnContainer" style = "margin-bottom: 5px">
				<div class = "midColSection">
					<input name = "firstLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "firstLevelMax varchar(255)" style = "width: 15%">
				</div>
				<div class = "midColSection">
					<input name = "secondLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "secondLevelMax" style = "width: 15%">
				</div>
				<div class = "midColSection">
					<input name = "thirdLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "thirdLevelMax varchar(255)" style = "width: 15%">
				</div>
			</div>
			<div class = "middleColumnContainer">
				<div class = "midColSection">
					4th
				</div>
				<div class = "midColSection">
					5th
				</div>
				<div class = "midColSection">
					6th
				</div>
			</div>
			<div class = "middleColumnContainer" style = "margin-bottom: 5px">
				<div class = "midColSection">
					<input name = "fourthLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "fourthLevelMax varchar(255)" style = "width: 15%">
				</div>
				<div class = "midColSection">
					<input name = "fifthLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "fifthLevelMax varchar(255)" style = "width: 15%">
				</div>
				<div class = "midColSection">
					<input name = "sixthLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "sixthLevelMax varchar(255)" style = "width: 15%">
				</div>
			</div>
			<div class = "middleColumnContainer">
				<div class = "midColSection">
					7th
				</div>
				<div class = "midColSection">
					8th
				</div>
				<div class = "midColSection">
					9th
				</div>
			</div>
			<div class = "middleColumnContainer">
				<div class = "midColSection">
					<input name = "seventhLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "seventhLevelMax varchar(255)" style = "width: 15%">
				</div>
				<div class = "midColSection">
					<input name = "eighthLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "eighthLevelMax varchar(255)" style = "width: 15%">
				</div>
				<div class = "midColSection">
					<input name = "ninthLevelCurrent varchar(255)" style = "width: 15%">
					/
					<input name = "ninthLevelMax varchar(255)" style = "width: 15%">
				</div>
			</div>
		</div>
		
		<!--Weapons Table-->
		<div class= "middleColumnContainer">
			<div class = "midColHeaderBox">
				<table id="weaponTableHeader">
					<col width="30%">
					<col width="30%">
					<col width="30%">
					<thead>
						<tr>
							<th>Name</th>
							<th>Atk Bonus</th>
							<th>Damage/Type</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class = "middleColumnContainer">
			<div class = "midColWepBox">
				<table id="weaponTable">
					<col width="30%">
					<col width="30%">
					<col width="30%">
					<tr>
						<td><input name = "weapon1Name varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
						<td><input name = "weapon1AttackBonus varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
						<td><input name = "weapon1Damage varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
					</tr>
					<tr>
						<td><input name = "weapon2Name varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
						<td><input name = "weapon2AttackBonus varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
						<td><input name = "weapon2Damage varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
					</tr>
					<tr>
						<td><input name = "weapon3Name varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
						<td><input name = "weapon3AttackBonus varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
						<td><input name = "weapon3Damage varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
					</tr>
				</table>
				<input type = "button" value = "Add Attack" onclick="weaponTableAddRow()">
				<input type = "button" value = "Delete Attack" onclick="weaponTableDeleteRow()">
			</div>
		</div>
		<!--Spells Table-->
		<div class= "middleColumnContainer">
			<div class = "midColHeaderBox">
				<table id="spellTableHeader">
					<col width="30%">
					<col width="10%">
					<col width="50%">
					<thead>
						<tr>
							<th>Spell</th>
							<th>Lvl</th>
							<th>Description</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class= "middleColumnContainer">
			<div class = "midColWepBox">
				<table id="spellTable">
					<col width="30%">
					<col width="10%">
					<col width="50%">
					<tr>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 47%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
					</tr>
					<tr>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 47%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
					</tr>
					<tr>
						<td><input style = "max-width: 85%; text-align: center;"></td>
						<td><input style = "max-width: 47%; text-align: center;"></td>
						<td><input style = "max-width: 85%; text-align: center;"></td>
					</tr>
				</table>
				<input type = "button" value = "Add Spell" onclick="spellTableAddRow()">
				<input type = "button" value = "Delete Spell" onclick="spellTableDeleteRow()">
			</div>
		</div>
	</div>
<!--End of Middle Column-->

<!--Right Column-->
	<div class="column" id="col3">
		<!-- Structure: Wrapper contains N boxes -->
		<!-- Each box has a label and input/textarea -->
		<!-- It is possible to have only 1 box (only personality has more) -->
		<!-- Personality Traits -->
		<div class="personality-wrapper">
			<div class="personality-box">
				<label class="input-label">Traits</label>
				<textarea name="traits" form="characterSheet" class="input-field"></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Ideals</label>
				<textarea name="ideals" form="characterSheet" class="input-field"></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Bonds</label>
				<textarea name="bonds" form="characterSheet" class="input-field"></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Flaws</label>
				<textarea name="flaws" form="characterSheet" class="input-field"></textarea>
			</div>
		</div>
		<!-- Features / Special Traits -->
		<div class="features-traits-wrapper">
			<div class="features-traits-box">
				<label class="input-label">Features & Traits</label>
				<textarea name="featuresAndTraits" form="characterSheet" class="input-field"></textarea>
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
							<input type="text" placeholder="Gold!" name="gold" id="inv-gold"></input>
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