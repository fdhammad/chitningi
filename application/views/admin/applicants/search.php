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
						<?= $page_title ?>
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>Applicant List</a>
					</li>
					<!-- 	<li class="float-right">
						<a class="nav-link" href="<?php echo base_url(); ?>admin/students/create"><i class="icon icon-plus-circle"></i> Add New Student</a>
					</li> -->

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
								<form role="form" action="<?php echo site_url('admin/applicants/search') ?>" method="post">
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="row">


										<div class="col-md-6">
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

										<div class="col-md-6">
											<div class="form-group">
												<label><?php echo 'Course'; ?></label> <small class="req"> *</small>

												<select autofocus="" id="course_id" name="course_id" class="form-control" required>
													<option value=""><?php echo get_phrase('select'); ?></option>
												</select>
												<span class="text-danger"><?php echo form_error('course_id'); ?></span>

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
							<!-- <div class="col-md-4">
								<form role="form" action="<?php echo site_url('admin/students/search') ?>" method="post" class="">
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="col-md-12">
										<div class="form-group">
											<label><?php echo get_phrase('search_by_keyword'); ?></label>
											<input class="form-control form-control-lg r-30" type="text" name="search_text" placeholder="<?php echo get_phrase('search_by_student_name'); ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<button type="submit" name="search" value="search_full" class="btn btn-primary pull-right"><i class="icon icon-search"></i> <?php echo get_phrase('search'); ?></button>
										</div>
									</div>
								</form>
							</div> -->
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
													<th>DATE</th>
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
															<td><?php echo $student['created_at'] ?></td>
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