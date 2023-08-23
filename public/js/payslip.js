$( document ).ready( function () {
    dateVal = new Date();
	payrollCutoff(dateVal);

	$("#fileUpload").click(function() {
		if (confirm('NOTE: RESERVED WORD IN HEADER IS NOT ALLOWED ( #, / ) AND REPLACE WITH ( - ), THANK YOU.')) {}
	});

	new Pikaday({ 
		field: document.getElementById('payroll_period'),
		disableWeekends: false,
		// minDate: payrollCutoff(dateVal),
		defaultDate: payrollCutoff(dateVal),
		setDefaultDate: true,
		disableDayFn: ((callbackDay) => {
			if(callbackDay.getDate() == 5 || callbackDay.getDate() == 20) {
				return false;
			} else {
				return true;
			}
		}),
		onSelect: function() {
			// picker.setMaxDate(this.getDate());
			payrollCutoff(this.getDate());
		}
	});

	$('#payslipViewModal').on('hidden.bs.modal', function () {
		// do something…
		$('#payslipTbl').html('');
	});

	function ProcessExcel() {
    // function ProcessExcel(data) {
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
                        // ProcessExcel(e.target.result);
						// console.log(ProcessExcel(e.target.result));
						var data = e.target.result;
						  //Read the Excel File data.
						  var workbook = XLSX.read(data, {
							type: 'binary'
						});
				 
						//Fetch the name of First Sheet.
						var firstSheet = workbook.SheetNames[0];
				 
						//Read all rows from First Sheet into an JSON array.
						// var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

						var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet] );
				 
						//Add the data rows from Excel file.
						payAmt = [];
						for (var i = 0; i < excelRows.length; i++) {
							// console.log(excelRows[i]);
							payAmt.push(excelRows[i]);
						}
						var dataStringPay = JSON.stringify(payAmt);
						// console.log(dataStringPay);
						addPayslip(dataStringPay);
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
                        // ProcessExcel(data);
						// var data = e.target.result;
						  //Read the Excel File data.
						  var workbook = XLSX.read(data, {
							type: 'binary'
						});
				 
						//Fetch the name of First Sheet.
						var firstSheet = workbook.SheetNames[0];
				 
						//Read all rows from First Sheet into an JSON array.
						var excelRows = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheet], {defval: ''} );
				 
						//Add the data rows from Excel file.
						payAmt = [];
						for (var i = 0; i < excelRows.length; i++) {
							payAmt.push(excelRows[i]);
						}
						var dataStringPay = JSON.stringify(payAmt);
						// console.log(dataStringPay);
						addPayslip(dataStringPay);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            console.log("Please upload a valid Excel file.");
        }
    };

	// LEAVE DATATABLE
	$('#tblPayslip').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'excelHtml5',
		],
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

	$( "#frmPayslip" ).validate( {
		rules: {
			payroll_period: {
				required: true
			},
			payroll_cutoff: {
				required: true,
			},
			excel_file: {
				required: true,
			},
		},
		messages: {
			payroll_period: "Payroll period required",
			payroll_cutoff: {
				required: "Payroll cut-off required.", 
			},
			excel_file: {
				required: "Excel file required.", 
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
			if (confirm('PLEASE MAKE SURE PAYSLIP DATA IS CHECKED. THANK YOU.')) {
				ProcessExcel();
			}
		}
	} );

} );

function payrollCutoff(dateVal) {
	var date = new Date(dateVal);
	var payroll_period_first = new Date(date.getFullYear(), date.getMonth(), 5);
	var payroll_period_second = new Date(date.getFullYear(), date.getMonth(), 20);
	console.log(payroll_period_first);
	var payroll_period = '';
	if (date > payroll_period_first) {
		if (date > payroll_period_second) {
			payroll_period = new Date(date.getFullYear(), date.getMonth() + 1, 5);
			payroll_cutoff1 = new Date(date.getFullYear(), date.getMonth() - 1, 11);
			payroll_cutoff2 = new Date(date.getFullYear(), date.getMonth() - 1, 25);
		} else {
			payroll_period = new Date(date.getFullYear(), date.getMonth(), 20);
			payroll_cutoff1 = new Date(date.getFullYear(), date.getMonth() - 1, 26);
			payroll_cutoff2 = new Date(date.getFullYear(), date.getMonth(), 10);
		}
	} else {
		payroll_period = new Date(date.getFullYear(), date.getMonth(), 5);
		payroll_cutoff1 = new Date(date.getFullYear(), date.getMonth() - 1, 11);
		payroll_cutoff2 = new Date(date.getFullYear(), date.getMonth() - 1, 25);
	}
	$("#payroll_cutoff").val(payroll_cutoff1.toDateString()+'-'+payroll_cutoff2.toDateString());
	return payroll_period;
}

