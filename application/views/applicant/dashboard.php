<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<!--begin::Content wrapper-->
	<div class="d-flex flex-column flex-column-fluid">
		<!--begin::Toolbar-->
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<!--begin::Toolbar container-->
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<!--begin::Title-->
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Default</h1>
					<!--end::Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<!--begin::Item-->
						<li class="breadcrumb-item text-muted">
							<a href="?page=index" class="text-muted text-hover-primary">Home</a>
						</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item">
							<span class="bullet bg-gray-400 w-5px h-2px"></span>
						</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item text-muted">Dashboard</li>
						<!--end::Item-->
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page title-->

			</div>
			<!--end::Toolbar container-->
		</div>
		<!--end::Toolbar-->

		<!--begin::Content-->
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<!--begin::Content container-->
			<div id="kt_app_content_container" class="app-container container-xxl">

				<!--begin::Row-->
				<div class="row g-5 g-xl-10 mb-5 mb-xl-10">

					<!--begin::Col-->
					<div class="col-xl-5">
						<!--begin::Engage widget 9-->
						<div class="card" style="background: linear-gradient(112.14deg, #77132B 0%, #772316 100%)">
							<!--begin::Body-->
							<div class="card-body">
								<!--begin::Row-->
								<div class="row align-items-center">

									<!--begin::Col-->
									<div class="col-sm-5 ">
										<!--begin::Illustration-->
										<img src="<?php echo $this->applicant_model->get_user_image_url($this->session->userdata('user_id')); ?>" class="symbol symbol-50px h-150px h-md-180px my-n6" alt="" />
										<!--end::Illustration-->
									</div>

									<!--begin::Col-->
									<div class="col-sm-7 pe-0 mb-5 mb-sm-0">
										<!--begin::Wrapper-->
										<div class="d-flex justify-content-between h-100 flex-column pt-xl-5 pb-xl-2 ps-xl-7">
											<!--begin::Container-->
											<div class="mb-4">
												<!--begin::Title-->
												<div class="mb-4">
													<h4 class="fs-2x fw-semibold text-white"><?php echo $applicant['firstname'] . ' ' . $applicant['lastname']; ?></h4>
													<?php if ($token != null) : ?>
														<span class="fw-semibold text-white opacity-75">Application No: <?php echo $applicant['application_no'] ?></span>
													<?php endif ?>
													<!-- 	<span class="fw-semibold text-white opacity-75">Welcome Back</span> -->
												</div>
												<!--end::Title-->
												<!--begin::Items-->

											</div>
											<!--end::Container-->
											<!--begin::Action-->
											<div class="m-0">
												<a href="#" class="btn btn-color-white bg-white bg-opacity-15 bg-hover-opacity-25 fw-semibold">Application Status: <?php if ($applicant['status'] == 'not submitted') : ?><span class="badge badge-light-danger">Not Submitted</span><?php elseif ($applicant['status'] == 'pending') : ?><span class="badge badge-light-warning">Pending</span><?php elseif ($applicant['status'] == 'progress') : ?><span class="badge badge-light-info">Progress</span><?php elseif ($applicant['status'] == 'submitted' || $applicant['status'] == 'finalize') : ?><span class="badge badge-light-info">Submitted</span><?php elseif ($applicant['status'] == 'admitted' || $applicant['status'] == 'approved') : ?><span class="badge badge-light-success">Admitted</span> <?php endif ?></a>

											</div>
											<!--begin::Action-->
										</div>
										<!--end::Wrapper-->
									</div>

								</div>
								<!--begin::Row-->
							</div>

							<!--end::Body-->
						</div>
						<!--end::Engage widget 9-->
					</div>
					<!--end::Col-->
					<div class="col-xl-7">
						<?php if ($token == NULL) : ?>
							<div class="card card-flush pt-3 mb-0">
								<!--begin::Card header-->

								<div class="row">
									<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed rounded-3 p-6">
										<!--begin::Wrapper-->
										<div class="d-flex flex-stack flex-grow-1">
											<!--begin::Content-->
											<div class="fw-semibold">
												<h4 class="text-gray-900 fw-bold">Important notice!</h4>
												<div class="fs-6 text-gray-700">Its appears that you are a new applicant, click on pay now to process
													<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card" class="fw-bold">Pay now</a>.
												</div>
											</div>
											<!--end::Content-->
										</div>
										<!--end::Wrapper-->
									</div>
								</div>
								<!--end::Notice-->
								<div class="card-header">

									<!--begin::Card title-->
									<div class="card-title">
										<h2>Applicant Details</h2>
									</div>
									<!--end::Card title-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body pt-0 fs-6">
									<!--begin::Section-->
									<div class="mb-7">


										<!--begin::Title-->
										<!-- 	<h5 class="mb-3">BioData</h5> -->
										<!--end::Title-->
										<!--begin::Details-->
										<div class="d-flex align-items-center mb-1">
											<!--begin::Name-->
											<a href="#" class="fw-bold text-gray-800 text-hover-primary me-2">Name: <?php echo $applicant['firstname'] . ' ' . $applicant['lastname']; ?></a>
											<!--end::Name-->

										</div>

										<!--end::Details-->
										<!--begin::Email-->

										<div class="d-flex align-items-center mb-1">

											<a href="#" class="fw-semibold text-gray-800 text-hover-primary">Email: <?php echo $applicant['email']; ?></a>

										</div>
										<div class="d-flex align-items-center mb-1">

											<a href="#" class="fw-bold text-gray-800 text-hover-primary me-2">Phone Number: <?php echo $applicant['phone']; ?></a>

										</div>
										<!--end::Email-->
									</div>
									<!--end::Section-->
									<!--begin::Seperator-->
									<!-- 	<div class="separator separator-dashed mb-7"></div> -->
									<!--end::Seperator-->
									<!--begin::Section-->
									<!-- 	<div class="mb-7">
									<h5 class="mb-3">Program details</h5>
									<div class="mb-0">
										<span class="fw-semibold text-gray-600">Program: <?= $applicant['name'] ?></span>
									</div>

								</div> -->
									<!--end::Section-->
									<!--begin::Seperator-->
									<div class="separator separator-dashed mb-7"></div>
									<!--end::Seperator-->
									<!--begin::Section-->
									<div class="mb-10">
										<!--begin::Title-->
										<h5 class="mb-3">Payment Details</h5>
										<!--end::Title-->
										<!--begin::Details-->
										<div class="mb-0">
											<!--begin::Card info-->
											<div class="fw-semibold text-gray-600 d-flex align-items-center">Application Fee
												<img src="assets/media/svg/card-logos/mastercard.svg" class="w-35px ms-2" alt="" />
											</div>
											<!--end::Card info-->

											<!--begin::Card expiry-->
											<div class="amount fw-bold text-primary pt-2" id="amount">--</div>
											<!--end::Card expiry-->
										</div>
										<!--end::Details-->
									</div>
									<!--end::Section-->
									<!--begin::Actions-->
									<div class="mb-0">

										<a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">Pay Now</a>
									</div>
									<!--end::Actions-->
								</div>
								<!--end::Card body-->
							</div>
						<?php else : ?>
							<div class="card card-flush pt-3 mb-0">
								<div class="card-header">

									<!--begin::Card title-->
									<div class="card-title">
										<h2>Applicant Details</h2>
									</div>
									<!--end::Card title-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body pt-0 fs-6">
									<!--begin::Section-->
									<div class="mb-7">
										<div class="table-responsive">
											<table class="table table-hover table-condensed">
												<thead>
													<tr>
														<td><b>#ID
															</b></td>
														<td><b>Forms
															</b></td>
														<td><b>Status
															</b></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1
														</td>
														<td>Bio-Data Form
														</td>
														<?php if ($applicant['current_address'] != NULL) { ?>
															<td class="text-success">
																<i class="bi bi-check-square-fill text-success fs-2x">
																</i>
															<?php } else { ?>
															<td class="text-danger">
																<i class="bi bi-x-square-fill text-danger fs-2x">
																</i>
															<?php } ?>
															</td>
													</tr>
													<!-- <tr>
														<td>2
														</td>
														<td>Educational Background
														</td>
														<?php if ($applicant['sitting'] != NULL) { ?>
															<td class="text-success">
																<i data-feather="check-circle">
																</i>
															<?php } else { ?>
															<td class="text-danger">
																<i data-feather="x-square">
																</i>
															<?php } ?>
															</td>
													</tr>
 -->
													<tr>
														<td>2
														</td>
														<td>O-Level/A-Level Result
														</td>
														<?php if ($applicant['title'] != NULL) { ?>
															<td class="text-success">
																<i class="bi bi-check-square-fill text-success fs-2x">
																</i>
															<?php } else { ?>
															<td class="text-danger">
																<i class="bi bi-x-square-fill text-danger fs-2x">
																</i>
															<?php } ?>
															</td>
													</tr>
													<tr>
														<td>3
														</td>
														<td>Course Choice
														</td>
													<?php if ($applicant['grade8'] != null) { ?>
															<td class="text-success">
																<i class="bi bi-check-square-fill text-success fs-2x">
																</i>
															<?php } else { ?>
															<td class="text-danger">
																<i class="bi bi-x-square-fill text-danger fs-2x">
																</i>
															<?php } ?>

															</td>
													</tr>
													<tr>
														<td>4
														</td>
														<td>Declaration
														</td>

													<?php if ($applicant['grade8'] != null) { ?>
															<td class="text-success">
																<i class="bi bi-check-square-fill text-success fs-2x">
																</i>
															<?php } else { ?>
															<td class="text-danger">
																<i class="bi bi-x-square-fill text-danger fs-2x">
																</i>
															<?php } ?>
															</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div class="row">
										<div class="col-md-12 text-center">
											<span class="color7">

												<b>Admission Status:</b> <?php if ($applicant['status'] != "admitted") { ?>

													<span class="badge badge-warning"> <?php echo $applicant['status'] ?>
													</span><?php } else { ?> <span class="badge badge-success"><i class="fa fa-check-circle"></i> <?php echo $applicant['status'] ?>
													</span><?php } ?>

											</span>
										</div>
										<br>
										<div class="col-md-6">
											<?php if ($applicant['status'] == 'not submitted' || $applicant['status'] == 'Not Submitted') { ?>
												<span>
													<!-- <a href="<?php echo base_url('applicant/adform/'); ?>" class="btn btn-lg btn-success"> -->
													<a href="<?php echo base_url('applicant/adform/'); ?>" class="btn btn-lg btn-primary">
														<i class="fa fa-file-text"></i> Proceed to application
													</a>
													<!-- target="_blank" -->
												</span>

											<?php } elseif ($applicant['status'] == 'saved') { ?>
												<span>
													<a href="<?php echo base_url('applicant/adform/'); ?>" class="btn btn-lg btn-warning">
														<i class="fa fa-file-text"></i> Continue application
													</a>
													<!-- target="_blank" -->
												</span>

											<?php } else { ?>
												<span>
													<!-- <form action="<?php echo base_url('applicant/print_slip') ?>" method="post">
														<input type="hidden" id="id" name="id" value="<?php echo $applicant['id']; ?>">
														<button type="button" class="btn btn-success mt-3 print"><i data-feather="download"></i> <?php echo 'Print Acknowledgement '; ?></button>
													</form>
 -->
													<a href="<?php echo base_url() . 'applicant/acknown_form_pdf/'; ?>" type="button" title="Generate Semester Form" class="btn btn-xs btn-success mb-2" target="_blank"><i class="fa fa-print"></i><?php echo 'Print Acknowledgement '; ?></a>


												</span>
											<?php } ?>
										</div>

									</div>
								</div>
							</div>

						<?php endif ?>
						<!--end::Card-->
					</div>
				</div>
				<!--end::Row-->
			</div>
			<!--end::Content-->
		</div>
	</div>

