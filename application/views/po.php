<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<style>
	table.table-bordered {
		border:1px solid black;
		margin-top:20px;
	}
	table.table-bordered th {
		border:1px solid black;
		margin-top:20px;
	}
	table.table-bordered > thead > tr > th {
		border:1px solid black;
	}
	table.table-bordered > tbody > tr > td {
		border:1px solid black;
	}
	th, td {
		padding-top: 10px;
		padding-bottom: 20px;
		padding-left: 30px;
		padding-right: 40px;
	}
	.attachment img {
		width: 200px;
		height: 200px;
		margin: 10px;
	}
</style>
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
			<div class="col-md-12">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-item nav-link active"  id="nav-visayas-tab" data-toggle="tab" href="#nav-visayas" role="tab" aria-controls="nav-visayas" aria-selected="true">VISAYAS </a>
					</li>
					<li class="nav-item">
						<a class="nav-item nav-link" id="nav-luzon-tab" data-toggle="tab" href="#nav-luzon" role="tab" aria-controls="nav-luzon" aria-selected="false">LUZON</a>
					</li>
				</ul>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-visayas" role="tabpanel" aria-labelledby="nav-visayas-tab">
						<br>
						<div class="table-responsive">
							<table id="datatableidreceived" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
										<th scope="col" style="width:17%;">Entry Date</th>
										<th scope="col" style="width:10%;">Po no.</th>
										<th scope="col" >Supplier</th>
										<th scope="col" > Remarks </th>
										<?php if ($lasturl == 'recievedpo') { ?>
											<th scope="col" > Note </th>
										<?php }?>
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POVisayas) ){
										// print_r($POVisayas);
									foreach ($POVisayas as $POV) {
									?>
									
											<tr>
												<td>
													<?php if ($lasturl == 'recievedpo') { ?>
														<?=  $POV['Entry_Date'] ?>
													<?php } else { ?>
														<?=($getEntryDate($POV['PO_Number'],'Vis')); ?>
													<?php } ?>
												</td>
												<td> <?=  $POV['PO_Number'] ?> </td>
												<td> <?=  $POV['PO_Supplier'] ?> </td>
												<td>
												<?php if ($lasturl == 'recievedpo') { ?>
													<?=  $POV['PO_Remarks'] ?>
												<?php } else { ?>
													<?=($getRemarks($POV['PO_Number'],'Vis',$POV['PO_Status'])); ?> 
												<?php } ?>
												</td>
												<?php if ($lasturl == 'recievedpo') { ?>
													<td><?=  $POV['Note'] ?></td>
												<?php } ?>
												<td class="details-control" data-site='1'>
												<button type="submit" name="viewrequest" class="btn btn-info">
													<i class="fas fa-th-list"></i> VIEW 
												</button>
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
					<div class="tab-pane fade" id="nav-luzon" role="tabpanel" aria-labelledby="nav-luzon-tab">
						<br>
						<div class="table-responsive">
							<table id="datatableidLuzon" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
										<th scope="col" style="width:10%;">Entry Date</th>
										<th scope="col" style="width:10%;">Po no.</th>
										<th scope="col" >Supplier</th>
										<th scope="col" > Remarks </th>	
										<?php if ($lasturl == 'recievedpo') { ?>
											<th scope="col" > Note </th>
										<?php }?>
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POLuzon) ){
										foreach ($POLuzon as $POL) {
									?>
									
											<tr>
												<td><?php if ($lasturl == 'recievedpo') { ?>
														<?=  $POL['Entry_Date'] ?>
													<?php } else { ?>
														<?=($getEntryDate($POL['PO_Number'],'Vis')); ?>
													<?php } ?> </td>
												<td> <?= $POL['PO_Number'] ?> </td>
												<td> <?= $POL['PO_Supplier'] ?> </td>
												<td>
												<?php if ($lasturl == 'recievedpo') { ?>
													<?=  $POL['PO_Remarks'] ?>
												<?php } else { ?>
													<?=($getRemarks($POL['PO_Number'],'Vis',$POL['PO_Status'])); ?> 
												<?php } ?>
												</td>
												<?php if ($lasturl == 'recievedpo') { ?>
													<td><?=  $POL['Note'] ?></td>
												<?php } ?>
												<td class="details-control" data-site='2'>
													<button type="submit" name="viewrequest" class="btn btn-info">
														<i class="fas fa-th-list"></i> VIEW 
													</button>
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
											<label>Supplier</label>
											<span style="display: block; font-weight: bold" id="POSupplier"></span>
										</div>
										<div class="form-group">
											<label>PO Number</label>
											<input type="hidden" name="statustype" id="statustype" >
											<input type="text" id="po_no" name="po_no" class="form-control" readonly>
										</div>
										<div class="form-group">
											<label>Remarks</label>
											<textarea required="required" class="form-control" id="remarks" name="remarks"  rows="3"></textarea>
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
<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/po.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
	Fancybox.bind('[data-fancybox="gallery"]', {
        //
      });  
</script>
