<!-- Begin Page Content -->

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->

<style type="text/css">
	@media screen {
		#printSection {
			display: none;
		}
	}

	@media print {
		body * {
		visibility:hidden;
		}
		#printSection, #printSection * {
		visibility:visible;

		}
		#printSection {
		position:absolute;
		left:0;
		top:0;
		}
		span{
			font-size: 15pt;
		}
		.large{
			font-size: 17pt;
		}
		p {
			font-size: 12pt;
		}

	}

	.img{
	width: 90%;
	margin-top: 10px;
	margin-left: 20px;
	margin-right:auto;
	}

	.png{
	width: 100%;
	margin-top: 10px;
	margin-left: auto;
	margin-right:auto;
	}
	#thead{
	padding: 10px;

	}
	.row{
	margin-left: 3%;
	margin-right: 3%;

	}
	.morespace{
		margin-bottom: 5%;
	margin-top: 58%;

	}
	.pulloutspace{
		margin-bottom: 5%;
	margin-top: 40%;

	}
	em#amount-error {
		position: absolute !important;
    	margin-left: -110px !important;
    	margin-top: -26px !important;
	}
	.badge {
		position: relative;
		top: -20px;
		left: -25px;
		border: 1px solid black;
		border-radius: 50%;
	}
	button {
		margin:5px;
	}
</style>

