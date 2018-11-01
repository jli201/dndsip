function addRow() {
    var table = document.getElementById("weaponTable");
    var row = table.insertRow(table.rows.length);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var box1 = document.createElement("INPUT");
    	box1.setAttribute("type", "text");
    var box2 = document.createElement("INPUT");
    	box2.setAttribute("type", "text");
    var box3 = document.createElement("INPUT");
    	box3.setAttribute("type", "text");
    cell1.appendChild(box1);
    cell2.appendChild(box2);
    cell3.appendChild(box3);
}
function deleteRow() {
	var table = document.getElementById("myTable");
    if(table.rows.length > 2){
    	table.deleteRow(table.rows.length - 1);
    }
}


function addProfsLanguages(){
    var li = document.createElement("li");  
    var input = document.getElementById("addProfLanguagesArea");
    li.innerHTML = input.value;
    input.value = "";

    document.getElementById("ProfsLanguages").appendChild(li);
}

/* 
There are always at minimum two rows:
A 'gold' row and the 'header' row. Don't delete those!
Inventory Table Entry Format:
<tr>
    <td><input type="number" value="0" id="inv-num-#"></input></td>
    <td><input type="text" value="Item" id="inv-obj-#"></input></td>
</tr> */
function addInvRow() {
    var debug = false;
    
    // Get number of rows so we can append a proper id.
    var table = $('#inventory-table');
    var numRows = table[0].rows.length;
    if (debug) console.log("Adding inventory row.");
    if (debug) console.log("Num rows is " + numRows);

    // sanity check
    if (numRows > 1000 ) {
        if (debug) console.log("You don't need 1000+ inventory rows. Stop that.");
        return;
    }

    // CREATE MARKDOWN 
    // Remember, row 3 is the 1st numbered row. (only 2 rows = adding 1st row)
    numRows -= 1;

    // See table entry format in comments before function
    var markdown = '<tr><td><input type="number" value="0" id="inv-num-' + numRows
        + '"></input></td><td><input type="text" value="Item" id="inv-obj-' 
        + numRows + '"></input></td></tr>';

    // We will always have a tbody, because we have 2 default rows!
    // HTML adds a tbody if there is at least one tr, doesn't need to be explicit
    $('#inventory-table tbody').append(markdown);
    if (debug) console.log("Adding row " + numRows + " to table.");

    //Then focus on the newest # column's input.
    $('#inventory-table tr:last td:first input').focus();
}

// Deletes a row in the inventory table, does not delete top 2 rows.
function delInvRow() {
    var debug = false;

    // Determine whether # of rows is enough to del.
    var table = $('#inventory-table');
    var numRows = table[0].rows.length;
    if (debug) console.log("Deleting inventory row.");
    if (debug) console.log("Num rows is " + numRows);

    if (numRows <= 2 ) {
        if (debug) console.log("No rows to delete.");
        return;
    }

    $('#inventory-table tr:last').remove();

}