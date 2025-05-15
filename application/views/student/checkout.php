<!--begin::Main-->
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
									<h2>Payment Details</h2>
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

									<!--end::Title-->
									<!--begin::Details-->
									<div class="mb-0">
										<!--begin::Plan-->
										<table class="table">
											<tbody>
												<tr>
													<td>Student Name</td>
													<td><span class="text-uppercase"> <?php echo $student['firstname'] . ' ' . $student['lastname']; ?></span></td>
												</tr>

												<tr>
													<td>Amount </td>
													<td>&#8358;<span class="money"><strong><?php echo number_format($amount); ?></strong></span></td>
												</tr>
												<tr>
													<td>Payment Description </td>
													<td><?php echo $descr ?></td>
												</tr>
												<!-- 	<tr>
													<td>Status</td>
													<td><?php echo $status ?></td>
												</tr> -->
												<tr>
													<td>Generation Message</td>
													<td><?php echo $message ?></td>
												</tr>
												<tr>
													<td>Transaction Reference</td>
													<td><b style="font-size: 14px;"><?php echo $invoice_no; ?> </b></td>
												</tr>
												<tr>
													<td>RRR Number</td>
													<td><b style="font-size: 20px;"><?php echo $rrr; ?> </b>(Please write this down)</td>
												</tr>

												<tr>
													<td class="">

													</td>
													<td>
														<div class="row mt-4">
															<div class="col-3"> <a class="btn btn-primary" href="<?php echo base_url('student/payment/'); ?>" role="button"><i class="fa fa fa-cross"></i>Cancel</a>



															</div>
															<div class="col-3">
																<form action="<?php echo $authorization_url; ?>" method="POST">

																	<input type="submit" class="btn btn-success" name="submit_btn" value="Proceed Payment">
																</form>
															</div>
																<div class="col-3"> 
																
																<a class="btn btn-info" href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/<?php echo $rrr; ?>/printinvoiceRequest.pdf" target="_blank"><i class="fa fa fa-print"></i> Print RRR</a>
															</div>
														</div>
														

														<!-- <button type="submit" class="btn btn-success btn-xs receipt" id="<?php echo $invoice_no; ?>"> <i class="icon-download"></i>Print Invoice</button>
										 -->
														<!-- <form action="<?php echo $authorization_url; ?>" method="POST"> -->
														<!-- <input id="merchantId" name="merchantId" value="<?php echo $merchantId; ?>" type="hidden">
											<input id="hash" name="hash" value="<?php echo $hash; ?>" type="hidden">
											<input id="rrr" name="rrr" value="<?php echo $rrr; ?>" type="hidden">
											<input id="responseurl" name="responseurl" value="<?php echo $responseurl; ?>" type="hidden"> -->
														<!-- 	<input type="submit" class="btn btn-success float-center" name="submit_btn" value="Submit">

										</form> -->
													</td>
												</tr>
											</tbody>
										</table>

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
