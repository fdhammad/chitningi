  <style>
  	#export_buttons {
  		display: flex;
  		align-items: center;
  		gap: 10px;
  		/* Adjust gap as needed */
  	}
  </style>
  <div class="card shadow">
  	<div class="card-header">
  		<div class="row">
  			<div class="col-md-4">
  				<h4 class="card-title"><i class="icon icon-list"></i> Mark Result</h4>
  			</div>
  			<div id="export_buttons" class="col-md-8">
  				<form method="post" action="<?php echo base_url(); ?>admin/exams/export">
  					<input type="hidden" name="subject_id" class="form-control input-sm" value="<?php echo $subject_id; ?>">
  					<input type="hidden" name="semester_id" id="semester_id" class="form-control input-sm" value="<?php echo $semester_id; ?>">
  					<input type="hidden" name="session_id" id="session_id" class="form-control input-sm" value="<?php echo $session_id; ?>">
  					<button type="submit" name="export" class="btn btn-primary btn-sm mark" value="export">
  						<i class="icon-sign-out-alt"></i> <?php echo 'Export Excel Mark Sheet '; ?>
  					</button>
  				</form>
  				<form method="post" action="<?php echo base_url(); ?>admin/exams/export_result">
  					<input type="hidden" name="subject_id" class="form-control input-sm" value="<?php echo $subject_id; ?>">
  					<input type="hidden" name="semester_id" id="semester_id" class="form-control input-sm" value="<?php echo $semester_id; ?>">
  					<input type="hidden" name="session_id" id="session_id" class="form-control input-sm" value="<?php echo $session_id; ?>">
  					<button type="submit" name="export" class="btn btn-success btn-sm mark" value="export">
  						<i class="icon-sign-out-alt"></i> <?php echo 'Export Excel Result '; ?>
  					</button>
  				</form>
  			</div>
  		</div>
  	</div>
  	<div class="card-body">
  		<div class="table-responsive">
  			<?= form_open(base_url('admin/exams/add'), ['id' => 'marksForm']) ?>
  			<?php echo $this->customlib->getCSRF(); ?>
  			<table id="basic" class="table table-bordered table-striped table-hover">
  				<thead>
  					<tr>
  						<th><?php echo ('S/N'); ?></th>
  						<th><?php echo get_phrase('reg_no'); ?></th>
  						<!-- 	<th><?php echo get_phrase('student_name'); ?></th> -->
  						<th><?php echo ('C A'); ?></th>
  						<th><?php echo ('Exam'); ?></th>
  						<th><?php echo ('Total'); ?></th>
  						<th><?php echo ('Grade'); ?></th>
  						<!-- <th><?php echo ('GP'); ?></th>
  						<th><?php echo ('WGP'); ?></th> -->
  					</tr>
  				</thead>
  				<tbody>
  					<?php
						if (empty($students)) {
						?>
  						<tr>
  							<td colspan="9" class="text-danger text-center"><?php echo get_phrase('no_record_found'); ?></td>
  						</tr>
  						<?php
						} else {
							$count = 1;
							foreach ($students as $std) {
								$mark = $this->exam_model->get_mark($std['student_id'], $subject_id, $semester_id, $session_id);
							?>
  							<tr class="tr">
  								<td><?php echo $count++; ?></td>
  								<td class="text-uppercase">
  									<?php echo $std['reg_no']; ?>
  									<input type="hidden" name="id[]" class="form-control input-sm" value="<?php echo !empty($mark) ? $mark['id'] : ''; ?>">
  									<input type="hidden" name="student_id[]" value="<?php echo $std['student_id']; ?>">
  									<input type="hidden" name="course_id[]" value="<?php echo $subject_id; ?>"> <!-- Assuming $subject_id is the course_id -->
  									<input type="hidden" name="subject_id[]" value="<?php echo $subject_id; ?>">
  									<input type="hidden" name="semester_id[]" value="<?php echo $semester_id; ?>">
  									<input type="hidden" name="session_id[]" value="<?php echo $session_id; ?>">
  								</td>
  								<!-- <td class="text-uppercase"><?php echo $std['firstname'] . " " . $std['lastname'] . " " . $std['middlename']; ?></td>
  								 -->
  								<td><input type="number" name="ca[]" class="form-control input-sm autonumber mark" value="<?php echo !empty($mark) ? $mark['ca'] : ''; ?>" min="0" max="40" size="5"></td>
  								<td><input type="number" name="exam[]" class="form-control input-sm autonumber mark" value="<?php echo !empty($mark) ? $mark['exam'] : ''; ?>" min="0" max="60" size="5"></td>
  								<td><input type="number" name="total[]" class="form-control input-sm total" value="<?php echo !empty($mark) ? $mark['total'] : ''; ?>" readonly></td>
  								<td><input type="text" name="grade[]" class="form-control input-sm grade" value="<?php echo !empty($mark) ? $mark['grade'] : ''; ?>" readonly>
  									<input type="hidden" name="gp[]" class="form-control input-sm gp" value="<?php echo !empty($mark) ? $mark['gp'] : ''; ?>">
  									<input type="hidden" name="wgp[]" class="form-control input-sm wgp" value="<?php echo !empty($mark) ? $mark['wgp'] : ''; ?>">
  								</td>
  							</tr>
  					<?php
							}
						}
						?>
  				</tbody>
  				<tfoot>
  					<tr>
  						<td colspan="9" class="text-center">
  							<input type="submit" value="submit" class="btn btn-lg btn-success">
  						</td>
  					</tr>
  				</tfoot>
  			</table>
  			<?= form_close(); ?>
  		</div>
  	</div>
  </div>

  <script type="text/javascript">
  	$(document).ready(function() {
  		function calculateSum() {
  			const $input = $(this);
  			const $row = $input.closest('tr');
  			let sum = 0;

  			$row.find(".mark").each(function() {
  				sum += parseFloat(this.value) || 0;
  			});

  			const $total = $row.find(".total").val(sum);
  			const $grade = $row.find(".grade");
  			const $gp = $row.find(".gp");
  			const $wgp = $row.find(".wgp");

  			const unit = <?php echo $unit->unit; ?>;
  			let grade, gp, wgp;

  			if (sum >= 70 && sum <= 100) {
  				grade = "A";
  				gp = 4;
  			} else if (sum >= 60 && sum <= 69) {
  				grade = "B";
  				gp = 3;
  			} else if (sum >= 55 && sum <= 59) {
  				grade = "C";
  				gp = 2;
  			} else if (sum >= 50 && sum <= 54) {
  				grade = "D";
  				gp = 1;
  			} else {
  				grade = "F";
  				gp = 0;
  			}

  			wgp = gp * unit;

  			$grade.val(grade);
  			$gp.val(gp);
  			$wgp.val(wgp);
  		}

  		// Assuming you attach this function to some input elements like this:
  		$(".mark").on('input', calculateSum);
  	});
  </script>

  <script>
  	$(document).ready(function() {
  		$('#marksForm').on('submit', function(event) {
  			event.preventDefault(); // Prevent default form submission
  			var formData = $(this).serialize(); // Serialize form data
  			console.log(formData);
  			$.ajax({
  				url: $(this).attr('action'),
  				type: "POST",
  				data: formData,

  				success: function(response) {
  					var result = JSON.parse(response);
  					if (result.status === 'success') {
  						alert("Data submitted successfully!");
  					} else {
  						alert("Error: " + result.message);
  					}
  				},
  				error: function(xhr, status, error) {
  					console.error("An error occurred: " + error);
  					alert("An error occurred while submitting the data.");
  				}
  			});
  		});
  	});
  </script>