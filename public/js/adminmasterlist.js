
$( document ).ready( function () {


	// LEAVE CREDIT
	$('#adminlist').DataTable( {
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

});