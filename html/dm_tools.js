var editor = new Editor({
    element: document.getElementById("dmNotes")
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
/* FUNCTIONS
enqueue - adds a TurnElement to queue, priority highest roll.
	requires cname, roll, ally

dequeue - removes the front-most element of queue, returns fail string if empty queue.

findDelete - removes a TurnElement from queue.
	requires cname, roll, ally

findIndex - gets index of a TurnElement from queue (like 'find')
	requires cname, roll, ally

front - returns front TurnElement in queue, returns fail string if empty.

isEmpty - returns true/false boolean based on if queue is empty

size - returns size of internal queue (# of elements)

dumpQueue - returns a string-based representation of the internal queue
	Each element is formatted as "(CHARACTER NAME: ROLLVALUE <ALLY/ENEMY>)"

returnQueue - returns the internal queue.

*/
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

	//same as finddelete, but no delete & returns index, -1 on fail (instead of false)
	findIndex(cname, roll, ally) {
		var i;
		for (i = 0; i < this.turns.length; i++ ) {
			if (cname == this.turns[i].cname) {
				if (roll == this.turns[i].roll && ally == this.turns[i].ally) {
					return i; //you done, all 3 match (if you return 'i', treated as 'false' if i = 0)
				}
			}
		}
		return -1; //you didn't find the specified pair.
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

	size() {
		return this.turns.length;
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

	// focus on char name for next character
	$('#initNewTurnName').focus();
}

//get the cname, roll, and ally value of the 1st turn.
//if fail (no 1st turn), return "false" instead of object
//if pass, return TurnElement object.
function getCurrentTurn() {
	if (turnList.isEmpty()) {
		console.log("Empty queue, trying to get 1st turn of nothing.");
		return false;
	}

	var element = $('.turn')[0];
	// console.log(element);
	var turn = parseTurn(element);
	if (turn == false) {
		return false;
	}
	return turn;

}

//returns cname, roll, ally off an element as an obj.
//assumes element exists. up to calling function.
function parseTurn(element) {
	var cname, roll, ally;
	var children = element.children;
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
	ally = element.getAttribute("ally");
	ally = ally == "true" ? true : false; //convert to boolean

	// return an object
	return {
		cname: cname,
		roll: roll,
		ally: ally
	};

}

//called with an html element
function removeTurn(element) {
	// console.log(element);
	//get values for this element.
	var turn = parseTurn(element); //returns cname, roll, ally in an obj
	if (turn == false) {
		return false; //parseturn failed.
	}
	
	//then, remove this from the queue.
	var result = turnList.findDelete(turn.cname, turn.roll, turn.ally);
	if (result == false) {
		console.log("findDelete didn't find value.");
	}

	//then reprint queue
	pasteOrder();

	// console.log(turnList.dumpQueue());

}


// re-sort DOM after making an adjustment.
function pasteOrder(index = 0) {
	// console.log("Sorting.");
	deleteAllTurns();
	var i;
	var list = turnList.returnQueue();
	var size = turnList.size(); //same as list.length;
	if (size == 0) {
		return; //no turns.
	}
	$('#initCurrentTurnText').after(createTurnHTML(
		list[0].cname, list[0].roll, list[0].ally));

	if (size < 2) {
		return;
	}

	for (i = 1; i < list.length; i++ ) {
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
	$('.turn').remove();
}

//moves turn to back.
function nextTurn () {
	if (turnList.size() <= 1 ) {
		return; //you don't need to do anything if you only have 1 turn
	}
	//move the top element to the bottom.
	//move the 2nd element into 'current turn' space.

	//move top element to bottom
	var html = $('.turn');
	// console.log(html[0]);
	var elem = html[0];
	// console.log(elem.outerHTML);
	$('#initTurnOrder').append(elem.outerHTML);
	elem.remove();

	//move new 'top' element to top.
	var elem = html[1];
	$('#initCurrentTurnText').after(elem.outerHTML);
	elem.remove();

}

// VARIABLE DECLARATIONS

turnList = new TurnOrder();


// Put other stuff below this?