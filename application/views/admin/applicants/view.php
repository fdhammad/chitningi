<div class="page has-sidebar-left">
	<div>
		<header class="danger accent-3 relative">
			<div class="container-fluid text-white">
				<div class="row p-t-b-10 ">
					<div class="col">
						<div class="pb-3">
							<div class="image mr-3  float-left">
								<img class="user_avatar no-b no-p" src="<?php if (!empty($applicant['image'])) {
																			echo base_url() . $applicant['image'];
																		} else {
																			echo base_url() . "uploads/applicant_image/no_image.png";
																		} ?>" alt="User Image">
							</div>
							<div>
								<h6 class="p-t-10"><?php echo $applicant['firstname'] . " " . $applicant['lastname'] . " " . $applicant['middlename']; ?></h6>
								<?php echo 'Application No'; ?>: <b><?php echo $applicant['application_no']; ?></b> <br>

							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
						<li>
							<a class="nav-link" id="v-pills-back-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"><i class="icon icon-arrow-left"></i>back</a>
						</li>
						<li>
							<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"><i class="icon icon-home2"></i>Profile</a>
						</li>
					</ul>
				</div>

			</div>
		</header>

		<div class="container-fluid animatedParent animateOnce my-3">
			<div class="animated fadeInUpShort">
				<div class="tab-content" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
						<div class="row">
							<?php if ($this->session->flashdata('toast')) { ?>
								<?php echo $this->session->flashdata('toast') ?>
							<?php } ?>

							<div class="col-md-4">
								<div class="card ">
									<?php if ($this->session->flashdata('msg')) { ?>
										<?php echo $this->session->flashdata('msg') ?>
									<?php } ?>
									<h5 class="card-header primary text-center">COURSE OF CHOICE</h5>
									<ul class="list-group list-group-flush">
										<li class="list-group-item"><i class="icon icon-book3 text-warning"></i><strong class="s-11">First Choice</strong> <span class="float-right s-11"><?php
																																															echo $choice1; ?></span></li>
										<li class="list-group-item"><i class="icon icon-book3 text-primary"></i><strong class="s-11">Second Choice</strong> <span class="float-right s-11"><?php
																																															echo $choice2; ?></span></li>
									</ul>
								</div>
								<br>
								<div class="card ">

									<ul class="list-group list-group-flush">
										<ul class="list-group list-group-flush">
											<li class="list-group-item"><strong class="s-11">Institution</strong> <span class="float-right s-11"><?php echo $applicant['primary_school'] ?></span></li>
											<li class="list-group-item"><strong class="s-11">Certificate Obtained</strong> <span class="float-right s-11"><?php echo $applicant['primary_cert']; ?></span></li>
											<li class="list-group-item"><strong class="s-11">Year of Graduation</strong> <span class="float-right s-11"><?php echo $applicant['primary_school_year']; ?></span></li>
											<li class="list-group-item"><strong class="s-11">Institution</strong> <span class="float-right s-11"><?php echo $applicant['secondary_school']; ?></span></li>
											<li class="list-group-item"><strong class="s-11">Certificate Obtained</strong> <span class="float-right s-11"><?php echo $applicant['secondary_cert']; ?></span></li>
											<li class="list-group-item"><strong class="s-11">Year of Graduation</strong> <span class="float-right s-11"><?php echo $applicant['secondary_school_year']; ?></span></li>
										</ul>
									</ul>
								</div>

								<?php
								$count = 1;
								foreach ($neco as $value) { ?>
									<br>
									<div class="card ">
										<h5 class="card-header primary text-center"><?php echo $value['title']; ?> - <?php echo $value['exam_year']; ?> - (<?php echo $value['exam_no']; ?>)</h5>

										<ul class="list-group list-group-flush">
											<ul class="list-group list-group-flush">
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject']; ?></strong> <span class="float-right s-11"><?php echo $value['grade']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject2']; ?></strong> <span class="float-right s-11"><?php echo $value['grade2']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject3']; ?></strong> <span class="float-right s-11"><?php echo $value['grade3']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject4']; ?></strong> <span class="float-right s-11"><?php echo $value['grade4']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject5']; ?></strong> <span class="float-right s-11"><?php echo $value['grade5']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject6']; ?></strong> <span class="float-right s-11"><?php echo $value['grade6']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject7']; ?></strong> <span class="float-right s-11"><?php echo $value['grade7']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject8']; ?></strong> <span class="float-right s-11"><?php echo $value['grade8']; ?></span></li>
												<li class="list-group-item"><strong class="s-11"><?php echo $value['subject9']; ?></strong> <span class="float-right s-11"><?php echo $value['grade9']; ?></span></li>
											</ul>
										</ul>
									</div>
								<?php }; ?>
							</div>
							<br>
							<div class="col-md-6">
								<div class="row">
									<!-- bar charts group -->
									<div class="col-md-12">
										<div class="card">
											<h5 class="card-header white">BIO DATA
												<?php

												if ($applicant["status"] == "submitted") {
												?>

													<button type="button" href="<?php echo base_url(); ?>admin/applicant/admit/<?php echo $applicant['id'] ?>" class="btn btn-xs btn-primary float-sm-right ml-2" data-toggle="tooltip" title="Admit" data-original-title="Admit"><i class="icon-check"></i> Admit </button>
												<?php } elseif ($applicant["status"] == "admitted") { ?>
													<!-- <a href="<?php echo base_url() . 'admin/student/admission_pdf/' . $applicant['id']; ?>" type="button" class="btn btn-xs btn-success" target="_blank"><i class="icon icon-print"></i>Print Admission</a>
 -->
													<form action="<?php echo base_url('admin/applicant/print_admission') ?>" method="post">
														<input type="hidden" id="id" name="id" value="<?php echo $applicant['id']; ?>">
														<button style="margin-top: -10px;" type="button" class="btn btn-xs btn-success float-sm-right ml-2 print"><i class="icon icon-download"></i> <?php echo 'Print Admission Letter '; ?></button>
													</form>
												<?php
												} ?>

											</h5>
											<div class="card-body">
												<ul class="list-group list-group-flush">
													<li class="list-group-item"><strong class="s-11">Application Number</strong> <span class="float-right s-11"><?php echo $applicant['application_no']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Date of Birth</strong> <span class="float-right s-11"><?php echo $applicant['dob']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Phone</strong> <span class="float-right s-11"><?php echo $applicant['phone']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Email</strong> <span class="float-right s-11"><?php echo $applicant['email']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Gender</strong> <span class="float-right s-11"><?php echo $applicant['gender']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Phone</strong> <span class="float-right s-11"><?php echo $applicant['phone']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">State</strong> <span class="float-right s-11"><?php echo $applicant['state']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Religion</strong> <span class="float-right s-11"><?php echo $applicant['religion']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Marital Status</strong> <span class="float-right s-11"><?php echo $applicant['marital_status']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Application Date</strong> <span class="float-right s-11"><?php echo $applicant['admission_date']; ?></span></li>
												</ul>
											</div>
										</div>
										<br>
										<div class="card">
											<div class="card-header white">
												<h4>ADDRESS DETAILS</h4>
											</div>
											<div class="card-body">
												<ul class="list-group list-group-flush">
													<li class="list-group-item"><strong class="s-11">Current Address</strong> <span class="float-right s-11"><?php echo $applicant['current_address']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Permanent Address</strong> <span class="float-right s-11"><?php echo $applicant['permanent_address']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Local Government</strong> <span class="float-right s-11"><?php echo $applicant['local_government']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">State</strong> <span class="float-right s-11"><?php echo $applicant['state']; ?></span></li>

												</ul>
											</div>
										</div>
										<br>
										<div class="card">
											<div class="card-header white">
												<h4>PARENT/GUARDIANT DETAILS</h4>
											</div>
											<div class="card-body">
												<ul class="list-group list-group-flush">
													<li class="list-group-item"><strong class="s-11">Guardian Name</strong> <span class="float-right s-11"><?php echo $applicant['guardian_name']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Guardian Phone</strong> <span class="float-right s-11"><?php echo $applicant['guardian_phone']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Guardian Email</strong> <span class="float-right s-11"><?php echo $applicant['guardian_email']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Guardian Address</strong> <span class="float-right s-11"><?php echo $applicant['guardian_address']; ?></span></li>

												</ul>
											</div>
										</div>
									</div>
									<!-- /bar charts group -->
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
