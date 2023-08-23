var base_url = window.location.origin;
baseURL = base_url+'/cgsiportal/';
$( document ).ready( function () {

	var date = new Date();
	$("#date_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());
	$("#undate_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());

	
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
	var table = $('#datatableidreceived').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
			{
                target: [],
                visible: false,
            },
		],
		order: [[ 0, 'desc' ]],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	 // Add event listener for opening and closing details
	 $('#datatableidreceived tbody').on('click', 'td.details-control', function(){
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if(row.child.isShown()){
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data(),$(this).data('site'))).show();
            tr.addClass('shown');
        }
    });

	
function format ( d, site ) {
	console.log(d);
	$.ajax({
		url: 'getPOInfo',
		type: 'POST',
		data: {ponumber: d[1], site: site},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {

			var result = JSON.parse(data);
			var vatYesNo = '';

			if(result['success']) {

				console.log(result);
				$("#Address"+d[1]+site).html(' '+(result['data'][0]['Address'].length == 0)? ' '+result['data'][0]['Address']:'');
				$("#telNo"+d[1]+site).html(' '+(result['data'][0]['CellNo'].length == 0)? ' '+result['data'][0]['CellNo']:'');
				$("#contactPerson"+d[1]+site).html(' '+(result['data'][0]['Contact_Person'].length == 0)? ' '+result['data'][0]['Contact_Person']:'');
				$("#orderDate"+d[1]+site).html(' '+(result['data'][0]['Order_Date'].length == 0)? ' '+result['data'][0]['Order_Date']:'');
				$("#deliveryDate"+d[1]+site).html(' '+(result['data'][0]['Delivery_Date'].length == 0)? ' '+result['data'][0]['Delivery_Date']:'');
				$("#cancelDate"+d[1]+site).html(' '+(result['data'][0]['Cancel_Date'].length == 0)? ' '+result['data'][0]['Cancel_Date']:'');
				$("#termsPayment"+d[1]+site).html(' '+(result['data'][0]['TOP'].length == 0)? ' '+result['data'][0]['TOP']:'');
				$("#Sup_TIN"+d[1]+site).html(' '+(result['data'][0]['Sup_TIN'].length == 0)? ' '+result['data'][0]['Sup_TIN']:'');
				$("#Note"+d[1]+site).html(' '+(result['data'][0]['Note'].length == 0)? ' '+result['data'][0]['Note']:'');

				$("#Vatsale"+d[1]+site).html(' '+(result['data'][0]['Vatsale'] !== '0' && result['data'][0]['NonVAt'] === '0')? ' '+result['data'][0]['Vatsale']:' '+result['data'][0]['NonVAt']);
				$("#AddedTax"+d[1]+site).html(' '+(result['data'][0]['AddedTax'].length == 0)? ' '+result['data'][0]['AddedTax']:'');
				$("#TotalAmount"+d[1]+site).html(' '+(result['data'][0]['Vatsale'] !== '0' && result['data'][0]['NonVAt'] === '0')? ' '+result['data'][0]['TotalAmount']:''+result['data'][0]['TotalWNVAt']);

				// Check if Vatsale not equal to 0
				$("#vatTitle"+d[1]+site).html(' '+(result['data'][0]['Vatsale'] !== '0')? 'Vatable':'NON-VATABLE');
				
				if(result['data'][0]['Vatsale'] === '0' && result['data'][0]['NonVAt'] !== '0') {
					$("tr#trAddedTax"+d[1]+site).attr('style','display:none');
				}

				if(result['data'][0]['Vatsale'] !== '0' && result['data'][0]['NonVAt'] === '0') {
					$("tr#trAddedTax"+d[1]+site).removeAttr('style');
				}
				var sig = '', name = '', mamRose = '<br><br>';

				if (site == 1) {
					sig = 'mamchona.png';
					name = 'MA. CHONA LIM';
				} else {
					sig = 'misshoney.png';
					name = 'HONEY JOY POLINAR';
				}
				$("#preparedBy"+d[1]+site).attr("src","public/img/voucher/"+sig+"");
				$("#purchaserName"+d[1]+site).html(name);
				$("#vatYesNo"+d[1]+site).html(vatYesNo)

				// trigger modal
				$("#btnapr"+d[1]+site).attr('data-ponum',result['data'][0]['PO_Number']);
				$("#btnapr"+d[1]+site).attr('data-supplier',result['data'][0]['PO_Supplier']);
				$("#btnret"+d[1]+site).attr('data-ponum',result['data'][0]['PO_Number']);
				$("#btnret"+d[1]+site).attr('data-supplier',result['data'][0]['PO_Supplier']);
				$("#btnrej"+d[1]+site).attr('data-ponum',result['data'][0]['PO_Number']);
				$("#btnrej"+d[1]+site).attr('data-supplier',result['data'][0]['PO_Supplier']);

				if (result['data'][0]['PO_Status'] === 'Approved' && result['data'][0]['PO_StatusTag'] === '2' ) {
					mamRose = '<img class="img" src="public/img/voucher/mamroseheray.png" width="155" height="70">';
				}
				$("#mamRoseSig"+d[1]+site).html(mamRose);

				var xhr = new XMLHttpRequest();
				xhr.open("GET", base_url+"/PO/uploads/"+result['data'][0]['PO_Number']+"/", true);
				xhr.responseType = 'document';
				xhr.onload = () => {
				if (xhr.status === 200) {
					var elements = xhr.response.getElementsByTagName("a");
					for (x of elements) {
					if ( x.href.match(/\.(jpe?g|png|gif)$/) ) { 
						$("#image_pane"+d[1]+site).append('<a class="'+d[1]+site+'" href="'+x.href+'" data-fancybox="gallery" data-src="'+x.href+'" data-caption="Attachment of PO Number: '+result['data'][0]['PO_Number']+', SUPPLIER: '+result['data'][0]['PO_Supplier']+'"><img class="shadow p-3 mb-5 bg-white rounded attachment" src="'+x.href+'"/></a>');
					} 
					};
				} 
				else {
					// alert('Request failed. Returned status of ' + xhr.status);
					$("#image_pane"+d[1]+site).html('No attachment.')
				}
				}
				xhr.send()

			} 
		}
	});
	$.ajax({
		url: 'getPODetails',
		type: 'POST',
		data: {ponumber: d[1], site: site},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			if(result['success']) {
				var trHTML = '';
				$.each(result['data'], function (i, item) {
					trHTML += '<tr style="font-weight: initial; font-size: smaller"><td>' + item.ItemQty + '</td><td>' + item.ItemUnit + '</td><td>' + item.ItemDesc + '</td><td  style="text-align:right;">' + item.ItemCost + '</td><td  style="text-align:right;">' + item.Total_Cost + '</td></tr>';
				});
				$('#poTable'+d[1]+site).append(trHTML);
			} else {
				trHTML += '<tr><td></td><td></td><td></td><td  style="text-align:right;"></td><td  style="text-align:right;"></td></tr>';
				$('#poTable'+d[1]+site).append(trHTML);
			}
		}
	});
	
    return '<div class="card shadow p-3 mb-5 bg-white rounded">'+
					'<div class="card-body" style="background-color: #FFE4FA;" oncopy="return false" onpaste="return false" oncut="return false">'+ 
						'<div class="row">'+
							'<div class="col" style="text-align:right;">'+
							'</div>'+
							'<div class="col" >'+
								'<img class="img" src="public/img/headerPO.png"  height="100" width="550">'+
							'</div>'+
							'<div class="col">'+
							'</div>'+
						'</div>'+
						'<div class="row" >'+
							'<div class="col-6">'+

							'</div>'+
							'<div class="col" style="text-align: RIGHT;">'+
								'<p style="font-size: 18px;font-weight: 700;">'+
									'PO. NO.'+
								'</p>'+
							'</div>'+
							'<div class="col" >'+
								'<p style="font-size: 18px;font-weight: 700;text-align: LEFT;margin-left: -15px;color:red" id="PONumber">'+
								' '+d[1]+'' +
								'</p>'+
							'</div>'+
						'</div>'+
						'<div class="row">'+
							'<div class="col">'+
							'</div>'+
							'<div class="col" style="text-align: center;font-size: 25px;">'+
								'<p style="font-size: 27px;font-weight: 700;">'+
									'PURCHASE ORDER'+
								'</p>'+
							'</div>'+
							'<div class="col">'+
							'</div>'+
						'</div>'+
						'<div class="row" style="font-weight: 700;">'+
							'<div class="col">'+
								'<span style="font-size: 12px;"> Supplier:</span>'+
								'<span style="font-size: 12px;">'+
									' '+d[2]+'' +
								'</span>'+
								'<br>'+
								'<span style="font-size: 12px;"> Address:</span>'+
								'<span style="font-size: 12px;" id="Address'+d[1]+site+'"></span>'+
								'<br>'+
								'<span style="font-size: 12px;"> Tel No:</span>'+
								'<span style="font-size: 12px;" id="telNo'+d[1]+site+'"></span>'+
								'<br>'+
								'<span style="font-size: 12px;"> Contact Person: </span>'+
								'<span style="font-size: 12px;" id="contactPerson'+d[1]+site+'"></span>'+
							'</div>'+
							'<div class="col-5">'+
							'</div>'+
							'<div class="col" style="text-align: left;">'+
								'<span style="font-size: 12px;">' +
									'Order Date:'+
								'</span>'+
								'<span style="font-size: 14px;margin-left: 40px;" id="orderDate'+d[1]+site+'"></span>'+
								'<br>'+
								'<span style="font-size: 12px;">'+
									'Delivery Date: '+
								'</span>'+
								'<span style="font-size: 14px;margin-left: 25px;" id="deliveryDate'+d[1]+site+'"></span>'+
								'<br>'+
								'<span style="font-size: 12px;"> Cancel Date: </span>'+
								'<span style="font-size: 14px;margin-left: 35px;" id="cancelDate'+d[1]+site+'"></span>'+
								'<br>'+
								'<span style="font-size: 12px;"> Terms of payment:</span>'+
								'<span style="font-size: 14px;" id="termsPayment'+d[1]+site+'"></span>'+
							'</div>'+
							'<div class="row" style="margin-bottom: 25px!important;font-weight: 700;">'+
								'<div class="col">'+
								'</div>'+
								'<div class="col" style="text-align: center;">'+
									'<span style="font-size: 12px;"> TIN:</span>'+
									'<span style="font-size: 14px;" id="Sup_TIN'+d[1]+site+'"></span>'+
								'</div>'+
								'<div class="col" style="text-align: right;">'+
								'</div>'+
							'</div>'+
							'<table class="table table-bordered" id="poTable'+d[1]+site+'" style="width:100%">'+
								'<tr>'+
									'<th> Qty </th>'+
									'<th> Units </th>'+
									'<th> Description</th>'+
									'<th> Unit Cost </th>'+
									'<th>Total Cost</th>'+
								'</tr>'+
							'</table>'+
							'<div class="row">'+
								'<div class="col-6" >'+
									'NOTE: <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0" style="font-weight: lighter;" id="Note'+d[1]+site+'"></div>'+
								'</div>'+
							'</div>'+
							'<table class="borderless" style="width:100%; font-size: small;font-weight: 500;" >'+
								'<tr>'+
									'<td>  </td>'+
									'<td >  </td>'+
									'<td style="width: 64%;">  </td>'+
									'<td style="text-align: right"> <span id="vatTitle'+d[1]+site+'"> Vatable </span> >>>>>>>> </td>'+
									'<td > <span style="font-size: 14px;font-weight: 700;" id="Vatsale'+d[1]+site+'"></span> </td>'+
								'</tr>'+
								'<tr id="trAddedTax'+d[1]+'">'+
									'<td>  </td>'+
									'<td >  </td>'+
									'<td >  </td>'+
									'<td style="text-align: right"> Value Added Tax >>>>>>>> </td>'+
									'<td > <span style="font-size: 14px;font-weight: 700;" id="AddedTax'+d[1]+site+'"></span> </td>'+
								'</tr>'+
								'<tr>'+
									'<td>  </td>'+
									'<td >  </td>'+
									'<td >  </td>'+
									'<td style="text-align: right"> Total Amount >>>>>>>> </td>'+
									'<td > <span style="font-size: 14px;font-weight: 700;" id="TotalAmount'+d[1]+site+'"></span> </td>'+
								'</tr>'+
							'</table>'+
							'<div class="row">'+
								'<div class="col" id="termsandcondition" style="border: 1px solid;margin: 18px;">'+
									'<b>'+
										'<u style= "font-size: 11px!important;">'+
											'Terms and Condition:'+
										'</u>'+
										'<p style= "font-size: 11px!important;font-style: oblique; font-weight: lighter; text-align: justify">'+
											'After acceptance of the order, you bind yourself to pay to CEBU GENERAL SERVICES, INC. for any loss and/or damage suffered by the company due to late delivery for any of the articles called herein or failure to comply with the terms and conditions of the order. The supplier hereby submits itself and agrees to pay 5% of the amount per day of the delayed items. All invoices and delivery receipt should be attached to the original copy of the purchased order upon delivery. CEBU GENERAL SERVICES, INC. have the right to reject all good in bad order condition and/or not accordance with the specification of our order. All expense related hereto are for the accounts of the supplier. The purchase order is not valid without the signature of the company authorize signatory.'+
										'</p>'+
									'</b>'+
								'</div>'+
							'</div>'+
							'<div class="row">'+
								'<div class="col" style="border-left: 1px solid;border-left: 1px solid;border-bottom: 1px solid;text-align: center;margin-top: -20px;margin-left: 18px">	'+				                 
									'<span style= "font-size: 12px!important;font-weight: 700;"> '+
										'Prepared by:'+
									'<br>'+
										'<img class="img" id="preparedBy'+d[1]+site+'" width="155" height="70"/>'+	
										'<br>'+
											'<div style="margin-top: -25px;font-size:12px!important;">'+
												'<span id="purchaserName'+d[1]+site+'"></span>'+
												'<br>'+
												'Purchaser'+
											'</div>'+						
									'</span>'+
								'</div>'+
								'<div class="col-6" style="border-bottom: 1px solid;border-left: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;">'+
									'<span style= "font-size: 12px!important;font-weight: 700;">'+
										'Verified by:'+
										'<br>'+
										'<span id="mamRoseSig'+d[1]+site+'"></span>'+
										'<br>'+
										'<div style="margin-top: -35px;font-size:12px!important;">'+
												'MS. ROSE HERAY'+
												'<br>'+
												' Finance & Acctg. Manager'+
										'</div>'+
									'</span>'+
								'</div>'+
								'<div class="col" style="border-bottom: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;margin-right: 18px;">'+
					                     		
					                    	'<span style= "font-size: 12px!important;font-weight: 700">' +
					                    		'Approved by:'+
						                	'<br>'+
						                    	'<br>'+
						                    	'<div style="margin-top: 16px;font-size:12px!important;">'+
				 										'MRS. GRACE ILIGAN'+
				 										'<br>'+
				 										'President'+
				 								'</div>'+
					                    	'</span>'+
					                    '</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<h4 style="text-align:center; margin-top: 15px"> ATTACHMENTS </h4>'+
					'<div id="image_pane'+d[1]+site+'" class="gallery attachment" style="padding: 10px"></div>'+
					'<div class="float" style="position: fixed;right: 60px;margin-right: 3px;padding-bottom: 27px;">'+
							'<button type="button" id="btnapr'+d[1]+site+'" class="btn btn-success approvedbtn" data-id="1" data-toggle="modal" data-target="#statusModal" style="    width: 200px;margin: 10px;display: block;margin-bottom: 0px;"><i class="fa fa-check"></i>'+ ' APPROVE </button>'+
							'<button type="button" id="btnret'+d[1]+site+'"  class="btn btn-secondary approvedbtn" data-id="2" data-toggle="modal" data-target="#statusModal" style="width:200px; margin: 10px"><i class="fa fa-arrow-left"></i>'+ ' RETURN </button>'+
							'<button type="button"  id="btnrej'+d[1]+site+'" class="btn btn-danger approvedbtn" data-id="3" data-toggle="modal" data-target="#statusModal" style="    margin-bottom: 9px;width: 200px;display: block;margin-left: 9px;"><i class="fa fa-times"></i>' +' REJECT </button>'+
					'</div>'+
			 '</div>';
}

