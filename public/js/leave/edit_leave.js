	document.addEventListener("DOMContentLoaded", function () {
		getLeaveType(1);
		$('.datepicker').pickadate({
			selectMonths: true, 
			selectYears: 20,
		});
		moment.createFromInputFallback = function(config) {
			// unreliable string magic, or
			config._d = new Date(config._i);
		};
		let userID = sessionStorage.getItem('userID');
		$("#application_type").val(1);
		populate('.timeSelect');
		getEmpInfo();
		getLeaveDetails();
		date = new Date();
		document.getElementById('date-filed').value = getFormattedDate(date);
		// $('#date-filed').keydown(function(e)
		// {
		// 	// Allow: backspace, delete, tab
		// 	if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
		// 	// Allow: Ctrl+A, Command+A
		// 	(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		// 	// Allow: home, end, left, right, down, up
		// 	(e.keyCode >= 35 && e.keyCode <= 40)) {
		// 	// let it happen, don't do anything
		// 		$(this).val("");
		// 		submitEnable();
		// 	}
		// 	// Ensure that it is a number and stop the keypress
		// 	if ((e.shiftKey || (e.keyCode > 1 || e.keyCode < 200))) {
		// 		e.preventDefault();
		// 	} 
		// 	else {
		// 		if( $(this).val().length === "" ) {
		// 			$("#leaveUndertime").attr('style','display: none');
		// 			submitEnable();
		// 		} else {
		// 			submitEnable();
		// 		}
		// 	}
		// });

		$('#date-leave-undertime-to').keydown(function(e)
		{

			// Allow: backspace, delete, tab
			if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
			// Allow: Ctrl+A, Command+A
			(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
			// Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
			// let it happen, don't do anything
				$(this).val("");
				submitEnable();
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode > 1 || e.keyCode < 200))) {
				e.preventDefault();
			} else {
				if( $(this).val().length === "" ) {
					$("#leaveDays").attr('style','display: none');
				} else {
					$("#leaveDays").removeAttr('style');
					$("#leaveDays").attr('style','margin-bottom:16px');
				}	
				submitEnable();
			}
		});

		$('#date-leave-undertime-from').keydown(function(e)
		{
			// Allow: backspace, delete, tab
			if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
			// Allow: Ctrl+A, Command+A
			(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
			// Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
			// let it happen, don't do anything
				$(this).val("");
				submitEnable();
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode > 1 || e.keyCode < 200))) {
				e.preventDefault();
			} else {
				if( $(this).val().length === "" ) {
					$("#leaveDays").attr('style','display: none');
				} else {
					$("#leaveDays").removeAttr('style');	
					$("#leaveDays").attr('style','margin-bottom:16px');
				}	
				submitEnable();
			}
		});

		$('#reason').keyup(function()
		{	
			submitEnable();
		});

		$('#other_reason').keyup(function()
		{	
			submitEnable();
		});

		$("#leave-type").bind("change keyup", function(){
			if ( $("#application_type").val() == 2 ) {
				let date = new Date();
				document.getElementById('date-filed').value = getFormattedDate(date);
				document.getElementById('date-leave-undertime-from').value = getFormattedDate(date);
				document.getElementById('date-leave-undertime-to').value = getFormattedDate(date);
				$("#date-filed").attr('readonly','');
				$("#date-leave-undertime-from").attr('readonly','');
				$("#date-leave-undertime-to").attr('readonly','');
				// $("#leaveUndertime").removeAttr('style');
				$("#leaveDays").removeAttr('style');
				$("#leaveDays").attr('style','margin-bottom:16px');
				between = [];
				between.push(new Date());
				appendTableDate(between);
			} else {
			if($(this).val() == 12 || $(this).val() == 8) {
				$("#OtherleaveDays").removeAttr('style');
				$("#date-filed").removeAttr('readonly');
				$("#date-leave-undertime-from").removeAttr('readonly');
				$("#date-leave-undertime-to").removeAttr('readonly');
				// $("#leaveUndertime").attr('style','display:none');
				// $("#date-filed").val('');
				// $("#date-leave-undertime-from").val('');
				// $("#date-leave-undertime-to").val('');
				$("#leaveDays").attr('style','display:none');
			} else if($(this).val() == 3 || $(this).val() == 4 || $(this).val() == 5) {
				$("#OtherleaveDays").hide();
				// $("#leaveUndertime").attr('style','display: none');
				$("#date-filed").removeAttr('readonly');
				$("#date-leave-undertime-from").removeAttr('readonly');
				$("#date-leave-undertime-to").removeAttr('readonly');
				// $("#leaveUndertime").attr('style','display:none');
				// $("#date-filed").val('');
				// $("#date-leave-undertime-from").val('');
				// $("#date-leave-undertime-to").val('');
				$("#leaveDays").attr('style','display:none');
			} else if($(this).val() == 7) {
				let date = new Date();
				document.getElementById('date-filed').value = getFormattedDate(date);
				document.getElementById('date-leave-undertime-from').value = getFormattedDate(date);
				document.getElementById('date-leave-undertime-to').value = getFormattedDate(date);
				$("#date-filed").attr('readonly','');
				$("#date-leave-undertime-from").attr('readonly','');
				$("#date-leave-undertime-to").attr('readonly','');
				// $("#leaveUndertime").removeAttr('style');
				$("#leaveDays").removeAttr('style');
				$("#leaveDays").attr('style','margin-bottom:16px');
				between = [];
				between.push(new Date());
				appendTableDate(between);
			} else {
				$("#OtherleaveDays").hide();
				$("#date-filed").removeAttr('readonly');
				$("#date-leave-undertime-from").removeAttr('readonly');
				$("#date-leave-undertime-to").removeAttr('readonly');
				// $("#leaveUndertime").attr('style','display:none');
				// $("#date-filed").val('');
				// $("#date-leave-undertime-from").val('');
				// $("#date-leave-undertime-to").val('');
			}
			}
			submitEnable();
		});

		// $("#leave-type").bind("change keyup", function(){
		// 	console.log( $("#application_type").val());
		// 	if ( $("#application_type").val() == 2 ) {
		// 		let date = new Date();
		// 		document.getElementById('date-filed').value = getFormattedDate(date);
		// 		document.getElementById('date-leave-undertime-from').value = getFormattedDate(date);
		// 		document.getElementById('date-leave-undertime-to').value = getFormattedDate(date);
		// 		$("#date-filed").attr('readonly','');
		// 		$("#date-leave-undertime-from").attr('readonly','');
		// 		$("#date-leave-undertime-to").attr('readonly','');
		// 		$("#leaveUndertime").removeAttr('style');
		// 		$("#leaveDays").removeAttr('style');
		// 		$("#leaveDays").attr('style','margin-bottom:16px');
		// 		between = [];
		// 		between.push(new Date());
		// 		appendTableDate(between);
		// 	} else {
		// 	if($(this).val() == 12 || $(this).val() == 8) {
		// 		$("#OtherleaveDays").removeAttr('style');
		// 		$("#date-filed").removeAttr('readonly');
		// 		$("#date-leave-undertime-from").removeAttr('readonly');
		// 		$("#date-leave-undertime-to").removeAttr('readonly');
		// 		$("#leaveUndertime").attr('style','display:none');
		// 		$("#date-filed").val('');
		// 		$("#date-leave-undertime-from").val('');
		// 		$("#date-leave-undertime-to").val('');
		// 		$("#leaveDays").attr('style','display:none');
		// 	} else if($(this).val() == 3 || $(this).val() == 4 || $(this).val() == 5) {
		// 		$("#OtherleaveDays").hide();
		// 		$("#leaveUndertime").attr('style','display: none');
		// 		$("#date-filed").removeAttr('readonly');
		// 		$("#date-leave-undertime-from").removeAttr('readonly');
		// 		$("#date-leave-undertime-to").removeAttr('readonly');
		// 		$("#leaveUndertime").attr('style','display:none');
		// 		$("#date-filed").val('');
		// 		$("#date-leave-undertime-from").val('');
		// 		$("#date-leave-undertime-to").val('');
		// 		$("#leaveDays").attr('style','display:none');
		// 	} else if($(this).val() == 7) {
		// 		let date = new Date();
		// 		document.getElementById('date-filed').value = getFormattedDate(date);
		// 		document.getElementById('date-leave-undertime-from').value = getFormattedDate(date);
		// 		document.getElementById('date-leave-undertime-to').value = getFormattedDate(date);
		// 		$("#date-filed").attr('readonly','');
		// 		$("#date-leave-undertime-from").attr('readonly','');
		// 		$("#date-leave-undertime-to").attr('readonly','');
		// 		$("#leaveUndertime").removeAttr('style');
		// 		$("#leaveDays").removeAttr('style');
		// 		$("#leaveDays").attr('style','margin-bottom:16px');
		// 		between = [];
		// 		between.push(new Date());
		// 		appendTableDate(between);
		// 	} else {
		// 		$("#OtherleaveDays").hide();
		// 		$("#date-filed").removeAttr('readonly');
		// 		$("#date-leave-undertime-from").removeAttr('readonly');
		// 		$("#date-leave-undertime-to").removeAttr('readonly');
		// 		$("#leaveUndertime").attr('style','display:none');
		// 		$("#date-filed").val('');
		// 		$("#date-leave-undertime-from").val('');
		// 		$("#date-leave-undertime-to").val('');
		// 	}
		// 	}
		// 	submitEnable();
		// });

		$('.navbar-toggler').hide();
		var picker = new Pikaday({
			field: document.getElementById('date-filed'),
			minDate: new Date(),
			setDefaultDate: true,
			disableDayFn: function(date){
				// Disable Saturday and Sunday
				return date.getDay() === 6 || date.getDay() === 0;
			},
			onSelect: function() {
				$("#leaveUndertime").show();
				submitEnable();
			}
		});
		var startDate,
		endDate,
		updateStartDate = function() {
			startPicker.setStartRange(startDate);
			endPicker.setStartRange(startDate);
			endPicker.setMinDate(startDate);
			displayLeaveDate(startDate, endDate);
			submitEnable();
		},
		updateEndDate = function() {
			startPicker.setEndRange(endDate);
			startPicker.setMaxDate(endDate);
			endPicker.setEndRange(endDate);
			displayLeaveDate(startDate, endDate);
			submitEnable();
		},
		startPicker = new Pikaday({
			field: document.getElementById('date-leave-undertime-from'),
			minDate: new Date(),
			format: 'D MMM YYYY',
			maxDate: new Date(2021, 12, 30),
			disableDayFn: function(date){
				// Disable Saturday and Sunday
				return date.getDay() === 6 || date.getDay() === 0;
			},
			onSelect: function() {
				startDate = this.getDate();
				updateStartDate();
				getLeaveType($("#application_type").val());
			}
		}),
		endPicker = new Pikaday({
			field: document.getElementById('date-leave-undertime-to'),
			minDate: new Date(),
			format: 'D MMM YYYY',
			maxDate: new Date(2021, 12, 31),//new Date(2020, 12, 31),
			disableDayFn: function(date){
				// Disable Saturday and Sunday
				return date.getDay() === 6 || date.getDay() === 0;
			},
			onSelect: function() {
				endDate = this.getDate();
				// if (leaveType !== 2) {
					updateEndDate();
				// }
				$("#leaveDays").removeAttr('style');
				$("#leaveDays").attr('style','margin-bottom:16px');
				getLeaveType($("#application_type").val());
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
	});

	function populate(selector) {
		var start = 9;
		var s = document.getElementById("timeSelect");

		for(var i = 0; i< 19; i++){
			var t = ((start + i) % 12 + 1) + ":00 ";
			var t2 = ((start + i) % 12 + 1) + ":30 ";

			t += Math.floor(i/12) === 0 ? "AM" : "PM";
			t2 += Math.floor(i/12) === 0 ? "AM" : "PM";

			let option = document.createElement('option');
			option.text = t
			option.value = t;

			let option2 = document.createElement('option');
			option2.text = t2
			option2.value = t2;

			s.append(option)
			s.append(option2)
		}
	}

	function switchButton(event) {
		var checkbox = document.querySelector('input[name="switchLeaveUnder"]');
		if (checkbox.checked) {
			// do this
			$("#leaveTypeText").html("LEAVE");
			$("#selectLeaveTye").text("leave");
			$("#application_type").val(1);
			$("#undertTime").attr('style','display:none');
			console.log('Checked');
			getLeaveType(1);
		  } else {
			// do that
			$("#leaveTypeText").html("UNDERTIME");
			$("#selectLeaveTye").text("undertime");
			$("#application_type").val(2);
			$("#undertTime").removeAttr('style');
			console.log('Not checked');
			getLeaveType(2);
		  }
	}

	
	// leave day get date leave remarks
	let leaveDay = [];
	let leaveDate = [];
	let leaveTerm = [];
	let dayCover = [];
	let coverName = [];
	let dayCoverUnder = [];
	let coverNameUnder = [];
	document.getElementById('requestTriggerYes').addEventListener('click', requestTriggerYes);

	function filterDates(e) {
		// Allow: backspace, delete, tab
		if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
		// Allow: Ctrl+A, Command+A
		(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		// Allow: home, end, left, right, down, up
		(e.keyCode >= 35 && e.keyCode <= 40)) {
		// let it happen, don't do anything
			return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode > 1 || e.keyCode < 200))) {
			e.preventDefault();
		} else {
			return true;
		}
	}

	function submitEnable() {
		let leaveType = document.getElementById('leave-type').value;
		let dateFiled = document.getElementById('date-filed').value;

		let leaveUndertimeFrom = document.getElementById('date-leave-undertime-from').value;
		let leaveUndertimeTo = document.getElementById('date-leave-undertime-to').value;
		let reason = document.getElementById('reason').value;
		let other_reason = document.getElementById('other_reason').value;
		
		if(leaveType == 0 || dateFiled == '' || leaveUndertimeFrom == '' || leaveUndertimeTo == '' || reason.trim() == '') {
			$("#requestTriggerYes").hide();
		} else {
			if (leaveType == 12 || leaveType == 8) {
				if (other_reason.trim() == '') {
					$("#requestTriggerYes").hide();
				} else {
					$("#requestTriggerYes").show();
				}
			} else {
				$("#requestTriggerYes").show();
			}
		}
	}

	function getFormattedDate(date) {
		var year = date.getFullYear();
	  
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
	  
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return moment(month + '/' + day + '/' + year).format('ddd D MMM YYYY');
	}

	function getEmpInfo() {
		fetch('../api/leave/get_emp_info.php', {
			method: 'POST',
			credentials: "same-origin",
		})
		.then((res) => { return res.json() })
		.then((data) => {
			sessionStorage.setItem('userID',data[0]['emp_id']);
			sessionStorage.setItem('emp_status',data[0]['emp_status']);
			$("#fullname").val(data[0]['fullname']);
			$("#department").val(data[0]['department']);
			$("#contact_number").val(data[0]['contact_number']);
			$("#total_leave_credit").html(data[0]['total_leave']);
			$("#designation").val(data[0]['designation']);
		})
		.catch((err) => console.log(err))
	}

	// function getLeaveType(selectDefualt) {
	// 	fetch('../api/leave/get_leave_types.php', {
	// 		method: 'POST',
	// 		credentials: "same-origin"
	// 	})
	// 	.then((res) => { return res.json() })
	// 	.then((data) => {
	// 		$('#leave-type').html('');
	// 		let leaveType = [];
	// 		for (let i = 0; i < data.length; i++) {
	// 			if (selectDefualt == 2) {
	// 				if (data[i].id == 2 || data[i].id == 7 || data[i].id == 10) {
	// 					leaveType.push(data[i]);
	// 				}	
	// 			} else {
	// 				leaveType.push(data[i]);
	// 			}
	// 		}
	// 		textSelect = 'Select leave type';
	// 		if(selectDefualt == 2) {
	// 			textSelect = 'Select undertime type';
	// 		}
	// 		$('#leave-type').append('<option value="0">'+textSelect+'</option>');
	// 		$.each(leaveType, function (i, item) {
	// 			$('#leave-type').append($('<option>', { 
	// 				value: item.id,
	// 				text : item.name 
	// 			}));
	// 		});
	// 	})
	// 	.catch((err) => console.log(err))
	// }

	function getLeaveType(selectDefualt) {
		fetch('../api/leave/get_leave_types.php', {
			method: 'POST',
			credentials: "same-origin"
		})
		.then((res) => { return res.json() })
		.then((data) => {
			$('#leave-type').html('');
			$('#leave-type').attr('disabled','disabled');
			let leaveType = [];
			for (let i = 0; i < data.length; i++) {
				if (selectDefualt == 2) {

					if (data[i].id == 2 || data[i].id == 7 || data[i].id == 12) {
						leaveType.push(data[i]);
					}	

				} else {

					var dt = new Date();
					var time = dt.getHours();
					datefile = document.getElementById('date-filed').value = getFormattedDate(dt);
					leaveFrom = document.getElementById('date-leave-undertime-from').value;
					leaveTo = document.getElementById('date-leave-undertime-to').value;

					if (leaveFrom == datefile && leaveTo == datefile) {
						if ( time >= 14 && time <= 16 ){
							if (data[i].id == 7) {
								leaveType.push(data[i]);
							}
						} 
					} else {
						if (data[i].id == 1 || data[i].id == 2 || data[i].id == 3 || data[i].id == 4 || data[i].id == 5 || data[i].id == 10 || data[i].id == 11 || data[i].id == 12) {
							leaveType.push(data[i]);
						}
					}
				}
			}
			textSelect = 'Select leave type';
			if(selectDefualt == 2) {
				textSelect = 'Select undertime type';
			}
			$('#leave-type').append('<option value="0">'+textSelect+'</option>');
			$.each(leaveType, function (i, item) {
				$('#leave-type').append($('<option>', { 
					value: item.id,
					text : item.name 
				}));
			});
			$('#leave-type').removeAttr('disabled');
		})
		.catch((err) => console.log(err))
	}

	// get leave edit details
	function getLeaveDetails() {
		let formData = new FormData();
		formData.append('leaveID', sessionStorage.getItem('leaveID'));
		fetch('../api/leave/get_leave_details.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
		.then((res) => { return res.json() })
		.then((data) => {
			$("#application_type").html((data[0].appl_type == 2)? 'UPDATE UNDERTIME':'UPDATE LEAVE');
			if (data[0].appl_type == 2) {
				$('.toggle').removeClass('off').addClass('btn-primary');
				$("#undertTime").removeAttr('style');
				document.getElementById('timeSelect').value=data[0]['time_undertime'];
			} else {
				$('.toggle').addClass('off').addClass('btn-light');
				$("#undertTime").attr('style','display:none');
			}
			document.getElementById('leave-type').value=data[0]['leave_type'];
			document.getElementById('leaveID').value=data[0]['leave_id'];	
			$("#date-filed").val(moment(data[0]['date_filed']).format('ddd D MMM YYYY'));
			$("#reason").val(data[0]['reason']);
			$("#date-leave-undertime-from").val(moment(data[0]['date_from']).format('ddd D MMM YYYY'));
			$("#date-leave-undertime-to").val(moment(data[0]['date_to']).format('ddd D MMM YYYY'));
			displayLeaveDate(new Date(moment(data[0]['date_from']).format('ddd D MMM YYYY')).toUTCString(),new Date(moment(data[0]['date_to']).format('ddd D MMM YYYY')).toUTCString());
			var dayTerm = data[0].leave_days_remarks;
			var dayCover = data[0].cover_day;
			splitDayCover = [];
			splitDay = [];
			splitDayUnder = [];
			if (dayTerm !== '' || dayCover !== '') {
				let result = '<table style="width: 100%;" class="mdl-data-table mdl-js-data-table"><tr><td style="text-align: center; font-weight: bold" colspan="2">DAY REMARK</td></tr><tr><td style="text-align: center;">DAY</td><td style="text-align: center;">TERM</td></tr>';
				try {

					splitDay = (JSON.parse(dayTerm));
					splitDay.forEach((dayRems) =>{
						result += '<tr><td style="text-align: center;">'+dayRems.dayName.replace(/_/g,' ')+'</td><td style="text-align: center;">'+dayRems.term+'</td></tr>';
					});	

				}catch(err) {}

				//day cover
				let resultCover = '<table style="width: 100%;" class="mdl-data-table mdl-js-data-table"><tr><td colspan=2 style="text-align: center;">HALF DAY</td></tr>';
				try {

					splitDayCover = (JSON.parse(dayCover));
					splitDayCover.forEach((dayRems) =>{
						resultCover += '<tr><td style="text-align: center;">'+dayRems.dayName.replace(/_/g,' ')+'</td><td style="text-align: center;">'+dayRems.Cover+'</td></tr>';
					});	

				}catch(err) {}


				if (dayTerm == '' || dayTerm == '[]') {
					result += '<tr><td colspan=2 style="text-align: center">All Day is With Pay</td></tr>';
				} 
				if(dayCover == '' || dayCover == '[]') {
					resultCover += '<tr><td colspan=2 style="text-align: center">No half day.</td></tr>';
				} 
				$("#dayRemarks").html('<br />'+result+'</table> '+resultCover+'</table>');
			} else {
				nodayr = '<table style="width: 100%;" class="mdl-data-table mdl-js-data-table"><tr><td style="text-align: center; font-weight: bold">NO DAY REMARK</td></tr>';
				$("#dayRemarks").html('<br />'+nodayr);
			}
			
			console.log(data[0]);

		})
		.catch((err) => console.log(err))
	}

	function exitFormRequest() {
		window.open("myleave.php", "_self");
	}

	function showDayRemarks() {
		// body...
		$("#leaveDays").toggle();
	}

	function displayLeaveDate(startDate, endDate) {
		var start = startDate,
			end = endDate,
			currentDate = new Date(start),
			between = [];
		
		while (currentDate <= new Date(end)) {
			between.push(new Date(currentDate));
			currentDate.setDate(currentDate.getDate() + 1);
		}
		appendTableDate(between);
		
	}

	function appendTableDate(between) {
		let tbody, nofday = 0, weekEnds = 0;
		 var dayWOPay = [];
		 leaveDay = [];
		 leaveDate = [];
		 leaveTerm = [];
		 dayCover = [];
		 coverName = [];
		 dayCoverUnder = [];
		 coverNameUnder = [];
		 sessionStorage.setItem('leaveDayRemarks','');
		 sessionStorage.setItem('leaveDayCover','');
		 sessionStorage.setItem('leaveDayUnder','');
		$.each(between, function( index, value ) {
			nofday = index+1;
			var emp_status = sessionStorage.getItem('emp_status');
			var dateParse = new Date(value).toString();

			if (emp_status == 1) {
				// regular status
				if (dateParse.split(' ')[0] == 'Sat' || dateParse.split(' ')[0] == 'Sun') {
					checkedWpay = '';
					checkedWOpay = 'checked';
					dtitle = 'display: none';
					dtime = 'display: none';
					weekEnds = weekEnds+1;
					checkdisWO = 'disabled';
				} else {
					console.log(nofday);
					var checkedWpay = 'checked';
					var checkedWOpay = '';
					 var isLastElement = index == between.length -1;
					 if(isLastElement) {
					 	var lastDay = (index+1);
					 }
					if (nofday == 1 || nofday == lastDay) { 
						var dtitle = '';
					} else {
						dtitle = 'display: none';
					}
					var dtime = 'display: none';
					var checkdisWP = 'disabled';
					var checkdisWO = '';
				}
			} else {
				// probe status
				checkedWpay = '';
				checkedWOpay = 'checked';
				dtitle = 'display: none';
				dtime = 'display: none';
				var checkdisWP = 'disabled';
				var checkdisWO = 'disabled';
			}
			total_leave_left = parseFloat($("#total_leave_credit").text()) - nofday;
			total_leave_left += weekEnds; 
			if ( total_leave_left < 0 ) {
				checkedWpay = '';
				checkedWOpay = 'checked';
				dtitle = 'display: none';
				dtime = 'display: none';
				checkdisWP = 'disabled';
				checkdisWO = 'disabled';
				dayWOPay.push(nofday);
			}
			var day = dateParse.split(' ')[0]+', '+dateParse.split(' ')[1]+' '+dateParse.split(' ')[2]+' '+dateParse.split(' ')[3];

			tbody += '<tr id="dayTerm-'+nofday+'">';
			tbody +="<td class='mdl-data-table__cell--non-numeric'>"+day+ '</td><td class="mdl-data-table__cell--non-numeric"><span style="display: none" id="'+nofday+'with-out"></span><input type="radio" style="position: relative;pointer-events: fill;opacity: inherit;" value="1" name="terms-'+nofday+'" '+checkedWpay+' data-value="'+day.replace(/,/g,'').replace(/ /g,'_')+'-W Pay" onclick="triggerWOpay('+nofday+',1, this)" '+checkdisWP+'> W-pay &nbsp;<input id=terms-'+nofday+' type="radio" style="position: relative;pointer-events: fill;opacity: inherit;" name="terms-'+nofday+'" value="2" onclick="triggerWOpay('+nofday+',2, this)" '+checkedWOpay+' '+checkdisWO+' data-value="'+day.replace(/,/g,'').replace(/ /g,'_')+'-Wout Pay"> WO-pay</td></tr>';
			tbody += '<tr id="dayTimeTitle-'+nofday+'" style="'+dtitle+'"><td colspan="2" class="mdl-data-table__cell--non-numeric" style="text-align: center">Day cover <i class="fas fa-chevron-circle-down" onclick="showDayCover('+nofday+')"></i></td></tr>';
			// Day Cover
			tbody += '<tr id="dayTime-'+nofday+'" style="'+dtime+'"><td colspan="2" class="mdl-data-table__cell--non-numeric" style="text-align: center"><input type="radio" style="position: relative;pointer-events: fill;opacity: inherit;" value="1" data-value="'+day.replace(/,/g,'').replace(/ /g,'_')+'-Whole" name="daytime-'+nofday+'" checked onclick="triggerDtime(1,'+nofday+', this)" disabled> Whole &nbsp;<input type="radio" style="position: relative;pointer-events: fill;opacity: inherit;" name="daytime-'+nofday+'" value="2" onclick="triggerDtime(2,'+nofday+', this)" data-value="'+day.replace(/,/g,'').replace(/ /g,'_')+'-Half">  Half	<br><span id="note-'+nofday+'" style="font-size: 9px;font-weight: bold; display: none"><select id="'+nofday+'-selectDcover" class="mdl-textfield__input" style="width: 50px; margin-left:40%;font-size: 12px; margin-bottom: -24px;" onclick="triggerDtime(3,'+nofday+', this)" data-value="'+day.replace(/,/g,'').replace(/ /g,'_')+'-Half"><option value="AM">AM</option><option value="PM">PM</option></select><br /></td></tr>';
		});
		deductWeekEnds = parseFloat($("#total_leave_credit").text()) + parseInt(weekEnds);
		// add week ends in the leave left
		var totalLeaveCalc = ((deductWeekEnds) - parseFloat(nofday));
		sessionStorage.setItem('leaveCalcRes', totalLeaveCalc);
		$("#total_leave_left").html(totalLeaveCalc);
		
		// deduct week ends in the leave days
		sessionStorage.setItem('dayCalcRes', nofday - parseInt(weekEnds));
		$("#nofdayleave").html(nofday - parseInt(weekEnds));
		$("#leaveDays tbody").html(tbody);
	}

	function triggerWOpay(i,t, event) {
		$("#leaveDays tbody tr#dayTimeUnder-"+i+ ' td select#'+i+'-selectUnder').val('AM');
		$("#leaveDays tbody tr#dayTime-"+i+ ' td select#'+i+'-selectDcover').val('AM');
		$("#leaveDays tbody tr td span#"+i+'with-out').html($(event).data('value'));
		var with_without = $("#leaveDays tbody tr td span#"+i+'with-out').text();

		leaveDay.push({DayId: with_without.split('-')[0], term: with_without.split('-')[1]});
		leaveTerm.push({DayNameId: with_without.split('-')[0], dayName: with_without.split('-')[0]});

		// MAP DAY LEAVE
		const DayMap = leaveDay.reduce((map, { DayId, term }) => {
		  let days = map.get(DayId) || []
		  days.push(term)
		  return map.set(DayId, days)
		}, new Map())

		const array = leaveTerm.map(({ DayNameId, dayName }) => (
			{
			  dayName,
			  term: ((DayMap.get(DayNameId) || []).join(', ').split(','))[((DayMap.get(DayNameId) || []).join(', ').split(',')).length - 1].replace(/ /g,'')
			}
		))

		// get unique day push
		var result = array.reduce((unique, o) => {
		    if(!unique.some(obj => obj.dayName === o.dayName && obj.term === o.term)) {
		      unique.push(o);
		    }
		    return unique;
		},[]);

		leaveDayRemarks = result.filter(function( obj ) {
			if (obj.dayName.split('_')[0] === 'Sat' || obj.dayName.split('_')[0] === 'Sun') {
		   		return obj.term == 'WPay';
			} else {
				return obj.term !== 'WPay';
			}
		});
		if (leaveDayRemarks !== undefined || leaveDayRemarks.length !== 0){
			sessionStorage.setItem('leaveDayRemarks',JSON.stringify(leaveDayRemarks));
		}

		if(t == 1) {
			$(event).siblings('input').removeAttr('disabled');
			$(event).attr('disabled','disabled');
			$("#total_leave_left").html(
				function(i, val) { return val*1-1 }
			);
			$("#nofdayleave").html(
				function(i, val) { return val*1+1 }
			);
		} else {
			$(event).siblings('input').removeAttr('disabled');
			$(event).attr('disabled','disabled');
			$("#total_leave_left").html(
				function(i, val) { return val*1+1 }
			);
			$("#nofdayleave").html(
				function(i, val) { return val*1-1 }
			);
		}
	}

	function showDayCover(id) {
		$("#leaveDays tbody tr#dayTime-"+id).toggle();
		$("#leaveDays tbody tr#dayTimeUnder-"+id).toggle();
	}

	function triggerHalf(e) {
		console(e);
	}

	function triggerDtime(d,nd, event) {
		// value of under back to default
		$("#leaveDays tbody tr#dayTimeUnder-"+nd+ ' td select#'+nd+'-selectUnder').val('AM');
		if (d == 3) {
			ampm =  String.fromCharCode(160)+$("#leaveDays tbody tr#dayTime-"+nd+ ' td select#'+nd+'-selectDcover option:selected').val();
		} else if (d == 2) { 
			ampm = String.fromCharCode(160)+"AM";
		} else {
			ampm = '';
			$("#leaveDays tbody tr#dayTime-"+nd+ ' td select#'+nd+'-selectDcover').val('AM');
		}
		day_cover = $(event).data('value');

		dayCover.push({DayId: day_cover.split('-')[0], Cover: day_cover.split('-')[1]+ampm});
		coverName.push({DayNameId: day_cover.split('-')[0], dayName: day_cover.split('-')[0]});

		// MAP DAY LEAVE
		const DayMap = dayCover.reduce((map, { DayId, Cover }) => {
		  let days = map.get(DayId) || []
		  days.push(Cover)
		  return map.set(DayId, days)
		}, new Map())

		const array = coverName.map(({ DayNameId, dayName }) => (
			{
			  dayName,
			  Cover: ((DayMap.get(DayNameId) || []).join(', ').split(','))[((DayMap.get(DayNameId) || []).join(', ').split(',')).length - 1].replace(/ /,'')
			}
		))

		// get unique day push
		var result = array.reduce((unique, o) => {
		    if(!unique.some(obj => obj.dayName === o.dayName && obj.Cover === o.Cover)) {
		      unique.push(o);
		    }
		    return unique;
		},[]);
		leaveDayCover = result.filter(function( obj ) {
		    return obj.Cover !== 'Whole';
		});
		if (leaveDayCover !== undefined || leaveDayCover.length !== 0){
			sessionStorage.setItem('leaveDayCover',JSON.stringify(leaveDayCover));
			under = sessionStorage.getItem('leaveDayUnder');
			console.log(under.concat(JSON.stringify(leaveDayCover)));
		}


		if(d == 1) {
			if (sessionStorage.getItem('triggerUnder') == 0) {
				$("#total_leave_left").html(parseFloat($("#total_leave_left").text()) - .5);
				$("#nofdayleave").html(parseFloat($("#nofdayleave").text()) + .5);
				sessionStorage.setItem('triggerUnder',0);
			}
			$("#leaveDays tbody tr#dayTimeUnder-"+nd+ ' td input[name=daytimeUnder-'+nd+']').removeAttr('disabled').prop('checked',false);
			$(event).siblings('input').removeAttr('disabled');
			$(event).attr('disabled','disabled');
			$("#leaveDays tbody tr#dayTimeUnder-"+nd+ ' td span#noteunder-'+nd).attr('style','display: none');
			$("#leaveDays tbody tr#dayTime-"+nd+ ' td span#note-'+nd).attr('style','display: none');
		} else if(d == 2) {
			$("#total_leave_left").html(parseFloat($("#total_leave_left").text()) + .5);
			$("#nofdayleave").html(parseFloat($("#nofdayleave").text()) - .5);
			sessionStorage.setItem('triggerUnder',0);
			$("#leaveDays tbody tr#dayTime-"+nd+ ' td span#note-'+nd).attr('style','font-size: 9px;font-weight: bold;');
			$("#leaveDays tbody tr#dayTimeUnder-"+nd+ ' td span#noteunder-'+nd).attr('style','display: none');
			$("#leaveDays tbody tr#dayTimeUnder-"+nd+ ' td input[name=daytimeUnder-'+nd+']').removeAttr('disabled').prop('checked',false);
			$(event).siblings('input').removeAttr('disabled');
			$(event).attr('disabled','disabled');
		} else if(d == 3) { }
	}

	function triggerDtimeUnder(d,nd, event) {
		$("#leaveDays tbody tr#dayTime-"+nd+ ' td select#'+nd+'-selectDcover').val('AM');
		if (d == 1) {
			ampm = String.fromCharCode(160)+"AM";
		} else {
			ampm =  String.fromCharCode(160)+$("#leaveDays tbody tr#dayTimeUnder-"+nd+ ' td select#'+nd+'-selectUnder').val();
		}
		day_cover = $(event).data('value');

		dayCoverUnder.push({DayId: day_cover.split('-')[0], Cover: day_cover.split('-')[1]+ampm});
		coverNameUnder.push({DayNameId: day_cover.split('-')[0], dayName: day_cover.split('-')[0]});

		// MAP DAY LEAVE
		const DayMap = dayCoverUnder.reduce((map, { DayId, Cover }) => {
		  let days = map.get(DayId) || []
		  days.push(Cover)
		  return map.set(DayId, days)
		}, new Map())

		const array = coverNameUnder.map(({ DayNameId, dayName }) => (
			{
			  dayName,
			  Cover: ((DayMap.get(DayNameId) || []).join(', ').split(','))[((DayMap.get(DayNameId) || []).join(', ').split(',')).length - 1].replace(/ /g,'')
			}
		))

		// get unique day push
		var result = array.reduce((unique, o) => {
		    if(!unique.some(obj => obj.dayName === o.dayName && obj.Cover === o.Cover)) {
		      unique.push(o);
		    }
		    return unique;
		},[]);
		if (result !== undefined || result.length !== 0){
			sessionStorage.setItem('leaveDayUnder',JSON.stringify(result));
			under = sessionStorage.getItem('leaveDayCover');
			console.log(under.concat(JSON.stringify(result)));
		}
		if (d == 1) {
		sessionStorage.setItem('triggerUnder',1);
		$("#leaveDays tbody tr#dayTimeUnder-"+nd+ ' td span#noteunder-'+nd).attr('style','font-size: 9px;font-weight: bold;');
		$("#leaveDays tbody tr#dayTime-"+nd+ ' td input[name=daytime-'+nd+']').removeAttr('disabled').prop('checked',false);
		$("#leaveDays tbody tr#dayTime-"+nd+ ' td span#note-'+nd).attr('style','display: none');
		$(event).siblings('input').removeAttr('disabled');
		$(event).attr('disabled','disabled');
		$("#total_leave_left").html(sessionStorage.getItem('leaveCalcRes'));
		$("#nofdayleave").html(sessionStorage.getItem('dayCalcRes'));
		}
	}

	// save apply leave
	function requestTriggerYes(event) {
		event.preventDefault();

		let userID = sessionStorage.getItem('userID');
		let leaveID = document.getElementById('leaveID').value;;
		let leaveType = document.getElementById('leave-type').value;
		let application_type = document.getElementById('application_type').value;
		let dateFiled = document.getElementById('date-filed').value;
		let leaveUndertimeFrom = document.getElementById('date-leave-undertime-from').value;
		let leaveUndertimeTo = document.getElementById('date-leave-undertime-to').value;
		let reason = document.getElementById('reason').value;
		let other_reason = document.getElementById('other_reason').value;
		let nofdayleave = $('#nofdayleave').text();
		let leaveDayRemarks = (sessionStorage.getItem('leaveDayRemarks'))=='[]'? '':sessionStorage.getItem('leaveDayRemarks');
		let dayCover = (sessionStorage.getItem('leaveDayCover')) == 'null'? '': sessionStorage.getItem('leaveDayCover');
		let dayUnder = (sessionStorage.getItem('leaveDayUnder')) == 'null'? '': sessionStorage.getItem('leaveDayUnder');
		let undertime = document.getElementById('timeSelect').value;

		let formData = new FormData();
		formData.append('userID', userID);
		formData.append('leaveID', leaveID);
		formData.append('application_type', application_type);
		formData.append('leave_type', leaveType);
		formData.append('date_filed', dateFiled);
		formData.append('leave_undertime-from', leaveUndertimeFrom);
		formData.append('leave_undertime-to', leaveUndertimeTo);
		formData.append('reason', reason);
		formData.append('other_reason', other_reason);
		formData.append('nofdayleave', nofdayleave);
		formData.append('leave_days_remarks', leaveDayRemarks);
		formData.append('day_cover', dayCover);
		formData.append('undertime', dayUnder);
		formData.append('sel-undertime', undertime);


		fetch('../api/leave/update_emp_leave.php', {
			method: 'POST',
			credentials: "same-origin",
			body: formData
		})
			.then((res) => res.json())
			.then((data) => {
				let datares = "Successfully Updated Leave";

				if (data == datares) {
					$("#requestTriggerYes").html("UPDATING LEAVE..").attr('disabled','disabled');
					setTimeout(function() {
						window.open("myleave.php", "_self");
					}, 2000);
				} else {
					let message = `
					<div class="alert alert-warning alert-dismissible fade in" role="alert">
						<strong>Error!</strong> ${data}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
			`;
					$('#error').html(message);
				}
			})
			.catch((err) => console.log(err))
	}

	function getUnique(array){
        var uniqueArray = [];
        
        // Loop through array values
        for(i=0; i < array.length; i++){
            if(uniqueArray.indexOf(array[i]) === -1) {
                uniqueArray.push(array[i]);	
            }
        }
        return uniqueArray;
    }