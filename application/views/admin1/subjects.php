<!-- $('#myTable tr:last').after('<tr>...</tr>
<tr>...</tr>'); -->
<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-university"></i>
						Courses
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>All Courses</a>
					</li>

				</ul>
			</div>
		</div>
	</header>
	<div class="container-fluid my-3">
		<div class="row">
			<div class="col-md-4">
				<?php if ($this->session->flashdata('toast')) { ?>
					<?php echo $this->session->flashdata('toast') ?>
				<?php } ?>
				<div class="card shadow r-0">
					<div class="card-header danger text-white text-uppercase">
						<h5 class="card-title"><i class="icon icon-pen"></i> Add Course</h5>
					</div>
					<div class="card-body">

						<form id="subject" method="post" class="needs-validation" novalidate accept-charset="utf-8">

							<?php if ($this->session->flashdata('msg')) { ?>
								<?php echo $this->session->flashdata('msg') ?>
							<?php } ?>
							<?php echo $this->customlib->getCSRF(); ?>

							<div class="form-group">
								<label><?php echo 'Course Title'; ?> </label><small class="req"> *</small>
								<input autofocus="" id="name" name="name" placeholder="" type="text" class="form-control" value="<?php echo set_value('name'); ?>" required />
								<span class="text-danger"><?php echo form_error('name'); ?></span>
							</div>
							<div class="form-group">
								<label><?php echo 'Course Code' ?></label>
								<input name="code" placeholder="" type="text" class="form-control" value="<?php echo set_value('code'); ?>" required />
								<span class="text-danger"><?php echo form_error('code'); ?></span>
							</div>
							<div class="form-group">
								<label class="radio-inline">
									<input type="radio" value="C" name="status" <?php if (set_value('status') == "C") echo "checked"; ?> checked><?php echo 'Core'; ?>
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" <?php if (set_value('status') == "E") echo "checked"; ?> value="E"><?php echo 'Elective'; ?>
								</label>
							</div>
							<div class="form-group">
								<label><?php echo 'Unit'; ?></label>
								<input autofocus="" id="unit" name="unit" placeholder="" type="text" class="form-control" value="<?php echo set_value('unit'); ?>" required />
								<span class="text-danger"><?php echo form_error('unit'); ?></span>
							</div>

							<div class="form-group">
								<label><?php echo get_phrase('level'); ?></label><small class="req"> *</small>
								<select id="class_id" name="class_id" class="form-control" required>
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
							<div class="form-group">
								<label><?php echo 'Semester'; ?></label><small class="req"> *</small>
								<select id="semester_id" name="semester_id" class="form-control" required>
									<option value=""><?php echo get_phrase('select'); ?></option>
									<?php
									foreach ($semesterlist as $semester) {
									?>
										<option value="<?php echo $semester['id'] ?>" <?php if (set_value('semester_id') == $semester['id']) echo "selected=selected" ?>><?php echo $semester['semester'] ?></option>
									<?php

									}
									?>
								</select>
								<span class="text-danger"><?php echo form_error('semester_id'); ?></span>
							</div>
							<div class="form-group">
								<label><?php echo 'Programme'; ?></label><small class="req"> *</small>
								<select id="course_id" name="course_id" class="form-control" required>
									<option value=""><?php echo get_phrase('select'); ?></option>
									<?php
									foreach ($courselist as $course) {
									?>
										<option value="<?php echo $course['id'] ?>" <?php if (set_value('course_id') == $course['id']) echo "selected=selected" ?>><?php echo $course['name'] ?></option>
									<?php

									}
									?>
								</select>
								<span class="text-danger"><?php echo form_error('course_id'); ?></span>
							</div>
							<div class="card-footer">
								<button id="subject_button" type="submit" class="btn btn-info pull-right"><?php echo get_phrase('save'); ?></button>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card r-0 shadow">
					<div class="card-header danger text-white text-uppercase">
						<h5 class="card-title"><i class="icon icon-clipboard-list"></i> Course List</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="table-responsive">
								<table id="basic" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<!-- <th>S/n</th> -->
											<th><?php echo 'Course Code'; ?></th>
											<th><?php echo 'Course Title'; ?></th>
											<th><?php echo 'Status'; ?></th>
											<th><?php echo 'Unit'; ?></th>
											<th><?php echo 'Program'; ?></th>
											<th><?php echo 'Level'; ?></th>
											<th><?php echo 'Semester'; ?></th>
											<th width="50" class="text-right no-print"><?php echo get_phrase('action'); ?></th>
										</tr>
									</thead>
									<tbody>

										<?php
										$count = 1;
										$s = 1;
										foreach ($subjectlist as $subject) {
										?>
											<tr>
												<!-- <td><?php echo $s++; ?> </td> -->
												<td id="td_name-<?php echo $subject['id'] ?>"> <?php echo $subject['name'] ?></td>
												<td id="td_code-<?php echo $subject['id'] ?>"> <?php echo $subject['code'] ?></td>
												<td id="td_status-<?php echo $subject['id'] ?>"> <?php echo $subject['status'] ?></td>
												<td id="td_unit-<?php echo $subject['id'] ?>"> <?php echo $subject['unit'] ?></td>
												<td id="td_course-<?php echo $subject['id'] ?>"> <?php echo $subject['course'] ?></td>
												<td id="td_class-<?php echo $subject['id'] ?>"> <?php echo $subject['class'] ?></td>
												<td id="td_semester-<?php echo $subject['id'] ?>"> <?php echo $subject['semester'] ?></td>
												<td class="text-right">


													<a href="javascript:void(0)" data-id="<?php echo $subject['id']; ?>" id="<?php echo $subject['id']; ?>" class="edit-product" data-toggle="tooltip" title="Edit" data-original-title="Edit">
														<i class="icon-edit mr-3"></i>
													</a>

													<a href="<?php echo base_url(); ?>admin/subjects/delete/<?php echo $subject['id'] ?>" class="delete" id="<?php echo $subject['id']; ?>" data-toggle="tooltip" title="Delete" data-original-title="DeleteDelete">
														<i class="text-danger icon icon-trash mr-3"></i>
													</a>


												</td>
											</tr>
										<?php
										}
										$count++;
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
					<input type="hidden" name="modal_id" id="modal_id">

					<div class="form-group">
						<label for="subject" class="col-sm-6 control-label">Course Title</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="modal_name" name="modal_name" placeholder="Course Title" value="" required="">
						</div>
					</div>
					<div class="form-group">
						<label for="subject" class="col-sm-6 control-label">Course Code</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="modal_code" name="modal_code" placeholder="Course Title" value="" required="">
						</div>
					</div>

					<div class="form-group">
						<label class="radio-inline">
							<input type="radio" value="C" name="modal_status" <?php if (set_value('status') == "C") echo "checked"; ?> checked><?php echo 'Core'; ?>
						</label>
						<label class="radio-inline">
							<input type="radio" name="modal_status" <?php if (set_value('status') == "E") echo "checked"; ?> value="E"><?php echo 'Elective'; ?>
						</label>
					</div>
					<div class="form-group">
						<label><?php echo 'Unit'; ?></label>
						<input autofocus="" id="modal_unit" name="modal_unit" placeholder="" type="text" class="form-control" value="<?php echo set_value('unit'); ?>" required />
						<span class="text-danger"><?php echo form_error('unit'); ?></span>
					</div>

					<div class="form-group">
						<label><?php echo get_phrase('level'); ?></label><small class="req"> *</small>
						<select id="modal_class_id" name="modal_class_id" class="form-control" required>
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
					<div class="form-group">
						<label><?php echo 'Semester'; ?></label><small class="req"> *</small>
						<select id="modal_semester_id" name="modal_semester_id" class="form-control" required>
							<option value=""><?php echo get_phrase('select'); ?></option>
							<?php
							foreach ($semesterlist as $semester) {
							?>
								<option value="<?php echo $semester['id'] ?>" <?php if (set_value('semester_id') == $semester['id']) echo "selected=selected" ?>><?php echo $semester['semester'] ?></option>
							<?php

							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('semester_id'); ?></span>
					</div>
					<div class="form-group">
						<label><?php echo 'Programme'; ?></label><small class="req"> *</small>
						<select id="modal_course_id" name="modal_course_id" class="form-control" required>
							<option value=""><?php echo get_phrase('select'); ?></option>
							<?php
							foreach ($courselist as $course) {
							?>
								<option value="<?php echo $course['id'] ?>" <?php if (set_value('course_id') == $course['id']) echo "selected=selected" ?>><?php echo $course['name'] ?></option>
							<?php

							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('course_id'); ?></span>
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