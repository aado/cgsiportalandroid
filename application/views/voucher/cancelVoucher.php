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
						<a class="nav-item nav-link active" id="nav-cancelledvisayas-tab" data-toggle="tab" href="#nav-cancelledvisayas" role="tab" aria-controls="nav-cancelledvisayas" aria-selected="true">
							VISAYAS
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-item nav-link" id="nav-cancelledluzon-tab" data-toggle="tab" href="#nav-cancelledluzon" role="tab" aria-controls="nav-cancelledluzon" aria-selected="false">
							LUZON
						</a>
					</li>
				</ul>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-cancelledvisayas" role="tabpanel" aria-labelledby="nav-cancelledvisayas-tab">
						<br>
						<div class="table-responsive">
							<table id="datatableid_Cancelledvisayas" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
										<th scope="col" style="width:10%;" >Entry Date</th>
										<th scope="col" style="width:8%;">Po no.</th>
										<th scope="col"> Supplier</th>
										<th scope="col"> Remarks </th>
										<th scope="col"> Note </th>
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POCancelled_Visayas) ){
										foreach ($POCancelled_Visayas as $POVC) {
											?>
											<tr>
												<td> <?= $POVC['Entry_Date'];?> </td>
												<td> <?= $POVC['PO_Number'];?> </td>
												<td> <?= $POVC['PO_Supplier'];?> </td>
												<td> <?= $POVC['PO_Remarks'];?> </td>
												<td> <?= $POVC['Note'];?> </td>
												<td>
													<form action="requestsviewattcm_canceledLuzon.php" method="POST">
														<input type="hidden" name="reqnumno" value="<?php echo $POVC['PO_Number'];?>" class="form-control">
														<button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i>
															VIEW 
														</button>
													</form>	<!--!-->
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
					<div class="tab-pane fade" id="nav-cancelledluzon" role="tabpanel" aria-labelledby="nav-cancelledluzon-tab">
						<br>
						<div class="table-responsive">
							<table id="datatableid_CancelledLuzon" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
										<th scope="col" style="width:10%;" >Entry Date</th>
										<th scope="col" style="width:8%;">Po no.</th>
										<th scope="col"> Supplier</th>
										<th scope="col"> Remarks </th>
										<th scope="col"> Note </th>
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POCancelled_Luzon) ){
										foreach ($POCancelled_Luzon as $POLC) {
											?>
											<tr>
												<td> <?= $POLC['Entry_Date'];?> </td>
												<td> <?= $POLC['PO_Number'];?> </td>
												<td> <?= $POLC['PO_Supplier'];?> </td>
												<td> <?= $POLC['PO_Remarks'];?> </td>
												<td> <?= $POLC['Note'];?> </td>
												<td>
													<form action="requestsviewattcm_canceledLuzon.php" method="POST">
														<input type="hidden" name="reqnumno" value="<?php echo $POLC['PO_Number'];?>" class="form-control">
														<button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i>
															VIEW 
														</button>
													</form>	<!--!-->
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
<script src="<?= site_url('public/js/po.js'); ?>"></script>
