/* Example of weapon table element
    <tr>
        <td><input name = "weapon#Name varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
        <td><input name = "weapon#AttackBonus varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
        <td><input name = "weapon#Damage varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
    </tr>
*/
function weaponTableAddRow(){
    var table = $('#weaponTable');

    /*Since we want our weapons to span from 1-64, we add 1 to the numRows */
    var numRows = table[0].rows.length + 1;

    /*Only add rows if we are under 65 total rows, since we add 1 to the row number, we can make this limit 65*/
    if(numRows < 65){
        var markdown = '<tr>'+
                            '<td><input name = "weapon' + numRows + 'Name varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>'+
                            '<td><input name = "weapon' + numRows + 'AttackBonus varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>'+
                            '<td><input name = "weapon' + numRows + 'Damage varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>'+
                        '</tr>';
        $('#weaponTable tbody').append(markdown);
        $('#weaponTable tr:last td:first input').focus();
    }
}

function weaponTableDeleteRow(){
    var table = $('#weaponTable');
    var numRows = table[0].rows.length;

    /*We always want at least 1 row in the table*/
    if(numRows > 1){
        $('#weaponTable tr:last').remove();
    }
}

/*
    Spell Table format
    <tr>
        <td><input name = "spell#Name varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>
        <td><input name = "spell#Level varchar(255)" type = "number" style = "max-width: 47%; text-align: center;"></td>
        <td><input name = "spell#Description text" type = "text" style = "max-width: 85%; text-align: center;"></td>
    </tr>
*/

function spellTableAddRow() {
    var table = $('#spellTable');

    /*Since we want our spells to span from 1-64, we add 1 to the numRows */
    var numRows = table[0].rows.length + 1;

    /*Only add rows if we are under 65 total rows, since we add 1 to the row number, we can make this limit 65*/
    if(numRows < 65){
        var markdown = '<tr>'+
                            '<td><input name = "spell' + numRows + 'Name varchar(255)" type = "text" style = "max-width: 85%; text-align: center;"></td>'+
                            '<td><input name = "spell' + numRows + 'Level varchar(255)" type = "number" style = "max-width: 47%; text-align: center;"></td>'+
                            '<td><input name = "spell' + numRows + 'Description text" type = "text" style = "max-width: 85%; text-align: center;"></td>'+
                        '</tr>';
        $('#spellTable tbody').append(markdown);
        $('#spellTable tr:last td:first input').focus();
    }
}
function spellTableDeleteRow(){
    var table = $('#spellTable');
    var numRows = table[0].rows.length;

    /*We always want at least 1 row in the table*/
    if(numRows > 1){
        $('#spellTable tr:last').remove();
    }
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

    // CREATE MARKDOWN 
    // Remember, row 3 is the 1st numbered row. (only 2 rows = adding 1st row)
    numRows -= 1;

    // sanity check
    if (numRows > 96 ) {
        if (debug) console.log("Only 96 inventory items allowed.");
        return;
    }

    // See table entry format in comments before function
    var markdown = '<tr><td><input type="number" value="0" name="Item' + numRows 
        + 'Name" id="inv-num-' + numRows
        + '"></input></td><td><input type="text" value="Item" name="Item' + numRows
        + 'Description" id="inv-obj-' + numRows + '"></input></td></tr>';

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

////////////////////////////////////////////
////////   ON NAVIGATE AWAY   //////////////
////////////////////////////////////////////
//https://www.oodlestechnologies.com/blogs/Capture-Browser-Or-Tab-Close-Event-Jquery-Javascript
//https://eureka.ykyuen.info/2011/02/22/jquery-javascript-capture-the-browser-or-tab-closed-event/

//Note that browsers prevent alert, confirm, or prompt fxns on this event.
//https://developer.mozilla.org/en-US/docs/Web/Events/beforeunload
var validEscape = false;

function addValidUnloadEvents () {
    //add special cases here
    //e.g. if you hit refresh and you want to save, add:
    /*$(document).on('keypress', function(e) {
        if (e.keyCode == 116){ //F5
            validNavigation = true;
        }
    });*/

}

//when the document loads, add all event triggers
$(document).ready(function() {
    addValidUnloadEvents();
});

//https://api.jquery.com/unload/
$(window).on("beforeunload", function() {
    console.log("Bye!")
    if (validEscape) {
        callUnloadEvent();
    }
});

function callUnloadEvent () {
    console.log("Valid unload event.");
}