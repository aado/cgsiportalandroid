$(document).ready(function() {
	const d = new Date();
	// Create date inputs
	minDate = new DateTime($('#min'), {
		format: 'MMMM Do YYYY',
		maxDate: new Date(d.getFullYear() + 1, d.getMonth(), d.getDate())
	});
	maxDate = new DateTime($('#max'), {
		format: 'MMMM Do YYYY',
		maxDate: new Date(d.getFullYear() + 1, d.getMonth(), d.getDate())
	});

	if(window.location.pathname.split('/')[2] === 'RTAInactive') {
		var minDate, maxDate;
	
		// Custom filtering function which will search data in column four between two values
		$.fn.dataTable.ext.search.push(
			function( settings, data, dataIndex ) {
				var min = minDate.val();
				var max = maxDate.val();
				var date = new Date( data[6] );
		
				if (
					( min === null && max === null ) ||
					( min === null && date <= max ) ||
					( min <= date   && max === null ) ||
					( min <= date   && date <= max )
				) {
					return true;
				}
				return false;
			}
		);
	}

	if(window.location.pathname.split('/')[2] === 'Masterlist') {
		var minDate, maxDate;
	
		// Custom filtering function which will search data in column four between two values
		$.fn.dataTable.ext.search.push(
			function( settings, data, dataIndex ) {
				var min = minDate.val();
				var max = maxDate.val();
				var date = new Date( data[7] );
		
				if (
					( min === null && max === null ) ||
					( min === null && date <= max ) ||
					( min <= date   && max === null ) ||
					( min <= date   && date <= max )
				) {
					return true;
				}
				return false;
			}
		);
	}

	var dataTable = $('#dataTable').DataTable( {
		dom: 'Bfrtip',
		responsive: true,
		"order": [[ 7, "asc" ]],
        buttons: [
			{
				extend: 'excelHtml5',
				exportOptions: {
					columns: [1,2,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
				}
			},
        ],
		"columnDefs": [
			{
				"targets": [ 11 ],
				"visible": false,
				"searchable": false
			},
			{ 
				targets: 1,
				width: 400
			}
		],
		processing: true,
		initComplete: function () {
			$('.masterlistTable').removeAttr('style');
			$('.loading').attr('style','display: none');
		}
	} );

	// Refilter masterlist table
    $('#min, #max').on('change', function () {
        dataTable.draw();
    });

	// TO RTA
	var toRTA = $('#toRTA').DataTable( {
		dom: 'Bfrtip',
		// "order": [[ 14, "desc" ]],
        buttons: [
            'excelHtml5',
            // 'pdfHtml5'
        ],
		// 'rowsGroup': [0],
		responsive: true,
		"columnDefs": [
			{ 
				orderable: false, 
				targets: 0,
				className: 'comp_name',
				width: '50px'
			}
		],
		processing: true,
		initComplete: function () {
			$('.masterlistTable').removeAttr('style');
			$('.loading').attr('style','display: none');
		}
	} );

	//RTA In Active
	var rtaTable = $('#RTAInactive').DataTable( {
		dom: 'Bfrtip',
        // "scrollX": true,
		// 'rowsGroup': [4],
		responsive: true,
        buttons: [
            'excelHtml5',
            // 'pdfHtml5'
        ],
		"columnDefs": [
			{ 
				orderable: false, 
				targets: 4
			}
		],
		processing: true,
		initComplete: function () {
			$('.masterlistTable').removeAttr('style');
			$('.loading').attr('style','display: none');
			this.api().columns(0).every( function () {
				var column = this;
				var select = $('<select class="companySelect"><option value="">Company Assigned</option></select>')
				.prependTo( $(column.header()).empty() )
				.on( 'change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
					);

					column
					.search( val ? '^'+val+'$' : '', true, false )
					.draw();
				} );

				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		}
	} );


	// Refilter rta table
    $('#min, #max').on('change', function () {
        rtaTable.draw();
    });
	 

	// For leave and Maternity
	var forceLeave = $('#forceleave').DataTable( {
		// dom: 'Bfrtip',
		// 'rowsGroup': [7],
		responsive: true,
		"columnDefs": [
			{ 
				orderable: false, 
				targets: 7,
				className: 'comp_name'
			}
		],
		processing: true,
		initComplete: function () {
			$('.masterlistTable').removeAttr('style');
			$('.loading').attr('style','display: none');
			this.api().columns(7).every( function () {
				var column = this;
				var select = $('<select class="companySelect"><option value="">Company Name</option></select>')
				.prependTo( $(column.header()).empty() )
				.on( 'change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
					);

					column
					.search( val ? '^'+val+'$' : '', true, false )
					.draw();
				} );

				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		}
	} );

	var SIL = $('#SIL').DataTable( {
		dom: 'Bfrtip',
		responsive: true,
		// "order": [[ 7, "desc" ]],
		// "bInfo": true,
        buttons: [
            'excelHtml5',
            // 'pdfHtml5'
        ],
		"columnDefs": [],
		processing: true,
		initComplete: function () {
			$('.masterlistTable').removeAttr('style');
			$('.loading').attr('style','display: none');
			this.api().columns(0).every( function () {
				var column = this;
				var select = $('<select class="companySelect"><option value="">COMPANY</option></select>')
				.prependTo( $(column.header()).empty() )
				.on( 'change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
					);

					column
					.search( val ? '^'+val+'$' : '', true, false )
					.draw();
				} );

				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		}
	} );



	// Update Info
	$('#dataTable tbody').on('click', 'td button.edit', function () {
		var data = dataTable.row( $(this).closest('tr') ).data();
		console.log(data);
		$("#empName").html(data[5]+', '+data[6]+' '+data[7]);
		$("#empCompany").html(data[2]);
		$("#textRef").html(data[4]);
		$("#textCompID").html(data[3]);
		$("#textDhired").html(data[8]);
		//Get form value
		$(".error").html("");
		$("#Company_ID").val(data[3]);
		$("#Reference_Number").val(data[4]);
		$("#Contact_Number").val(data[9]);
		$("#Applicant_ID").val(data[11]);

		$("#SCompany_ID").val(data[3]);
		$("#SReference_Number").val(data[4]);
		$("#Name").val(data[5]+', '+data[6]+' '+data[7]);
		$("#Date_Hired").val(data[8]);
		$("#SVICompany").val(data[1]);

		$("#Address").val(data[10]);

		//Update Status
		$("#textDept").html((data[2] === '')? 'Not yet Assigned.': data[2]);

		$.ajax({
			url: 'contactInfo',
			type: 'GET',
			data: {applicant_ID: data[11]},
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				var contactPerson = JSON.parse(data)[0];
				$("#Contact_Person").val(contactPerson['Contact_Person']); 
				$("#Contact_Person_Number").val(contactPerson['Contact_Number']); 
			}
		});

		$.ajax({
			url: 'getApplicImage',
			type: 'GET',
			data: {applicant_ID: data[11]},
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				console.log(JSON.parse(data));
				$('#applicantImage').attr('src', "data:image/png;base64," + JSON.parse(data)[0]);
			}
		});
	} );


	// Update Status
	$('#forceleave tbody').on('click', 'td button.status', function () {
		var data = forceLeave.row( $(this).closest('tr') ).data();
		console.log(data);
		//Get form value
		$("#SCompany_ID").val(data[3]);
		$("#SReference_Number").val(data[2]);
		$("#Name").val(data[4]+', '+data[5]+' '+data[6]);
		$("#Date_Hired").val(data[8]);
		$("#SVICompany").val(data[7]);
		
		//Empty input date
		$("#Employment_Status").val("");
		$("#Reason").val("");
		$("#Last_Pay").val("");
		$("#Effective_Date").val("");
		$("#Other_Info").val("");
	} );

	// Update Status
	$('#toRTA tbody').on('click', 'td button.status', function () {
		var data = toRTA.row( $(this).closest('tr') ).data();
		console.log(data);
		//Get form value
		$("#SCompany_ID").val(data[4]);
		$("#SReference_Number").val(data[3]);
		$("#Name").val(data[5]+', '+data[6]+' '+data[7]);
		$("#Date_Hired").val(data[9]);
		$("#SVICompany").val(data[1]);
		$("#Employment_Status").val(data[8]);
		$("#Reason").val(data[10]);
		$("#Last_Pay").val(getDateInput(data[12]));
		$("#Effective_Date").val(getDateInput(data[11]));
		$("#Last_Duty").val(getDateInput(data[13]));
		$("#Other_Info").val(data[14]);
	} );
});

function getDateInput(data) {
	var now = new Date(data);
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	return today;
}


