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
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Payment</h1>
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
						<li class="breadcrumb-item text-muted">Checkout</li>
						<!--end::Item-->
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page title-->

			</div>
			<!--end::Toolbar container-->
		</div>
		<!--end::Toolbar-->

		<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
			<!--begin::Content wrapper-->
			<div class="d-flex flex-column flex-column-fluid">


				<!--begin::Content-->
				<div id="kt_app_content" class="app-content flex-column-fluid">
					<!--begin::Content container-->
					<div id="kt_app_content_container" class="app-container container-xxl">

						<!--begin::Row-->
						<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
							<?php if ($this->session->flashdata('toast')) { ?>
								<?php echo $this->session->flashdata('toast') ?>
							<?php } ?>
							<?php if ($this->session->flashdata('msg')) { ?>
								<?php echo $this->session->flashdata('msg') ?>
							<?php } ?>
							<?php echo $this->customlib->getCSRF(); ?>
							<!--begin::Col-->

							<div class="col-xl-10">
								<div class="card card-flush pt-3 mb-0">
									<!--begin::Card header-->
									<div class="row">
										<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed rounded-3 p-6">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack flex-grow-1">
												<!--begin::Content-->
												<div class="fw-semibold">
													<h4 class="text-gray-900 fw-bold">Important notice!</h4>
													<div class="fs-6 text-gray-700">Confirm your details below before proceeding.
														<!-- <a href="#" class="fw-bold">Pay now</a>. -->
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
											<h2>Student Details</h2>
										</div>
										<!--end::Card title-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0 fs-6">

										<!--begin::Seperator-->
										<div class="separator separator-dashed mb-7"></div>
										<!--end::Seperator-->
										<!--begin::Section-->
										<div class="mb-7">

											<!--begin::Details-->
											<div class="mb-0">
												<!-- <form action="<?php echo base_url(); ?>students/payment/pay_direct" method="POST">
													<?php echo $this->customlib->getCSRF(); ?>
													<input type="submit" class="btn btn-success" name="submit_btn" value="Pay Via Remita">
												</form> -->
												<!--begin::Plan-->
												<form id="general-info" action="<?= base_url('student/init_pre_pay_direct') ?>" method="POST" class="form-validation needs-validation" novalidate="novalidate" accept-charset="utf-8" enctype="multipart/form-data">
													<input type="hidden" id="amount" name="amount" value="<?= $amount ?>">
													<input type="hidden" id="student_id" name="student_id" value="<?= $student['id']; ?>">

													<table class="table">
														<tbody>
															<tr>
																<td>Student Name </td>
																<td><span class="text-uppercase"> <?php echo $student['firstname'] . ' ' . $student['lastname'] . ' ' . $student['middlename']; ?></span></td>
															</tr>
															<tr>
																<td>Course </td>
																<td><span class="text-capitalize"> <?php echo $student['course'] . " (" . $student['code'] . ")"; ?></span></td>
															</tr>

															<tr>
																<td>Payment Descr </td>
																<td><?php echo "Weeding Registration Fee"; ?></td>
															</tr>

															<tr>
																<td>Date</td>
																<td><b><?php echo date('d/m/Y H:i:s'); ?></b></td>
															</tr>

															<!-- <tr>
																<td>Payment Method</td>
																<td>
																	<div class="required form-group col-8 m-0">
																		<select id="method" name="method" aria-label="Select a method" data-control="select2" data-placeholder="Select a method..." class="form-select form-select-solid form-select-lg fw-semibold" required>
																			<option value=""></option>
																			<option value="card">Card</option>
																			<option value="bank">Bank</option>

																		</select>
																	</div>
																</td>
															</tr> -->
															<tr>
																<td><label class="fs-6 fw-semibold form-label">Amount you are Pay is:</label>
																</td>
																<td>
																	<div class="fw-bold text-primary pt-2" style="font-size: 24px ;"><span id="amount" class="amount">₦ <?= number_format($amount) ?></span></div>
																</td>
															</tr>
															<tr>
																<td class=""></td>
																<td class="">
																	<div class="row mt-4">
																		<div class="col-3"> <a class="btn btn-primary" href="<?php echo base_url('students/pre_payment/'); ?>" role="button"><i class="fa fa fa-cross"></i>Cancel</a>

																		</div>
																		<div class="col-5">
																			<button type="submit" class="btn btn-success">Pay With Remita</button>
																		</div>
																	</div>
																</td>

															</tr>
														</tbody>
													</table>
												</form>

											</div>
											<!--end::Details-->
										</div>
										<!--end::Section-->

										<!--end::Card body-->
									</div>
									<!--end::Card-->
								</div>
							</div>


						</div>
						<!--end::Row-->


					</div>
					<!--end::Content-->
				</div>
			</div>
		</div>