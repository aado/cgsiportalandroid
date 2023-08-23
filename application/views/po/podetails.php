<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=site_url('public/plugins/simplelightbox-master')?>/dist/simple-lightbox.css?v2.10.4" />
<div class="container-fluid">
<!-- Page Heading -->

<style>
	table, th, td {
		border-right: 1px solid black;
		border-collapse: collapse;
		border-left: 1px solid black;
		border-bottom: 1px solid black;
		font-family: calibri;
	}
	th {
		border-top:1px solid black;
		border-bottom: 1px solid black;
		text-align: center;
	}
	td{
		border-bottom: 0px solid black;
		padding: 15px;
		font-size: 14px;
	}
	.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:80px;
	right:50px;
	text-align:center;
}
.backfloat{
	position:fixed;
	width:60px;
	height:60px;
	bottom:123px;
	right:50px;
	text-align:center;
}
</style>


<h1 class="h3 mb-4 text-gray-800">PO Details</h1>
	<div class="content">
		<div class="card">
			<div class="card-body">

				<?php
 					if($getPODetails)
 					{
						// print_r($getPODetails);
 						foreach($getPODetails as $row)
 						{
 							echo '<span class="text-sm text-grey-m2 align-middle" style="color:white">'.$row['PO_Number'].'</span>';		
							?>
							<div class="card">
 								<div class="card-body" style="background-color: #FFE4FA;" oncopy="return false" onpaste="return false" oncut="return false"> 
 									<div class="row">
 										<div class="col" style="text-align:right;">

 										</div>
 										<div class="col" >
 											<img class="img" src="<?= site_url('public/img/headerPO.png');?>"  height="100" width="550">
 										</div>
 										<div class="col">
 										
 										</div>
 									</div>
 									<div class="row" >
 										<div class="col-6">

 										</div>
 										<div class="col" style="text-align: RIGHT;">
 											<p style="font-size: 18px;font-weight: 700;">
 												PO. NO.
 											</p>
 										</div>
 										<div class="col" >
 											<p style="font-size: 18px;font-weight: 700;text-align: LEFT;margin-left: -15px;color:red">
 												<?php echo $row['PO_Number'];?>
 											</p>
 										</div>
 									</div>
 									<div class="row">
 										<div class="col">
 										</div>
 										<div class="col" style="text-align: center;font-size: 
 											25px;">
 											<p style="font-size: 27px;font-weight: 700;">
 												PURCHASE ORDER
 											</p>
 										</div>
 										<div class="col">
 											
 										</div>
 									</div>
 									<div class="row" style="font-weight: 700;">
 										<div class="col">
 											<span style="font-size: 12px;"> Supplier:</span> 
 											<span style="font-size: 12px;"> 
 												<?php echo $row['PO_Supplier'];?> 
 											</span>
 											<br>
 											<span style="font-size: 12px;"> Address:</span>
 											<span style="font-size: 12px;"> 
 												<?php echo $row['Address'];?> 
 											</span>
 											<br>
 											<span style="font-size: 12px;"> Tel No:</span>
 											<span style="font-size: 12px;"> 
 												<?php echo $row['CellNo'];?> 
 											</span>
 											<br>
 											<span style="font-size: 12px;"> Contact Person: </span>
 											<span style="font-size: 12px;"> 
 												<?php echo $row['Contact_Person'];?> 
 											</span>
 										</div>
 										<div class="col-5">
 										</div>
 										<div class="col" style="text-align: left;">
 											<span style="font-size: 12px;"> 
 												Order Date:
 											</span> 
 											<span style="font-size: 14px;margin-left: 40px;">
 												<?php echo $row['Order_Date'];?>  
 											</span>
 											<br>
 											<span style="font-size: 12px;">
 												Delivery Date: 
 											</span>
 											<span style="font-size: 14px;margin-left: 25px;">
 												<?php echo $row['Delivery_Date'];?>
 											</span>
 											<br>
 											<span style="font-size: 12px;"> Cancel Date: </span>
 											<span style="font-size: 14px;margin-left: 35px;"> 
 												<?php echo $row['Cancel_Date'];?>
 											</span>
 											<br>
 											<span style="font-size: 12px;"> Terms of payment:</span>
 											<span style="font-size: 14px;"> 
 												<?php echo $row['TOP'];?>
 											</span>
 										</div>
 									</div>	
 									<div class="row" style="margin-bottom: 25px!important;font-weight: 700;">
	 									<div class="col">
	 									</div>
 										<div class="col" style="text-align: center;">
 											<span style="font-size: 12px;"> TIN:</span>
 											<span style="font-size: 14px;"> 
 												<?php echo $row['Sup_TIN'];?>  
 											</span>
 										</div>
 										<div class="col" style="text-align: right;">
 										</div>
 									</div>
 									<table style="width:100%">
 										<tr>
 											<th> Qty </th>
 											<th> Units </th>
 											<th> Description</th>
 											<th> Unit Cost </th>
 											<th>Total Cost</th>
 										</tr>
 										<?php
 											if($getPOItems)
 											{
 												foreach($getPOItems as $row2)
 												{	
												?>
												<tr>
 													<td style="text-align:right;"> 
 														<?php echo $row2['ItemQty'];?>
 													</td>
 													<td> <?php echo $row2['ItemUnit'];?>  </td>  
 													<td> <?php echo $row2['ItemDesc'];?> </td>
 													<td style="text-align:right;"> 
 														<?php echo $row2['ItemCost'];?> 
 													</td>
 													<td style="text-align:right;"> 
 														<?php echo $row2['Total_Cost'];?> </td>
 												</tr>
												<?php
												}	
											}
										?>
									</table>
									<br>
									<div class="row">
 										<div class="col-6" >
 											<div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
 												<?php echo $row['Note'];?>
 											</div>
 										</div>
 										
 										<?php
 											if($row['Vatsale'] !=='Yes')
 											{
 												?>
 												<div class="col" style="text-align:right;font-weight: 700;margin-top: 15px;" >

 												<?php
 												if($row['Vatsale'] !='0') 
 												{
 												 ?>
 													<span style="font-size: 12px;text-align:right;"> 
 														Vatable >>>>>>>> 
 													</span>
 													<br>
 													<span style="font-size: 12px;text-align:right;"> 
 														Value Added Tax >>>>>>>> 
 													</span>
 													<br>
 													<?php }
 												?>
 													<span style="font-size: 12px;text-align:right;"> 
 														Total Amount >>>>>>>>
 													</span>
 													<br>
 												</div>
 												<div class="col" style="margin-top: 15px;">

 												<?php
 												if($row['Vatsale'] !='0') 
 												{
 												 ?>
 													<span style="font-size: 14px;font-weight: 700;">
 														<?php echo $row['Vatsale'];?>
 													</span><br>
 													<span style="font-size: 14px;font-weight: 700;">
 														<?php echo $row['AddedTax'];?>
 													</span>
 													<br>
 												<?php }
 												?>
 													<span style="font-size: 14px;font-weight: 700;">
 														<?php echo $row['TotalAmount'];?>
 													</span>
 													<br>
 												</div>
 												<?php
 											}
 										?>
 									</div>
 										<?php
 											if($row['NonVAt'] === 'No')
 											{
 												?>
 												<div class="row">
 													<div class="col-5">
 													</div>
 													<div class="col" style="text-align:right;font-weight: 700;" ><!-- 
 														<span style="text-align:right;font-size: 12px;"> 
 															NON-VATABLE >>>>>
 														</span> -->
 														<br>
 														<span style="text-align:right;font-size: 12px;"> 
 															TOTAL AMOUNT >>>>>
 														</span>
 														<br>
 													</div>
 													<div class="col" style="text-align:left;">
 														<!-- <span style="font-size: 14px;font-weight:700;">
 															<?php echo $row['NonVAt'];?>
 														</span> -->
 														<br>
 														<span style="font-size: 14px;font-weight:700;">
 															<?php echo $row['TotalAmount'];?>
 														</span>
 														<br>
 													</div>
 												</div>
 												<?php
 											}
 										?>
 									<div class="row">
 										<div class="col" id="termsandcondition" style="border: 1px solid;margin: 18px;">
 											<b>
 												<u style= "font-size: 11px!important;"> 
 													Terms and Condition:
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
											 	<?php if ($row['PO_Branch'] == 'Luzon') { ?>
													<img class="img" src="<?= site_url('public/img/voucher/misshoney.png');?>" width="155" height="70">	
												<?php } else {?>
 													<img class="img" src="<?= site_url('public/img/voucher/mamchona.png');?>" width="155" height="70">
												<?php } ?>
				 								<br>
				 									<div style="margin-top: -25px;font-size:12px!important;">
														<?=($row['PO_Branch'] == 'Luzon')?'HONEY JOY POLINAR':'MA. CHONA LIM';?>
				 										<br>
				 										Purchaser
				 									</div>						
				 							</span>
					                    </div>
					                    <?php if($row['PO_Status'] =='Approved' && $row['PO_StatusTag'] =='1'){ ?>
					                    <div class="col-6" style="border-bottom: 1px solid;border-left: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;">
					                    	<span style= "font-size: 12px!important;font-weight: 700;"> 
					                    		Verified by:
						                		<br>
						                		<img class="img" src="<?= site_url('public/img/voucher/mamroseheray.png');?>" width="155" height="70">
						                    	<br>
						                    	<div style="margin-top: -35px;font-size:12px!important;">
				 										MS. ROSE HERAY
				 										<br>
				 										Finance & Acctg. Manager
				 								</div>
					                     	</span>
					                    </div>
										<div class="col" style="border-bottom: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;margin-right: 18px;">
					                     		
					                    	<span style= "font-size: 12px!important;font-weight: 700"> 
					                    		Approved by:
						                	<br>
						                    	<br>
						                    	<div style="margin-top: 0px;font-size:12px!important;">
				 										MRS. GRACE ILIGAN
				 										<br>
				 										President
				 								</div>
					                    	</span>
					                    </div>
					                    <?php } ?>
										<?php
					                    if($row['PO_Status'] =='Pending' && $row['PO_StatusTag'] =='0')
					                    {
					                    ?>
										 <div class="col-6" style="border-bottom: 1px solid;border-left: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;">
					                    	<span style= "font-size: 12px!important;font-weight: 700;"> 
					                    		Verified by:
						                		<br>
						                    	<br>
						                    	<div style="font-size:12px!important;">
				 										MS. ROSE HERAY
				 										<br>
				 										Finance & Acctg. Manager
				 								</div>
					                     	</span>
					                    </div>
					                    
										<div class="col" style="border-bottom: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;margin-right: 18px;">
					                     		
					                    	<span style= "font-size: 12px!important;font-weight: 700"> 
					                    		Approved by:
						                	<br>
						                    	<br>
						                    	<div style="margin-top: 0px;font-size:12px!important;">
				 										MRS. GRACE ILIGAN
				 										<br>
				 										President
				 								</div>
					                    	</span>
					                    </div>
					                    <?php } ?>
					                    <?php
					                    if($row['PO_Status'] =='Approved' && $row['PO_StatusTag'] =='2')
					                    {
					                    ?>
										<div class="col-6" style="border-bottom: 1px solid;border-left: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;">
					                    	<span style= "font-size: 12px!important;font-weight: 700;"> 
					                    		Verified by:
						                		<br>
						                		<img class="img" src="<?= site_url('public/img/voucher/mamroseheray.png');?>" width="155" height="70">
						                    	<br>
						                    	<div style="margin-top: -35px;font-size:12px!important;">
				 										MS. ROSE HERAY
				 										<br>
				 										Finance & Acctg. Manager
				 								</div>
					                     	</span>
					                    </div>
					                    <div class="col" style="border-bottom: 1px solid;border-right: 1px solid;text-align: center;margin-top: -20px;margin-right: 18px;">
					                     		
					                    	<span style= "font-size: 12px!important;font-weight: 700"> 
					                    		Approved by:
						                	<br>
						                	<img class="img" src="<?= site_url('public/img/voucher/sigGrace.png');?>" width="155" height="70">
						                    	<br>
						                    	<div style="margin-top: -30px;font-size:12px!important;">
				 										MRS. GRACE ILIGAN
				 										<br>
				 										President
				 								</div>
					                    	</span>
					                    </div>
					                    <?php } ?>

 									</div>
 									<div class="row">
 										<div class="col" style="text-align:right;font-weight: 700">
 											<p> F-751-131 Rev.0/8-1-13</p>
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

		
		<div class="" style="margin-top: 10px">
			<div class="gallery">
			<div class="card">
				<div class="card-body">
				<h2 style="text-align:center;"> ATTACHMENTS </h2>	
				<?php 
				if($getPODetails)
				{
					foreach($getPODetails as $row)
					{
						$filename=$row['PO_Number'];
						  // Image extensions
						$image_extensions = array("png","jpg","jpeg","gif","bmp");
						  // Target directory
					  	$dir_path = "uploads/".$filename;
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
													$image_path = base_url("uploads/$filename/".$file);
						  							// $image_path = "uploads/$filename/".$file;
						  							$image_ext = pathinfo($image_path, PATHINFO_EXTENSION);
						  							// Check its not folder and it is image file
						  							if(!is_dir($image_path) && in_array($image_ext,$image_extensions)){
                                                    ?>
						  								<a href="<?php echo $image_path; ?>">
						  									<img src="<?php echo $image_path; ?>" alt="" title="" style="width: 19%; height: 20%; padding: 5px"/>
						  								</a>
														<?php
						  								$count++;
						  							}
						  						}
						  				} 
						  			closedir($dh);
						  	}
						  } else {
							echo 'No attachment yet.';
						}
					}
				}
				?>
					</div>
					</div>
				</div>
			</div>
		</div>
