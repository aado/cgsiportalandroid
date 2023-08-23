<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Voucher Details</h1>


	<div class="content">
			<?php
 			if($voucherdetails)
 			{
 				foreach($voucherdetails as $row)
 				{
 					echo '<span class="text-sm text-grey-m2 align-middle" style="color:white">'.$row['Voucher_Num'].'</span>';		
			?>
			<div class="card">
 				<div class="card-body" style="background-color: #FFE4FA;border:1px solid;" oncopy="return false" onpaste="return false" oncut="return false"> 
 					<div class="row" style="border-bottom:1px solid;">
 						<div class="col-md-auto">
 							<img class="img" src="<?= site_url('public/img/voucher/cashvoucher.png');?>"  height="100" width="550">
 						</div>
 						<div class="col">
 							<span>
 								<p style="font-size: 22px;font-weight: 700;text-align: right;">
 									CV No.
 								</p>
 							</span>
 							<span style="position: absolute; bottom: 0; right: 0">
								<p>Date:</p>
 							</span>
 						</div>
 						<div class="col">
 							<span>
 								<p style="font-size: 22px;font-weight: 700;text-align: LEFT;margin-left: -20px;color:red">
									<?php echo $row['Voucher_Num'];?>
 								</p>
 							</span>
							<span style="position: absolute; bottom: 0; left: 0;color: #586e98">
								<p><u> <?php echo date('F d Y',strtotime(explode(' ',$d['approvedate'])[0]))?> 	</u></p>
							</span>
						</div>
 					</div>
 					<div class="row" style="font-weight: 700;border-bottom: 1px solid;">
 						<div class="col-8">
 							<span style="font-size: 16px;"> PAID TO:</span> 
 							<span style="font-size: 16px;color: #586e98;"> 
 								<?php echo $row['Payee'];?> 
 							</span>
 						</div>
						<div class="col" style="border-left:1px solid;">
							<span class="text-center" style="font-size: 16px;margin-left: 45%;"> AMOUNT </span> 
						</div>
					</div>
					<div class="row" style="margin-bottom: 25px!important;font-weight: 700;">
	 					<div class="col">
	 						<span style="font-size: 14px;color: #586e98;margin-left: 20px;"> 
 								<?php echo $row['PO_Particular'];?> 
 							</span>
	 					</div>
	 				</div>	
	 				<table class="table table-borderless table-sm" style="width:100%" >
 						<tr>
						    <th scope="col"></th>
						    <th scope="col" style="width: 150px;color: #586e98;font-size: 12px;">
							    <u>E</u> <u>N</u> <u>T</u> <u>R</u> <u>I</u> <u>E</u> <u>S</u></th>
							<th scope="col" style="text-align:center;width: 150px;color: #586e98;font-size: 12px;">
							    <u>D</u> <u>E</u> <u>B</u> <u>I</u> <u>T</u></th>
							<th scope="col" style="text-align:center;width: 150px;color: #586e98;font-size: 12px;">
							    <u>C</u> <u>R</u> <u>E</u> <u>D</u> <u>I</u> <u>T</u></th>
						</tr>
						<?php
 							if($voucherdetails2)
 							{
 								foreach($voucherdetails2 as $row2)
 								{	
								?>
								<tr>
 									<td></td>
 									<td style="color: #586e98;"> 
 										<?php echo $row2['Account_Code'];?>
 									</td>
 									<td style="text-align:center;color: #586e98;"> 
 									<?php 
 									$no = '';
 										if($row2['IsDebit'] =='Yes')
 										{
 											echo number_format($row2['Journal_Amount'], 2);
 										}
 									?> 
 									</td>
 									<td style="text-align:center;color: #586e98;"> 
 									<?php 
	 									$no = '';
	 									if($row2['IsDebit'] =='No')
	 									{
	 										echo number_format($row2['Journal_Amount'], 2);
	 									}
 									?> 
 									</td>
 								</tr>
 								<?php												
 								}
 							}
 						?>
 					</table>
 					<br>
 					<div class="row">
 						<div class="col-8">
 						</div>
 						<div class="col" style="border-top:1px solid #586e98;">
 							<span class="text-center" style="font-size: 14px;margin-left:80px;color:#586e98;text-align: right;">
 								<?php echo number_format( $row['Gross_Amount'], 2);?> 
 							</span> 
 						</div>
 						<div class="col" style="border-top:1px solid #586e98;">
 							<span class="text-center" style="font-size: 14px;margin-left: 45px;color:#586e98;;">
 								<?php echo number_format( $row['Gross_Amount'], 2);?>
 							</span> 
 						</div>
 					</div>
 					<div class="row" style="border-top:1px solid;">
 						<div class="col">
 							<span>
 								PAYMENT REF. :
 								<div class="form-check form-check-inline">
									<u>
									 	<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
										<label class="form-check-label" for="inlineCheckbox1"> 
											<u>Check</u>
										</label>
									</u>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
										<label class="form-check-label" for="inlineCheckbox2"> 
											<u>Debit Memo</u>
										</label>
								</div>
								<br>
								<span style="margin-left:15%;font-size: 12px;color: #586e98;">
									<?php echo $row['Bank_Name'];?>  <?php echo $row['Cheque_Num'];?> 
								</span>
 							</span>
 						</div>
 						<div class="col-6" style="border-left:1px solid;">
 							<span class="text-center" style="font-size: 16px;">
 								Received from <b>CEBU GENERAL SERVICES, INC.</b> the sum of Pesos
 							</span>
 							<hr style="background-color: black!important;margin-top:-2px;margin-bottom:-2px">
 								<span style="font-size: 12px;color: #586e98;padding-top: -10px;">
 								<?php 
 									//$netpayable = explode('.',$row['Gross_Amount'])[1];
									//if($netpayable == 0){
 									//	$netpayable = explode('.',$row['Gross_Amount'])[0];
 									//	$c = 'Pesos';
 										//}else
 										//{
 										//	$netpayable = $row['Gross_Amount'];
 										//	$c = '';
 										//}
 											//echo convert_number_to_words($netpayable) .' '.$c; ?>
 								</span>
 						</div>
 					</div>
 					<div class="row" style="border-top:1px solid;">
 						<div class="col col-lg-2"  style="padding-top: 15px!important">
 							<span>
 								Prepared by: 
 							</span>
						</div>
						<div class="col">
							<img class="img" src="<?= site_url('public/img/voucher/misslauron.png');?>" width="100" height="50" style="position: absolute;">	
							<!-- <img src="images/misslauron.png" width="100" height="50" style="position: absolute;">  -->
							<br>
							<span style="color: #586e98;">
								Jesille Marie L. Lauron
							</span>
						</div>
						<div class="col-6" style="border-left:1px solid;padding-top: 25px;">
							<span class="text-center" style="font-size: 16px;color: #586e98;">
								(P &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format( $row['Gross_Amount'], 2);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
							</span> 
							<span>
								in payment of above mentioned transaction
							</span>
						</div>
					</div>
					<div class="row" style="border-top:1px solid;">
 						<div class="col col-lg-2"  style="padding-top: 15px!important">
	 						<span>
 								Noted by: 
 							</span>
						</div>
						<div class="col">
						<br>
							<span style="color: #586e98;">
								R.HERAY
							</span>
						</div>
						<div class="col-6" style="border-left:1px solid;padding-top: 25px!important;">
							<span class="text-center" style="font-size: 18px;font-family: Brush Script MT;">
								Received by: ___________________________ Date: ______________
 							</span> 
 						</div>
 					</div>
 					<div class="row">
						<div class="col col-lg-2"  style="padding-top: 15px!important;border-top: 1px solid;">
 							<span>
 								Approved by: 
 							</span>
						</div>
						<div class="col" style="border-top: 1px solid">
							<!-- <img src="images/sigGrace.png" width="100" height="50" style="position: absolute;">  -->
						<br>
							<span style="color: #586e98;">
								G. ILIGAN
							</span>
						</div>
						<div class="col-6" style="border-left:1px solid; margin-top: -15px;">
							<span class="text-center" style="font-size: 10px;margin-left: 145px;">
							 (Signature Over Printed Name)
							</span> <br>
							<span style="margin-left: 100px;font-size: 16px;font-family: Brush Script MT;">
 								Official Receipt No. : _________________
 							</span>
 						</div>
 					</div>
 					<div class="row" style="border-top: 1px solid;">
 						<div class="col" style="text-align:left;font-weight: 700;">
 							<p style="font-size: 10px;font-weight: 700;"> F-851-57 Rev.1 </p>
 						</div>
 						<div class="col" style="text-align:right;">
 							<p style="font-size: 10px;font-weight: 700;"> September 14,2017</p>
 						</div>
 					</div>
 				</div>
 			</div>
			<?php
				}
			}
			?>

<style>
.container .gallery a img {
	float: left;
	width: 25%;
	height: auto;
	border: 5px solid #fff;
	-webkit-transition: -webkit-transform .15s ease;
	-moz-transition: -moz-transform .15s ease;
	-o-transition: -o-transform .15s ease;
	-ms-transition: -ms-transform .15s ease;
	transition: transform .15s ease;
	position: relative;
}
.clear {
	clear: both;
	}

a {
	color: #009688;
	text-decoration: none;
}

a:hover {
	color: #01695f;
	text-decoration: none;
}
</style>

	<h2 style="text-align:center;"> ATTACHMENTS </h2>
	<div class="container">
		<div class="gallery">
	  	<?php 
			if(isset($getpoattachments)){
				foreach($getpoattachments as $attachments)
				{									
					echo '<ul><h5>PO#: '.($attachments['PO_Number']).'</h5></ul> ';
				
					$filename=$attachments['PO_Number'];
						  // Image extensions
					$image_extensions = array("png","jpg","jpeg","gif","bmp");
						  // Target directory
				  	$dir_path = "uploads/".$filename;
                        // echo $dir_path;
				  if (is_dir($dir_path))
				  	{
				  		if ($dh = opendir($dir_path))
						  			{
						  				$count = 1;
						  					// Read files
						  				while (($file = readdir($dh)) !== false)
						  					{
						  						if($file != '' && $file != '.' && $file != '..')
						  						{
						  							$image_path = "uploads/$filename/".$file;
						  							$image_ext = pathinfo($image_path, PATHINFO_EXTENSION);
						  							// Check its not folder and it is image file
						  							if(!is_dir($image_path) && in_array($image_ext,$image_extensions)){
                                                    ?>
						  								<!-- Image -->
						  								<a href="<?php echo $image_path; ?>">
						  									<img src="<?php echo $image_path; ?>" alt="" title=""/>
						  								</a>
														<?php
														?>
														<?php
						  								$count++;
						  							}
						  						}
						  				} 
						  			closedir($dh);
						  	}
						  } else {
							echo ' No attachment yet. ';
						}
					}
				}
				?>
				</div>
			</div>
	</div>
</div>
<style>
	.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:120px;
	right:50px;
/*	border-radius:50px;*/
	text-align:center;
/*	box-shadow: 2px 2px 3px #999;*/

}
.backfloat{
	position:fixed;
	width:60px;
	height:60px;
	bottom:180px;
	right:50px;
/*	border-radius:50px;*/
	text-align:center;
/*	box-shadow: 2px 2px 3px #999;*/

}
.viewpofloat{
	position:fixed;
	width:60px;
	height:60px;
	bottom:123px;
	right:50px;
/*	border-radius:50px;*/
	text-align:center;
/*	box-shadow: 2px 2px 3px #999;*/

}
}
</style>
<div class="backfloat">
		<button type="button" class="btn btn-info" title="back" style="width:95px;" onclick="backButton('<?=$locstatus?>')"> <i class="fas fa-arrow-left"></i> BACK </button>
	</div>

	<div class="float">
		<button type="button" class="btn btn-primary viewpodetailsbtn" data-toggle="modal" style="margin-bottom: 5px;width:95px; font-size: 13px;" data-target="#viewpodetailsbtn"> PO DETAILS</button>

		<?php if ($locstatus !=='cancelVoucher') { ?>
			<button type="button" class="btn btn-success approvedbtn" title="approve"  style="margin-bottom: 5px;width:95px;"> APPROVE </button>
			<button type="button" class="btn btn-secondary approvedbtn" title="return"  style="margin-bottom: 5px;width:95px;"> RETURN </button>
			<button type="button" class="btn btn-danger approvedbtn" title="reject"   style="margin-bottom: 5px;width:95px;"> REJECT </button>
		<?php } ?>
	</div>

