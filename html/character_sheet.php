<?php
	session_start();

	//Global variables
	$characterID = $_SESSION['characterID'];


	/*
	Checking to see if a user is logged in
	and redirecting them to the login page if they are not
	*/
    if($_SESSION["user"]) {
        $username = $_SESSION["user"];
    } else {
        $_SESSION["notLoggedIn"] = True;
        header("Location: index.php");
    }


	//database credentials
    $host = "localhost";
    $dbuser = "mhypnaro";
    $dbpassword = "CMPS115rjullig";
    $dbname = "dndsip";


    //establishing a connection to the database
    $conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        echo ("Unable to connect to database!");
    }


	else {
		 /*
		When the form is submit, check to see what button was clicked.
		Regardless of what button was clicked, save the form data.
    	*/
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			//saving the character sheet
			putBasicInfo($conn, $characterID);
			putStatsAndSkills($conn, $characterID);
			putMiddleColumn($conn, $characterID);
			putRightColumn($conn, $characterID);
			putWeapons($conn, $characterID);
			putSpells($conn, $characterID);
			putItems($conn, $characterID);

			//if we hit the "Characters" button
			if(isset($_POST['backToCharacters'])) {
				header("Location: character_list.php");
			
			//if we hit the "Logout" button
			} elseif(isset($_POST['logout'])) {
				header("Location: logout.php");
			}
		}

		/*
		Loading the page saved data regardless of whether we hit save
		or we load the page for the first time
		*/
		$basicInfo = getBasicInfo($conn, $characterID);
		$statsAndSkills = getStatsAndSkills($conn, $characterID);
		$middleColumn = getMiddleColumn($conn, $characterID);
		$weapons = getWeapons($conn, $characterID);
		$numberOfWeapons = getNumberOfWeapons($weapons);
		$spells = getSpells($conn, $characterID);
		$numberOfSpells = getNumberOfSpells($spells);
		$rightColumn = getRightColumn($conn, $characterID);
		$items = getItems($conn, $characterID);
		$numberOfItems = getNumberOfItems($items);
	}


    //closing the connection to the database
    $conn->close();



    /*
    Helper functions
    */

    /*
    Purpose: Pareses input from forms to make it harder to hack us with SQL Injection Attacks.
    Params:
        -$data: The string to parse
    Returns: Nothing
    */
    function parse_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    /*
    Purpose: Checks to see if a checkbox in the database has been check. If it has, then
    		 set the checkbox calling this function to checked by adding "checked" into the
    		 html.
    Params:
    	-$target: The checkbox to check
    Returns: Nothing
   	*/
    function checkCheckBox($target){
    	if (strcmp($target, 'on') == 0){
    		echo('checked');
    	}
    }


    /*
    Purpose: Gets the number of weapons in the database so we know how many to load onto the page.
    Params:
    	-$weapons: The table row we are looking at
    Returns:
    	-$numberOfWeapons: The number of weapons in $weapons
    */
    function getNumberOfWeapons($weapons) {
    	$numberOfWeapons = 0;
    	for ($i = 0; $i < 65; $i++) {
    		if ($weapons['weapon' . $i . 'Name']) {
    			++$numberOfWeapons;
    		}
    	}
    	return $numberOfWeapons;
    }


    //Same as above, except that it is being done for the spells table instead.
    function getNumberOfSpells($spells) {
    	$numberOfSpells = 0;
    	for ($i = 0; $i < 65; $i++) {
    		if ($spells['spell' . $i . 'Name']) {
    			++$numberOfSpells;
    		}
    	}
    	return $numberOfSpells;
    }


    //Same as above, except that it is being done for the items table instead.
    function getNumberOfItems($items) {
    	$numberOfItems = 0;
    	for ($i = 1; $i <= 96; $i++) {
    		if ($items['item' . $i . 'Quantity']) {
    			++$numberOfItems;
    		}
    	}
    	return $numberOfItems;
    }


    /*
    Purpose: Loads an additional weapon row from the database onto the page.
    Params:
    	-$rowNumber: Determines what element from the database to load and properly
    				 assigns a name to the elements created in the page
    Returns: Nothing.
    */
    function addWeaponRow($rowNumber, $weapons) {
    	echo(
			"<tr>
				<td>
					<input name='weapon".$rowNumber."Name' type='text' style='max-width: 85%; text-align: center;' value='".$weapons['weapon'.$rowNumber.'Name']."'>
				</td>
				<td>
					<input name='weapon".$rowNumber."AttackBonus' type='text' style='max-width: 85%; text-align: center;' value='".$weapons['weapon'.$rowNumber.'AttackBonus']."'>
				</td>
				<td>
					<input name='weapon".$rowNumber."Damage' type='text' style='max-width: 85%; text-align: center;' value='".$weapons['weapon'.$rowNumber.'Damage']."'>
				</td>
			</tr>"
			);
    }


    //Same as above except that it pulls data from the Spells table of the database.
    function addSpellRow($rowNumber, $spells) {
    	echo(
    		"<tr>
				<td>
					<input name='spell".$rowNumber."Name' type='text' style='max-width: 85%; text-align: center;' value='".$spells['spell'.$rowNumber.'Name']."'>
				</td>
				<td>
					<input name='spell".$rowNumber."Level' type='text' style='max-width: 85%; text-align: center;' value='".$spells['spell'.$rowNumber.'Level']."'>
				</td>
				<td>
					<input name='spell".$rowNumber."Description' type='text' style='max-width: 85%; text-align: center;' value='".$spells['spell'.$rowNumber.'Description']."'>
				</td>
			</tr>"
    	);
    }


    //Same as above except that it pulls data from the Items table of the database.
    function addItemRow($rowNumber, $items) {
    	echo(
    		"<tr>
			    <td><input name='item".$rowNumber."Quantity' type='number' value='".$items['item'.$rowNumber.'Quantity']."'></input></td>
			    <td><input name='item".$rowNumber."Description' type='text' value='".$items['item'.$rowNumber.'Description']."'></input></td>
			</tr>"
    	);
    }



    /*
	Data Retrieval
    */

    /*
	Purpose: Collects all the information from the BasicInfo table of the database
			 associated with a particular characterID and stores it in a variable for use.
	Params:
		-$conn: The open connection to the database to query against.
		-$characterID: The id of the character to pull information for.
	Returns: 
		-$basicInfo: The row of the table which contains the data
			-Each individual element can be accessed with $basicInfo['COLUMN_NAME']
    */
    function getBasicInfo($conn, $characterID) {
	    $basicInfoQuery = "SELECT * FROM BasicInfo WHERE characterID='$characterID';";
	    $basicInfoResult = $conn->query($basicInfoQuery);
	    $basicInfo = $basicInfoResult->fetch_assoc();

	    return $basicInfo;
	}


	//Same as above, except that it accesses the StatsAndSkills table of the database instead.
	function getStatsAndSkills($conn, $characterID) {
		$statsAndSkillsQuery = "SELECT * FROM StatsAndSkills WHERE characterID='$characterID';";
	    $statsAndSkillsResult = $conn->query($statsAndSkillsQuery);
	    $statsAndSkills = $statsAndSkillsResult->fetch_assoc();

	    return $statsAndSkills;
	}

	//Same as above, except that it accesses the MiddleColumn table of the database instead.
	function getMiddleColumn($conn, $characterID) {
		$middleColumnQuery = "SELECT * FROM MiddleColumn WHERE characterID='$characterID';";
	    $middleColumnResult = $conn->query($middleColumnQuery);
	    $middleColumn = $middleColumnResult->fetch_assoc();

	    return $middleColumn;
	}


	//Same as above, except that it accesses the Weapons table of the database instead.
	function getWeapons($conn, $characterID) {
	    $weaponsQuery = "SELECT * FROM Weapons WHERE characterID='$characterID';";
	    $weaponsResult = $conn->query($weaponsQuery);
	    $weapons = $weaponsResult->fetch_assoc();

	    return $weapons;
	}


	//Same as above, except that it accesses the Spells table of the database instead.
	function getSpells($conn, $characterID) {
	    $spellsQuery = "SELECT * FROM Spells WHERE characterID='$characterID';";
	    $spellsResult = $conn->query($spellsQuery);
	    $spells = $spellsResult->fetch_assoc();

	    return $spells;
	}


	//Same as above, except that it accesses the RightColumn table of the database instead.
	function getRightColumn($conn, $characterID) {
	    $rightColumnQuery = "SELECT * FROM RightColumn WHERE characterID='$characterID';";
	    $rightColumnResult = $conn->query($rightColumnQuery);
	    $rightColumn = $rightColumnResult->fetch_assoc();

	    return $rightColumn;
	}


	//Same as above, except that it accesses the Inventory table of the database instead.
	function getItems($conn, $characterID) {
	    $itemsQuery = "SELECT * FROM Inventory WHERE characterID='$characterID';";
	    $itemsResult = $conn->query($itemsQuery);
	    $items = $itemsResult->fetch_assoc();

	    return $items;
	 }



	/*
	Data upload
	*/

	/*
	Purpose: Updates (saves / puts) the contents of the page associated with the basicInfo table
			 into the database for the given charcterID.
	Params:
		-$conn: The open connection to the database to query against.
		-$charcterID: The id of the character to update information for.
	Returns:
		Nothing
	*/
	function putBasicInfo($conn, $characterID) {
		$updatedPlayerName = parse_input($_POST['playerName']);
		$updatedCharacterName = parse_input($_POST['characterName']);
		$updatedClass = parse_input($_POST['class']);
		$updatedLevel = parse_input($_POST['level']);
		$updatedRace = parse_input($_POST['race']);
		$updatedAlignment = parse_input($_POST['alignment']);
		$updatedExperiencePoints = parse_input($_POST['experiencePoints']);

		$updateBasicInfoQuery = "UPDATE BasicInfo SET
								playerName='$updatedPlayerName',
								characterName='$updatedCharacterName',
								class='$updatedClass',
								level='$updatedLevel',
								race='$updatedRace',
								alignment='$updatedAlignment',
								experiencePoints='$updatedExperiencePoints'
								WHERE characterID='$characterID';";

		$conn->query($updateBasicInfoQuery);
	}


	//Same as above, except that it accesses the StatsAndSkills table instead
	function putStatsAndSkills($conn, $characterID) {
		$updatedStrength = parse_input($_POST['strength']);
		$updatedDexterity = parse_input($_POST['dexterity']);
		$updatedConstitution = parse_input($_POST['constitution']);
		$updatedIntelligence = parse_input($_POST['intelligence']);
		$updatedWisdom = parse_input($_POST['wisdom']);
		$updatedCharisma = parse_input($_POST['charisma']);

		$updatedStrengthProficient = parse_input($_POST['strengthProficient']);
		$updatedDexterityProficient = parse_input($_POST['dexterityProficient']);
		$updatedConstitutionProficient = parse_input($_POST['constitutionProficient']);
		$updatedIntelligenceProficient = parse_input($_POST['intelligenceProficient']);
		$updatedWisdomProficient = parse_input($_POST['wisdomProficient']);
		$updatedCharismaProficient = parse_input($_POST['charismaProficient']);

		$updatedInspiration = parse_input($_POST['inspiration']);
		$updatedProficiencyBonus = parse_input($_POST['proficiencyBonus']);
		$updatedManualEntry = parse_input($_POST['manualEntry']);

		$updatedAcrobaticsProficient = parse_input($_POST['acrobaticsProficient']);
		$updatedArcanaProficient = parse_input($_POST['arcanaProficient']);
		$updatedDeceptionProficient = parse_input($_POST['deceptionProficient']);
		$updatedInsightProficient = parse_input($_POST['insightProficient']);
		$updatedInvestigationProficient = parse_input($_POST['investigationProficient']);
		$updatedNatureProficient = parse_input($_POST['natureProficient']);
		$updatedPerformanceProficient = parse_input($_POST['performanceProficient']);
		$updatedReligionProficient = parse_input($_POST['religionProficient']);
		$updatedStealthProficient = parse_input($_POST['stealthProficient']);
		$updatedAnimalHandlingProficient = parse_input($_POST['animalHandlingProficient']);
		$updatedAthleticsProficient = parse_input($_POST['athleticsProficient']);
		$updatedHistoryProficient = parse_input($_POST['historyProficient']);
		$updatedIntimidationProficient = parse_input($_POST['intimidationProficient']);
		$updatedMedicineProficient = parse_input($_POST['medicineProficient']);
		$updatedPerceptionProficient = parse_input($_POST['perceptionProficient']);
		$updatedPersuasionProficient = parse_input($_POST['persuasionProficient']);
		$updatedSleightOfHandProficient = parse_input($_POST['sleightOfHandProficient']);
		$updatedSurvivalProficient = parse_input($_POST['survivalProficient']);


		$updatedPassivePerception = parse_input($_POST['passivePerception']);
		$updatedOther = parse_input($_POST['other']);

		$updateStatsAndSkillsQuery = "UPDATE StatsAndSkills SET
									 strength='$updatedStrength',
									 dexterity='$updatedDexterity',
									 constitution='$updatedConstitution',
									 intelligence='$updatedIntelligence',
									 wisdom='$updatedWisdom',
									 charisma='$updatedCharisma',
									 
									 inspiration='$updatedInspiration',
									 proficiencyBonus='$updatedProficiencyBonus',
									 manualEntry='$updatedManualEntry',

									 strengthProficient='$updatedStrengthProficient',
									 dexterityProficient='$updatedDexterityProficient',
									 constitutionProficient='$updatedConstitutionProficient',
									 intelligenceProficient='$updatedIntelligenceProficient',
									 wisdomProficient='$updatedWisdomProficient',
									 charismaProficient='$updatedCharismaProficient',

									 acrobaticsProficient='$updatedAcrobaticsProficient',
									 arcanaProficient='$updatedArcanaProficient',
									 deceptionProficient='$updatedDeceptionProficient',
									 insightProficient='$updatedInsightProficient',
									 investigationProficient='$updatedInvestigationProficient',
									 natureProficient='$updatedNatureProficient',
									 performanceProficient='$updatedPerformanceProficient',
									 religionProficient='$updatedReligionProficient',
									 stealthProficient='$updatedStealthProficient',
									 animalHandlingProficient='$updatedAnimalHandlingProficient',
									 athleticsProficient='$updatedAthleticsProficient',
									 historyProficient='$updatedHistoryProficient',
									 intimidationProficient='$updatedIntimidationProficient',
									 medicineProficient='$updatedMedicineProficient',
									 perceptionProficient='$updatedPerceptionProficient',
									 persuasionProficient='$updatedPersuasionProficient',
									 sleightOfHandProficient='$updatedSleightOfHandProficient',
									 survivalProficient='$updatedSleightOfHandProficient',

									 passivePerception='$updatedPassivePerception',
									 other='$updatedOther'
									 WHERE characterID='$characterID';";

		$conn->query($updateStatsAndSkillsQuery);
	}


	function putMiddleColumn($conn, $characterID) {
		$updatedAC = parse_input($_POST['ac']);
		$udpatedInitiative = parse_input($_POST['initiative']);
		$updatedSpeed = parse_input($_POST['speed']);
		$updatedHPCurrent = parse_input($_POST['hpCurrent']);
		$updatedHPMax = parse_input($_POST['hpMax']);
		$updatedTempHP = parse_input($_POST['tempHp']);
		$updatedHitDiceCurrent = parse_input($_POST['hitDiceCurrent']);
		$updatedHitDiceMax = parse_input($_POST['hitDiceMax']);

		$updatedDeathSuccessOne = parse_input($_POST['deathSuccessOne']);
		$updatedDeathSuccessTwo = parse_input($_POST['deathSuccessTwo']);
		$updatedDeathSuccessThree = parse_input($_POST['deathSuccessThree']);
		$updatedDeathFailOne = parse_input($_POST['deathFailOne']);
		$updatedDeathFailTwo = parse_input($_POST['deathFailTwo']);
		$updatedDeathFailThree = parse_input($_POST['deathFailThree']);

		$updatedFirstLevelCurrent = parse_input($_POST['firstLevelCurrent']);
		$updatedSecondLevelCurrent = parse_input($_POST['secondLevelCurrent']);
		$updatedThirdLevelCurrent = parse_input($_POST['thirdLevelCurrent']);
		$updatedFourthLevelCurrent = parse_input($_POST['fourthLevelCurrent']);
		$updatedFifthLevelCurrent = parse_input($_POST['fifthLevelCurrent']);
		$updatedSixthLevelCurrent = parse_input($_POST['sixthLevelCurrent']);
		$updatedSeventhLevelCurrent = parse_input($_POST['seventhLevelCurrent']);
		$updatedEighthLevelCurrent = parse_input($_POST['eighthLevelCurrent']);
		$updatedNinthLevelCurrent = parse_input($_POST['ninthLevelCurrent']);

		$udpatedFirstLevelMax = parse_input($_POST['firstLevelMax']);
		$udpatedSecondLevelMax = parse_input($_POST['secondLevelMax']);
		$udpatedThirdLevelMax = parse_input($_POST['thirdLevelMax']);
		$udpatedFourthLevelMax = parse_input($_POST['fourthLevelMax']);
		$udpatedFifthLevelMax = parse_input($_POST['fifthLevelMax']);
		$udpatedSixthLevelMax = parse_input($_POST['sixthLevelMax']);
		$udpatedSeventhLevelMax = parse_input($_POST['seventhLevelMax']);
		$udpatedEighthLevelMax = parse_input($_POST['eighthLevelMax']);
		$udpatedNinthLevelMax = parse_input($_POST['ninthLevelMax']);

		$updateMiddleColumnQuery = "UPDATE MiddleColumn SET

									ac='$updatedAC',
									initiative='$udpatedInitiative',
									speed='$updatedSpeed',
									hpCurrent='$updatedHPCurrent',
									hpMax='$updatedHPMax',
									tempHp='$updatedTempHP',
									hitDiceCurrent='$updatedHitDiceCurrent',
									hitDiceMax='$updatedHitDiceMax',

									deathSuccessOne='$updatedDeathSuccessOne',
									deathSuccessTwo='$updatedDeathSuccessTwo',
									deathSuccessThree='$updatedDeathSuccessThree',
									deathFailOne='$updatedDeathFailOne',
									deathFailTwo='$updatedDeathFailTwo',
									deathFailThree='$updatedDeathFailThree',

									firstLevelCurrent='$updatedFirstLevelCurrent',
									secondLevelCurrent='$updatedSecondLevelCurrent',
									thirdLevelCurrent='$updatedThirdLevelCurrent',
									fourthLevelCurrent='$updatedFourthLevelCurrent',
									fifthLevelCurrent='$updatedFifthLevelCurrent',
									sixthLevelCurrent='$updatedSixthLevelCurrent',
									seventhLevelCurrent='$updatedSeventhLevelCurrent',
									eighthLevelCurrent='$updatedEighthLevelCurrent',
									ninthLevelCurrent='$updatedNinthLevelCurrent',

									firstLevelMax='$udpatedFirstLevelMax',
									secondLevelMax='$udpatedSecondLevelMax',
									thirdLevelMax='$udpatedThirdLevelMax',
									fourthLevelMax='$udpatedFourthLevelMax',
									fifthLevelMax='$udpatedFifthLevelMax',
									sixthLevelMax='$udpatedSixthLevelMax',
									seventhLevelMax='$udpatedSeventhLevelMax',
									eighthLevelMax='$udpatedEighthLevelMax',
									ninthLevelMax='$udpatedNinthLevelMax'

									where characterID='$characterID';";

		$conn->query($updateMiddleColumnQuery);
	}


	//Same as above, except that it accesses the RightColumn table instead
	function putRightColumn($conn, $characterID) {
		$updatedTraits = parse_input($_POST['traits']);
		$updatedIdeals = parse_input($_POST['ideals']);
		$updatedBonds = parse_input($_POST['bonds']);
		$updatedFlaws = parse_input($_POST['flaws']);
		$updatedFeaturesAndTraits = parse_input($_POST['featuresAndTraits']);
	
		$updateRightColumnQuery = "UPDATE RightColumn SET
									 traits='$updatedTraits',
									 ideals='$updatedIdeals',
									 bonds='$updatedBonds',
									 flaws='$updatedFlaws',
									 featuresAndTraits='$updatedFeaturesAndTraits'
									 WHERE characterID='$characterID';";
		$conn->query($updateRightColumnQuery);
	}


	//Loads the weapons into the database by first checking to see which weapons are even populated
	function putWeapons($conn, $characterID) {
		$updateWeaponsQuery = "UPDATE Weapons SET";
		for($i = 1; $i <= 64; $i++) {
			if (parse_input($_POST['weapon'.$i.'Name'])) {
				$updateWeaponsQuery =
				$updateWeaponsQuery . " weapon" . $i . "Name='" . parse_input($_POST['weapon'.$i.'Name']) .
				"', weapon" . $i . "AttackBonus='" . parse_input($_POST['weapon'.$i.'AttackBonus']) .
				"', weapon" . $i . "Damage='" . parse_input($_POST['weapon'.$i.'Damage']) . "',";
			} else {
				$updateWeaponsQuery =
				$updateWeaponsQuery . " weapon" . $i . "Name='', weapon" . $i . "AttackBonus='', weapon" . $i . "Damage='',";
			}
		}
		if(strlen($updateWeaponsQuery) != 0) {
			$updateWeaponsQuery = substr($updateWeaponsQuery, 0, -1);
			$updateWeaponsQuery = $updateWeaponsQuery . " WHERE characterID='" . $characterID . "';";
			$conn->query($updateWeaponsQuery);
		}
	}


	//Loads the spells into the database by first checking to see which spells are even populated
	function putSpells($conn, $characterID) {
		$updateSpellsQuery = "UPDATE Spells SET";
		for($i = 1; $i <= 64; $i++) {
			if (parse_input($_POST['spell'.$i.'Name'])) {
				$updateSpellsQuery =
				$updateSpellsQuery . " spell" . $i . "Name='" . parse_input($_POST['spell'.$i.'Name']) .
				"', spell" . $i . "Level='" . parse_input($_POST['spell'.$i.'Level']) .
				"', spell" . $i . "Description='" . parse_input($_POST['spell'.$i.'Description']) . "',";
			} else {
				$updateSpellsQuery =
				$updateSpellsQuery . " spell" . $i . "Name='', spell" . $i . "Level='', spell" . $i . "Description='',";
			}
		}
		if(strlen($updateSpellsQuery) != 0) {
			$updateSpellsQuery = substr($updateSpellsQuery, 0, -1);
			$updateSpellsQuery = $updateSpellsQuery . " WHERE characterID='" . $characterID . "';";
			$conn->query($updateSpellsQuery);
		}
	}


	//Loads the items into the database by first checking to see which items are even populated
	function putItems($conn, $characterID) {
		$updateItemsQuery = "UPDATE Inventory SET gold='" . parse_input($_POST['gold']) . "',";
		for($i = 1; $i <= 96; $i++) {
			if (parse_input($_POST['item'.$i.'Quantity']) && parse_input($_POST['item'.$i.'Description'])) {
				$updateItemsQuery =
				$updateItemsQuery . " item" . $i . "Quantity='" . parse_input($_POST['item'.$i.'Quantity']) .
				"', item" . $i . "Description='" . parse_input($_POST['item'.$i.'Description']) . "',";
			} else {
				$updateItemsQuery =
				$updateItemsQuery . " item" . $i . "Quantity='', item" . $i . "Description='',";
			}
		}
		if(strlen($updateItemsQuery) != 0) {
			$updateItemsQuery = substr($updateItemsQuery, 0, -1);
			$updateItemsQuery = $updateItemsQuery . " WHERE characterID='" . $characterID . "';";
			$conn->query($updateItemsQuery);
		}
	}