<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<div class="memo"  style="margin-top: 20px; margin-left: -68px; margin-right: -50px">
	<?=$addMemo()?>
	<p>
		<table id="memoTable" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>TYPE</th>
					<th>SUBJECT</th>
					<th>DESCRIPTION</th>
					<th style="width: 150px">APPROVER</th>
					<th>VIEW</th>
					<th style="width: 90px !important;r">VIEWED BY </th>
					<th>POSTED</th>
					<th style="width: 50px !important"></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($memoList as $memo) {
						echo '<tr>';
							echo '<td>'.$memo['name'].'</td>';
							echo '<td>'.substr($memo['memo_name'],0,20).'...</td>';
							echo '<td>'.substr($memo['memo_description'],0,20).'...</td>';
							echo '<td>'.$approverList($memo['memo_id']).'</td>';
							$file = site_url('public/memo/'.$memo['memo_attachment']);
							$viewbtn = '';
							$viewerbtn = '';
							if($memo['memo_status'] == 1 && $memo['approved'] == 1) {
								$viewbtn = '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#forprintmodal" onclick="memoPrintModal('.$memo["memo_id"].')"><i class="fa fa-eye" title="View Memo"></i></button><span style="display: block;
								font-size: 9px;"><b>Expiry: </b>'.$memo['memo_expiry'].'</span>';
								$viewerbtn = '<span id="group">
												<button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewedbyModal" onclick="getMemoType('.$memo["memo_type"].','.$memo["memo_id"].')" title="View Memo">
												<i class="fa fa-user"></i>
												</button>
												<span class="badge badge-light">'.$viewMemoCnt($memo["memo_id"]).'</span>
											</span>';
							} else {
								if ($designationID == '13' || $designationID == '17'  || $designationID == '44') {
									$viewbtn = '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#forprintmodal" onclick="memoPrintModal('.$memo["memo_id"].')"><i class="fa fa-eye" title="View Memo"></i></span></button>';
									$viewerbtn = '<span id="group">
												<button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewedbyModal" onclick="getMemoType('.$memo["memo_type"].','.$memo["memo_id"].')" title="View Memo">
												<i class="fa fa-user"></i>
												</button>
												<span class="badge badge-light">'.$viewMemoCnt($memo["memo_id"]).'</span>
											</span><span>';
								}
							}
							echo '<td>'.$viewbtn.'</td>';
							echo '<td style="text-align: center">'.$viewerbtn.'</td>';
							echo '<td>'.$memo['memo_created'].'</td>';
							$delbtn = '';
							if ($designationID == '44') {
								$delbtn = '<i class="fa fa-trash" onclick="removeMemo('.$memo["memo_id"].')"></i>';
							}
							if ($designationID == '13' || $designationID == '17') {
								if ($designationID == 13) {
									if($memo['verified'] == 0 && $memo['approved'] == 0) {
										$delbtn='<span style="display: block"><button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 2px" data-toggle="modal" data-target="#memoConfirmStatModal" onclick="confirmMemo(1,'.$memo['memo_id'].')"><i class="fa fa-check">Approved</i> </button> <button type="button" class="btn btn-danger btn-sm" onclick="confirmMemo(2,'.$memo['memo_id'].')" data-toggle="modal" data-target="#memoConfirmStatModal" ><i class="fa fa-times"> Reject</i> </button></span>';
									}
								} else {
									if($memo['verified'] == 1 && $memo['approved'] == 0) {
										$delbtn='<span style="display: block"><button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 2px" data-toggle="modal" data-target="#memoConfirmStatModal" onclick="confirmMemo(1,'.$memo['memo_id'].')"><i class="fa fa-check">Approved</i> </button> <button type="button" class="btn btn-danger btn-sm" onclick="confirmMemo(2,'.$memo['memo_id'].')" data-toggle="modal" data-target="#memoConfirmStatModal" ><i class="fa fa-times"> Reject</i> </button></span>';
									}
								}
							}
							echo '<td>'.$delbtn.'</td>';
						echo '</tr>';

					}
				?>
			</tbody>
		</table>
	</p>
		<!-- My Leave -->
		<!-- Modal -->
		<!-- Create Memo -->
		<div class="modal fade" id="addMemoModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Create Memo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmmemo">
						<div class="row">
							<div class="col-md-6">
								<label for="refnum" class="col-sm-6 col-form-label">Type</label>
								<div class="col-sm-12">
										<?php
											echo '<select class="form-control" id="memotype" name="memotype"><option value=""> </option>';
											foreach($memotype as $memo) {
												echo '<option value="'.$memo['typeid'].'">';
													echo $memo['name'];
													echo '</option>';
											}	
											echo '</select>'; 
										?>
								</div>
							</div>
							<div class="col-md-6">
								<label for="refnum" class="col-sm-6 col-form-label">Expiry</label>
								<div class="col-sm-12">
									<input type="text" class="form-control"  id="expiry" name='expiry'>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="refnum" class="col-sm-6 col-form-label">Subject</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="subject" name='subject'>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="refnum" class="col-sm-6 col-form-label">Memo body</label>
								<div class="col-sm-12" style="margin-bottom: 10px">
									<div id="memobody"></div>
								</div>
							</div>
						</div>
						<div class="row" id="successAlertStat"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
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
		<h5 class="modal-title" id="exampleModalLabel"><span id="memoTypeT"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="memoModal()"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel"></h4>
      </div>
    
      <!-- Modal Body -->  
      <div class="modal-body">
        <div class="body-message">
			<style>
				table#inside, table#inside th, table#inside td {
					border: 1px solid black;
				}
			</style>
        	<div id="printThis" style="font-family: New Times Roman;">
        		<div class="template" style="border: 2px solid #6d3f6c" >
        			<div class="row">
						<table id="inside" style="width:100%; border: 1px solid; margin-top: 20px; font-size:12px;     margin-bottom: 30px;">
							<tr>
								<th rowspan="3" style="width:65%"><img src="<?php echo site_url('public/img/memo_header.jpg') ?>" class="img" style="widht: 90%"/></th>
								<td><span style="margin-left: 5px;">FORM NO.</span></td>
								<td style="text-align: center">F-74-01</td>
							</tr>
							<tr>
								<td><span style="margin-left: 5px;">REV.</span></td>
								<td style="text-align: center">01</td>
							</tr>
							<tr>
								<td><span style="margin-left: 5px;">DATE</span></td>
								<td style="text-align: center">09/14/2019</td>
							</tr>
						</table>
        			</div>	
        			<div class="row" style="margin-bottom: 10px">
        				<div class="col">
							To <span style="margin-left: 70px;">:</span> <span style="margin-left: 45px;"> All CGSI Employees (Admin) </span>
        				</div>
        			</div>
					<div class="row" style="margin-bottom: 10px">
        				<div class="col">
							Date <span style="margin-left: 53px;">:</span> <span style="margin-left: 45px;" id="memoDate"></span>
        				</div>
        			</div>
					<div class="row" style="margin-bottom: 10px">
        				<div class="col">
							Subject <span style="margin-left: 34px;">:</span> <span style="margin-left: 45px; font-weight: bold; font-size: 14px" id="memoSubject"></span>
        				</div>
        			</div>
        			<div class="row row-centered">
        				<div class="col">
							<div id="memoPrintBody" style="margin-top: 50px;font-size: 16px"></div>
        				</div>
        			</div>
					<!-- class="morespace" -->
        			<div class="morespace">
        				<div class="row" >
        					<div class="col" >
        						<span>Prepared by:</span>
								<img style="height: 100px;position: absolute;margin-top: 7px;left: 35px;" src="<?php echo site_url('public/img/zyrasig.png') ?>" />
								<span style="display: block; display: block; margin-top: 40px; font-weight: bold;">MS. ZYRA T. GABUYA</span>
								<span>HR-ER Section Head</span>
        					</div>
        				</div>
        				<div class="row">
							<table id="inside" style="width:100%; border-top: 1px solid; margin-top: 20px; font-size:9px; margin-bottom: 30px; font-family: tahoma">
								<tr>
									<th rowspan="2" style="width:35%; text-align: center">
										<span style="font-size: 15px">MANAGEMENT SYSTEM</span>
										<span style="font-size: 15px; display: block"> COMMUNICATION</span>
									</th>
									<td style="text-align: center; width: 220px;"><span style="margin-left: 3px; font-style: italic; font-weight: bold">MS. MA.FARAH B. AMAYA-PARAN</span>
										<img style="height: 75px;position: absolute;margin-top: -6px;left: 327px;" src="<?php echo site_url('public/img/farahsig.png') ?>" />
										<br>
										<br><br>
									</td>
									<td rowspan="2" style="text-align: center; width: 95px;">HR MANAGER</td>
									<td rowspan="2" style="text-align: center"><span style="margin-left: 5px;">Page 1</span></td>
								</tr>
								<tr>
									<td style="text-align: center">NOTED</td>
								</tr>
								<tr>
									<td rowspan="2" style="text-align: center;font-weight: bold;padding: 10px;">INTERNAL COMPANY MEMORANDUM</td>
									<td style="text-align: center"><span style="margin-left: 3px; font-style: italic; font-weight: bold">MS. GRACE S. ILIGAN</span>
										<img style="height: 51px;position: absolute;margin-top: 6px;left: 352px;" src="<?php echo site_url('public/img/gracesig.png') ?>" />
										<br><br><br></td>
									<td rowspan="2" style="text-align: center">PRESIDENT</td>
									<td rowspan="2" style="text-align: center"><span style="margin-left: 5px;">Documentary stamp</span></td>
								</tr>
								<tr>
									<td style="text-align: center">APPROVED BY:</td>
								</tr>
							</table>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
			<div id="addAmountDiv" style="display: none; position: absolute; right: 297px;">
				<form id="frmContri">
					<div class="row">
						<div class="col-md-12">
							<div class="col-sm-12">
								<input type="hidden" class="form-control" id="memo_id" name='memo_id'>
								<input type="number" class="form-control" placeholder="Add amount" id="amount" name='amount'>
								<button type="submit" style="float: right;margin-top: 4px; margin-top: 4px;position: absolute;right: -55px;top: -5px;" class="btn btn-primary">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<button type="button" class="btn btn-primary" style="display: none" id="contribution"><i class="fa fa-plus"></i> Add Amount</button>
			<?php if ($idnumber == '300261'){?>
        	<button id="btnPrint" type="button" class="btn btn-primary">Print</button>
			<?php } ?>
        </div>
      </div>
      <!-- Modal Content: ends -->
    </div>
  </div>
