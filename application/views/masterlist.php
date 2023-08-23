<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<!-- style="margin-top: 50px" -->
	<div class="masterlist">
		<div class="loading">Loading...</div>
		<div class="masterlistTable" style="display: none">
			<div class="row" id="rtadateRange">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Hired From" id="min" name="min">
					<input type="text" class="form-control" placeholder="Hired To" id="max" name="max">
				</div>
			</div>
			<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th style="width: 100px !important">Action</th>
						<th>Company Name</th>
						<th>Department</th>
						<th>Company ID</th>
						<th>Ref#</th>
						<th>Lastname</th>
						<th>Firstname</th>
						<th>Middlename</th>
						<th>Date Hired</th>
						<th>Contact#</th>
						<th>Address</th>
						<th></th>
						<th>Status</th>
						<th>Service</th>
						<th>Gender</th>
						<th>DOB</th>
						<th>Email</th>
						<th>Birth Place</th>
						<th>Civil Status</th>
						<th>SSS#</th>
						<th>TIN#</th>
						<th>PAG-IBIG#</th>
						<th>Philhealth#</th>
						<th>Designation</th>
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
							// print_r($string);
							echo '<tr>';
								echo '<td style="width: 65px !important"><span id="nameDetails"><span style="font-size: 10px;opacity: .5;font-weight: bold;">ComID: '.$mstr_list['Company_ID'].'<br/>RefID: '.$mstr_list['Emp_RefNum'].'</span><span> '.utf8_encode($mstr_list['Emp_LName']).', '.utf8_encode($mstr_list['Emp_FName']).' '.utf8_encode($mstr_list['Emp_MName']).'</span></span><button class="edit" title="Update Info" style="background: transparent;border: 0px;" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit" style="color: #8a8ad7")"></i></button></td>';
								// <button class="status" title="Update Status" style="background: transparent;border: 0px;" data-toggle="modal" data-target="#statusModal"><i class="fa fa-flag" style="color: #cd9256")"></i></button>
								echo '<td style="font-weight: bold">'.$mstr_list['Comp_Name'].'</td>';
								echo '<td style="font-weight: bold;">'.$mstr_list['Department'].'</td>';
								// echo '<td  style="font-weight: bold">'.implode("",$string).'-'.explode('-',$mstr_list['Comp_Name'])[1].'</td>';
								echo '<td>'.$mstr_list['Company_ID'].'</td>';
								echo '<td>'.$mstr_list['Emp_RefNum'].'</td>';
								echo '<td>'.utf8_encode($mstr_list['Emp_LName']).'</td>';
								echo '<td>'.utf8_encode($mstr_list['Emp_FName']).'</td>';
								echo '<td>'.utf8_encode($mstr_list['Emp_MName']).'</td>';
								echo '<td>'.$mstr_list['Date_Hired'].'</td>';
								echo '<td>'.$mstr_list['Contact_Num1'].'</td>';
								echo '<td>'.utf8_encode($mstr_list['Address_1']).'</td>';
								echo '<td>'.$mstr_list['Applicant_ID'].'</td>';
								$color = '';
								if ($mstr_list['Status'] == 'Maternity' || $mstr_list['Status'] == 'Force Leave') {
									$color = 'blue';
								}
								echo '<td style="color:'.$color.'">'.$mstr_list['Status'].'</td>';
								echo '<td>'.$mstr_list['Duration'].'</td>';
								echo '<td>'.$mstr_list['Gender'].'</td>';
								$dob = $mstr_list['DoB']->format('m/d/Y');
								echo '<td>'.$dob.'</td>';
								echo '<td>'.$mstr_list['Email_Address'].'</td>';
								echo '<td>'.utf8_encode($mstr_list['Birth_Place']).'</td>';
								echo '<td>'.$mstr_list['Civil_Status'].'</td>';
								// echo '<td>'.$mstr_list['Address_1'].'</td>';
								// echo '<td>'.$mstr_list['Contact_Num1'].'</td>';
								echo '<td>'.$mstr_list['SSS_Num'].'</td>';
								echo '<td>'.$mstr_list['Tin_Num'].'</td>';
								echo '<td>'.$mstr_list['Pagibig_Num'].'</td>';
								echo '<td>'.$mstr_list['Philhealth_Num'].'</td>';
								echo '<td>'.$mstr_list['Designation'].'</td>';
								// echo '<td>'.$mstr_list['RateType'].'</td>';
								// echo '<td>'.$mstr_list['Rate'].'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" width="100%">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">EMPLOYEE INFORMATION</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div style="margin-bottom: 16px;">
							<span>
								<img class="img-profile rounded-circle" style="width:115px; float: left; height: 115px" src="<?= site_url('public/img/avatar.jpg'); ?>" id="applicantImage">
							</span>
							<span id="empName" style="color: #3498db;font-family: arial;font-weight: bold; font-size: 24px;"></span>
							<span id="empCompany" style="color: #6c757d;font-family: arial;font-weight: bold; font-size: 12px; display: block"></span>
							<span style="font-family: arial;font-weight: bold;font-size: 12px;display: block;opacity: .5;">Department: <span id="textDept">Not yet assign</span></span>
							<span style="font-family: arial;font-weight: bold;font-size: 12px;display: block;opacity: .5;">Reference ID: <span id="textRef"></span></span>
							<span style="font-family: arial;font-weight: bold;font-size: 12px;display: block;opacity: .5;margin-left: 115px">Company ID: <span id="textCompID"></span></span>
							<span style="font-family: arial;font-weight: bold;font-size: 12px;display: block;opacity: .5;margin-left: 115px">Date Hired: <span id="textDhired"></span></span>
						</div>

						<ul class="nav nav-tabs" id="updateInfoTab">
							<li class="nav-item nav-link active"><a data-toggle="tab" href="#update_info">Add Records</a></li>
							<li class="nav-item nav-link"><a data-toggle="tab" href="#update_status">History</a></li>
							<!-- <li class="nav-item nav-link"><a data-toggle="tab" href="#assign_department">Assign Department</a></li> -->
						</ul>
						<div class="tab-content">
							<div id="update_info" class="tab-pane fade in active" style="margin-top: 15px;">
								<form id="updateInfo">
									<div>
										<input type="hidden" id="Applicant_ID">
										<input type="hidden" class="form-control" id="Reference_Number">
										<input type="hidden" class="form-control" id="Company_ID">
										<div class="form-group row">
											<label for="refnum" class="col-sm-4 col-form-label">Reason For Visit</label>
											<div class="col-sm-8">
												<select name="reasonforvisit" id="reasonforvisit" class="form-control">
													<option value="">Select</option>
													<option value="">Ask Medecine</option>
													<option value="">Consultation</option>
													<option value="">MedCert Validation</option>
													<option value="">Request MedCert</option>
													<option value="">Borrow Item</option>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label for="refnum" class="col-sm-4 col-form-label">Diagnosis</label>
											<div class="col-sm-8">
												<select name="reasonforvisit" id="reasonforvisit" class="form-control">
													<option value="">Diagnosis</option>
													<option value="">Fever</option>
													<option value="">Headache</option>
													<option value="">Body Pain</option>
												</select>
											</div>
										</div>
										
										<div class="form-group row">
											<label for="refnum" class="col-sm-4 col-form-label">Remarks</label>
											<div class="col-sm-8">
											<textarea class="form-control" id="Remarks" rows="2" name="Remarks"></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label for="refnum" class="col-sm-4 col-form-label">Medicine</label>
											<div class="col-sm-8">
											<?php
												echo '<select class="form-control" id="Department" name="Department"><option value=""> Select Medicine </option>';
												foreach($department as $dept) {
													if($dept =='') {
													} else {
														echo '<option value="'.strtoupper($dept).'">';
														echo strtoupper($dept);
														echo '</option>';
													}
												}	
												echo '</select>'; 
											?>
											</div>
										</div>
										<div class="form-group row">
											<label for="refnum" class="col-sm-4 col-form-label">Quantity</label>
											<div class="col-sm-8">
											<input type="text" class="form-control" id="Quantity" name="Quantity" required>
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
							<div id="assign_department" class="tab-pane fade" style="margin-top: 15px;">
								<form id="assignDepartment">
									<input type="hidden" class="form-control" id="Reference_Number">
									<input type="hidden" class="form-control" id="Company_ID">
									<div class="form-group row" style="display: none" id="showDepartment">
										<label for="ndept" class="col-sm-4 col-form-label">New Department</label>
										<div class="col-sm-8">
											<input type="text" style="margin-left:-10px; width: 468px;" class="form-control" id="new_department" name="new_department" placeholder="Input new department">
											<div class="btn btn-primary" id="saveDepartment" style="position: absolute;right: 6px;margin-top: -40px;"><i title="Save" class="fa fa-check" aria-hidden="true"></i></div>
										</div>
									</div>
									<div class="form-group row" style="float: right">
										<div class="col-sm-8">
											<div class="btn btn-primary" id="addDepartment"><i title="Add new department" class="fa fa-plus" aria-hidden="true"></i></div>
										</div>
									</div>
									<div class="form-group row">
										<label for="department" class="col-sm-4 col-form-label">Department</label>
										<div class="col-sm-8">
										<?php
											echo '<select class="form-control" id="Department" name="Department"><option value=""> Select Department </option>';
											foreach($department as $dept) {
												if($dept =='') {
												} else {
													echo '<option value="'.strtoupper($dept).'">';
													echo strtoupper($dept);
													echo '</option>';
												}
											}	
											echo '</select>'; 
										?>
										</div>
									</div>
									<div class="modal-footer">
										<div class="row" id="successAlert"></div>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary" >Submit</button>
									</div>
								</form>
							</div>
							<div id="update_status" class="tab-pane fade" style="margin-top: 15px;">
									<!-- Medical records history -->
									<div class="masterlistTable" style="display: none">
										<table id="toRTA" class="table table-striped table-bordered" style="width:100%">
											<thead>
												<tr>
													<th></th>
													<th>Medicine Name</th>
													<th>Quantity</th>
													<th>Remarks</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>
												<?php
													// foreach ($torta as $rta_list) {
													// 	echo '<tr>';
													// 		echo '<td><button class="status" title="Update Status" style="background: transparent;border: 0px;" data-toggle="modal" data-target="#statusModal"><i class="fa fa-flag" style="color: #cd9256")"></i></button></td>';
													// 		echo '<td  style="font-size: 12px">'.$rta_list['Comp_Name'].'</td>';
													// 		echo '<td>'.$rta_list['RTA_Status'].'<span id="nameDetails"><span style="font-size: 10px;opacity: .5;font-weight: bold; display: block">ER: '.$rta_list['Emp_Refnum'].' <br/> CI: '.$rta_list['Company_ID'].'</span>'.utf8_encode($rta_list['Emp_LName']).', '.utf8_encode($rta_list['Emp_FName']).' '.utf8_encode($rta_list['Emp_MName']).'</span></td>';
													// 		echo '<td>'.$rta_list['Emp_Refnum'].'</td>';
													// 	echo '</tr>';
													// }
												?>
											</tbody>
										</table>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
<script src="<?= site_url('public/js/masterlist.js'); ?>"></script>
