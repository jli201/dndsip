//


//'open' and 'close' dice roller.
function openClose() {
	;
}



//calculates roll based on <num> 'd' <dicetype> + <mod>
//individual rolls calculated via Math.random
function calculateRoll() {
	var debugflag = false; //turn this on to debug!
	if (debugflag) console.log("Calculating roll.");
	try {
		var dice = parseInt($('#tdice').val()); //'value', not inner html
		if (debugflag) console.log("Dice type = " + dice);


		//things to catch.
		//1. is the textarea empty? We should treat this as 0.
		//2. Is the text area not a number? We should throw an error.

		var num = $('#ndice').val(); //inner html b/c text area
		//Case 1.
		if (num.length == 0 ) { //typeof b/c if num dne, doesn't throw an error
			if (debugflag) console.log('no dice val entered');
			$('#resultdice').text('0');
			return;
		} //clears case of empty text box "" value
		//Case 2.
		if (isNaN(num)) { //can't parse int
			if (debugflag) console.log('ParseInt failed.');
			throw("Bad num dice.");
		}
		//Clears test cases "a", "12a", "efc", "12 ", and "12   3"
		//"12 " is 12, "12   3" is NaN (intended).

		//b/c we call isNaN before ParseInt, we guarantee an int is being sent, not a gibberish string.
		num = parseInt(num);
		//ParseInt takes a string and returns the first num.
		//So if your string is "12abef" it returns 12.
		if (debugflag) console.log("Num dice = " + num);

		var sum = 0;
		for (var i = 0; i < num; i++ ) {
			if (debugflag) console.log('Rolling 1 die.');
			sum += Math.ceil(Math.random() * dice); //should return 1, 2, ..., dice integer.
		}
		if (debugflag) console.log("Sum is " + sum);

		//use editing guards.
		//Why? B/c a user who edits the 'textarea' result line causes a bug
		//This bug prevents the new value from displaying on screen, even if it's in the actual html
		//e.g. it can be <textarea>3</textarea> but on screen 3 will not show up!
		$('#resultdice').prop('readonly', false);
		$('#resultdice').html(sum);
		$('#resultdice').prop('readonly', true);
		
	}

	catch(err) {
		$('#resultdice').text('ERR');
		if (debugflag) console.log(err); //tells us what the error is.
	}

}