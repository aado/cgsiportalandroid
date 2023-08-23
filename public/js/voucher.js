var base_url = window.location.origin;
baseURL = base_url+'/cgsiportal/';
$( document ).ready( function () {

	let $select = jQuery("#under_time");

	for (let hr = 10; hr < 16.30; hr++) {

		let hrStr = hr.toString().padStart(2, "0") + ":";

		let val = hrStr + "00";
		$select.append('<option val="' + val + '">' + val + '</option>');

		val = hrStr + "30";
		$select.append('<option val="' + val + '">' + val + '</option>')

	}

	var date = new Date();
	$("#date_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());
	$("#undate_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());

	new Pikaday({ 
		field: document.getElementById('datefrom'),
		disableWeekends: true,
		minDate: new Date(),
		defaultDate: new Date(),
		setDefaultDate: true
	});
	new Pikaday({ 
		field: document.getElementById('undatefrom'),
		disableWeekends: true,
		minDate: new Date(),
		defaultDate: new Date(),
		setDefaultDate: true
	});
	new Pikaday({ 
		field: document.getElementById('dateto'),
		disableWeekends: true,
		minDate: new Date(),
		onSelect: function() {
			var date = new Date();
			var gdateto = new Date(this.getDate());
			var gdatefrom = new Date($("#datefrom").val());
			var datenow = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
			var dateto= (gdateto.getMonth() + 1) + '/' + gdateto.getDate() + '/' +  gdateto.getFullYear();
			var datefrom= (gdatefrom.getMonth() + 1) + '/' + gdatefrom.getDate() + '/' +  gdatefrom.getFullYear();
			if (datenow == datefrom && datenow == dateto) {
				$("#leavetype").val(7);
			} else {
				$("#leavetype").val("");
				$("#leavetype option[value='7']").attr('disabled',true);
				$("#leavetype").removeAttr('disabled');
			}
			var startDate = new Date(datefrom);
			var endDate = new Date(dateto);
			var numOfDates = getBusinessDatesCount(startDate,endDate);
			$("#nofdayleave").val(numOfDates);
			$("#ldayleave").text('No. of Leave/s: '+numOfDates);
        }
	});

	$("#undertime").hide();

	$('#applytype').on('change', function() {
		if( this.value == 1) {
			$("#frmleave").show();
			$("#undertime").hide();
		} else {
			$("#frmleave").hide();
			$("#undertime").show();
		}	
	});

	// PO DATATABLE
	$('#datatableidreceived').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('#datatableidLuzon').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('#datatableidreturned_visayas').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('#datatableidreturned_luzon').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('#datatableid_Cancelledvisayas').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('#datatableid_CancelledLuzon').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('#datatableid_historyvisayas').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );
	
	$('#datatableid_historyLuzon').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('.approvedbtn').on('click',function()
	{
		console.log(1);
		var title = $(this).attr('title');
		$('#approvedmodal').modal('show');
		$tr = $(this).closest('tr');
	
		var data = $tr.children("td").map(function()
		{
			return $(this).text();
		}).get();

		var status = "";
		if(title == 'approve'){
			status = 1;
		}else if(title == 'return')
		{
			status = 2;
		}else
		{
			status = 3;
		}
		console.log(data);
		$('#statustype').val(status);
		$('#entrydate_approved').val(data[0]);
		$('#voucher_no_approved').val(data[1]);
	});

	$('.returnbtn').on('click',function()
	{
		$('#returnmodal').modal('show');
		$tr = $(this).closest('tr');
		
		var data = $tr.children("td").map(function()
		{
			return $(this).text();
		}).get();

		$('#statustype').val(2);
		$('#entrydate_return').val(data[0]);
		$('#voucher_no__return').val(data[1]);
	});

	$('.rejectbtn').on('click',function()
	{
		$('#rejectmodal').modal('show');
		
		$tr = $(this).closest('tr');
		
		var data = $tr.children("td").map(function()
		{
			return $(this).text();
		}).get();
		
		$('#statustype').val(3);
		$('#entrydate_rejected').val(data[0]);
		$('#voucher_no_reject').val(data[1]);
	});

	//VOUCHER DATABLE
		$('#voucherreceived_luzon').DataTable(
		{
			responsive: true,
			"pagingType": "full_numbers",
			"order":[[ 0, "desc" ]],  	
			"lengthMenu": 
			[
					[5, 15, 25, 50, -1],
					[5, 15, 25, 50, "All"]
			],
	
			language:
			{
				search:"_INPUT_",
				searchPlaceholder: "Search records",
			}
		});
	$('#voucherreceived_visayas').DataTable(
		{
			responsive: true,
			"pagingType": "full_numbers",
			"order":[[ 0, "desc" ]],  	
			"lengthMenu": 
			[
					[5, 15, 25, 50, -1],
					[5, 15, 25, 50, "All"]
			],
	
			language:
			{
				search:"_INPUT_",
				searchPlaceholder: "Search records",
			}
		});
	$('#voucherreturned').DataTable(
		{
			responsive: true,
			"pagingType": "full_numbers",
			"order":[[ 0, "desc" ]],  	
			"lengthMenu": 
			[
					[5, 15, 25, 50, -1],
					[5, 15, 25, 50, "All"]
			],
	
			language:
			{
				search:"_INPUT_",
				searchPlaceholder: "Search records",
			}
		});

	$('#vouchercancel').DataTable(
		{
			responsive: true,
			"pagingType": "full_numbers",
			"order":[[ 0, "desc" ]],  	
			"lengthMenu": 
			[
					[5, 15, 25, 50, -1],
					[5, 15, 25, 50, "All"]
			],
	
			language:
			{
				search:"_INPUT_",
				searchPlaceholder: "Search records",
			}
		});

	$('#voucherhistory_visayas').DataTable(
		{
			responsive: true,
			"pagingType": "full_numbers",
			"order":[[ 0, "desc" ]],  	
			"lengthMenu": 
			[
					[5, 15, 25, 50, -1],
					[5, 15, 25, 50, "All"]
			],
	
			language:
			{
				search:"_INPUT_",
				searchPlaceholder: "Search records",
			}
		});
	$('#voucherhistory').DataTable(
		{
			responsive: true,
			"pagingType": "full_numbers",
			"order":[[ 0, "desc" ]],  	
			"lengthMenu": 
			[
					[5, 15, 25, 50, -1],
					[5, 15, 25, 50, "All"]
			],
	
			language:
			{
				search:"_INPUT_",
				searchPlaceholder: "Search records",
			}
		});

	var minDate = new DateTime($('#from'), 
		{
			format: 'MMMM Do YYYY'
		});

		var maxDate = new DateTime($('#to'), 
		{
			format: 'MMMM Do YYYY'
		});
		
		// DataTables initialisation
		var numberRenderer = $.fn.dataTable.render.number( ',', '.', 2,   ).display;
 		var table = $('#vouchersummary').DataTable({

		"footerCallback": function ( row, data, start, end, display ) 
		{
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
        };
            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) 
                {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
				console.log (total);
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
          
				''+ numberRenderer( pageTotal ) +' <br> ( '+ numberRenderer( total ) +' Total Amount )'
            );
		},
		
			responsive: true,
			"pagingType": "full_numbers",
			"order":[[ 0, "asc" ]],  	
			"lengthMenu": 
			[
				[5, 15, 25, 50, -1],
				[5, 15, 25, 50, "All"]
			],
			
			language:
			{
				search:"_INPUT_",
				searchPlaceholder: "Search records",
			}
		});
			// Refilter the table
			$('#from, #to').on('change', function () 
			{
				table.draw();
			});

	


	// LEAVE DATATABLE
	$('#leaveTableDept').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	// LEAVE CREDIT
	$('#leavecredit').DataTable( {
		// dom: 'Bfrtip',
		// buttons: [
		// 	'excelHtml5',
		// ],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 10,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );


	$.each($.validator.methods, function (key, value) {
        $.validator.methods[key] = function () {           
            if(arguments.length > 0) {
                arguments[0] = $.trim(arguments[0]);
            }

            return value.apply(this, arguments);
        };
    });

	jQuery.validator.addMethod("greaterThan", function(value, element, params) {    
		if (!/Invalid|NaN/.test(new Date(value))) {
			return new Date(value) >= new Date($(params[0]).val());
		}
		return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val())); 
	},'Must be greater than {1}.');

	$( "#frmleave" ).validate( {
		rules: {
			dateto: {
				required: true,
				greaterThan: ["#datefrom","Date From"]
			},
			datefrom: {
				required: true
			},
			leavetype: {
				required: true,
			},
			Reason: {
				required: true,
			},
		},
		messages: {
			datefrom: "Date from required",
			dateto: {
				required: 'Date to required',
				greaterThan: 'Date to must not greater than date from'
			},
			leavetype: "Leave type required",
			Reason: {
				required: "Reason required.", 
			},
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
			applyLeave(1);
		}
	} );

		$( "#triggerapproved" ).validate( {
		rules: {
			remarks_approved: {
				required: false,
			}
		},
		messages: {
			// remarks_approved: "fa from required",
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
			saveapproved();
		}
	} );

	$( "#undertime" ).validate( {
		rules: {
			under_time: {
				required: true
			},
			datefrom: {
				required: true
			},
			leavetype: {
				required: true,
			},
			Reason: {
				required: true,
			},
		},
		messages: {
			datefrom: "Date from required",
			under_time: {
				required: 'Time is required'
			},
			leavetype: "Leave type required",
			Reason: {
				required: "Reason required.", 
			},
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
			applyLeave(2);
		}
	} );

	$('.approvedbtn').on('click',function()
	{
		var modal = $("#approvedmodal");
		var title = $(this).attr('title');
		console.log(title);
		modal.find('.modal-title').html(title.toUpperCase())
		$("#exampleModalLabel").html("Approve Voucher?");
		$('#approvedmodal').modal('show');
		$tr = $(this).closest('tr');
	
		var data = $tr.children("td").map(function()
		{
			return $(this).text();
		}).get();

		var status = "";
		if(title == 'approve'){
			// console.log(title);
			status = 1;
			$("#exampleModalLabel").text("Approve Voucher?");
		}else if(title == 'return')
		{
			status = 2;
			$("#exampleModalLabel").html("Return Voucher?");
		}else
		{
			status = 3;
			$("#exampleModalLabel").html("Reject Voucher?");
		}

		$('#statustype').val(status);
		$('#entrydate_approved').val(data[0]);
		$('#voucher_no').val(data[1]);
	});

	$('#closeModal,#closeModalNo').on('click',function()
	{
		$('#approvedmodal').modal('hide');
	});
	
	$("#formStatus").submit(function(e) {
		e.preventDefault();
		confirmStatus();
	});

} );

