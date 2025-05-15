<?php
$selected_session = $this->db->get_where('sessions', array('id' => $session_id))->row()->session;
$selected_semester = $this->db->get_where('semesters', array('id' => $semester_id))->row()->semester;

if (!empty($resultlist)) {
?>
	<div class="card">
		<div class="card-header text-center">
			<h4 class=" fw-bold card-title">
				<?= $selected_session . ' / ' . $selected_semester; ?>
			</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-xl-10 col-md-10 col-sm-12 col-12 mx-auto">
					<div class="table-responsive mb-4">

						<div class="float-right">
							<a href="<?php echo base_url() . 'student/semester_form_pdf/' . $semester_id . '/' . $session_id; ?>" type="button" title="Generate Semester Form" class="btn btn-sm btn-success mb-2" target="_blank"><i class="fa fa-print"></i>Print Semester Form</a>

							<!-- <form method="post" action="<?php echo base_url('admin/student/print_form') ?>">
								<input type="hidden" id="id" name="id" value="<?php echo $student['id']; ?>">
								<input type="hidden" id="sess_id" name="sess_id" value="<?php echo $session_id; ?>">
								<input type="hidden" id="sm_id" name="sm_id" value="<?php echo $semester_id; ?>">
								<button class="btn btn-xs btn-success mb-2 form" type="button" title="Generate Semester Form"><i class="icon icon-print"></i>Print Semester Form</button>
							</form> -->
						</div>

						<table id="table" class="table table-hover table-rounded table-condensed border gy-3 gs-3">
							<thead>
								<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">

									<th class="">#</th>
									<th>COURSE CODE</th>
									<th>COURSE TITLE</th>
									<th>STATUS</th>
									<th>UNIT</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$count = 1;
								foreach ($resultlist as $course) { ?>
									<!-- <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
 -->
									<tr>
										<td class=""><?php echo $count++; ?></td>
										<td><?php echo $course->code; ?></td>
										<td><?php echo $course->subject; ?></td>
										<td><?php echo $course->status; ?></td>
										<td><?php echo $course->unit; ?></td>
									</tr>
								<?php } ?>
								<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
									<td colspan="3" class=""></td>
									<td>
										<b class="float-right">Total Credit Units:</b>

									</td>
									<td class=""><b><?php echo $total; ?></b></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="float-left">

						<a href="<?php echo base_url() . 'student/semester_form_pdf/' . $semester_id . '/' . $session_id; ?>" type="button" title="Generate Semester Form" class="btn btn-sm btn-success mb-2" target="_blank"><i class="fa fa-print"></i>Print Semester Form</a>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php
} else {
?>
	<div class="card">
		<div class="card-header">
			<h4 class=" fw-bold card-title text-center">
				<?= $selected_session . ' / ' . $selected_semester; ?>
			</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-xl-8 col-md-8 col-sm-12 col-12 mx-auto">

					<table width="648" border="0" cellpadding="5" cellspacing="5" class="table table-bordered table-striped">
						<tr>
							<th colspan="4" style="font-size: 12px; text-align: center; color:red" scope="row">No Record Found</th>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php };
?>
