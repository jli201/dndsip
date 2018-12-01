<?php
	session_start();
    
    //checking to see if a user is logged in
	$username = "";
    if($_SESSION["user"]) {
        $username = $_SESSION["user"];
    } else {
        $_SESSION["notLoggedIn"] = True;
        header("Location: index.php");
    }

    //establishing a connection to the database
    $host = "localhost";
    $dbuser = "mhypnaro";
    $dbpassword = "CMPS115rjullig";
    $dbname = "dndsip";
    $conn = new mysqli($host, $dbuser, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        echo ("Unable to connect to database!");
    }
	else {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			putdmNotes($username, $conn);

			//if we hit the "Characters" button
			if(isset($_POST['backToCharacters'])) {
				header("Location: character_list.php");
			
			//if we hit the "Logout" button
			} elseif(isset($_POST['logout'])) {
				header("Location: logout.php");
			}
		}

		// loading saved data
		$dmNotes = getdmNotes($username);
    }



    function getdmNotes($username, $conn) {
    	$dmNotesQuery = "SELECT * FROM DMNotes WHERE username='$username';";
    	$dmNotesResult = $conn->query($dmNotesQuery);
    	$dmNotes = $dmNotesResult->fetch_assoc();

    	return $dmNotes;
    }

    function putdmNotes($username, $conn) {
    	$updatedDmNotes = $_POST['dmNotes'];
		$updateDmNotesQuery = "UPDATE DMNotes SET DMNotes='$updatedDmNotes' where username='$username';";

		$conn->query($updateDmNotesQuery);
    }

    $conn->close();
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
		<!-- https://github.com/lepture/editor -->
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
		<form id="dmNotesForm" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<!-- placeholder to load dice roller -->
		<div id="diceroller"></div>
		<div id="dmtoolsHeader">
			<div class="buttonholder">
				<button type="submit" class="navbutton" name="save" > Save </button>
				<button type="submit" class="navbutton" name="backToCharacters"> Characters </button>
				<button type="submit" class="navbutton" name="logout"> Logout </button>
			</div>
			<div id="pagetitle">DM TOOLS</div>
		</div>

		<!-- INIT TRACKER -->
		<div id="initTrackerWrapper" class="column">
			<div id="initHeader">
				<span id="initTrackerName">INIT TRACKER</span>
				<input type="button" id="initNextTurn" value="Next Turn >" onClick="nextTurn()">
			</div>

			<div id="initTurnOrder">
				<div id="initCurrentTurnText" class="turnlabel">CURRENT TURN:</div>
				<!-- <div class="turn" ally="true">
					<div class="turnChName">Character Name</div>
					<div class="turnRoll">Roll</div>
					<div class="deleteTurnButton">-</div>
				</div> -->
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
				<textarea class="codemirror-textarea" id="dmNotes" name="dmNotes"><?php echo($dmNotes['DMNotes']);?></textarea>
			</div>
		</div>
		</form>
	</body>
</html>