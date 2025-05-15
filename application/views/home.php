<!-- <body oncontextmenu="return false" class="alt-menu sidebar-noneoverflow"> -->
<div class="helpdesk container">
	<nav class="navbar navbar-expand navbar-light">
		<h6 class="text-white mine">Email: <?php echo get_settings('system_email'); ?></h6>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link mine" href="#">Need Help? CALL: <i class="fa fa-phone"></i></abbr> <b>+234 803 615 2791, +234 806 221 8873</b></a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- <a href="<?php echo base_url(); ?>admission"><img src="<?php echo base_url('assets/img/logo/ascoea.png'); ?>" height="70px" width="350px" /></a> -->
	<div class="helpdesk layout-spacing">
		<div class="hd-header-wrapper">
			<div class="row">
				<div class="col-md-12 text-center">
					<h4 class=""><img src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="ascoea logo" /></h4>
					<h2 class="text-white"><b><span><?php echo get_settings('system_name'); ?></span></b></h2>

					<div class="row">
						<div class="col-xl-6 col-lg-7 col-md-7 col-sm-11 col-11 mx-auto">
							<div class="btn-group mt-3 shadow" role="group" aria-label="Basic example">
								<a type="button" href="https://ascoea.edu.ng/" class="btn btn-primary">Website</a>
								<a href="<?= base_url('admission'); ?>" class="btn btn-primary">Admission</a>
								<a href="<?= base_url('screening'); ?>" class="btn btn-primary">Screening</a>
								<a href="https://pgsp.ascoea.edu.ng/main" class="btn btn-primary">PG & Sub-Degree</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bio layout-spacing ">
			<div class="col-lg-12">

				<!-- <div class="alert alert-success mb-4 text-center role=" alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i data-feather="x"></i></button>
						<h6><strong> Notice:</strong> All the Payments services have now been rectified. Thank you<strong id="demo"> </strong></h6>
					</div> -->
				<!-- 	<p class="text-center" id="demo"></p> -->
				<div class="alert alert-danger mb-4 text-center role=" alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i data-feather="x"></i></button>
					<h6><strong> Notice:</strong> Registration Closed<strong id="demo"> </strong></h6>
				</div>



			</div>
			<div class="widget-content widget-content-area">

				<div class="bio-skill-box">

					<div class="row">

						<div class="col-12 col-xl-6 col-lg-6 mb-xl-4 mb-4 ">

							<div class="d-flex b-skills">

								<div>
								</div>
								<div class="">
									<h5>PROSPECTIVE STUDENTS</h5>
									<p>Applicants can access their respective portals and pay their application fees, generate application token, apply for admission, print application form and more.</p>
									<a href="<?= base_url('applicant/login/'); ?>" class="btn btn-block btn-info">Applicants Login</a>
								</div>
							</div>

						</div>

						<div class="col-12 col-xl-6 col-lg-6 mb-xl-4 mb-4 ">

							<div class="d-flex b-skills">
								<div>
								</div>
								<div class="">
									<h5>NCE STUDENTS</h5>
									<p>NCE students can access their respective portals and pay their fees, do online course registrations, apply for accommodation, check their semester results and more.</p>
									<a href="<?= base_url('nce/login/'); ?>" class="btn btn-block btn-primary">NCE Login</a>
								</div>
							</div>

						</div>

						<div class="col-12 col-xl-6 col-lg-6 mb-xl-4 mb-4 mx-auto">

							<div class="d-flex b-skills">
								<div>
								</div>
								<div class="">
									<h5>PRE-NCE STUDENTS</h5>
									<p>PRE-NCE students can access their respective portals and pay their fees, do online course registrations, apply for accommodation, check their semester results and more.</p>
									<a href="<?= base_url('pre/login/'); ?>" class="btn btn-block btn-success">PRE-NCE Login</a>
								</div>
							</div>

						</div>

						<div class="col-12 col-xl-6 col-lg-6 mb-xl-4 mb-4 ">

							<div class="d-flex b-skills">
								<div>
								</div>
								<div class="">
									<h5>UNDERGRADUATE STUDENTS</h5>
									<p>UG Students can access their respective portals and pay their fees, do online course registrations, apply for accommodation, check their semester results and more.</p>
									<a href="https://ug.ascoea.edu.ng/" class="btn btn-block btn-warning">UG Login</a>
								</div>
							</div>

						</div>
						<div class="col-12 col-xl-6 col-lg-6 mb-xl-0 mb-5 ">

							<div class="d-flex b-skills">
								<div>
								</div>
								<div class="">
									<h5>PG & SUB-DEGREE STUDENTS</h5>
									<p>Post Undergraduate & Sub-Degree Students can access their respective portals and pay their fees, do online course registrations, check their semester results and more.</p>
									<a href="https://pgsp.ascoea.edu.ng/main" class="btn btn-block btn-danger">PG & Sub-degree</a>
								</div>
							</div>

						</div>

					</div>

				</div>

			</div>
		</div>

	</div>
</div>

<div id="miniFooterWrapper" class="">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="position-relative">
					<div class="arrow text-center">
						<p class="">Up</p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5 mx-auto col-lg-6 col-md-6 site-content-inner text-md-left text-center copyright align-self-center">
						<p class="mt-md-0 mt-4 mb-0">Copyright <?php echo date('Y'); ?> &copy; ASCOEA</p>
					</div>
					<div class="col-xl-5 mx-auto col-lg-6 col-md-6 site-content-inner text-md-right text-center copyright align-self-center">
						<p class="mb-0">Developed By <a target="_blank" href="https://diidol.com/">DIIDOL</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- </body> -->
