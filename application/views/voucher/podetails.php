<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">PO Details</h1>
	<?php if($getPODetails) { ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col"style="width:2%">ReqNum</th>
						<th scope="col" style="width:15%">Supplier</th>
						<th scope="col" style="width:10%">Item Name</th>
						<th scope="col" style="width:30%">Desc</th>
						<th scope="col" style="width:5%">Unit</th>
						<th scope="col" style="width:5%">Size</th>
						<th scope="col"style="width:5%">Qty</th>
						<th scope="col" style="width:8%">Cost</th>
						<th scope="col" style="width:15%">TotalCost</th>
					</tr>
				</thead>
				<?php
				
					foreach($getPODetails as $row)
					{
						?>
						  
					  <tbody>
						<tr>
							<td> <?php echo $row['ReqNum'];?> </td>
							<td> <?php echo $row['PO_Supplier'];?> </td>
							<td> <?php echo $row['ItemName'];?> </td>
							<td> <?php echo $row['ItemDesc'];?> </td>
							<td> <?php echo $row['ItemUnit'];?> </td>
							<td> <?php echo $row['ItemSize'];?> </td>
							<td> <?php echo $row['ItemQty'];?> </td>
							<td> <?php echo $row['ItemCost'];?> </td>
							<td> <?php echo $row['Total_Cost'];?> </td>
							
						</tr>
						
					  </tbody>
					  <?php
					}
				}
				else
				{
					echo "No Record Found";
				}
				?>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-sm">
				<?php
				if($getPODetails)
				{
					foreach($getPODetails as $row)
					{
						if($row['Vatsale'] !=='0')
						{
							?>
							<tbody>
								<tr>
									<td style="text-align: right;"> <b>Vatable </b> </td>
									<td style="padding-left:10%"> <?php echo $row['Vatsale'];?> </td>
								</tr>
							</tbody>
							<tbody>
								<tr style>
									<td style="text-align: right;"><b> Value Added Tax</b> </td>
									<td style="padding-left:10%"> <?php echo $row['AddedTax'];?> </td>
								</tr>
							</tbody>
							<tbody>
								<tr>
									<td style="text-align: right"> <b>Total Amount</b> </td>
									<td style="padding-left:10%"> <?php echo $row['TotalAmount'];?></td>
								</tr>
							</tbody>
							<?php
						}
						?>
						<?php
						if($row['NonVAt'] !== '0')
						{
							?>
							<tbody>
								<tr>
									<td style="text-align: right"> <b>NON-VATABLE </b> </td>
									<td style="padding-left:10%"> <?php echo $row['NonVAt'];?> </td>
								</tr>
							</tbody>
							<tbody>
								<tr>
									<td style="text-align: right"> <b>TOTAL AMOUNT </b> </td>
									<td style="padding-left:10%"> <?php echo $row['TotalWNVAt'];?> </td>
								</tr>
							</tbody>
							<?php
						}
						?>
						<?php
						}
					}
					else
					{
						echo "No Record Found";
					}
					?>
				</table>
			</div>
			<div style="float: left; margin-left: 12px">
				<button type="button" class="btn btn-danger" title="back" style="width:95px;" onclick="backButton('<?=$locstatus?>')"> <i class="fas fa-arrow-left"></i> BACK </button>
			</div>
			<?php if($getPODetails){ ?>
			<div style="float: right; margin-right: 13px">
				<a href="<?=site_url()?>poattachments"><button type="submit" name="viewimages" class="btn btn-info" data-toggle="modal" data-target="#attachmentModal"><i class="fas fa-folder-open"></i>
					ATTACHMENTS
				</button></a>
				<?php if ($locstatus !=='cancellpo') { ?>
					<button type="button" class="btn btn-success approvedbtn" title="approve" data-toggle="modal" data-target="#statusModal"> APPROVE </button>
					<button type="button" class="btn btn-secondary approvedbtn" title="return"  data-toggle="modal" data-target="#statusModal" style="width:95px;"> RETURN </button>
					<button type="button" class="btn btn-danger approvedbtn" title="reject"  data-toggle="modal" data-target="#statusModal" style="width:95px;"> REJECT </button>
				<?php } ?>
			</div>
			<?php } ?>
	</div>
<!-- /.container-fluid -->

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="formStatus">
				<div class="modal-body">
					<div class="form-group">
						<label>PO_Number</label>
						<input type="hidden" name="statustype" id="statustype" >
						<input type="text" name="po_no" value="<?php echo $row['PO_Number']; ?>" class="form-control" readonly>
					</div>
					<div class="form-group">
						<label>Remarks</label>
						<textarea class="form-control" id="remarks" name="remarks"  rows="3"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
					<button type="submit" name="approveddata" class="btn btn-primary">YES</button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>

		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/po.js'); ?>"></script>
