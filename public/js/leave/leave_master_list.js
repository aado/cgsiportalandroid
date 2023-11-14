	document.addEventListener("DOMContentLoaded", function () {
		leaveMasterList();
	});

	var d = new Date();
  	var year = d.getFullYear();

	var startDate,
	endDate,
	updateStartDate = function() {
		startPicker.setStartRange(startDate);
		endPicker.setStartRange(startDate);
		endPicker.setMinDate(startDate);
		leaveMasterList();
	},
	updateEndDate = function() {
		startPicker.setEndRange(endDate);
		startPicker.setMaxDate(endDate);
		endPicker.setEndRange(endDate);
		leaveMasterList();
	},
	startPicker = new Pikaday({
		field: document.getElementById('date-from'),
		format: 'D MMM YYYY',
		defaultDate: new Date(d.getFullYear(), d.getMonth(), 1),
		setDefaultDate: true,
		maxDate: new Date(year, 12, 30),
		onSelect: function() {
			startDate = this.getDate();
			updateStartDate();
		}
	}),
	endPicker = new Pikaday({
		field: document.getElementById('date-to'),
		format: 'D MMM YYYY',
		defaultDate: new Date(),
		setDefaultDate: true,
		maxDate: new Date(year, 12, 31),
		onSelect: function() {
			endDate = this.getDate();
			updateEndDate();
		}
	}),
	_startDate = startPicker.getDate(),
	_endDate = endPicker.getDate();

	if (_startDate) {
		startDate = _startDate;
		updateStartDate();
	}

	if (_endDate) {
		endDate = _endDate;
		updateEndDate();
	}

	function leaveMasterList() {
		var table = "leaveMasterTable";
		let datefrom = document.getElementById('date-from').value;
		let dateto = document.getElementById('date-to').value;
		let formData = new FormData();
		formData.append('date_from', datefrom);
		formData.append('date_to', dateto);
		fetch('../api/leave/get_leave_master_list.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
		.then((res) => { return res.json() })
		.then((data) => {
			console.log(data);
			if(data=='0 results') {
				$("#notempty").html("<img src='../images/nodatafound.png' style='width: 100%'/>");
				$('#leaveMasterTable_wrapper').hide();
			} else {
				$('#notempty').html("");
				$('#leaveMasterTable_wrapper').show();
				$('#'+table).DataTable( {
					responsive: true,
					deferRender: true,
					columnDefs: [
						{ 
							"targets": [ 0 ],
							"visible": false 
						},
						{
							"targets": [ 16 ],
							"visible": false
						}
					],
					data: data,
					destroy: true,
					dom: 'Bfrtip',
					// initComplete: function () {
					// 	this.api().columns().every( function () {
					// 		var column = this;
					// 		var select = $('<select style="width: 20px"><option value=""></option></select>')
					// 			.appendTo( $(column.header()) )
					// 			.on( 'change', function () {
					// 				var val = $.fn.dataTable.util.escapeRegex(
					// 					$(this).val()
					// 				);
			 
					// 				column
					// 					.search( val ? '^'+val+'$' : '', true, false )
					// 					.draw();
					// 			} );
			 
					// 		column.data().unique().sort().each( function ( d, j ) {
					// 			select.append( '<option value="'+d+'">'+d+'</option>' )
					// 		} );
					// 	} );
					// },
					buttons: [
						// {
						// 	extend: 'copyHtml5',
						// 	exportOptions: {
						// 		columns: [ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12,14 ],
						// 		// format: {
						// 		// 	header: function ( data ) {
						// 		// 	  var n = data.indexOf('<select style="width: 20px">');
						// 		// 	  if (n > -1) {
						// 		// 		return data.substring(0, n);
						// 		// 	  } else {
						// 		// 		return data;
						// 		// 	  }
						// 		// 	}
						// 		// }
						// 	},
						// 	className: 'leave mdl-button mdl-js-button mdl-button--raised mdl-button--colored',
						// },
						// {
						// 	// extend: 'excelHtml5',
						// 	extend: 'excel',
						// 	exportOptions: {
						// 		columns: [ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12,14 ],
						// 		// format: {
						// 		// 	header: function ( data ) {
						// 		// 	  var n = data.indexOf('<select style="width: 20px">');
						// 		// 	  if (n > -1) {
						// 		// 		return data.substring(0, n);
						// 		// 	  } else {
						// 		// 		return data;
						// 		// 	  }
						// 		// 	}
						// 		// }
						// 	},
						// 	download: 'open',
						// 	className: 'leave mdl-button mdl-js-button mdl-button--raised mdl-button--colored',
						// },
						// {
						// 	// extend: 'pdfHtml5',
						// 	extend: 'pdf',
						// 	orientation: 'landscape',
						// 	pageSize: 'LEGAL',
						// 	exportOptions: {
						// 		columns: [ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12,14 ],
						// 		// format: {
						// 		// 	header: function ( data ) {
						// 		// 	  var n = data.indexOf('<select style="width: 20px">');
						// 		// 	  if (n > -1) {
						// 		// 		return data.substring(0, n);
						// 		// 	  } else {
						// 		// 		return data;
						// 		// 	  }
						// 		// 	}
						// 		// }
						// 	},
						// 	// download: 'open',
						// 	className: 'leave mdl-button mdl-js-button mdl-button--raised mdl-button--colored'
						// },
						// {
						// 	// extend: 'pdfHtml5',
						// 	extend: 'print',
						// 	orientation: 'landscape',
						// 	pageSize: 'LEGAL',
						// 	exportOptions: {
						// 		columns: [ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12,14 ],
						// 		format: {
						// 			header: function ( data ) {
						// 			  var n = data.indexOf('<select style="width: 20px">');
						// 			  if (n > -1) {
						// 				return data.substring(0, n);
						// 			  } else {
						// 				return data;
						// 			  }
						// 			}
						// 		}
						// 	},
						// 	className: 'leave mdl-button mdl-js-button mdl-button--raised mdl-button--colored'
						// },
					],
					columns: [
						{ data: 'emp_id', title: "ID"},
						{ 
							data: 'fullname', title: "FULLNAME",
							render:function(data, type, row)
							{
								image = "../images/idpicture/noimage.jpg";
								var table = '<div class="main-card mb-3 card" style="margin-top: 0px; width: 200px;">';
								table += '<div>';
								table += '<tbody>';
								if (data !== '') {
									table += '<tr>';
										table += '<td>';
											table += '<div class="widget-content p-0">';
											table += '<div class="widget-content-wrapper">';
											table += '<div class="widget-content-left mr-3">';
												table += '<div class="widget-content-left">';
													table += '<img width="40" class="rounded-circle" src="../images/idpicture/'+row.emp_id+'.jpg" alt="" onerror="ImgError(this)"/>';
												table += '</div>';
											table += '</div>';
											table += '<div class="widget-content-left flex2">';
											table += '<div class="widget-heading">'+row.fullname+'</div>';
											table += '<div class="widget-subheading opacity-7">'+row.emp_id+'</div>';
											table += '<div class="widget-subheading opacity-7">'+row.designation+'</div>';
											table += '</div>';
											table += '</div>';
											table += '</div>';
											table += '</td>';
											table += '<td class="text-center">';
										table += '</td>';
									table += '</tr>';
								} else {
									table += '<tr><td colspan="3" style="text-align: center;">No approver yet.</td></tr>';
								}
											
								table += '</tbody>';
								table += '</table>';
								table += '</div>';
								table += '</div>';
								return table;
							}	 
						},
						{ 
							data: 'leave_type', title: "TYPE",
							render: function(data, type, row) {
								var table = '<div class="main-card mb-3 card" style="margin-top: 0px; width: 100px;">';
								table += '<div>';
								table += '<tbody>';
								if (row.application_type == 2) {
									table += '<tr>';
										table += '<td>';
											table += '<div class="widget-content p-0">';
											table += '<div class="widget-content-wrapper">';
											table += '<div class="widget-content-left mr-3">';
											table += '</div>';
											table += '<div class="widget-content-left flex2">';
											table += '<div class="widget-heading">'+data+'</div>';
											table += '<div class="widget-subheading opacity-7">Undertime</div>';
											table += '<div class="widget-subheading opacity-7">'+row.time_undertime+'</div>';
											table += '</div>';
											table += '</div>';
											table += '</div>';
										table += '</td>';
									table += '</tr>';
								} else {
									table += '<tr>';
										table += '<td>';
											table += '<div class="widget-content p-0">';
											table += '<div class="widget-content-wrapper">';
											table += '<div class="widget-content-left mr-3">';
											table += '</div>';
											table += '<div class="widget-content-left flex2">';
											table += '<div class="widget-heading">'+data+'</div>';
											table += '</div>';
											table += '</div>';
											table += '</div>';
										table += '</td>';
									table += '</tr>';
								}
											
								table += '</tbody>';
								table += '</table>';
								table += '</div>';
								table += '</div>';

								return table;
							}
						},
						{ data: 'application_type', title: "APPLICATION TYPE",
							render: function(data,type,row) {
								if(data == 2) {
									return 'UNDERTIME';
								} else {
									return 'LEAVE';
								}
							} 
					
						},
						{ data: 'department', title: "Department" },
						{ data: 'designation', title: "Designation" },
						{ data: 'apply_date', title: "Filed" },
						{ data: 'date_from', title: "From" },
						{ data: 'date_to', title: "To" },
						{ 
							data: 'total_leave_credit', 
							title: "LEAVE CREDIT", 
							render:function(data, type, row)
							{

								var table = '<div class="main-card mb-3 card" id="'+row.leaveid+'-creditinfo">';
									table += '<div class="card-header" style="background: cornflowerblue;color: white;font-weight: bold;">LEAVE CREDIT INFO</div>';
								table += '<div class="table-responsive">';
								table += '<table class="align-middle mb-0 table table-borderless table-striped table-hover">';
								table += '<thead>';
									table += '<tr class="text-center">';
										table += '<th>TOTAL</th>';
										table += '<th class="text-center">USED</th>';
										table += '<th class="text-center">LEFT</th>';
									table += '</tr>';
								table += '</thead>';
								table += '<tbody>';
										table += '<tr>';
											table += '<td class="text-center">';
											table += data;
											table += '</td>';
											table += '<td class="text-center">';
											table += row.leave_used;
											table += '</td>';
											table += '<td class="text-center">';
											table += row.leave_left;
											table += '</td>';
										table += '</tr>';
											
								table += '</tbody>';
								table += '</table>';
								table += '</div>';
								table += '</div>';
								return ''+table;
							}	

						},
						{ data: 'num_days_leave', title: "DAY NO." },
						{ data: 'reason', title: "REASON" },
						{ data: 'contact_number', title: "CONTACT" },
						{ 
							data: 'leave_days_remarks', 
							title: "DAY REMARKS  <br /><span style='opacity: .5;font-size: 11px;'>below date(s) are half day, undertime and w/out pay only.</span>",
							render: function(data, type, row) {
								splitDayCover = [];
								splitDay = [];
								splitDayUnder = [];
								if (row.leave_days_remarks !== '' || row.cover_day !== '' || row.undertime !== '') {
									let result = '<table style="width: 100%;"><tr><td style="text-align: center;">DAY</td><td style="text-align: center;">TERM</td></tr>';
									try {

										splitDay = (JSON.parse(row.leave_days_remarks));
										splitDay.forEach((dayRems) =>{
											result += '<tr><td style="text-align: center;">'+dayRems.dayName.replace(/_/g,' ')+'</td><td style="text-align: center;">'+dayRems.term+'</td></tr>';
										});	

									}catch(err) {}

									//day cover
									let resultCover = '<table style="width: 100%;"><tr><td colspan=2 style="text-align: center;">HALF DAY</td></tr>';
									try {

										splitDayCover = (JSON.parse(row.cover_day));
										splitDayCover.forEach((dayRems) =>{
											resultCover += '<tr><td style="text-align: center;">'+dayRems.dayName.replace(/_/g,' ')+'</td><td style="text-align: center;">'+dayRems.Cover+'</td></tr>';
										});	

									}catch(err) {}


									if (row.leave_days_remarks == '' || row.leave_days_remarks == '[]') {
										result += '<tr><td colspan=2 style="text-align: center">All Day is With Pay</td></tr>';
									} 
									if(row.cover_day == '' || row.cover_day == '[]') {
										resultCover += '<tr><td colspan=2 style="text-align: center">No half day.</td></tr>';
									} 

									return '<br />'+result+'</table> '+resultCover+'</table>';
								} else {
									return '<br />No Remark';
								}


							}
						},
						{ 
							data: 'leave_status', 
							title: "Leave Status",
							render:function(data, type, row)
							{			
								let badgeStat = '';
								if (data == "Pending") {
									badgeStat = '<span class="badge badge-default">'+data+'</badge>'; 
								} else if (data == "Approved") {
									badgeStat = '<span class="badge badge-success">'+data+'</badge>'; 
								} else if(data == "Cancelled") {
									badgeStat = '<span class="badge badge-danger">'+data+'</badge>'; 
								}
								return badgeStat;
							}	
						},
						{
							"data": 'approver_info',
							render:function(data, type, row)
							{
								var table = '<div class="main-card mb-3 card" style="margin-top: -15px;">';
									table += '<div class="card-header" style="background: cornflowerblue;color: white;font-weight: bold;">APPROVER</div>';
								table += '<div class="table-responsive">';
								table += '<table class="align-middle mb-0 table table-borderless table-striped table-hover">';
								table += '<thead>';
								table += '<tr>';
								table += '<th>Name</th>';
								table += '<th class="text-center">Status</th>';
								table += '</tr>';
								table += '</thead>';
								table += '<tbody>';
								if (data !== '') {
									data.forEach((approver) => {
										table += '<tr>';
											table += '<td>';
												table += '<div class="widget-content p-0">';
												table += '<div class="widget-content-wrapper">';
												table += '<div class="widget-content-left mr-3">';
												table += '<div class="widget-content-left">';
												table += '<img width="40" class="rounded-circle" src="../images/idpicture/'+approver.approver_emp_id+'.jpg" alt=""  onerror="ImgError(this)">';
												table += '</div>';
												table += '</div>';
												table += '<div class="widget-content-left flex2">';
												table += '<div class="widget-heading">'+approver.fullname+'</div>';
												table += '<div class="widget-subheading opacity-7">'+approver.designation+'</div>';
												table += '</div>';
												table += '</div>';
												table += '</div>';
												table += '</td>';
												table += '<td class="text-center">';
												table += '<div class="badge badge-'+approver.badge+'">'+approver.leave_remarks.toUpperCase()+'</div><div class="widget-subheading opacity-7">'+approver.date_created+'</div>';
											table += '</td>';
										table += '</tr>';
									});	
								} else {
									table += '<tr><td colspan="3" style="text-align: center;">No approver yet.</td></tr>';
								}
											
								table += '</tbody>';
								table += '</table>';
								table += '</div>';
								table += '</div>';
								return table;
							}	
						},
						{
							"data": 'approver_info',
							title: 'Leave Approver',
							render:function(data, type, row)
							{
								var table = '';				
								table +="";	
								if (data !== '') {
									data.forEach((approver) => {
										table += 'Remarks: '+approver.leave_remarks+'<br/> Date: '+approver.date_created+' <br/>Approver Name: '+approver.fullname+' <br /> Approver Designation: '+approver.designation+'<br /> ';
									});	
								} else {
									table += '';
								}
								return table;
							}	
						},
					]
				} );
			}
		})
		.catch((err) => console.log(err))
	}

	function ImgError(source){
		source.src = "http://180.232.152.179:80/cgsiapplication/images/idpicture/noimage.jpg";
		source.onerror = "";
		return true;
	}