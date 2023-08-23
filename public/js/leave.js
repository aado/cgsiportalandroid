
$( document ).ready( function () {

	var input = $("#Reason"),
    output = $("#eventText"),
    bannedInput = ["matter","matters","personal reason","personal","reason","test","sex"];

	input.on("keyup", function (e) {

		var name = e.target.value.toLowerCase(), 
		match = $.grep(bannedInput, function (value) {
			return new RegExp(value).test(name)
		});
		if (!!match.length) {
			output.html(
			"<br />Please avoid using the following words and/or phrases: " 
			+ "<span class=banned>\"" 
			+ match.join(match.length === 1 ? " " : "\"<i>,</i> \"") 
			+ "\"</span>, using such words and/or phrases will lead to automatic reject of leave and/or undertime.");
			$("#submitBtn").attr('disabled','disabled');
		} else {
			output.empty();
			$("#submitBtn").removeAttr('disabled');
		}
	});

	var input2 = $("#under_Reason"),
    output2 = $("#under_eventText"),
    bannedInput2 = ["matter","matters","personal reason","personal","reason","test"];

	input2.on("keyup", function (e) {

		var name = e.target.value.toLowerCase(), 
		match = $.grep(bannedInput2, function (value) {
			return new RegExp(value).test(name)
		});
		if (!!match.length) {
			output2.html(
			"<br />Please avoid using the following words and/or phrases: " 
			+ "<span class=banned>\"" 
			+ match.join(match.length === 1 ? " " : "\"<i>,</i> \"") 
			+ "\"</span>");
			$("#submitBtn").attr('disabled','disabled');
		} else {
			output2.empty();
			$("#submitBtn").removeAttr('disabled');
		}
	});

	var input2 = $("#half_Reason"),
    output2 = $("#half_eventText"),
    bannedInput2 = ["matter","matters","personal reason","personal","reason","test"];

	input2.on("keyup", function (e) {

		var name = e.target.value.toLowerCase(), 
		match = $.grep(bannedInput2, function (value) {
			return new RegExp(value).test(name)
		});
		if (!!match.length) {
			output2.html(
			"<br />Please avoid using the following words and/or phrases: " 
			+ "<span class=banned>\"" 
			+ match.join(match.length === 1 ? " " : "\"<i>,</i> \"") 
			+ "\"</span>");
			$("#submitBtn").attr('disabled','disabled');
		} else {
			output2.empty();
			$("#submitBtn").removeAttr('disabled');
		}
	});

	var date = new Date();
	$("#date_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());
	$("#undate_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());
	var date = new Date();
	date.setDate(date.getDate()+1);
	new Pikaday({ 
		field: document.getElementById('datefrom'),
		disableWeekends: false,
		minDate: date,
		defaultDate: new Date(),
		setDefaultDate: true,
		onSelect: function() {
			if( $("#leavetype").val() == 10 ) {
				$("#dateto").attr('readonly','readonly');
				$("#dateto").val($("#datefrom").val());
				$("#ldayleave").text('1');
			} else {
				$("#dateto").removeAttr('readonly');
			}
			var date = new Date();
			var gdatefrom = new Date(this.getDate());
			var gdateto = new Date($("#dateto").val());
			console.log(gdateto);
			console.log(gdatefrom);

			var numOfDates = getBusinessDatesCount(gdatefrom,gdateto);
			console.log(numOfDates);

			$("#nofdayleave").val(numOfDates);
			$("#ldayleave").text(numOfDates);
			$("#tempLeaveDay").val(numOfDates);
			localStorage.setItem('noOfLeave',numOfDates);
		}
	});
	new Pikaday({ 
		field: document.getElementById('undatefrom'),
		disableWeekends: false,
		minDate: new Date(),
		defaultDate: new Date(),
		setDefaultDate: true
	});
	new Pikaday({ 
		field: document.getElementById('halfdatefrom'),
		disableWeekends: false,
		minDate: new Date(),
		defaultDate: new Date(),
		setDefaultDate: true
	});
	new Pikaday({ 
		field: document.getElementById('dateto'),
		disableWeekends: false,
		minDate: date,
		onSelect: function() {
			$("#dayswithoutpay").html("");
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
				$("#wouthpd").removeAttr('style');
			}
			var startDate = new Date(datefrom);
			var endDate = new Date(dateto);
			var numOfDates = getBusinessDatesCount(startDate,endDate);
			$("#nofdayleave").val(numOfDates);
			$("#ldayleave").text(numOfDates);
			$("#tempLeaveDay").val(numOfDates);
			localStorage.setItem('noOfLeave',numOfDates);

			$("#dtwoutp").removeAttr('style');
			var startDate = new Date($("#datefrom").val()); //YYYY-MM-DD
			var endDate = new Date($("#dateto").val()); //YYYY-MM-DD

			var getDateArray = function(start, end) {
				var arr = new Array();
				var dt = new Date(start);
				while (dt <= end) {
					arr.push(new Date(dt));
					dt.setDate(dt.getDate() + 1);
				}
				return arr;
			}

			var dateArr = getDateArray(startDate, endDate);
			var option = '';
			for (var i = 0; i < dateArr.length; i++) {
				if(new Date(dateArr[i]).getDay() == 6 || new Date(dateArr[i]).getDay() == 0) {
					option += '';
				} else {
					option += '<option>'+formatDate(dateArr[i])+'</option>';
				}
			}
			$("#dayswithoutpay").append(option);
        }
	});

	$("#undertime").hide();
	$("#halfday").hide();

	// TRIGGER APPLY LEAVE FORM
	$('#applytype').on('change', function() {
		if( this.value == 1) {
			$("#frmleave").show();
			$("#undertime").hide();
			$("#halfday").hide();
		} else if ( this.value == 2 ) {
			$("#frmleave").hide();
			$("#undertime").show();
			$("#halfday").hide();
		} else {
			$("#frmleave").hide();
			$("#undertime").hide();
			$("#halfday").show();
		}
	});

	// LEAVE DATATABLE
	$('#leaveTable').DataTable( {
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

	$('#holidayTbl').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
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
	
	// LEAVE DATATABLE
	$('#leaveTableDept').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
		responsive: true,
		"columnDefs": [{ type: 'date', 'targets': [4]}],
		order: [[ 4, 'desc' ]],
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

	// LEAVE CREDIT NORMAL EMPL
	$('#leavecredit2').DataTable( {
		responsive: true,
		"columnDefs": [
		],
		"paging":   false,
        "ordering": false,
        "info":     false,
		searching: false,
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
			$('#disclaimerModal').show();
			$("#disclaimerModal").find("div.modal-footer").children('button#disclaimerSubmit').attr('onclick','applyLeave(1)');
		}
	} );

	$( "#undertime" ).validate( {
		rules: {
			// under_time: {
			// 	required: true
			// },
			under_time_out: {
				required: true,
				// greaterThanTime: ["#under_time","Under Time"]
			},
			datefrom: {
				required: true
			},
			leavetype: {
				required: true,
			},
			under_Reason: {
				required: true,
			},
		},
		messages: {
			datefrom: "Date from required",
			// under_time: {
			// 	required: 'Time in is required'
			// },
			under_time_out: {
				required: 'Time out is required',
				// greaterThanTime: 'Time in must not greater than or equal with time out.'
			},
			leavetype: "Leave type required",
			under_Reason: {
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
			$('#disclaimerModal').show();
			$("#disclaimerModal").find("div.modal-footer").children('button#disclaimerSubmit').attr('onclick','applyLeave(2)');
		}
	} );

	$( "#halfday" ).validate( {
		rules: {
			halfdate: {
				required: true,
			},
			half_Reason: {
				required: true,
			},
		},
		messages: {
			halfdate: "Date from required",
			half_Reason: {
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
			$('#disclaimerModal').show();
			$("#disclaimerModal").find("div.modal-footer").children('button#disclaimerSubmit').attr('onclick','applyLeave(3)');
		}
	} );

	$('#dayswithoutpay').on("select2:select", function(e) { 
		// what you would like to happen
		var dwp = $("#dayswithoutpay").select2("val");
		$("#dWithoutPay").val(JSON.stringify(dwp));
		$("#ldayleave").text(parseInt(localStorage.getItem('noOfLeave')) - dwp.length);
		$("#tempLeaveDay").val(parseInt(localStorage.getItem('noOfLeave')) - dwp.length);
	 });

	 $('#dayswithoutpay').on('select2:unselect', function (e) {
        var dwp = $("#dayswithoutpay").select2("val");
		$("#dWithoutPay").val(JSON.stringify(dwp));
		$("#ldayleave").text(parseInt(localStorage.getItem('noOfLeave')) - dwp.length);     
		$("#tempLeaveDay").val(parseInt(localStorage.getItem('noOfLeave')) - dwp.length);
    });

	$("#leavetype").click(function() {
		if($(this).val() == 10) {
			$("#datefrom").val($("#birthdate").val());
			$("#dateto").attr('readonly','readonly');
			$("#dateto").val($("#birthdate").val());
			$("#ldayleave").text('1');
			$("#dtwoutp").attr('style','display:none');
			$("#Reason").text("It's my Birhtday.");
		} else if($(this).val() == 3) {
			$("#maternityLeave").attr('style','visibility: visible;font-size: 12px;width: 98% !important;left: 8px');
			$("#paternalLeave").attr('style','display:none');
		} else if($(this).val() == 4) {
			$("#paternalLeave").attr('style','visibility: visible;font-size: 12px;width: 98% !important;left: 8px');
			$("#maternityLeave").attr('style','display:none');
		} else if($(this).val() == 13) {
			var date = new Date();
			var monthNames = ["Jan", "Feb", "Mar", "Apr", "May","Jun","Jul", "Aug", "Sep", "Oct", "Nov","Dec"];
			var Days = ['Sun','Mon','Tue','Wed','Thur','Fri','Sat'];
			var Day = Days[date.getDay()];
			var datenow = Day+ ' '+(monthNames[date.getMonth()]) + ' ' + date.getDate() + ' ' +  date.getFullYear();
			console.log(datenow);
			$("#datefrom").val(datenow);
			$("#dateto").val(datenow);
			$("#dateto").attr('readonly','readonly');
			$("#datefrom").attr('readonly','readonly');
			$("#ldayleave").text('1');
		} else {
			$("#dateto").removeAttr('readonly');
			$("#maternityLeave").attr('style','display:none');
			$("#paternalLeave").attr('style','display:none');
			$("#datefrom").removeAttr('readonly');
		}
		if ($(this).val() !== '') {
			$("#attachment").removeAttr('style').attr('style','padding: 8px');
		}
	});

	$("#deleteImage").click(function () {
		$("#output").removeAttr('src');
		$("#attachmentWrap").attr('style','display: none');
		document.getElementById("attachment_file").value = "";
	});

} );

function isBanned(bannedWords, input){
	return $.map(bannedWords, function(n, i){
	  return input.indexOf(n) >= 0 ? n : 0;
	}   );
}

function getTimeDiff(date1,date2) {
	var diff = date1.getTime() - date2.getTime();

	var msec = diff;
	var hh = Math.floor(msec / 1000 / 60 / 60);
	msec -= hh * 1000 * 60 * 60;
	var mm = Math.floor(msec / 1000 / 60);
	msec -= mm * 1000 * 60;
	var ss = Math.floor(msec / 1000);
	msec -= ss * 1000;

	console.log(hh + " hour/s and " + mm + ":" + ss);
	$("#timeDiff").text(hh + " hour/s and " + mm +" min/s");
}

function applyLeave(applictype) {
	var frmSerialize = $("#frmleave").serialize();
	if (applictype == 2) {
		frmSerialize = $("#undertime").serialize();
	}
	if (applictype == 3) {
		console.log(3);
		frmSerialize = $("#halfday").serialize();
	}
	var file_data = $("#attachment_file").prop('files')[0];   
	var data = '';
	if (file_data) {
		var form_data = new FormData();
		form_data.append("file", file_data);
		form_data.append("application_type",applictype);
		form_data.append("date_filed",$("#date_filed").val());
		form_data.append("emp_id", $("#emp_id").val());
		form_data.append("posi_type",$("#posi_type").val());
		form_data.append("deep_type",$("#deep_type").val());
		form_data.append("designationID",$("#designationID").val());
		form_data.append("dWithoutPay",$("#dWithoutPay").val());
		form_data.append("tempLeaveDay",$("#tempLeaveDay").val());
		form_data.append("datefrom",$("#datefrom").val());
		form_data.append("dateto",$("#dateto").val());
		form_data.append("nofdayleave",$("#nofdayleave").val());
		form_data.append("leavetype",$("#leavetype").val());
		form_data.append("Reason",$("#Reason").val());
		form_data.append("designation",$("#designation").val());
		data = form_data;
		console.log(applictype);
		$.ajax({
			url: 'saveLeaveUndertime',
			type: 'POST',
			data: data,
			contentType: false,
			cache: false,
			   processData:false,
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				var result = JSON.parse(data);

				if(result['success']) {

					emailjs.init("user_jXEHEjDvf6F3v7yYF4fMj"); //use your USER ID

					var leavetype = '';
					if (applictype == '2') {
						leavetype = 'Undertime';
					} else  if (applictype == '3') {
						leavetype = 'Halfday';
					}

					const toSend =  {
						name: data['name'],
						department: data['department'],
						designation: data['designation'],
						to_email: data['email'],
						reason:leavetype +': '+data['reason'],
						noofleave: data['noofleave']
					};

					emailjs.send('service_37v4ai9', 'template_o9c9k4u', toSend) //use your Service ID and Template ID
					.then(function(response) {
						console.log('SUCCESS!', response.status, response.text);
					}, function(error) {
						console.log('FAILED...', error);
					});

					setTimeout(function(){
						window.location.reload();
					 }, 2000);

				}
			}
		});
	} else {
		data = frmSerialize + "&application_type= "+applictype;
		$.ajax({
			url: 'saveLeaveUndertime',
			type: 'POST',
			data: data,
			cache: false,
			error: function() {	
				alert('Something is wrong');
			},
			success: function(data) {
				var result = JSON.parse(data);
				if(result['success']) {
					var data = result['data'];

					emailjs.init("user_jXEHEjDvf6F3v7yYF4fMj"); //use your USER ID

					var leavetype = '';
					if (applictype == '2') {
						leavetype = 'Undertime';
					} else  if (applictype == '3') {
						leavetype = 'Halfday';
					}

					const toSend =  {
						name: data['name'],
						department: data['department'],
						designation: data['designation'],
						to_email: 'vinzadz1987@gmail.com',//data['email'], //
						reason: leavetype +': '+ data['reason'],
						noofleave: data['noofleave']
					};

					emailjs.send('service_37v4ai9', 'template_o9c9k4u', toSend) //use your Service ID and Template ID
					.then(function(response) {
						console.log('SUCCESS!', response.status, response.text);
					}, function(error) {
						console.log('FAILED...', error);
					});
					
					setTimeout(function(){
						window.location.reload();
					 }, 2000);


				}
			}
		});
	}
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

function confirmLeave(ident, lid, empid,templeave,applictype) {
	$("#confirmStatus").find('input#leaveID').val(lid);
	$("#confirmStatus").find('input#approveCancel').val(ident);
	$("#confirmStatus").find('input#empID').val(empid);
	$("#confirmStatus").find('input#templeaveday').val(templeave);
	$("#confirmStatus").find('input#applictype').val(applictype)
	if (ident == 2) {
		$("#confirmStatus").find("#rejectReason").removeAttr('style');
		$("#confirmStatus").find("#rejectReason").attr('style','display: block;width: 268px;height: 175px;margin-top: 6px');
		$("#confirmStatus").find("#lblConfirm").html('<span style="color:red; font-weight: bold">REJECT</span>');
	} else {
		$("#confirmStatus").find("#rejectReason").removeAttr('style');
		$("#confirmStatus").find("#rejectReason").val('');
		$("#confirmStatus").find("#rejectReason").attr('style','display: none');
		$("#confirmStatus").find("#lblConfirm").html('<span style="color:blue; font-weight: bold">APPROVED</span>');
	}
}

function confirmLeaveSubmit() {
	$("#confirmStatus").find("button#confirmLeaved").attr('disabled','disabled');
	var leaveid = $("#confirmStatus").find("#leaveID").val();
	var leavetype = $("#confirmStatus").find("#approveCancel").val();
	var rejectreason = $("#confirmStatus").find("#rejectReason").val();
	var empid = $("#confirmStatus").find("#empID").val();
	var temp_leave_day = $("#confirmStatus").find("#templeaveday").val();
	var application_type = $("#confirmStatus").find("#applictype").val();
	$.ajax({
		url: 'saveLeaveSubmit',
		type: 'POST',
		data: {leaveid: leaveid,leavetype: leavetype, rejectreason: rejectreason, empid: empid, temp_leave_day: temp_leave_day, application_type: application_type},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			if(result['success']) {
				console.log(result);

				var notif = result['notification'];


				emailjs.init("user_jXEHEjDvf6F3v7yYF4fMj"); //use your USER ID

					var leavetype = '';
					if (application_type == '2') {
						leavetype = 'Undertime';
					} else  if (applictype == '3') {
						leavetype = 'Halfday';
					}

					const toSend =  {
						name: notif['name'],
						department: notif['department'],
						designation: notif['designation'],
						to_email: data['email'], //'vinzadz1987@gmail.com',//
						reason: leavetype +': '+ notif['reason'],
						noofleave: notif['noofleave']
					};

					emailjs.send('service_37v4ai9', 'template_o9c9k4u', toSend) //use your Service ID and Template ID
					.then(function(response) {
						console.log('SUCCESS!', response.status, response.text);
					}, function(error) {
						console.log('FAILED...', error);
					});
				
					setTimeout(function(){
						window.location.reload();
					}, 2000);
			}
		}
	});
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
			var result = JSON.parse(data);
			if(result['success']) {
				location.reload();
			}
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

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
    return [month, day, year].join('-');
}

		