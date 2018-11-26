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
                            '<td><input name = "weapon' + numRows + 'Name" type = "wepColGeneral"></td>'+
                            '<td><input name = "weapon' + numRows + 'AttackBonus" type = "wepColGeneral"></td>'+
                            '<td><input name = "weapon' + numRows + 'Damage" type = "wepColGeneral"></td>'+
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
                            '<td><input name = "spell' + numRows + 'Name" type = "spellColGeneral"></td>'+
                            '<td><input name = "spell' + numRows + 'Level" type = "spellColMiddle"></td>'+
                            '<td><input name = "spell' + numRows + 'Description" type = "spellColGeneral"></td>'+
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
    <td><input type="number" value="0" name="Item#Quantity" id="inv-num-#"></input></td>
    <td><input type="text" value="Item" name="Item#Description" id="inv-obj-#"></input></td>
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
        + 'Quantity" id="inv-num-' + numRows
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

///////////////////////////////////////////////
/////// UPDATE MOD VALUES           ///////////
///////////////////////////////////////////////


//populate one score
function populateOneScore (scoreID, modID) {
    var score = $('#' + scoreID).val();
    var mod;
    if ( score.length == 0 ) { //value unset
        $('#' + modID).html("-");
    }
    else if (isNaN(score) ) { //somehow not a #
        $('#' + modID).html("-");
    }
    else {
        mod = Math.floor((score-10)/2); //Javascript doesn't have int division
        $('#' + modID).html(mod);
    }
}

//https://www.kirupa.com/html5/handling_events_for_many_elements.htm
$(document).ready(function() {
    
    //stat scores
    // statBoxParent.addEventListener("change", handleStatChange, false);
    $('#statsBoxFormat').on('keyup', handleStatChange);

    //saving throws
    $('#ST-form').on('change', handleSavingThrowChange);
    // $('#ST-form').on('keyup', handleSavingThrowChange);

    //skills
    $('#proficiency').on('change', handleProficiencyChange);
    $('#skillsList').on('change', handleSkillProficiencyCheckBoxChange);


    //inventory.
    console.log("Hello1.");
    $('#inventory-table tbody').load("loadinv.php");


});


function handleStatChange(e) {
    if (e.target != e.currentTarget ) {
        var score = e.target.id;
        // console.log(score + " is changing.");
        var shortform = score.substring(0, 3);
        var mod = shortform + "Mod";
        populateOneScore(score, mod);

        //assumes checkbox ids are 'strCheckbox', 'dexCheckbox', etc.
        populateOneSavingThrow(shortform, shortform + "Checkbox");

        if(skillHandler.manualCalculation == false){
            populateOneSkillCatagory(shortform + "Mod", shortform + "Skill");
        }
    }
    e.stopPropagation();
}

function getThrowFromShortform (shortform) {
    var inputName;
    switch(shortform) {
        case "str":
            inputName = "strengthSavingThrow";
            break;
        case "dex":
            inputName = "dexteritySavingThrow";
            break;
        case "con":
            inputName = "constitutionSavingThrow";
            break;
        case "int":
            inputName = "intelligenceSavingThrow";
            break;
        case "wis":
            inputName = "wisdomSavingThrow";
            break;
        case "cha":
            inputName = "charismaSavingThrow";
            break;
        default:
            inputName = "BadName."
            console.log('Unknown case.');
    }
    return inputName;

}

function handleProficiencyChange(e){
    var i;
    for(i = 0; i < skillHandler.classTags.length; i++){
		
        var shortform = skillHandler.classTags[i].substring(0,3);
        console.log("Stat being changed: " + shortform);
        //assumes checkbox ids are 'strCheckbox', 'dexCheckbox', etc.
        populateOneSavingThrow(shortform, shortform + "Checkbox");
		
		
        if(skillHandler.manualCalculation == false){
            populateOneSkillCatagory(shortform + "Mod", shortform + "Skill");
        }
		
    }
}

//triggered by checkbox click
function handleSavingThrowChange(e) {
    if (e.target != e.currentTarget ) {
        //find out if the triggering object is checkbox or number input
        var type = $('#' + e.target.id).attr('type');
        if (type != 'checkbox' ) {
            return; //do nothing if you trigger a non-checkbox change
        }
        var shortform = (e.target.id).substring(0,3);
        
        populateOneSavingThrow(shortform, e.target.id);
    }
    e.stopPropagation();
}

