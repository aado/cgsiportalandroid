	document.addEventListener("DOMContentLoaded", function () {
		leaveUserInfo();
		jQuery('#additional').keyup(delay(function(e) {
		    if( e.which == 8 || e.which == 46 ) {
		    	console.log('this');
		    	if(this.value==="") { 
					document.getElementById('submitCredit').disabled = true; 
					$("#total_leave_credit").html(sessionStorage.getItem('totalCredit'));
					$("#leave_left").html(sessionStorage.getItem('leaveLeft'));
				} else {
					document.getElementById('submitCredit').disabled = false;
					leavCredit = $("#total_leave_credit").text();
					leaveLeft = $("#leave_left").text();
					$("#total_leave_credit").html((parseFloat(leavCredit) - parseFloat(this.value)));
					$("#leave_left").html((parseFloat(leaveLeft) - parseFloat(this.value)));
				}
		    } else {
		    	document.getElementById('submitCredit').disabled = false;
				leavCredit = $("#total_leave_credit").text();
				$("#total_leave_credit").html((parseFloat(leavCredit) + parseFloat(this.value)));
				leaveLeft = $("#leave_left").text();
				$("#leave_left").html((parseFloat(leaveLeft) + parseFloat(this.value)));
		    }
		}, 1000));
	});

	function leaveUserInfo() {
		fetch('../api/leave/get_leave_user_info.php', {
			method: 'POST',
			credentials: "same-origin",
		})
		.then((res) => { return res.json() })
		.then((data) => {
			$('#leaveUserInfo').DataTable( {
				responsive: true,
				data: data,
				destroy: true,
				"aLengthMenu": [[50, 75, -1], [50, 75, "All"]],
        		"iDisplayLength": 50,
				columnDefs: [
					// { responsivePriority: 1, targets: 1 },
					// { responsivePriority: 2, targets: 2 },
					// { responsivePriority: 2, targets: 3 },
				],
				columns: [
					{ data: 'emp_id', title: "ID"},
					{ data: 'lastname', title: "LAST NAME"},
					{ data: 'firstname', title: "FIRST NAME"},
					{ data: 'middlename', title: "MIDDLE NAME"},
					{ data: 'date_hired', title: "DATE HIRED" },
					{ data: 'leave_additional', title: "ADDT'L" },
					{ data: 'total_leave_credit', title: "TOTAL LEAVE CREDIT" },
					{ data: 'leave_used', title: "USED LEAVE" },
					{ data: 'leave_left', title: "LEAVE LEFT" },
					{
						data: 'userid',
						title: "ACTION",
						render:function(data, type, row)
						{	
							return '<button onclick="getUserLeaveInfo('+data+')" class="btn btn-primary"  data-toggle="modal" data-target="#addUserModal"><i class="fa fa-edit"></i> UPDATE LEAVE CREDIT </button>';
						}
					}
				]
			} ).columns.adjust()
			.responsive.recalc();
		})
		.catch((err) => console.log(err))
	}

	function delay(callback, ms) {
	  var timer = 0;
	  return function() {
	    var context = this, args = arguments;
	    clearTimeout(timer);
	    timer = setTimeout(function () {
	      callback.apply(context, args);
	    }, ms || 0);
	  };
	}

	function getUserLeaveInfo(id) {
		let formData = new FormData();
		formData.append('userID', id);
		fetch('../api/leave/get_leave_master_info.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
		.then((res) => { return res.json() })
		.then((data) => {
				row = data[0];
				$("#fullname").html(row.lastname+', '+row.firstname+' '+row.middlename);
				$("#userID").val(row.userid);
				$("#leave_left").html(row.leave_left);
				$("#leave_used").html(row.leave_used);
				$("#additional").val(row.leave_additional);
				$("#total_leave_credit").html(row.total_leave_credit);
				sessionStorage.setItem('leaveLeft',row.leave_left);
				sessionStorage.setItem('totalCredit',row.total_leave_credit);
		})
		.catch((err) => console.log(err))
	}

	function addLeaveCredit() {
		 if(document.getElementById("additional").value==="") { 
            document.getElementById('submitCredit').disabled = true; 
            $("#total_leave_credit").html(sessionStorage.getItem('totalCredit'));
        } else { 
            document.getElementById('submitCredit').disabled = false;
            leavCredit = $("#total_leave_credit").text();
            $("#total_leave_credit").html((parseFloat(leavCredit) + parseFloat($("#additional").val())));
        }
	}

	function saveEditLeave() {
		userID = $("#userID").val();
		leaveAdd = $("#additional").val();
		leaveCredit = $("#total_leave_credit").text();
		leaveLeft = $("#leave_left").text();
		let formData = new FormData();
		formData.append('userID', userID);
		formData.append('additional', leaveAdd);
		formData.append('total_leave_credit', leaveCredit);
		formData.append('leave_left', leaveCredit);
		fetch('../api/leave/edit_leave_info.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
			.then((res) => res.json())
			.then((data) => {
				console.log(data);
				if (data.success == 1) {
					let message = `<div class="alert alert-success alert-dismissible" role="alert">
							${data.msg}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					`;
					$('#addUserModal').find("div#error").html(message);
					setTimeout(function() {
						window.open("leave_masterlist.php", "_self");
					}, 2000);
				} else {
					let message = `error in update leave info`;
					$('#error').html(message);
				}
			})
			.catch((err) => console.log(err))
	}