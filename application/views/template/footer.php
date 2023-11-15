</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer" style="background: #f8f9fc">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
					<style>
						@import url(https://fonts.googleapis.com/css?family=Open+Sans);

						/* $bg-color: #537ec5;
						$text-color:  #010038;
						$inactive-item-color: #537ec5;
						$active-item-color: #010038; */

						.fa-2x {
						font-size: 26px;
						}

						.menu-container {
							width: 500px;
							height: 60px;
							padding: 4px 20px 0px 20px;
							box-shadow:  0px 0px 5px #dee3e7, 0px -1px 5px #888;
							z-index: 99999;
							bottom: 0px;
							position: fixed;
							left: 0px;
							background: azure;
						}

						.menu {
							/* width: 100%; */
							width: 150%;
							height: 100%;
							margin: 0;
							padding: 0;
							display: flex;
							position: relative;
						}

						input[type="radio"] {
							display: none;
						}

						label {
							color: $inactive-item-color;
							cursor: pointer;
							z-index: 1;
								display: flex;
								align-items: center;
								justify-content: center;
							width: 25%;
							transition: 0.25s ease-in;
						}

						.item {
							text-align: center;
						}

						.item-title {
							margin-top: 0px;
							margin-bottom: -6px;
							color: gray;
							font-weight: 600;
							font-size: 11px;
						}

						.blob-container {
							position: absolute;
							z-index: 0;
							width: 25%;
							transition: transform 0.2s ease-out;
						}

						.blob {
							background: $active-item-color;
							width: 50px;
							height: 50px;
							border-radius: 25px;
							margin: 2px auto;
						}

						input[type="radio"] {
							&:checked {
								& + label {
									color: blue;
								}
							}
						}

						input[id="radio-0"] {
							&:checked {
								~ .blob-container {
									transform: translateX(0%);
							.blob {
								animation: scaleY-0 .2s linear;
							}
								}
							}
						}

						input[id="radio-1"] {
							&:checked {
								~ .blob-container {
									transform: translateX(100%);
							.blob {
								animation: scaleY-1 .2s linear;
							}
								}
							}
						}

						input[id="radio-2"] {
							&:checked {
								~ .blob-container {
									transform: translateX(200%);
							.blob {
								animation: scaleY-2 .2s linear;
							}
								}
							}
						}

						input[id="radio-3"] {
							&:checked {
								~ .blob-container {
									transform: translateX(300%);
							.blob {
								animation: scaleY-3 .2s linear;
							}
								}
							}
						}

						@keyframes scaleY-0 {
						0%  { transform: scale(0);}
						60%  { transform: scaleY(0.5) translateY(30px); }
						100% { transform: scaleY(1);}
						}

						@keyframes scaleY-1 {
						0%  { transform: scale(0);}
						60%  { transform: scaleY(0.5) translateY(-30px); }
						100% { transform: scaleY(1);}
						}

						@keyframes scaleY-2 {
						0%  { transform: scale(0); }
						60%  { transform: scaleY(0.5) translateY(30px); }
						100% { transform: scaleY(1); }
						}

						@keyframes scaleY-3 {
						0%  { transform: scale(0); }
						60%  { transform: scaleY(0.5) translateY(-30px); }
						100% { transform: scaleY(1); }
						}
					</style>
						<div class="menu-container">
						
						<div class="menu" id="menu">
							
							<!-- <input type="radio" id="radio-0" name="menu" checked onclick="redirectPage(1)"/>
								<label class="tab" for="radio-0">
							<div class="item">
							<img src="<?= site_url('public/img/homegray.png'); ?>" style="width: 29px;height: 33px;">
								<div class="item-title">Home</div>
							</div>
							</label> -->
							
							<input type="radio" id="radio-1" name="menu" onclick="redirectPage(2)"/>
								<label class="tab" for="radio-1">
							<div class="item">
								<img src="<?= site_url('public/img/profilegray.png'); ?>" id="profileIcon" style="width: 29px;height: 33px;">
								<div class="item-title" id="protitle">Profile</div>
							</div>
							</label>
							
							<input type="radio" id="radio-2" name="menu" onclick="redirectPage(3)"/>
									<label class="tab" for="radio-2">
								<div class="item">
									<img src="<?= site_url('public/img/payslipgray.png'); ?>"  id="payslipIcon"  style="width: 30px;height: 33px;">
									<!-- <i class="fas fa-credit-card fa-2x"></i> -->
									<div class="item-title" id="paytitle">Payslip</div>
								</div>
								</label>
							
							<!-- <input type="radio" id="radio-3" name="menu" />
									<label class="tab" for="radio-3">
								<div class="item">
									<i class="fas fa-shopping-cart fa-2x"></i>
									<div class="item-title">Cart</div>
								</div>
								</label> -->
							
							<div class="blob-container">
							<div class="blob"></div>
							</div>

						</div>
						</div>
						<!-- <span>Copyright &copy; CGSI Portal 2023. All rights reserved by <b>CGSI MIS Team</b> </span> -->
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="<?= site_url('logout'); ?>">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="<?= site_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= site_url('public/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?= site_url('public/js/sb-admin-2.min.js'); ?>"></script>
    <!-- <script src="<?= site_url('public/vendor/datatables/jquery.dataTables.min.js'); ?>"></script> -->
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="<?= site_url('public/js/events/datatables.js'); ?>"></script>
	<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
	
	<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
	
</body>
</html>

<script>

	$(function(){
		// console.log(localStorage.getItem('menutab'));
		$("#"+localStorage.getItem('menutab')).attr('checked','checked');
		var tab = localStorage.getItem('menutab');
		if (tab == 'radio-1') {
			$("#userDropdown").html("Profile");
			$("#userDropdown").attr("style","color: white;font-size: 28px;position: absolute;top: 10px;right: 40%;");
			$("#profileIcon").attr("src","public/img/profileblue.png");
			$("#protitle").attr('style','color: blue');
		} else {
			$("#userDropdown").html("Payslip");
			$("#userDropdown").attr("style","color: white;font-size: 28px;position: absolute;top: 10px;right: 40%;");
			$("#payslipIcon").attr("src","public/img/payslipblue.png");
			$("#paytitle").attr('style','color: blue');
		}
	});

	function redirectPage(page) {
		// console.log(page);
		if(page === 2) {
			localStorage.setItem('menutab','radio-1');
			window.location.href = "profile";
		}
		if(page === 3) {
			localStorage.setItem('menutab','radio-2');
			window.location.href = "payslipindiv";
		}
	}
	
</script>