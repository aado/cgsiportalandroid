<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container-fluid">
	<!-- Page Heading -->
	<!-- <h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1> -->
	<div class="leave"  style="margin-top: 20px">
	<h1 class="h3 mb-4 text-gray-800">HOLIDAYS</h1>
	<p><div id="holiday">
		<table id="holidayTbl" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Name</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($holiday as $hol) {?>
				<tr>
					<td><?=$hol['holiday_name']?></td>
					<td><?=date("D, d M Y", strtotime($hol['holiday_date']))?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table></p>
</div>

<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/leave.js'); ?>"></script>
