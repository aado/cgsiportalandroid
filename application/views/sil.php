<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<div class="masterlist">
		<div class="loading">Loading...</div>
		<div class="masterlistTable" style="display: none">
			<div class="row" id="rtadateRange">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Hired From" id="min" name="min">
					<input type="text" class="form-control" placeholder="Hired To" id="max" name="max">
				</div>
			</div>
			<table id="SIL" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Company Name</th>
						<th>Company ID</th>
						<th>Ref Number</th>
						<th>Full Name</th>
						<th>Date Hired</th>
						<th>Status</th>
						<th>Duration</th>
						<th>SIL</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$ctr = 0;
						foreach ($masterlist as $mstr_list) {
							$string = explode(' ',explode('-',$mstr_list['Comp_Name'])[0]);
							$i=0;
							while($i<count($string)){
								$string[$i] = mb_substr($string[$i], 0, 1);
								$i++;
							}
							echo '<tr>';
								echo '<td style="font-size: 11px">'.$mstr_list['Comp_Name'].'</td>';
								echo '<td>'.$mstr_list['Company_ID'].'</td>';
								echo '<td>'.$mstr_list['Emp_RefNum'].'</td>';
								echo '<td>'.utf8_encode($mstr_list['Emp_LName']).', '.utf8_encode($mstr_list['Emp_FName']).' '.utf8_encode($mstr_list['Emp_MName']).'</td>';
								echo '<td>'.$mstr_list['Date_Hired'].'</td>';
								$color = '';
								if ($mstr_list['Status'] == 'Maternity' || $mstr_list['Status'] == 'Force Leave') {
									$color = 'blue';
								}
								echo '<td style="color:'.$color.'; font-size:11px">'.strtoupper($mstr_list['Status']).'</td>';
								
								echo '<td>'.$mstr_list['Duration'].'</td>';
								if ($mstr_list['Duration'] < 1) {
									$leave = 0;
								} else {
									$leave = 5;
								}
								echo '<td>'.$leave.'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" width="100%">
			<div class="modal-dialog" role="document" style="margin-top: 60px;">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update Employee Info</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="updateInfo">
						<input type="hidden" id="Applicant_ID">
						<div class="form-group row">
							<label for="refnum" class="col-sm-4 col-form-label">Reference Number</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="Reference_Number" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="refnum" class="col-sm-4 col-form-label">Company ID</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="Company_ID" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="refnum" class="col-sm-4 col-form-label">Contact Number</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="Contact_Number"  name="Contact_Number" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="refnum" class="col-sm-4 col-form-label">Address</label>
							<div class="col-sm-8">
							<textarea class="form-control" id="Address" rows="3" name="Address"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="refnum" class="col-sm-4 col-form-label">Contact Person</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="Contact_Person" name="Contact_Person" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="refnum" class="col-sm-4 col-form-label">Contact Person's Number</label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="Contact_Person_Number" name="Contact_Person_Number">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="row" id="successAlert"></div>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" >Submit</button>
					</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Update Status -->
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
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Employment Status</label>
							<div class="col-sm-12">
							 	<?php
									echo '<select class="form-control" id="Employment_Status" name="Employment_Status"><option value=""> Select Status </option>';
									foreach($status as $stat) {
										echo '<option value="'.$stat['status_name'] .'">';
										echo $stat['status_name'];
										echo '</option>';
									}
									echo '</select>'; 
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-sm-6 col-form-label">Reason</label>
							<div class="col-sm-12">
								<textarea class="form-control" id="Reason" name="Reason" rows="2"></textarea>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							<label class="col-sm-6 col-form-label" id="lastPay">Last Payroll</label>
							<div class="col-sm-12">
							<input type="date" class="form-control" name="Last_Pay" id="Last_Pay">
							</div>
						</div>
						<div class="col-md-6" id="effectDate">
							<label class="col-sm-6 col-form-label">Effective Date</label>
							<div class="col-sm-12">
							<input type="Date" class="form-control" name="Effective_Date" id="Effective_Date">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8">
							<label class="col-sm-4 col-form-label">Other Info</label>
							<div class="col-sm-12">
								<textarea class="form-control" id="Other_Info" name="Other_Info" rows="2"></textarea>
							</div>
						</div>
					</div>
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
<script src="<?= site_url('public/js/masterlist.js'); ?>"></script>