?>


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
	<form id="characterSheet" method="post" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"]));?>"> 
	<!-- needs additional work. e.g. action tag -->
	<div id="namePlate">
		<div id="innerbox">
			<button type="submit" name="save"> Save </button>
			<button type="submit" name="backToCharacters"> Characters </button>
			<button type="submit" name="logout"> Logout </button>
			<label for="pName"> Player Name: </label>
			<input name="playerName" id="pName" type="text" placeholder="Player Name" value="<?php echo($basicInfo['playerName']);?>">
			<label for="cName">Character Name: </label>
			<input name="characterName" id="cName" type="text" placeholder="Character Name" value="<?php echo($basicInfo['characterName']);?>">
			<label for="class"> Class: </label>
			<input name="class" id="class" type="text" placeholder="Class" value="<?php echo($basicInfo['class']);?>">
			<label for="level"> Level: </label>
			<input name="level" id="level" type="text" placeholder="Level" value="<?php echo($basicInfo['level']);?>">
			<label for="race"> Race: </label>
			<input name="race" id="race" type="text" placeholder="Race" value="<?php echo($basicInfo['race']);?>">
			<label for="alignment"> Alignment: </label>
			<input name="alignment" id="alignment" type="text" placeholder="Alignment" value="<?php echo($basicInfo['alignment']);?>">
			<label for="exp"> Experience Points: </label>
			<input name="experiencePoints" id="exp" type="number" placeholder="Experience Points" value="<?php echo($basicInfo['experiencePoints']);?>">
		</div>
	</div>
	<div class="column">
		
		<div id="stats">

			<div id="statsBoxFormat">
				<!-- stats boxes -->
				<div id="statsboxLeftCol">
					<h4> Strength </h4>					
					<input name="strength" id="strength" type="number" value="<?php echo($statsAndSkills['strength']);?>">
					<div name="strengthMod" id="strMod">str mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Dexterity </h4>
					<input name="dexterity" id="dexterity" type="number" value="<?php echo($statsAndSkills['dexterity']);?>">
					<div name="dexterityMod" id="dexMod">dex mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Constitution </h4>
					<input name="constitution" id="constitution" type="number" value="<?php echo($statsAndSkills['constitution']);?>">
					<div name="constitutionMod" id="conMod">con mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Intelligence </h4>
					<input name="intelligence" id="intelligence" type="number" value="<?php echo($statsAndSkills['intelligence']);?>">
					<div name="intelligenceMod" id="intMod">int mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Wisdom </h4>
					<input name="wisdom" id="wisdom" type="number" value="<?php echo($statsAndSkills['wisdom']);?>">
					<div name="wisdomMod" id="wisMod">wis mod</div>
				</div>
				<div id="statsboxLeftCol">
					<h4> Charisma </h4>
					<input name="charisma" id="charisma" type="number" value="<?php echo($statsAndSkills['charisma']);?>">
					<div name="charismaMod" id="chaMod">cha mod</div>
				</div>

			</div>

			<div id="insp-prof-st-skills">
			
			<!-- inspiration and proficiency bonus -->
				<div id="insp-prof" style="margin-top: 0;"> 
					<input for="inspiration" name="inspiration" type="checkbox" <?php echo(checkCheckBox($statsAndSkills['inspiration']));?>>
					<label id="inspiration">Inspiration</label>
				</div>
				<div id="insp-prof"> 
					<input name="proficiencyBonus" id="proficiency" type="number" value="<?php echo($statsAndSkills['proficiencyBonus']);?>">
					<label id="profBonus">Proficiency Bonus</label>
				</div>

				<!-- saving throws -->
				<div id="savingThrowsBackground">
					<div id="savingThrows" class="ST-form">
						<h4> Saving Throws </h4>
						<input type="checkbox" id="strCheckbox" name="strengthProficient" <?php echo(checkCheckBox($statsAndSkills['strengthProficient']));?>>
						<input name="strengthSavingThrow" id="strengthSavingThrow" type="number"> Strength
						<br>
						<input type="checkbox" id="dexCheckbox" name="dexterityProficient" <?php echo(checkCheckBox($statsAndSkills['dexterityProficient']));?>>
						<input name="dexteritySavingThrow" id="dexteritySavingThrow" type="number"> Dexterity 
						<br>
						<input type="checkbox" id="conCheckbox" name="constitutionProficient" <?php echo(checkCheckBox($statsAndSkills['constitutionProficient']));?>>
						<input name="constitutionSavingThrow" id="constitutionSavingThrow" type="number"> Constitution
						<br>
						<input type="checkbox" id="intCheckbox" name="intelligenceProficient" <?php echo(checkCheckBox($statsAndSkills['intelligenceProficient']));?>>
						<input name="intelligenceSavingThrow" id="intelligenceSavingThrow" type="number"> Intelligence
						<br>
						<input type="checkbox" id="wisCheckbox" name="wisdomProficient" <?php echo(checkCheckBox($statsAndSkills['wisdomProficient']));?>>
						<input name="wisdomSavingThrow" id="wisdomSavingThrow" type="number"> Wisdom
						<br>
						<input type="checkbox" id="chaCheckbox" name="charismaProficient" <?php echo(checkCheckBox($statsAndSkills['charismaProficient']));?>> 
						<input name="charismaSavingThrow" id="charismaSavingThrow" type="number"> Charisma
						<br>
					</div>
				</div> 
				
				<div id="skillsBox">
					<div id="skills"> 
						<h4>Skills</h4>
						<div id="manualInputDiv">
						 <div id="manualEntry"> <input name="manualEntry" type="checkbox" onclick="switchManualCalculation(), changeSkillInputFeildsWritability()" <?php echo(checkCheckBox($statsAndSkills['manualEntry']));?>> Manual Entry
							<span id="manualInputText">Manual Entry disables the automatic calculation of skills. Checkboxes for skill proficiency also have no effect.</span>
						 </div>
						</div>
						<table id="skillsList">
							<tr>
								<td> 
									<input type="checkbox" id="acrobaticsCheckbox" name="acrobaticsProficient" <?php echo(checkCheckBox($statsAndSkills['acrobaticsProficient']));?>> 
									<input name="acrobatics" id="acrobatics" type="number" class="dexSkill"> Acrobatics
								</td>
								<td>
									<input type="checkbox" id="animalCheckbox" name="animalHandlingProficient" <?php echo(checkCheckBox($statsAndSkills['animalHandlingProficient']));?>>
									<input name="animalHandling" id="animal" type="number" class="wisSkill"> Animal Handling</td>
							</tr>
							<tr>
								<td> 
									<input type="checkbox" id="arcanaCheckbox" name="arcanaProficient" <?php echo(checkCheckBox($statsAndSkills['arcanaProficient']));?>>
									<input name="arcana" id="arcana" type="number" class="intSkill"> Arcana
								</td>
								<td>
									<input type="checkbox" id="athleticsCheckbox" name="athleticsProficient" <?php echo(checkCheckBox($statsAndSkills['athleticsProficient']));?>>
									<input name="athletics" id="athletics" type="number" class="strSkill"> Athletics
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="deceptionCheckbox" name="deceptionProficient" <?php echo(checkCheckBox($statsAndSkills['deceptionProficient']));?>>
									<input name="deception" id="deception" type="number" class="chaSkill"> Deception
								</td>
								<td>
									<input type="checkbox" id="historyCheckbox" name="historyProficient" <?php echo(checkCheckBox($statsAndSkills['historyProficient']));?>>
									<input name="history" id="history" type="number" class="intSkill"> History
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="insightCheckbox" name="insightProficient" <?php echo(checkCheckBox($statsAndSkills['insightProficient']));?>>
									<input name="insight" id="insight" type="number" class="wisSkill"> Insight
								</td>
								<td>
									<input type="checkbox" id="intimidationCheckbox" name="intimidationProficient" <?php echo(checkCheckBox($statsAndSkills['intimidationProficient']));?>>
									<input name="intimidation" id="intimidation" type="number" class="chaSkill"> Intimidation
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="investigationCheckbox" name="investigationProficient" <?php echo(checkCheckBox($statsAndSkills['investigationProficient']));?>>
									<input name="investigation" id="investigation" type="number" class="intSkill"> Investigation
								</td>
								<td>
									<input type="checkbox" id="medicineCheckbox" name="medicineProficient" <?php echo(checkCheckBox($statsAndSkills['medicineProficient']));?>>
									<input name="medicine" id="medicine" type="number" class="wisSkill"> Medicine
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="natureCheckbox" name="natureProficient" <?php echo(checkCheckBox($statsAndSkills['natureProficient']));?>>
									<input name="nature" id="nature" type="number" class="intSkill"> Nature
								</td>
								<td>
									<input type="checkbox" id="perceptionCheckbox" name="perceptionProficient" <?php echo(checkCheckBox($statsAndSkills['perceptionProficient']));?>>
									<input name="perception" id="perception" type="number" class="wisSkill"> Perception
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="performanceCheckbox" name="performanceProficient" <?php echo(checkCheckBox($statsAndSkills['performanceProficient']));?>>
									<input name="performance" id="performance" type="number" class="chaSkill"> Performance
								</td>
								<td>
									<input type="checkbox" id="persuasionCheckbox" name="persuasionProficient" <?php echo(checkCheckBox($statsAndSkills['persuasionProficient']));?>>
									<input name="persuasion" id="persuasion" type="number" class="chaSkill"> Persuasion
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="religionCheckbox" name="religionProficient" <?php echo(checkCheckBox($statsAndSkills['religionProficient']));?>>
									<input name="religion" id="religion" type="number" class="intSkill"> Religion
								</td>
								<td>
									<input type="checkbox" id="sleightCheckbox" name="sleightOfHandProficient" <?php echo(checkCheckBox($statsAndSkills['sleightOfHandProficient']));?>>
									<input name="sleightOfHand" id="sleight" type="number" class="dexSkill"> Sleight of Hand
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" id="stealthCheckbox" name="stealthProficient" <?php echo(checkCheckBox($statsAndSkills['stealthProficient']));?>>
									<input name="stealth" id="stealth" type="number" class="dexSkill"> Stealth
								</td>
								<td>
									<input type="checkbox" id="survivalCheckbox" name="survivalProficient" <?php echo(checkCheckBox($statsAndSkills['survivalProficient']));?>>
									<input name="survival" id="survival" type="number" class="wisSkill"> Survival
								</td>
							</tr>
						</table>
					</div>
				</div>

			</div>

		</div>
		
		<div id="passiveWisdomBox">
			<input for="passiveWisdom" name="passivePerception" type="number" value="<?php echo($statsAndSkills['passivePerception']);?>">
			<label name="passivePerception" id="passiveWisdom">Passive Wisdom (Perception)</label>
		</div>
		
		<!-- Other Proficiencies and Languages -->
		<div id="otherProfLanguagesWrapper">
			<div> 
			<label class="otherProfLanguagesHeading">Other Proficiencies & Languages</label>
			</div>
			<div>
				<textarea name="other" form="characterSheet" class="profLanguagesInput"><?php echo($statsAndSkills['other']);?></textarea>
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
					<img class = "center midColImgSize" src="img/sheild2.png"/>
					<input name = "ac" type="sheildTextBox" style="width:2vw; text-align: center;" placeholder="AC" value="<?php echo($middleColumn['ac']);?>">
				</div>
			</div>
			<!--Box for Initiative-->
			<div class = "midColSection midColThird">
				<div class = "imgTextOverlay">
					<img class = "center midColImgSize" src="img/TextBox.png"/>
					<input name = "initiative" type="speedBox" style="width:2vw; text-align: center;" value="<?php echo($middleColumn['initiative']);?>">
					<div class = "imgTextBot2">
						<b>Initiative</b>
					</div>
				</div>
			</div>
			<!--Box for Speed-->
			<div class = "midColSection midColThird">
				<div class = "imgTextOverlay">
					<img class = "center midColImgSize" src="img/TextBox.png"/>
					<input name = "speed" type="speedBox" style="width:2vw; text-align: center;" value="<?php echo($middleColumn['speed']);?>">
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
								<input name = "hpCurrent" style = "max-width: 62%; margin-top: 5.5%; text-align: right; margin-left: 6%; margin-right: 2%" value="<?php echo($middleColumn['hpCurrent']);?>">
							</div>
							<div class = "midColSection center">
								<h6>/</h6>
							</div>
							<div class = "midColSection">
								<input name = "hpMax" style = "max-width: 62%; margin-top: 5.5%; margin-right: 6%" value="<?php echo($middleColumn['hpMax']);?>">
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
						<input name = "tempHp" style = "max-width: 80%; margin-top: 5.5%; margin-right: 5%" value="<?php echo($middleColumn['tempHp']);?>">
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
								<input name = "hitDiceCurrent" style = "max-width: 66%; margin-top: 18%; text-align: right; margin-left: 2%; margin-right: 2%" value="<?php echo($middleColumn['hitDiceCurrent']);?>">
							</div>
							<div class = "midColSection center" style = "margin-top: 8%">
								<h6>/</h6>
							</div>
							<div class = "midColSection">
								<input name = "hitDiceMax" style = "max-width: 66%; margin-top: 18%; margin-right: 2%" value="<?php echo($middleColumn['hitDiceMax']);?>">
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
						<input name = "deathSuccessOne" type="checkbox" <?php echo(checkCheckBox($middleColumn['deathSuccessOne']));?>>
						<input name = "deathSuccessTwo" type="checkbox" <?php echo(checkCheckBox($middleColumn['deathSuccessTwo']));?>>
						<input name = "deathSuccessThree" type="checkbox" <?php echo(checkCheckBox($middleColumn['deathSuccessThree']));?>>
					</div>
				</div>
				<br>
				<div class = "middleColumnContainer">
					<div class = "midColSection halvesBoxes">
						Failures
					</div>
					<div class = "midColSection halvesBoxes right">
						<input name = "deathFailOne" type="checkbox" <?php echo(checkCheckBox($middleColumn['deathFailOne']));?>>
						<input name = "deathFailTwo" type="checkbox" <?php echo(checkCheckBox($middleColumn['deathFailTwo']));?>>
						<input name = "deathFailThree" type="checkbox" <?php echo(checkCheckBox($middleColumn['deathFailThree']));?>>
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
					<input name = "firstLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['firstLevelCurrent']);?>">
					/
					<input name = "firstLevelMax" style = "width: 15%" value="<?php echo($middleColumn['firstLevelMax']);?>">
				</div>
				<div class = "midColSection">
					<input name = "secondLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['secondLevelCurrent']);?>">
					/
					<input name = "secondLevelMax" style = "width: 15%" value="<?php echo($middleColumn['secondLevelMax']);?>">
				</div>
				<div class = "midColSection">
					<input name = "thirdLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['thirdLevelCurrent']);?>">
					/
					<input name = "thirdLevelMax" style = "width: 15%" value="<?php echo($middleColumn['thirdLevelMax']);?>">
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
					<input name = "fourthLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['fourthLevelCurrent']);?>">
					/
					<input name = "fourthLevelMax" style = "width: 15%" value="<?php echo($middleColumn['fourthLevelMax']);?>">
				</div>
				<div class = "midColSection">
					<input name = "fifthLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['fifthLevelCurrent']);?>">
					/
					<input name = "fifthLevelMax" style = "width: 15%" value="<?php echo($middleColumn['fifthLevelMax']);?>">
				</div>
				<div class = "midColSection">
					<input name = "sixthLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['sixthLevelCurrent']);?>">
					/
					<input name = "sixthLevelMax" style = "width: 15%" value="<?php echo($middleColumn['sixthLevelMax']);?>">
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
					<input name = "seventhLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['seventhLevelCurrent']);?>">
					/
					<input name = "seventhLevelMax" style = "width: 15%" value="<?php echo($middleColumn['seventhLevelMax']);?>">
				</div>
				<div class = "midColSection">
					<input name = "eighthLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['eighthLevelCurrent']);?>">
					/
					<input name = "eighthLevelMax" style = "width: 15%" value="<?php echo($middleColumn['eighthLevelMax']);?>">
				</div>
				<div class = "midColSection">
					<input name = "ninthLevelCurrent" style = "width: 15%" value="<?php echo($middleColumn['ninthLevelCurrent']);?>">
					/
					<input name = "ninthLevelMax" style = "width: 15%" value="<?php echo($middleColumn['ninthLevelMax']);?>">
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
						<td>
							<input name = "weapon1Name" type = "text" style = "max-width: 85%; text-align: center;" value="<?php echo($weapons['weapon1Name']);?>">
						</td>
						<td>
							<input name = "weapon1AttackBonus" type = "text" style = "max-width: 85%; text-align: center;" value="<?php echo($weapons['weapon1AttackBonus']);?>">
						</td>
						<td>
							<input name = "weapon1Damage" type = "text" style = "max-width: 85%; text-align: center;" value="<?php echo($weapons['weapon1Damage']);?>">
						</td>
					</tr>
					<tr>
						<td>
							<input name = "weapon2Name" type = "text" style = "max-width: 85%; text-align: center;" value="<?php echo($weapons['weapon2Name']);?>">
						</td>
						<td>
							<input name = "weapon2AttackBonus" type = "text" style = "max-width: 85%; text-align: center;" value="<?php echo($weapons['weapon2AttackBonus']);?>">
						</td>
						<td>
							<input name = "weapon2Damage" type = "text" style = "max-width: 85%; text-align: center;" value="<?php echo($weapons['weapon2Damage']);?>">
						</td>
					</tr>
					<?php
						//loading all weapons beyond the first two from the database
						if ($numberOfWeapons > 2) {
							for($i = 3; $i <=$numberOfWeapons; $i++){
								addWeaponRow($i, $weapons);
							}
						}
					?>
				</table>
				<input type = "button" value = "Add Weapon" style = "margin-left: 5px;" onclick="weaponTableAddRow()">
				<input type = "button" value = "Delete Weapon" onclick="weaponTableDeleteRow()">
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
						<td>
							<input name="spell1Name" type="text" style="max-width: 85%; text-align: center;" value="<?php echo($spells['spell1Name']);?>">
						</td>
						<td>
							<input name="spell1Level" type="number" style="max-width: 47%; text-align: center;" value="<?php echo($spells['spell1Level']);?>">
						</td>
						<td>
							<input name="spell1Description" type="text" style="max-width: 85%; text-align: center;" value="<?php echo($spells['spell1Description']);?>">
						</td>
					</tr>
					<tr>
						<td>
							<input name="spell2Name" type="text" style="max-width: 85%; text-align: center;" value="<?php echo($spells['spell2Name']);?>">
						</td>
						<td>
							<input name="spell2Level" type="number" style="max-width: 47%; text-align: center;" value="<?php echo($spells['spell2Level']);?>">
						</td>
						<td>
							<input name="spell2Description" type="text" style="max-width: 85%; text-align: center;" value="<?php echo($spells['spell2Description']);?>">
						</td>
					</tr>
					<?php
						//loading all spells beyond the first two from the database
						if ($numberOfSpells > 2) {
							for($i = 3; $i <=$numberOfSpells; $i++){
								addSpellRow($i, $spells);
							}
						}
					?>
				</table>
				<input type = "button" value = "Add Spell" style="margin-left: 5px;" onclick="spellTableAddRow()">
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
				<textarea name="traits" form="characterSheet" class="input-field"><?php echo($rightColumn['traits']);?></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Ideals</label>
				<textarea name="ideals" form="characterSheet" class="input-field"><?php echo($rightColumn['ideals']);?></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Bonds</label>
				<textarea name="bonds" form="characterSheet" class="input-field"><?php echo($rightColumn['bonds']);?></textarea>
			</div>
			<div class="personality-box">
				<label class="input-label">Flaws</label>
				<textarea name="flaws" form="characterSheet" class="input-field"><?php echo($rightColumn['flaws']);?></textarea>
			</div>
		</div>
		<!-- Features / Special Traits -->
		<div class="features-traits-wrapper">
			<div class="features-traits-box">
				<label class="input-label">Features & Traits</label>
				<textarea name="featuresAndTraits" form="characterSheet" class="input-field"><?php echo($rightColumn['featuresAndTraits']);?></textarea>
			</div>
		</div>
		<!-- Inventory Table -->
		<div class="inventory-wrapper">
			<div class="inventory-box">
				<label class="input-label">Inventory</label>
				
				<div id="inventory-table-wrapper">
					<table id="inventory-table">
						<tr>
							<td colspan="2">
								<input type="text" style="text-align: center;" placeholder="Gold!" name="gold" id="inv-gold" value="<?php echo($inventory['gold']);?>">
							</td>
						</tr>
						<tr>
							<td>Amnt.</td>
							<td style="text-align: center;">Item Name & Description</td>
						</tr>
						<?php 
							//loading all items from the database
							if ($numberOfItems > 0) {
								for($i = 1; $i <=$numberOfItems; $i++){
									addItemRow($i, $items);
								}
							}
						?>
					</table>
				</div>

				<div class="inv-buttons">
					<input type="button" onclick="addInvRow()" value="+"></input>
					<input type="button" onclick="delInvRow()" value="-"></input>
				</div>
			</div>
		</div>
	</div>
	</form> <!-- end 'characterSheet' form -->
</body>
</html>