$(document).ready(function() {
	console.log("Welcome to DM Tools!");
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
	findDelete(cname, roll) {
		var i;
		for (i = 0; i < this.turns.length; i++ ) {
			if (cname == this.turns[i].cname) {
				if (roll == this.turns[i].roll) {
					this.turns.splice(i, 1); //delete that element
					return i; //you done
				} //else continue if only char name matches
				//(ie if you have Goblin and Goblin with rolls of 12 and 19, this will fix that case) 
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
	console.log(turnList.dumpQueue());

	pasteOrder();
}




// re-sort DOM after making an adjustment.
function pasteOrder() {
	console.log("Sorting.");
	deleteAllTurns();
	var i;
	var list = turnList.returnQueue();
	for (i = 0; i < list.length; i++ ) {
		$('#initTurnOrder').append(createTurnHTML(
			list[i].cname, list[i].roll, list[i].ally));
	}
}

// DOM only
function deleteAllTurns () {
	console.log("Clearing all turns");
	($('.turn').slice(1)).remove();
}

/*<div class="turn" ally="true">
	<div class="turnChName">Character Name</div>
	<div class="turnRoll">Roll</div>
	<div class="deleteTurnButton">-</div>
</div>
*/
function createTurnHTML (cname, roll, ally) {
	var htmlstr = '<div class="turn" ally="' + ally;
	htmlstr += '"><div class="turnChName">' + cname;
	htmlstr += '</div><div class="turnRoll">'+ roll;
	htmlstr += '</div><div class="deleteTurnButton">-</div></div>';
	return htmlstr;
}

// VARIABLE DECLARATIONS

turnList = new TurnOrder();


// Put other stuff below this?