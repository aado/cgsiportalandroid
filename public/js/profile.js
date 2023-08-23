
$( document ).ready( function () {
    
	$.each($.validator.methods, function (key, value) {
        $.validator.methods[key] = function () {           
            if(arguments.length > 0) {
                arguments[0] = $.trim(arguments[0]);
            }

            return value.apply(this, arguments);
        };
    });

	jQuery.validator.addMethod("passwordMatch", function(value, element, params) { 
		console.log(value);

		if ($("#password").val() == value) {
			return true;
		}
		return false;
	});

	$( "#changePassword" ).validate( {
		rules: {
			password: {
				required: true,
			},
			confirm_password: {
				required: true,
				passwordMatch: ["#password","Confirm Password"]
			}
		},
		messages: {
			password: "Password required.",
			confirm_password:{
				required: 'Confirm password required.',
				passwordMatch: "Password not match."
			} 
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
			updatePassword();
		}
	} );


} );

function forceChangePass() {
	var frmSerialize = $("#changePassword").serialize();
	console.log(frmSerialize);
	if (confirm('Change Password?')) {
		$.ajax({
			url: 'saveChangePassword',
			type: 'POST',
			data: frmSerialize,
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				alert("Your password change successfully.");
				location.reload();
			}
		});
	}	
}

function updatePassword() {
	var frmSerialize = $("#changePassword").serialize();
	console.log(frmSerialize);
	if (confirm('Change Password?')) {
		$.ajax({
			url: 'saveChangePassword',
			type: 'POST',
			data: frmSerialize,
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				alert("Your password change successfully.");
				location.reload();
			}
		});
	}	
}
		