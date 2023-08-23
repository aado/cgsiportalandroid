<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>

	<div id="transmittal" class="tabcontent">
		<br>
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active"  id="nav-transmittal-tab" data-toggle="tab" href="#nav-transmittal" role="tab" aria-controls="nav-transmittal" aria-selected="true">
					EQUIPMENTS
				</a>
			</li>
			<?php
			// if($idnumber == '300319' || $idnumber =='300146' || $idnumber=='300109')
			if($idnumber == '300544' || $idnumber =='300591')
			{
			?>
			<li class="nav-item">
				<a class="nav-link"  id="nav-officesupp-tab" data-toggle="tab" href="#nav-officesupp" role="tab" aria-controls="nav-officesupp" aria-selected="true">
					OFFICE SUPPLIES
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  id="nav-chemicals-tab" data-toggle="tab" href="#nav-chemicals" role="tab" aria-controls="nav-chemicals" aria-selected="true">
					CHEMICALS
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  id="nav-uniforms-tab" data-toggle="tab" href="#nav-uniforms" role="tab" aria-controls="nav-uniforms" aria-selected="true">
					UNIFORMS
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  id="nav-cleaningsupp-tab" data-toggle="tab" href="#nav-cleaningsupp" role="tab" aria-controls="nav-cleaningsupp" aria-selected="true">
					CLEANING SUPPLIES
				</a>
			</li>
			<?php
		}
			?>
			<li class="nav-item">
				<a class="nav-link"  id="nav-empnames-tab" data-toggle="tab" href="#nav-empnames" role="tab" aria-controls="nav-empnames" aria-selected="false">
					EMPLOYEE LIST
				</a>
			</li>
		</ul>
		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-transmittal" role="tabpanel" aria-labelledby="nav-inventory-tab">
				<br>
				<div class="table-responsive">
					<table id="equipment" class="table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Date Transfered </th>
								<th scope="col"> ItemName 	</th>
								<th scope="col"> ItemUnit 	</th>
								<th scope="col"> ItemSize 	</th>
								<th scope="col"> TotalQty  	</th>
								<th scope="col"> Available </th>
								<th scope="col"> </th>
							</tr>
						</thead>
						<tbody>
						<?php
						
				 			if(isset($Inventory) )
				 			{
				 				foreach ($Inventory as $TBT) 
				 				{
										if($TBT['TOTALQTY'] - $itemCount($TBT['TOTALQTY']) !='0')
											{
										?>
										<tr>
											<td> <?= $TBT['Entry_Date'];?> </td>
											<td> <?= $TBT['ItemName'];?> </td>
											<td> <?= $TBT['ItemUnit'];?> </td>
											<td> <?= $TBT['ItemSize'];?> </td>
											<td align="center"><?=$TBT['TOTALQTY'];?> </td>
											<!--<td align="center"></td>!-->
											<td><?=$TBT['TOTALQTY']- $itemCount($TBT['TOTALQTY']);?></td>
											<td>
											<a href="inventorylist/<?= $TBT['ItemName'];?>/1">
													<button type="submit" name="viewdetails" class="btn btn-outline-primary">
														<i class="fas fa-th-list"></i> 
													</button>
												</a>
											</td>
										</tr>
										<?php
									}
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="nav-officesupp" role="tabpanel" aria-labelledby="nav-officesupp-tab">
				<br>
				<div class="table-responsive">
					<table id="officesupp" class="table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Entry_Date </th>
								<th scope="col"> ItemName 	</th>
								<th scope="col"> ItemUnit 	</th>
								<th scope="col"> ItemSize 	</th>
								<th scope="col"> TotalQty  	</th>
								<th scope="col"> Available </th>
								<th scope="col"> </th>
							</tr>
						</thead>
						<tbody>
						<?php
						
				 			if(isset($Officesupplies) )
				 			{
				 				foreach ($Officesupplies as $OS) 
				 				{
				 				
									?>
									<tr>
										<td> <?= $OS['Entry_Date'];?> </td>
										<td> <?= $OS['ItemDesc'];?> </td>
										<td> <?= $OS['ItemUnit'];?> </td>
										<td> <?= $OS['ItemSize'];?> </td>
										<td align="center"><?=$itemCountbyName(str_replace("'","",$OS['ItemDesc']));?> </td>
										<td align="center"><?=$OS['totalqty'];?> </td>
										<td>
											<a href="inventorylist/<?= str_replace("'","",$OS['ItemDesc']);?>/2">
												<button type="submit" name="viewdetails" class="btn btn-outline-primary">
													<i class="fas fa-th-list"></i> 
												</button>
											</a>
										</td>
									</tr>
									<?php
										
										}
									}
								?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="nav-chemicals" role="tabpanel" aria-labelledby="nav-chemicals-tab">
				<br>
				<div class="table-responsive">
					<table id="chemicals" class="table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Entry_Date </th>
								<th scope="col"> ItemName 	</th>
								<th scope="col"> ItemUnit 	</th>
								<th scope="col"> ItemSize 	</th>
								<th scope="col"> TotalQty  	</th>
								<th scope="col"> Available </th>
								<th scope="col"> </th>
							</tr>
						</thead>
						<tbody>
						<?php
						
				 			if(isset($chemicals) )
				 			{
				 				foreach ($chemicals as $chems) 
				 				{
				 					
									?>
									<tr>
										<td> <?= $chems['Entry_Date'];?> </td>
										<td> <?= $chems['ItemDesc'];?> </td>
										<td> <?= $chems['ItemUnit'];?> </td>
										<td> <?= $chems['ItemSize'];?> </td>
										<td align="center"><?=$itemCountbyName($chems['ItemDesc'])?> </td>
										<td align="center"><?=$chems['totalqty'];?> </td>
										<!--<td align="center"></td>!-->
										<td>
											<a href="inventorylist/<?= $chems['ItemDesc'];?>/2">
												<button type="submit" name="viewdetails" class="btn btn-outline-primary">
													<i class="fas fa-th-list"></i> 
												</button>
											</a>
										</td>
									</tr>
									<?php
										
										}
									}
								?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="nav-uniforms" role="tabpanel" aria-labelledby="nav-uniforms-tab">
				<br>
				<div class="table-responsive">
					<table id="uniforms" class="table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Entry_Date </th>
								<th scope="col"> ItemName 	</th>
								<th scope="col"> ItemUnit 	</th>
								<th scope="col"> ItemSize 	</th>
								<th scope="col"> TotalQty  	</th>
								<th scope="col"> Available </th>
								<th scope="col"> </th>
							</tr>
						</thead>
						<tbody>
						<?php
						
				 			if(isset($uniforms) )
				 			{
				 				foreach ($uniforms as $uni) 
				 				{
				 					
									?>
									<tr>
										<td> <?= $uni['Entry_Date'];?> </td>
										<td> <?= $uni['ItemDesc'];?> </td>
										<td> <?= $uni['ItemUnit'];?> </td>
										<td> <?= $uni['ItemSize'];?> </td>
										<td align="center"><?=$itemCountbyName(str_replace("'","",$uni['ItemDesc']));?>  </td>
										<td align="center"><?=$uni['totalqty'];?> </td>
										<!--<td align="center"></td>!-->
										<td>
											<a href="inventorylist/<?= $uni['ItemDesc'];?>/2">
												<button type="submit" name="viewdetails" class="btn btn-outline-primary">
													<i class="fas fa-th-list"></i> 
												</button>
											</a>
										</td>
									</tr>
									<?php
										
										}
									}
								?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="nav-cleaningsupp" role="tabpanel" aria-labelledby="nav-cleaningsupp-tab">
				<br>
				<div class="table-responsive">
					<table id="cleaningsupp" class="table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Entry_Date </th>
								<th scope="col"> ItemName 	</th>
								<th scope="col"> ItemUnit 	</th>
								<th scope="col"> ItemSize 	</th>
								<th scope="col"> TotalQty  	</th>
								<th scope="col"> Available </th>
								<th scope="col"> </th>
							</tr>
						</thead>
						<tbody>
						<?php
						
				 			if(isset($cleaningsupp) )
				 			{
				 				foreach ($cleaningsupp as $cs) 
				 				{
									?>
									<tr>
										<td> <?= $cs['Entry_Date'];?> </td>
										<td> <?= $cs['ItemDesc'];?> </td>
										<td> <?= $cs['ItemUnit'];?> </td>
										<td> <?= $cs['ItemSize'];?> </td>
										<td align="center"><?=$itemCountbyName(str_replace("'","",$cs['ItemDesc']));?>  </td>
										<td align="center"><?=$cs['totalqty'];?> </td>
										<!--<td align="center"></td>!-->
										<td>
											<a href="inventorylist/<?= str_replace("'","",$cs['ItemDesc']);?>/2">
												<button type="submit" name="viewdetails" class="btn btn-outline-primary">
													<i class="fas fa-th-list"></i> 
												</button>
											</a>
										</td>
									</tr>
									<?php
										}
									}
								?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="nav-empnames" role="tabpanel" aria-labelledby="nav-empnames-tab">
			<!-- <br>
				<p>
					<a class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
						ADD EMPLOYEE ITEM
					</a>
				</p>
					<div class="collapse" id="collapseExample">
						<div class="card card-body">
					
						</div>
					</div>-->
			<br>
				<div class="table-responsive">
					<table id="dataemployeelist" class="table table-striped" width="100%">
						<thead>
							<tr>
								<th scope="col"> Employee ID </th>
								<th scope="col"> Name </th>
								<th scope="col"> Designation </th>
								<th scope="col"> Department </th>
								<th scope="col"> </th>
							<!-- <th scope="col"> </th> -->							
							</tr>
						</thead>
						<tbody>

							<?php
							if(isset($EmployeeList) )
				 			{
				 				foreach ($EmployeeList as $EML) 
				 				{
								?>
								<tr>
								<td> <?= $EML['UserID'];?> </td>
								<td> <?= $EML['Name'];?> </td>
								<td> <?= $EML['designationname'];?> </td>
								<td> <?= $EML['departmentname'];?> </td>
								<td>
									<button type="button" class="btn btn-outline-primary MIStransmittedbtn" title="approve" data-toggle="modal" data-target="#transmittedmodalmis"> <i class="fas fa-th-list"></i>  </button>
								</td>
							</tr>
								<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<!-- /.end of TRANSMITTAL CONTENT-->
	</div>


<!-- TRANSMITTED MODAL  --> 
<div class="modal fade" id="transmittedmodalmis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="updatetransmitted.php" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label style="text:Bold"> DateTransmitted </label>
								<input type="text" name="DateTrans" id="DateTrans" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label> PO Number </label>
								<input type="text" name="PONumber" id="PO" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label>Invoice Number </label>
								<input type="text" name="Invoice_Number" id="invoice" class="form-control" readonly>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label> Transmittal Number </label>
								<input type="text" name="transmittal_Num" id="transnum" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label> ID No </label>
								<input type="text" name="TransmittedTo" id="Idno" class="form-control" 
								readonly>
							</div>
							<div class="form-group">
								<label>Transmitted to </label>
								<input type="text" id="TransmittedTo" class="form-control" 
								readonly>
							</div>
						</div>
					</div>
					<br>
					<div id="details-container">
						
					</div>
					<div id="pulloutform" style="display:none">
						<div class="row" >
						<div class="col">
								<div class="form-group">
											<label> Transmittal No. </label>
											<input type="text" id="pullout_transnum" name="pullout_transnum"
											class="form-control" readonly>
										</div>
							<div class="form-group">
											<label> Qty </label>
											<input type="text" id="pullout_qty" name="pullout_qty"
											class="form-control" readonly>
										</div>
								<div class="form-group">
											<label> Particulars </label>
											<input type="text" id="pullout_particulars" name="pullout_particulars"
											class="form-control" readonly>
										</div>
										
						</div>
						<div class="col">
							<div class="form-group">
											<label> Brand </label>
											<input type="text" id="pullout_brand" name="pullout_brand"
											class="form-control" readonly>
										</div>
								<div class="form-group">
											<label> ToolM </label>
											<input type="text" id="pullout_ToolM" name="pullout_ToolM"
											class="form-control" readonly>
										</div>
										<div class="form-group">
											<label> Serial No </label>
											<input type="text" id="pullout_sn" name="pullout_sn"
											class="form-control" readonly>
										</div>

							
						</div>
					</div>
					<div class="row" >
						<div class="col">
							
							<div class="form-group">
								<label> Status </label>
								<select id="Status"  class="form-select form-control form-select-sm " aria-label=".form-select-sm example" name="Status" readonly>
								<!-- 	<option value="Transmit" selected> </option> -->
									<option id="pulloutoption" value="Pullout"> Pull out</option> 
									<!-- <option id="forrepair" onchange="pullout(this)" value="For Repair"> For Repair  </option>
									<option id="fordisposal"  id="showpullout" value="For Disposal"> For Disposal  </option> --> 
								</select>
							</div>
							<div class="form-group" >
								<label> Pullout No. </label>
								<div class="form-group"><input type="text" name="pulloutNo" class="form-control" readonly></div>';
			 							<label> Department/Section </label>
			 							<select class="form-select form-control form-select-sm " aria-label=".form-select-sm example" name="department">
											<option selected> </option>
											<option value="HR">HR DEPARTMENT</option>
											<option value="MIS"> MIS DEPARTMENT</option>
											<option value="MARKETING"> MARKETING DEPARTMENT</option>
											<option value="SERVICE"> SERVICE DEPARTMENT</option>
											<option value="ACCOUNTING">ACCOUNTING DEPARTMENT</option>
									</select>
								<!-- <input type="text" name="department" class="form-control">-->
								<div class="form-group">
									<label> Remarks </label>
									<select class="form-select form-control form-select-sm " aria-label=".form-select-sm example" name="pulloutremarks">
										<option selected> </option>
										<option value="Functional"> Functional</option>
										<option value="Subject for replacement"> Subject for replacement</option>
										<option value="Not Functional/Damaged">Not Functional/Damaged</option>
									</select>
								</div>
								<div class="form-group">
									<label> Note </label>
									<input type="text" name="pulloutNote"
									class="form-control">
								</div>
								<div class="form-group">
									<label> Status of Staff/Client </label>
									<input type="text" name="StatusofStaffClient" 
									class="form-control">
								</div>
								<div class="form-group">
									<label> Prepared By: </label>
									<input type="text" name="preparedBy" 
									class="form-control">
								</div>
								
							</div>
						</div>
						</div>
						</div>
						<div id="pulloutformhide">
							<div class="row">
								<div class="col">
							<!-- last -->
							
								<div class="form-group" >
									<label> Delivered By </label>
									<input type="text" name="DeliveredBy" id="db" class="form-control" readonly>
								</div>
								<div class="form-group" >
								<label> Remarks </label>
								<select class="form-select form-control form-select-sm " aria-label=".form-select-sm example" name="remarks">
									<option selected> </option>
									<option value="Functional" selected> Functional </option>
									<!-- <option value="Subject for replacement"> Subject for replacement</option>
									<option value="For Disposal">Not Functional/Damaged</option> -->
								</select>
								</div>
								<div class="form-group">
									<label> Note </label>
									<input type="text" name="Note" id="Note" class="form-control">
								</div>
								
							
						</div>
					</div>
				</div>
				</div>
				<div class="modal-footer">
					<div id="hidetransmitbtn">
						<button type="button"  class="btn btn-secondary" data-dismiss="modal"> CLOSE </button>
						<button type="submit" name="updatetransmitted" class="btn btn-primary" id="update"> UPDATE </button>
					</div>
					<div id="hidepulloutbtn" style="display:none;" >
						<button type="button"  class="btn btn-secondary" data-dismiss="modal"> CLOSE </button>
						<button type="submit" name="pulledoutdata" formaction="pulloutdata.php" class="btn btn-primary"> PULLOUT </button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div> 

<!-- PRINTINGGG  --> 
<div id="forprintmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  
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
        	<div id="printThis">
        		<div class="template" style="border: 1px solid black;" >
        			<div class="row">
        				<div class="col">
        					<img class="img" src="<?= site_url('public/img/transmittal.png');?>">
        				</div>
        			</div>
        				<br>
        				<br>
        			<div class="row">
        				<div class="col">
        				</div>
        				<div class="col">
        				</div>
        				<div class="col">
        					<b><span>NO :</span></b> <span id="transnom"></span>
        				</div>
        			</div>

        			<div class="row row-centered">
        				<div class="col">
        					<b><span>TO : </span></b> <span id="To"></span>
        				</div>
        				<div class="col">
        				</div>
        				<div class="col">
        					<b><span>DATE :</span></b> <span id="DateTransmit"></span>
        				</div>
        			</div>
        			<div class="row row-centered">
        				<div class="col">
        					<BR>
        					<p>
        						We would like to inform you that we will transmit equipment/supplies as described below, currently assign in your good office.
        					</p>
        				</div>
        			</div>

        			<div id="table-container">
        			</div>
        		
        			<div class="morespace" >
        				<div class="row" >
        					<div class="col" >
        						<span>Prepared & Transmitted by:</span>
        					</div>
        				</div>
        				<div class="row">
        					<div class="col" style="margin-bottom:5%;">
        					</div>
        				</div>
        				<div class="row" >
        					<div class="col" style="text-align:center;">
        						<span id="dby"></span>
        					</div>
        					<div class="col-6">
        						<span></span>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        				</div>
        				<div class="row" >
        					<div class="col" style="border-top:1px solid black;margin-left:2%">
        						<span style="font-size: 12px;">Signature over Printed</span>
        					</div>
        					<div class="col-6">
        						<span></span>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        				</div>
        				<br>
        				<br>
        				<div class="row" >
        					<div class="col" style="text-align:center;">
        						<span> Received by: </span>
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
        						<span style="font-size: 12px;">Signature over Printed</span>
        					</div>
        					<div class="col-6">
        						<span></span>
        					</div>
        					<div class="col">
        						<span></span>
        					</div>
        				</div>
        				<br>
        				<div class="row" style="border-top: 2px solid black;margin-top:2%;color:gray;">
        					<div class="col" >
        						<b><span style="font-size: 12px;">  F-851-39 Rev.1  </span></b>
        					</div>
        					<div class="col-6">
        						<span></span>
        					</div>
        					<div class="col">
        						<b> <span style="font-size: 12px;text-align: right;"> September 14, 2017  </span></b>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
        	<button id="btnPrint" type="button" class="btn btn-default">Print</button>
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