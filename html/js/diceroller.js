//'open' and 'close' dice roller.
function openClose() {
	var debugflag = false;

	if ( $(".rollbox").hasClass("rollboxCompact") ) {
		if(debugflag) console.log("Small box going big.");
		$(".rollbox").removeClass("rollboxCompact")
		$("#diceroller").css("width", "495px");
	}
	else {
		if(debugflag) console.log("Big box going small.");
		$(".rollbox").addClass("rollboxCompact");
		$("#diceroller").css("width", "60px");
	}
}


function calculateRoll() {
	try {
		debugflag=false;

		var ndice = $('#numdice').val();
		var tdice = $('#typedice').val();
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

		$('#rollResult').prop('readonly', false);
		$('#rollResult').html(sum);
		$('#rollResult').prop('readonly', true);

		//make dice logo change!
		$("#dicelogo").addClass("rollCompleted");
		//less than 3 digits (usual case in d&d.)
		if (sum/100 < 1) {
			$("#dicelogo").removeClass("largeRoll");
		}
		if (sum/100 > 1) { //looks good up to 5 digits
			$("#dicelogo").addClass("largeRoll");
		}

		$("#dicelogo").html(sum);


	}
	catch(err) {
		$('#rollResult').text('ERR');
		if (debugflag) console.log(err); //tells us what the error is.
	}
		
}