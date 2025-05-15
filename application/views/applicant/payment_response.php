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
						<li class="breadcrumb-item text-muted">Payment Response</li>
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

							<!--begin::Col-->

							<div class="col-xl-10">
								<div class="card card-flush pt-3 mb-0">
									<!--begin::Card header-->

									<div class="card-header">

										<!--begin::Card title-->
										<div class="card-title">
											<h2>Payment Status</h2>
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
											<!--begin::Title-->

											<!-- <h5 class="mb-3">Payment details</h5> -->
											<!--end::Title-->
											<!--begin::Details-->
											<div class="mb-0">
												<!--begin::Plan-->
												<form id="general-info" action="<?= base_url('applicant/init_pay') ?>" method="POST" class="section general-info" accept-charset="utf-8" enctype="multipart/form-data">
													<input type="hidden" id="inputAmount" name="inputAmount" value="">
													<input type="hidden" id="applicant_id" name="applicant_id" value="<?= $applicant['id']; ?>">

													<table class="table">
														<tbody>
															<tr>
																<td>Applicant Name </td>
																<td><span class="text-uppercase"> <?php echo $applicant['firstname'] . ' ' . $applicant['lastname']; ?></span></td>
															</tr>
															<tr>
																<td>Payment Transaction No</td>
																<td><b><?php echo $ref; ?></b></td>
															</tr>
															<tr>
																<td>Amount </td>
																<td>&#8358;<span class="money"> <strong><?php echo $amount; ?></strong></span></td>
															</tr>
																<tr>
																<td>Charges </td>
																<td>&#8358;<span class="money"> <strong><?php echo 322.50; ?></strong></span></td>
															</tr>

															<tr>
																<td>Payment Descr </td>
																<td><?php echo "Online Application Fee"; ?></td>
															</tr>

															<tr>
																<td>Payment Message</td>
																<td>Payment <b><?php echo $message; ?></b></td>
															</tr>
															<tr>
																<td>Payment Status</td>
																<td><?php echo $status; ?></td>
															</tr>
															<tr>
																<td>Remita Refrence Number(RRR)</td>
																<td><b><?php echo $RRR; ?> </b>(Please write this down)</td>
															</tr>


															<tr>
																<td class=""></td>
																<td class="">
																	<div class="row mt-4">
																		<div class="col-3">
																			<button type="button" class="btn btn-primary" onclick="history.go(-1);"> Go Back </button>
																		</div>
																		<div class="col-5">
																			<?php if ($status == "01") { ?><a class="btn btn-success" href="<?= base_url('applicant/receipt/' . $RRR) ?>" role="button"><i class="fa fa fa-print"></i>Print Receipt</a><?php } else {
																																																													}; ?>
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