<!--begin::Modal - New Card-->
<div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2>Payment Method</h2>
				<!--end::Modal title-->
				<!--begin::Close-->
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
					<span class="svg-icon svg-icon-1">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
							<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
						</svg>
					</span>
					<!--end::Svg Icon-->
				</div>
				<!--end::Close-->
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
				<!--begin::Form-->
				<form id="init_payment" class="form" action="<?= base_url('applicant/init_pay') ?>" method="POST">
					<!--begin::Input group-->
					<input type="hidden" id="inputAmount" name="inputAmount" value="">
					<input type="hidden" id="applicant_id" name="applicant_id" value="<?= $applicant['id']; ?>">
					<!--begin::Input group-->
					<div class="row mb-10">
						<!--begin::Col-->
						<div class="col-md-12 fv-row">
							<!--begin::Label-->
							<label class="required fs-6 fw-semibold form-label mb-2">Program</label>
							<!--end::Label-->
							<!--begin::Row-->
							<div class="row fv-row">
								<!--begin::Col-->
								<div class="col-12">
									<select id="program" name="program" aria-label="Select a programme" data-control="select2" data-placeholder="Select a programme..." class="form-select form-select-solid form-select-lg fw-semibold">
										<option value=""></option>
										<option value="1">HND</option>
										<option value="2">ND</option>
										<option value="3">Diploma</option>


									</select>
								</div>
								<!--end::Col-->
								<label class="required fs-6 fw-semibold form-label mb-2">Payment Method</label>
								<!--begin::Col-->
								<div class="col-12">

									<select id="method" name="method" aria-label="Select a method" data-control="select2" data-placeholder="Select a method..." class="form-select form-select-solid form-select-lg fw-semibold">
										<option value=""></option>
										<option value="card">Card</option>
										<option value="bank">Bank</option>

									</select>
								</div>
								<!--end::Col-->
							</div>
							<!--end::Row-->
						</div>


						<!--end::Col-->
					</div>
					<!--end::Input group-->
					<!--begin::Input group-->
					<div class="d-flex flex-stack">
						<!--begin::Label-->
						<div class="me-5">
							<label class="fs-6 fw-semibold form-label">Amount you are Pay is:</label>
							<div class="fw-bold text-primary pt-2" style="font-size: 24px ;"><span id="modalAmount" class="amount">--</span></div>
						</div>
						<!--end::Label-->
						<!--begin::Switch-->
						<!-- <label class="form-check form-switch form-check-custom form-check-solid">
							<input class="form-check-input" type="checkbox" value="1" checked="checked" />
							<span class="form-check-label fw-semibold text-muted">Save Card</span>
						</label> -->
						<!--end::Switch-->
					</div>
					<!--end::Input group-->
					<!--begin::Actions-->
					<div class="text-center pt-15">
						<button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
						<button type="submit" id="ktsubmit" class="btn btn-primary">
							<span class="indicator-label">Submit</span>
							<span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
					</div>
					<!--end::Actions-->
				</form>
				<!--end::Form-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->


