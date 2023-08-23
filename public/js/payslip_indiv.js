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
		// dom: 'Bfrtip',
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
	$("#basicRate").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; padding: 8px; position: absolute; margin-top: -8px;');
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

function showbasicPay(e) {
	$("#basicPay").removeAttr('style').attr('style','margin-left: 0px; font-weight: bold; padding: 8px;');
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
	$("#grossPay").removeAttr('style').attr('style','margin-left: 9px; font-weight: bold; padding: 8px;');
	$(e).removeAttr('style').attr('style','font-size: 20px;color: red; margin-left: 10px');
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




function viewPayslip(payslip_id) {
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
					$("#jobDescription").html(basicEarning['DESIGNATION']);
					$("#jobDescription2").html(basicEarning['DESIGNATION']);
					$("#ABSENTUNDERTIME").html(basicEarning['ABSENTUNDERTIME']);
					$("#LEGALPAYBDAYPAY").html(basicEarning['LEGALPAYBDAYPAY']);
					$("#LEGALDUTY").html(basicEarning['RATE_9']);
					$("#legHolyOTRate").html(basicEarning['RATE_10']);
					$("#SUNDUTYAMT").html((basicEarning['SUNDUTYAMT'] == '0:00')? basicEarning['SUNDUTYAMT']: '-');
					$("#regDays2").html(basicEarning['NOOFDAYS']);
					$("#ADJUSTMENTAMT").html(basicEarning['ADJUSTMENT']);

					$("#accntNum").html(payslipData[key]['ACCOUNT NUMBERS']);
					$("#accntNum2").html(payslipData[key]['ACCOUNT NUMBERS']);
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

function saveLeaveApprovedReject() {
	$.ajax({
		url: 'approvedRejectLeave',
		type: 'POST',
		data: {leaveid: lid},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			// console.log(data);
			// var result = JSON.parse(data);
			// if(result['success']) {
			// 	location.reload();
			// }
		}
	});
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

		