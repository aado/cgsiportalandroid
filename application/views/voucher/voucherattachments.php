<!-- <div class="container-fluid">
<!-- Page Heading -->
<link rel="stylesheet" href="<?=site_url('public/plugins/simplelightbox-master')?>/dist/simple-lightbox.css?v2.10.4" />
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
<h1 class="h3 mb-4 text-gray-800" style="margin-left: 12px;"><?= ($page['title'] ?? 'Undefined'); ?></h1>
<div style="float: right; margin-right: 12px;margin-top: -50px;">
	<a href="voucherdetails/<?=$vouchernumber?>/<?=$site?>"><button type="button" class="btn btn-danger" title="back" style="width:95px;"> <i class="fas fa-arrow-left"></i> BACK </button></a>
</div>
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
				<?php if ($locstatus !=='cancelVoucher') { ?>
				<div class="float-right" style="margin-right: 15px">
					<button type="button" class="btn btn-success approvedbtn" title="approve"> APPROVE </button>
					<button type="button" class="btn btn-secondary approvedbtn" title="return" style="width:95px;"> RETURN </button>
					<button type="button" class="btn btn-danger approvedbtn" title="reject"  style="width:95px;"> REJECT </button>
				</div>
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
									<input type="hidden" name="statustype" id="statustype" >
									<input type="text" name="voucherno" value="<?php echo $vouchernumber; ?>" class="form-control" readonly>
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
			
</div>
<!-- /.container-fluid -->
<script src="<?= site_url('public/js/voucher.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?=site_url('public/plugins/simplelightbox-master')?>/dist/simple-lightbox.js?v2.8.0"></script>
<script>
    (function() {
        var $gallery = new SimpleLightbox('.gallery a', {});
    })();
</script>
