<div class="box">
	<!-- form start -->
	<div class="box-body" style="margin-bottom: 50px;">
		<div class="row">
			<?php $system_name = $this->db->get_where('settings', array('key' => 'system_name'))->row()->value; ?>

			<div class="col-sm-12">

				<div class="reportPage-header">';
					<span class="header"><img class="logo" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>"></span>';

					<p class="title"><?= $system_name; ?> </p>

					<p class="title-desc"> Applicant List 2024/2025 Academic Session</p>
				</div>
			</div>
			<!-- /.box-header -->


			<div class="col-sm-12">

				<?php
				foreach ($departments as $value) {
					$i = 1; ?>
					<?php if (!empty($value->list)) { ?>
						<h2 style="text-align: center;">Department of <?php echo $value->name; ?></h2>
					<?php }; ?>
					<?php if (!empty($value->list)) {
						echo '<div class="table-responsive">
						<table class="table table-bordered table-responsive">
							<thead>
								<tr>
								<th>S/N</th>	
								<th>APP NO</th>
								<th>NAME</th>
								<th>SEX</th>
								<th>COURSE</th>
								<th>STATE</th>
								<th>PHONE</th>
								
								</tr>
							</thead>';
						foreach ($value->list as $student) {
							echo '	<tbody>
								<tr>
								<td>' . $i++ . '</td>
								<td>' . $student->application_no . '</td>
									
								<td style="text-transform: uppercase;">' . $student->firstname . " " . $student->lastname . " " . $student->middlename . '</td>
								<td>' . $student->gender . '</td>
								<td>' . $student->course . '</td>
								<td>' . $student->state . '</td>
								<td>' . $student->phone . '</td>
								
								</tr>
								</tbody>';
						}; ?>


						</table>
						<div class="pagebreaker"></div>
						<div class="col-sm-12">
							<div class="reportPage-header">';
								<span class="header"><img class="logo" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>"></span>';

								<p class="title"><?= $system_name; ?> </p>

								<p class="title-desc">Applicant List 2024/2025 Academic Session </p>
							</div>
						</div>
						<div class="box-header bg-gray">
							<!-- <h2 class="box-title text-navy" style="text-align: center;"><i class="fa fa-clipboard"></i>
								SCHOOL OF SCIENCES <br>REGISTERED STUDENTS <br> SECOND SEMESTER 2019/2020 ACADEMIC SESSION

							</h2> -->
						</div>

					<?php	} ?>

				<?php } ?>

			</div>
			<div class="col-sm-12">
				<h2>Department-wise Count</h2>
				<div class="table-responsive">
					<table class="table table-bordered table-responsive">
						<thead>
							<tr>
								<th>Department</th>
								<th>Total Applicants</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($department_applicants as $row) { ?>
								<tr>
									<td><?php echo $row['department']; ?></td>
									<td><?php echo $row['total_students']; ?></td>
								</tr>
							<?php } ?>
							<tr>
								<td><b><?php echo 'TOTAL'; ?></b></td>
								<td><?php echo $total_applicants; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-12 text-center footerAll">
				<div class="footer">
					<img class="flogo" style="width:30px" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">
					<p class="copyright">Copyright @ <?= date('Y') ?> <?= $system_name; ?> </p>
				</div>
			</div>
		</div><!-- row -->
	</div><!-- Body -->
</div>
</div>