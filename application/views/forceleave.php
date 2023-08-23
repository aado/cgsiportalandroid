<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<div class="masterlist"  style="margin-top: 50px">
		<div class="loading">Loading...</div>
		<div class="masterlistTable" style="display: none">
			<table id="forceleave" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th></th>
						<!-- <th>RTA Status</th> -->
						<th>Employment Status</th>
						<th>Reference Number</th>
						<th>Company ID</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Company Name</th>
						<th>Date Hired</th>
						<th>Reason</th>
						<th>Start Date</th>
						<!-- <th>End Date</th> -->
						<th>Other Info</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($torta as $rta_list) {
							echo '<tr>';
								echo '<td style="width: 65px !important"><button class="status" title="Update Status" style="background: transparent;border: 0px;" data-toggle="modal" data-target="#statusModal"><i class="fa fa-flag" style="color: #cd9256")"></i></button></td>';
								echo '<td>'.$rta_list['Category'].'</td>';
								echo '<td>'.$rta_list['Emp_Refnum'].'</td>';
								echo '<td>'.$rta_list['Company_ID'].'</td>';
								echo '<td>'.utf8_encode($rta_list['Emp_LName']).'</td>';
								echo '<td>'.utf8_encode($rta_list['Emp_FName']).'</td>';
								echo '<td>'.utf8_encode($rta_list['Emp_MName']).'</td>';
								echo '<td  style="font-size: 12px">'.$rta_list['Comp_Name'].'</td>';
								echo '<td>'.$rta_list['DateHired'].'</td>';
								echo '<td>'.$rta_list['Reason'].'</td>';
								$jsonDateTime = json_encode($rta_list['M_F_StartDate']);
								$start_date = trim(explode(' ',$jsonDateTime)[0],' {"date":"');
								$startDate = '';
								if ($start_date !== 'null') {
									$date=date_create($start_date);
									$startDate = date_format($date,"m/d/Y");
								}
								echo '<td>'.$startDate.'</td>';
								echo '<td>'.$rta_list['OtherInfo'].'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>

		<!-- Update Status Modal-->
		<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" style="margin-top: 60px;" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="updateStatus">
					<input type="hidden" id="SVIncharge" value="<?=utf8_encode($user['Fullname']) ?>">
					<input type="hidden" id="SVICompany">
					<div class="row">
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Reference Number</label>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="SReference_Number" id="SReference_Number" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Company ID</label>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="SCompany_ID" id="SCompany_ID" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Name</label>
							<div class="col-sm-12">
							<input type="text" class="form-control" id="Name" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Date Hired</label>
							<div class="col-sm-12">
							<input type="text" class="form-control" id="Date_Hired" readonly>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-12">
							<label for="refnum" class="col-sm-6 col-form-label">Employment Status</label>
							<div class="col-sm-12">
							 	<?php
									echo '<select class="form-control" id="Employment_Status" name="Employment_Status"><option value=""></option>';
									foreach($status as $stat) {
										if ( $stat == 'EOC' || $stat == 'Active') {
											echo '<option value="'.$stat .'">';
											echo $stat;
											echo '</option>';
										}
									}
									echo '</select>'; 
								?>
							</div>
						</div>
						<!-- <div class="col-md-6">
							<label class="col-sm-6 col-form-label">Reason</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="Reason" name="Reason" rows="2"></textarea>
							</div>
						</div> -->
					</div>
					<!-- <div class="form-group row">
						<div class="col-md-6">
							<label class="col-sm-6 col-form-label">Last Pay</label>
							<div class="col-sm-10">
							<input type="date" class="form-control" name="Last_Pay" id="Last_Pay">
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-sm-6 col-form-label">Effective Date</label>
							<div class="col-sm-10">
							<input type="Date" class="form-control" name="Effective_Date" id="Effective_Date">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8">
							<label class="col-sm-4 col-form-label">Other Info</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="Other_Info" name="Other_Info" rows="2"></textarea>
							</div>
						</div>
					</div> -->
					<div class="row" id="successAlertStat"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
