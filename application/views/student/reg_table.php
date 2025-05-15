	<div class="row g-5 g-xl-10 mb-5 mb-xl-10">


		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="card shadow">
				<div class="card-header bg-danger text-white text-uppercase text-center download_label">
					<div class="card-title">
						<h4 class="text-white">Courses To Register</h4>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">

						<?php echo form_open('', array('id' => 'add_reg_form')); ?>
						<table class="table table-hover table-rounded table-condensed border gy-3 gs-3">
							<thead>
								<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
									<th class="w-10px pe-2">
										<?php
										if ($count == NULL) { ?>
											<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
												<input id="select_all" class="form-check-input" type="checkbox" />
											</div>
										<?php } ?>
									</th>
									<!-- <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"> -->
									<th>Course Code</th>
									<th>Course Title</th>
									<th class="text-center">Status</th>
									<th class="text-center">Unit</th>
								</tr>
							</thead>
							<tbody>

								<?php
								foreach ($course_re as $course) {
								?>
									<tr id="tr-<?php echo $course->id ?>" class="py-5 fw-semibold  border-bottom border-gray-300 fs-6">
										<?php $subject_id = $course->id; ?>




										<td>
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input type="checkbox" id="checkbox" class="form-check-input checkbox" name="check" data-subject_id="<?php echo $course->id ?>" value="<?php echo $course->id ?>" <?php foreach ($reg as $value) {
																																																						if ($course->id == $value) {
																																																							echo "disabled";
																																																						}
																																																					}; ?> />
											</div>

											<!-- <input type="checkbox" class="checkbox center-block" name="check" data-subject_id="<?php echo $course->id ?>" value="<?php echo $course->id ?>" disabled>
 -->
											<input type="hidden" id="student_id" name="student_id" value="<?php echo $student['id']; ?>">
											<input type="hidden" id="reg_no" name="reg_no" value="<?php echo $student['reg_no']; ?>">
											<input type="hidden" id="session_id" name="session_id" value="<?php echo $this->current_session; ?>">
											<input type="hidden" id="semester_id" name="semester_id" value="<?php echo $this->current_semester; ?>">
											<input type="hidden" id="class_id" name="class_id" value="<?php echo $student['class_id']; ?>">
											<input type="hidden" id="course_id" name="course_id" value="<?php echo $student['course_id']; ?>">

										</td>
										<td style="font-size: 11px; font-weight: bold"><?php echo $course->code ?></td>
										<td style="font-size: 11px; font-weight: bold"><?php echo $course->subject ?></td>
										<td class="text-center" style="font-size: 11px"><?php echo $course->status ?></td>
										<td class="text-center" style="font-size: 11px"><?php echo $course->unit ?></td>
									</tr>
								<?php }; ?>
							</tbody>
						</table>

						<table border="0" class="table">
							<tr class="text-right">
								<td colspan="3"><strong>Total <?php echo $unit->unit; ?></strong></td>
							</tr>
							<tr>
								<td class="text-center">
									<button type="submit" id="add_reg" class="btn btn-sm btn-primary course_selected">Add Course (s)</button>

									<button type="button" class="btn btn-sm btn-secondary " onclick="history.go(-1);">Back</button>
								</td>
							</tr>
						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6 col-sm-12 col-xs-12">
			<?php
			if ($count != NULL) { ?>

				<div class="card shadow">
					<div class="card-header bg-danger text-white text-uppercase text-center download_label">
						<div class="card-title">

							<h4 class="text-white"><b>Total No of Course Credit(s) Registered For: (<?php echo $count; ?>)</b></h4>

						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive mb-4">

							<table id="table" class="table table-hover table-rounded table-condensed border gy-3 gs-3">
								<thead>
									<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
										<!-- 	<th class="w-10px pe-2"> -->

										<!-- 	<input type="checkbox" id="select_to_delete_all" class="mr-2" /><button type="button" name="delete_all" id="delete_all" class="btn btn-circle btn-danger btn-xs"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
																		<circle cx="12" cy="12" r="10"></circle>
																		<line x1="15" y1="9" x2="9" y2="15"></line>
																		<line x1="9" y1="9" x2="15" y2="15"></line>
																	</svg></button> -->
										<!-- </th> -->
										<th>Code</th>
										<th>Course Title</th>

										<!-- <th class="text-center">Action</th> -->
									</tr>
								</thead>

								<tbody>

									<?php
									if ($count != NULL) {
										//$num = 1;
										foreach ($registered as $reg) {
									?>
											<tr>
												<?php $id = $reg->id; ?>

												<td style="font-size: 10px;" id="<?= $id; ?>" data-course_id="<?= $id; ?>">
													<b><?php echo $reg->code  . " " . "(" . $reg->unit . ")"; ?></b>
												</td>
												<td style="font-size: 10px;">
													<b><?php echo $reg->subject; ?></b>
												</td>

												<!-- <td class="text-center"><a href="#" class="bs-tooltip text-danger delete" id="<?php echo $id; ?>" data-toggle=" tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
															<circle cx="12" cy="12" r="10"></circle>
															<line x1="15" y1="9" x2="9" y2="15"></line>
															<line x1="9" y1="9" x2="15" y2="15"></line>
														</svg></a></td> -->
											</tr>
									<?php }
									}; ?>

								</tbody>
							</table>
							<table border="0" class="table table-hover table-condensed">


								<tr>
									<td>
										<button type="button" name="delete_all" id="delete_all" class="btn btn-sm btn-circle btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
												<circle cx="12" cy="12" r="10"></circle>
												<line x1="15" y1="9" x2="9" y2="15"></line>
												<line x1="9" y1="9" x2="15" y2="15"></line>
											</svg> Remove Seleted</button>

										<!-- <?php echo form_open('students/course_reg/later/' . $student['id'], ' id="save"'); ?>

															<?php echo $this->customlib->getCSRF(); ?>
															<input type="hidden" id="count" name="count" value="<?php echo $count; ?>">

															<button type="submit" class="btn btn-sm btn-primary">Save for Later</button>
															<?php echo form_close(); ?> -->

									</td>
									<td>


										<form action="" id="register" method="post">

											<?php echo $this->customlib->getCSRF(); ?>
											<input type="hidden" id="count" name="count" value="<?php echo $count; ?>">
											<input type="hidden" id="id" name="id" value="<?= $student['id'] ?>">

											<button type="submit" class="btn btn-sm btn-primary"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-diff" viewBox="0 0 16 16">
													<path d="M8 5a.5.5 0 0 1 .5.5V7H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V8H6a.5.5 0 0 1 0-1h1.5V5.5A.5.5 0 0 1 8 5zm-2.5 6.5A.5.5 0 0 1 6 11h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
													<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
												</svg> Finalize & Submit</button>
										</form>

									</td>

								</tr>
								<tr>
									<td colspan="2" bgcolor="#fff" style="font-size: 10px; color: #F00;"><strong>NOTE: YOU CAN NOT ADD MORETHAN 24 CREDIT UNITS</strong></td>
								</tr>

							</table>

						</div>
					</div>
				</div>

			<?php } ?>
		</div>
	</div>
	</div>


	<!-- 
