$(document).ready(function() {
	console.log("Welcome to DM Tools!");
});


// CLASS CREATION

//https://www.geeksforgeeks.org/implementation-priority-queue-javascript/
//Created with reference to the above. But seriously anyone who passed 101 can make a pqueue.
class TurnElement {
	constructor(name, roll) {
		this.cname = cname; //character name
		this.roll = roll; //character roll
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
	enqueue(cname, roll) {
		var turn = new TurnElement(cname, roll);

		//simple insertion sort
		var i;
		for (i = 0; i < this.turns.length; i++ ) {
			if (this.turns[i].roll < turn.roll) {
				this.turns.splice(i, 0, turn); //index, # items to remove, any # of args to add 
			}
		}

	}

	dequeue() {
		if (this.isEmpty()) {
			return "Turn list empty.";
		}
		return this.turns.shift(); //pop removes 'top' ie. as stack.

	}

	//delete the element that clicked its delete button
	//https://www.w3schools.com/jsref/jsref_splice.asp - splice.
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
				+ this.turns[i].roll + ") ";
		}
		// console.log(str);
		return str;
	}

}

// Functions for interaction with queue.

function addTurn() {
	// var cname = 
}




// re-sort DOM after making an adjustment.
function sort() {
	console.log("Sorting.");
}

// VARIABLE DECLARATIONS

turnList = new TurnOrder();


// Put other stuff below this?