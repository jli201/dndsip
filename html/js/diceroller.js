//'open' and 'close' dice roller.
function openClose() {
	var debugflag = false;

	if ( $(".rollbox").hasClass("rollsmall") ) {
		if(debugflag) console.log("Small box.");
		$(".rollbox").removeClass("rollsmall").addClass("rollbig");
	}
	else if ( $(".rollbox").hasClass("rollbig") ) {
		if(debugflag) console.log("Big box.");
		$(".rollbox").removeClass("rollbig").addClass("rollsmall");
	}
	else {
		if(debugflag) console.log("Bad box.");
	}
}


function calculateRoll() {
	try {
		debugflag=false;

		var ndice = $('#ndice').val();
		var tdice = $('#tdice').val();
		var sign = $('#plusminus').val();
		var mod = $('#modval').val();

		//////// VALIDATE DATA ///////////////

		//Treating 'no input' as bad.
		//Different from '0'.
		if (ndice.length == 0 || tdice.length == 0 ) {
			if(debugflag) console.log("No dice type or number of dice.");
			throw("Bad dice input.");
		}

		if (mod.length == 0 ) {
			if(debugflag) console.log("No mod input. Setting to 0.");
			mod = 0;
		}

		if(debugflag) console.log("Rolling dice.");
		var sum = 0;
		for ( var i = 0; i < ndice; i++ ) {
			sum += Math.ceil(Math.random() * tdice);
		}

		//implicit cast as int, not string/char.
		if ( sign == '-' ) mod *= -1;
		else mod *= 1;
		sum += mod;

		if(debugflag) console.log("Final sum is " + sum);

		/////// PRINT RESULT /////////////////

		$('#resultdice').prop('readonly', false);
		$('#resultdice').html(sum);
		$('#resultdice').prop('readonly', true);

		//make dice logo change!
		$("#clickdie div").addClass("dicelogohollow");
		//less than 3 digits (usual case in d&d.)
		if (sum/100 < 1) {
			$("#clickdie div").removeClass("largevalue");
		}
		if (sum/100 > 1) { //looks good up to 5 digits
			$("#clickdie div").addClass("largevalue");
		}

		$("#clickdie div").html(sum);


	}
	catch(err) {
		$('#resultdice').text('ERR');
		if (debugflag) console.log(err); //tells us what the error is.
	}
		
}