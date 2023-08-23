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
						<a class="nav-item nav-link active" id="nav-historyvisayas-tab" data-toggle="tab" href="#nav-historyvisayas" role="tab" aria-controls="nav-historyvisayas" aria-selected="true">
							VISAYAS
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-item nav-link" id="nav-historyluzon-tab" data-toggle="tab" href="#nav-historyluzon" role="tab" aria-controls="nav-historyluzon" aria-selected="false">
							LUZON
						</a>
					</li>
				</ul>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-historyvisayas" role="tabpanel" aria-labelledby="nav-historyvisayas-tab">
						<br>
						<div class="table-responsive">
							<table id="voucherhistory_visayas" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
										<th scope="col" style="width:12%;">Entry Date</th>
										<th scope="col" style="width:12%;">Voucher no.</th>
										<th scope="col" >Payee</th>
										<th scope="col" >Status</th>
										<th scope="col" > Remarks </th>  
										<th scope="col" > StatusByReceiver </th>		
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($VoucherVisayas_history) ){
										foreach ($VoucherVisayas_history as $VVH) {
											?>
											<tr>
												<td> <?= $VVH['Entry_Date'];?> </td>
												<td> <?= $VVH['Voucher_Num'];?> </td> 
												<td> <?= $VVH['Payee'];?> </td>
												<td> <?= $VVH['Voucher_Stat'];?> </td>
												<td> <?= $VVH['Remarks'];?> </td>
												<td> <?= $VVH['StatusByReceiver'];?> 
												<td>
													<a href="voucherdetails/<?php echo $VVH['Voucher_Num'];?>/1"><button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i> VIEW 
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
					<div class="tab-pane fade" id="nav-historyluzon" role="tabpanel" aria-labelledby="nav-historyluzon-tab">
						<br>
						<div class="table-responsive">
							<table id="datatableidLuzon" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
										<th scope="col" style="width:12%;">Entry Date</th>
										<th scope="col" style="width:12%;">Voucher no.</th>
										<th scope="col" >Payee</th>
										<th scope="col" >Status</th>
										<th scope="col" > Remarks </th>  
										<th scope="col" > StatusByReceiver </th>		
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($VoucherLuzon_history) ){
										foreach ($VoucherLuzon_history as $VL) {
											?>
											<tr>
												<td> <?= $VL['Entry_Date'];?> </td>
												<td> <?= $VL['Voucher_Num'];?> </td> 
												<td> <?= $VL['Payee'];?> </td>
												<td> <?= $VL['Voucher_Stat'];?> </td>
												<td> <?= $VL['Remarks'];?> </td>
												<td> <?= $VL['StatusByReceiver'];?> 
												<td>
													<a href="voucherdetails/<?php echo $VL['Voucher_Num'];?>/2"><button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i> VIEW 
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
