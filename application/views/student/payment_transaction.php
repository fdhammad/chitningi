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
				<?php if ($this->session->flashdata('toast')) { ?>
					<?php echo $this->session->flashdata('toast') ?>
				<?php } ?>
				<?php if ($this->session->flashdata('msg')) { ?>
					<?php echo $this->session->flashdata('msg') ?>
				<?php } ?>
				<?php echo $this->customlib->getCSRF(); ?>

				<!--begin::Content-->
				<div id="kt_app_content" class="app-content flex-column-fluid">
					<!--begin::Content container-->
					<div id="kt_app_content_container" class="app-container container-xxl">

						<!--begin::Row-->
						<div class="row g-5 g-xl-10 mb-5 mb-xl-10">

							<!--begin::Col-->

							<div class="col-xl-12">
								<div class="card card-flush pt-3 mb-0">
									<!--begin::Card header-->

									<!--end::Notice-->
									<div class="card-header">

										<!--begin::Card title-->
										<div class="card-title">
											<h2>Transaction Details</h2>
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

											<h5 class="mb-3">Payment details</h5>
											<!--end::Title-->
											<!--begin::Details-->
											<div class="mb-0">
												<!--begin::Plan-->
												<div class="table-responsive">
													<table class="table table-hover table-condensed" id="users">

														<thead>
															<tr>
																<th>#RRR </th>
																<th>#Ref </th>
																<th>Item</th>
																<th>Amount</th>
																<th>Response</th>
																<th>Date</th>
															</tr>
														</thead>
														<tbody>

															<?php

															foreach ($deposit as $value) {;
																$a = $value['receipt'];
																$b = array('-', '-');
																$c = array(
																	4, 8
																);

																for ($i = count($c) - 1; $i >= 0; $i--) {
																	$a = substr_replace($a, $b[$i], $c[$i], 0);
																} ?>
																<tr>
																	<?php if ($value['status'] == 'paid') {; ?> <td> <a href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/<?php echo $value['receipt']; ?>/printrecieptRequest.pdf" target="_blank"><?php echo $a; ?></a></td>
																	<?php } else {; ?>
																		<td> <a href="#"><?php echo $a; ?></a></td>
																	<?php } ?>
																	<td><?php echo $value['txn']; ?></td>
																	<td><?php echo $value['descr']; ?></td>
																	<td><?php echo $value['amount']; ?></td>
																	<td><?php if ($value['status'] == 'paid') {; ?> <span class="badge badge-outline badge-success"> <?php echo $value['status']; ?> <?php } else { ?><span class="badge badge-outline badge-warning"> <?php echo $value['status'];
																																																																	} ?> </span></td>
																	<td><?php echo $value['created_at']; ?></td>
																	<td><?php if ($value['status'] == 'paid') {; ?>
																			<!-- <button type="submit" class="btn btn-success btn-xs acceptance_receipt" id="<?php echo $value['receipt']; ?>"> <i class="icon-download"></i>Print Receipt</button>
																			 -->
																			<a href="<?= base_url('student/receipt/' . $value['receipt']) ?>" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-download"></i> Print Receipt</a>
																		<?php } else { ?> <form action="<?php echo base_url(); ?>student/check/<?php echo $value['receipt']; ?>" method="POST">

																				<input type="hidden" id="RRR" name="RRR" value="<?php echo $value['receipt']; ?>">

																				<input type="submit" class="btn btn-sm btn-info" name="submit_btn" value="Check Status">
																			</form>

																		<?php }; ?>
																	</td>
																</tr>
															<?php }; ?>
														</tbody>
													</table>
												</div>

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
	</div>