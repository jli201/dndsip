var editor = new Editor({
    element: document.getElementById("myTextArea")
});

$(document).ready(function() {
	console.log("Welcome to DM Tools!");

	// Load text editor.
	editor.render();
});


// CLASS CREATION

//https://www.geeksforgeeks.org/implementation-priority-queue-javascript/
//Created with reference to the above. But seriously anyone who passed 101 can make a pqueue.
class TurnElement {
	constructor(cname, roll, ally) {
		this.cname = cname; //character name
		this.roll = Number(roll); //character roll - use Number() to make comparisons num based, not string alpha based
		this.ally = ally; //friend or foe?
	}
}

// class functions should be agnostic of dom.
class TurnOrder {

	constructor() {
		this.turns = []; //contains turns
	}

	// Helper functions.

	// ENQUEUE, DEQUEUE, FRONT, ISEMPTY, DUMPQUEUE

	// ENQUEUE - rolls are the priority value
	enqueue(cname, roll, ally) {
		var turn = new TurnElement(cname, roll, ally);

		//simple insertion sort
		var i;
		for (i = 0; i < this.turns.length; i++ ) {
			if (this.turns[i].roll < turn.roll) {
				this.turns.splice(i, 0, turn); //index, # items to remove, any # of args to add 
				return;
			}
		}

		this.turns.push(turn); //if turn.roll is ALWAYS smaller than all others, add to back

	}

	dequeue() {
		if (this.isEmpty()) {
			return "Turn list empty.";
		}
		return this.turns.shift(); //pop removes 'top' ie. as stack.

	}

	//delete the element that clicked its delete button
	//https://www.w3schools.com/jsref/jsref_splice.asp - splice.
	// ally status doesn't matter
	findDelete(cname, roll, ally) {
		var i;
		for (i = 0; i < this.turns.length; i++ ) {
			if (cname == this.turns[i].cname) {
				if (roll == this.turns[i].roll && ally == this.turns[i].ally) {
					this.turns.splice(i, 1); //delete that element
					return true; //you done, all 3 match (if you return 'i', treated as 'false' if i = 0)
				}
			}
		}
		return false; //you didn't find the specified pair.
	}

	front () {
		if (this.isEmpty()) {
			return "Turn list empty.";
		}
		return this.turns[0];
	}

	isEmpty () {
		return this.turns.length == 0; //true if 0, false otherwise
	}


	// PRINT 
	dumpQueue () {
		var str = "";
		var i;
		for (i = 0; i < this.turns.length; i++ ) {
			str += "(" + this.turns[i].cname + ": " 
				+ this.turns[i].roll;
				if (this.turns[i].ally) str += " <ally>";
				else str += " <enemy>";
				str += ") ";
		}
		// console.log(str);
		return str;
	}

	//returns queue to external. breaks separation.
	returnQueue () {
		return this.turns;
	}

}

/////// END CLASS SPEC ///////

// Functions for interaction with queue.

function addTurn() {
	var cname = $('#initNewTurnName').val();
	var roll = $('#initNewTurnRoll').val();
	var ally = !($('#initNewTurnEnemy').prop("checked"));

	// console.log(cname + " " + roll + " " + ally);
	if (cname.length == 0 || roll.length == 0 ) { //values not entered
		console.log("Some values not inputted.");
		return;
	}

	turnList.enqueue(cname, roll, ally);
	// console.log(turnList.dumpQueue());

	pasteOrder();
}

//called with an html element
function removeTurn(element) {
	console.log(element);
	var html = element;
	var cname, roll, ally;
	var children = html.children;
	//first, get the values of this element.
	//https://www.w3schools.com/jsref/dom_obj_all.asp
	// console.log(children[0].innerHTML);
	cname = children[0].innerHTML;
	// console.log(children[1].innerHTML);
	roll = children[1].innerHTML;
	roll = Number(roll);
	if (isNaN(roll)) {
		console.log ("roll value not a number.");
		return false;
	}
	// console.log(html.getAttribute("ally"));
	ally = html.getAttribute("ally");
	ally = ally == "true" ? true : false; //convert to boolean


	// console.log("Trying to delete " + cname + " with roll " + roll + " and ally status " + ally);
	//then, remove this from the queue.
	var result = turnList.findDelete(cname, roll, ally);
	if (result == false) {
		console.log("findDelete didn't find value.");
	} 

	//then reprint queue
	pasteOrder();

	// console.log(turnList.dumpQueue());

}


// re-sort DOM after making an adjustment.
function pasteOrder() {
	// console.log("Sorting.");
	deleteAllTurns();
	var i;
	var list = turnList.returnQueue();
	for (i = 0; i < list.length; i++ ) {
		$('#initTurnOrder').append(createTurnHTML(
			list[i].cname, list[i].roll, list[i].ally));
	}
}

// Creates one turn html
/*<div class="turn" ally="true">
	<div class="turnChName">Character Name</div>
	<div class="turnRoll">Roll</div>
	<div class="deleteTurnButton" onclick="removeTurn(this.parentNode)">-</div>
</div>
*/
function createTurnHTML (cname, roll, ally) {
	var htmlstr = '<div class="turn" ally="' + ally;
	htmlstr += '"><div class="turnChName">' + cname;
	htmlstr += '</div><div class="turnRoll">'+ roll;
	htmlstr += '</div><div class="deleteTurnButton" onclick="removeTurn(this.parentNode)">-</div></div>';
	return htmlstr;
}

// DOM only - deletes all turns
function deleteAllTurns () {
	// console.log("Clearing all turns");
	($('.turn').slice(1)).remove();
}

//moves turn to back.
function nextTurn () {
	var html = $('.turn').slice(1);
	// console.log(html[0]);
	var elem = html[0];
	// console.log(elem.outerHTML);
	$('#initTurnOrder').append(elem.outerHTML);
	elem.remove();
}

// VARIABLE DECLARATIONS

turnList = new TurnOrder();


// Put other stuff below this?