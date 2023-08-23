	document.addEventListener("DOMContentLoaded", function () {
		leaveList(1);
		$('[data-toggle="tooltip"]').tooltip();
	});

	function leaveList(leaveStat) {
		var table = "leaveTable"+leaveStat;
		let formData = new FormData();
		formData.append('leave_stat', leaveStat);
		fetch('../api/leave/get_leave_list.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
		.then((res) => { return res.json() })
		.then((data) => {
			if(data=='0 results') {
				$("#table"+leaveStat).html("<img src='../images/nodatafound.png' style='width: 100%'/>");
			} else {
				$('#'+table).DataTable( {
					responsive: true,
					data: data,
					destroy: true,
					lengthChange: false,
					order: [[ 5, 'asc' ]],
					columnDefs: [
						{
							"targets": [ 0 ],
							"visible": false
						},
					],
					columns: [
						{ data: 'emp_id', title: "ID" },
						{ 
							data: 'fullname', title: "FULLNAME",
							render:function(data, type, row)
							{
								image = "../images/idpicture/noimage.jpg";
								var table = '<div class="main-card mb-3 card" style="margin-top: 0px; width: 150px;">';
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
											table += '<div class="widget-subheading opacity-7" style="font-style: italic">'+row.reason.substr(0,15).toLowerCase()+'..</div>';
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
												// table += '<div class="widget-subheading opacity-7">'+row.reason+'</div>';
												table += '<div class="widget-subheading opacity-7" style="font-style: italic">'+row.reason.substr(0,15).toLowerCase()+'..</div>';
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
						{ data: 'department', title: "DEPARTMENT" },
						
						{ data: 'designation', title: "DESIGNATION" },
						{ data: 'apply_date', title: "FILED", 
							render: function(data, type, row) {
								return moment(data).format('ddd D MMM YYYY')
							}
						},
						{ data: 'date_from', title: "FROM",
							render: function(data, type, row) {
								return moment(data).format('ddd D MMM YYYY')
							} 
						},
						{ data: 'date_to', title: "TO",
							render: function(data, type, row) {
								return moment(data).format('ddd D MMM YYYY')
							}
						},
						{ data: 'num_days_leave', title: "NO. DAY" },
						{ 
							data: 'leave_days_remarks', 
							title: "DAY REMARKS <br /><span style='opacity: .5;font-size: 11px;'>below date(s) are half day, undertime and w/out pay only.</span>",
							render: function(data, type, row) {
								splitDayCover = [];
								splitDay = []
								if (row.leave_days_remarks !== '' || row.cover_day !== '') {
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
						{ data: 'application_type', title: "APPLICATION",
							render: function(data,type,row) {
								if(data == 2) {
									return 'UNDERTIME <span style="font-weight:bold; margin-left: 50px;">Time: </span> <span>'+row.time_undertime+'</span>';
								} else {
									return 'LEAVE';
								}
							} 
					
						},
						{ data: 'reason',
							render: function(data,type,row) {
								table = "<table style='width:100%; margin-top:-30px'><th style='text-align:center;'>REASON</th>";
								if(row.attachment !== '' ) {
									attachment =  '<tr><td style="font-style:italic;">'+row.reason+'</td></tr>';
									attachment += '<tr><td><div class="container"><img style="width:100px; margin-left:100px" id="attachment'+row.leaveid+'" src="../api/leave/attachments/'+row.attachment+'" /><span class="material-icons zoom" style="font-size: 40px;position: relative; color: blue" onclick="zoomAttachment('+row.leaveid+','+leaveStat+')" id="zoomAttach'+row.leaveid+'">zoom_in</span></div></td></tr>';
								} else {
									attachment =  '<tr><td style="font-style:italic;">'+row.reason+'</td></tr>';
								}
								return table+attachment+'</table>';
							} 
					
						},
						{ data: 'contact_number', title: "CONTACT NUMBER"},
						{ 
							data: 'leave_status', 
							title: "STATUS",
							render:function(data, type, row)
							{			
								let badgeStat = '';
								if (data == "Pending") {
									badgeStat = '<span class="badge badge-default">'+data+'</badge>'; 
								} else if (data == "Approved") {
									badgeStat = '<span class="badge badge-success">'+data+'</badge>'; 
								} else if(data == "Cancelled") {
									badgeStat = '<span class="badge badge-danger">REJECTED</badge>'; 
								}
								return badgeStat;
							}	
						},
						{ 
							data: 'total_leave_credit', 
							title: "LEAVE CREDIT", 
							render:function(data, type, row)
							{

								var table = '<i class="fas fa-chevron-circle-down" onclick="toggleCredit('+row.leaveid+','+leaveStat+')" style="position: relative;left: 10px;"></i><div class="main-card mb-3 card" id="'+row.leaveid+'-creditinfo" style="display: none">';
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
										rejectReason = '';
										if (approver.leave_remarks == "Rejected") {
											rejectReason = 'REASON: '+approver.reject_reason;
										}
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
												table += '<div class="badge badge-'+approver.badge+'">'+approver.leave_remarks.toUpperCase()+'</div><div class="widget-subheading opacity-7">'+approver.date_created+'<span style="display: block; font-size: 10px">'+rejectReason+'</span></div>';
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
							"data": 'leaveid',
							render:function(data, type, row)
							{	
								// filter button for approval leave
								let buttonApproved = '';
								if (row.position_type == "4") {
									if(leaveStat == 1) {
										if(row.appr_inter_head == '2' && row.sessionID == 0) {
											buttonApproved = '<button class="actionBtn mdl-button mdl-button--raised mdl-button--colored dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button><button class="actionBtn mdl-button mdl-button--raised mdl-button--accent dialog-button" onclick="onclickAction('+data+','+leaveStat+',2)"><i class="fas fa-times"></i> Reject</button></div>';
										} else if (row.appr_inter_head == '0' && row.sessionID == 1) {
											buttonApproved = '<button class="actionBtn mdl-button mdl-button--raised mdl-js-button dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button><button class="btn btn-danger actionBtn" onclick="onclickAction('+data+','+leaveStat+',2)"><i class="fas fa-times"></i> Reject</button></div>';
										}
									} 
								} else if ( row.position_type == 1 && row.appr_inter_head !== '2' ) {
									if(leaveStat == 1) { 
										buttonApproved = '<button class="btn btn-primary actionBtn mdl-button mdl-button--raised mdl-button--colored dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button><button class="mdl-button mdl-button--raised mdl-button--accent dialog-button actionBtn" onclick="onclickAction('+data+','+leaveStat+',2)"><i class="fas fa-times"></i> Reject</button></div>';
									} else if (leaveStat == 3) {
										buttonApproved = '<button class="btn btn-primary actionBtn mdl-button mdl-button--raised mdl-button--colored dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button></div>';
									}
								} else if (row.position_type == 2 && row.appr_hr_manager !== '2') {
									if(leaveStat == 1) { 
										buttonApproved = '<button class="btn btn-primary actionBtn mdl-button mdl-button--raised mdl-button--colored dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button><button class="mdl-button mdl-button--raised mdl-button--accent dialog-button actionBtn" onclick="onclickAction('+data+','+leaveStat+',2)"><i class="fas fa-times"></i> Reject</button></div>';
									} else if (leaveStat == 3) {
										buttonApproved = '<button class="btn btn-primary actionBtn mdl-button mdl-button--raised mdl-button--colored dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button></div>';
									}
								} else if (row.position_type == 3 && row.appr_president !== '2') {
									if(leaveStat == 1) { 
									buttonApproved = '<button class="btn btn-primary actionBtn mdl-button mdl-button--raised mdl-button--colored dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button><button class="mdl-button mdl-button--raised mdl-button--accent dialog-button actionBtn" onclick="onclickAction('+data+','+leaveStat+',2)"><i class="fas fa-times"></i> Reject</button></div>';
									} else if (leaveStat == 3) {
										buttonApproved = '<button class="btn btn-primary actionBtn mdl-button mdl-button--raised mdl-button--colored dialog-button" onclick="onclickAction('+data+','+leaveStat+',1)"><i class="fas fa-check"></i> Approve</button></div>';
									}
								} 
								return '<div class="modal-content2" id="approvedLeave'+data+'" style="display: none"><p id="modalContent'+data+'" style="font-size: 15px;">Are you sure you want to <span id="msg'+data+'"></span> this leave?</p><div class="form-group" id="reason'+data+'" style="display: none"><label>REASON</label><input id="reason'+data+'" style="width:100%" onkeyup="addRejectReason('+data+','+leaveStat+')"/></div><div class="modal-footer"><button class="btn btn-danger"  onclick="closeModal('+data+','+leaveStat+')">Cancel</button><button id="submitYes'+data+'" class="btn btn-primary" style="width: 50%"><i class="fas fa-check"></i> Yes</button></div></div><div id="error-'+data+'"></div></div><div class="divActionBtn">'+buttonApproved;
							}
						}
					]
				} );
			}
		})
		.catch((err) => console.log(err))
	}

	function ImgError(source){
		source.src = "http://180.232.152.179:70/cgsiapplication/images/idpicture/noimage.jpg";
		source.onerror = "";
		return true;
	}

	function zoomAttachment(id,table) {
		$("#leaveTable"+table+" tbody tr.child td.child ul li").find("#attachment"+id).attr('style','width:100%;');
		$("#leaveTable"+table+" tbody tr.child td.child ul li").find("#zoomAttach"+id).text('zoom_out');
		$("#leaveTable"+table+" tbody tr.child td.child ul li").find("#zoomAttach"+id).removeAttr('onclick').attr('onclick','zoomInAttachment('+id+','+table+')');
	}

	function zoomInAttachment(id,table) {
		$("#leaveTable"+table+" tbody tr.child td.child ul li").find("#attachment"+id).attr('style','width:100px;margin-left:100px');
		$("#leaveTable"+table+" tbody tr.child td.child ul li").find("#zoomAttach"+id).text('zoom_in');
		$("#leaveTable"+table+" tbody tr.child td.child ul li").find("#zoomAttach"+id).removeAttr('onclick').attr('onclick','zoomAttachment('+id+','+table+')');

	}

	function applyLeave(userid,page) {
		sessionStorage.setItem('userID', userid);
		sessionStorage.setItem('leaveListPage',page);
    	window.open("apply_leave.php", "_self");
	}

	function addRejectReason(id, table) {
		rejectReasonVal = $("#leaveTable"+table+" tbody tr.child td.child ul li").find("input#reason"+id).val();
		if ($.trim(rejectReasonVal) == '') {
			$("#leaveTable"+table+" tbody tr.child td.child ul li").find("button#submitYes"+id).attr('style','display:none');
		} else {
			$("#leaveTable"+table+" tbody tr.child td.child ul li").find("button#submitYes"+id).removeAttr('style');
		}
	}

	// toggle credit info table
	function toggleCredit(id,table) {
		$("#leaveTable"+table+" tbody tr.child td.child ul li div#"+id+"-creditinfo").toggle();
	}

	function onclickAction(id,table, stat) {
		if (stat == 1 ) {
			$("#leaveTable"+table+" tbody tr.child td.child ul li span.dtr-data div#approvedLeave"+id+" p#modalContent"+id+" span#msg"+id).html('approve');
			$("#leaveTable"+table+" tbody tr.child td.child ul li span.dtr-data div#approvedLeave"+id+" button#submitYes"+id).attr('onclick','approveLeave('+id+',1,'+table+')');
			$("#leaveTable"+table+" tbody tr.child td.child ul li").find("div#reason"+id).attr('style','display: none');

			$("#leaveTable"+table+" tbody tr.child td.child ul li").find("button#submitYes"+id).removeAttr('style');
		} else {
			$("#leaveTable"+table+" tbody tr.child td.child ul li span.dtr-data div#approvedLeave"+id+" p#modalContent"+id+" span#msg"+id).html('reject');
			$("#leaveTable"+table+" tbody tr.child td.child ul li").find("button#submitYes"+id).attr('style','display: none');
			$("#leaveTable"+table+" tbody tr.child td.child ul li span.dtr-data div#approvedLeave"+id+"  button#submitYes"+id).attr('onclick','approveLeave('+id+',2,'+table+')');
			$("#leaveTable"+table+" tbody tr.child td.child ul li").find("div#reason"+id).removeAttr('style');
		}
		$("#leaveTable"+table+" tbody tr.child td.child ul li span.dtr-data div#approvedLeave"+id).removeAttr('style');
	}

	function getApproverDetails(data) {
		
		let formData = new FormData();
		formData.append('leave_id', data);
		fetch('../api/leave/get_leave_approver.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
			.then((res) => res.json())
			.then((data) => {
				if(data == "0 results") {
					console.log('no data');
				} else {
					data.forEach((approver) => {
						$("#leaveTable tbody tr.child td.child ul li span.dtr-data approverName"+approver.emp_leave_id).html('test2');
					});	
				}
			})
			.catch((err) => console.log(err))
	}

	function approveLeave(id,approve_cancel,table) {
		rejectReason = $("#leaveTable"+table+" tbody tr.child td.child ul li").find("input#reason"+id).val();
		let formData = new FormData();
		formData.append('leaveID', id);
		formData.append('approve_cancel', approve_cancel);
		formData.append('reject_reason', rejectReason);
		fetch('../api/leave/edit_leave_approve.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
			.then((res) => res.json())
			.then((data) => {
				if (approve_cancel == 1) {
					msg = 'Approved';
				} else {
					msg = 'Rejected';
				}
				let datares = "Successfully "+msg+" Leave";
				if (data['m'] == datares) {
					let message = datares;
					$("#leaveTable"+table+" tbody tr.child td.child ul li span.dtr-data div#approvedLeave"+id).html('<span style="text-align: center">'+message+'</span>');
					setTimeout(function() {
						window.open("leaveapplication.php", "_self");
					}, 2000);
				} else {
					let message = `error in applying leave`;
					$('#error').html(message);
				}
			})
			.catch((err) => console.log(err))
	}

	function closeModal(id,tbid) {
		$("#leaveTable"+tbid+" tbody tr.child td.child ul li span.dtr-data div#approvedLeave"+id).attr('style','display: none');
		$("#leaveTable"+tbid+" tbody tr.child td.child ul li").find("input#reason"+id).val("");
	}

	function exitFormRequest() {
		window.open("leaveapplication.php", "_self");
	}