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


	//document.getElementById("defaultOpen").click();

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
		var title = $(this).attr('title');
		$('#approvedmodal').modal('show');
		$tr = $(this).closest('tr');
	
		var data = $tr.children("td").map(function()
		{
			return $(this).text();
		}).get();

		status = "";
		if(title == 'approve'){
			status = 1;
		}else if(title == 'return')
		{
			status = 2;
		}else
		{
			status = 3;
		}

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
	$('#voucherreceived').DataTable(
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

	$( "#frmtransmit" ).validate( {
		rules: {
			TransmittedTo: {
				required: true
			},
			Brands: {
				required: true
			},
			ToolM: {
				required: true,
			},
			DeliveredBy:{
				required: true
			}
		},
		messages: {
			TransmittedTo: "Employee name required",
			Brands: 'Brand required'
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
			transmit();
		}
	} );

	function transmit() {
		var frmSerialize = $("#frmtransmit").serialize();
		console.log(frmSerialize);
		$.ajax({
			url: baseURL+'saveTransmitall',
			type: 'POST',
			data: frmSerialize,
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

	$( "#frmAddReceipt" ).validate( {
		rules: {
			delivery_receipt: {
				required: true
			},
			amount: {
				required: true
			},
			// leavetype: {
			// 	required: true,
			// },
			// Reason: {
			// 	required: true,
			// },
		},
		messages: {
			delivery_receipt: "Delivery receipt is required.",
			amount: {
				required: 'Amount is required.'
			},
			// leavetype: "Leave type required",
			// Reason: {
			// 	required: "Reason required.", 
			// },
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
			saveReceipt_Amount();
		}
	} );

	function saveReceipt_Amount() {
		var frmSerialize = $("#frmAddReceipt").serialize();
		console.log(frmSerialize);
		$.ajax({
			url: baseURL+'saveReceiptInfo',
			type: 'POST',
			data: frmSerialize,
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				var result = JSON.parse(data);
				console.log(result);
				// if(result['success']) {
				// 	location.reload();
				// }
			}
		});
	}


	//INVENTORY MIS TABLE
	var tobetransmitted = $('#tobetransmitted').DataTable({
		// responsive: true,

		"footerCallback": function ( row, data, start, end, display ) {
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
                     .column(4 )
                     .data()
                     .reduce( function (a, b) {
                     	return intVal(a) + intVal(b);
                     }, 0 );
                     // Total over this page
                      pageTotal = api
                      .column( 4, { page: 'current'} )
                      .data()
                      .reduce( function (a, b) {
                      	return intVal(a) + intVal(b);
                      }, 0 );
                       // Update footer
                       $( api.column( 4 ).footer() ).html(
                       	''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
                       	);
                   },
                   "columnDefs": [
                   {
                   	"targets": [5,6],
                   	"visible": true
                   },
                   ],
                   "pagingType": "full_numbers",
                   "order":[[ 0, "desc" ]],
                   "lengthMenu": [
                   	[5, 10,15, 25, 50, -1],
                   	[5, ,15, 25, 50, "All"]
                   	],
                   language:{
                   	search:"_INPUT_",
                   	searchPlaceholder: "Search records",
                   }
               });
     //TO BE TRANSMITTED NGA MODAL
	$('#tobetransmitted tbody').on('click','td button#transmitbtn',function(){
		// alert(1);
		$('#transmitmodal').modal('show');
		//$tr = $(this).closest('tr');

		var mistransmit = tobetransmitted.row( $(this).closest('tr') ).data();
		$('#Entry_Date').val(mistransmit[0]);
		$('#PO_Number').val(mistransmit[1]);
		$('#transmittal_Num').val(mistransmit[2]);
		$('#ItemName').val(mistransmit[3]);
		$('#ItemUnit').val(mistransmit[4]);
		$('#ItemSize').val(mistransmit[5]);
		$('#TotalQty').val(mistransmit[6]);
		$('#Delivery_Date').val(mistransmit[9]);
		$('#Requester').val(mistransmit[10]);
		$('#Invoice_Number').val(mistransmit[11]);
		$('#ItemDesc').val(mistransmit[12]);
	});

	var groupColumn = 2;
		var table = $('#MISitemtransmitted').DataTable({
			columnDefs: [{ visible: false, targets: groupColumn }],
			order: [[groupColumn, 'asc']],
			displayLength: 25,
			drawCallback: function (settings) {
				var api = this.api();
				var rows = api.rows({ page: 'current' }).nodes();
				var last = null;
	
				api
					.column(groupColumn, { page: 'current' })
					.data()
					.each(function (group, i) {
						if (last !== group) {
							$(rows)
								.eq(i)
								.before('<tr class="group"><td colspan="5"><b>' + group + '</b></td></tr>');
	
							last = group;
						}
					});
       	 },
    });
 
    // Order by the grouping
    $('#MISitemtransmitted tbody').on('click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            table.order([groupColumn, 'desc']).draw();
        } else {
            table.order([groupColumn, 'asc']).draw();
        }
    });

    // var groupColumn = 4;
	// 	var table = $('#MISitemtransmittedNew').DataTable({
	// 		columnDefs: [{ visible: false, targets: groupColumn }],
	// 		order: [[groupColumn, 'asc']],
	// 		displayLength: 25,
	// 		drawCallback: function (settings) {
	// 			var api = this.api();
	// 			var rows = api.rows({ page: 'current' }).nodes();
	// 			var last = null;
	
	// 			api
	// 				.column(groupColumn, { page: 'current' })
	// 				.data()
	// 				.each(function (group, i) {
	// 					if (last !== group) {
	// 						$(rows)
	// 							.eq(i)
	// 							.before('<tr class="group"><td colspan="5"><b>' + group + '</b></td></tr>');
	
	// 						last = group;
	// 					}
	// 				});
    //    	 },
    // });
 
    // // Order by the grouping
    // $('#MISitemtransmittedNew tbody').on('click', 'tr.group', function () {
    //     var currentOrder = table.order()[0];
    //     if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
    //         table.order([groupColumn, 'desc']).draw();
    //     } else {
    //         table.order([groupColumn, 'asc']).draw();
    //     }
    // });

	var MISitemtransmittedhistory = $('#MISitemtransmittedhistory').DataTable({
		responsive: true,
		
		"footerCallback": function ( row, data, start, end, display ) {
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
                .column(4)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column(4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
				console.log (total);
 
            // Update footer
            $( api.column(4).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
        },
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		// "columnDefs": [
		//  {
		//  	"targets": [1,9],
		//  	"visible": false
		// 	},
		// ],
		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		},
		"createdRow": function( row, data, dataIndex ) {
            if ( data["4"] == "Transmit" ) {
                $( row ).css( "background-color", "#33cc33" );
                $( row ).addClass( "warning" );
            }
             else if ( data["4"] == "For Disposal" ) {
                $( row ).css( "background-color", "#ff3300" );
                $( row ).addClass( "warning" );
            }
             else if ( data["4"] == "For Repair" ) {
                $( row ).css( "background-color", "#0099ff" );
                $( row ).addClass( "warning" );
            }
             else if ( data["4"] == "Pull out" ) {
                $( row ).css( "background-color", "#C0C0C0" );
                $( row ).addClass( "warning" );
            }  
        }
	});
	
	var pulloutitems = $('#pulloutitems').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column(3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
	},

		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		 
		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}


	});
	
	var MISitempullouthistory = $('#MISitempullouthistory').DataTable({
		responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column(4)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column(4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(4).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
	},

		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

	 // "columnDefs": [
	// 	 {
     //            "targets": [1,9],
     //            "visible": false
     //        },


	// 	 ],

		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		},
		// "createdRow": function( row, data, dataIndex ) {
        //     if ( data["11"] == "Transmit" ) {
        //         $( row ).css( "background-color", "#33cc33" );
        //         $( row ).addClass( "warning" );
        //     }
        //      else if ( data["11"] == "For Disposal" ) {
        //         $( row ).css( "background-color", "#ff3300" );
        //         $( row ).addClass( "warning" );
        //     }
        //      else if ( data["11"] == "For Repair" ) {
        //         $( row ).css( "background-color", "#0099ff" );
        //         $( row ).addClass( "warning" );
        //     }
        //      else if ( data["11"] == "Pullout" ) {
        //         $( row ).css( "background-color", "#C0C0C0" );
        //         $( row ).addClass( "warning" );
        //     }  
        // }

	});


	var datatobetransmit = $('#datatobetransmit').DataTable({
		responsive: true,
		"pagingType": "full_numbers",
		"order":[[ 1, "asc" ]],  	
		"lengthMenu": [
			[5, 15, 25, 50, -1],
			[5, 15, 25, 50, "All"]
		],

		 // "columnDefs": [
		 // {
         //        "targets": [6],
         //        "visible": false
         //    },
		 // ],

		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}
		
	});

	var datalists = $('#datalists').DataTable({
		responsive: true,
		"pagingType": "full_numbers",
		"order":[[ 1, "asc" ]],  	
		"lengthMenu": [
			[5, 15, 25, 50, -1],
			[5, 15, 25, 50, "All"]
		],

		 "columnDefs": [
		 {
                "targets": [6],
                "visible": false
            },
		 ],

		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		},
		"createdRow": function( row, data, dataIndex ) {
            if ( data["6"] == "Functional" ) {
            		$( row ).css( "background-color", "#33cc33" );
                	$( row ).addClass( "warning" );
              	}
                else if ( data["6"] == "Not Functional/Damaged" ) {
                	$( row ).css( "background-color", "#ff3300" );
                   	$( row ).addClass( "warning" );
                }
                else if ( data["6"] == "Subject for replacement" ) {
                  	$( row ).css( "background-color", "#0099ff" );
                   	$( row ).addClass( "warning" );
                }
        }
		
	});
	
	$('#datatobetransmit tbody').on('click','td button#transmittalmisbtn',function(){
		
		$('#transmitmismodal').modal('show');

		var tobetransmit = datatobetransmit.row( $(this).closest('tr') ).data();

			$('#Delivery_Date').val(tobetransmit[0]);
			$('#PO_Number').val(tobetransmit[1]);
			$('#Invoice_Number').val(tobetransmit[2]);
			$('#Requester').val(tobetransmit[3]);
			$('#TransmittedTo').val(tobetransmit[4]);
			$('#totalQty').val(tobetransmit[5]);
			$('#ItemName').val(tobetransmit[6]);
			$('#ItemDesc').val(tobetransmit[7]);
			$('#ItemQty').val(tobetransmit[8]);
			$('#transmittal_Num').val(tobetransmit[9]);
			$('#Status').val(tobetransmit[10]);
			$('#ItemUnit').val(tobetransmit[11]);
			$('#ItemSize').val(tobetransmit[12]);
			
		
	});