<!--begin::Modal - New Card-->
<div class="modal fade" id="kt_modal_pass" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2>Update Name</h2>
				<!--end::Modal title-->
				<!--begin::Close-->
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
					<span class="svg-icon svg-icon-1">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
							<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
						</svg>
					</span>
					<!--end::Svg Icon-->
				</div>
				<!--end::Close-->
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
				<!--begin::Form-->
				<form id="update_name" class="form" action="<?= base_url('applicant/update_name') ?>" method="POST">
					<!--begin::Input group-->
					<input type="hidden" id="applicant_id" name="applicant_id" value="<?= $applicant['id']; ?>">
					<!--begin::Input group-->
						<div class="row g-9 mb-8">
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label for="firstname" class="required fs-6 fw-semibold mb-2">First Name</label>
								<input type="text" placeholder="First Name" name="firstname" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label for="lastname" class="required fs-6 fw-semibold mb-2">Last Name</label>
								<input type="text" placeholder="Last name" name="lastname" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
						</div>

						<div class="row g-9 mb-8">
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label class="required fs-6 fw-semibold mb-2">Email</label>
								<input type="text" placeholder="Email" name="email" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label class="required fs-6 fw-semibold mb-2">Phone Number</label>
								<input type="text" placeholder="Phone Number" name="phone" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row g-9 mb-8">
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label for="password" class="required fs-6 fw-semibold mb-2">Password</label>
								<input id="password" type="password" placeholder="**************" name="password" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label for="confirm_password" class="required fs-6 fw-semibold mb-2">Confirm Password</label>
								<input type="password" placeholder="*************" name="confirm_password" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
						</div>
						
						<!--end::Input group=-->
					<!--begin::Actions-->
					<div class="text-center pt-15">
						<button type="reset" id="kt_modal_pass_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
						<button type="submit" id="kt_submit" class="btn btn-primary">
							<span class="indicator-label">Submit</span>
							<span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
					</div>
					<!--end::Actions-->
				</form>
				<!--end::Form-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
