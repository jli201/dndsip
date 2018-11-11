<?php
	session_start();
	$username = "";
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
	} else {
		$findCharacters = "select * from BasicInfo where username='$username';";
		$result = $conn->query($findCharacters);
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="character_list.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <title>Character List/Selection</title>

    <script>
        $(document).ready(function() {
            $('.charSelectBorder').click(function() {
                $(this).toggleClass('charSelectBorderClicked');
                });
            });
    </script>

    </head>

    <body>
        <div id="logout">
            <a href="logout.php">Logout</a>
        </div>
        <div class="heading_div">
            <h1 class="charHeadingBorder"> Characters:</h1>
        </div>

    <!-- php to generate each character in the list -->
    <?php
        //for each row: create a div which displays info about the character
        $characterNumber = 0;
        while($row = $result->fetch_assoc()) {
                $characterNumber = ++$characterNumber;
                createDiv($characterNumber, $username, $row);
            }
        $conn->close();


        /*
        Purpose: Creates unique divs for each of the user's characters
        Params:
            -characterNumber: used to modify the name attribute of each character's details
            -username: used to modify the name attribute of each character's details
            -row: the row of the database which contains the info for a given character (iterated over by a calling loop)
        Returns: Nothing
        */
        function createDiv($characterNumber, $username, $row) {
            //echos a div onto the actual DOM
            echo "<div class='char_div'>
                    <div class='charSelectBorder'>
                        <div name='".$username."level".$characterNumber."' class='char_info'>
                            Level: <span class='numberCircle'> ".$row['level']." </span>
                        </div>
                        <div name='".$username."charName".$characterNumber."' class='char_info'> Name: ".$row['characterName']."</div>
                        <div name='".$username."race".$characterNumber."' class='char_info'> Race: ".$row['race']."</div>
                        <div name='".$username."class".$characterNumber."' class='char_info'> Class: ".$row['class']."</div>
                        <br>
                    </div>
                  </div>";
        }
    ?>

        <!--This was for testing the divs before we had any data in our database, it is not needed anymore.
            Leaving it here incase I need to refer to it again-->

        <!-- <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob</div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div>
        <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob </div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div>
        <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob </div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div>
        <div class="char_div">
            <div class="charSelectBorder">
                <div class="char_info">
                    Level:  <span class="numberCircle">13</span>
                </div>
                <div class="char_info"> Name: Bob </div>
                <div class="char_info"> Race: Elf</div>
                <div class="char_info"> Class: Mage</div>
               <br>
            </div>
        </div> -->
        <!--This was for testing the divs before we had any data in our database, it is not needed anymore
        Leaving it here incase I need to refer to it again-->

        <div class="char_div">
            <div class="createChar">
                + Create
            </div>
        </div>

        <div class="heading_div">
                <h1 class="charHeadingBorder"> 
                     <a href="index.php"> DM Tools </a> 
                </h1>
        </div>

    </body>
</html>
