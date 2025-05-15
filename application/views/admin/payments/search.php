<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-money"></i>
						Search RRR Number
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" href="<?php echo base_url(); ?>admin/payments/search" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>Search Payment</a>
					</li>
					<li class="float-right">
						<a class="nav-link" href="<?php echo base_url(); ?>admin/payments/report"><i class="icon icon-documents"></i>Payments Report</a>
					</li>
					<li class="float-right">
						<a class="nav-link" href="<?php echo base_url(); ?>admin/payment/check_rrr"><i class="icon icon-search"></i>Check RRR Status</a>
					</li>
				</ul>
			</div>
		</div>
	</header>
	<div class="container-fluid my-3">
		<?php if ($this->session->flashdata('msg')) { ?>
			<?php echo $this->session->flashdata('msg') ?>
		<?php } ?>
		<?php if ($this->session->flashdata('toast')) { ?>
			<?php echo $this->session->flashdata('toast') ?>
		<?php } ?>
		<div class="row">

			<div class="col-md-12">

				<div class="card shadow">
					<div class="card-header">
						<h5 class="card-title"><i class="icon icon-search"></i> <?php echo site_phrase('select_criteria'); ?></h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">

								<form role="form" action="<?php echo site_url('admin/payments/search') ?>" method="post" class="">
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="col-md-12">
										<div class="form-group">
											<label><?php echo "Search By RRR"; ?></label>
											<input id="receipt" name="receipt" type="text" class="form-control form-control-lg r-0" style="font-size: 40px; letter-spacing: 5px;" placeholder="">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<button type="submit" name="search" value="search_full" class="btn btn-danger pull-right r-0"><i class="icon icon-search"></i> <?php echo site_phrase('search'); ?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php if (isset($feeList)) {
				?>

					<div class="container-fluid animatedParent animateOnce">
						<div class="tab-content my-3" id="v-pills-tabContent">
							<div class="tab-pane animated fadeInUpShort show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
								<div class="row my-3">
									<div class="col-md-12">
										<div class="card my-3 no-b shadow">
											<div class="card-body">
												<table class="table table-striped table-bordered table-hover example">
													<thead>
														<tr>
															<th><?php echo 'Image'; ?></th>
															<th><?php echo 'Receipt'; ?></th>
															<th><?php echo site_phrase('reg_no'); ?></th>
															<th><?php echo site_phrase('name'); ?></th>
															<th><?php echo 'Descr'; ?></th>
															<th><?php echo 'Status'; ?></th>
															<th><?php echo 'Date'; ?></th>

															<th class="text text-right"><?php echo site_phrase('amount'); ?></th>

														</tr>
													</thead>
													<tbody>
														<?php
														$amount = 0;
														$discount = 0;
														$fine = 0;
														$total = 0;
														$grd_total = 0;
														if (empty($feeList)) {
														?>
														<?php
														} else {
															$count = 1;
															$a = $feeList->receipt;
															$b = array('-', '-');
															$c = array(
																4, 8
															);

															for ($i = count($c) - 1; $i >= 0; $i--) {
																$a = substr_replace($a, $b[$i], $c[$i], 0);
															}

														?>
															<tr>
																<td>
																	<div class="avatar avatar-lg mr-3 mt-1 float-left">
																		<img src="<?php if (!empty($feeList->image)) {
																						echo base_url() . $feeList->image;
																					} else {
																						echo base_url() . "uploads/student_images/no_image.png";
																					} ?>" alt="User Image">
																	</div>
																</td>
																<td><a href="<?php echo base_url() ?>admin/payments/receipt/<?php echo $feeList->receipt; ?>" target="_blank"><?php echo $a; ?></a></td>
																<td>
																	<?php echo $feeList->reg_no; ?>
																</td>
																<td>
																	<?php echo $feeList->firstname . " " . $feeList->lastname . " " . $feeList->middlename; ?>
																</td>

																<td class="text-uppercase">
																	<?php echo $feeList->descr; ?>
																</td>

																<td><?php if ($feeList->status == "paid") { ?><span class="badge badge-success">Paid</span><?php } else { ?><span class="badge badge-warning"><?php echo $feeList->status; ?></span><?php }; ?></td>

																<td>
																	<?php echo $feeList->date; ?>
																</td>

																<td class="text text-right">
																	<?php
																	$amount = number_format($feeList->amount, 2, '.', '');
																	echo  $amount;
																	?>
																</td>
																<?php if ($feeList->status != 'paid') { ?>

																	<td>
																		<form action="<?php echo base_url(); ?>admin/payments/check_payment_status_search/<?php echo $feeList->student_id; ?>" method="POST">

																			<input id="RRR" name="RRR" value="<?php echo $feeList->receipt; ?>" type="hidden">

																			<input type="submit" class="btn btn-sm r-3 btn-info" name="submit_btn" value="Check Status">
																		</form>
																	</td>
																<?php

																} elseif ($feeList->status != 'paid' && $feeList->descr == 'hostel') { ?>
																	<td>
																		<form action="<?php echo base_url(); ?>admin/payments/other_status2/<?php echo $feeList->student_id; ?>" method="POST">

																			<input id="RRR" name="RRR" value="<?php echo $feeList->receipt; ?>" type="hidden">

																			<input type="submit" class="btn btn-sm r-3 btn-info" name="submit_btn" value="Check Status">
																		</form>
																	</td>

																<?php }; ?>

															</tr>
														<?php
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				} else { ?>
					<div class="container-fluid animatedParent animateOnce">
						<div class="tab-content my-3" id="v-pills-tabContent">
							<div class="tab-pane animated fadeInUpShort show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
								<div class="row my-3">
									<div class="col-md-12">
										<div class="card my-3 no-b shadow">
											<div class="card-body">
												<table class="table table-striped table-bordered table-hover example">

													<tr>
														<td colspan="12" class="text-danger text-center"><?php echo site_phrase('no_record_found'); ?></td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }
				?>
			</div>
		</div>
	</div>
</div>