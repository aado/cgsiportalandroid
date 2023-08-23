
$( document ).ready( function () {
		$('#leaveTable').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'excelHtml5',
			],
			responsive: true,
			"columnDefs": [
			],
			processing: true,
			initComplete: function () {}
		} );

		
		$( "#applyLeave" ).validate( {
			rules: {
				datefrom: required
				// Contact_Number: {
				// 	required: {
				// 		depends:function(){
				// 			$(this).val($.trim($(this).val()));
				// 			return true;
				// 		}
				// 	},
				// 	number: true,
				// 	minlength:7,
				// 	maxlength:11,
				// },
			},
			messages: {
				// Contact_Number: {
				// 	required: "Please enter contact number.", 
				// 	number: "Please enter valid contact number",
				// 	minlength: "Please enter 7 digit phone number or 11 digit mobile number",
				// 	maxlength: "Please enter 7 digit phone number or 11 digit mobile number",
				// } ,
			},
			errorElement: "em",
			errorPlacement: function ( error, element ) {
				// Add the `help-block` class to the error element
				error.addClass( "help-block" );
	
				if ( element.prop( "type" ) === "checkbox" ) {
					error.insertAfter( element.parent( "label" ) );
				} else {
					error.insertAfter( element );
				}
			},
			highlight: function ( element, errorClass, validClass ) {
				$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
			},
			unhighlight: function (element, errorClass, validClass) {
				$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
			},
			submitHandler: function () { 
				// saveUpdateInfo(1);
			}
		} );
});
