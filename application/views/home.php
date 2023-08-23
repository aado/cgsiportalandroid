<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<?php if ($this->session->flashdata('success_message')) : ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<?= $this->session->flashdata('success_message'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php elseif ($this->session->flashdata('error_message')) : ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?= $this->session->flashdata('error_message'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php else : ?>
		<div class="alert alert-info alert-dismissible fade show" role="alert">
			Hello, <?= ($username ?? 'Guest'); ?>.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php 
                  $arr = array();
                  foreach ($masterCount as $key => $item) {
                    $arr[$item['Comp_Name']][$key] = $item;
                  }
                ?>
                <p>Memo</p>
                <h3><?=count($masterCount)?></h3>

				<?php 
					$client_name = '<span style="font-size: 12px">';
					foreach ($userClient as $client) {
						$client_name .= $client.': <span style="color: #5d1e85;font-weight: bold;font-size: 15px;float:right">'.count($arr[$client]).'</span><br>';
					}
					echo $client_name.'</span>';
                ?>
              </div>
              <div class="icon">
			  	    <i class="fa fa-sticky-note"></i>
              </div>
              <a href="<?= site_url('/Masterlist'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
				<?php 
					$arr = array();
					foreach ($tortaCount as $key => $item) {
						$arr[$item['Comp_Name']][$key] = $item;
					}
					?>
					<p>Medicine Stocks</p>
					<h3><?=count($tortaCount)?></h3>

					<?php 
						$client_name = '<span style="font-size: 12px">';
						foreach ($userClient as $client) {
							$count = 0;
							if (isset($arr[$client])) {
								$count = count($arr[$client]);
							}
							$client_name .= $client.': <span style="color: #5d1e85;font-weight: bold;font-size: 15px;float:right">'.$count.'</span><br>';
						}
						echo $client_name.'</span>';
				?>
              </div>
              <div class="icon">
                <i class="fa fa-arrow-right"></i>
              </div>
              <a href="<?= site_url('/ToRTA'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
			  	<?php 
					$arr = array();
					foreach ($tortainCount as $key => $item) {
						$arr[$item['Company_Assigned']][$key] = $item;
					}
					?>
					<p>Reports</p>
					<h3><?=count($tortainCount)?></h3>

					<?php 
						$client_name = '<span style="font-size: 12px">';
						foreach ($userClient as $client) {
							$count = 0;
							if (isset($arr[$client])) {
								$count = count($arr[$client]);
							}
							$client_name .= $client.': <span style="color: #5d1e85;font-weight: bold;font-size: 15px;float:right">'.$count.'</span><br>';
						}
						echo $client_name.'</span>';
				?>
              </div>
              <div class="icon">
                <i class="fa fa-medkit"></i>
              </div>
              <a href="<?= site_url('/RTAInactive'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
			  		<?php 
					$arr = array();
					foreach ($ForMatCount as $key => $item) {
						$arr[$item['Comp_Name']][$key] = $item;
					}
					?>
					<p>Force Leave/ Maternity</p>
					<h3><?=count($ForMatCount)?></h3>

					<?php 
						$client_name = '<span style="font-size: 12px">';
						foreach ($userClient as $client) {
							$count = 0;
							if (isset($arr[$client])) {
								$count = count($arr[$client]);
							}
							$client_name .= $client.': <span style="color: #5d1e85;font-weight: bold;font-size: 15px;float:right">'.$count.'</span><br>';
						}
						echo $client_name.'</span>';
					?>
              </div>
              <div class="icon">
                <i class="fa fa-child"></i>
              </div>
              <a href="<?= site_url('/ForceLeaveMaternity'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

	</div>
<!-- /.container-fluid -->

			