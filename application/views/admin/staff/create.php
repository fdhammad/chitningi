<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-user"></i>
						<?= $page_title  ?>
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link" href="<?php echo base_url('admin/staff') ?>" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>All Staff</a>
					</li>
					<li>
						<a class="nav-link active" href="<?php echo base_url('admin/staff/create') ?>" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-user-plus"></i>Add New Staff</a>
					</li>

				</ul>
			</div>
		</div>
	</header>

	<div class="container-fluid my-3">
		<div class="row">
			<?php if ($this->session->flashdata('toast')) { ?>
				<?php echo $this->session->flashdata('toast') ?>
			<?php } ?>
			<?php echo $this->customlib->getCSRF(); ?>
			<?php if ($this->session->flashdata('msg')) { ?>
				<?php echo $this->session->flashdata('msg') ?>
			<?php } ?>

			<div class="col-md-12">
				<div id="alert"></div>
				<form id="staff_create" class="needs-validation" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<?php echo $this->customlib->getCSRF(); ?>
					<div class="row">
						<div class="col-md-12">
							<!-- <div class="alert alert-info">
								Staff email is their login username, password is generated automatically and its the Staff Mobile No. Superadmin can change staff password on their staff profile page.
							</div> -->
						</div>
						<div class="col-md-4">
							<div class="card card-profile card-secondary">
								<div class="card-header">
									<div>
										<input type="file" id="image" class="dropify" name="file" data-plugins="dropify" data-max-file-size="1M" />
										<p class="text-muted text-center mt-2 mb-0">Upload Passport</p>
										<span class="text-danger"><?php echo form_error('file'); ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="card r-0 shadow">
								<div class="card-header">
									<h5 class="card-title">Bio-data</h5>
								</div>

								<div class="card-body">

									<?php if ($this->session->flashdata('msg')) { ?>
										<?php echo $this->session->flashdata('msg') ?>
									<?php } ?>
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="row mt-3">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label><?php echo get_phrase('staff_id'); ?></label><small class="req"> *</small>
												<input autofocus="" id="employee_id" name="employee_id" placeholder="" type="text" class="form-control" value="<?php echo set_value('employee_id') ?>" />
												<span class="text-danger"><?php echo form_error('employee_id'); ?></span>
											</div>
										</div>
										<!-- <div class="col-md-6">
											<div class="form-group form-group-default">
												<label><?php echo get_phrase('role'); ?></label><small class="req"> *</small>
												<select id="role" name="role" class="form-control">
													<option value=""><?php echo get_phrase('select'); ?></option>
													<?php
													foreach ($roles as $key => $role) {
													?>
														<option value="<?php echo $role['id'] ?>" <?php echo set_select('role', $role['id'], set_value('role')); ?>><?php echo $role["name"] ?></option>
													<?php }
													?>
												</select>
												<span class="text-danger"><?php echo form_error('role'); ?></span>
											</div>
										</div> -->
										<div id="test" class="col-md-6">
											<div class="form-group form-group-default">
												<label><?php echo 'School'; ?></label><small class="req"> *</small>
												<div class="bg-light">
													<select autofocus="" id="school_id" name="school_id" class="form-control">
														<option value=""><?php echo get_phrase('select'); ?></option>
														<?php
														foreach ($schoollist as $school) {
														?>
															<option value="<?php echo $school['id'] ?>" <?php if (set_value('school_id') == $school['id']) echo "selected=selected" ?>><?php echo $school['code'] ?></option>
														<?php

														}
														?>
													</select>
													<span class="text-danger"><?php echo form_error('school_id'); ?></span>
												</div>

											</div>
										</div>
										<div id="department">
											<div class="col-md-10">
												<div class="form-group form-group-default">
													<label><?php echo 'School'; ?></label><small class="req"> *</small>
													<div class="bg-light">
														<select autofocus="" id="school_id" name="school_id" class="form-control">
															<option value=""><?php echo get_phrase('select'); ?></option>
															<?php
															foreach ($schoollist as $school) {
															?>
																<option value="<?php echo $school['id'] ?>" <?php if (set_value('school_id') == $school['id']) echo "selected=selected" ?>><?php echo $school['code'] ?></option>
															<?php

															}
															?>
														</select>
														<span class="text-danger"><?php echo form_error('class_id'); ?></span>
													</div>

												</div>
											</div>
											<div class="col-md-10">
												<div class="form-group form-group-default">
													<label><?php echo 'Department'; ?></label><small class="req"> *</small>
													<div class="bg-light">
														<select autofocus="" id="department_id" name="department_id" class="form-control">
															<option value=""><?php echo get_phrase('select'); ?></option>
															<?php
															foreach ($departmentlist as $department) {
															?>
																<option value="<?php echo $department['id'] ?>" <?php if (set_value('department_id') == $department['id']) echo "selected=selected" ?>><?php echo $department['name'] ?></option>
															<?php

															}
															?>
														</select>
														<span class="text-danger"><?php echo form_error('department_id'); ?></span>
													</div>

												</div>
											</div>
										</div>
									</div>

									<div class="row mt-3">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>First Name</label>
												<input id="firstname" name="firstname" placeholder="First Name" type="text" class="form-control" value="<?php echo set_value('firstname') ?>" required />
												<span class="text-danger"><?php echo form_error('firstname'); ?></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Last Name</label>
												<input id="lastname" name="lastname" placeholder="Last Name" type="text" class="form-control" value="<?php echo set_value('lastname') ?>" required />
												<span class="text-danger"><?php echo form_error('lastname'); ?></span>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group form-group-default">
												<label>Email</label>
												<input id="email" name="email" placeholder="Email" type="text" class="form-control" value="<?php echo set_value('email') ?>" required />
												<span class="text-danger"><?php echo form_error('email'); ?></span>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group form-group-default">
												<label>Phone</label>
												<input id="contact_no" name="contact_no" placeholder="Mobile No" type="tel" class="form-control" value="<?php echo set_value('contact_no') ?>" />
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-4">
											<div class="form-group form-group-default">
												<label>Marital Status</label>
												<select class="form-control" name="marital_status">
													<option value=""><?php echo get_phrase('select'); ?></option>
													<?php
													foreach ($maritalStatus as $key => $value) {
													?>
														<option value="<?php echo $key; ?>" <?php if (set_value('marital_status') == $key) echo "selected"; ?>><?php echo $value; ?></option>
													<?php
													}
													?>

												</select>
												<span class="text-danger"><?php echo form_error('marital_status'); ?></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-group-default">
												<label>Gender</label>
												<select class="form-control" name="gender" required>
													<option value=""><?php echo get_phrase('select'); ?></option>
													<?php
													foreach ($genderList as $key => $value) {
													?>
														<option value="<?php echo $key; ?>" <?php echo set_select('gender', $key, set_value('gender')); ?>><?php echo $value; ?></option>
													<?php
													}
													?>
												</select>
												<span class="text-danger"><?php echo form_error('gender'); ?></span>
											</div>
										</div>

									</div>
									<div class="row mt-3">

										<div class="col-md-4">
											<div class="form-group form-group-default">
												<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select State</label>
												<select class="custom-select my-1 form-control r-0 light s-12" id="state_id" name="state_id">
													<option value="">Choose...</option>
													<?php
													foreach ($statelist as $state) {
													?>
														<option value="<?php echo $state['id']; ?>" <?php if (set_value('state_id') == $state['id']) echo "selected=selected"; ?>><?php echo $state['name']; ?></option>
													<?php

													}
													?>
												</select>
												<span class="text-danger"><?php echo form_error('state_id'); ?></span>
											</div>
										</div>
										<div class="col-md-4">
											<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select LGA</label>
											<select class="custom-select my-1  form-control r-0 light s-12" id="local_government_id" name="local_government_id">
												<option selected>Choose...</option>

											</select>
											<span class="text-danger"><?php echo form_error('local_government_id'); ?></span>
										</div>


									</div>
									<div class="row mt-3">
										<div class="col-md-12">
											<div class="form-group form-group-default">
												<label>Address</label>
												<textarea name="permanent_address" class="form-control" placeholder="Address"><?php echo set_value('permanent_address'); ?></textarea>
												<span class="text-danger"><?php echo form_error('permanent_address'); ?></span>
											</div>
										</div>
									</div>
									<div class="row mt-3 mb-1">
										<div class="col-md-12">
											<div class="form-group form-group-default">
												<label>About Me</label>
												<textarea name="note" class="form-control" placeholder="About Me" rows="3"><?php echo set_value('note'); ?></textarea>
												<span class="text-danger"><?php echo form_error('note'); ?></span>
											</div>
										</div>
									</div>
									<hr>
									<div class="row mt-3">
										<div class="col-md-5">
											<div class="form-group form-group-default">
												<label>Password</label>
												<input id="password" name="password" placeholder="Password" type="password" class="form-control" value="" required />
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group form-group-default">
												<label>Password Confirm</label>
												<input id="password_confirm" name="password_confirm" placeholder="Confirm Pass" type="password" class="form-control" value="" required />
											</div>
										</div>
									</div>
									<hr>
									<div class="text-right mt-3 mb-3">
										<button id="staff_create_button" type="submit" class="btn btn-success mr-5"><i class="icon icon-user-plus"></i> Save</button>

										<a href="<?php echo base_url('admin/staff'); ?>" class="btn btn-outline-danger"><i class="icon icon-arrow_back"></i> Go Back</a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- jQuery  -->
<!-- <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>assets/dropify/js/dropify.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.dropify').dropify();
	});
</script>
 -->

<script>
	$(document).ready(function() {
		$('#test').hide();
		$('#department').hide();
		$("#role").change(function() {
			var selected_option = $('#role').val();
			if (selected_option === '2') {
				$('#test').show();
				$('#department').hide();
			} else if (selected_option === '9') {
				$('#test').hide();
				$('#department').show();
			} else {
				$('#test').hide();
				$('#department').hide();
			}
		})
	});
</script>
<!-- 
<script>
	$(document).ready(function() {
		$('#form1').on('submit', function(e) {
			//e.preventDefault();
			if ($('#image_file').val() == '') {
				alert("Please Select the File");
			} else {
				$.ajax({
					url: "<?php echo base_url(); ?>admin/staff/ajax_upload",
					//base_url() = http://localhost/tutorial/codeigniter
					method: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(data) {
						$('#uploaded_image').html(data);
					}
				});
			}
		});
	});
</script> -->