</div>

<!-- PRINTINGGG  --> 
<div id="viewedbyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">
    
    <!-- Modal Content: begins -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Viewed By List <span id="memoTypeT"></span></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="gridSystemModalLabel"></h4>
      </div>
    
      <!-- Modal Body -->  
      <div class="modal-body">
        <div class="body-message">
			<br><br>
        	<div id="viewByDiv1" style="margin-top:50px">
				<table id="contriTable1" class="table table-striped" style="width:100%"></table>
        	</div>
			<div id="viewByDiv2" style="margin-top:50px">
				<table id="contriTable2" class="table table-striped" style="width:100%"></table>
			</div>
        </div>
      </div>
      <!-- Modal Content: ends -->
    </div>
  </div>
</div>

<div class="modal fade" id="memoConfirmStatModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Confirm Memo ?</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" id="memoID">
					<input type="hidden" id="approveCancel">
					Are you sure you want to <span id="lblConfirm"></span> this memo.
					<textarea id="rejectReason" class="form-control" placeholder="REASON"></textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary" onclick="confirmMemoSubmit()">Submit</button>
		</div>
	</div>
</div>

<!-- /.container-fluid -->
<script src="<?= site_url('public/vendor/jquery/jquery.min.js'); ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/memo.js'); ?>"></script>