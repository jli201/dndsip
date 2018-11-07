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

    <?php
        //for each row: do the contents inside the while loop
		//access the data in a particular column of a given row with $row['DATA_YOU_WANT']
		while($row = $result->fetch_assoc()) {

            //create the div for each character sheet and grab the respective values from the database
            echo "<div class='char_div'>
                    <div class='charSelectBorder'>
                        <div class='char_info'>
                            Level: <span class='numberCircle'> ".$row['level']." </span>
                        </div>
                        <div class='char_info'> Name: ".$row['characterName']."</div>
                        <div class='char_info'> Race: ".$row['race']."</div>
                        <div class='char_info'> Class: ".$row['class']."</div>
                        <br>
                    </div>
                  </div>";
			
        }
        $conn->close();
    ?>

        <!--This was for testing the divs before we had any data in our database, it is not needed anymore-->

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
