<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title"><i class="icon icon-list"></i>Registerable Courses</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
					<thead>
						<tr>
							<!--  <th><?php echo 'S/n' ?></th> -->
							<th><?php echo 'Code'; ?></th>
							<th><?php echo 'Name'; ?></th>
							<th></th>

						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						//$s = 1;
						foreach ($registrable_courses as $sug) {
						?>
							<tr>
								<!--  <td><?php echo $s++ ?></td> -->
								<td class="text-uppercase"><?php echo $sug->code; ?></td>
								<td class="text-uppercase"><?php echo $sug->subject; ?></td>
								<?php $id = $sug->id; ?>
								<td class="text-center"><a href="#" class="bs-tooltip text-danger delete" id="<?php echo $id; ?>" data-toggle=" tooltip" data-placement="top" title="" data-original-title="Delete"><i class="icon icon-cross"></i> Remove</a></td>
							</tr>
						<?php
							$count++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>

<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title"><i class="icon icon-list"></i> Departmental Courses</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<?php echo form_open('', array('id' => 'add_reg_form')); ?>
				<table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
					<thead>
						<tr>
							<!-- 	<?php if (empty($reg)) : ?>
								<th><input type="checkbox" id="select_all" name="check" class="checkbox"> </th>

							<?php
										else : ?>
								<th> </th>
							<?php endif ?> -->
							<th></th>
							<th><?php echo 'Code'; ?></th>
							<th><?php echo 'Name'; ?></th>

						</tr>
					</thead>
					<tbody>
						<?php
						if (empty($result)) {
						?>
							<tr>
								<td colspan="3" class="text-danger text-center"><?php echo get_phrase('no_record_found'); ?></td>
							</tr>
							<?php
						} else {
							$count = 1;

							foreach ($result as $subject) {
							?>
								<tr>
									<td class="text-center">


										<input type="checkbox" name="check" class="checkbox" data-subject_id="<?php echo $subject['id'] ?>" value="<?php echo $subject['id'] ?>" <?php foreach ($reg as $value) {
																																														if ($subject['id'] == $value) {
																																															echo "disabled";
																																														}
																																													}; ?> />
										<input type="hidden" id="semester_id" name="semester_id" value="<?php echo $semester_id; ?>">
										<input type="hidden" id="class_id" name="class_id" value="<?php echo $class_id; ?>">
										<input type="hidden" id="course_id" name="course_id" value="<?php echo $course_id; ?>">


									</td>

									<td class="text-uppercase"><a href="<?php echo $subject['id']; ?>"> <?php echo $subject['code']; ?></a></td>
									<td class="text-uppercase"><?php echo $subject['name']; ?></td>

								</tr>
						<?php
								$count++;
							}
						}
						?>
						<tr>

							<td colspan="3" class="text-center">
								<button type="submit" id="add_reg" class="btn btn-danger printSelected">Add Course (s)</button>
							</td>

						</tr>
					</tbody>
				</table>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>