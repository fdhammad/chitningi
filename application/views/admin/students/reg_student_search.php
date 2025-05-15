<style>
	.form-group input[type=file] {
		z-index: 5 !important;
	}
</style>
<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-database"></i>
						Registered Students
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>Search Registered Students</a>
					</li>
					<li class="float-right">
						<a class="nav-link" href="<?php echo base_url(); ?>admin/students/create"><i class="icon icon-plus-circle"></i> Add New Student</a>
					</li>

				</ul>
			</div>
		</div>
	</header>
	<div class="container-fluid my-3">
		<?php if ($this->session->flashdata('toast')) { ?>
			<?php echo $this->session->flashdata('toast') ?>
		<?php } ?>
		<?php if ($this->session->flashdata('msg')) { ?>
			<?php echo $this->session->flashdata('msg') ?>
		<?php } ?>
		<div class="row">

			<div class="col-md-12">

				<div class="card shadow r-0">
					<div class="card-header">
						<h5 class="card-title"><i class="icon icon-search"></i> <?php echo get_phrase('select_criteria'); ?></h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<form role="form" action="<?php echo site_url('admin/students/search') ?>" method="post">
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="row">


										<div class="col-md-5">
											<div class="form-group">
												<label><?php echo 'Department'; ?></label> <small class="req"> *</small>

												<select autofocus="" id="department_id" name="department_id" class="form-control" required>
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

										<div class="col-md-4">
											<div class="form-group">
												<label><?php echo 'Course'; ?></label> <small class="req"> *</small>

												<select autofocus="" id="course_id" name="course_id" class="form-control" required>
													<option value=""><?php echo get_phrase('select'); ?></option>
												</select>
												<span class="text-danger"><?php echo form_error('course_id'); ?></span>

											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label><?php echo 'Level'; ?></label><small class="req"> *</small>
												<div class="bg-light">
													<select autofocus="" id="class_id" name="class_id" class="form-control">
														<option value=""><?php echo get_phrase('select'); ?></option>
														<?php
														foreach ($classlist as $class) {
														?>
															<option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
														<?php

														}
														?>
													</select>
													<span class="text-danger"><?php echo form_error('class_id'); ?></span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div id="searchDiv" class="form-group">
												<button type="button" id="show" value="search_filter" class="btn btn-danger pull-right"><i class="icon icon-search"></i> <?php echo get_phrase('search'); ?></button>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="col-md-4">
								<form role="form" action="<?php echo site_url('admin/students/search') ?>" method="post" class="">
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="col-md-12">
										<div class="form-group">
											<label><?php echo get_phrase('search_by_keyword'); ?></label>
											<input class="form-control form-control-lg r-30" type="text" id="search_text" name="search_text" placeholder="<?php echo get_phrase('search_by_student_name'); ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<button type="submit" id="search" name="search" value="search_full" class="btn btn-danger pull-right"><i class="icon icon-search"></i> <?php echo get_phrase('search'); ?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div id="response">

	</div>

	<?php
	if (isset($resultlist)) {
	?>
		<div class="container-fluid animatedParent animateOnce">
			<div class="tab-content my-3" id="v-pills-tabContent">
				<div class="tab-pane animated fadeInUpShort show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
					<div class="row my-3">
						<div class="col-md-12">
							<div class="card my-3 no-b shadow">
								<div class="card-body">

									<div class="table-responsive">
										<?php if ($searchby == "filter") { ?>
											<div class="float-right"> <a href="<?php echo base_url(); ?>admin/students/generatePDF/<?php echo $course_id . '/' . $class_id ?>" class="btn btn-outline-primary btn-sm" type="button" name="generate" title="Generate List"><?php echo 'Generate Student List'; ?></a></div>
										<?php } ?>

										<table id="basic" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>COLLEGE NO</th>
													<th>JAMB NO</th>
													<th>NAME</th>
													<th>SCHOOL (COURSE)</th>
													<th>LEVEL</th>
													<th>STATE</th>
													<th>ACTION</th>
												</tr>
											</thead>

											<tbody>
												<?php
												if (empty($resultlist)) {
												?>
													<tr>
														<td colspan="12" class="text-danger text-center"><?php echo get_phrase('no_record_found'); ?></td>
													</tr>
													<?php
												} else {
													$count = 1;
													foreach ($resultlist as $student) {
													?>
														<tr>
															<td><?php echo $student['reg_no']; ?></td>
															<!-- <td><?php echo $student['jamb_no']; ?></td> -->
															<td class="text-uppercase">
																<a href="<?php echo base_url(); ?>admin/students/view/<?php echo $student['id']; ?>"><?php echo $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename']; ?>
																</a>
															</td>
															<td><?php echo $student['sch_code'] . " (" . $student['code'] . ")" ?></td>
															<td><?php echo $student['class'] ?></td>
															<td><?php if ($student['state_id'] == 5) { ?><span class="r-3 badge badge-success"><?php echo $student['state']; ?></span>
																<?php
																} else { ?><span class="r-3 badge badge-warning "><?php echo $student['state']; ?></span> <?php }; ?></td>
															<td>

																<a href="<?php echo base_url(); ?>admin/students/view/<?php echo $student['id'] ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="View Student Details" data-original-title="View">
																	<i class="icon-eye"></i>
																</a>

																<a href="<?php echo base_url(); ?>admin/students/edit/<?php echo $student['id'] ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Student" data-original-title="Edit Student">
																	<i class="icon-pencil"></i>
																</a>
																<!-- <a type="button" href="javascript:void(0)" data-id="<?php echo $student['id']; ?>" class="btn btn-warning btn-xs edit-product" id="<?php echo $student['id']; ?>"> <i class="icon-pencil"></i>
																	</a> -->


																<button type="submit" class="btn btn-danger btn-xs delete" id="<?php echo $student['id']; ?>"> <i class="icon-trash"></i></button>

															</td>
														</tr>
												<?php }
												}; ?>
											</tbody>

										</table>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>

<!--Add New Message Fab Button-->
<a href="<?php echo base_url(); ?>admin/students/create" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i class="icon-add"></i></a>

</div>

<!-- Model for add edit product -->
<div class="modal fade" id="ajax-product-modal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header danger text-white">
				<h4 class="modal-title text-center" id="productCrudModal"></h4>
			</div>
			<div class="modal-body">
				<form id="productForm" name="productForm" class="form-horizontal">
					<input type="hidden" name="id" id="id">
					<div class="row">
						<div class="col-md-10">
							<div class="card no-b  no-r">
								<div class="card-body">
									<p class="card-title">STUDENT BIO DATA</p>
									<hr>
									<div class="form-row">
										<div class="col-md-8">
											<div class="form-group m-0">
												<label for="reg_no" class="col-form-label s-12">COLLEGE NO</label>
												<input id="reg_no" name="reg_no" placeholder="Enter College No" class="form-control r-0 light s-12 " type="text" value="<?php echo set_value('reg_no'); ?>" required>
												<span class="text-danger"><?php echo form_error('reg_no'); ?></span>
											</div>
											<div class="form-group m-0">
												<label for="jamb_no" class="col-form-label s-12">JAMB NO</label>
												<input id="jamb_no" name="jamb_no" placeholder="Enter JAMB No" class="form-control r-0 light s-12 " type="text" value="<?php echo set_value('jamb_no'); ?>">
												<span class="text-danger"><?php echo form_error('jamb_no'); ?></span>
											</div>
											<div class="form-row">
												<div class="form-group col-6 m-0">
													<label for="lastname" class="col-form-label s-12">Surname</label>
													<input id="lastname" name="lastname" placeholder="Enter Surname" class="form-control r-0 light" type="text" value="<?php echo set_value('lastname'); ?>" required>
													<span class="text-danger"><?php echo form_error('lastname'); ?></span>
												</div>
												<div class="form-group col-6 m-0">
													<label for="firstname" class="col-form-label s-12">Firstname</label>
													<input id="firstname" name="firstname" placeholder="Enter Firstname" class="form-control r-0 light" type="text" value="<?php echo set_value('firstname'); ?>" required>
													<span class="text-danger"><?php echo form_error('firstname'); ?></span>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-6 m-0">
													<label for="middlename" class="col-form-label s-12">Othername</label>
													<input id="middlename" name="middlename" placeholder="Enter Othername" class="form-control r-0 light" type="text" value="<?php echo set_value('middlename'); ?>">
													<span class="text-danger"><?php echo form_error('middlename'); ?></span>
												</div>
											</div>

											<div class="form-group m-0">
												<label for="gender" class="col-form-label s-12">GENDER</label>
												<br>
												<div class="custom-control custom-radio custom-control-inline">
													<input type="radio" id="male" name="gender" class="custom-control-input" value="Male">
													<label class="custom-control-label m-0" for="male">Male</label>
												</div>
												<div class="custom-control custom-radio custom-control-inline">
													<input type="radio" id="female" name="gender" class="custom-control-input" value="Female">
													<label class="custom-control-label m-0" for="female">Female</label>
												</div>
												<span class="text-danger"><?php echo form_error('gender'); ?></span>
											</div>
											<div class="form-row">
												<div class="form-group col-5 m-0">
													<label class="my-1 mr-2" for="inlineFormCustomSelectPref">MARITIAL STATUS</label>
													<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" name="marital_status">
														<option selected>Choose...</option>
														<?php
														foreach ($maritalStatus as $key => $value) {
														?>
															<option value="<?php echo $key; ?>" <?php if (set_value('marital_status') == $key) echo "selected"; ?>><?php echo $value; ?></option>
														<?php
														}
														?>
														<span class="text-danger"><?php echo form_error('marital_status'); ?></span>
													</select>
												</div>
												<div class="form-group col-6 m-0">
													<label for="dob" class="col-form-label s-12"><i class="icon-calendar mr-2"></i>DATE OF BIRTH</label>
													<input type="text" name="dob" class="date-time-picker form-control r-0 light" data-options='{"timepicker":false, "format":"d/m/Y"}' value="<?php echo set_value('dob'); ?>" autocomplete="off" />

													<span class="text-danger"><?php echo form_error('dob'); ?></span>
												</div>

											</div>

										</div>
										<div class="col-md-3 offset-md-1">
											<input type="file" class="dropify" id="image" name="file" data-plugins="dropify" data-max-file-size="6M" />
											<p class="text-muted text-center mt-2 mb-0">Upload Passport</p>
											<span class="text-danger"><?php echo form_error('file'); ?></span>
										</div>

									</div>

									<div class="form-row mt-1">
										<div class="form-group col-4 m-0">
											<label for="email" class="col-form-label s-12"><i class="icon-envelope-o mr-2"></i>Email</label>
											<input type="email" id="email" name="email" placeholder="user@email.com" class="form-control r-0 light s-12 " value="<?php echo set_value('email'); ?>">
											<span class="text-danger"><?php echo form_error('email'); ?></span>
										</div>

										<div class="form-group col-4 m-0">
											<label for="mobileno" class="col-form-label s-12"><i class="icon-phone mr-2"></i>Phone</label>
											<input type="tel" id="mobileno" name="mobileno" placeholder="08012345678" pattern="[0-9]{11}" class="form-control r-0 light s-12 " value="<?php echo set_value('mobileno'); ?>">
											<span class="text-danger"><?php echo form_error('mobileno'); ?></span>
										</div>
										<div class="form-group col-4 m-0">
											<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Religion</label>
											<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" name="marital_status">
												<option selected>Choose...</option>
												<?php
												foreach ($religion as $key => $value) {
												?>
													<option value="<?php echo $key; ?>" <?php if (set_value('religion') == $key) echo "selected"; ?>><?php echo $value; ?></option>
												<?php
												}
												?>
												<span class="text-danger"><?php echo form_error('religion'); ?></span>
											</select>


										</div>

									</div>
									<!-- <div class="form-group m-0">
									<label for="disability" class="col-form-label s-12">Disability</label>
									<br>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="no" name="disability" class="custom-control-input" value="no" checked>
										<label class="custom-control-label m-0" for="no">No</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="yes" name="disability" class="custom-control-input" value="yes">
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
											<label for="school_i" class="col-form-label s-12">SCHOOL</label>
											<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="school_id" name="school_id" required>
												<option value="">Choose...</option>
												<?php
												foreach ($schoollist as $school) {
												?>
													<option value="<?php echo $school['id'] ?>" <?php if (set_value('school_id') == $school['id']) echo "selected=selected" ?>><?php echo $school['school'] ?></option>
												<?php

												}
												?>
											</select>
											<span class="text-danger"><?php echo form_error('school_id'); ?></span>
										</div>
										<div class="form-group col m-0">
											<label for="course_id" class="col-form-label s-12">COURSE</label>
											<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="course_id" name="course_id" required>
												<option value="">Choose...</option>

											</select>
											<span class="text-danger"><?php echo form_error('course_id'); ?></span>
										</div>
										<div class="form-group col m-0">
											<label for="roll4" class="col-form-label s-12">LEVEL</label>
											<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="class_id" name="class_id" required>
												<option value="">Choose...</option>
												<?php
												foreach ($classlist as $class) {
												?>
													<option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
												<?php

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
											<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="state_id" name="state_id" required>
												<option value="">Choose...</option>
												<?php
												foreach ($state as $state) {
												?>
													<option value="<?php echo $state['id']; ?>" <?php if (set_value('state_id') == $state['id']) echo "selected=selected"; ?>><?php echo $state['name']; ?></option>
												<?php

												}
												?>
											</select>
											<span class="text-danger"><?php echo form_error('state_id'); ?></span>
										</div>
										<div class="form-group col-5 m-0">
											<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select LGA</label>
											<select class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="local_government_id" name="local_government_id">
												<option value="">Choose...</option>

											</select>
											<span class="text-danger"><?php echo form_error('local_government_id'); ?></span>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-7 m-0">
											<label for="address" class="col-form-label s-12">Contact Address</label>
											<input type="text" class="form-control r-0 light s-12" id="current_address" name="current_address" placeholder="Enter Address" value="<?php echo set_value('current_address'); ?>">
											<span class="text-danger"><?php echo form_error('current_address'); ?></span>
										</div>

										<div class="form-group col-5 m-0">
											<label for="tow" class="col-form-label s-12">Town of Birth</label>
											<input type="text" class="form-control r-0 light s-12" id="tob" name="tob" value="<?php echo set_value('tob'); ?>">
											<span class="text-danger"><?php echo form_error('tob'); ?></span>
										</div>
									</div>
								</div>
								<hr>

							</div>
						</div>


						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
							</button>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>