$( document ).ready( function () {

	$.each($.validator.methods, function (key, value) {
        $.validator.methods[key] = function () {           
            if(arguments.length > 0) {
                arguments[0] = $.trim(arguments[0]);
            }

            return value.apply(this, arguments);
        };
    });

	$( "#updateStatus" ).validate( {
		rules: {
			Employment_Status: { 
				required: true
			},
			Reason: {
				required: true
			},
			Last_Pay: {
				required: true
			},
			Effective_Date: {
				required: true
			},
		},
		messages: {
			Employment_Status: {
				required: "Please select employment status."
			} ,
			Reason: "Please enter reason",
			Last_Pay: "Please enter valid date.",
			Effective_Date: "Please enter effective date.",
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
			saveUpdateInfo();
		}
	} );
} );

function saveUpdateInfo(ident,dateCat) {
	var data = {};
	var compid = $("#SCompany_ID").val();
	var refid = $("#SReference_Number").val();
	var dateHired = $("#Date_Hired").val();
	var category = $("#Employment_Status").val();
	var reason = $("#Reason").val();
	var lastPay = $("#Last_Pay").val();	
	var effectiveDate = $("#Effective_Date").val();
	var others = $("#Other_Info").val(); 
	var svIncharge = $("#SVIncharge").val();
	var svCompany = $("#SVICompany").val();
	data = {
		compid: compid,
		refid: refid,
		category: category,
		reason: reason,
		lastpay: lastPay,
		datehired: dateHired,
		effectivedate: effectiveDate,
		others: others,
		svincharge: svIncharge,
		svcompany: svCompany,
		update_cat: 'status',
		date_cat: dateCat 
	}
	// Save data
	$.ajax({
		url: 'updateEmpInfo',
		type: 'POST',
		data: data,
		error: function() {
			alert('Something is wrong');
		},
		success: function(res) {
			var result = JSON.parse(res);
			if(result['success']) {
				if(data['update_cat'] == 'info') {
					var containName = 'successAlert';
					var modal = 'editModal';
				} else {
					containName = 'successAlertStat';
					modal = 'statusModal';
				}
			}
			setTimeout(function(){
				$('#'+modal).modal('hide');
				$("#"+containName).html('')
				location.reload();
			}, 2000);
		}
	});
}


		