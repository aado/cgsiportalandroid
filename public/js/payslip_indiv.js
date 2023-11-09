$( document ).ready( function () {
    dateVal = new Date();
	// payrollCutoff(dateVal);

	$("#resendVerif").click(function() {
		location.reload();
	});

	var timer2 = "5:01";
	var interval = setInterval(function() {


	var timer = timer2.split(':');
	//by parsing integer, I avoid all extra string processing
	var minutes = parseInt(timer[0], 10);
	var seconds = parseInt(timer[1], 10);
	--seconds;
	minutes = (seconds < 0) ? --minutes : minutes;
	if (minutes < 0) clearInterval(interval);
	seconds = (seconds < 0) ? 59 : seconds;
	seconds = (seconds < 10) ? '0' + seconds : seconds;
	//minutes = (minutes < 10) ?  minutes : minutes;
	$('.otpcount').html(minutes + ':' + seconds);
	timer2 = minutes + ':' + seconds;
	if (minutes == '0' && seconds == '00') {
		$("#resendVerif").removeAttr('style');
		$("#verify").attr('style','display: none');
		$("#timerLabel").attr('style','display: none');
		$("#otp").val('');
	}
	}, 1000);

	$("#showPayslip").click(function() {
		$("#payslipContainer").slideToggle('slow');
		if ($(this).hasClass('fa-arrow-down')) {
			$(this).removeClass('fa-arrow-down').addClass('fa fa-arrow-up');
		} else {
			$(this).removeClass('fa-arrow-up').addClass('fa fa-arrow-down');
		}
	});

	$("body").on("click", "#upload", function () {
        //Reference the FileUpload element.
        var fileUpload = $("#fileUpload")[0];
 
        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
 
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        ProcessExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcessExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            console.log("Please upload a valid Excel file.");
        }
    });

    function ProcessExcel(data) {
        //Read the Excel File data.
        var workbook = XLSX.read(data, {
            type: 'binary'
        });
 
        //Fetch the name of First Sheet.
        var firstSheet = workbook.SheetNames[0];
 
        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
 
        //Add the data rows from Excel file.
		payAmt = [];
        for (var i = 0; i < excelRows.length; i++) {
			// console.log(excelRows[i]);
			payAmt.push(excelRows[i]);
        }
		var dataStringPay = JSON.stringify(payAmt);
		localStorage.setItem('paySlipData',dataStringPay);
    };

	// LEAVE DATATABLE
	$('#tblPayslip').DataTable( {
		"order": [[ 2, 'desc' ]],
		// buttons: [
		// 	'excelHtml5',
		// ],
		responsive: true,
		"columnDefs": [
		],
		pageLength : 5,
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

	$( "#frmOTP" ).validate( {
		rules: {
			otp: {
				required: true,
				minlength: 4,
				maxlength:4
			},
		},
		messages: {
			otp: {
				required: "Code is required, Please check SMS.",
				minlength: "Accept 4 digit OTP",
				maxlength: "Accept 4 digit OTP"
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
			verifyCode();
		}
	} );

} );

function verifyCode() {
	var frmSerialize = $("#frmOTP").serialize();
	$.ajax({
		url: 'checkVerify',
		type: 'POST',
		data: frmSerialize,
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			// console.log(data);
			var result = JSON.parse(data);
			if(result['success']) {
				$("#res_message").html('Code Verified successfully.');
				setTimeout(function() { 
					location.reload();
				}, 2000);
			}
		}
	});
}

function showbasicRate(e) {
	$("#basicRate").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; padding: 8px;margin-top: -8px;');
	$(e).removeAttr('style').attr('style','color: red');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','hidesbasicRate(this)');
}

function hidesbasicRate(e) {
	$("#basicRate").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left:0px;color: blue');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','showbasicRate(this)');
}

function showbasicRatenew(e) {
	$("#basicRatenew").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; padding: 8px;margin-top: -8px;');
	$(e).removeAttr('style').attr('style','color: red');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','hidesbasicRatenew(this)');
}

function hidesbasicRatenew(e) {
	$("#basicRatenew").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left:0px;color: blue');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','showbasicRatenew(this)');
}


function showbasicPay(e) {
	$("#basicPay").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; padding: 8px; margin-top: -8px;');
	$(e).removeAttr('style').attr('style','color: red');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','hidebasicPay(this)');
}

function hidebasicPay(e) {
	$("#basicPay").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left:0px;color: blue');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','showbasicPay(this)');
}

function showbasicPaynew(e) {
	$("#basicPaynew").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; padding: 8px; margin-top: -8px;');
	$(e).removeAttr('style').attr('style','color: red');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','hidebasicPaynew(this)');
}

function hidebasicPaynew(e) {
	$("#basicPaynew").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left:0px;color: blue');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','showbasicPaynew(this)');
}


function showNetPay(e) {
	$("#NETPAY").removeAttr('style').attr('style','margin-left: 126px; font-weight: bold; padding: 8px;').addClass('netPayVal');
	$(e).removeAttr('style').attr('style','font-size: 20px;color: red; margin-left: 24px');
	$(e).attr('class','fa fa-money-bill billiconMob');
	$(e).attr('onclick','hideNetPay(this)');
}

function hideNetPay(e) {
	$("#NETPAY").removeAttr('style').attr('style','margin-left: 126px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left: 230px; font-size: 20px;color: blue');
	$(e).attr('class','fa fa-money-bill billicon');
	$(e).attr('onclick','showNetPay(this)');
}


function showGrossPay(e) {
	$("#grossPay").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; padding: 8px;');
	$(e).removeAttr('style').attr('style','font-size: 20px;color: red; margin-left: 9px');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','hideGrossPay(this)');
}

function hideGrossPay(e) {
	$("#grossPay").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left: 80px; font-size: 20px;color: blue');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','showGrossPay(this)');
}


function showPrevGrossPay(e) {
	$("#prevGrossPay").removeAttr('style').attr('style','margin-left: 9px; font-weight: bold; padding: 8px;');
	$(e).removeAttr('style').attr('style','font-size: 20px;color: red');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','hideshowPrevGrossPay(this)');
}

function hideshowPrevGrossPay(e) {
	$("#prevGrossPay").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left: 80px; font-size: 20px;color: blue');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','showPrevGrossPay(this)');
}


function showmonthlyGrossPay(e) {
	$("#monthlyGrossPay").removeAttr('style').attr('style','margin-left: 9px; font-weight: bold; padding: 8px;');
	$(e).removeAttr('style').attr('style','font-size: 20px;color: red');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','hidesmonthlyGrossPay(this)');
}

function hidesmonthlyGrossPay(e) {
	$("#monthlyGrossPay").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; display: none');
	$(e).removeAttr('style').attr('style','margin-left: 80px; font-size: 20px;color: blue');
	$(e).attr('class','fa fa-money-bill');
	$(e).attr('onclick','showmonthlyGrossPay(this)');
}

