<div class="card shadow r-0">
	<div class="card-header danger text-white text-uppercase">
		<h5 class="card-title"><i class="icon icon-pen"></i> Borrow Courses</h5>
	</div>
	<div class="card-body">

		<form id="register">
			<div class="card-body">
				<div class="form-group">
					<?php echo $this->customlib->getCSRF(); ?>
					<select id="sug" name=" subject_id" class="form-control">
						<option value=""><?php echo 'Select Course' ?></option>
						<?php
						foreach ($subject as $course) {
							echo '<option value="' . $course->id . '">' . $course->code . '</option>';
						}
						?>
					</select>
					<input type="hidden" id="semester_id" name="semester_id" value="<?php echo $semester_id; ?>">
					<input type="hidden" id="class_id" name="class_id" value="<?php echo $class_id; ?>">
					<input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>">
				</div>

				<button name="save_co" type="button" class="btn btn-danger save_co">Add Course</button>

			</div>
		</form>

	</div>
</div>
