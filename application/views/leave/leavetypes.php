<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container-fluid">
	<!-- Page Heading -->
	<!-- <h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1> -->
	<div class="leave"  style="margin-top: 20px">
	<hr />
	<h1 class="h3 mb-4 text-gray-800">LEAVE TYPE</h1>
	<p><div id="holiday">
		<table id="leaveTable" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th style="width: 100px !important">Name</th>
					<th style="width: 200px !important">Start Date</th>
					<th>End Date</th>
					<th>No of Days</th>
					<th>Year</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>'.$leave['leave_type_name'].'</td>
					<td>'.$leave['reason'].'</td>
					<td>'.$leave['reason'].'</td>
					<td>'.$leave['reason'].'</td>
					<td>'.$leave['reason'].'</td>
				</tr>
			</tbody>
		</table></p>
</div>

<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/leave.js'); ?>"></script>