$('#inventoryMIS').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			

	},

	
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		 // "columnDefs": [
		 // {
         //        "targets": [6],
         //        "visible": false
         //    },


		 // ],

		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}
		
	});


$('#equipment').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
			
			
	},

		
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		
		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}
		// },

		// "createdRow": function( row, data, dataIndex ) {
  //           if ( data["5"] == "Functional" ) {
  //               $( row ).css( "background-color", "#33cc33" );
  //               $( row ).addClass( "warning" );
  //           }
  //            else if ( data["5"] == "Not Functional/Damaged" ) {
  //               $( row ).css( "background-color", "#ff3300" );
  //               $( row ).addClass( "warning" );
  //           }
  //            else if ( data["5"] == "Subject for replacement" ) {
  //               $( row ).css( "background-color", "#0099ff" );
  //               $( row ).addClass( "warning" );
  //           }
  //           //  else if ( data["5"] == "Pullout" ) {
  //           //     $( row ).css( "background-color", "#C0C0C0" );
  //           //     $( row ).addClass( "warning" );
  //           // }  
  //       }


	});



$('#officesupp').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
			
			
	},

		
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		
		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}
		// },

		// "createdRow": function( row, data, dataIndex ) {
  //           if ( data["5"] == "Functional" ) {
  //               $( row ).css( "background-color", "#33cc33" );
  //               $( row ).addClass( "warning" );
  //           }
  //            else if ( data["5"] == "Not Functional/Damaged" ) {
  //               $( row ).css( "background-color", "#ff3300" );
  //               $( row ).addClass( "warning" );
  //           }
  //            else if ( data["5"] == "Subject for replacement" ) {
  //               $( row ).css( "background-color", "#0099ff" );
  //               $( row ).addClass( "warning" );
  //           }
  //           //  else if ( data["5"] == "Pullout" ) {
  //           //     $( row ).css( "background-color", "#C0C0C0" );
  //           //     $( row ).addClass( "warning" );
  //           // }  
  //       }


	});



