<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-user"></i>
						Assign Payment Item
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" href="#" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>Payment Items</a>
					</li>


				</ul>
			</div>
		</div>
	</header>
	<?php if ($this->session->flashdata('toast')) { ?>
		<?php echo $this->session->flashdata('toast') ?>
	<?php } ?>
	<?php echo $this->customlib->getCSRF(); ?>
	<div class="container-fluid my-3">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">

					</div>
					<div class="card-body">
						<form class="assign_teacher_form" action="<?php echo base_url(); ?>admin/payments/getPaymentItems" method="post" enctype="multipart/form-data">

							<div class="row">
								<div class="col-md-12">
									<?php if ($this->session->flashdata('msg')) { ?>
										<?php echo $this->session->flashdata('msg') ?>
									<?php } ?>
									<?php echo $this->customlib->getCSRF(); ?>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label><?php echo 'Payment Category'; ?></label><small class="req"> *</small>
										<select autofocus="" id="payment_type" name="payment_type" class="form-control">
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php
											foreach ($payment_type as $key => $value) {
											?>
												<option value="<?php echo $key; ?>" <?php if (set_value('payment_type') == $key) echo "selected"; ?>><?php echo $value; ?></option>
											<?php
											}
											?>
										</select>
										<span class="payment_type_error text-danger"></span>
									</div>
								</div>
								<div id="department" class="col-md-3">
									<div class="form-group">
										<label><?php echo 'Department'; ?></label><small class="req"> *</small>
										<select autofocus="" id="department_id" name="department_id" class="form-control">
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php
											foreach ($departmentlist as $department) {
											?>
												<option value="<?php echo $department['id'] ?>"><?php echo 'Dept of ' . $department['name'] ?></option>
											<?php

											}
											?>
										</select>
										<span class="department_id_error text-danger"></span>
									</div>
								</div>

								<div id="course" class="col-md-3">
									<div class="form-group">
										<label><?php echo 'Course'; ?></label> <small class="req"> *</small>

										<select autofocus="" id="course_id" name="course_id" class="form-control">
											<option value=""><?php echo get_phrase('select'); ?></option>
										</select>
										<span class="course_id_error text-danger"></span>

									</div>
								</div>
								<br>
								<div id="class" class="col-md-3">
									<div class="form-group">
										<label><?php echo get_phrase('level'); ?></label><small class="req"> *</small>
										<select autofocus="" id="class_id" name="class_id" class="form-control">
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php
											foreach ($classlist as $class) {
											?>
												<option value="<?php echo $class['id'] ?>"><?php echo $class['class'] ?></option>
											<?php

											}
											?>
										</select>
										<span class="class_id_error text-danger"></span>
									</div>
								</div>
								<div id="semester" class="col-md-3">
									<div class="form-group">
										<label><?php echo 'Semester'; ?></label><small class="req"> *</small>
										<select id="semester_id" name="semester_id" class="form-control">
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php
											foreach ($semesters as $semester) {
											?>
												<option value="<?php echo $semester['id'] ?>" <?php if (set_value('semester_id') == $semester['id']) echo "selected=selected" ?>><?php echo $semester['semester'] ?></option>
											<?php

											}
											?>
										</select>
										<span class="semester_id_error text-danger"></span>
									</div>
								</div>
								<div id="indigene_field" class="col-md-3">
									<div class="form-group">
										<label><?php echo 'Indigene'; ?></label><small class="req"> *</small>
										<select id="indigene" name="indigene" class="form-control">
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php
											foreach ($indigene as $key => $value) {
											?>
												<option value="<?php echo $key; ?>" <?php if (set_value('indigene') == $key) echo "selected"; ?>><?php echo $value; ?></option>
											<?php
											}
											?>
										</select>
										<span class="indigene_error text-danger"></span>
									</div>
								</div>
							</div>
							<button type="submit" id="search_filter" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle flaot-right"><i class="icon icon-search"></i> <?php echo get_phrase('search'); ?></button>
						</form>
					</div>

				</div>
			</div>
			<div class="col-md-12">

				<div class="card card-success mt-3" id="box_display" style="display:none">
					<div class="card-header with-border">
						<h3 class="card-title"><i class="icon icon-money"> </i> <?php echo 'Payment Items'; ?></h3>

						<div class="card-tools float-right">
							<button id="btnAdd" class="btn btn-primary btn-sm checkbox-toggle float-right" type="button"><i class="icon icon-plus"></i> <?php echo get_phrase('add'); ?></button>
						</div>
					</div>
					<form action="<?php echo base_url() ?>admin/payments/manage_amounts" method="POST" id="formSubjectTeacher">
						<?php echo $this->customlib->getCSRF(); ?>
						<br />
						<input type="hidden" value="0" id="post_payment_type" name="payment_type">
						<input type="hidden" value="0" id="post_department_id" name="department_id">
						<input type="hidden" value="0" id="post_course_id" name="course_id">
						<input type="hidden" value="0" id="post_class_id" name="class_id">
						<input type="hidden" value="0" id="post_semester_id" name="semester_id">
						<input type="hidden" value="0" id="post_indigene" name="indigene">

						<div class="form-horizontal" id="TextBoxContainer" role="form">
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary btn-lg float-right save_button" style="display: none;"><?php echo get_phrase('save'); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
