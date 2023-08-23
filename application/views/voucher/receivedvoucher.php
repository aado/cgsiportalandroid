<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container-fluid">
	
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>

<div class="card">
		<div class="card-body">	
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
							<table id="voucherreceived_visayas" class="table table-striped" width="100%">
				 			<thead>
				 				<tr>
				 				 <th scope="col" style="width:12%;">Entry Date</th>
				 				 <th scope="col" style="width:15%;">Voucher no.</th>
				 				 <th scope="col"> Payee</th>
				 				 <th scope="col"> Remarks </th>
				 				 <th scope="col"> Note </th>
				 				 <th scope="col">  </th>
				 				</tr>
				 			</thead>
				 			<tbody>
				 				<?php
						 			if(isset($VoucherVisayas) )
						 			{
						 				foreach ($VoucherVisayas as $VVR) 
						 				{
											?>
							 				<tr>
							 					<td> <?= $VVR['Entry_Date'];?> </td>
							 					<td> <?= $VVR['Voucher_Num'];?> </td>
							 					<td> <?= $VVR['Payee'];?> </td>
							 					<td> <?= $VVR['Remarks'];?> </td>
							 					<td> <?= $VVR['Note'];?> </td>
							 					<td>
							 						<a href="voucherdetails/<?php echo $VVR['Voucher_Num'];?>/1">
							 							<button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i> VIEW </button>
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
					<div class="tab-pane fade" id="nav-luzon" role="tabpanel" aria-labelledby="nav-luzon-tab">
						<br>
						<div class="table-responsive">
							<table id="voucherreceived_luzon" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
										<th scope="col" style="width:12%;">Entry Date</th>
						 				<th scope="col" style="width:15%;">Voucher no.</th>
						 				<th scope="col"> Payee</th>
						 				<th scope="col"> Remarks </th>
						 				<th scope="col"> Note </th>
						 				<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($VoucherLuzon) ){
									foreach ($VoucherLuzon as $gv) {
									?>
											<tr>
												<td> <?= $gv['Entry_Date'];?> </td>
							 					<td> <?= $gv['Voucher_Num'];?> </td>
							 					<td> <?= $gv['Payee'];?> </td>
							 					<td> <?= $gv['Remarks'];?> </td>
							 					<td> <?= $gv['Note'];?> </td>
												<td>
													<a href="voucherdetails2/<?php echo $gv['PO_Number'];?>/2"><button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i> VIEW 
													</button></a>
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
			</div>
		</div>
	</div> 
</div>
<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/voucher.js'); ?>"></script>
