
$( document ).ready( function () {
    
	$('#memobody').summernote({
		placeholder: 'Enter Memo body',
		tabsize: 2,
		height: 250,
		toolbar: [
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']]
		  ]
	});

	var date = new Date();
	$("#date_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());
	$("#undate_filed").val((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear());

	date.setDate(date.getDate()+1);
	new Pikaday({ 
		field: document.getElementById('expiry'),
		disableWeekends: true,
		minDate: date,
		defaultDate: getAddvnceWeeksDate(new Date()),
		setDefaultDate: true
	});

	// MEMO DATATABLE
	$('#memoTable').DataTable( {
		responsive: true,
		"columnDefs": [{ type: 'date', 'targets': [6]}],
		order: [[ 6, 'DESC' ]],
		pageLength : 5,
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

	$.each($.validator.methods, function (key, value) {
        $.validator.methods[key] = function () {           
            if(arguments.length > 0) {
                arguments[0] = $.trim(arguments[0]);
            }

            return value.apply(this, arguments);
        };
    });

	$( "#frmmemo" ).validate( {
		rules: {
			memotype: {
				required: true
			},
			subject: {
				required: true,
			},
			expiry: {
				required: true
			}
		},
		messages: {
			subject: "Subject required",
			memotype: {
				required: "Memo required.", 
			},
			expiry: "Expiry date required",
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
			addMemo();
		}
	} );

	$( "#frmContri" ).validate( {
		rules: {
			amount: {
				required: true
			}
		},
		messages: {
			amount: "Amount required."
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
			addContri();
		}
	} );

	$("#btnPrint").click(function() {
		printElement(document.getElementById("printThis"));
	});

	$("#contribution").click( function() {
		$('#addAmountDiv').toggle();
		$('#frmContri').attr('style','margin-right: 50px');
	});

} );


function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

function addMemo() {
	var memoBody = $("#memobody").summernote('code');
	var frmSerialize = $("#frmmemo").serialize();
	$.ajax({
		url: 'saveMemo',
		type: 'POST',
		data: frmSerialize + "&memobody= "+memoBody+"",
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

function addContri() {
	var frmSerialize = $("#frmContri").serialize();
	console.log(frmSerialize);
	$.ajax({
		url: 'addContriAmt',
		type: 'POST',
		data: frmSerialize,
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

function memoPrintModal(memoid) {
	$("#addAmountDiv").attr('style','display: none');
	$.ajax({
		url: 'viewMemo',
		type: 'POST',
		data: {memoid: memoid},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			var result = JSON.parse(data);
			if(result['success']) {
				var data = result['data'];
				$("#memoPrintBody").html(data['memo_description']);
				var monthNames = ["January", "February", "March", "April", "May","June","July", "August", "September", "October", "November","December"];

				var d = new Date(data['memo_created']);
				$("#memoDate").html(monthNames[d.getMonth()]+' '+d.getDate()+', '+d.getFullYear());
				$("#memoSubject").html(data['memo_name'].toUpperCase());
				$("#memo_id").val(data['memo_id']);
				if (data['memo_type'] == 2) {
					$("#memoTypeT").html("Contribution Memo");
					var expiry_date = new Date(data['memo_expiry']).getTime();
					var date_now = Date.now();
					if (expiry_date < date_now) {
						$("#contribution").attr('style','display: none');
					} else {
						$("#contribution").removeAttr('style');
					}
				} else {
					$("#contribution").attr('style','display: none');
					$("#memoTypeT").html("Normal Memo");
				}
			}
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

function confirmMemo(ident, lid) {
	$("#memoID").val(lid);
	$("#approveCancel").val(ident);
	if (ident == 2) {
		$("#rejectReason").removeAttr('style');
		$("#rejectReason").attr('style','display: block;height: 175px;margin-top: 6px');
		$("#lblConfirm").html('<span style="color:red; font-weight: bold">REJECT</span>');
	} else {
		$("#rejectReason").removeAttr('style');
		$("#rejectReason").val('');
		$("#rejectReason").attr('style','display: none');
		$("#lblConfirm").html('<span style="color:blue; font-weight: bold">APPROVED</span>');
	}
}

function confirmMemoSubmit() {
	var memoid = $("#memoID").val();
	var statusType = $("#approveCancel").val();
	var rejectreason = $("#rejectReason").val();
	$.ajax({
		url: 'saveMemoSubmit',
		type: 'POST',
		data: {memoid: memoid,statustype: statusType, rejectreason: rejectreason},
		error: function() {	
			alert('Something is wrong');
		},
		success: function(data) {
			// console.log(data);
			var result = JSON.parse(data);
			if(result['success']) {
				location.reload();
			}
		}
	});
}

function getMemoType(type,memoid) {
	$('#contriTable1').DataTable( {
        dom: "Bfrtip",
		buttons: [
					'excelHtml5',
				],
        ajax: {
            url: 'getAllMemoViewerById',
			type: 'GET',
			data: {memoid: memoid, memotype: type},
        },
        columns: [
			{ 
				title: "Fullname",
				data: "firstname", 
				render: function (data, type, row) {
                    return '<b>'+row['firstname']+' '+row['lastname']+'</b>';
                },
			},
			{ 
				title: "Department",
				data: "firstname", 
				render: function (data, type, row) {
                    return row['departmentname']+', '+row['designationname'];
                }
			},
			{ title: "Amount", data: "amount",
				render: function (data, type, row) {
					console.log(row['amount']);
					if (row['amount'] == 0) {
						return '50';
					} else if (row['amount'] == undefined){
						return '50';
					} else {
						return row['amount'];
					}
				}
			},
        ],
		"bDestroy": true
    } );

	$('#contriTable2').DataTable( {
        dom: "Bfrtip",
		buttons: [
			'excelHtml5',
		],
        ajax: {
            url: 'getAllMemoViewerById',
			type: 'GET',
			data: {memoid: memoid, memotype: type},
        },
        columns: [
            { 
				title: "Fullname",
				data: "firstname", 
				render: function (data, type, row) {
                    return '<b>'+row['firstname']+' '+row['lastname']+'</b>';
                },
			},
			{ 
				title: "Department",
				data: "firstname", 
				render: function (data, type, row) {
                    return row['departmentname']+', '+row['designationname'];
                }
			},
        ],
		"bDestroy": true
    } );
	if (type == 1) {
		$("#viewByDiv1").attr('style','display: none;');
		$("#viewByDiv2").removeAttr('style');
		$("#memoTypeT").html("Normal");
	} else {
		$("#viewByDiv2").attr('style','display: none;');
		$("#viewByDiv1").removeAttr('style');
		$("#memoTypeT").html("Contribution");
	}

}

function getAddvnceWeeksDate() {
	const now = new Date();

	return new Date(now.getFullYear(), now.getMonth(), now.getDate() + 7);
}

function removeMemo(id) {
	if(confirm("Are you sure you want to delete this memo?")){
		$.ajax({
			url: 'removeMemo',
			type: 'POST',
			data: {memo_id: id},
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

		