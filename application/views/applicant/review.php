<div class="row">
	<!-- bar charts group -->
	<div class="col-md-12">

		<div class="avatar avatar-md text-center mb-2">

			<img alt="avatar" src="<?php
									if (!empty($applicant['image'])) {
										echo base_url() . $applicant['image'];
									}
									?>" class="rounded-square " />
		</div>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">BIO DATA</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-rounded table-row-dashed border p-3">
						<thead>
							<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
								<th>Application Number</th>
								<th><?php echo $applicant['application_no']; ?></th>
								<input type="hidden" id="id" name="id" value="<?= $applicant['id'] ?>">
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Full Name</td>
								<td><?php echo $applicant['firstname'] . " " . $applicant['lastname'] . " " . $applicant['middlename']; ?></td>

							</tr>
							<tr>
								<td>Date of Birth</td>
								<td><?php echo $applicant['dob']; ?></td>

							</tr>
							<tr>
								<td>Phone</td>
								<td><?php echo $applicant['phone']; ?></td>

							</tr>
							<tr>
								<td>Email</td>
								<td><?php echo $applicant['email']; ?></td>

							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $applicant['gender']; ?></td>

							</tr>
							<tr>
								<td>State</td>
								<td><?php echo $applicant['state']; ?></td>

							</tr>
							<tr>
								<td>L.G.A</td>
								<td><?php echo $applicant['local_g']; ?></td>

							</tr>
							<tr>
								<td>Marital Status</td>
								<td><?php echo $applicant['marital_status']; ?></td>

							</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>

		<br>
		<div class="card">

			<div class="card-header">
				<h5 class="card-title">ADDRESS DETAILS</h5>
			</div>

			<div class="card-body">

				<div class="table-responsive">
					<table class="table table-rounded table-row-dashed border p-3">
						<thead>
							<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
								<th>Current Address</th>
								<th><?php echo $applicant['current_address']; ?></th>

							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Local Government</td>
								<td><?php echo $applicant['local_government']; ?></td>

							</tr>
							<tr>
								<td>State</td>
								<td><?php echo $applicant['state']; ?></td>

							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
		<div class="card ">
			<div class="card-header">
				<h5 class="card-title">COURSE OF CHOICE</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-rounded table-row-dashed border p-3">
						<thead>
							<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
								<th>First Choice</th>
								<th><?php
									echo $choice1['choice_course']; ?></th>

							</tr>
							<tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
								<th>Second Choice</th>
								<th><?php
									echo $choice2['choice_course']; ?></th>

							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<br>
		<div class="card ">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-rounded table-row-dashed border p-3">

						<tbody>
							<tr>
								<td>Primary School</td>
								<td><?php echo $applicant['primary_school'] ?></td>

								<td>Year of Graduation</td>
								<td><?php echo $applicant['primary_school_year']; ?></td>
							</tr>
							<tr>
								<td>Secondary School</td>
								<td><?php echo $applicant['secondary_school'] ?></td>

								<td>Year of Graduation</td>
								<td><?php echo $applicant['secondary_school_year']; ?></td>
							</tr>
						</tbody>

					</table>
				</div>
			</div>
		</div>
		<br>
		<?php
		$count = 1;
		foreach ($neco as $value) { ?>
			<br>
			<div class="card ">

				<div class="card-header">
					<h5 class="card-title"><?php echo $value['title']; ?> - <?php echo $value['exam_year']; ?> - (<?php echo $value['exam_no']; ?>)</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-rounded table-row-dashed border p-3">
							<tbody>
								<tr>
									<td><?php echo $value['subject']; ?></td>
									<td><?php echo $value['grade']; ?></td>
								</tr>
								<tr>
									<td><?php echo $value['subject2']; ?></td>
									<td><?php echo $value['grade2']; ?></td>
								</tr>

								<tr>
									<td><?php echo $value['subject3']; ?></td>
									<td><?php echo $value['grade3']; ?></td>
								</tr>

								<tr>
									<td><?php echo $value['subject4']; ?></td>
									<td><?php echo $value['grade4']; ?></td>
								</tr>

								<tr>
									<td><?php echo $value['subject5']; ?></td>
									<td><?php echo $value['grade5']; ?></td>
								</tr>

								<tr>
									<td><?php echo $value['subject6']; ?></td>
									<td><?php echo $value['grade6']; ?></td>
								</tr>

								<tr>
									<td><?php echo $value['subject7']; ?></td>
									<td><?php echo $value['grade7']; ?></td>
								</tr>

								<tr>
									<td><?php echo $value['subject8']; ?></td>
									<td><?php echo $value['grade8']; ?></td>
								</tr>

								<tr>
									<td><?php echo $value['subject9']; ?></td>
									<td><?php echo $value['grade9']; ?></td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php }; ?>




		<!-- /bar charts group -->
	</div>
</div>
