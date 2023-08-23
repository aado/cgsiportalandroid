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
			foreach($voucherdetails as $rowluzon)
			{
				echo '<span class="text-sm text-grey-m2 align-middle" style="color:white">'.$rowluzon['Voucher_Num'].'</span>';
				?>
				<div class="card">
					<div class="card-body" style="background-color: #FFF797;border:1px solid;" oncopy="return false" onpaste="return false" oncut="return false">
						<div class="row" style="border-bottom:1px solid;">
							<div class="col-md-auto">
								<img src="<?= site_url('public/img/voucher/cashvoucher.png');?>"  height="100" width="550">
							</div>
							<div class="col">
								<span>
									<p style="font-size: 20px;font-weight: 700;text-align: right;">
										No.
									</p>
								</span>
								<span style="text-align: right">
									<p>Date:</p>
								</span>
							</div>
							<div class="col-2">
								<span>
									<p style="font-size: 20px;font-weight: 700;text-align: LEFT;margin-left: -30px;color:red">
										<?php echo $rowluzon['Voucher_Num'];?>
									</p>
								</span>
								<?php
								if($d['approvedate'] !='')
								{
									?>
									<span style="color: #586e98;">
										<p>
											<u style="font-size:14px;margin-left: -25px;margin-top: 25px;"> 
												<?php echo date('F d Y',strtotime(explode(' ',$d['approvedate'])[0]))?>
											</u>
										</p>
									</span>
									<?php
								}
								?>
							</div>
						</div>
						<div class="row" style="border-bottom: 1px solid;">
							<div class="col-8">
								<span style="font-size: 16px;"> Paid to:</span> 
								<span style="font-size: 16px;color: #879675;font-weight: 700;">
									<?php echo $rowluzon['Payee'];?>
								</span>
							</div>
							<div class="col" style="border-left:1px solid;text-align: center;">
								<span class="text-center"> For Bookkeeping use only: </span>
							</div>
						</div>
						<div class="row">
							<div class="col-8"style="font-size: 16px;text-align: center;">
							</div>
							<div class="col" style="border-left:1px solid;text-align: center;">
								<span class="text-center">
									Entries
								</span> 
							</div>
							<div class="col-3" style="border-left:1px solid;text-align: center;">
								<span class="text-center">
									Amount
								</span>
							</div>
						</div>
						<div class="row" style="border-bottom: 1px solid;">
							<div class="col-8"style="font-size: 16px;text-align: center;">
								<span> Particulars </span>
							</div>
							<div class="col" style="border-left:1px solid;text-align: center;">
								<span class="text-center">  </span>
							</div>
							<div class="col col-lg-2" style="border-left:1px solid;border-top:1px solid;text-align: center;">
								<span class="text-center"> debit </span>
							</div>
							<div class="col" style="border-left:1px solid;border-top:1px solid;text-align: center;">
								<span class="text-center"> credit </span>
							</div>
						</div>
						<br>
						<div class="row" style="margin-bottom: 25px!important;">
							<div class="col-8">
								<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
									<?php echo strtok($rowluzon['PO_Particular'], '(')?>
								</span>
								<br>
								<?php
								if(explode(' ',$rowluzon['Bank_Name'])[1] == 'DM')
								{
									?>
									<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
										Crediting Date:
									</span>
									<span style="font-size: 14px;color: #586e98;">
										<?php echo $rowluzon['Crediting_Date'];?>
									</span>
									<?php
								}
								?>
							</div>
							<div class="col">
								<table class="table table-borderless table-sm" style="width:100%">
									<tr>
										<th scope="col"></th>
										<th scope="col"></th>
										<th scope="col"></th>
										<th scope="col"></th>
									</tr>
									<?php
									if($voucherdetails2)
									{
										foreach($voucherdetails2 as $rowluzon2)
										{
											?>
											<tr>
												<td> </td>
												<td style="color: #586e98;">
													<?php echo $rowluzon2['Account_Code'];?>
												</td>
												<td style="text-align:center;color: #586e98;">
													<?php
													$no = '';
													if($rowluzon2['IsDebit'] =='Yes')
													{
														echo number_format($rowluzon2['Journal_Amount'], 2);
													}
													?>
												</td>
												<td style="text-align:center;color: #586e98;">
													<?php
													$no = '';
													if($rowluzon2['IsDebit'] =='No')
													{
														echo number_format($rowluzon2['Journal_Amount'], 2);
													}
													?>
												</td>
											</tr>
											<?php
											}
										}
									?>
								</table>
							</div>
							<div class="row" style="margin-bottom: 25px!important;">
								<div class="col-2">
									<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
									</span>
								</div>
								<div class="col" style="text-align:right;">
									<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
										<?php echo substr($rowluzon['PO_Particular'],
											strpos($rowluzon['PO_Particular'], "(") - 1);
											?>
									</span>
								</div>
								<div class="col-6">
									<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
										<?php echo number_format($rowluzon['Gross_Amount'], 2);?>
									</span>
								</div>
							</div>
							<?php
							if($rowluzon['Tax'] =='%' && $rowluzon['VAT'] !='%')
							{
								?>
								<div class="row" style="margin-bottom: 25px!important;">
									<div class="col-2">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
										</span>
									</div>
									<div class="col" style="text-align:right;">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
											Less:EWT(<?php echo number_format($rowluzon['Gross_Amount'], 2);?> / 1.<?php echo $rowluzon['VAT'];?>)
										</span>
									</div>
									<div class="col-6">
										<Span style="font-size: 14px;color: #586e98;margin-left: 20px;">
											<?php echo number_format($rowluzon['VAT_Amount'], 2);?></Span>
									</div>
								</div>
								<?php
							}
							?>
							<?php
							if($rowluzon['VAT'] =='%' && $rowluzon['Tax'] !='%')
							{
								?>
								<div class="row" style="margin-bottom: 25px!important;">
									<div class="col-2">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
										</span>
									</div>
									<div class="col" style="text-align:right;">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
											Less:EWT(<?php echo number_format($rowluzon['Gross_Amount'], 2);?> * <?php echo $rowluzon['Tax'];?>)
										</span>
									</div>
									<div class="col-6">
										<Span style="font-size: 14px;color: #586e98;margin-left: 20px;"><?php echo number_format($rowluzon2['Total_W_TaxApplied'], 2);?></Span>
									</div>
								</div>
								<?php
							}
							?>
							<?php
							if($rowluzon['VAT'] !='%' && $rowluzon['Tax'] !='%')
							{
								?>
								<div class="row" style="margin-bottom: 25px!important;">
									<div class="col-2">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
										</span>
									</div>
									<div class="col" style="text-align:right;">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
											Less:EWT(<?php echo number_format($rowluzon['Gross_Amount'], 2);?> / 1.<?php echo $rowluzon['VAT'];?>)
										</span>
									</div>
									<div class="col-6">
										<Span style="font-size: 14px;color: #586e98;margin-left: 20px;">
											<?php echo number_format($rowluzon['VAT_Amount'], 2);?></Span>
									</div>
								</div>
								<div class="row" style="margin-bottom: 25px!important;">
									<div class="col-2">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
										</span>
									</div>
									<div class="col" style="text-align:right;">
										<span style="font-size: 14px;color: #586e98;margin-left: 20px;">
											Less:EWT(<?php echo number_format($rowluzon['Gross_Amount'], 2);?> * <?php echo $rowluzon['Tax'];?>)
										</span>
									</div>
									<div class="col-6">
										<Span style="font-size: 14px;color: #586e98;margin-left: 20px;">
											<?php echo number_format($rowluzon['Total_W_TaxApplied'], 2);?>
										</Span>
									</div>
								</div>
								<?php
							}
							?>
							<br>
							<div class="row">
								<div class="col-2" style="text-align: right;">
								</div>
								<div class="col-4" style="text-align: right;">
									<span>Amount Issued >>>>>>Php</span>
								</div>
								<div class="col-6">
									<span style="font-size: 14px;color:#586e98;">
										<?php echo number_format( $rowluzon['Net_Payable'], 2);?>
									</span>
								</div>
								<div class="col">
									<span></span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<span></span> 
								</div>
								<div class="col-1">
								</div>
								<div class="col-1">
								</div>
								<div class="col-2" style="border-top:1px solid;padding: 0;">
									<hr  style="background-color: black!important;">
								</div>
								<div class="col">
								</div>
							</div>
							<div class="row" style="border-top:1px solid;">
								<div class="col">
									<span>
										PAYMENT MODE :
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
											<label class="form-check-label" for="inlineCheckbox1">Check</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
											<label class="form-check-label" for="inlineCheckbox2">DM</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
											<label class="form-check-label" for="inlineCheckbox2">MC</label>
										</div>
										<br>
										<?php
												if(explode(' ',$rowluzon['Bank_Name'])[1] == 'DM')
												{
												?>
												<span style="margin-left:15%;font-size: 12px;color: #586e98;">
													<?php echo $rowluzon['Bank_Name'];?> 
												</span>
												<?php
											}
											?>
											<?php
											if(explode(' ',$rowluzon['Bank_Name'])[1] !== 'DM')
											{
												?>
												<span style="margin-left:15%;font-size: 12px;color: #586e98;">
													<?php echo $rowluzon['Bank_Name'];?>  <?php echo $rowluzon['Cheque_Num'];?> 
												</span>
												<?php
											}
											?>
									</span>
								</div>
								<div class="col-6" style="border-left:1px solid;">
									<span class="text-center" style="font-size: 14px;">
										Received from CEBU GENERAL SERVICES, INC. the sum amount of
									</span> 
									<hr style="background-color: black!important;margin-bottom:-2px">
									<span style="font-size: 12px;color: #586e98;padding-top: -10px;">
										<?php 
										// $netpayable = explode('.',$rowluzon['Net_Payable'])[1];
										// if($netpayable == 0){
										// 	$netpayable = explode('.',$rowluzon['Net_Payable'])[0];
										// 	$c = 'Pesos';
										// }else
										// {
										// 	$netpayable = $rowluzon['Net_Payable'];
										// 	$c = '';
										// }
										// echo convert_number_to_words($netpayable) .' '.$c; 
										?>
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
 									<img src="<?= site_url('public/img/voucher/missruado.png');?>" width="100" height="50" style="position: absolute;">	
 									<br>
 									<span style="color: #586e98;">
 										G.Ruado
 									</span>
 								</div>
 								<div class="col-6" style="border-left:1px solid;padding-top: 10px;">
 									<span class="text-center" style="font-size: 16px;color: #586e98;">
 										(Php &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowluzon['Net_Payable'], 2);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
 									</span>
 									<span>
 										as payment of above mentioned transaction(s).
 									</span>
 								</div>
 							</div>
 							<div class="row" style="border-top:1px solid;">
 								<div class="col col-lg-2" style="padding-top: 15px!important">
 									<span>
 										Noted by:
 									</span>
 								</div>
 								<div class="col">
 									<br>
 									<span style="color: #586e98;">
 										R.HERAY
 									</span>
 									<span style="color: #586e98;margin-left: 50px ;">
 										C. MENDEZ
 									</span>
 								</div>
 								<div class="col-6" style="border-left:1px solid;padding-top: 25px!important;">
 									<span style="font-style: italic;">
 										Received by: ___________________________ Date: ______________
 									</span> 
 								</div>
 							</div>
 							<div class="row">
 								<div class="col col-lg-2" style="padding-top: 15px!important;border-top: 1px solid;">
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
 									<span style="color: #586e98;margin-left: 40px ;">
 										& R. PEREZ
 									</span>
 								</div>
 								<div class="col-6" style="border-left:1px solid; margin-top: -10px;">
 									<span class="text-center" style="font-size: 14px;margin-left: 120px;">
 										(Signature Over Printed Name)
 									</span>
 									<br>
 									<span style="margin-left: 100px;font-size: 14px;font-style: italic;">
 										Official Receipt No. : _________________
 									</span>
 								</div>
 							</div>
 						</div>
				</div>
				<?php
			}
		}
		?>
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
