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
						<a class="nav-item nav-link active" id="nav-returnedvisayas-tab" data-toggle="tab" href="#nav-returnedvisayas" role="tab" aria-controls="nav-returnedvisayas" aria-selected="true">VISAYAS </a>
					</li>
					<li class="nav-item">
						<a class="nav-item nav-link" id="nav-returnedluzon-tab" data-toggle="tab" href="#nav-returnedluzon" role="tab" aria-controls="nav-returnedluzon" aria-selected="false">
						LUZON </a>
					</li>
				</ul>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-returnedvisayas" role="tabpanel" aria-labelledby="nav-returnedvisayas-tab">
						<br>
						<div class="table-responsive">
							<table id="datatableidreturned_visayas" class="table table-striped" style="width: 100%;">
								<br>
								<thead>
									<tr>
										<th scope="col" >Date</th>
										<th scope="col" >PO NO.</th>
										<th scope="col" >Supplier</th>
										<th scope="col" >Remarks</th>
										<th scope="col" ></th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POLuzon) ){
									foreach ($POVisayas as $POV) {
									?>
									<tr>
										<td> <?= $POV['Entry_Date'] ?> </td>
										<td> <?= $POV['PO_Number'] ?> </td>
										<td> <?= $POV['PO_Supplier'] ?> </td>
										<td> <?= $POV['PO_Remarks'] ?> </td>
										<td> <?= $POV['Note'] ?> </td>
										<td>
											<form action="requestsview.php" method="POST">
												<input type="hidden" name="reqnumno" value="<?php echo $POV['PO_Number'];?>" class="form-control">
												<input type="hidden" name="app_id" value="e5217763-fdd9-4af7-ba82-a236b613a0a9">
												<input type="hidden" name="user_id" id="user_id">
												<button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i> VIEW 
												</button>
											</form>
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
					<div class="tab-pane fade" id="nav-returnedluzon" role="tabpanel" aria-labelledby="nav-returnedluzon-tab">
						<br>
						<div class="table-responsive">
							<table id="datatableidreturned_luzon" class="table table-striped" style="width: 100%;">
								<br>
								<thead>
									<tr>
										<th scope="col" >Date</th>
										<th scope="col" >PO NO.</th>
										<th scope="col" >Supplier</th>
										<th scope="col" >Remarks</th>
										<th scope="col" ></th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POLuzon) ){
									foreach ($POLuzon as $POL) {
									?>
											<tr>
												<td> <?= $POL['Entry_Date'];?> </td>
												<td> <?= $POL['PO_Number'];?> </td>
												<td> <?= $POL['PO_Supplier'];?> </td>
												<td> <?= $POL['PO_Remarks'];?> </td>
												<td>
													<form action="requestviewattcm_returnedLuzon.php" method="POST">
														<input type="hidden" name="reqnumno" value="<?php echo $POL['PO_Number'];?>" class="form-control">
														<input type="hidden" name="user_id" id="user_id">
														<button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i>
															VIEW
														</button>
													</form>
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
