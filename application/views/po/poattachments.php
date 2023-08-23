<!-- <div class="container-fluid">
Page Heading -->
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
	<button type="button" class="btn btn-danger" title="back" style="width:95px;" onclick="backButton('<?=$locstatus?>')"> <i class="fas fa-arrow-left"></i> BACK </button>
</div>
<div class="container">
				<div class="gallery">
			  	<?php 

						$filename=$ponumber;
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
													// Break
														// if( $count%4 == 0)
														// {
														?>
															<!-- <div class="clear"></div> -->
														<?php
						  								// }
						  								$count++;
						  							}
						  						}
						  				} 
						  			closedir($dh);
						  	}
						  } else {
							echo 'No attachment yet.';
						}
				?>
				</div>
				</div>
			</div>
</div>
<!-- /.container-fluid -->
<script src="<?= site_url('public/js/po.js'); ?>"></script>
<script src="<?=site_url('public/plugins/simplelightbox-master')?>/dist/simple-lightbox.js?v2.8.0"></script>
<script>
    (function() {
        var $gallery = new SimpleLightbox('.gallery a', {});
    })();
</script>
