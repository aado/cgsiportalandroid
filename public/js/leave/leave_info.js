	document.addEventListener("DOMContentLoaded", function () {
		leave_info();
	});

	function leave_info() {
		fetch('../api/leave/get_leave_info.php', {
			method: 'POST',
			credentials: "same-origin",
		})
		.then((res) => { return res.json() })
		.then((data) => {
			var html = '';
			// ITERATING THROUGH OBJECTS
			$.each(data, function (key, value) {
				console.log(value);
				html += '<tr>';
					html += '<td style="text-align: right" class="mdl-data-table__cell--non-numeric center">'+value.leave_additional+'</td><td style="text-align: right" class="mdl-data-table__cell--non-numeric right">'+value.total_leave_credit+'</td><td style="text-align: right" class="mdl-data-table__cell--non-numeric">'+value.leave_used+'</td><td style="text-align: right" class="mdl-data-table__cell--non-numeric">'+value.leave_left+'</td>';
				html += '</tr>';
			});
			//INSERTING ROWS INTO TABLE 
			$('#leaveInfoTable').append(html);
		})
		.catch((err) => console.log(err))
	}