function populateOneSavingThrow (shortform, checkboxID) {
    var modID = shortform + "Mod";
    var inputID = getThrowFromShortform(shortform);

    var total = ($('#' + modID).html());
        if (isNaN(total)) {
            $('#' + inputID).val('-0');
            return;
        }
        total *= 1; //parse as int
        // console.log(total);
        if ( $('#' + checkboxID).prop('checked') ) {
            var prof = $('#proficiency').val();
            // console.log('prof ' + prof );
            if (prof.length == 0 ) { prof = 0; }
            else prof *= 1;
            total += prof;
        }
        // console.log(total);
        $('#' + inputID).val(total);

}

//Skills and Proficiencies

//This is to make the skill sheet readOnly by default
window.onload = changeSkillInputFeildsWritability;

//This object will carry any variables we need to handle skill changes
var skillHandler = {

    //A list of all skill input box id's
    skills: ["acrobatics","animal","arcana","athletics","deception",
        "history","insight","intimidation","investigation","medicine",
        "nature","perception","performance","persuasion","religion",
        "sleight", "stealth", "survival"],
    
    //checks if manual calculation is enabled or not
    manualCalculation: false,

    //Class tags used in html to determine what stat is associated with a skill
    classTags: ["strSkill","dexSkill","conSkill","intSkill","wisSkill","chaSkill"],

    //Stat tags used for looping through all stats when needed
    statShorthands: ["str","dex","con","int","wis","cha"],
}

//swaps skill calcuation from automatic to manual and vice versa
function switchManualCalculation(){
    skillHandler.manualCalculation = !skillHandler.manualCalculation;
}

function changeSkillInputFeildsWritability() {
    if (skillHandler.manualCalculation == false) {
        for(i = 0; i < skillHandler.skills.length; i++) {
            document.getElementById(skillHandler.skills[i]).readOnly = true;
        }
    }else{
        for(i = 0; i < skillHandler.skills.length; i++) {
            document.getElementById(skillHandler.skills[i]).readOnly = false;
        }
    }
}

function handleSkillProficiencyCheckBoxChange(e) {
    if (e.target != e.currentTarget ) {
        //find out if the triggering object is checkbox or number input
        var type = $('#' + e.target.id).attr('type');
        if (type != 'checkbox' ) {
            return; //do nothing if you trigger a non-checkbox change
        }

        //make a new string to get the skill name so we can check the input boxes
        var skillString = (e.target.id);

        //8 is the number of characters there are in "Checkbox" and we need to trim that to get the skill name
        skillString =  skillString.substring(0, skillString.length - 8);
        
        //now we've found the input box associated with this checkbox
        var skill = $('#' + skillString);

        //Figure out what stat is associated with this skill and assign the first 3 letters to shortform
        var shortform = "";
        for(i = 0; i < skillHandler.classTags.length; i++){
            if(skill.hasClass(skillHandler.classTags[i])){
                shortform = skillHandler.classTags[i].substring(0,3);
            }
        }

        //If for any reason the above didn't populate shortform, we abort 
        if (shortform == ""){
            return;
        }
        //finally, we call populateOneSkillCatagory again to update the results
        if(skillHandler.manualCalculation == false){
           populateOneSkillCatagory(shortform + "Mod", shortform + "Skill");
        }
    }
    e.stopPropagation();
}

function populateOneSkillCatagory(modID, skillID) {
	var i;
    for(i = 0; i < skillHandler.skills.length; i++){

        //Calculate base modifier of skill based on Score mod
        var skillMod = ($('#' + modID).html());
		if (isNaN(skillMod) ) {
			console.log(skillMod + " not set.");
			continue;
		}

        //Change skillMod to integer
        skillMod *= 1;

        //jQuery for all html elements with id's listed as one of the skills in the skillHandler
        var skill = $('#' + skillHandler.skills[i]);

        //Make sure we're only bothering to look at a skill with the right stat associated with it
        if(skill.hasClass(skillID)){

            //jQuery for all html elements with id's listed as being a skill checkbox
            var skillCheckbox = $('#' + skillHandler.skills[i] + "Checkbox");
            if (skillCheckbox.prop('checked')){
                var prof = $('#proficiency').val();
                // console.log('prof ' + prof );
                if (prof.length == 0 ) { prof = 0; }
                else prof *= 1;
                skillMod += prof;
            }

            //set input box value to mod
            skill.val(skillMod);
        }
    }

    /*if ( $('#' + "acrobaticsCheckbox").prop('checked') ) {
        var prof = $('#proficiency').val();
        if (prof.length == 0 ) { prof = 0; }
        else prof *= 1;
        skillMod += prof;
    }*/

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
    if (!validEscape) {
        callUnloadEvent();
    }
});

//requires form id is 'characterSheet'
function callUnloadEvent () {
    console.log("Invalid unload event. Submitting form.");
    $('#characterSheet').submit(); //submit the form
}

