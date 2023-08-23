<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>

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
							<table id="datatableidhistory_visayas" class="table table-striped" style="width: 100%;">
								<thead>
									<tr>
									<th scope="col" style="width:10%">Entry Date</th>
										<th scope="col"> PO NO.</th>
										<th scope="col"> Supplier</th>
										<th scope="col"> Status</th>
										<th scope="col"> Remarks </th>
										<th scope="col"> Total Amount</th>
										<th scope="col"> StatusByReceiver </th>
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POHistory_Visayas) ){
										foreach ($POHistory_Visayas as $POVH) {
											?>
											<tr>
												<td><?= $POVH['Entry_Date'];?> </td>
												<td> <?= $POVH['PO_Number'];?> </td>
												<td> <?= $POVH['PO_Supplier'];?> </td>
												<td> <?= $POVH['PO_Status'];?> </td>
												<td> <?= $POVH['PO_Remarks'];?> </td>
												<td> <?= $POVH['Total_Cost'];?> </td>
												<td> <?= $POVH['StatusByReceiver'];?></td>
												<td>
													<a href="podetails/<?php echo $POVH['PO_Number'];?>/1"><button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i> VIEW 
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
										<th scope="col" style="width:10%">Entry Date</th>
										<th scope="col">PO NO.</th>
										<th scope="col">Supplier</th>
										<th scope="col">Status</th>
										<th scope="col"> Remarks </th>
										<th scope="col"> Total Amount</th>
										<th scope="col"> StatusByReceiver </th>
										<th scope="col">  </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(isset($POHistory_Luzon) ){
										foreach ($POHistory_Luzon as $POLH) {
											?>
											<tr>
												<td><?= $POLH['Entry_Date'];?> </td>
												<td> <?= $POLH['PO_Number'];?> </td>
												<td> <?= $POLH['PO_Supplier'];?> </td>
												<td> <?= $POLH['PO_Status'];?> </td>
												<td> <?= $POLH['PO_Remarks'];?> </td>
												<td> <?= $POLH['Total_Cost'];?> </td>
												<td> <?= $POLH['StatusByReceiver'];?></td>
												<td>
													<a href="podetails/<?php echo $POLH['PO_Number'];?>/2"><button type="submit" name="viewrequest" class="btn btn-info"><i class="fas fa-th-list"></i> VIEW 
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
<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/po.js'); ?>"></script>
