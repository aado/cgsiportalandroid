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
					TO BE TRANSMITTED
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  id="nav-transmitted-tab" data-toggle="tab" href="#nav-transmitted" role="tab" aria-controls="nav-transmitted" aria-selected="false">
					TRANSMITTED
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link"  id="nav-transmittedhistory-tab" data-toggle="tab" href="#nav-transmittedhistory" role="tab" aria-controls="nav-transmittedhistory" aria-selected="false">
					HISTORY
				</a>
			</li>
		</ul>
		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-transmittal" role="tabpanel" aria-labelledby="nav-inventory-tab">
				<br>
				<div class="table-responsive">
					<table id="tobetransmitted" class="table table-striped" style="width:100%;">
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
						
				 			if(isset($ToBeTransmitted) )
				 			{
				 				foreach ($ToBeTransmitted as $TBT) 
				 				{
				 					if($TBT['TOTALQTY'] - $itemCount($TBT['ItemName']) !='0')
										{
									?>
									<tr>
										<td> <?= $TBT['Entry_Date'];?> </td>
										<td> <?= $TBT['ItemName'];?> </td>
										<td> <?= $TBT['ItemUnit'];?> </td>
										<td> <?= $TBT['ItemSize'];?> </td>
										<td><?=$TBT['TOTALQTY'];?> </td>
										<td><?=$TBT['TOTALQTY']-$itemCount($TBT['ItemName'])?></td>
										<td>
											<a href="inventorydetails/<?= $TBT['ItemName'];?>">
												<button type="submit" name="viewdetails" class="btn btn-outline-primary">
													<span id="<?php echo $TBT['ID'] ?>">
														<i class="fas fa-th-list" onClick="loadDetail(<?php echo $TBT['ID'] ?>)"></i> 
													</span>
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
			<div class="tab-pane fade" id="nav-transmitted" role="tabpanel" aria-labelledby="nav-transmitted-tab">
				<br>
				<p>
					<a class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
						ADD ITEMS
					</a>
				</p>
				<div class="collapse" id="collapseExample">
					<div class="card card-body">
						<form action="additems.php" method="POST">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label>TRANSMITTAL NUMBER</label>
										<input type="text" name="add_transnum" class="form-control form-control-sm" placeholder="TRANSMITTAL NUMBER" value="<?=$transmittalNumber?>" readonly>
									</div>
									<div class="form-group">
										<input type="text" name="add_ponumber" id="to" class="form-control form-control-sm" placeholder="PO NUMBER">
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
								</div>
								<div class="col">
								</div>
								<div class="col">
									<div class="form-group">
										<input type="date" name="add_DateTrans" value='<?php echo date('Y-m-d');?>' class="form-control form-control-sm" placeholder=".form-control-sm">
									</div>
									<div class="form-group">
										<input type="text" name="add_deliveredby" id="add_deliveredby" class="form-control form-control-sm" placeholder="DELIVERED BY" required>
									</div>
									<div class="form-group">
										<input type="text" name="add_Invoicenum"
										class="form-control form-control-sm" placeholder="INVOICE NUMBER">
									</div>
								</div>
							</div>
							<table id="table_items" class="table table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th> QTY </th>
										<th> PARTICULARS </th>
										<th> BRAND </th>
										<th> TOOLM </th>
										<th> SERIAL NO </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type="text" name="add_ItemQty[]"  class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_Particulars[]" class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_Brand[]" class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_ToolM[]" class="form-control" required>
										</td>
										<td>
											<input type="text" name="add_SerialNo[]" class="form-control" required>
										</td>
										<td>
											<button class="btn btn-info" type="button" name="additems" id="additems" value="add"> 
												<i class="fas fa-plus" style="width:20px;"></i> 
											</button>
										</td>
									</tr>
								</tbody>
							</table>
							<center>
								<button type="submit" name="adding" class="btn btn-primary">
									TRANSMIT
								</button>
							</center>
						</form>
					</div>
				</div>
				<div class="table-responsive">
					<?php //print_r($transmitted) ?>
					<table id="MISitemtransmitted" class="table table-striped" style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> Date Transmitted </th>
								<!-- <th scope="col"> PO 	</th> -->
								<!-- <th scope="col"> Inv_No  </th> -->
								<th scope="col"> Trans_No </th>
								<th scope="col"> To	</th>
								<th scope="col"> ItemName </th>
								<th scope="col"> Qty </th>
								<th scope="col"> Brand  </th>
								<!-- <th scope="col">   </th>
								<th scope="col">   </th>
								<th scope="col">   </th>
								<th scope="col"> Status </th>
								<th scope="col">  </th>
								<th scope="col"> Note </th>
								<th scope="col">  </th>
								<th scope="col">  </th> -->
							</tr>
						</thead>
						<tbody>
						<?php
											
				 			// if(isset($TransmittedItems) )
				 			// {
				 			// 	foreach ($TransmittedItems as $TI) 
				 			// 	{
								if(isset($transmitted) )
				 				{
				 				foreach ($transmitted as $TI) 
				 				{
									?>
							<tr>
								<td> <?= $TI['DateTrans'];?> </td>
								<!-- <td> </td> -->
								<!-- <td>  </td> -->
								<td> <?= $TI['ID_no'];?> </td>
								<td> <?= $TI['TransmittalTo'];?> </td>
								<td> <?= $TI['Particulars'];?> </td>
								<td> <?= $TI['QTY'];?> </td>
								<td> <?= $TI['Brand'];?> </td>
								<!--<td> <?= $TI['toolmodel'];?> </td>
								<td> <?= $TI['SN'];?> </td>
								<td> <?= $TI['db'];?> </td>
								<td> <?= $TI['itemStatus'];?> </td>
								<td> <?= $TI['itemRemarks'];?> </td>
								<td> <?= $TI['Note'];?> </td>
								<td> <?= $TI['Idno'];?> </td> -->
								<!-- <td>
									
									<button type="button" class="btn btn-outline-primary MIStransmittedbtn" title="approve" data-toggle="modal" data-target="#transmittedmodalmis"> <i class="fas fa-edit" style="width:20px;"></i> </button>

									<button type="button" id="btnPrint" class="btn btn-outline-primary forprintbtn" title="For Print" data-toggle="modal" data-target="#forprintmodal"> <i class="fas fa-print" style="width:20px;"></i> </button> -->
									
									<!-- <button type="button" id="MIStransmittedbtn" data-toggle="modal" data-target="#transmittedmodalmis"  class="btn btn-outline-info MIStransmittedbtn"><i class="fas fa-edit" style="width:20px;"></i>
									</button>
									<button type="button" class="btn btn-outline-primary forprintbtn" title="For Print" data-toggle="modal" data-target="#forprintmodal"> <i class="fas fa-print" style="width:20px;"></i> </button>-->
								<!-- </td> -->
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
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>									
								<td scope="col" align="right"><b> TOTAL <b></td>
								<td scope="col" align="center">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
							</tr>
						</tfoot> -->
					</table>
				</div>
			</div>
			<!-- HISTORY -->
			<div class="tab-pane fade" id="nav-transmittedhistory" role="tabpanel" aria-labelledby="nav-transmittedhistory-tab">
				<br>
				<div class="table-responsive">
					<table id="MISitemtransmittedhistory" class="table table-striped" 
					style="width:100%;">
						<thead>
							<tr>
								<th scope="col"> DateTransmitted </th>
								<th scope="col"> Trans. No </th>
								<th scope="col"> To	</th>
								<th scope="col"> ItemName 	</th>
								<th scope="col"> Qty </th>
								<th scope="col"> Status </th>
								<th scope="col"> Delivered By </th>


							</tr>
						</thead>
						<tbody>
						<?php
						if(isset($InventoryHistory) )
				 			{
				 			foreach ($InventoryHistory as $IH) 
				 			{
							?>
							<tr>
								<td> <?= $IH['datetrans'];?> </td>
								<td> <?= $IH['transmittal_num'];?> </td>
								<td> <?= utf8_encode($IH['TransmittedTo']);?> </td>
								<td> <?= $IH['Particulars'];?> </td>
								<td> <?= $IH['ItemQty'];?> </td>
								<td> <?= $IH['Status'];?> </td>
								<td> <?= $IH['DeliveredBy'];?> </td>
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
								<td scope="col" align="right"><b> TOTAL <b>  </td>
								<td scope="col" align="center"> </td>
								<td scope="col" >  </td>
								<td scope="col">  </td>
								<td scope="col">  </td>
							</tr>
						</tfoot>
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
<!-- </div> -->
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