function viewPayslipwithadj(payslip_id) {
	$("#newRate").show();
	$("#lblnew").show();
	$.ajax({
		url: 'viewPayslip',
		type: 'GET',
		data: {payslip_id: payslip_id},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			console.log(result);

			$("#payPeriod").html(result['payroll_period']);
			$("#pcutofflbl").html(result['payroll_period']);

			$("#payPeriod2").html(result['payroll_period']);
			$("#pcutofflbl2").html(result['payroll_cutoff']);

			var payslipData = JSON.parse(window.atob(result['payslipData']));
			paysliptblInner = '';

			
			for(var key in payslipData) {
				var ctr = 0;
				var basicEarning = {};
				if (payslipData[key]['ID'] == result['empid']) {
					for (const [key2, value] of Object.entries(payslipData[key])) {
							var keyValue = key2.replace(/[^\w\s]/gi, '').replaceAll(' ', '').toUpperCase();
							basicEarning[keyValue] = value;
					}
					// $("#jobDescription").html(basicEarning['DESIGNATION']);
					// $("#ABSENTUNDERTIME").html(basicEarning['ABSENTUNDERTIME']);
					// $("#LEGALPAYBDAYPAY").html(basicEarning['LEGALPAYBDAYPAY']);
					// $("#LEGALDUTY").html(basicEarning['RATE_9']);
					// $("#legHolyOTRate").html(basicEarning['RATE_10']);
					// $("#SUNDUTYAMT").html((basicEarning['SUNDUTYAMT'] == '0:00')? '0:00':basicEarning['SUNDUTYAMT']);
					// $("#regDays2").html(basicEarning['REGDAYSADJ']);
					// $("#prevbasicpay").html(payslipData[key]['PREVIOUS BASIC PAY']);
					// $("#regDaysrate").html(payslipData[key]['RATE_3']);
					// $("#ADJUSTMENTAMT").html(parseFloat(basicEarning['RATE_13'].replace(/,/g,'')) * basicEarning['REGDAYSADJ']);

					// $("#accntNum").html(payslipData[key]['ACCOUNT NUMBERS']);
					// $("#regDays").html(payslipData[key]['REG DAYS']);
					// $("#regDays_1").html(payslipData[key]['BASIC RATE']);
					// $("#basicPay").html(payslipData[key]['BASIC PAY']);
					// $("#basicRate").html(payslipData[key]['BASIC RATE']);
					// $("#regOT").html(payslipData[key]['REG. OT']);
					// $("#otRate").html(payslipData[key]['RATE']);
					// $("#regOTAMT").html(payslipData[key]['REG OT AMT.']);
					// $("#regOT1").html(payslipData[key]['REGOTAMT_1']);
					// $("#regOTrate_1").html(payslipData[key]['RATE']);
					// $("#regOTAMT_1").html('0');

					// $("#sunDRate").html(payslipData[key]['RATE_1']);
					// $("#sunDOTRate").html(payslipData[key]['RATE_2']);
					// $("#sunLRate").html(payslipData[key]['RATE_3']);
					// $("#sunLOTRate").html(payslipData[key]['RATE_4']);
					// $("#splDutyRate").html(payslipData[key]['RATE_5']);
					// $("#splDutyOTRate").html(payslipData[key]['RATE_6']);
					// $("#splSunOtRate").html(payslipData[key]['RATE_8']);

					// $("#sunDuty").html(payslipData[key]['SUN DUTY']);
					// $("#SUNOT").html(payslipData[key]['SUN OT']);
					// $("#SUNLEGALDUTY").html(payslipData[key]['SUN LEGAL DUTY']);
					// $("#SUNLEGALOT").html(payslipData[key]['SUN LEGAL OT']);
					// $("#SPECIALDUTY").html(payslipData[key]['SPECIAL DUTY']);
					// $("#SPECIALOT").html(payslipData[key]['SPECIAL OT']);
					// $("#SPLSUNOT").html(payslipData[key]['SPL SUN OT']);
					// $("#LEGALHOLDUTY").html(payslipData[key]['LEGAL HOL DUTY']);
					// $("#LEGALHOLOT").html(payslipData[key]['LEGAL HOL OT']);
					// $("#NP").html(payslipData[key]['NP']);
					// $("#ABSENT-undertime").html(payslipData[key]['ABSENT-undertime']);

					// $("#SUNLEGALDUTY1").html(payslipData[key]['SUN LEGAL DUTY_1']);
					// $("#sunLRate_1").html(payslipData[key]['RATE_17']);
					// $("#SUNLEGALAMT_1").html(payslipData[key]['SUN LEGAL AMT_1']);

					// $("#SUNLEGALOT_1").html(payslipData[key]['SUN LEGAL OT_1']);
					// $("#SUNLEGALOTrate_1").html(payslipData[key]['RATE_18']);
					// $("#SUNLEGALOTAMT_1").html(payslipData[key]['SUN LEGAL OT AMT._1']);
					// $("#SPECIALDUTY_1").html(payslipData[key]['SPECIAL DUTY_1']);
					// $("#splDutyRate_1").html(payslipData[key]['RATE_19']);
					// $("#SPLDUTYAMT_1").html(payslipData[key]['SPL DUTY AMT_1']);
					// $("#SPECIALOT_1").html(payslipData[key]['SPECIAL OT_1']);
					// $("#splDutyOTRate_1").html(payslipData[key]['RATE_20']);
					// $("#SPLOTAMT_1").html(payslipData[key]['SPL OT AMT_1']);
					// $("#SPLSUNOT_1").html(payslipData[key]['SPL SUN OT_1']);
					// $("#splSunOtRate_1").html(payslipData[key]['RATE_22']);
					// $("#SPLSUNOTAMT_1").html(payslipData[key]['SPL SUN OT AMT_1']);
					// $("#LEGALHOLDUTY_1").html((payslipData[key]['DUTY_1'] == '0.00')? '0':payslipData[key]['DUTY_1']);
					// $("#LEGALDUTYRATE_1").html(payslipData[key]['RATE_23']);
					// $("#LEGALHOLDUTYAMT_1").html(payslipData[key]['LEGAL HOL  DUTY AMT']);
					// $("#LEGALHOLOT_1").html((payslipData[key]['LEGAL HOL OT_1'] == '0.00')? '0':payslipData[key]['LEGAL HOL OT_1']);
					// $("#LEGALHOLOTRATE_1").html((payslipData[key]['RATE_24'] == '0.00')? '0':payslipData[key]['RATE_24']);
					// $("#LEGALHOLOTAMT_ 1").html(payslipData[key]['LEGAL HOL OT AMT']);
					// $("#NP_1").html(payslipData[key]['NP_1']);
					// $("#NPRATE_1").html(payslipData[key]['RATE_25']);
					// $("#NPAMT_1").html(payslipData[key]['NP AMT_1']);

					// $("#SUNOTAMT").html(payslipData[key]['SUN OT AMT']);
					// $("#SUNLEGALAMT").html(payslipData[key]['SUN LEGAL AMT']);
					// $("#SUNLEGALOTAMT").html((payslipData[key]['SUN LEGAL OT AMT'] == '0.00')? '0.00':payslipData[key]['SUN LEGAL OT AMT']);
					// // $("#SUNLEGALOTAMT").html(payslipData[key]['SUN LEGAL OT AMT']);
					// $("#SPLDUTYAMT").html(payslipData[key]['SPL DUTY AMT']);
					// $("#SPLSUNOTAMT").html(payslipData[key]['SPL SUN OT AMT']);
					// $("#LEGALHOLDUTYAMT").html(payslipData[key]['LEGAL HOL  DUTY AMT']);
					// $("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')? '0.00':payslipData[key]['SPL OT AMT']);
					// $("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')?'0.00':payslipData[key]['SPL OT AMT']);
					// $("#LEGALHOLOTAMT").html((payslipData[key]['LEGAL HOL  OT AMT'] == '0.00')?'0.00':payslipData[key]['LEGAL HOL  OT AMT']);
					// $("#NPAMT").html((payslipData[key]['NP AMT'] == '0.00')?'0.00':payslipData[key]['NP AMT']);
					// $("#LATEAMT").html((payslipData[key]['LATE AMT'] == '0.00')?'0.00':payslipData[key]['LATE AMT']);
					
					// $("#sunDuty1").html(payslipData[key]['SUNDUTY_1']);

					// $("#SUNOT1").html(payslipData[key]['SUN OT_1']); 
					// $("#sunDutyrate_1").html(payslipData[key]['RATE_15']);
					// $("#SUNDUTYAMT_1").html(payslipData[key]['SUNDUTYAMT_1']);
					// $("#SUNOTRate2").html(payslipData[key]['RATE_16']);
					// $("#SUNOTAMOUNT").html(payslipData[key]['SUNOTAMOUNT']);

					// $("#ABSAMOUNT").html((payslipData[key]['ABS AMOUNT'] == '0.00')?'0.00':payslipData[key]['ABS AMOUNT']);

					// $("#ADJUSTMENT").html(payslipData[key]['RATE_7']);
					// $("#NPRATE").html(payslipData[key]['RATE_11']);
					// $("#ABSENTRATE").html('-'+payslipData[key]['RATE_13']);

					// $("#grossPay").html(basicEarning['GROSSPAY']);
					// $("#prevGrossPay").html(payslipData[key]['PREVIOUS GROSS PAY']);
					// $("#monthlyGrossPay").html(payslipData[key]['TOTAL MONTHLY GROSS']);

					// $("#late").html(payslipData[key]['LATE']);
					// $("#lateRate").html('-'+payslipData[key]['RATE_12']);
					// $("#NETPAY").html(payslipData[key]['NET PAY']);
					// $("#mealallow").html(payslipData[key]['MEAL ALLOW']);
					// $("#motorental").html(payslipData[key]['MOTOR RENTAL_ALLOW']);
					// $("#13THMONTHADJUSTMENT").html(payslipData[key]['13th month adjustment']);
					// $("#VLpay").html(payslipData[key]['VL pay']);
					
					// // ADJUSTMENT
					// x = 14;
					// for (i = 2; i <= 8; i++) {
					// 	$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					// }
					// $("#adjustment9").html(basicEarning['RATE_7']);
					// // RATE ADJUSTMENT 
					// x = 22;
					// for (i = 10; i <= 12; i++) {
					// 	$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					// }
					// $("#adjustment13").html(payslipData[key]['LEGAL PAY-B-DAY PAY']);
					// $("#adjustment14").html(payslipData[key]['RATE_25']);

					$("#jobDescription").html(basicEarning['DESIGNATION']);
					$("#ABSENTUNDERTIME").html(basicEarning['ABSENTUNDERTIME']);
					$("#LEGALPAYBDAYPAY").html(basicEarning['LEGALPAYBDAYPAY']);
					$("#LEGALDUTY").html(basicEarning['RATE_9']);
					$("#legHolyOTRate").html(basicEarning['RATE_10']);
					$("#SUNDUTYAMT").html((basicEarning['SUNDUTYAMT'] == '0:00')? '0:00':basicEarning['SUNDUTYAMT']);
					$("#regDays2").html(payslipData[key]['REG DAYS ADJ']);
					$("#regDaysrate").html(payslipData[key]['RATE_17']);
					$("#prevbasicadj").html(payslipData[key]['RATE_17']);
					$("#ADJUSTMENTAMT").html(parseFloat(payslipData[key]['RATE_17'].replace(/,/g, '')) * parseFloat(payslipData[key]['REG DAYS ADJ']));
1
					$("#regdaysadj").html(payslipData[key]['REG DAYS ADJ']);
					$("#regdaysadjrate").html(basicEarning['RATE_3']);
					$("#regdaysamt").html(payslipData[key]['REG DAY ADJ AMOUNT']);

					$("#accntNum").html(payslipData[key]['ACCOUNT NUMBERS']);
					$("#regDays").html(payslipData[key]['REG DAYS']);

					$("#regDaysold").html(payslipData[key]['REG DAYS']);

					$("#regDays_1").html(payslipData[key]['BASIC RATE']);
					$("#basicPay").html(payslipData[key]['BASIC PAY_1']);

					$("#basicPayold").html(payslipData[key]['BASIC PAY_1']);
					
					$("#basicRate").html(payslipData[key]['BASIC RATE_1']);
					$("#regOT").html(payslipData[key]['REG. OT']);
					$("#otRate").html(payslipData[key]['RATE']);
					$("#regOTAMT").html(payslipData[key]['REG OT AMT._1']);
					$("#regOT1").html(payslipData[key]['REGOTAMT_1']);
					$("#regOTrate_1").html(payslipData[key]['RATE_1']);
					$("#regOTAMT_1").html('0');
					// $("#regOTAMT_1").html(payslipData[key]['REG OT AMT._1']);

					$("#sunDRate").html(payslipData[key]['RATE_1']);
					$("#sunDOTRate").html(payslipData[key]['RATE_2']);
					$("#sunLRate").html(payslipData[key]['RATE_3']);
					$("#sunLOTRate").html(payslipData[key]['RATE_4']);
					$("#splDutyRate").html((payslipData[key]['RATE_5'] == '0.00')? '0':payslipData[key]['RATE_5']);
					$("#splDutyOTRate").html(payslipData[key]['RATE_6']);
					$("#splSunOtRate").html(payslipData[key]['RATE_8']);

					$("#sunDuty").html(payslipData[key]['SUN DUTY']);
					$("#SUNOT").html(payslipData[key]['SUN OT']);
					$("#SUNLEGALDUTY").html(payslipData[key]['SUN LEGAL DUTY']);
					$("#SUNLEGALOT").html(payslipData[key]['SUN LEGAL OT']);
					$("#SPECIALDUTY").html((payslipData[key]['SPECIAL DUTY'] == '0.00' || payslipData[key]['SPECIAL DUTY'] == '')?'0':payslipData[key]['SPECIAL DUTY']);
					$("#SPECIALOT").html(payslipData[key]['SPECIAL OT']);
					$("#SPLSUNOT").html(payslipData[key]['SPL SUN OT']);
					$("#LEGALHOLDUTY").html((payslipData[key]['LEGAL HOL DUTY'] == '0.00')?'0':payslipData[key]['LEGAL HOL DUTY']);
					$("#LEGALHOLOT").html(payslipData[key]['LEGAL HOL OT']);
					$("#NP").html(payslipData[key]['NP']);
					$("#ABSENT-undertime").html(payslipData[key]['ABSENT-undertime']);

					$("#SUNLEGALDUTY1").html(payslipData[key]['SUN LEGAL DUTY_1']);
					$("#sunLRate_1").html(payslipData[key]['RATE_17']);
					$("#SUNLEGALAMT_1").html(payslipData[key]['SUN LEGAL AMT_1']);

					$("#SUNLEGALOT_1").html(payslipData[key]['SUN LEGAL OT_1']);
					$("#SUNLEGALOTrate_1").html(payslipData[key]['RATE_18']);
					$("#SUNLEGALOTAMT_1").html(payslipData[key]['SUN LEGAL OT AMT._1']);
					$("#SPECIALDUTY_1").html(payslipData[key]['SPECIAL DUTY_1']);
					$("#splDutyRate_1").html(payslipData[key]['RATE_19']);
					$("#SPLDUTYAMT_1").html(payslipData[key]['SPL DUTY AMT_1']);
					$("#SPECIALOT_1").html(payslipData[key]['SPECIAL OT_1']);
					$("#splDutyOTRate_1").html(payslipData[key]['RATE_20']);
					$("#SPLOTAMT_1").html(payslipData[key]['SPL OT AMT_1']);
					$("#SPLSUNOT_1").html(payslipData[key]['SPL SUN OT_1']);
					$("#splSunOtRate_1").html(payslipData[key]['RATE_22']);
					$("#SPLSUNOTAMT_1").html(payslipData[key]['SPL SUN OT AMT_1']);
					$("#LEGALHOLDUTY_1").html((payslipData[key]['DUTY_1'] == '0.00' || payslipData[key]['DUTY_1'] == '')? '0':payslipData[key]['DUTY_1']);
					$("#LEGALDUTYRATE_1").html(payslipData[key]['RATE_23']);
					$("#LEGALHOLDUTYAMT_1").html(payslipData[key]['LEGAL HOL  DUTY AMT']);
					$("#LEGALHOLOT_1").html((payslipData[key]['LEGAL HOL OT_1'] == '0.00')? '0':payslipData[key]['LEGAL HOL OT_1']);
					$("#LEGALHOLOTRATE_1").html((payslipData[key]['RATE_24'] == '0.00')? '0':payslipData[key]['RATE_24']);
					$("#LEGALHOLOTAMT_ 1").html(payslipData[key]['LEGAL HOL OT AMT']);
					$("#NP_1").html(payslipData[key]['NP_1']);
					$("#NPRATE_1").html(payslipData[key]['RATE_25']);
					$("#NPAMT_1").html(payslipData[key]['NP AMT_1']);

					$("#SUNOTAMT").html(payslipData[key]['SUN OT AMT']);
					$("#SUNLEGALAMT").html(payslipData[key]['SUN LEGAL AMT']);
					$("#SUNLEGALOTAMT").html((payslipData[key]['SUN LEGAL OT AMT'] == '0.00')? '0':payslipData[key]['SUN LEGAL OT AMT']);
					// $("#SUNLEGALOTAMT").html(payslipData[key]['SUN LEGAL OT AMT']);
					$("#SPLDUTYAMT").html(payslipData[key]['SPL DUTY AMT']);
					$("#SPLSUNOTAMT").html(payslipData[key]['SPL SUN OT AMT']);
					$("#LEGALHOLDUTYAMT").html((payslipData[key]['LEGAL HOL  DUTY AMT'] == '0' || payslipData[key]['LEGAL HOL  DUTY AMT'] == '')? '0':payslipData[key]['LEGAL HOL  DUTY AMT']);
					$("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')? '0.00':payslipData[key]['SPL OT AMT']);
					$("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')?'0.00':payslipData[key]['SPL OT AMT']);
					$("#LEGALHOLOTAMT").html((payslipData[key]['LEGAL HOL  OT AMT'] == '0.00')?'0.00':payslipData[key]['LEGAL HOL  OT AMT']);
					$("#NPAMT").html((payslipData[key]['NP AMOUNT'] == '0.00')?'0.00':payslipData[key]['NP AMOUNT']);
					$("#LATEAMT").html((payslipData[key]['LATE AMOUNT'] == '0.00')?'0.00':payslipData[key]['LATE AMOUNT']);
					
					$("#sunDuty1").html(payslipData[key]['SUNDUTY_1']);

					$("#SUNOT1").html(payslipData[key]['SUN OT_1']); 
					$("#sunDutyrate_1").html(payslipData[key]['RATE_15']);
					$("#SUNDUTYAMT_1").html(payslipData[key]['SUNDUTYAMT_1']);
					$("#SUNOTRate2").html(payslipData[key]['RATE_16']);
					$("#SUNOTAMOUNT").html(payslipData[key]['SUNOTAMOUNT']);

					$("#ABSAMOUNT").html((payslipData[key]['ABSENT AMOUNT'] == '0.00')?'0.00':payslipData[key]['ABSENT AMOUNT']);

					$("#ADJUSTMENT").html(payslipData[key]['RATE_7']);
					$("#NPRATE").html(payslipData[key]['RATE_11']);
					$("#ABSENTRATE").html('-'+payslipData[key]['RATE_13']);

					$("#LEGALPAYBDAYPAYS").html(payslipData[key]['RATE_13']);

					$("#grossPay").html(basicEarning['GROSSPAY']);
					$("#prevGrossPay").html(payslipData[key]['PREVIOUS GROSS PAY']);
					$("#monthlyGrossPay").html(payslipData[key]['TOTAL MONTHLY GROSS']);

					$("#late").html(payslipData[key]['LATE_1']);
					$("#lateRate").html('-'+payslipData[key]['RATE_12']);
					$("#NETPAY").html(payslipData[key]['NET PAY']);
					$("#mealallow").html(payslipData[key]['MEAL ALLOW']);
					$("#motorental").html(payslipData[key]['MOTOR RENTAL_ALLOW']);
					$("#13THMONTHADJUSTMENT").html(payslipData[key]['13th month adjustment']);
					$("#VLpay").html(payslipData[key]['VL pay']);
					
					// ADJUSTMENT
					 $("#basicRateprev").html(payslipData[key]['BASIC RATE_1']);
					// RATE ADJUSTMENT 14
					x = 14;
					for (i = 2; i <= 8; i++) {
						$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment9").html(basicEarning['RATE_7']);
					// RATE ADJUSTMENT 
					x = 22;
					for (i = 10; i <= 12; i++) {
						$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment13").html(payslipData[key]['LEGAL PAY-B-DAY PAY']);
					$("#adjustment14").html(payslipData[key]['RATE_25']);


					// OLD PAYSLIP

					for (const [deductions_name, deductValues] of Object.entries(payslipData[key])) {
						var deductName = deductions_name.replaceAll(' ', '').replaceAll('/','').replaceAll('.','').replaceAll("'",'').replaceAll('-','').replaceAll("`\`",'').toUpperCase();
						console.log(deductName +' = '+deductValues);
						if(deductName == 'RATE_9') {
							$("#LEGALDUTYRATEDDD").html(deductValues);
						}
					}

					// NEW RATE

					$("#jobDescriptionnew").html(basicEarning['DESIGNATION']);
					$("#ABSENTUNDERTIMEnew").html(basicEarning['ABSENT']);
					$("#LEGALPAYBDAYPAYnew").html(basicEarning['RATE_13']);
					$("#LEGALDUTYnew").html(basicEarning['RATE_9']);
					$("#legHolyOTRatenew").html(basicEarning['RATE_10']);
					$("#SUNDUTYAMTnew").html((basicEarning['SUNDUTYAMT'] == '0:00')? '0:00':basicEarning['SUNDUTYAMT']);
					$("#regDays2new").html(payslipData[key]['REG DAYS ADJ']);
					$("#regDaysratenew").html(payslipData[key]['RATE_3']);
					// $("#prevbasicadjnew").html(payslipData[key]['RATE_3']);
					$("#ADJUSTMENTAMTnew").html(parseFloat(payslipData[key]['RATE_3'].replace(/,/g, '')) * parseFloat(payslipData[key]['REG DAYS ADJ']));
1
					$("#regdaysadjnew").html(payslipData[key]['REG DAYS ADJ']);
					$("#regdaysadjratenew").html(basicEarning['RATE_3']);
					$("#regdaysamtnew").html(payslipData[key]['REG DAY ADJ AMOUNT']);

					$("#accntNumnew").html(payslipData[key]['ACCOUNT NUMBERS']);
					$("#regDaysnew").html(payslipData[key]['REG DAYS']);

					$("#regDaysnew").html(payslipData[key]['REG DAYS']);

					$("#regDays_1new").html(payslipData[key]['BASIC RATE']);
					$("#basicPaynew").html(payslipData[key]['BASIC PAY']);

					// $("#basicPaynew").html(payslipData[key]['BASIC PAY_1']);
					
					$("#basicRatenew").html(payslipData[key]['BASIC RATE']);
					$("#regOTnew").html(payslipData[key]['REG. OT_1']);
					$("#otRatenew").html(payslipData[key]['RATE_1']);
					$("#regOTAMTnew").html(payslipData[key]['REG OT AMT.']);
					$("#regOT1new").html(payslipData[key]['REGOTAMT_1']);
					$("#regOTrate_1new").html(payslipData[key]['RATE']);
					$("#regOTAMT_1new").html('0');

					$("#sunDRatenew").html(payslipData[key]['RATE_1']);
					$("#sunDOTRatenew").html(payslipData[key]['RATE_2']);
					$("#sunLRatenew").html(payslipData[key]['RATE_3']);
					$("#sunLOTRatenew").html(payslipData[key]['RATE_4']);
					$("#splDutyRatenew").html((payslipData[key]['RATE_5'] == '0.00')? '0':payslipData[key]['RATE_5']);
					$("#splDutyOTRatenew").html(payslipData[key]['RATE_6']);
					$("#splSunOtRatenew").html(payslipData[key]['RATE_8']);

					$("#sunDutynew").html(payslipData[key]['SUN DUTY']);
					$("#SUNOTnew").html(payslipData[key]['SUN OT']);
					$("#SUNLEGALDUTYnew").html(payslipData[key]['SUN LEGAL DUTY']);
					$("#SUNLEGALOTnew").html(payslipData[key]['SUN LEGAL OT']);
					$("#SPECIALDUTYnew").html((payslipData[key]['SPECIAL DUTY'] == '0.00' || payslipData[key]['SPECIAL DUTY'] == '')?'0':payslipData[key]['SPECIAL DUTY']);
					$("#SPECIALOTnew").html(payslipData[key]['SPECIAL OT']);
					$("#SPLSUNOTnew").html(payslipData[key]['SPL SUN OT']);
					$("#LEGALHOLDUTYnew").html((payslipData[key]['LEGAL HOL DUTY'] == '0.00')?'0':payslipData[key]['LEGAL HOL DUTY']);
					$("#LEGALHOLOTnew").html(payslipData[key]['LEGAL HOL OT']);
					$("#NPnew").html(payslipData[key]['NP_1']);
					$("#ABSENT-undertimenew").html(payslipData[key]['ABSENT-undertime']);

					$("#SUNLEGALDUTY1new").html(payslipData[key]['SUN LEGAL DUTY_1']);
					$("#sunLRate_1new").html(payslipData[key]['RATE_17']);
					$("#SUNLEGALAMT_1new").html(payslipData[key]['SUN LEGAL AMT_1']);

					$("#SUNLEGALOT_1new").html(payslipData[key]['SUN LEGAL OT_1']);
					$("#SUNLEGALOTrate_1new").html(payslipData[key]['RATE_18']);
					$("#SUNLEGALOTAMT_1new").html(payslipData[key]['SUN LEGAL OT AMT._1']);
					$("#SPECIALDUTY_1new").html(payslipData[key]['SPECIAL DUTY_1']);
					$("#splDutyRate_1new").html(payslipData[key]['RATE_19']);
					$("#SPLDUTYAMT_1new").html(payslipData[key]['SPL DUTY AMT_1']);
					$("#SPECIALOT_1new").html(payslipData[key]['SPECIAL OT_1']);
					$("#splDutyOTRate_1new").html(payslipData[key]['RATE_20']);
					$("#SPLOTAMT_1new").html(payslipData[key]['SPL OT AMT_1']);
					$("#SPLSUNOT_1new").html(payslipData[key]['SPL SUN OT_1']);
					$("#splSunOtRate_1new").html(payslipData[key]['RATE_22']);
					$("#SPLSUNOTAMT_1new").html(payslipData[key]['SPL SUN OT AMT_1']);
					$("#LEGALHOLDUTY_1new").html((payslipData[key]['DUTY_1'] == '0.00' || payslipData[key]['DUTY_1'] == '')? '0':payslipData[key]['DUTY_1']);
					$("#LEGALDUTYRATE_1new").html(payslipData[key]['RATE_23']);
					$("#LEGALHOLDUTYAMT_1new").html(payslipData[key]['LEGAL HOL  DUTY AMT']);
					$("#LEGALHOLOT_1new").html((payslipData[key]['LEGAL HOL OT_1'] == '0.00')? '0':payslipData[key]['LEGAL HOL OT_1']);
					$("#LEGALHOLOTRATE_1new").html((payslipData[key]['RATE_24'] == '0.00')? '0':payslipData[key]['RATE_24']);
					$("#LEGALHOLOTAMT_ 1new").html(payslipData[key]['LEGAL HOL OT AMT']);
					$("#NP_1new").html(payslipData[key]['NP_1']);
					$("#NPRATE_1new").html(payslipData[key]['RATE_25']);
					$("#NPAMT_1new").html(payslipData[key]['NP AMT_1']);

					$("#SUNOTAMTnew").html(payslipData[key]['SUN OT AMT']);
					$("#SUNLEGALAMTnew").html(payslipData[key]['SUN LEGAL AMT']);
					$("#SUNLEGALOTAMTnew").html((payslipData[key]['SUN LEGAL OT AMT'] == '0.00')? '0':payslipData[key]['SUN LEGAL OT AMT']);
					// $("#SUNLEGALOTAMT").html(payslipData[key]['SUN LEGAL OT AMT']);
					$("#SPLDUTYAMTnew").html(payslipData[key]['SPL DUTY AMT']);
					$("#SPLSUNOTAMTnew").html(payslipData[key]['SPL SUN OT AMT']);
					$("#LEGALHOLDUTYAMTnew").html((payslipData[key]['LEGAL HOL  DUTY AMT'] == '0' || payslipData[key]['LEGAL HOL  DUTY AMT'] == '')? '0':payslipData[key]['LEGAL HOL  DUTY AMT']);
					$("#SPLOTAMTnew").html((payslipData[key]['SPL OT AMT'] == '0.00')? '0.00':payslipData[key]['SPL OT AMT']);
					$("#SPLOTAMTnew").html((payslipData[key]['SPL OT AMT'] == '0.00')?'0.00':payslipData[key]['SPL OT AMT']);
					$("#LEGALHOLOTAMTnew").html((payslipData[key]['LEGAL HOL  OT AMT'] == '0.00')?'0.00':payslipData[key]['LEGAL HOL  OT AMT']);
					$("#NPAMTnew").html((payslipData[key]['NP AMT_1'] == '0.00')?'0.00':payslipData[key]['NP AMT_1']);
					$("#LATEAMTnew").html((payslipData[key]['LATE AMOUNT'] == '0.00')?'0.00':payslipData[key]['LATE AMOUNT']);
					
					$("#sunDuty1new").html(payslipData[key]['SUNDUTY_1']);

					$("#SUNOT1new").html(payslipData[key]['SUN OT_1']); 
					$("#sunDutyrate_1new").html(payslipData[key]['RATE_15']);
					$("#SUNDUTYAMT_1new").html(payslipData[key]['SUNDUTYAMT_1']);
					$("#SUNOTRate2new").html(payslipData[key]['RATE_16']);
					$("#SUNOTAMOUNTnew").html(payslipData[key]['SUNOTAMOUNT']);

					$("#ABSAMOUNTnew").html((payslipData[key]['ABS AMOUNT'] == '0.00')?'0.00':payslipData[key]['ABS AMOUNT']);
					console.log(payslipData[key]);

					$("#ADJUSTMENTnew").html(payslipData[key]['RATE_7']);
					$("#NPRATEnew").html(payslipData[key]['RATE_25']);
					$("#NPRATE_1new").html(payslipData[key]['RATE_11']);
					$("#ABSENTRATEnew").html('-'+payslipData[key]['RATE_24']);

					$("#grossPaynew").html(basicEarning['GROSSPAY']);
					$("#prevGrossPaynew").html(payslipData[key]['PREVIOUS GROSS PAY']);
					$("#monthlyGrossPaynew").html(payslipData[key]['TOTAL MONTHLY GROSS']);

					$("#latenew").html(payslipData[key]['LATE']);
					$("#lateRatenew").html('-'+payslipData[key]['RATE_23']);
					$("#NETPAYnew").html(payslipData[key]['NET PAY']);
					$("#mealallownew").html(payslipData[key]['MEAL ALLOW']);
					$("#motorentalnew").html(payslipData[key]['MOTOR RENTAL_ALLOW']);
					$("#13THMONTHADJUSTMENTnew").html(payslipData[key]['13th month adjustment']);
					$("#VLpaynew").html(payslipData[key]['VL pay']);
					
					// ADJUSTMENT
					 $("#basicRateprevnew").html(payslipData[key]['BASIC RATE_1']);
					// RATE ADJUSTMENT 14
					x = 14;
					for (i = 2; i <= 8; i++) {
						$("#adjustmentnew"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment9new").html(basicEarning['RATE_7']);
					// RATE ADJUSTMENT 
					x = 22;
					for (i = 10; i <= 12; i++) {
						$("#adjustmentnew"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment13new").html(payslipData[key]['LEGAL PAY-B-DAY PAY']);
					$("#adjustment14new").html(payslipData[key]['RATE_25']);

					
					var deducBody = '<tr><th colspan="2" style="text-align: center">DEDUCTIONS</th></tr>';
					var totalDeduction = 0;
					var ctr = 0;
					console.log(payslipData[key]);
					for (const [deductions_name, deductValues] of Object.entries(payslipData[key])) {
						// console.log(deductions_name);
						var deductName = deductions_name.replaceAll(' ', '').replaceAll('/','').replaceAll('.','').replaceAll("'",'').replaceAll('-','').replaceAll("`\`",'').toUpperCase();
						console.log(deductName);

						if (deductName == 'SSS' || deductName == 'SSSLOAN' || deductName == 'PHILHEALTH' || deductName == 'PAGIBIG' || deductName == 'SSSCALAMITYLOAN' || deductName == 'PAGIBIGLOAN' ||	deductName == 'PAGIBIGCALAMITYLOAN' || deductName == 'INSURANCE' || deductName == 'PERSONALDED' || deductName == 'EMPLOYEESSAVINGS' || deductName == 'AUBLOANOVERDUE' || deductName == 'UPLOAN' || deductName == 'EYEGLASSES' || deductName == 'ISURANCEIDANDMEMBERSHIPFEE' || deductName == 'ECQCASHADVANCES' || deductName == 'AUBLOAN' || deductName == 'PHILENSURE(DEPENDENTS)' || deductName == 'MOTORRENTALFORADJUNBILLEDPAYROLL' || deductName == 'COCOLIFE' || deductName == 'PAGIBIGMP2' || deductName == 'WITHHOLDINGTAX' || deductName == 'MP2' || deductName == 'PAGIBIGHOUSINGLOAN' || deductName == 'ADMINUNIFORMSADDITIONAL' || deductName == 'BADMINTONRACKET' || deductName == 'MOTORRENTALFORADJ' || deductName == "EYEGLASSESS" || deductName == "INSURANCEMEMBERSHIPFEE") {
							deducBody += '<tr>';
							deducBody += '<td>'+deductName+'</td>';
							deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}
						var str2 = "CASHASSISTANCE";
						if(deductName.indexOf(str2) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var giftWedding = "CASHGIFTWEDDING";
						if(deductName.indexOf(giftWedding) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var giftWedding2 = "CASHWEDDINGGIFT";
						if(deductName.indexOf(giftWedding2) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var cashAdvance = "CASHADVANCE";
						if(deductName.indexOf(cashAdvance) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var pagibigHousing = "PAGIBIGCALAMITY";
						if(deductName.indexOf(pagibigHousing) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var bdayPay = "BDAYPAY";
						if(deductName.indexOf(bdayPay) != -1){
							console.log('bdy'+deductValues);
							$("#LEGALPAYBDAYPAYAMT").html(deductValues);
							if(deductValues > 0) {
								$("#LEGALPAYBDAYPAYCount").html(1);
							} else {
								$("#LEGALPAYBDAYPAYCount").html(0);
							}
						}

						var funrun = "FUNRUN";
						if(deductName.indexOf(funrun) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var others = "OTHERS";
						if(deductName.indexOf(others) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						if (deductName == 'TOTALDEDUCTIONS') {
							totalDeduction = deductValues;
						}

						if (deductName == 'MOTORRENTALALLOW') {
							$("#motorental").html(deductValues);
						}

					}

					deducBody += '<tr><th>TOTAL DEDUCTIONS</th><th id="totalDeductions">'+totalDeduction+'</th></tr>';
						$("#deductions").html(deducBody);
				}
			}
		}
	});

	$('#searchPayslip').keyup(function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		
		$("#payslipTbl").find('tbody').find('tr').show().filter(function() {
			var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
			return !~text.indexOf(val);
		}).hide();
	});


}

function showPayslip(payslip_id, idnumber) {

	$.ajax({
		url: 'viewPayslip',
		type: 'GET',
		data: {payslip_id: payslip_id},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);

			$("#payPeriod").html(result['payroll_period']);
			$("#pcutofflbl").html(result['payroll_cutoff']);

			var payslipData = JSON.parse(window.atob(result['payslipData']));
			paysliptblInner = '';
			console.log(payslipData);

			
			for(var key in payslipData) {
				var ctr = 0;
				var basicEarning = {};
				if (payslipData[key]['ID'] == idnumber) {
					for (const [key2, value] of Object.entries(payslipData[key])) {
							var keyValue = key2.replace(/[^\w\s]/gi, '').replaceAll(' ', '').toUpperCase();
							basicEarning[keyValue] = value;
					}

					$("#empName").html(payslipData[key]['EMPLOYEE NAME']);
					// $("#jobDescription").html(position);
					// $("#idNumber").html(idnumber);
					// $("#accntNum").html(account);
					// $("#tinno").html(tinno);

					$("#jobDescription").html(basicEarning['DESIGNATION']);
					$("#ABSENTUNDERTIME").html(basicEarning['ABSENTUNDERTIME']);
					$("#LEGALPAYBDAYPAY").html(basicEarning['LEGALPAYBDAYPAY']);
					$("#LEGALDUTY").html(basicEarning['RATE_9']);
					$("#legHolyOTRate").html(basicEarning['RATE_10']);
					$("#SUNDUTYAMT").html((basicEarning['SUNDUTYAMT'] == '0:00')? basicEarning['SUNDUTYAMT']: '-');
					$("#regDays2").html(basicEarning['NOOFDAYS']);
					$("#ADJUSTMENTAMT").html(basicEarning['ADJUSTMENT']);

					$("#accntNum").html(payslipData[key]['ACCOUNT NUMBERS']);
					$("#regDays").html(payslipData[key]['REG DAYS']);
					$("#regDays_1").html(payslipData[key]['BASIC RATE']);
					$("#basicPay").html(payslipData[key]['BASIC PAY']);
					$("#basicRate").html(payslipData[key]['BASIC RATE']);
					$("#regOT").html(payslipData[key]['REG.OT']);
					$("#otRate").html(payslipData[key]['RATE']);
					$("#regOTAMT").html(payslipData[key]['REG OT AMT.']);

					$("#sunDRate").html(payslipData[key]['RATE_1']);
					$("#sunDOTRate").html(payslipData[key]['RATE_2']);
					$("#sunLRate").html(payslipData[key]['RATE_3']);
					$("#sunLOTRate").html(payslipData[key]['RATE_4']);
					$("#splDutyRate").html(payslipData[key]['RATE_5']);
					$("#splDutyOTRate").html(payslipData[key]['RATE_6']);
					$("#splSunOtRate").html(payslipData[key]['RATE_8']);

					$("#sunDuty").html(payslipData[key]['SUN DUTY']);
					$("#SUNOT").html(payslipData[key]['SUN OT']);
					$("#SUNLEGALDUTY").html(payslipData[key]['SUN LEGAL DUTY']);
					$("#SUNLEGALOT").html(payslipData[key]['SUN LEGAL OT']);
					$("#SPECIALDUTY").html(payslipData[key]['SPECIAL DUTY']);
					$("#SPECIALOT").html(payslipData[key]['SPECIAL OT']);
					$("#SPLSUNOT").html(payslipData[key]['SPL SUN OT']);
					$("#LEGALHOLDUTY").html(payslipData[key]['LEGAL HOL DUTY']);
					$("#LEGALHOLOT").html(payslipData[key]['LEGAL HOL OT']);
					$("#NP").html(payslipData[key]['NP']);
					$("#ABSENT-undertime").html(payslipData[key]['ABSENT-undertime']);

					$("#SUNOTAMT").html(payslipData[key]['SUN OT AMT']);
					$("#SUNLEGALAMT").html(payslipData[key]['SUN LEGAL AMT']);
					$("#SUNLEGALOTAMT").html(payslipData[key]['SUN LEGAL OT AMT']);
					$("#SUNLEGALOTAMT").html(payslipData[key]['SUN LEGAL OT AMT']);
					$("#SPLDUTYAMT").html(payslipData[key]['SPL DUTY AMT']);
					$("#SPLSUNOTAMT").html(payslipData[key]['SPL SUN OT AMT']);
					$("#LEGALHOLDUTYAMT").html(payslipData[key]['LEGAL HOL  DUTY AMT']);
					$("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')? '-':payslipData[key]['SPL OT AMT']);
					$("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')?'-':payslipData[key]['SPL OT AMT']);
					$("#LEGALHOLOTAMT").html((payslipData[key]['LEGAL HOL  OT AMT'] == '0.00')?'-':payslipData[key]['LEGAL HOL  OT AMT']);
					$("#NPAMT").html((payslipData[key]['NP AMT'] == '0.00')?'-':payslipData[key]['NP AMT']);
					$("#LATEAMT").html((payslipData[key]['LATE AMT'] == '0.00')?'-':payslipData[key]['LATE AMT']);
					
					$("#ABSAMOUNT").html((payslipData[key]['ABS AMOUNT'] == '0.00')?'-':payslipData[key]['ABS AMOUNT']);

					$("#ADJUSTMENT").html(payslipData[key]['RATE_7']);
					$("#NPRATE").html(payslipData[key]['RATE_11']);
					$("#ABSENTRATE").html('-'+payslipData[key]['RATE_13']);

					$("#grossPay").html(basicEarning['GROSSPAY']);
					$("#prevGrossPay").html(payslipData[key]['PREVIOUS GROSS PAY']);
					$("#monthlyGrossPay").html(payslipData[key]['TOTAL MONTHLY GROSS']);

					$("#late").html(payslipData[key]['LATE']);
					$("#lateRate").html('-'+payslipData[key]['RATE_12']);
					$("#NETPAY").html(payslipData[key]['NET PAY']);
					$("#mealallow").html(payslipData[key]['MEAL ALLOW']);
					$("#motorental").html(payslipData[key]['MOTOR RENTAL_ALLOW']);
					
					// ADJUSTMENT
					// $("#adjustment1").html(payslipData[key]['BASIC RATE_1']);
					// RATE ADJUSTMENT 14
					x = 14;
					for (i = 2; i <= 8; i++) {
						$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment9").html(basicEarning['RATE_7']);
					// RATE ADJUSTMENT 
					x = 22;
					for (i = 10; i <= 12; i++) {
						$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment13").html(payslipData[key]['LEGAL PAY-B-DAY PAY']);
					$("#adjustment14").html(payslipData[key]['RATE_25']);
					
					var deducBody = '<tr><th colspan="2" style="text-align: center">DEDUCTIONS</th></tr>';
					var totalDeduction = 0;
					var ctr = 0;
					console.log(payslipData[key]);
					for (const [deductions_name, deductValues] of Object.entries(payslipData[key])) {
						console.log(deductions_name);
						var deductName = deductions_name.replaceAll(' ', '').replaceAll('/','').replaceAll('.','').replaceAll("'",'').replaceAll('-','').replaceAll("`\`",'').toUpperCase();
						console.log(deductName);

						if(deductName == 'WITHHOLDINGTAX') {
							console.log(deductValues);
						}

						if (deductName == 'SSS' || deductName == 'SSSLOAN' || deductName == 'PHILHEALTH' || deductName == 'PAGIBIG' || deductName == 'SSSCALAMITYLOAN' || deductName == 'PAGIBIGLOAN' ||	deductName == 'PAGIBIGCALAMITYLOAN' || deductName == 'INSURANCE' || deductName == 'PERSONALDED' || deductName == 'EMPLOYEESSAVINGS' || deductName == 'AUBLOANOVERDUE' || deductName == 'UPLOAN' || deductName == 'EYEGLASSES' || deductName == 'ISURANCEIDANDMEMBERSHIPFEE' || deductName == 'ECQCASHADVANCES' || deductName == 'AUBLOAN' || deductName == 'PHILENSURE(DEPENDENTS)' || deductName == 'MOTORRENTALFORADJUNBILLEDPAYROLL' || deductName == 'COCOLIFE' || deductName == 'PAGIBIGMP2' || deductName == 'WITHHOLDINGTAX') {
							deducBody += '<tr>';
							deducBody += '<td>'+deductName+'</td>';
							deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}
						if (deductName == 'TOTALDEDUCTIONS') {
							totalDeduction = deductValues;
						}

						if (deductName == 'MOTORRENTALALLOW') {
							$("#motorental").html(deductValues);
						}

					}

					deducBody += '<tr><th>TOTAL DEDUCTIONS</th><th id="totalDeductions">'+totalDeduction+'</th></tr>';
					$("#deductions").html(deducBody);
				}
			}
		}
	});



	var duration = 'slow';
	$('#paySlipTable').hide(duration, function() {
        $('#paySlipDiv').show('slide', {direction: 'left'}, duration);
	});
	console.log(this);
	$("#showPayrollbtn").show();
}

function viewPayslip(payslip_id) {
	$("#newrate").hide();
	$("#lblnew").hide();
	$.ajax({
		url: 'viewPayslip',
		type: 'GET',
		data: {payslip_id: payslip_id},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			console.log(result);

			$("#payPeriod").html(result['payroll_period']);
			$("#pcutofflbl").html(result['payroll_period']);
			// $("#pcutofflbl").html(result['payroll_period'].split(' ')[1]+' '+result['payroll_period'].split(' ')[2]+' '+result['payroll_period'].split(' ')[3]);

			$("#payPeriod2").html(result['payroll_period']);
			$("#pcutofflbl2").html(result['payroll_cutoff']);

			var payslipData = JSON.parse(window.atob(result['payslipData']));
			paysliptblInner = '';

			
			for(var key in payslipData) {
				var ctr = 0;
				var basicEarning = {};
				if (payslipData[key]['ID'] == result['empid']) {
					for (const [key2, value] of Object.entries(payslipData[key])) {
							var keyValue = key2.replace(/[^\w\s]/gi, '').replaceAll(' ', '').toUpperCase();
							basicEarning[keyValue] = value;
					}

					for (const [deductions_name, deductValues] of Object.entries(payslipData[key])) {
						var deductName = deductions_name.replaceAll(' ', '').replaceAll('/','').replaceAll('.','').replaceAll("'",'').replaceAll('-','').replaceAll("`\`",'').toUpperCase();
						console.log(deductName +' = '+deductValues);
					}

					$("#jobDescription").html(basicEarning['DESIGNATION']);
					$("#ABSENTUNDERTIME").html(basicEarning['ABSENTUNDERTIME']);
					$("#LEGALPAYBDAYPAY").html(basicEarning['LEGALPAYBDAYPAY']);
					$("#LEGALDUTY").html(basicEarning['RATE_9']);
					$("#legHolyOTRate").html(basicEarning['RATE_10']);
					$("#SUNDUTYAMT").html((basicEarning['SUNDUTYAMT'] == '0:00')? '0:00':basicEarning['SUNDUTYAMT']);
					$("#regDays2").html(basicEarning['NOOFDAYS']);
					$("#prevbasicpay").html(payslipData[key]['PREVIOUS BASIC PAY']);
					$("#regDaysrate").html(basicEarning['RATE_13']);
					$("#ADJUSTMENTAMT").html(parseFloat(basicEarning['RATE_13'].replace(/,/g,'')) * basicEarning['NOOFDAYS']);

					$("#accntNum").html(payslipData[key]['ACCOUNT NUMBERS']);
					$("#regDays").html(payslipData[key]['REG DAYS']);
					$("#regDays_1").html(payslipData[key]['BASIC RATE']);
					$("#basicPay").html(payslipData[key]['BASIC PAY']);
					$("#basicRate").html(payslipData[key]['BASIC RATE']);
					$("#regOT").html(payslipData[key]['REG. OT']);
					$("#otRate").html(payslipData[key]['RATE']);
					$("#regOTAMT").html(payslipData[key]['REG OT AMT.']);
					$("#regOT1").html(payslipData[key]['REGOTAMT_1']);
					$("#regOTrate_1").html(payslipData[key]['RATE']);
					$("#regOTAMT_1").html('0');

					$("#sunDRate").html(payslipData[key]['RATE_1']);
					$("#sunDOTRate").html(payslipData[key]['RATE_2']);
					$("#sunLRate").html(payslipData[key]['RATE_3']);
					$("#sunLOTRate").html(payslipData[key]['RATE_4']);
					$("#splDutyRate").html(payslipData[key]['RATE_5']);
					$("#splDutyOTRate").html(payslipData[key]['RATE_6']);
					$("#splSunOtRate").html(payslipData[key]['RATE_8']);

					$("#sunDuty").html(payslipData[key]['SUN DUTY']);
					$("#SUNOT").html(payslipData[key]['SUN OT']);
					$("#SUNLEGALDUTY").html(payslipData[key]['SUN LEGAL DUTY']);
					$("#SUNLEGALOT").html(payslipData[key]['SUN LEGAL OT']);
					$("#SPECIALDUTY").html(payslipData[key]['SPECIAL DUTY']);
					$("#SPECIALOT").html(payslipData[key]['SPECIAL OT']);
					$("#SPLSUNOT").html(payslipData[key]['SPL SUN OT']);
					$("#LEGALHOLDUTY").html(payslipData[key]['LEGAL HOL DUTY']);
					$("#LEGALHOLOT").html(payslipData[key]['LEGAL HOL OT']);
					$("#NP").html(payslipData[key]['NP']);
					$("#ABSENT-undertime").html(payslipData[key]['ABSENT-undertime']);

					$("#SUNLEGALDUTY1").html(payslipData[key]['SUN LEGAL DUTY_1']);
					$("#sunLRate_1").html(payslipData[key]['RATE_17']);
					$("#SUNLEGALAMT_1").html(payslipData[key]['SUN LEGAL AMT_1']);

					$("#SUNLEGALOT_1").html(payslipData[key]['SUN LEGAL OT_1']);
					$("#SUNLEGALOTrate_1").html(payslipData[key]['RATE_18']);
					$("#SUNLEGALOTAMT_1").html(payslipData[key]['SUN LEGAL OT AMT._1']);
					$("#SPECIALDUTY_1").html(payslipData[key]['SPECIAL DUTY_1']);
					$("#splDutyRate_1").html(payslipData[key]['RATE_19']);
					$("#SPLDUTYAMT_1").html(payslipData[key]['SPL DUTY AMT_1']);
					$("#SPECIALOT_1").html(payslipData[key]['SPECIAL OT_1']);
					$("#splDutyOTRate_1").html(payslipData[key]['RATE_20']);
					$("#SPLOTAMT_1").html(payslipData[key]['SPL OT AMT_1']);
					$("#SPLSUNOT_1").html(payslipData[key]['SPL SUN OT_1']);
					$("#splSunOtRate_1").html(payslipData[key]['RATE_22']);
					$("#SPLSUNOTAMT_1").html(payslipData[key]['SPL SUN OT AMT_1']);
					$("#LEGALHOLDUTY_1").html((payslipData[key]['DUTY_1'] == '0.00')? '0':payslipData[key]['DUTY_1']);
					$("#LEGALDUTYRATE_1").html(payslipData[key]['RATE_23']);
					$("#LEGALHOLDUTYAMT_1").html(payslipData[key]['LEGAL HOL  DUTY AMT']);
					$("#LEGALHOLOT_1").html((payslipData[key]['LEGAL HOL OT_1'] == '0.00')? '0':payslipData[key]['LEGAL HOL OT_1']);
					$("#LEGALHOLOTRATE_1").html((payslipData[key]['RATE_24'] == '0.00')? '0':payslipData[key]['RATE_24']);
					$("#LEGALHOLOTAMT_ 1").html(payslipData[key]['LEGAL HOL OT AMT']);
					$("#NP_1").html(payslipData[key]['NP_1']);
					$("#NPRATE_1").html(payslipData[key]['RATE_25']);
					$("#NPAMT_1").html(payslipData[key]['NP AMT_1']);

					$("#SUNOTAMT").html(payslipData[key]['SUN OT AMT']);
					$("#SUNLEGALAMT").html(payslipData[key]['SUN LEGAL AMT']);
					$("#SUNLEGALOTAMT").html((payslipData[key]['SUN LEGAL OT AMT'] == '0.00')? '0.00':payslipData[key]['SUN LEGAL OT AMT']);
					// $("#SUNLEGALOTAMT").html(payslipData[key]['SUN LEGAL OT AMT']);
					$("#SPLDUTYAMT").html(payslipData[key]['SPL DUTY AMT']);
					$("#SPLSUNOTAMT").html(payslipData[key]['SPL SUN OT AMT']);
					$("#LEGALHOLDUTYAMT").html(payslipData[key]['LEGAL HOL  DUTY AMT']);
					$("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')? '0.00':payslipData[key]['SPL OT AMT']);
					$("#SPLOTAMT").html((payslipData[key]['SPL OT AMT'] == '0.00')?'0.00':payslipData[key]['SPL OT AMT']);
					$("#LEGALHOLOTAMT").html((payslipData[key]['LEGAL HOL  OT AMT'] == '0.00')?'0.00':payslipData[key]['LEGAL HOL  OT AMT']);
					$("#NPAMT").html((payslipData[key]['NP AMT'] == '0.00')?'0.00':payslipData[key]['NP AMT']);
					$("#LATEAMT").html((payslipData[key]['LATE AMT'] == '0.00')?'0.00':payslipData[key]['LATE AMT']);
					
					$("#sunDuty1").html(payslipData[key]['SUNDUTY_1']);

					$("#SUNOT1").html(payslipData[key]['SUN OT_1']); 
					$("#sunDutyrate_1").html(payslipData[key]['RATE_15']);
					$("#SUNDUTYAMT_1").html(payslipData[key]['SUNDUTYAMT_1']);
					$("#SUNOTRate2").html(payslipData[key]['RATE_16']);
					$("#SUNOTAMOUNT").html(payslipData[key]['SUNOTAMOUNT']);

					$("#ABSAMOUNT").html((payslipData[key]['ABS AMOUNT'] == '0.00')?'0.00':payslipData[key]['ABS AMOUNT']);

					$("#ADJUSTMENT").html(payslipData[key]['RATE_7']);
					$("#NPRATE").html(payslipData[key]['RATE_11']);
					$("#ABSENTRATE").html('-'+payslipData[key]['RATE_13']);

					$("#grossPay").html(basicEarning['GROSSPAY']);
					$("#prevGrossPay").html(payslipData[key]['PREVIOUS GROSS PAY']);
					$("#monthlyGrossPay").html(payslipData[key]['TOTAL MONTHLY GROSS']);

					$("#late").html(payslipData[key]['LATE']);
					$("#lateRate").html('-'+payslipData[key]['RATE_12']);
					$("#NETPAY").html(payslipData[key]['NET PAY']);
					$("#mealallow").html(payslipData[key]['MEAL ALLOW']);
					$("#motorental").html(payslipData[key]['MOTOR RENTAL_ALLOW']);
					$("#13THMONTHADJUSTMENT").html(payslipData[key]['13th month adjustment']);
					$("#VLpay").html(payslipData[key]['VL pay']);
					
					// ADJUSTMENT
					x = 14;
					for (i = 2; i <= 8; i++) {
						$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment9").html(basicEarning['RATE_7']);
					// RATE ADJUSTMENT 
					x = 22;
					for (i = 10; i <= 12; i++) {
						$("#adjustment"+i).html(payslipData[key]['RATE_'+x++]);
					}
					$("#adjustment13").html(payslipData[key]['LEGAL PAY-B-DAY PAY']);
					$("#adjustment14").html(payslipData[key]['RATE_25']);
					
					var deducBody = '<tr><th colspan="2" style="text-align: center">DEDUCTIONS</th></tr>';
					var totalDeduction = 0;
					var ctr = 0;
					console.log(payslipData[key]);
					for (const [deductions_name, deductValues] of Object.entries(payslipData[key])) {
						// console.log(deductions_name);
						var deductName = deductions_name.replaceAll(' ', '').replaceAll('/','').replaceAll('.','').replaceAll("'",'').replaceAll('-','').replaceAll("`\`",'').toUpperCase();
						console.log(deductName);

						if (deductName == 'SSS' || deductName == 'SSSLOAN' || deductName == 'PHILHEALTH' || deductName == 'PAGIBIG' || deductName == 'SSSCALAMITYLOAN' || deductName == 'PAGIBIGLOAN' ||	deductName == 'PAGIBIGCALAMITYLOAN' || deductName == 'INSURANCE' || deductName == 'PERSONALDED' || deductName == 'EMPLOYEESSAVINGS' || deductName == 'AUBLOANOVERDUE' || deductName == 'UPLOAN' || deductName == 'EYEGLASSES' || deductName == 'ISURANCEIDANDMEMBERSHIPFEE' || deductName == 'ECQCASHADVANCES' || deductName == 'AUBLOAN' || deductName == 'PHILENSURE(DEPENDENTS)' || deductName == 'MOTORRENTALFORADJUNBILLEDPAYROLL' || deductName == 'COCOLIFE' || deductName == 'PAGIBIGMP2' || deductName == 'WITHHOLDINGTAX' || deductName == 'MP2' || deductName == 'PAGIBIGHOUSINGLOAN' || deductName == 'ADMINUNIFORMSADDITIONAL' || deductName == 'BADMINTONRACKET' || deductName == 'MOTORRENTALFORADJ' || deductName == "EYEGLASSESS" || deductName == "INSURANCEMEMBERSHIPFEE") {
							deducBody += '<tr>';
							deducBody += '<td>'+deductName+'</td>';
							deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}
						var str2 = "CASHASSISTANCE";
						if(deductName.indexOf(str2) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var giftWedding = "CASHGIFTWEDDING";
						if(deductName.indexOf(giftWedding) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var giftWedding2 = "CASHWEDDINGGIFT";
						if(deductName.indexOf(giftWedding2) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var cashAdvance = "CASHADVANCE";
						if(deductName.indexOf(cashAdvance) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var pagibigHousing = "PAGIBIGCALAMITY";
						if(deductName.indexOf(pagibigHousing) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var bdayPay = "BDAYPAY";
						if(deductName.indexOf(bdayPay) != -1){
							console.log('bdy'+deductValues);
							$("#LEGALPAYBDAYPAYAMT").html(deductValues);
							if(deductValues > 0) {
								$("#LEGALPAYBDAYPAYCount").html(1);
							} else {
								$("#LEGALPAYBDAYPAYCount").html(0);
							}
						}

						var funrun = "FUNRUN";
						if(deductName.indexOf(funrun) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						var others = "OTHERS";
						if(deductName.indexOf(others) != -1){
							deducBody += '<tr>';
								deducBody += '<td>'+deductName+'</td>';
								deducBody += '<td>'+deductValues+'</td>';
							deducBody += '</tr>';
						}

						if (deductName == 'TOTALDEDUCTIONS') {
							totalDeduction = deductValues;
						}

						if (deductName == 'MOTORRENTALALLOW') {
							$("#motorental").html(deductValues);
						}

					}

					deducBody += '<tr><th>TOTAL DEDUCTIONS</th><th id="totalDeductions">'+totalDeduction+'</th></tr>';
						$("#deductions").html(deducBody);
				}
			}
		}
	});

	$('#searchPayslip').keyup(function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		
		$("#payslipTbl").find('tbody').find('tr').show().filter(function() {
			var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
			return !~text.indexOf(val);
		}).hide();
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

function checkUndefined(rowVal) {
	if (typeof(rowVal) === "undefined") {
		res = '';
	} else {
		res = rowVal;
	}
	return res;
}


function confirmLeave(ident, lid) {
	if (ident == 2) {
		$("#lblConfirm").html('<span style="color:red; font-weight: bold">REJECT</span>');
	} else {
		$("#lblConfirm").html('<span style="color:blue; font-weight: bold">APPROVED</span>');
	}
}

var getMonth = function(idx) {

	var objDate = new Date();
	objDate.setDate(1);
	objDate.setMonth(idx-1);
  
	var locale = "en-us",
		month = objDate.toLocaleString(locale, { month: "long" });
  
	  return month;
}

function removePayslip(id) {
	if(confirm("Are you sure you want to delete this Payslip?")){
		$.ajax({
			url: 'removePayslip',
			type: 'POST',
			data: {payslip_id: id},
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

		