function addPayslip(dataStringPay) {
	var frmSerialize = $("#frmPayslip").serialize();
	$("#upload").attr('disabled','disabled');
	$.ajax({
		url: 'savePayslip',
		type: 'POST',
		data: frmSerialize + "&payslipData= "+window.btoa(dataStringPay)+"",
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			$("#upload").removeAttr('disabled');
			var result = JSON.parse(data);
			if(result['success']) {
				$("#res_message").html('Payslip save successfully.');
				sendPayslipEmail();
				setTimeout(function() { 
					location.reload();
				}, 10000);
			}
		}
	});
}

function sendPayslipEmail() {
	// alert(1);
	$.ajax({
		url: 'sendPayslipEmail',
		type: 'GET',
		error: function() {
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			console.log(result);
			result.forEach((value, index, self) => {
				console.log(value['email'])
				emailjs.init("user_jXEHEjDvf6F3v7yYF4fMj"); //use your USER ID

					const toSend =  {
						to_name: value['firstname']+' '+value['lastname'],
						to_email: value['email'],
						payroll_period: $("#payroll_period").val()
					};

					emailjs.send('service_37v4ai9', 'template_spf43vh', toSend) //use your Service ID and Template ID
					.then(function(response) {
						console.log('SUCCESS!', response.status, response.text);
					}, function(error) {
						console.log('FAILED...', error);
					});
			})
		}
	});
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

			$("#pperiodlbl").html(result['payroll_period']);
			$("#pcutofflbl").html(result['payroll_cutoff']);

			var payslipData = JSON.parse(window.atob(result['payslipData']));
			// console.log(payslipData);
			paysliptblInner = '';
			BindTable(payslipData,'#payslipTbl');

			jQuery('#payslipTbl > tr').each(function(index, value) {
				var count = $(value).children('td:eq(0)').text();
				var name = $(value).children('td:eq(7)').text();
				var position = $(value).children('td:eq(1)').text();
				var idnumber = $(value).children('td:eq(5)').text();
				var account = $(value).children('td:eq(6)').text();
				var tinno = $(value).children('td:eq(4)').text();
				$(value).children('td:eq(0)').html('<span><span style="text-decoration: none;color: blue;cursor: pointer;font-weight: 800;" onclick="showPayslip(\'' + name + '\',\'' + position + '\','+idnumber+','+account+',\'' + tinno + '\','+payslip_id+')"> VIEW </span> '+count+'.</span>');
			});

		}
	});

	$('#searchPayslip').keyup(function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		
		$("#payslipTbl").find('tr').show().filter(function() {
			var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
			return !~text.indexOf(val);
		}).hide();
	});


}

function BindTable(jsondata, tableid) {/*Function used to convert the JSON array to Html Table*/  
     var columns = BindTableHeader(jsondata, tableid); /*Gets all the column headings of Excel*/  
     for (var i = 0; i < jsondata.length; i++) {  
         var row$ = $('<tr/>');  
         for (var colIndex = 0; colIndex < columns.length; colIndex++) {  
             var cellValue = jsondata[i][columns[colIndex]];  
             if (cellValue == null)  
                 cellValue = "";  
             row$.append($('<td/>').html(cellValue));  
         }  
         $(tableid).append(row$);  
     }  
 }  

 function BindTableHeader(jsondata, tableid) {/*Function used to get all column names from JSON and bind the html table header*/  
     var columnSet = [];  
     var headerTr$ = $('<tr style="background: antiquewhite; color: black;"	/>');  
     for (var i = 0; i < jsondata.length; i++) {  
         var rowHash = jsondata[i];  
         for (var key in rowHash) {  
             if (rowHash.hasOwnProperty(key)) {  
                 if ($.inArray(key, columnSet) == -1) {/*Adding each unique column names to a variable array*/  
                     columnSet.push(key);  
					 console.log(key['OTHERS-acebedo/gasoline/CA']);
                     headerTr$.append($('<th/>').html(key));  
                 }  
             }  
         }  
     }  
     $(tableid).append(headerTr$);  
     return columnSet;  
 }  

function getKeyName(data) {
    var firstItem = data[0];  // look at first array element
    for (var i in firstItem) {
        return(i);  // return first property name found
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

function checkUndefined(rowVal) {
	if (typeof(rowVal) === "undefined") {
		res = '';
	} else {
		res = rowVal;
	}
	return res;
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

// Show Individual Payslip

function showPayslip(name, position, idnumber, account, tinno, payslip_id) {
	
	$("#empName").html(name);
	$("#jobDescription").html(position);
	$("#idNumber").html(idnumber);
	$("#accntNum").html(account);
	$("#tinno").html(tinno);

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
	$('#payslipBody').hide(duration, function() {
        $('#paySlipDiv').show('slide', {direction: 'left'}, duration);});
	console.log(this);
	$("#showPayrollbtn").show();
}

function showPayroll() {
	var duration = 'slow';
	$('#paySlipDiv').hide('slide', {direction: 'left'}, duration, function() {
        $('#payslipBody').show(duration);});
		$("#showPayrollbtn").hide();
}

		