<div class="modal fade" id="approvedmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formStatus">
				<div class="modal-body">
					<div class="form-group">
						<label>PO_Number</label>
						<input type="hidden" name="statustype" id="statustype">
						<input type="hidden" name="site" id="site" value="<?php echo $site; ?>">
						<input type="text" name="voucherno" value="<?php echo $voucherno; ?>" class="form-control" readonly>
					</div>
					<div class="form-group">
						<label>Remarks</label>
						<textarea class="form-control" id="remarks_approved" name="remarks_approved"  rows="3"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalNo">NO</button>
					<button type="submit" name="approveddata" class="btn btn-primary">YES</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="viewpodetailsbtn" tabindex="-1" aria-labelledby="viewpodetailsbtnLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php
					$group = array();
						if(isset($voucherviewpodetails)){
							foreach($voucherviewpodetails as $row)
							{									
							?>
							<div class="card-body" style="background-color: #FFE4FA;" oncopy="return false" onpaste="return false" oncut="return false">
								<div class="row">
									<div class="col" style="text-align:right;"></div>
									<div class="col">
										<img src="<?= site_url('public/img/voucher/headerPO.png'); ?>" height="100" width="550">
									</div>
									<div class="col"></div>
								</div>
								<div class="row">
									<div class="col-6"></div>
									<div class="col" style="text-align: RIGHT;">
										<p style="font-size: 18px;font-weight: 700;">PO. NO. </p>
									</div>
									<div class="col">
										<p style="font-size: 18px;font-weight: 700;text-align: LEFT;margin-left: -15px;color:red"> 
											<?php echo $row['PO_Number'];?> 
										</p>
									</div>
								</div>
							<div class="row">
 								<div class="col"> </div>
 									<div class="col" style="text-align: center;font-size: 25px;">
										<p style="font-size: 25px;font-weight: 700;">
											PURCHASE ORDER 
										</p>
									</div>
								<div class="col"> </div>
							</div>
							<div class="row" style="font-weight: 700;">
 								<div class="col-5">
 									<span style="font-size: 12px;"> Supplier:</span> 
 									<span style="font-size: 12px;"> 
 										<?php echo $row['PO_Supplier'];?> 
 									</span>
 									<br>
 									<span style="font-size: 12px;"> Address:</span>
 									<span  style="font-size: 12px;"> 
 										<?php echo $row['Address'];?> 
 									</span>
 									<br>
 									<span style="font-size: 12px;"> Tel No:</span>
 									<span  style="font-size: 12px;"> 
 										<?php echo $row['CellNo'];?> 
 									</span>
 									<br>
 									<span style="font-size: 12px;"> Contact Person:</span>
 									<span  style="font-size: 12px;"> 
 										<?php echo $row['Contact_Person'];?> 
 									</span>
 								</div>
 								<div class="col"></div>
 								<div class="col" style="text-align:left;">
 									<span style="font-size: 12px;"> Order Date: </span>
 									<span style="font-size: 14px;margin-left: 40px;">
 										<?php echo $row['Order_Date'];?>
 									</span>
 									<br>
 									<span style="font-size: 12px;"> Delivery Date: </span>
 									<span  style="font-size: 14px;margin-left: 25px;">
 										<?php echo $row['Delivery_Date'];?>
 									</span>
 									<br>
 									<span style="font-size: 12px;"> Cancel Date: </span>
 									<span  style="font-size: 14px;margin-left: 35px;">
 										<?php echo $row['Cancel_Date'];?>
 									</span>
 									<br>
 									<span style="font-size: 12px;"> Terms of payment:</span>
 									<span style="font-size: 14px;"> 
 											<?php echo $row['TOP'];?> 							
 									</span>
 								</div>
 							</div>
 							<div class="row" style="margin-bottom: 25px!important;font-weight:700;">
 								<div class="col"></div>
 								<div class="col" style="text-align: center;">
 									<span style="font-size: 12px;"> TIN:</span>
 									<span style="font-size: 14px;"> 
 										<?php echo $row['Sup_TIN'];?>  
 									</span>
 								</div>
 								<div class="col" style="text-align: right;"></div>
 							</div>
 								<?=$viewpoitems($row['PO_Number']);?>
 							<br>
 								<div class="row">
 									<div class="col-6">
 										<div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
 											<?php echo $row['Note'];?>
 										</div>
 									</div>
 								</div>
 							<div class="row" style="margin-top:-80px">
 								<?=$vouchervatsale($row['PO_Number']);?>
 							</div>
 								<div class="row">
 										<div class="col" id="termsandcondition" style="border: 1px solid;margin: 18px;">
 											<b>
	 											<u style= "font-size: 11px!important;"> Terms and 		Condition:
	 											</u>
	 											<p style= "font-size: 11px!important;font-style: oblique;">
	 												After acceptance of the order, you bind yourself to pay to CEBU GENERAL SERVICES, INC. for any loss and/or damage suffered by the company due to late delivery for any of the articles called herein or failure to comply with the terms and conditions of the order. The supplier hereby submits itself and agrees to pay 5% of the amount per day of the delayed items. All invoices and delivery receipt should be attached to the original copy of the purchased order upon delivery. CEBU GENERAL SERVICES, INC. have the right to reject all good in bad order condition and/or not accordance with the specification of our order. All expense related hereto are for the accounts of the supplier. The purchase order is not valid without the signature of the company authorize signatory.
	 											</p>
 											</b>
 										</div>
 									</div>
 									<div class="row">
 										<div class="col" style="border-left: 1px solid;border-left: 1px solid;border-bottom: 1px solid;text-align: center;margin-top: -20px;margin-left: 18px;">
 											<span style= "font-size: 12px!important;font-weight: 700;">
	 											Prepared by: 
	 										<br>
	 										<?php
	 											if($lastUriSegment ==1)
	 											{
 													?>
 													<img src="<?= site_url('public/img/voucher/mamchona.png'); ?>" width="155" height="70">
 													<br>
 													<div style="margin-top: -35px;font-size: 12px!important;">
 														MA. CHONA LIM 
 														<br>
 														Purchaser
 													</div>	
 													<?php
 												}else{
 													?>
 													<img src="<?= site_url('public/img/voucher/misshoney.png'); ?>" width="155" height="70">
 													<br>
	 												<div style="margin-top: -35px;font-size: 12px!important;">
	 													HONEY JOY POLINAR
	 												<br>
	 													Purchaser
	 												</div>
 												<?php
 												}
 											?>
 											</span>
 										</div>
 										<div class="col-6" style="border-bottom: 1px solid;border-left:
										1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;">
											<span style= "font-size: 12px!important;font-weight: 700;">
												Verified by:
												<br>
												<img src="<?= site_url('public/img/voucher/mamroseheray.png'); ?>" width="155" height="70">
												<br>
												<div style="margin-top: -35px;font-size: 12px!important;">
													MS. ROSE HERAY 
													<br>
													Finance & Acctg. Manager
												</div>
											</span>
										</div>
										<div class="col" style="border-bottom: 1px solid;border-right: 1px
										solid;text-align: center;margin-top: -20px;margin-right: 18px;">
											<span style= "font-size: 12px!important;font-weight: 700">
											Approved by:
												<br>
												<img src="<?= site_url('public/img/voucher/sigGrace.png'); ?>" width="100" height="50">
												<br>
												<div style="margin-top: -15px;font-size: 12px!important;font-weight: 700"> 
													MRS. GRACE ILIGAN 
													<br>
													President
												</div>
											</span>
										</div>
 									</div>
 									<div class="row">
	 									<div class="col" style="text-align:right;font-weight: 700">
	 										<p> F-751-131 Rev.0/8-1-13</p>
	 									</div>
	 								</div>
					<?php }} ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalNo">CLOSE </button>
				</div>
		</div>
	</div>
</div>


<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/voucher.js'); ?>"></script>
