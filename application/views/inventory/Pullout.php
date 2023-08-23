<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<?php if($this->session->add_message){ ?>
		<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration: none">&times;</a>
			<strong>Success!</strong> Successfully pull out item.
		</div>
	<?php } ?>
	<!-- /.start of PULLOUT CONTENT-->
	<div id="pullout" class="tabcontent">
		<br>
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active"  id="nav-pulledout-tab" data-toggle="tab" href="#nav-pulledout" role="tab" aria-controls="nav-pulledout" aria-selected="true">
						PULLED OUT
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  id="nav-pullouthistory-tab" data-toggle="tab" href="#nav-pullouthistory" role="tab" aria-controls="nav-pullouthistory" aria-selected="false">
					HISTORY
				</a>
			</li>
		</ul>
		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-pulledout" role="tabpanel" aria-labelledby="nav-pulledout-tab">
					<br>
					<p><a class="btn btn-info" data-toggle="collapse" href="#collapse_pullout" role="button" aria-expanded="false" aria-controls="collapse_pullout">
						ADD ITEMS
					</a>
				</p>
				<div class="collapse" id="collapse_pullout">
					<div class="card card-body">
						<form action="addpullout.php" method="POST">
							<div class="row">
								<div class="col">
										<div class="form-group">
											<input type="text" name="add_pulloutNo" class="form-control form-control-sm" placeholder="PO Number">
										</div>
										<div class="form-group">
										<?php
											echo '<select id="add_to" name="add_to"><option value=""> SELECT NAME </option>';
											foreach($EmployeeList as $emp) {
												echo '<option value="'.$emp['UserID'].'">';
												echo strtoupper($emp['Name']);
												echo '</option>';
											}	
											echo '</select>'; 
										?>
										</div>
										<div class="form-group">
											<!-- <?php
											echo '<select id="add_Departmentsection" name="add_Departmentsection"><option value=""> SELECT DEPARTMENT </option>';
											foreach($departmentlist as $dept) {
												echo '<option value="'.$dept['departmentid'].'">';
												echo strtoupper($dept['departmentname']);
												echo '</option>';
											}	
											echo '</select>'; 
										?> 
			 								<select class="form-select form-control form-select-sm " aria-label=".form-select-sm example" name="add_Departmentsection" >
												<option selected> SELECT DEPARTMENT </option>
												<option value="HR">HR DEPARTMENT</option>
												<option value="MIS"> MIS DEPARTMENT</option>
												<option value="MARKETING"> MARKETING DEPARTMENT</option>
												<option value="SERVICE"> SERVICE DEPARTMENT</option>
												<option value="ACCOUNTING">ACCOUNTING DEPARTMENT</option>
											</select>-->

											<div class="form-group">
									<!-- <label> Delivered By </label> -->
									<?php
										echo '<select id="add_Departmentsection"  class="form-control" name="add_Departmentsection"><option value=""> SELECT DEPARTMENT </option>';
										foreach($departmentlist as $dept) {
											echo '<option value="'.$dept['departmentid'].'">';
											echo strtoupper($dept['departmentname']);
											echo '</option>';
										}	
										echo '</select>'; 
									?>
								</div>
										</div>
								</div>
								<div class="col">
								</div>
								<div class="col">
									<div class="form-group">
										<input type="date" name="add_DateTrans" value='<?php echo date('Y-m-d');?>' class="form-control form-control-sm" placeholder=".form-control-sm">
									</div>
									<div class="form-group">
										<input type="text" name="add_transnum" class="form-control form-control-sm" placeholder="Transmittal No">
									</div>
									<div class="form-group">
										<input type="text" name="add_status" class="form-control form-control-sm" placeholder="Status of the Client/Staff">
									</div>
									<!-- <div class="form-group">
										<input type="text" name="add_preparedby" value="<?=$fullname?>" class="form-control form-control-sm" readonly>
									</div> -->
								</div>
							</div>
							<table id="table_pullitems" class="table table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th> QTY </th>
										<th> ITEM </th>
										<th> SERIAL NO </th>
										<th> BRAND </th>
										<th> TOOL MODEL </th>
										<th> REMARKS </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type="text" name="add_noitems[]"  class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_itemname[]" class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_sn[]" class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_bm[]" class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_tm[]" class="form-control" required>
										</td>
										<td>
											<select class="form-select form-control form-select-sm " aria-label=".form-select-sm example" name="add_remarks[]" required>
												<option selected> </option>
												<option value="Functional"> Functional</option>
												<option value="Subject for replacement"> Subject for replacement</option>
												<option value="For Disposal">Not Functional/Damaged</option>
											</select>
										</td>
										<td>
											<button class="btn btn-info" type="button" name="addpullitems" id="addpullitems" value="add">
											<i class="fas fa-plus" style="width:20px;"></i> 
											</button>
										</td>
									</tr>
								</tbody>
							</table>
							<button type="submit" name="addingpullout" class="btn btn-primary">  PULLED OUT </button>
						</form>
					</div>
				</div>
				<br>
				<div class="table-responsive">
					<table id="pulloutitems" class="table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Date </th>
								<th scope="col"> Pullout </th>
								<th scope="col"> Name 	</th>
								<th scope="col"> ItemQty  	</th>
								<th scope="col">  Particulars 	</th>
								<th scope="col"> Remarks </th>
								<th scope="col"> </th>
							</tr>
						</thead>
						<tbody>
						<?php
							if(isset($Pulloutitems) )
				 			{
				 				foreach ($Pulloutitems as $PI) 
				 				{
								?>
								<tr>
									<td> <?= $PI['PU_CreatedDate'];?> </td>
									<td> <?= $PI['PulloutNo'];?> </td>
									<td> <?= $PI['PU_Name'];?> </td>
									<td> <?= $PI['pu_ItemQty'];?> </td>
									<td> <?= $PI['pu_Particulars'];?> </td>
									<td> <?= $PI['pu_itemRemarks'];?> </td>
									<td> 
										<button type="button" id="MISPulloutbtn" data-toggle="modal" data-target="#pulledoutmodal"  class="btn btn-outline-primary MISPulloutbtn" onclick="getItemDetails('<?php echo $PI['transNum'];?>','<?php echo $PI['pu_ItemQty'];?>',''<?php echo $PI['pu_Particulars'];?>,'<?php echo $PI['s_n'];?>','<?php echo $PI['bd'];?>','<?php echo $PI['tl'];?>')">
											<i class="fas fa-edit" style="width:20px;"></i></button>

										<button type="button" id="pulloutprintbtn" data-toggle="modal" data-target="#pulloutprintmodal"  class="btn btn-outline-primary pulloutprintbtn"><i class="fas fa-print" style="width:20px;"> </i>
										</button>
									</td>
								</tr>
								<?php
								}
							}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col"  align="right"><b> TOTAL <b>  </td>
								<td scope="col"></td>
								<td scope="col" align="center">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<!-- HISTORYYY -->
			<div class="tab-pane fade" id="nav-pullouthistory" role="tabpanel" aria-labelledby="nav-pullouthistory-tab">
				<br>
				<div class="table-responsive">
					<table id="MISitempullouthistory" class="table table-striped"
					style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Created Date </th>
								<th scope="col"> Pullout No </th>
								<th scope="col"> Name	</th>
								<th scope="col"> Department 	</th>
								<th scope="col"> Qty </th>
								<th scope="col"> Particulars </th>
								<th scope="col"> Prepared By</th>


							</tr>
						</thead>
						<tbody>
						<?php
						if(isset($PulloutHistory) )
				 			{
				 			foreach ($PulloutHistory as $ph) 
				 			{
							?>
							<tr>
								<td> <?= $ph['PU_CreatedDate'];?> </td>
								<td> <?= $ph['PulloutNo'];?> </td>
								<td> <?= $ph['Name'];?> </td>
								<td> <?= $ph['PU_Department'];?> </td>
								<td> <?= $ph['pu_ItemQty'];?> </td>
								<td> <?= $ph['pu_Particulars'];?> </td>
								<td> <?= $ph['PreparedBy'];?> </td>
							</tr>
							<?php
							} 
					}
					?>
						</tbody>
						<!-- <tfoot>
							<tr>
							
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col" align="right"><b> TOTAL <b>  </td>
								<td scope="col" align="center"> </td>
								<td scope="col" >  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
							</tr>
						</tfoot> -->
					</table>
				</div>
			</div>
		</div>
	</div>

