<?php

	session_start();

	$characterID = $_SESSION['characterID'];
	echo ($characterID);
	$host        = "localhost";
	$dbuser      = "mhypnaro";
	$dbpass      = "CMPS115rjullig";
	$dbname      = "dndsip";
	
	$conn = new mysqli($host, $dbuser, $dbpass, $dbname) or die("Unable to connect to db or select table.");

	$invData = getInvRow($conn, $characterID); //194 total.  charID + gold field + 96 items, 96 quantities (192). An array.
	pasteInvTable($invData);
	// var_dump($invData);


	//Gets the entire inventory row.
	function getInvRow ($conn, $characterID) {
	    $invQuery = "SELECT * FROM Inventory WHERE characterID='$characterID';";
	    $invResult = $conn->query($invQuery);
	    $invData = $invResult->fetch_assoc();
	    return $invData;
	}

	/* Pastes the inventory table into the column area.

	<tr>
    <td><input type="number" value="0" name="Item#Quantity" id="inv-num-#"></input></td>
    <td><input type="text" value="Item" name="Item#Description" id="inv-obj-#"></input></td>
	</tr>
	Ignoring ids because who cares. 
	TO VIEW: SELECT item1Quantity FROM Inventory WHERE characterID = 2;
	TO TEST: mysql> UPDATE Inventory SET item1Quantity = '1' WHERE characterID = 2;*/
	function pasteInvTable($invData) {
		$invPure = array_slice($invData, 2); //delete gold and character id.

		if ($invData['gold'] != NULL ) {
			echo '<tr><td colspan="2"><input type="text" placeholder="Gold!" value="';
			echo $invData['gold'];
			echo '" name="gold" id="inv-gold"></input></td></tr>';	
		}
		else {
			echo '<tr><td colspan="2"><input type="text" placeholder="Gold!" name="gold" id="inv-gold"></input></td></tr>';
		}
		echo '<tr><td>#</td><td>Item</td></tr>';

		$i = 1;
		foreach($invPure as $key => $value ) {
			if ($value == NULL ) { //print out col value.
				$i++;
				continue;
			}
			if (($i % 2) == 1) { //quantity
				// echo '<tr><td>HELLO</td></tr>';
				echo "<tr><td><input type='number' value='$value' name='$key'></td>";
			}
			else { //description
				// echo '<tr><td>HELLO</td></tr>';
				echo "<td><input type='text' value='$value' name='$key'></td></tr>";
			}
			$i++; 
		}
	}

?>