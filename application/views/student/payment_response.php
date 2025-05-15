<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<!--begin::Content wrapper-->
	<div class="d-flex flex-column flex-column-fluid">

		<div class="app-main flex-column flex-row-fluid mt-10" id="kt_app_main">
			<!--begin::Content wrapper-->
			<div class="d-flex flex-column flex-column-fluid">


				<!--begin::Content-->
				<div id="kt_app_content" class="app-content flex-column-fluid">
					<!--begin::Content container-->
					<div id="kt_app_content_container" class="app-container container-xxl">
						<?php if ($this->session->flashdata('toast')) { ?>
							<?php echo $this->session->flashdata('toast') ?>
						<?php } ?>
						<?php if ($this->session->flashdata('msg')) { ?>
							<?php echo $this->session->flashdata('msg') ?>
						<?php } ?>
						<?php echo $this->customlib->getCSRF(); ?>
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
												<form id="general-info" action="<?= base_url('student/init_pay') ?>" method="POST" class="section general-info" accept-charset="utf-8" enctype="multipart/form-data">
													<input type="hidden" id="inputAmount" name="inputAmount" value="">
													<input type="hidden" id="student_id" name="student_id" value="<?= $student['id']; ?>">

													<table class="table">
														<tbody>
															<tr>
																<td>Student Name </td>
																<td><span class="text-uppercase"> <?php echo $student['firstname'] . ' ' . $student['lastname']; ?></span></td>
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
																<td>Payment Descr </td>
																<td><?php echo $descr; ?></td>
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

																		<?php if ($status == "01") { ?> <div class="col-3">
																				<a class="btn btn-success" href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/<?= $RRR; ?>/printinvoiceRequest.pdf" role="button" target="_blank"><i class="fa fa fa-print"></i>Remita Receipt</a>
																			</div>
																			<div class="col-3">
																				<a class="btn btn-info" href="<?= base_url('student/receipt/' . $RRR) ?>" role="button" target="_blank"><i class="fa fa fa-print"></i>Portal Receipt</a>
																			</div><?php } else {
																				}; ?>

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