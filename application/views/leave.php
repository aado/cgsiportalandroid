<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=site_url('public/plugins/simplelightbox-master')?>/dist/simple-lightbox.css?v2.10.4" />
<style>
	i {
		color:rgb(0, 0, 0);
	}
	.banned {
		color:rgb(0, 0, 255);
	}
	.select2-container--default .select2-selection--multiple .select2-selection__choice {
		background-color: #0D6EFD;
		border: 1px solid #aaa;
		border-radius: 4px;
		cursor: default;
		float: left;
		margin-right: 5px;
		margin-top: 5px;
		padding: 0 5px;
	}
	.delete_image {
		font-size: 18px;
		color: white;
		background: #6c757d;
		padding: 3px;
		border-radius: 8px;
		cursor: pointer;
	}
	.img-wrap {
    position: relative;
    display: inline-block;
    border: 1px red #00bc8c;
    font-size: 0;
	margin-top: 5px;
	}
	.img-wrap .close {
		position: absolute;
		top: 2px;
		right: 2px;
		z-index: 100;
		background-color: #FFF;
		padding: 5px 2px 2px;
		color: #000;
		font-weight: bold;
		cursor: pointer;
		opacity: .2;
		text-align: center;
		font-size: 22px;
		line-height: 10px;
		border-radius: 50%;
	}
	.img-wrap:hover .close {
		opacity: 1;
	}
	.container .gallery a img {
		height: 80px !important;
		width: 80%;
		height: auto;
		border: 5px solid #fff;
		-webkit-transition: -webkit-transform .15s ease;
		-moz-transition: -moz-transform .15s ease;
		-o-transition: -o-transform .15s ease;
		-ms-transition: -ms-transform .15s ease;
		transition: transform .15s ease;
		position: relative;
		left: 14px;
	}