$('#chemicals').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
			
			
	},

		
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		

		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}

	});



$('#uniforms').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
			
			
	},

		
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		

		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}
	});


$('#cleaningsupp').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
			
			
	},

		
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],
		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}
	});


	
	
	
	
$('#dataemployeelist').DataTable({
		// responsive: true,


"footerCallback": function ( row, data, start, end, display ) {
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
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
				console.log (total);
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
          
				''+ ( pageTotal ) +' <br> ( '+ ( total ) +' Overall )'
            );
			
			
			
	},
		"pagingType": "full_numbers",
		"order":[[ 0, "desc" ]],  	
		"lengthMenu": [
			[5, 10,15, 25, 50, -1],
			[5, ,15, 25, 50, "All"]
		],

		language:{
			search:"_INPUT_",
			searchPlaceholder: "Search records",
		}
		

	});
		
// request view accnt
	$('#dataemployeelist tbody').on('click','td button#addemployeebtn',function(){
		// alert(1);
	
		
		$('#addemployeeassets').modal('show');
		
	//$tr = $(this).closest('tr');

		var data = dataemployeelist.row( $(this).closest('tr') ).data();
		console.log(data);

			$('#empid').val(data[0]);
			$('#Name').val(data[1]);
			$('#Branch').val(data[2]);
			$('#department').val(data[3]);
			
				
	});
	
	//INVENTORY ADDING MULTIPLE ITEMS
	var html1 ='<tr><td><input type="text" name="add_ItemQty[]" class="form-control" required></td><td><input type="text" name="add_Particulars[]" class="form-control" required></td><td><input type="text" name="add_Brand[]" class="form-control" required></td><td><input type="text" name="add_ToolM[]" class="form-control" required></td><td><input type="text" name="add_SerialNo[]" class="form-control" required></td><td><button class="btn btn-danger" type="button" name="removeitems" id="removeitems" value="remove"> <i class="fas fa-trash" style="width:20px;"></i> </button></td></tr>';

	var max = 7;
	var add = 1 ;
	$("#additems").click(function(){
		if(add <= max) {
			$("#table_items").append(html1);
			add++;
		}
	});
	$("#table_items").on('click','#removeitems',function(){
		$(this).closest('tr').remove();
		add--;
	});
	//INVENTORY PULLOUT MNULTIPLE ITEMS
	var html ='<tr><td><input type="text" name="add_noitems[]"  class="form-control" required></td><td><input type="text" name="add_itemname[]" class="form-control" required></td><td><input type="text" name="add_sn[]" class="form-control" required></td><td><input type="text" name="add_bm[]" class="form-control" required></td><td><input type="text" name="add_tm[]" class="form-control" required></td><td><select class="form-select form-control form-select-sm " aria-label=".form-select-sm example" name="add_remarks[]" required><option selected> </option><option value="Functional"> Functional</option><option value="Subject for replacement"> Subject for replacement</option><option value="For Disposal">Not Functional/Damaged</option></select><td><button class="btn btn-danger" type="button" name="removepullitems" id="removepullitems" value="remove"><i class="fas fa-trash" style="width:20px;"></i>  </button></td></tr>';

	var max = 7;
	var add = 1 ;
	$("#addpullitems").click(function(){
		if(add <= max) {
			$("#table_pullitems").append(html);
			add++;
		}
	});
	$("#table_pullitems").on('click','#removepullitems',function(){
		$(this).closest('tr').remove();
		add--;
	});


	var html2 ='<tr><td><input type="text" name="add_noitems[]"  class="form-control" required></td><td><input type="text" name="add_itemname[]" class="form-control" required></td><td><input type="text" name="add_sn[]" class="form-control" required></td><td><input type="text" name="add_bm[]" class="form-control" required></td><td><input type="text" name="add_tm[]" class="form-control" required></td><td><button class="btn btn-danger" type="button" name="removeemployeeitems" id="removeemployeeitems" value="remove"><i class="fas fa-trash" style="width:20px;"></i> </button></td></tr>';

	var max = 7;
	var add = 1 ;
	$("#addemployeeitems").click(function(){
		if(add <= max) {
			$("#table_employeeitems").append(html2);
			add++;
		}
	});
	$("#table_employeeitems").on('click','#removeemployeeitems',function(){
		$(this).closest('tr').remove();
		add--;
	});

	//$(".js-example-basic-single").select2({
  //tags: true
