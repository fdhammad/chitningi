<div class="page has-sidebar-left  height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-database"></i>
						<?= $page_title  ?>
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link" href="<?php echo base_url("admin/students/view/" . $student['id']); ?>"><i class=" icon icon-home2"></i> Student Profile</a>
					</li>
					<li>
						<a class="nav-link active" href="<?php echo base_url("admin/students/edit/" . $student['id']); ?>"><i class=" icon icon-edit"></i> Edit Student</a>
					</li>
					<li>
						<a class="nav-link" href="<?php echo base_url(); ?>admin/students/create"><i class="icon icon-plus-circle"></i>Add New Student</a>
					</li>
					<li>
						<a class="nav-link" href="<?php echo base_url(); ?>admin/students/pre_import_without_reg_no"><i class="icon icon-documents3"></i>Bulk Upload without Coll No</a>
					</li>
				</ul>
			</div>
		</div>
	</header>
	<div class="container-fluid animatedParent animateOnce">
		<div class="animated fadeInUpShort">

			<div class="row my-3">
				<div class="col-md-7  offset-md-2">
					<div id="alert"></div>
					<form id="student_edit" class="needs-validation" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
						<div class="card no-b  no-r">
							<?php if ($this->session->flashdata('msg')) { ?>
								<?php echo $this->session->flashdata('msg') ?>
							<?php } ?>
							<?php echo $this->customlib->getCSRF(); ?>
							<div class="card-body">
								<h5 class="card-title">STUDENT BIO DATA</h5>
								<input type="hidden" id="student_id" name="student_id" value="<?php echo set_value('id', $student['id']); ?>">
								<div class="form-row">
									<div class="col-md-8">
										<div class="form-group m-0">
											<label for="reg_no" class="col-form-label s-12">COLLEGE NO</label>
											<input id="reg_no" name="reg_no" placeholder="Enter Registration No" class="form-control r-0 light s-12 " type="text" value="<?php echo set_value('reg_no', $student['reg_no']); ?>" required>
											<span class="text-danger"><?php echo form_error('reg_no'); ?></span>
										</div>
										<!-- <div class="form-group m-0">
											<label for="jamb_no" class="col-form-label s-12">JAMB NO</label>
											<input id="jamb_no" name="jamb_no" placeholder="Enter JAMB No" class="form-control r-0 light s-12 " type="text" value="<?php echo set_value('jamb_no', $student['jamb_no']); ?>">
											<span class="text-danger"><?php echo form_error('jamb_no'); ?></span>
										</div> -->
										<div class="form-row">
											<div class="form-group col-6 m-0">
												<label for="lastname" class="col-form-label s-12">Surname</label>
												<input id="lastname" name="lastname" placeholder="Enter Surname" class="form-control r-0 light" type="text" value="<?php echo set_value('lastname', $student['lastname']); ?>" required>
												<span class="text-danger"><?php echo form_error('lastname'); ?></span>
											</div>
											<div class="form-group col-6 m-0">
												<label for="firstname" class="col-form-label s-12">Firstname</label>
												<input id="firstname" name="firstname" placeholder="Enter Firstname" class="form-control r-0 light" type="text" value="<?php echo set_value('firstname', $student['firstname']); ?>" required>
												<span class="text-danger"><?php echo form_error('firstname'); ?></span>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-6 m-0">
												<label for="middlename" class="col-form-label s-12">Othername</label>
												<input id="middlename" name="middlename" placeholder="Enter Othername" class="form-control r-0 light" type="text" value="<?php echo set_value('middlename', $student['middlename']); ?>">
												<span class="text-danger"><?php echo form_error('middlename'); ?></span>
											</div>
										</div>

										<div class="form-group m-0">
											<label for="gender" class="col-form-label s-12">GENDER</label>
											<br>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="male" name="gender" class="custom-control-input" <?php if ($student['gender'] == "M" || $student['gender'] == "Male") echo "checked"; ?> value="M">
												<label class="custom-control-label m-0" for="male">Male</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="female" name="gender" class="custom-control-input" <?php if ($student['gender'] == "F" || $student['gender'] == "Female") echo "checked"; ?> value="F">
												<label class="custom-control-label m-0" for="female">Female</label>
											</div>
											<span class="text-danger"><?php echo form_error('gender'); ?></span>
										</div>
										<div class="form-row">
											<div class="form-group col-5 m-0">
												<label class="my-1 mr-2" for="inlineFormCustomSelectPref">MARITIAL STATUS</label>
												<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" name="marital_status">
													<option selected>Choose...</option>
													<?php foreach ($maritalStatus as $key => $value) {
													?>
														<option value="<?php echo $key; ?>" <?php if ($student['marital_status'] == $key) echo "selected"; ?>><?php echo $value; ?></option>

													<?php } ?>

												</select>
												<span class="text-danger"><?php echo form_error('marital_status'); ?></span>
											</div>
											<div class="form-group col-6 m-0">
												<label for="dob" class="col-form-label s-12"><i class="icon-calendar mr-2"></i>DATE OF BIRTH</label>
												<input type="text" name="dob" class="date-time-picker form-control r-0 light" data-options='{"timepicker":false, "format":"d/m/Y"}' value="<?php echo set_value('dob', $student['dob']); ?>" autocomplete="off" />

												<span class="text-danger"><?php echo form_error('dob'); ?></span>
											</div>

										</div>

									</div>
									<div class="col-md-3 offset-md-1">
										<input type="file" id="image" class="dropify" name="file" data-plugins="dropify" data-default-file="<?php
																																			if (!empty($student['image'])) {
																																				echo base_url() . $student['image'];
																																			} else {
																																				echo base_url() . "uploads/student_image/placeholder.png";
																																			}
																																			?>" data-max-file-size="1M" />
										<p class="text-muted text-center mt-2 mb-0">Upload Passport</p>
										<span class="text-danger"><?php echo form_error('file'); ?></span>
									</div>

								</div>

								<div class="form-row mt-1">
									<div class="form-group col-4 m-0">
										<label for="email" class="col-form-label s-12"><i class="icon-envelope-o mr-2"></i>Email</label>
										<input id="email" name="email" placeholder="user@email.com" class="form-control r-0 light s-12 " type="email" value="<?php echo set_value('email', $student['email']); ?>">
										<span class="text-danger"><?php echo form_error('email'); ?></span>
									</div>

									<div class="form-group col-4 m-0">
										<label for="phone" class="col-form-label s-12"><i class="icon-phone mr-2"></i>Phone</label>
										<input id="phone" name="phone" placeholder="08012345678" class="form-control r-0 light s-12 " type="tel" value="<?php echo set_value('phone', $student['phone']); ?>">
										<span class="text-danger"><?php echo form_error('phone'); ?></span>
									</div>
									<div class="form-group col-4 m-0">
										<label for="religion" class="col-form-label s-12">Religion</label>
										<input id="religion" name="religion" placeholder="" class="form-control r-0 light s-12 " type="text" value="<?php echo set_value('religion', $student['religion']); ?>">
										<span class="text-danger"><?php echo form_error('religion'); ?></span>
									</div>

								</div>
								<!-- 	<div class="form-group m-0">
									<label for="disability" class="col-form-label s-12">Disability</label>
									<br>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="no" name="disability" class="custom-control-input" <?php if ($student['disability'] == "No" || $student['disability'] == "no" || $student['disability'] == "None" || $student['disability'] == "none") echo "checked"; ?> value="no">
										<label class="custom-control-label m-0" for="no">No</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="yes" name="disability" class="custom-control-input" <?php if ($student['disability'] == "Yes" || $student['disability'] == "yes") echo "checked"; ?> value="yes">
										<label class="custom-control-label m-0" for="yes">Yes</label>
									</div>
									<span class="text-danger"><?php echo form_error('disability'); ?></span>
								</div> -->
							</div>

							<hr>
							<div class="card-body">
								<h5 class="card-title">ENROLLMENT</h5>
								<div class="form-row">
									<div class="form-group col-5 m-0">
										<label for="school_id" class="col-form-label s-12">DEPARTMENT</label>
										<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="department_id" name="department_id" required>
											<option value="">Choose...</option>
											<?php
											foreach ($departmentlist as $department) {
											?>
												<option value="<?php echo $department['id'] ?>" <?php if ($student['department_id'] == $department['id']) echo "selected=selected" ?>><?php echo $department['name'] ?></option>
											<?php
												$count++;
											}
											?>
										</select>
										<span class="text-danger"><?php echo form_error('department_id'); ?></span>
									</div>
									<div class="form-group col m-0">
										<label for="course_id" class="col-form-label s-12">COURSE</label>
										<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="course_id" name="course_id" required>
											<option selected>Choose...</option>

										</select>
										<span class="text-danger"><?php echo form_error('course_id'); ?></span>
									</div>
									<div class="form-group col m-0">
										<label for="roll4" class="col-form-label s-12">LEVEL</label>
										<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="class_id" name="class_id" required>
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php
											foreach ($classlist as $class) {
											?>
												<option value="<?php echo $class['id'] ?>" <?php if ($student['class_id'] == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
											<?php
												$count++;
											}
											?>
										</select>
										<span class="text-danger"><?php echo form_error('class_id'); ?></span>
									</div>
								</div>
							</div>
							<hr>
							<div class="card-body">
								<h5 class="card-title">ADDRESS</h5>
								<div class="form-row">
									<div class="form-group col-5 m-0">
										<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select State</label>
										<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="state_id" name="state_id">
											<option value="">Choose...</option>
											<?php
											foreach ($statelist as $state) {
											?>
												<option value="<?php echo $state['id'] ?>" <?php
																							if ($student['state_id'] == $state['id']) {
																								echo "selected =selected";
																							}
																							?>><?php echo $state['name'] ?></option>
											<?php

											}
											?>
										</select>
										<span class="text-danger"><?php echo form_error('state_id'); ?></span>
									</div>
									<div class="form-group col-5 m-0">
										<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select LGA</label>
										<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="local_government_id" name="local_government_id">
											<option selected>Choose...</option>

										</select>
										<span class="text-danger"><?php echo form_error('local_government_id'); ?></span>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-7 m-0">
										<label for="address" class="col-form-label s-12">Contact Address</label>
										<input type="text" class="form-control r-0 light s-12" id="current_address" name="current_address" placeholder="Enter Address" value="<?php echo set_value('current_address', $student['current_address']); ?>">
										<span class="text-danger"><?php echo form_error('current_address'); ?></span>
									</div>

									<div class="form-group col-5 m-0">
										<label for="tow" class="col-form-label s-12">Town of Birth</label>
										<input type="text" class="form-control r-0 light s-12" id="tob" name="tob" value="<?php echo set_value('tob', $student['tob']); ?>">
										<span class="text-danger"><?php echo form_error('tob'); ?></span>
									</div>
								</div>
							</div>
							<hr>
							<div class="card-body">
								<button type="submit" id="btn_save" class="btn btn-primary btn-lg pull-right"><i class="icon-save mr-2"></i>Save Data</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>