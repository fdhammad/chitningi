<!-- $('#myTable tr:last').after('<tr>...</tr>
<tr>...</tr>'); -->
<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-book"></i>
						Courses
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>Courses</a>
					</li>

				</ul>
			</div>
		</div>
	</header>
	<div class="container-fluid my-3">
		<?php if ($this->session->flashdata('toast')) { ?>
			<?php echo $this->session->flashdata('toast') ?>
		<?php } ?>
		<div class="row">
			<div class="col-md-4">
				<div id="course">

				</div>
			</div>
			<div class="col-md-8">
				<div class="card r-0 shadow">
					<div class="card-header danger text-white text-uppercase">
						<h5 class="card-title"><i class="icon icon-search"></i>Search Criteria</h5>
					</div>
					<div class="card-body">
						<form id="search_borrow" method="post" class="needs-validation" novalidate accept-charset="utf-8">
							<?php echo $this->customlib->getCSRF(); ?>
							<div class="row">

								<div class="col-md-4">
									<div class="form-group">
										<label><?php echo 'Programme'; ?></label> <small class="req"> *</small>
										<select autofocus="" id="course_id" name="course_id" class="form-control" required>
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
								</div>
								<div id="class" class="col-md-4">
									<div class="form-group">
										<label><?php echo 'Level'; ?></label><small class="req"> *</small>
										<select autofocus="" id="class_id" name="class_id" class="form-control" required>
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
								<div id="for_semester" class="col-md-4">
									<div class="form-group">
										<label><?php echo 'Semester'; ?></label> <small class="req"> *</small>

										<select autofocus="" id="semester_id" name="semester_id" class="form-control" required>
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
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<button type="submit" id="show" name="search" value="search_filter" class="btn btn-danger btn-sm pull-right checkbox-toggle"><i class="icon icon-search"></i> <?php echo get_phrase('search'); ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<br />
		<div id="result" class="row">

		</div>
	</div>
</div>
