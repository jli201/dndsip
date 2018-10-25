// //
// $(document).ready(function(){
   
//    $("#clickdie, .dicelogo, .dicelogo svg, .dicelogo img").click(function(){
// 		console.log("Hi.");
// 	});

// });



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
		debugflag=true;

		//Step 1. Validate data.
		var ndice = $('#ndice').val();
		var tdice = $('#tdice').val();
		var sign = $('#plusminus').val();
		var mod = $('#modval').val();

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

		//use editing guards.
		//Why? B/c a user who edits the 'textarea' result line causes a bug
		//This bug prevents the new value from displaying on screen, even if it's in the actual html
		//e.g. it can be <textarea>3</textarea> but on screen 3 will not show up!
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