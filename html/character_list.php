<?php

    session_start();


    //checking to see if a user is logged in
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


    /*
    When a button is clicked to use an exisiting character,
    get the characterID and pass it to the next page.

    When the user creates a new character, give that character
    the next available characterID and pass it to the next page.
    */
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $existingCharacter = parse_input($_POST['characterID']);
        $newCharacter = parse_input($_POST['newCharacterID']);
        if(strcmp($existingCharacter, "") == 0) {
            $characterID = $newCharacter + 1;
        } else {
            $characterID = $existingCharacter;
        }
        $_SESSION['characterID'] = $characterID;
        header("Location:character_sheet.php");
    }


    //establishing a connection to the database
    $conn = new mysqli($host, $dbuser, $dbpassword, $dbname);


    //finding all characters associated with a given username
    if (mysqli_connect_error()) {
        echo ("Unable to connect to database!");
    } else {
        $findCharacters = "SELECT * FROM BasicInfo WHERE username='$username';";
        $result = $conn->query($findCharacters);
    }


    /*
    Getting the last available characterID and incrementing it by one in case the
    user wants to make a new character.
    */
    $tempResult = $conn->query("SELECT characterID FROM BasicInfo ORDER BY characterID DESC LIMIT 1;");
    $temp = $tempResult->fetch_assoc();
    $lastCharacterID = ($temp['characterID']);


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
                    <form class='characterIDForm' method='post' action='".$_SERVER['PHP_SELF']."'>
            <input type='hidden' name='characterID' value='".$row['characterID']."'>
            <button class='characterSelectButton' type='submit'>></button>
        </form>
        <br>
                </div>
              </div>";
    }


    /*
    Purpose: Pareses input from forms to make it harder to hack us with SQL Injection Attacks
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

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="character_list.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <title>DNDSIP: Character Selection</title>
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


        //closing the database connection since we are done with it at this point
        $conn->close();
    ?>
        <div class="char_div">
            <div class="createChar">
                <form class="characterIDForm" method="post" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"]));?>">
                    <input type="hidden" name="newCharacterID" value="<?php echo($lastCharacterID);?>">
                    <button type="submit">Create Character</button>
                </form>
            </div>
        </div>

        <div class="heading_div">
                <h1 class="charHeadingBorder"> 
                     <a href="index.php"> DM Tools </a> 
                </h1>
        </div>

    </body>
</html>