</style>
<div class="container-fluid">
	<!-- Page Heading -->
	<!-- <h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1> -->
	<div class="leave"  style="margin-top: 20px">
	<!-- Leave Count -->
	<div class="container-fluid" style="margin-left: -10px">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner" style="padding: 5px;padding-left: 15px;padding-top: 4px;">
                <p>ALL</p>
                <h3><?php echo $leaveCount(0) ?></h3>
              </div>
              <!-- <div class="icon">
			  	    <i class="fa fa-sticky-note" style="font-size: 40px;"></i>
              </div> -->
            </div>
          </div>
          <!-- ./col -->
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner" style="padding: 5px;padding-left: 15px;padding-top: 4px;">
                <p>APPROVED</p>
                <h3><?php echo $leaveCount(2)?></h3>
              </div>
              <!-- <div class="icon">
			  	    <i class="fa fa-check"  style="font-size: 40px;"></i>
              </div> -->
            </div>
          </div>
          <!-- ./col -->
		  <!-- ./col -->
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner" style="padding: 5px;padding-left: 15px;padding-top: 4px;">
                <p>DECLINED</p>
                <h3><?php echo $leaveCount(3) ?></h3>
              </div>
              <!-- <div class="icon">
			  	    <i class="fa fa-times"  style="font-size: 40px;"></i>
              </div> -->
            </div>
          </div>
          <!-- ./col -->
		  <!-- ./col -->
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner"  style="padding: 5px;padding-left: 15px;padding-top: 4px;">
                <p>PENDING</p>
                <h3><?php echo $leaveCount(1)?></h3>
              </div>
              <!-- <div class="icon">
			  	    <i class="fa fa-stop"   style="font-size: 40px;"></i>
              </div> -->
            </div>
          </div>	
          <!-- ./col -->
        </div>
	</div>
	<!-- Leave Count -->
	<!-- Leave Credit -->
	<!-- My Leave -->
	<hr />
	<!-- disclaimerModal -->
		<div class="modal" id="changepassModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 80px" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"> CHANGE PASSWORD</h5>
					</div>

					<form id="changePassword">
						<div class="modal-body">

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                      		<input type="hidden" id="idnumber" name="idnumber" value="<?=$idnumber?>">
							<input type="password" id="newpassword" name="newpassword" class="form-control form-control-sm" id="formGroupExampleInput2">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                      		<input type="password" id="renewPassword" name="renewpassword" class="form-control form-control-sm" id="formGroupExampleInput2">
                      </div>
                    </div>
					</div>
					<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="submitBtn"> CHANGE PASSWORD</button>
					</div>
					</form>
					<!-- </div> -->
				</div>
			</div>
		</div>


	<h1 class="h3 mb-4 text-gray-800">My Leave</h1>
	<p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyLeaveModal"><i class="fa fa-plus"></i> Add New Leave / Undertime / Halfday</button><button type="button" class="btn btn-info m-2" data-toggle="modal" data-target="#creditModal"><i class="fa fa-eye text-orange"></i> Credit Info</button></p>
	<p><div id="leave">
		<table id="leaveTable" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th style="width: 100px !important">TYPE</th>
					<th style="width: 200px !important">REASON</th>
					<th>STATUS</th>
					<th>FILED</th>
					<th>FROM</th>
					<th>TO</th>
					<th>APPROVER</th>
					<th>APPLICATION</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($leaveList as $leave) {
						$leave_remove = '';
						$leaveType = 'Leave';
						$withoutPay = '';
						$attachment = '';
						if ($leave['without_pay_days'] !='') {
							$withoutPay = '<span style="font-size: 11px">Day/s without pay: <b>'.$leave['without_pay_days'].'</b></span>';
						} 
						if ($leave['attachment'] != '') {
							$attachment = '<div class="container">
							<div class="gallery"><span style="cursor: pointer;font-size: 12px;color: mediumblue;"><a href="uploads/leave_images/'.$idnumber.'/'.(string)$leave['attachment'].'" style="text-decoration: none"> <img src="uploads/leave_images/'.$idnumber.'/'.(string)$leave['attachment'].'" alt="" title="Attachment: '.$leave['reason'].'"/></a></span><br/><br/><span style="font-size: 11px;position: relative;top: -15px;color: darkorchid;"></span></div></div>';
						}
						$timeout = '';
						if ($leave['application_type'] == 2) {
							$leaveType = 'Undertime';
							$timeout = 'Out: '.$leave['undertime_out'];
						} 
						if ($leave['application_type'] == 3) {
							$leaveType = 'Halfday';
							$timeout = 'halfday: '.$leave['halfday'];
						}
						echo '<tr>';
							echo '<td>'.$leave['leave_type_name'].'</td>';
							echo '<td>'.$leave['reason'].'</td>';
							$leave_status = '<span class="bg-warning" style="padding: 5px;
							border-radius: 8px; font-size: 12px">Declined <i class="fa fa-times"></i></span>';
							if ($leave['leave_status'] == '1') {
								$leave_status = '<span class="bg-danger" style="padding: 5px;
								border-radius: 8px; font-size: 12px">Pending <i class="fa fa-spinner"></i></sp	an>';
								$leave_remove = '<span onclick="removeLeave('.$leave['id'].')"><i  style="pointer: cursor; color: red"  class="fa fa-trash" aria-hidden="true"></i></span>';
							} else if ($leave['leave_status'] == '2') {
								$leave_status = '<span class="bg-success" style="padding: 5px;
								border-radius: 8px; font-size: 11px">Approved <i class="fa fa-check"></i></span>';
							}
							echo '<td>'.$leave_status.'</td>';

							echo '<td>
								'.$leave['apply_date'].'
								<span style="font-size: small;display: block;color: blue;">'.$leave['temp_leave_day'].' day/s leave</span>
							</td>';
							echo '<td>'.$leave['date_from'].'</td>';

							echo '<td>'.$leave['date_to'].' <span style="font-size: small;display: block;color: blue;">'.$timeout.'</span></td>';
							echo '<td>'.$approverList($leave['id']).'</td>';
							echo '<td style="text-align: right">'.$leaveType.'<br />'.$withoutPay.' '.$attachment.'</td>';
							echo '<td>'.$leave_remove.'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table></p>
		<!-- My Leave -->
		<!-- My Dept Leave list -->
	<?php if ($posi_type !== '0') { ?>
	<hr />
	<h1 class="h3 mb-4 text-gray-800">My History</h1>
	<p><div id="leave">
		<table id="leaveTableDept" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th style="width: 200px !important">NAME</th>
					<th>TYPE</th>
					<th>REASON</th>
					<th>STATUS</th>
					<th>FILED</th>
					<th>FROM</th>
					<th style="width: 200px !important">TO</th>
					<th style="width: 200px !important">APPROVER</th>
					<th>APPLICATION</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$fullname = '';
					foreach ($leaveListDept as $leavedept) {
						$leave_remove = '';
						$approvedenied = '';
						$leaveType = 'Leave';
						$timeout = '';
						$attachment = '';
						if ($leavedept['without_pay_days'] !='') {
							$withoutPay = '<span style="font-size: 11px">Day/s without pay: <b>'.$leavedept['without_pay_days'].'</b></span>';
						} else {
							$withoutPay = '';
						}
						if ($leavedept['attachment'] != '') {
							$attachment = '<div class="container">
							<div class="gallery"><span style="cursor: pointer;font-size: 12px;color: mediumblue;"><a href="uploads/leave_images/'.$leavedept['emp_id'].'/'.$leavedept['attachment'].'" style="text-decoration: none"> <img src="uploads/leave_images/'.$leavedept['emp_id'].'/'.$leavedept['attachment'].'" alt="" title="Attachment of '.$leavedept['firstname'].' '.$leavedept['lastname'].' '.$leavedept['firstname'].' : '.$leavedept['reason'].'"/></a></span><br/><br/><span style="font-size: 11px;position: relative;top: -15px;color: darkorchid;"></span></div></div>';
						}
						if ($leavedept['application_type'] == 2) {
							$leaveType = 'Undertime/halfday';
							$timeout = 'Time out: '.$leavedept['undertime'];
							$withoutPay = '';
						}
						if ($leavedept['application_type'] == 3) {
							$leaveType = 'Halfday';
							$timeout = 'Halfday: '.$leavedept['halfday'];
							$withoutPay = '';
						}
						echo '<tr>';
						$image_url = site_url('public/img/idpicture/'.$leavedept['emp_id'].'.jpg');
						$image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
						if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
							$empimage = site_url('public/img/idpicture/noimage.jpg');
						} else {
							$empimage = site_url('public/img/idpicture/'.$leavedept['emp_id'].'.jpg');
						}
						$fullname = '<img width="40" class="rounded-circle" src="'.$empimage.'" />
							<b style="font-size: 13px; position: absolute" title="'.$leavedept['firstname'].' '.$leavedept['lastname'].'">'.$leavedept['firstname'].' '.$leavedept['lastname'].'</b><span style="display: block;
							font-size: 10px;margin-left: 45px; margin-top: -5px;">'.$leavedept['departmentname'].'</span><span style="display: block;
							font-size: 10px;margin-left: 45px;">'.$leavedept['designationname'].'</span>';
							echo '<td style="width:200px">'.$fullname.'</td>';
							echo '<td>'.$leavedept['leave_type_name'].'</td>';
							echo '<td>'.$leavedept['reason'].'</td>';
							$leave_status = '<span class="bg-danger" style="padding: 5px;
							border-radius: 8px; font-size: 12px">Declined <i class="fa fa-times"></i></span>';
							if ($leavedept['leave_status'] == '1') {
								$leave_status = '<span class="bg-danger" style="padding: 5px;
								border-radius: 8px; font-size: 12px">Pending <i class="fa fa-spinner"></i></span>';

								if ($idnumber !== $leavedept['emp_id']) {
									$approvedenied=$approvedDenied($leavedept['id'],$leavedept['emp_id'],$leavedept['designationID'],$leavedept['designationname'],$leavedept['temp_leave_day'],$leavedept['application_type']);
								} else {
									$leave_remove = '<span style="cursor: pointer ; color: red" onclick="removeLeave('.$leavedept['id'].')"><i   class="fa fa-trash" aria-hidden="true"></i></span>';
								}

							} else if ($leavedept['leave_status'] == '2') {
								$leave_status = '<span class="bg-success" style="padding: 5px;
								border-radius: 8px; font-size: 11px">Approved <i class="fa fa-check"></i></span>';
							}
							echo '<td>'.$leave_status.'</td>';

							echo '<td>'.$leavedept['apply_date'].'</td>';
							echo '<td>'.$leavedept['date_from'].'</td>';

							echo '<td>'.$leavedept['date_to'].'<span style="font-size: small;display: block;color: blue;">'.$leavedept['temp_leave_day'].' day/s leave</span> <span style="font-size: small;display: block;color: blue;">'.$timeout.'</span></td>';
							echo '<td>'.$approverList($leavedept['id']).'</td>';
							echo '<td  style="text-align: right">'.$leaveType.'<br />'.$withoutPay.' '.$attachment.'</td>';
							echo '<td>'.$approvedenied.' '.$leave_remove.'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table></p>
		<?php  } ?>

		<hr />
	<?php if ($designationID == '44' || $designationID == '18') { ?>
	<h1 class="h3 mb-4 text-gray-800">All Department Leave</h1>
	<p><div id="leave">
		<table id="leaveTableDept" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th style="width: 200px !important">NAME</th>
					<th>TYPE</th>
					<th>REASON</th>
					<th style="width:100px">STATUS</th>
					<th>FILED</th>
					<th>FROM</th>
					<th>TO</th>
					<th style="width: 200px !important">APPROVER</th>
					<th>APPLICATION</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$fullname = '';
					foreach ($leaveListDeptAll as $leavedept) {
						$leave_remove = '';
						$approvedenied = '';
						$leaveType = 'Leave';
						$timeout = '';
						$withoutPay = '';
						if ($leavedept['application_type'] == 2) {
							$leaveType = 'Undertime/halfday';
							$timeout = 'Time out: '.$leavedept['undertime'];
						}
						if ($leavedept['application_type'] == 3) {
							$leaveType = 'Halfday';
							$timeout = 'Halfday: '.$leavedept['halfday'];
						}
						echo '<tr>';
						$image_url = site_url('public/img/idpicture/'.$leavedept['emp_id'].'.jpg');
						$image_type_check = @exif_imagetype($image_url);//Get image type + check if exists
						if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
							$empimage = site_url('public/img/idpicture/noimage.jpg');
						} else {
							$empimage = site_url('public/img/idpicture/'.$leavedept['emp_id'].'.jpg');
						}
						$fullname = '<img width="40" class="rounded-circle" src="'.$empimage.'" />
							<b style="font-size: 13px; position: absolute" title="'.$leavedept['firstname'].' '.$leavedept['lastname'].'">'.$leavedept['firstname'].' '.substr($leavedept['lastname'], 0, 7).'</b><span style="display: block;
							font-size: 10px;margin-left: 45px; margin-top: -5px;">'.$leavedept['departmentname'].'</span><span style="display: block;
							font-size: 10px;margin-left: 45px;">'.$leavedept['designationname'].'</span>';
							echo '<td>'.$fullname.'</td>';
							echo '<td>'.$leavedept['leave_type_name'].'</td>';
							echo '<td>'.$leavedept['reason'].'</td>';
							$leave_status = '<span class="bg-danger" style="padding: 5px;
							border-radius: 8px; font-size: 12px">Declined <i class="fa fa-times"></i></span>';
							if ($leavedept['leave_status'] == '1') {
								$leave_status = '<span class="bg-warning" style="padding: 5px;
								border-radius: 8px; font-size: 12px">Pending <i class="fa fa-spinner"></i></span>';

								if ($idnumber !== $leavedept['emp_id']) {
									$approvedenied=$approvedDenied($leavedept['id'],$leavedept['emp_id'],$leavedept['designationID'],$leavedept['designationname']);
								} else {
									$leave_remove = '<span style="cursor: pointer ; color: red" onclick="removeLeave('.$leavedept['id'].')"><i   class="fa fa-trash" aria-hidden="true"></i></span>';
								}

							} else if ($leavedept['leave_status'] == '2') {
								$leave_status = '<span class="bg-success" style="padding: 5px;
								border-radius: 8px; font-size: 11px">Approved <i class="fa fa-check"></i></span>';
							}
							echo '<td>'.$leave_status.'</td>';

							$date1 = new DateTime($leavedept['date_from']);
							$date2 = new DateTime(date('Y-m-d H:i:s', strtotime($leavedept['date_to'] . ' +1 day')));
							$interval = $date1->diff($date2);

							echo '<td>
								'.$leavedept['apply_date'].'
								<span style="font-size: small;display: block;color: blue;">'.$interval->days.' day/s leave</span>
							</td>';
							echo '<td>'.$leavedept['date_from'].'</td>';

							echo '<td>'.$leavedept['date_to'].' <span style="font-size: small;display: block;color: blue;">'.$timeout.'</span></td>';
							echo '<td>'.$approverList($leavedept['id']).'</td>';
							echo '<td>'.$leaveType.'<br />'.$withoutPay.'</td>';
							echo '<td>'.$approvedenied.' '.$leave_remove.'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table></p>
		<?php  } ?>
		
		<!-- Modal -->
		<!-- File leave tabindex="-1" -->
		<div class="modal fade" id="applyLeaveModal" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Apply Leave</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<label for="refnum" class="col-sm-6 col-form-label">Apply Type</label>
							<div class="col-sm-12">
								<select class="form-select" id='applytype' aria-label="applytype">
									<option value="1">Leave</option>
									<option value="2">Undertime</option>
									<option value="3">Halfday</option>
								</select>
							</div>
						</div>
					</div>
					<form id="frmleave" method="post" enctype="multipart/form-data">
						<input type="hidden" class="form-control"  id="date_filed" name='date_filed'>	
						<input type="hidden" class="form-control"  id="emp_id" name='emp_id' value="<?=$idnumber?>">
						<input type="hidden" class="form-control"  id="posi_type" name='posi_type' value="<?=$posi_type?>">
						<input type="hidden" class="form-control"  id="deep_type" name='deep_type' value="<?=$deep_type?>">
						<input type="hidden" class="form-control"  id="designationID" name='designationID' value="<?=$designationID?>">
						<input type="hidden" class="form-control"  id="designation" name='designation' value="<?=$designation?>">
						<input type="hidden" id="dWithoutPay" name='dWithoutPay'>
						<input type="hidden" id="tempLeaveDay" name='tempLeaveDay'>
						<div class="row">
							<div class="col-md-6">
								<label for="refnum" class="col-sm-6 col-form-label">Date From</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="datefrom" name='datefrom'>
									<span style="margin-left: 12px;font-size: 12px;">Leave left: <?php echo $leaveinfo[0]['leave_left']?></span>
								</div>
							</div>
							<div class="col-md-6">
								<label for="refnum" class="col-sm-6 col-form-label">Date To</label>
								<div class="col-sm-12">
									<input type="text" class="form-control"  id="dateto" name='dateto'>
									<input type="hidden" class="form-control"  id="nofdayleave" name='nofdayleave'>
								</div>
								<span style="margin-left: 12px;font-size: 12px;">No. of Leave/s: <label id="ldayleave"></label></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="col-sm-12">
									<span id="dtwoutp" style="display: none">
										<select id="dayswithoutpay" name="date_range" class="form-control"></select>
									</span>
								</div>
							</div>
						</div>
						<div class="row" style='margin-bottom: 10px;'>
							<div class="col-md-12">
								<label for="refnum" class="col-sm-6 col-form-label">Leave Type</label>
								<div class="col-sm-12">
									<?php
										$datenow = date("m-d");
										$bdate = explode('-',$birthdate)[1].'-'.explode('-',$birthdate)[2];
										$Mnow = explode('-',date("m-d"))[0];
										$Bmonth = explode('-',$birthdate)[1];
										$Bday = explode('-',$birthdate)[2];
										$Mday = explode('-',date("m-d"))[1];
										$bday = 0;
										if ($Bmonth > $Mnow) {
											$bday = 1;
										} else if ($Bmonth == $Mnow) 	{
											if ($Bday > $Mday) {
												$bday = 1;
											} else if ($Bday == $Mday) {
												$bday = 1;
												echo 'Your birthday today.';
											}
										}
										echo '<input type="hidden" id="birthdate" value="'.date('M j', strtotime($birthdate)).' '.date('Y').'" />';
										echo '<select class="form-control" id="leavetype" name="leavetype">
													<option value=""></option>';
													unset($leavetypes[6]);
													if ($bday == 0) {
														unset($leavetypes[5]);
													}
													foreach($leavetypes as $leave) {
														echo '<option value="'.$leave['type_id'].'">';
														echo $leave['name'];
														echo '</option>';
													}
										echo '</select>'; 
									?>
								</div>
								<div id="attachment" style="padding:8px; display:none">
									<label for="refnum" class="col-sm-6 col-form-label">Attachment(Optional)</label>
									<input id="attachment_file" name="attachment_file" type="file" accept="image/*" class="form-control" name="image" onchange="loadFile(event)"/>
									<div class="img-wrap" id="attachmentWrap">
										<i class="delete_image close" id="deleteImage" style="display: none">&times;</i>
										<img alt="" id="output" style="width: 50%;margin-left: 20%;padding: 10px;">
									</div>
								</div>
								<div id="maternityLeave" class="col-sm-12 alert alert-warning" style="display: none">
									Republic Act No. 11210: An Act Increasing the Maternity Leave Period to One Hundred <b>Five (105) Days</b> for Female Workers with an Option to Extend for an Additional Thirty (30) Days Without Pay, and Granting an Additional Fifteen (15) Days for Solo Mothers, and for Other Purposes.
								</div>
								<div id="paternalLeave" class="col-sm-12 alert alert-warning" style="display: none">
									Under RA 8187, male private and government employees in the Philippines are entitled to <b>seven (7) days </b> of paternity leave with full pay. They should receive their basic salary, allowances, and other monetary benefits for those days.
								</div>
							</div>
							<div class="col-md-12">
								<label class="col-sm-6 col-form-label">Reason</label>
								<div class="col-sm-12">
									<textarea class="form-control" id="Reason" name="Reason" rows="3"></textarea>
									<span id="eventText" style="font-size: 13px"></span>
								</div>
							</div>
						</div> 
						<div class="row" id="successAlertStat"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
						</div>
					</form>

					<form id="undertime">
						<div class="row">
							<input type="hidden" class="form-control"  id="undate_filed" name='undate_filed'>
							<input type="hidden" class="form-control"  id="emp_id" name='emp_id' value="<?=$idnumber?>">
							<input type="hidden" class="form-control"  id="posi_type" name='posi_type' value="<?=$posi_type?>">
							<input type="hidden" class="form-control"  id="deep_type" name='deep_type' value="<?=$deep_type?>">
							<input type="hidden" class="form-control"  id="designationID" name='designationID' value="<?=$designationID?>">
							<input type="hidden" class="form-control"  id="unleavetype" name='unleavetype' value="12">
							<div class="col-md-12">
								<label for="refnum" class="col-sm-6 col-form-label">Undertime Date</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="undatefrom" name='undatefrom'>
								</div>
							</div>
							<div class="col-md-12">
								<label for="refnum" class="col-sm-6 col-form-label">Time Out</label>
								<div class="col-sm-12">
									<!-- <input name="under_time_out" id="under_time_out" class="form-control"> -->
									<?php
										date_default_timezone_set('Asia/Manila');
										$start = "10:00";//date('H:i'); //you can write here 00:00:00 but not need to it
										$end = "15:00";

										$tStart = strtotime($start);
										$tEnd = strtotime($end);
										$tNow = $tStart;
										echo '<select name="under_time_out" id="under_time_out" class="form-control">';
										while($tNow <= $tEnd){
											echo '<option value="'.date("H:i a",$tNow).'">'.date("H:i a",$tNow).'</option>';
											$tNow = strtotime('+30 minutes',$tNow);
										}
										echo '</select>';
									?>
									<!-- <span style="font-size: 12px; display: block">Time: <span id="timeDiff"></span></span> -->
								</div>
							</div>
						</div>
						<div class="row" style='margin-bottom: 10px'>
							<!-- <div class="col-md-6">
								<label for="refnum" class="col-sm-6 col-form-label">Leave Type</label>
								<div class="col-sm-12">
									<?php
										echo '<select class="form-control" id="unleavetype" name="unleavetype" readonly><option value="12" selected>Undertime</option>';
										echo '</select>'; 
									?>
								</div>
							</div> -->
							<div class="col-md-12">
								<label class="col-sm-6 col-form-label">Reason</label>
								<div class="col-sm-12">
									<textarea class="form-control" id="under_Reason" name="under_Reason" rows="3"></textarea>
									<span id="under_eventText"></span>
								</div>
							</div>
						</div> 
						<div class="row" id="successAlertStat"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>

					<form id="halfday">
						<div class="row">
							<input type="hidden" class="form-control"  id="halfdate_filed" name='halfdate_filed'>
							<input type="hidden" class="form-control"  id="emp_id" name='emp_id' value="<?=$idnumber?>">
							<input type="hidden" class="form-control"  id="posi_type" name='posi_type' value="<?=$posi_type?>">
							<input type="hidden" class="form-control"  id="deep_type" name='deep_type' value="<?=$deep_type?>">
							<input type="hidden" class="form-control"  id="designationID" name='designationID' value="<?=$designationID?>">
							<input type="hidden" class="form-control"  id="halfleavetype" name='halfleavetype' value="12">
							<div class="col-md-6">
								<label for="refnum" class="col-sm-12 col-form-label">Halfday Date</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="halfdatefrom" name='halfdatefrom'>
								</div>
							</div>
							<div class="col-md-6">
								<label for="refnum" class="col-sm-6 col-form-label">Time of the day</label>
								<div class="col-sm-12">
									<select class="form-select" id='halfdaytype' name="halfdaytype" aria-label="halfdaytype">
										<option value="Morning">Morning</option>
										<option value="Afternoon">Afternoon</option>
										<option value="Evening">Evening</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style='margin-bottom: 10px'>
							<div class="col-md-12">
								<label class="col-sm-6 col-form-label">Reason</label>
								<div class="col-sm-12">
									<textarea class="form-control" id="half_Reason" name="half_Reason" rows="3"></textarea>
									<span id="half_eventText"></span>
								</div>
							</div>
						</div> 
						<div class="row" id="successAlertStat"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>

				</div>
			</div>
		</div>
		<!-- disclaimerModal -->
		<div class="modal" id="disclaimerModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 80px">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">DISCLAIMER</h5>
					</div>

					<div class="modal-body">
						<p style="text-transform: uppercase; text-align: justify">This application does not guarantee automatic approval. Your leave is considered valid once all signatories signify approval.</p>
					</div>
					<div class="modal-footer">
						<button type="button" id="disclaimerSubmit" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
					</div>
					<!-- </div> -->
				</div>
			</div>
		</div>
</div>
<!-- CREDIT INFO MODAL -->
<div class="modal fade" id="creditModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Credit Info</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div>
						<table id="<?=($designationID == '44')? 'leavecredit': 'leavecredit2'?>" class="table table-striped" style="width:100%;">
							<thead>
								<tr>
									<th style="width: 200px !important">NAME</th>
									<th>ADDT'L</th>
									<th>TOTAL</th>
									<th>USED</th>
									<th>LEFT</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$fullname = '';
									$a = $leaveCreditList;
									foreach ($leaveCreditList as $credit) {
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
											<b style="font-size: 13px; position: absolute" title="'.$credit['firstname'].' '.$credit['lastname'].'">'.$credit['firstname'].' '.substr($credit['lastname'], 0, 7).'</b><span style="display: block;font-size: 10px;margin-left: 45px; margin-top: -5px;">'.$credit['departmentname'].'</span><span style="display: block;
											font-size: 10px;margin-left: 45px;">'.$credit['designationname'].'<br>Hired: '.$credit['date_hired'].'</span>';
											echo '<td>'.$fullname.'</td>';
											
											echo '<td>'.$creditAdditional($credit['date_hired']).'</td>';
											echo '<td>'.$leaveTotal($credit['date_hired']).'</td>';
											echo '<td>'.$credit['leave_used'].'</td>';
											echo '<td>'.$leaveLeft($credit['date_hired'],$credit['leave_used']).'</td>';
										echo '</tr>';
										}
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="confirmStatus" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Confirm Leave ?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" id="leaveID">
						<input type="hidden" id="approveCancel">
						<input type="hidden" id="empID">
						<input type="hidden" id="designation">
						<input type="hidden" id="templeaveday">
						<input type="hidden" id="applictype">
						Are you sure you want to <span id="lblConfirm"></span> this leave.
						<textarea id="rejectReason" class="form-control" style="display: none;
						width: 268px;
						height: 175px;
						margin-top: 6px;" placeholder="REASON"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="confirmLeaved" onclick="confirmLeaveSubmit()">Submit</button>
			</div>
		</div>
	</div>

<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/leave.js'); ?>"></script>
<script src="<?=site_url('public/plugins/simplelightbox-master')?>/dist/simple-lightbox.js?v2.8.0"></script>
<script type="text/javascript"
   src="https://cdn.jsdelivr.net/npm/emailjs-com@2.4.0/dist/email.min.js">
</script>
<script>
    (function() {
        var $gallery = new SimpleLightbox('.gallery a', {});
    })();
</script>
<script>

    var selectedValuesTest = [];
    $(document).ready(function() {
        $("#dayswithoutpay").select2({
			multiple: true,
			dropdownParent: $("#applyLeaveModal"),
			allowClear: true,
			placeholder: "Optional: Day/s without pay",
			width: '100%' 
		});
		$('#dayswithoutpay').select2('val', selectedValuesTest);
    });
	

	// LoadImage
	function loadFile (event) {
		var output = document.getElementById('output');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
			URL.revokeObjectURL(output.src) // free memory
		}
		var reader = new FileReader();
		reader.readAsDataURL(event.target.files[0]); 
		reader.onloadend = function() {
			var base64data = reader.result;                
			// console.log(base64data);
			$("#attachment_encode").val(base64data);
			return;
		}
		$("#deleteImage").removeAttr('style');
	}

</script> 
