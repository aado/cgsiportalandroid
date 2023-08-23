<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<!-- style="margin-top: 50px" -->

	<table id="<?=($designationID == '44')? 'adminlist': 'adminlist'?>" class="table table-striped" style="width:100%;">
							<thead>
								<tr>
									<th >NAME</th>
									<th> BIRTHDATE </th>
									<th> DATE HIRED </th>
									<th> DESIGNATION </th>
								</tr>
							</thead>
							<tbody>
								<?php
									$fullname = '';
									$a = $AdminList;
									foreach ($AdminList as $credit) {
										if ($credit['emp_id'] != '300109') {
										echo '<tr>';
											$image_url = site_url('public/img/idpicture/'.$credit['emp_id'].'.jpg');
											$image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
											if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
												$empimage = site_url('public/img/idpicture/noimage.jpg');
											} else {
												$empimage = site_url('public/img/idpicture/'.$credit['emp_id'].'.jpg');
											}
											$fullname ='<img width="40" class="rounded-circle" src="'.$empimage.'" />
											<b style="font-size: 13px; position: absolute" title=" '.$credit['firstname'].' '.$credit['lastname'].'">'.$credit['firstname'].' '.substr($credit['lastname'], 0, 8).'</b>';
											echo '<td> '.$fullname.' </td>';
											
											echo '<td>'.$credit['Birthdate'].'</td>';
											echo '<td>'.$credit['date_hired'].'</td>';
											echo '<td>'.$credit['designationname'].'</td>';
											//echo '<td>'.$leaveLeft($credit['date_hired'],$credit['leave_used']).'</td>';
										echo '</tr>';
										}
									}
								?>
							</tbody>
						</table>

</div>
<!-- /.container-fluid -->
<script src="<?= site_url('public/js/adminmasterlist.js'); ?>"></script>