<?php
if ($count != NULL) { ?>

	<div class="card shadow">
		<div class="card-header bg-danger text-white text-uppercase text-center download_label">
			<div class="card-title">

				<h4 class="text-white"><b>Total No of Course Credit(s) Registered For: (<?php echo $count; ?>)</b></h4>

			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive mb-4">

				<table class="table table-hover table-rounded table-condensed border gy-3 gs-3">
					<thead>
						<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
							<th class="w-10px pe-2">

							</th>
							<th>Code</th>
							<th>Course Title</th>

							<th class="text-center">Action</th>
						</tr>
					</thead>

					<tbody>

						<?php
						if ($count != NULL) {
							//$num = 1;
							foreach ($registered as $reg) {
						?>
								<tr>
									<?php $id = $reg->id; ?>
									<td><input type="checkbox" class="delete_checkbox" value="<?php echo $id; ?>" /></td>

									<td style="font-size: 10px;">
										<b><?php echo $reg->code  . " " . "(" . $reg->unit . ")"; ?></b>
									</td>
									<td style="font-size: 10px;">
										<b><?php echo $reg->subject; ?></b>
									</td>

									<td class="text-center"><a href="#" class="bs-tooltip text-danger delete" id="<?php echo $id; ?>" data-toggle=" tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
												<circle cx="12" cy="12" r="10"></circle>
												<line x1="15" y1="9" x2="9" y2="15"></line>
												<line x1="9" y1="9" x2="15" y2="15"></line>
											</svg></a></td>
								</tr>
						<?php }
						}; ?>

					</tbody>
				</table>
				<table border="0" class="table table-hover table-condensed">


					<tr>
						<td>
							<button type="button" name="delete_all" id="delete_all" class="btn btn-sm btn-circle btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
									<circle cx="12" cy="12" r="10"></circle>
									<line x1="15" y1="9" x2="9" y2="15"></line>
									<line x1="9" y1="9" x2="15" y2="15"></line>
								</svg> Remove Seleted</button>

						</td>
						<td>


							<form action="" id="register" method="post">

								<?php echo $this->customlib->getCSRF(); ?>
								<input type="hidden" id="count" name="count" value="<?php echo $count; ?>">
								<input type="hidden" id="id" name="id" value="<?= $student['id'] ?>">

								<button type="submit" class="btn btn-sm btn-primary"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-diff" viewBox="0 0 16 16">
										<path d="M8 5a.5.5 0 0 1 .5.5V7H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V8H6a.5.5 0 0 1 0-1h1.5V5.5A.5.5 0 0 1 8 5zm-2.5 6.5A.5.5 0 0 1 6 11h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
										<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
									</svg> Finalize & Submit</button>
							</form>

						</td>

					</tr>
					<tr>
						<td colspan="2" bgcolor="#fff" style="font-size: 10px; color: #F00;"><strong>NOTE: YOU CAN NOT ADD MORETHAN 24 CREDIT UNITS</strong></td>
					</tr>

				</table>

			</div>
		</div>
	</div>

<?php } ?>

 -->
	<br>
