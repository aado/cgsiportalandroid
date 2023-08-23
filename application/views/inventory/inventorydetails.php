<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<div class="container-fluid">
<!-- Page Heading -->
<style>
	.select2-selection--single {
		border-color: #80bdff;
		height: 38px !important;
	}
</style>
<h1 class="h3 mb-4 text-gray-800">Inventory Details</h1>
	<table class="table table-striped" id="datatobetransmit" style="width:100%;">
		<thead>
			<tr>
				<th scope="col"> Delivery Date </th>
				<th scope="col"> PO No. </th>
				<th scope="col"> TotalPerPO </th>
				<th scope="col"> Requester </th>
				<th scope="col"> To </th>
				<th scope="col"> TotalQty </th>		
				<th scope="col"> ItemName </th>
				<th scope="col" width="20%"> ItemDesc </th>
				<th scope="col"> Note </th>
				<th scope="col"> TransQty </th>	
				<th scope="col"> Trans Num </th>	
				<th scope="col">  </th>
			</tr>
		</thead>
		<tbody> 
			<?php
			if(isset($inventorydetails))
			{
				foreach ($inventorydetails as $InvDe)
				{
					?>
					<tr>
						<td> <?php echo $InvDe['Delivery_Date'];?> </td>
						<td> <?php echo $InvDe['PO_Number'];?> </td>
						<td> <?php echo $InvDe['totalQty'];?> </td>
						<td> <?php echo $InvDe['Requester'];?> </td>
						<td> <?=$getEmpName($InvDe['TransmittedTo']);?></td>
						<td> <?=$totalItemCount($InvDe['ItemName']);?> </td>
						<td> <?php echo $InvDe['ItemName'];?> </td>
						<td> <?php echo substr($InvDe['ItemDesc'], 0,50);?> ... </td>
						<td> <?php echo $InvDe['Note'];?> </td>
						<td> <?php echo $InvDe['Qty'];?> </td>
						<td> <?php echo $InvDe['transmittal_Num'];?> </td>
						<td>
							<?php
								
								if($InvDe['Qty'] !== $InvDe['totalQty'])
 								{
 									?>
 									<button type="button" class="btn btn-info approvedbtn" title="approve" data-toggle="modal" data-target="#transmitmismodal" onclick="getItemDetails('<?php echo $InvDe['ItemName'];?>',' <?=$totalItemCount($InvDe['ItemName']);?>','<?php echo ($InvDe['Qty'] == '')? 0: $InvDe['Qty'];?>','<?php echo $InvDe['Invoice_Number'];?>','<?php echo $InvDe['Delivery_Date'];?>','<?php echo $InvDe['PO_Number'];?>','<?=$itemCount($InvDe['ItemName']);?>')"><i class="fas fa-share"></i> </button>
 									<?php
 								}
 								?>
						</td>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>

<div>
	<div class="modal fade" id="transmitmismodal" tabindex="-1" role="dialog" aria-labelledby="transmitModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmtransmit">
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label>Transmit to: </label>
									<input type="hidden" name="Delivery_Date" id="Delivery_Date">
									<input type="hidden" name="invoice_number" id="invoice_number">
									<input type="hidden" name="Particulars" id="Particulars">
									<input type="hidden" name="PO_Number" id="PO_Number">
										<?php
											echo '<select id="TransmittedTo"  class="form-control" name="TransmittedTo"><option value=""> SELECT NAME </option>';
											foreach($EmployeeList as $emp) {
												echo '<option value="'.$emp['UserID'].'">';
												echo strtoupper($emp['Name']);
												echo '</option>';
											}	
											echo '</select>'; 
										?>
								</div>
								<div class="form-group">
									<label> Transmittal Number </label>
									<input type="text" name="transmittal_Num" value="<?=$transmittalNumber?>" class="form-control"  
									readonly>
								</div>
								<div class="form-group">
									<label>Brand </label>
										<?php
											echo '<select id="Brands"  class="form-control" name="Brands"><option value=""> BRAND </option>';
											foreach($brands as $brand) {
												echo '<option value="'.$brand['Brand'].'">';
												echo $brand['Brand'];
												echo '</option>';
											}	
											echo '</select>'; 
										?>
									</label>
								</div>
								<div class="form-group">
									<label>Tool Model</label>
									<input type="text" name="ToolM" id="ToolM" class="form-control" required >
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<label> Delivered By </label>
									<?php
										echo '<select id="DeliveredBy"  class="form-control" name="DeliveredBy"><option value=""> SELECT NAME </option>';
										foreach($deliveredby as $emp) {
											echo '<option value="'.strtoupper($emp['Name']).'">';
											echo strtoupper($emp['Name']);
											echo '</option>';
										}	
										echo '</select>'; 
									?>
								</div>
								<div class="form-group">
									<label>Serial Number </label>
									<input type="text" name="SerialNo" id="SerialNo" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Qty </label>
									<select class="form-control" id="qty" name="qty"></select>
								</div>
								<div class="form-group">
									<label> Note </label>
									<input type="text" name="Note" id="Note" class="form-control">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal"> CLOSE </button>
							<button type="submit" class="btn btn-primary"> TRANSMIT</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="float: left; margin-left: 12px">
				<button type="button" class="btn btn-danger" title="back" style="width:95px;" onclick="backButton('<?=$locstatus?>')"> <i class="fas fa-arrow-left"></i> BACK </button>
			</div>
<!-- /.container-fluid -->
</div>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/inventory.js'); ?>"></script>
<script>
	var selectedValuesTest = [];
    $(document).ready(function() {
        $("#TransmittedTo").select2({
			multiple: false,
			dropdownParent: $("#transmitmismodal"),
			allowClear: true,
			placeholder: "EMPLOYEE NAME",
			width: '100%' 
		});
		$('#TransmittedTo').select2('val', selectedValuesTest);

		$("#Brands").select2({
			multiple: false,
			dropdownParent: $("#transmitmismodal"),
			allowClear: true,
			placeholder: "BRAND",
			width: '100%' 
		});
		$('#Brands').select2('val', selectedValuesTest);
    });
</script
