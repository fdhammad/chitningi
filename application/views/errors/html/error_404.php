<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<link href="/assets/img/logo/logo.png" rel="shortcut icon" type="image/x-icon">
	<meta name="author" content="">
	<title>404 Page Not Found</title>
	<link rel="stylesheet" href="/assets/css/app.css">
</head>

<body oncontextmenu="return false">
	<div id="app">
		<div class="height-full light">
			<div id="primary" class="content-area" data-bg-possition="center" data-bg-repeat="false" style="background: url('/assets/img/icon/icon-circles.png');">
				<div class="container">
					<div class="col-xl-8 mx-lg-auto p-t-b-80">
						<header class="text-center mb-5">
							<h1>Oops!</h1>
							<p class="section-subtitle"><?php echo $heading; ?>. <?php echo $message; ?></p>

						</header>
						<div class="pt-5 p-t-100 text-center">
							<p class="s-256">404</p>
						</div>
					</div>
				</div>
			</div>
			<!-- #primary -->
		</div>
	</div>
</body>

</html>