//});

$("#btnPrint").click(function() {
		printElement(document.getElementById("printThis"));
	});


} );

	//INVENTORY
	function openCity(evt, cityName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
		  tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
		  tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}

function getBusinessDatesCount(startDate, endDate) {
    let count = 0;
    const curDate = new Date(startDate.getTime());
    while (curDate <= endDate) {
        const dayOfWeek = curDate.getDay();
        if(dayOfWeek !== 0 && dayOfWeek !== 6) count++;
        curDate.setDate(curDate.getDate() + 1);
    }
    // alert(count);
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
}

function getItemDetails(name, alltotal, used, invoicenumber, deldate, ponumber, tranqty) {
	$("#exampleModalLabel").text(name);
	$("#invoice_number").val(invoicenumber);
	$("#Delivery_Date").val(deldate);
	$("#Particulars").val(name);
	$("#PO_Number").val(ponumber);
	if(used == 0) {
		var option = '';
		for(var i=0; i < alltotal; i++) {
			option += '<option value="'+ (i+1) +'">'+ (i+1) +'</option>';
		}
		$("#qty").html(option);
	} else {
		var total = alltotal - tranqty;
		console.log(total);
		var option = '<option value=""></option>';
		for(var i=0;i < total; i++) {
			option += '<option value="'+ (i+1)+'">'+(i+1)+'</option>';
		}
		$("#qty").html(option);
	}
}

function getEntryDetails(deldate, ponumber, invoicenumber, status, itemdesc) {
	$("#exampleModalLabel").text(itemdesc);
	$("#del_date").val(deldate);
	$("#po_number").val(ponumber);
	$("#invoice_number").val(invoicenumber);
	$("#status").val(status);
}

function loadDetail(id) {
	$("#"+id).html("<img src='https://i.pinimg.com/originals/3e/f0/e6/3ef0e69f3c889c1307330c36a501eb12.gif' style='width: 15px'/>");
}

		