function confirmStatus() {
	var frmSerialize = $("#formStatus").serialize();
	console.log(frmSerialize);
	$.ajax({
		url: baseURL+'saveVoucherStatus',
		type: 'POST',
		data: frmSerialize,
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			if(result['success']) {
				location.href=baseURL+'receivedvoucher';
			}
		}
	});
}

function applyLeave(applictype) {
	var frmSerialize = $("#frmleave").serialize();
	if (applictype == 2) {
		frmSerialize = $("#undertime").serialize();
	}
	$.ajax({
		url: 'saveLeaveUndertime',
		type: 'POST',
		data: frmSerialize + "&application_type= "+applictype+"",
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			if(result['success']) {
				location.reload();
			}
		}
	});
}

function getBusinessDatesCount(startDate, endDate) {
    let count = 0;
    const curDate = new Date(startDate.getTime());
    while (curDate <= endDate) {
        const dayOfWeek = curDate.getDay();
        if(dayOfWeek !== 0 && dayOfWeek !== 6) count++;
        curDate.setDate(curDate.getDate() + 1);
    }
    return count;
}

function confirmLeave(ident, lid) {
	if (ident == 2) {
		$("#lblConfirm").html('<span style="color:red; font-weight: bold">REJECT</span>');
	} else {
		$("#lblConfirm").html('<span style="color:blue; font-weight: bold">APPROVED</span>');
	}
}

function saveLeaveApprovedReject() {
	$.ajax({
		url: 'approvedRejectLeave',
		type: 'POST',
		data: {leaveid: lid},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			console.log(data);
			// var result = JSON.parse(data);
			// if(result['success']) {
			// 	location.reload();
			// }
		}
	});
}

function removeLeave(id) {
	if(confirm("Are you sure you want to delete this leave?")){
		$.ajax({
			url: 'removeLeave',
			type: 'POST',
			data: {leaveid: id},
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				var result = JSON.parse(data);
				if(result['success']) {
					location.reload();
				}
			}
		});
    }
    else{
        return false;
    }
}

function backButton(locstatus) {
	location.href=baseURL+locstatus;
	// if(locstatus == 'cancellpo') {
	// 	$("#statusBtn").attr('style','display: none');
	// }
}

		