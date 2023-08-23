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
<h1 class="h3 mb-4 text-gray-800">Details</h1>
	<table class="table table-striped" id="datalists" style="width:100%;">
		<thead>
			<tr>
				<!-- <th scope="col"> Delivery Date </th> -->
				<th scope="col"> PO No. </th>
				<!-- <th scope="col"> Invoice No. </th> -->
				<th scope="col"> Requester </th>
				<!-- <th scope="col"> To </th> -->
				<th scope="col"> TotalQty </th>		
				<th scope="col"> ItemName </th>
				<th scope="col" width="20%"> ItemDesc </th>
				<th scope="col"> TransQty </th>	
				<th scope="col"> Trans Num </th>
				<th scope="col"> </th>		
				<th scope="col">  </th>
			</tr>
		</thead>
		<tbody> 
			<?php
			if(isset($inventorylist))
			{
				foreach ($inventorylist as $InvDe)
				{
					?>
					<tr>
						<!-- <td> <?php echo $InvDe['Delivery_Date'];?> </td> -->
						<td> <?php echo $InvDe['PO_Number'];?> </td>
						<!-- <td> <?php echo $InvDe['Invoice_Number'];?> </td> -->
						<td> <?php echo $InvDe['Requester'];?> </td>
						<!-- <td> <?php echo $InvDe['TransmittedTo'];?> </td> -->
						<td> <?php echo $InvDe['totalQty'];?> </td>
						<td> <?php echo $InvDe['ItemName'];?> </td>
						<td> <?php echo substr($InvDe['ItemDesc'], 0,50);?> ... </td>
						<td> <?php echo $InvDe['Qty'];?> </td>
						<td> <?php echo $InvDe['transmittal_Num'];?> </td>
						<td> <?php echo $InvDe['itemRemarks'];?> </td>

						<td> 
							<button type="button" class="btn btn-info approvedbtn" title="approve" data-toggle="modal" data-target="#transmitmismodal" onclick="getEntryDetails('<?php echo $InvDe['Delivery_Date'];?>','<?php echo $InvDe['PO_Number'];?>','<?php echo $InvDe['Invoice_Number'];?>','<?php echo $InvDe['itemStatus'];?>','<?php echo $InvDe['ItemDesc'];?>')"><i class="fas fa-eye"></i> </button>

							<button type="button" class="btn btn-info approvedbtn" title="approve" data-toggle="modal" data-target="#transmitmismodal"><i class="fas fa-file-image"></i> </button>
						
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
						<form id="frmAddReceipt">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label> Delivery Date </label>
											<input type="text" id="del_date" value="<?php echo $InvDe['Delivery_Date'];?>" class="form-control"  
										readonly>
									</div>
									<div class="form-group">
										<label> PO Number </label>
										<input type="text" id="po_number" name="PO_Number" value="<?php echo $InvDe['PO_Number'];?>" class="form-control"  
										readonly>
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Invoice Number </label>
										<input type="text" id="invoice_number" value="<?php echo $InvDe['Invoice_Number'];?>"  class="form-control" readonly>
									</div>
									<div class="form-group">
										<label> Item Status </label>
										<input type="text" id="status" value="<?php echo $InvDe['itemStatus'];?>" class="form-control" readonly>
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Delivery receipt </label>
										<input type="hidden" id="ItemName" name="ItemName" value="<?=$InvDe['ItemName']?>"/>
										<input type="text" id="delivery_receipt" name="delivery_receipt" value="<?=isset($InvDe['Deliveryreceipt'])? $InvDe['Deliveryreceipt']: '';?>"  class="form-control" />
									</div>
									<div class="form-group">
										<label> Item Cost</label>
										<input type="text" id="amount" name="amount" value="<?=isset($InvDe['Amount'])?$InvDe['Amount']:'';?>" class="form-control" >
									</div>
								</div>
							</div>
							<!-- <hr>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label> DELIVERY RECEIPT </label>
										<input type="text" id="deliveryreceipt" class="form-control"  
									>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<label> Item Amount</label>
									<input type="text" id="itemAmount" class="form-control"  
									>
								</div>
							</div>
						</div> -->
						</div>
						
						<div class="modal-footer">
							<button type="submit" class="btn btn-success" data-dismiss="modal"> UPDATE </button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal"> CLOSE </button>
						</div>
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
