$j('document').ready(function() {

	$j( ".pupup-submit" ).click(function() {

		var myArray = [];
		var regex = /\S+@\S+\.\S+/;

		myArray[ 0 ] = $j( ".name").val();
		myArray[ 1 ] = $j( ".email").val();
		myArray[ 2 ] = $j( ".child").val();
		myArray[ 3 ] = $j( ".dob").val();
		myArray[ 4 ] = $j( ".pupup-background-color").html();
		myArray[ 5 ] = $j( ".phone").val();
					
		//----------- Validating Email  ------------
		if(myArray[1] == '' || !regex.test(myArray[1])) {
		
			$j('.email').css('border-color','red');
			return false;
		}
		
		if(myArray[5] == '' || myArray[5] == null) {
			
			$j('.email').css('border-color','#cfcfcf');
			$j('.phone').css('border-color','red');
			return false;
		}
 
		$j.post('http://localhost/babyplanet.pk/index.php/popbox/index/saveData', {
			
			submit:true, 
			name:myArray[0], 
			email:myArray[1], 
			child:myArray[2], 
			dob:myArray[3], 
			gender:myArray[4], 
			phone:myArray[5]

		}, function(e) {
			
			popupClear();
			//window.location = 'http://babyplanet.pk/source/welcome.php';
			
		});
	
	});
	
	$j( ".pupup-boy" ).click(function() {

		$j( ".pupup-boy" ).addClass( "pupup-background-color" );
		$j( ".pupup-girl" ).removeClass( "pupup-background-color" );
	
	});
	
	$j( ".pupup-girl" ).click(function() {

		$j( ".pupup-girl" ).addClass( "pupup-background-color" );
		$j( ".pupup-boy" ).removeClass( "pupup-background-color" );
	
	});
	
	$j(function() {
	
		$j( "#datepicker" ).datepicker({

			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			yearRange: '2004:2015'

		});
	});
});