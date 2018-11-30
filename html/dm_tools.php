<?php
	session_start();
    //checking to see if a user is logged in

    if($_SESSION["user"]) {
        $username = $_SESSION["user"];
    } else {
        $_SESSION["notLoggedIn"] = True;
        header("Location: index.php");
    }

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
		$dmNotes = getdmNotes($username);
    }

    function getdmNotes($username) {
    	$dmNotesQuery = "SELECT * FROM DMTools WHERE username='$username';";
    	$dmNotesResult = $conn->query($dmNotesQuery);
    	$dmNotes = $dmNotesResult->fetch_assoc();

    	return $getdmNotes;
    }
?>

<html>
	<head>
		<title>DNDSIP: DM TOOLS</title>

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="dm_tools.css">

		<!-- JQUERY & JS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		

		<!-- MARKDOWN EDITOR STUFF  -->
		<!-- https://lab.lepture.com/editor/ -->
		<!-- https://ourcodeworld.com/articles/read/359/top-7-best-markdown-editors-javascript-and-jquery-plugins -->
		<link rel="stylesheet" href="http://lab.lepture.com/editor/editor.css" />
		<script type="text/javascript" src="http://lab.lepture.com/editor/editor.js"></script>
		<script type="text/javascript" src="http://lab.lepture.com/editor/marked.js"></script>


		<!-- Load personal script last. -->
		<script src="dm_tools.js"></script>


		<script>
	  	$(document).ready(function(){
		    $('#diceroller').load("diceroller.html");
		});
  </script>

	</head>
	<body>
		<!-- placeholder to load dice roller -->
		<div id="diceroller"></div>
		<div id="pagetitle">DM TOOLS</div>

		<!-- INIT TRACKER -->
		<div id="initTrackerWrapper" class="column">
			<div id="initHeader">
				<span id="initTrackerName">INIT TRACKER</span>
				<input type="button" id="initNextTurn" value="Next Turn >" onClick="nextTurn()">
			</div>

			<div id="initTurnOrder">
				<div id="initCurrentTurnText" class="turnlabel">CURRENT TURN:</div>
				<div class="turn" ally="true">
					<div class="turnChName">Character Name</div>
					<div class="turnRoll">Roll</div>
					<div class="deleteTurnButton">-</div>
				</div>
				<div id="initNextTurnText" class="turnlabel">NEXT TURNS:</div>

			</div>

			<div id="initNewTurn">
				<input type="text" id="initNewTurnName" placeholder="Character Name">
				<input type="number" id="initNewTurnRoll" placeholder="Roll">
				<div id="initNewTurnEnemyBox">
					<label id="initEnemyText" for="initNewTurnEnemy">Enemy?</label>
					<input type="checkbox" id="initNewTurnEnemy">
				</div>
				<input type="button" id="initNewTurnAdd" value="Add" onclick="addTurn()"></input>

			</div>
		</div>

		<!-- DM NOTES -->
		<div id="notesWrapper" class="column">
			<div id="notesBox">
				<textarea name="dmNotes" id="dmNotes" value="<?php echo($dmNotes['DMNotes']);?>"></textarea> <!-- what's pasted here gets pasted in result-->
			</div>

		</div>

	</body>
</html>