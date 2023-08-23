<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<div class="masterlist"  style="margin-top: 50px">
		<div class="loading">Loading...</div>
		<div class="masterlistTable" style="display: none">
			<div class="row" id="rtadateRange">
				<div class="input-group">
					<!-- <div class="input-group-prepend">
						<span class="input-group-text" id="">From and To</span>
					</div> -->
					<input type="text" placeholder="Date End From" class="form-control" id="min" name="min">
					<input type="text" placeholder="Date End To"  class="form-control" id="max" name="max">
				</div>
			</div>
			<div>
			</div>
			<table id="RTAInactive" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Company Assigned</th>
						<th>Reference Number</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Employee Status</th>
						<th>Date End</th>
						<th>Clearance Date</th>
						 <th>Date Prepared</th>
						<th>Contact Number</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($tortain as $rta_list) {
							$prepdate = "";
							if (json_encode($rta_list['Date_Prepared']) != 'null') {
								$prepdate = $rta_list['Date_Prepared']->format('m/d/Y 12:00:00 A');
							}
							echo '<tr>';
								echo '<td  style="font-size: 12px">'.$rta_list['Company_Assigned'].'</td>';
								echo '<td>'.$rta_list['Emp_RefNum'].'</td>';
								echo '<td>'.utf8_encode($rta_list['LastName']).'</td>';
								echo '<td>'.utf8_encode($rta_list['FirstName']).'</td>';
								echo '<td>'.utf8_encode($rta_list['MiddleName']).'</td>';
								echo '<td>'.$rta_list['EmpStatus'].'</td>';
								echo '<td>'.$rta_list['Date_End'].'</td>';
								echo '<td>'.$rta_list['Clearance_Date'].'</td>';
								echo '<td>'.$prepdate.'</td>';
								echo '<td>'.$rta_list['Contact#'].'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
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
							<input type="text" class="form-control" id="Contact_Number"  name="Contact_Number">
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
							<input type="text" class="form-control" id="Contact_Person" name="Contact_Person">
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
			<div class="modal-dialog modal-lg" role="document">
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
							<div class="col-sm-10">
								<input type="text" class="form-control" name="SReference_Number" id="SReference_Number" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Company ID</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="SCompany_ID" id="SCompany_ID" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Name</label>
							<div class="col-sm-10">
							<input type="text" class="form-control" id="Name" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Date Hired</label>
							<div class="col-sm-10">
							<input type="text" class="form-control" id="Date_Hired" readonly>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							<label for="refnum" class="col-sm-6 col-form-label">Employment Status</label>
							<div class="col-sm-10">
							 	<?php
									echo '<select class="form-control" id="Employment_Status" name="Employment_Status"><option value=""></option>';
									foreach($status as $stat) {
										echo '<option value="'.$stat .'">';
										echo $stat;
										echo '</option>';
									}
									echo '</select>'; 
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-sm-6 col-form-label">Reason</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="Reason" name="Reason" rows="3"></textarea>
							</div>
						</div>
					</div>
					<div class="form-group row">
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
								<textarea class="form-control" id="Other_Info" name="Other_Info" rows="3"></textarea>
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
