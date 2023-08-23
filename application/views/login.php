<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="PHP Simple Login with CodeIgniter Framework">
    <meta name="author" content="">

    <title>CGSI Portal - <?= ($page['title'] ?? 'Undefined'); ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= site_url('public/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= site_url('public/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

</head>

<style>
	.logindiv {
		height: 200px;
		width: 200px;
		/* background: linear-gradient(to bottom, #fff 0%, #fff 50%, #4E73DF 50%, #4E73DF 100%); */
	}
    .login {
        width: 90%;position: absolute;
    }
    @media (min-width:480px)  { 
        /* smartphones, Android phones, landscape iPhone */ 
        .login {
            width: 50%;position: absolute;left: 25%;
        }
    }
    @import "compass/css3";

	$color1: #ffffff;
	$color2: #1cff94;
	$color3: #1d2123;

	.xmas {
		height: 100%;
		width: 100%;
		position: relative;
		background: url('http://craftedbygc.com/images/xmas-large.jpg') no-repeat 0 0 / cover;

		.to {
			position: absolute;
			top: 30px;
			width: 100%;
			text-align: center;
			z-index: 3;

			div {
				font-family: "quimby-mayoral", sans-serif;
				color: $color1;
				font-size: 40px;
				line-height: 0.5em;
				margin-bottom: 5px;
			}

			.to-name {
				font-size: 24px;
			}

			.client-logo {
				display: block;
				width: auto;
				max-height: 100px;
				max-width: 250px;
				margin: 10px auto 0;
			}
		}
		.xmas-message {
			position: absolute;
			left: 50%;
			top: 50%;
			z-index: 2;
			@include translate(-50%, -50%);
			width: calc(90% - 6rem);
			height: calc(100% - 12rem);
			margin: 0 auto;
			background: url(http://craftedbygc.com/images/merryxmas.png) no-repeat 50% 50% / contain;
		}

		.from {
			position: absolute;
			bottom: 40px;
			width: 100%;
			z-index: 3;
			text-align: center;

			div {
				font-family: "quimby-mayoral", sans-serif;
				color: $color1;
				font-size: 40px;
				margin-bottom: 10px;
			}

			.gc-link {
				display: inline-block;
			font-family: "brandon-grotesque", sans-serif;
				font-size: 24px;
			color: $color1;
				transition: 400ms ease;
			text-decoration: none;
			text-transform: uppercase;
		
				&:hover {
					color: $color2;
				}
			}
		}
		
		// Let it snow!
		#xmas {
			width: 100%;
			height: 100%;
			position: relative;
			z-index: 2;
		}
	}

</style>

<body class="logindiv">
<canvas style="position: absolute"></canvas>
<!-- <canvas id="xmas" style="position: absolute"></canvas> -->
</section>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center login">

            <div class="col-md-8">

                <div class="o-hidden border-0" style="margin-top: 100px">
                    <div class="p-0" style="height: 500px;">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <div class="p-2">
                                    <div class="text-center">
                                        <!-- <h1 class="h2 text-gray-900 mb-2">CGSI PORTAL</h1> -->
                                        <img class="img-profile" style="width:115px" src="<?= site_url('public/img/cgsi.png'); ?>">
                                    </div>

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
                                    <?php endif; ?>

                                    <?= form_open('login', ['class' => 'user']); ?>
                                    <div class="form-group">
                                        <input style="height: 50px" type="text" class="form-control <?= (form_error('username') ? 'is-invalid' : ''); ?>" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                                        <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input  style="height: 50px" type="password" class="form-control <?= (form_error('password') ? 'is-invalid' : ''); ?>" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1">
                                            <label class="custom-control-label" for="remember">Remember Me</label>
                                        </div>
                                    </div> -->
                                    <button style="height: 50px;" type="submit" class="btn btn-primary btn-block">LOGIN</button>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= site_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= site_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= site_url('public/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= site_url('public/js/sb-admin-2.min.js'); ?>"></script>
    <script>
        $(document).ready(function(){

initLetItSnow();
});

// Init Christmas! \o/
var initLetItSnow = function(){

  (function() {
      var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame ||
      function(callback) {
          window.setTimeout(callback, 1000 / 60);
      };
      window.requestAnimationFrame = requestAnimationFrame;
  })();

  var flakes = [],
      canvas = document.getElementById("xmas"),
      ctx = canvas.getContext("2d"),
      mX = -100,
      mY = -100;

      if( $(window).width() < 999 ){
          var flakeCount = 125;
      } else {
          var flakeCount = 450;
      }

      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;

  function snow() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      for (var i = 0; i < flakeCount; i++) {
          var flake = flakes[i],
              x = mX,
              y = mY,
              minDist = 250,
              x2 = flake.x,
              y2 = flake.y;

          var dist = Math.sqrt((x2 - x) * (x2 - x) + (y2 - y) * (y2 - y)),
              dx = x2 - x,
              dy = y2 - y;

          if (dist < minDist) {
              var force = minDist / (dist * dist),
                  xcomp = (x - x2) / dist,
                  ycomp = (y - y2) / dist,
                  // deltaV = force / 2;
                  deltaV = force;

              flake.velX -= deltaV * xcomp;
              flake.velY -= deltaV * ycomp;

          } else {
              flake.velX *= .98;
              if (flake.velY <= flake.speed) {
                  flake.velY = flake.speed
              }
              flake.velX += Math.cos(flake.step += .05) * flake.stepSize;
          }

          ctx.fillStyle = "rgba(255,255,255," + flake.opacity + ")";
          flake.y += flake.velY;
          flake.x += flake.velX;
              
          if (flake.y >= canvas.height || flake.y <= 0) {
              reset(flake);
          }

          if (flake.x >= canvas.width || flake.x <= 0) {
              reset(flake);
          }

          ctx.beginPath();
          ctx.arc(flake.x, flake.y, flake.size, 0, Math.PI * 2);
          ctx.fill();
      }
      requestAnimationFrame(snow);
  };

  function reset(flake) {
      flake.x = Math.floor(Math.random() * canvas.width);
      flake.y = 0;
      flake.size = (Math.random() * 3) + 2;
      flake.speed = (Math.random() * 1) + 0.5;
      flake.velY = flake.speed;
      flake.velX = 0;
      flake.opacity = (Math.random() * 0.5) + 0.3;
  }

  function init() {
      for (var i = 0; i < flakeCount; i++) {
          var x = Math.floor(Math.random() * canvas.width),
              y = Math.floor(Math.random() * canvas.height),
              size = (Math.random() * 3) + 4,
              speed = (Math.random() * 1) + 0.5,
              opacity = (Math.random() * 0.5) + 0.3;

          flakes.push({
              speed: speed,
              velY: speed,
              velX: 0,
              x: x,
              y: y,
              size: size,
              stepSize: (Math.random()) / 160,
              step: 0,
              opacity: opacity
          });
      }

      snow();
  };

  canvas.addEventListener("mousemove", function(e) {
      mX = e.clientX,
      mY = e.clientY
  });

  window.addEventListener("resize",function(){
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
  })

  init();
};
        </script>

</body>

</html>