</div>



	<div class="backfloat">
				<button type="button" class="btn btn-info" title="back" style="width:95px;" onclick="backButton('<?=$locstatus?>')"> <i class="fas fa-arrow-left"></i> BACK </button>
			</div>
			<?php if($getPODetails){ ?>
			<div class="float">
				<!-- <a href="<?=site_url()?>poattachments"><button type="submit" name="viewimages" class="btn btn-info" data-toggle="modal" data-target="#attachmentModal"><i class="fas fa-folder-open"></i>
					ATTACHMENTS
				</button></a> -->
				<?php if ($locstatus !=='cancellpo') { ?>
					<button type="button" class="btn btn-success approvedbtn" title="approve" data-toggle="modal" data-target="#statusModal" style="margin-bottom: 5px;width:95px;"> APPROVE </button>
					<button type="button" class="btn btn-secondary approvedbtn" title="return"  data-toggle="modal" data-target="#statusModal" style="margin-bottom: 5px;width:95px;"> RETURN </button>
					<button type="button" class="btn btn-danger approvedbtn" title="reject"  data-toggle="modal" data-target="#statusModal" style="margin-bottom: 5px;width:95px;"> REJECT </button>
				<?php } ?>
			</div>
			<?php } ?>
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

<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/po.js'); ?>"></script>
<script src="<?=site_url('public/plugins/simplelightbox-master')?>/dist/simple-lightbox.js?v2.8.0"></script>
<script>
    (function() {
        var $gallery = new SimpleLightbox('.gallery a', {});
    })();
</script>