var tableLuzon = $('#datatableidLuzon').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		order: [[1, 'desc']],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	 // Add event listener for opening and closing details
	 $('#datatableidLuzon tbody').on('click', 'td.details-control', function(){
        var tr = $(this).closest('tr');
        var row = tableLuzon.row( tr );

        if(row.child.isShown()){
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data(),$(this).data('site'))).show();
            tr.addClass('shown');
        }
    });

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

	$('#datatableidhistory_visayas').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [
		],
		order: [[1, 'desc']],
		pageLength : 5,
		lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
		processing: true,
		initComplete: function () {}
	} );

	$('#datatableidreceived tbody').on('click', '.approvedbtn', function(){
		var status = ($(this).data('id'));
		if(status == 1){
			$("#exampleModalLabel").html("Approve PO?");
		}else if(status == 2)
		{
			// status = 2;
			$("#exampleModalLabel").html("Return PO?");
		}else
		{
			status = 3;
			$("#exampleModalLabel").html("Reject PO?");
		}
		$("#po_no").val($(this).data('ponum'));
		$("#POSupplier").html($(this).data('supplier'));
		$('#statustype').val(status);
    });
	/* Formatting function for row details - modify as you need */

	$('.approvedbtn').on('click',function()
	{
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
			$("#exampleModalLabel").html("Approve PO?");
		}else if(title == 'return')
		{
			status = 2;
			$("#exampleModalLabel").html("Return PO?");
		}else
		{
			status = 3;
			$("#exampleModalLabel").html("Reject PO?");
		}

		$('#statustype').val(status);
		$('#entrydate_approved').val(data[0]);
		$('#voucher_no').val(data[1]);
	});

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

	$("#formStatus").submit(function(e) {
		e.preventDefault();
		confirmStatus();
	});


} );

function changeStatus(stat) {
	console.log(stat);
}

function confirmStatus() {
	var frmSerialize = $("#formStatus").serialize();
	console.log(frmSerialize);
	// $.ajax({
	// 	url: baseURL+'savePOStatus',
	// 	type: 'POST',
	// 	data: frmSerialize,
	// 	error: function() {	
	// 		alert('Something is wrong');
	// 	},
	// 	success: function(data) {
	// 		var result = JSON.parse(data);
	// 		if(result['success']) {
	// 			location.href=baseURL+'recievedpo';
	// 		}
	// 	}
	// });
}

function getPODetails(ponumber, site) {
	$.ajax({
		url: 'getPODetails',
		type: 'POST',
		data: {ponumber: ponumber, site: site},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			console.log(result);
			// if(result['success']) {
			// 	location.href=baseURL+'recievedpo';
			// }
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
    // alert(count);
    return count;
}

function backButton(locstatus) {
	location.href=baseURL+locstatus;
	// if(locstatus == 'cancellpo') {
	// 	$("#statusBtn").attr('style','display: none');
	// }
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


		