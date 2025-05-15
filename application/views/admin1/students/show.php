<div class="page has-sidebar-left">
	<div>
		<header class="danger accent-3 relative">
			<div class="container-fluid text-white">
				<div class="row p-t-b-10 ">
					<div class="col">
						<div class="pb-3">
							<div class="image mr-3  float-left">
								<img class="user_avatar no-b no-p" src="<?php if (!empty($student['image'])) {
																			echo base_url() . $student['image'];
																		} else {
																			echo base_url() . "uploads/student_images/no_image.png";
																		} ?>" alt="User Image">
							</div>
							<div>
								<h6 class="p-t-10"><?php echo $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename']; ?></h6>
								<?php echo 'Reg No'; ?>: <b><?php echo $student['reg_no']; ?></b> <br>
								<?php echo 'Level'; ?>: <b><?php echo $student['class'] . " (" . $student['code'] . ")"; ?></b>
								<br>
								<?php echo 'Disability'; ?>: <div <?php if ($student['disability'] == 'no') {
																		echo 'class="badge badge-success"';
																	} else {
																		echo 'class="badge badge-warning"';
																	} ?>> <b class="text-capitalize"><?php echo $student['disability']; ?></b></div>

							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
						<li>
							<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home"><i class="icon icon-home2"></i>Home</a>
						</li>

						<li>
							<a class="nav-link" id="v-pills-payments-tab" data-toggle="pill" href="#v-pills-payments" role="tab" aria-controls="v-pills-payments" aria-selected="false"><i class="icon icon-money-1"></i>Payments</a>
						</li>
						<li>
							<a class="nav-link " id="v-pills-reg-tab" href="<?php echo base_url('admin/students/reg_courses/' . $student['id']); ?>" role="tab" aria-controls="v-pills-reg" aria-selected="false"><i class="icon icon-documents2"></i>Registered Courses</a>
						</li>


						<li>
							<a class="nav-link" id="v-pills-reg-tab" href="<?php echo base_url('admin/students/summer_reg/' . $student['id']); ?>" role="tab" aria-controls="v-pills-reg" aria-selected="false"><i class="icon icon-documents"></i>Summer Reg</a>
						</li>


						<li>
							<a class="nav-link" id="v-pills-reg-tab" href="<?php echo base_url('admin/students/result/' . $student['id']); ?>" role="tab" aria-controls="v-pills-reg" aria-selected="false"><i class="icon icon-documents3"></i>Results</a>
						</li>

						<li>
							<a class="nav-link" href="<?php echo base_url("admin/students/edit/" . $student['id']); ?>"><i class="icon icon-cog"></i>Edit Profile</a>
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
								<?php if ($this->session->flashdata('msg')) { ?>
									<?php echo $this->session->flashdata('msg') ?>
								<?php } ?>
								<div class="card shadow">

									<ul class="list-group list-group-flush">
										<li class="list-group-item"><i class="icon icon-pencil text-primary"></i><strong class="s-12">Level</strong> <span class="float-right s-12"><?php echo $student['class']; ?></span></li>
										<li class="list-group-item"><i class="icon icon-book3 text-warning"></i><strong class="s-12">Course</strong> <span class="float-right s-12"><?php echo
																																													$student['sch_code'] . " (" . $student['code'] . ")"; ?></span></li>

										<li class="list-group-item"><i class="icon icon-user text-info"></i><strong class="s-12">Gender</strong> <span class="float-right s-12"><?php echo $student['gender']; ?></span></li>
										<li class="list-group-item"><i class="icon icon-mobile text-purple"></i><strong class="s-12">Phone</strong> <span class="float-right s-12"><?php echo $student['phone']; ?></span></li>
										<li class="list-group-item"><i class="icon icon-contacts text-success"></i><strong class="s-12">State</strong> <span class="float-right s-12"><?php echo $student['state']; ?></span></li>
										<li class="list-group-item"><i class="icon icon-accessibility text-danger"></i><strong class="s-12">Student Type</strong> <span class="float-right s-12"><?php echo $student['student_type']; ?></span></li>
										<!--   <li class="list-group-item"><i class="icon icon-address-card-o text-warning"></i><strong class="s-12">Address</strong> <span class="float-right s-12"><?php echo $student['current_address']; ?></span></li>
                                        <li class="list-group-item"><i class="icon icon-web text-danger"></i> <strong class="s-12">Website</strong> <span class="float-right s-12">pappertemplate.com</span></li> -->
									</ul>
								</div>
								<br>
								<div class="card shadow">
									<ul class="list-group list-group-flush">
										<li class="list-group-item"><i class="icon icon-home2 text-info"></i><strong class="s-12">Hostel</strong> <span class="float-right s-11"><?php echo $student['hostel']; ?></span></li>
										<li class="list-group-item"><i class="icon icon-bed text-info"></i><strong class="s-12">Room </strong> <span class="float-right s-11"><?php echo $student['room_no']; ?></span></li>

									</ul>
								</div>


							</div>
							<div class="col-md-7">
								<div class="row">
									<!-- bar charts group -->
									<div class="col-md-12">
										<div class="card shadow">
											<div class="card-header white">

												<div class="col-md-8 ml-auto">

												</div>
												<h4>BIO DATA</h4>
												<hr>
												<div class="card-body">
													<ul class="list-group list-group-flush">
														<li class="list-group-item"><strong class="s-11">Registration Number</strong> <span class="float-right s-11"><?php echo $student['reg_no']; ?></span></li>
														<li class="list-group-item"><strong class="s-11">Date of Birth</strong> <span class="float-right s-11"><?php echo $student['dob']; ?></span></li>
														<li class="list-group-item"><strong class="s-11">Phone</strong> <span class="float-right s-11"><?php echo $student['phone']; ?></span></li>
														<li class="list-group-item"><strong class="s-11">Email</strong> <span class="float-right s-11"><?php echo $student['email']; ?></span></li>
														<li class="list-group-item"><strong class="s-11">Religion</strong> <span class="float-right s-11"><?php echo $student['religion']; ?></span></li>
														<li class="list-group-item"><strong class="s-11">Marital Status</strong> <span class="float-right s-11"><?php echo $student['marital_status']; ?></span></li>
														<li class="list-group-item"><strong class="s-11">Disability</strong> <span class="float-right s-11"><?php echo $student['disability']; ?></span></li>
														<li class="list-group-item"><strong class="s-11">Admission Date</strong> <span class="float-right s-11"><?php echo $student['admission_date']; ?></span></li>


													</ul>
												</div>

											</div>
										</div>
										<br>
										<div class="card shadow">
											<div class="card-header white">
												<h4>ADDRESS DETAILS</h4>
											</div>
											<div class="card-body">
												<ul class="list-group list-group-flush">
													<li class="list-group-item"><strong class="s-11">Current Address</strong> <span class="float-right s-11"><?php echo $student['current_address']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Permanent Address</strong> <span class="float-right s-11"><?php echo $student['permanent_address']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Local Government</strong> <span class="float-right s-11"><?php echo $student['local_g']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">State</strong> <span class="float-right s-11"><?php echo $student['state']; ?></span></li>

												</ul>
											</div>
										</div>
										<br>
										<div class="card shadow">
											<div class="card-header white">
												<h4>PARENT/GUARDIANT DETAILS</h4>
											</div>
											<div class="card-body">
												<ul class="list-group list-group-flush">
													<li class="list-group-item"><strong class="s-11">Guardian Name</strong> <span class="float-right s-11"><?php echo $student['guardian_name']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Guardian Phone</strong> <span class="float-right s-11"><?php echo $student['guardian_phone']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Guardian Email</strong> <span class="float-right s-11"><?php echo $student['guardian_email']; ?></span></li>
													<li class="list-group-item"><strong class="s-11">Guardian Address</strong> <span class="float-right s-11"><?php echo $student['guardian_address']; ?></span></li>

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
<!-- <div class="modal fade" id="ajax-product-modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="productCrudModal"></h4>
			</div>
			<div class="modal-body">
				<form id="productForm" name="productForm" class="form-horizontal">
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Level</label>
						<div class="col-sm-12">
							<div class="form-group">
								<label><?php echo 'Level'; ?></label>

								<select autofocus="" id="class_id" name="class_id" class="form-control" required>
									<option value=""><?php echo get_phrase('select'); ?></option>
									<?php
									foreach ($classlist as $class) {
									?>
										<option value="<?php echo $class['id'] ?>" <?php
																					if (set_value('class_id') == $class['id']) {
																						echo "selected = selected";
																					}
																					?>><?php echo $class['class'] ?></option>

									<?php

									}
									?>
								</select>
								<span class="text-danger"><?php echo form_error('class_id'); ?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label> <?php echo 'Status'; ?></label><small class="req"> *</small>
						<select class="form-control" name="status" required>
							<option value=""><?php echo get_phrase('select'); ?></option>
							<?php
							foreach ($paymentStatus as $key => $value) {
							?>
								<option value="<?php echo $key; ?>" <?php if (set_value('status') == $key) echo "selected"; ?>><?php echo $value; ?></option>
							<?php
							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('status'); ?></span>
					</div>

					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
						</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div> -->
<!-- The Modal -->
<div class="modal fade " id="Modal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><b>Student Login Details</b></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div class="col-md-12">
					<table class="table table-head-bg-primary mt-4">
						<thead>
							<tr class="text-white bg-primary">
								<th>Username</th>
								<th>Password</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<b class="text-uppercase"><?php echo $username; ?></b>
								</td>
								<td>
									<b> <?php echo $password; ?></b>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div> <!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>
<!-- Model for add edit product -->
<div class="modal fade" id="ajax-product-modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="productCrudModal"></h4>
			</div>
			<div class="modal-body">
				<form id="productForm" name="productForm" class="form-horizontal">
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="receipt" id="receipt">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">RRR</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="rrr" name="receipt" placeholder="RRR" value="" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="amount" class="col-sm-2 control-label">Amount</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="amounts" name="amount" placeholder="Enter Amount" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="statuss" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="statuss" name="status" placeholder="Enter Status" value="">
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="name" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="status" name="status" placeholder="Enter Status" value="" required="">
						</div>
					</div> -->
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
						</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<!-- Model for add edit product -->
<div class="modal fade" id="hostel_ajax-product-modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="hostel_productCrudModal"></h4>
			</div>
			<div class="modal-body">
				<form id="hostel_productForm" name="productForm" class="form-horizontal">
					<input type="hidden" name="id" id="hostel_id">
					<!-- 	<input type="hidden" name="receipt" id="hostel_receipt"> -->
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">RRR</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="hostel_rrr" name="receipt" placeholder="RRR" value="" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="amount" class="col-sm-2 control-label">Amount</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="hostel_amount" name="amount" placeholder="Enter Amount" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="statuss" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="hostel_statuss" name="status" placeholder="Enter Status" value="">
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="name" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="status" name="status" placeholder="Enter Status" value="" required="">
						</div>
					</div> -->
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" id="hostel_btn-save" value="create">Save changes
						</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!-- The Modal -->
<div class="modal fade " id="DisabilityModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><b>Change Disability</b></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form action="<?php echo site_url('admin/students/modaldisability/' . $student['id']); ?>" id="form-validation" name="passwordform" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
					<div class="modal-body">

						<?php if ($this->session->flashdata('msg')) { ?>
							<?php echo $this->session->flashdata('msg') ?>
						<?php } ?>

						<?php echo $this->customlib->getCSRF(); ?>

						<div class="form-group <?php
												if (form_error('new_pass')) {
													echo 'has-error';
												}
												?>">

							<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Disability</label>
							<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" name="disability">
								<option selected>Choose...</option>
								<?php foreach ($disability as $key => $value) {
								?>
									<option value="<?php echo $key; ?>" <?php if ($student['disability'] == $key) echo "selected"; ?>><?php echo $value; ?></option>

								<?php } ?>

							</select>
							<span class="text-danger"><?php echo form_error('disability'); ?></span>

						</div>
					</div> <!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div><!-- jQuery  -->