<!-- PULLOUT MODAL  --> 
<div class="modal fade" id="pulledoutmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label> Date </label>
							<input type="text" name="po_no" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>PO_Number</label>
							<input type="text" name="po_no" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label> From </label>
							<input type="text" name="po_no" class="form-control" readonly>
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label> Department </label>
							<input type="text" name="po_no" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Transmittal No.</label>
							<input type="text" name="po_no" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label> Status of the client/Staff </label>
							<input type="text" name="po_no" class="form-control" readonly>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="button" class="btn btn-primary">Save changes</button>
      		</div>
		</div>
	</div>
</div>
<!-- PULLOUT PRINTINGGG  --> 
<div id="pulloutprintmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">
    
    <!-- Modal Content: begins -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel"></h4>
      </div>
    
      <!-- Modal Body -->  
      <div class="modal-body">
        <div class="body-message">
        	<div id="printThis_pullout">
        		<div class="template"  >
        			<div class="row">
        				<div class="col">
        					<img class="png" style="width:100%;" src="<?= site_url('public/img/pullout.png');?>">
        				</div>
        			</div>
        					<br>
        					<br>
        			<div class="row">
        				<div class="col">
        				<b><span>NAME :</span></b> <span id="owner"></span>
        				</div>
        				<div class="col">
        				</div>
        				<div class="col">
        					<b><span>PULL OUT NO :</span></b> <span id="pn"></span>
        				</div>
        			</div>

        			<div class="row">
        				<div class="col-8">
        					<b><span>DEPARTMENT/SECTION :</span> </b> 
        				<span id="do"></span>
        				</div>
        			
        			
        				<div class="col-4">
        					<b><span>DATE :</span></b> <span id="transdate_pullout"></span>
        				</div>
        			</div>
        			<br>
        			<div id="pulloutprint-container">
        			</div>
        			
        			<div class="pulloutspace" >
        				<div class="row">
        					<div class="col">
        						<p class="large">Prepared by:</p>
        					</div>
        				</div>
        				<div class="row">
        					<div class="col"  id="prepby"  style="margin-top:3%;margin-left:2%;">
        					</div>
        				</div>
        				<div class="row" >
        					<div class="col" style="text-align:center;">
        						<!-- <span id="deby"></span> -->
        					</div>
        					<div class="col-6">
        						<span></span>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        				</div>
        				<div class="row" >
        					<div class="col-3" style="border-top:1px solid black;margin-left:2%">
        						<p>Signature over printed name</p>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        					<div class="col">
        						<p class="large"> Received by:</p>
        					</div>
        					<div class="col">
        						
        					</div>
        				</div>
        				<br>
        				<br>
        				<div class="row" >
        					<div class="col-6">
        					</div>
        				
        					<div class="col" style="border-top:1px solid black;margin-left:2%">
        						<p>Signature over printed name</p>
        					</div>
        					<div class="col col-lg-2">
        					</div>

        				</div>

        			<br>
        				<div class="row" >
        					<div class="col" >
        						<p class="large"> Noted by: </p>
        					</div>
        					<div class="col-6">
        						<span></span>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        				</div>
        				<div class="row" >
        					<div class="col" style="margin-bottom:5%;">
        					</div>
        				</div>
        				<div class="row" >
        					<div class="col" style="border-top:1px solid black;margin-left:2%">
        						<p>Signature over printed name</p>
        					</div>
        					<div class="col-6">
        						<span></span>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        				</div>
        				<br>
        				<div class="row" style="margin-top:1%;color:gray;">
        					<div class="col-6" >
        						<b><span>F-851-252-MIS Rev.0 </span></b>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        					<div class="col">
        						<b> <span style="text-align: right;"> July 13,2020  </span></b>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div> 
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
        	<button id="btnPulloutPrint" type="button" class="btn btn-default">Print</button>
        </div>
      </div>
      <!-- Modal Content: ends -->
    </div>
  </div>
</div>
<!-- end/.container-fluid -->	
</div>
<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/inventory.js'); ?>"></script>
<script>
    var selectedValuesTest = [];
    $(document).ready(function() {
        $("#add_to").select2({
			multiple: false,
			allowClear: true,
			placeholder: "EMPLOYEE NAME",
			width: '100%', height: '20%'
		});
		$('#add_to').select2('val', selectedValuesTest);
    });
</script> 