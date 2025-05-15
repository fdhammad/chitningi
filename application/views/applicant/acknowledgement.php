	<?php
	$applicant_id = $this->session->userdata('user_id');
	$applicant = $this->applicant_model->getAll($applicant_id)->row_array();
	$waec = $this->applicant_model->getWaec($applicant_id);
	//$this->data['waecs'] = $waec;
	$neco = $this->applicant_model->getNeco($applicant_id);
	//$this->data['neco'] = $neco;
	$choice1 = $this->applicant_model->get1choice($applicant_id);
	//$this->data['choice1'] = $choice1;
	$choice2 = $this->applicant_model->get2choice($applicant_id);
	//$this->data['choice2'] = $choice2;
	$choice = $this->applicant_model->get_choice($applicant_id);
	//$this->data['choice'] = $choice;
	$applicant_acad = $this->applicant_model->getapplicantacad($applicant_id);
	//$this->data['applicant_acad'] = $applicant_acad;
	//$this->data['applicant'] = $applicant;
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">


	</head>
	<page backtop="7mm" backbottom="7mm" footer="page">

		<body>
			<page_header>

				<div id="bg">
					<img class="bg" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">
				</div>
				<div class="mainstudentsessionreport">
					<div class="studentsession-headers">
						<div class="studentsession-logo">
							<img src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" height="75" width="80" alt="">
							<h2 style="text-transform: uppercase;"> <?= get_settings('system_name'); ?></h2>

							<h3 style="text-transform: uppercase;"> <?= "ACKNOWLEDGEMENT FORM (" . current_adm_session_name() . ") SESSION"; ?></h3>

						</div>

						<!-- <div class="school-name">
						<h2>SEMESTER REGISTRATION FORM</h2>
					</div> -->
					</div>
			</page_header>
			<div class="studentsession-contents studentsessionreporttable">
				<table width="928">
					<tbody>
						<tr>

							<th id="semester" colspan="6" style="font-size: 14px; text-transform: uppercase;">APPLICATION NUMBER: <?php echo $applicant['application_no']; ?></th>


						</tr>
						<tr>
							<th colspan="4">PERSIONAL BIODATA</th>
							<td width="180" rowspan="6" valign="top">
								<p><img src="<?php echo base_url() . $applicant['image']; ?>" width="150" height="150" align="top" /></p>
								<p><br />
								</p>
							</td>
						</tr>
						<!--<tr><th width="166">Matric Number</th><td><b>17/03CS063</b></td>
        <td>Phone Number</td>
        <td><span class=""><strong>08066880055</strong></span></td>
        </tr> -->
						<tr>
							<th>Surname</th>
							<td colspan="3"><span class="name"><b><?php echo $applicant['lastname']; ?></b></span></td>
						</tr>
						<tr>
							<th width="120">First Name</th>
							<td><span class="name"><b><?php echo $applicant['firstname']; ?> </b></span></td>
							<td width="120" valign="top"> Middle Name</td>
							<td width="140" valign="top"><strong><span class="name"><?php echo $applicant['middlename']; ?></span></strong></td>
						</tr>

						<tr>
							<th>Sex</th>
							<td><span class=""><b><?php echo $applicant['gender']; ?> </b></span></td>
							<td width="120" valign="top">Date of Birth</td>
							<td width="140" valign="top"><span class=""><b><?php echo $applicant['dob']; ?> </b></span></td>
						</tr>


						<tr>
							<th>Email Address </th>
							<td><span class="style27"><?php echo $applicant['email']; ?></a></span></td>
							<td width="120" valign="top">Phone Number </td>
							<td width="140" valign="top"><span class="style27"><?php echo $applicant['phone']; ?></span></td>

						</tr>

						<tr>
							<th>Current Address </th>
							<td colspan="3"><span class="style27"><?php echo $applicant['current_address']; ?></span></td>
							<!-- 	<td width="111" valign="top">Disability</td>
							<td width="166" valign="top"><span class=""><b><?php echo $applicant['disability_descr']; ?> </b></span></td>
 -->
						</tr>
						<tr>
							<th>State </th>
							<td><span class="style27"><?php echo $applicant['state']; ?> </span></td>
							<td valign="top">Local Government </td>
							<td colspan="2" valign="top"><span class="style27"><?php echo $applicant['local_government']; ?> </span></td>
						</tr>
						<!-- <tr>
							<th>Nationality </th>
							<td colspan="2" valign="top"><span class="style27">Nigerian</span></td>
						</tr> -->
					</tbody>
				</table>
				<br>
				<center>
					<table width="928">
						<tbody>
							<tr>
								<th colspan="2">
									<center>PROGRAMMES OF CHOICE</center>
								</th>
							</tr>
							<tr>


							<tr>

								<th width="50">S/No</th>
								<th>Programme name </th>
							</tr>
							<?php $count = 1;
							foreach ($choice as $value) { ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $value->course; ?></td>
								</tr>
							<?php } ?>


							</tr>
						</tbody>
					</table>
				</center>
				<br>
				<table width="928">
					<tbody>
						<tr>
							<th colspan="2">
								<center>ACADEMICS DETAILS</center>
							</th>
						</tr>
						<tr>

						<tr>

							<th width="50">S/No</th>
							<th width="300">Institution</th>
							<th width="120">Certificate Obtained</th>
							<th width="100">Year of Graduation</th>
						</tr>
						<tr>
							<td>1. </td>
							<td><?php echo $applicant['primary_school']; ?></td>
							<td><?php echo 'Primary Certificate'; ?></td>
							<td><?php echo $applicant['primary_school_year']; ?></td>
						</tr>
						<tr>
							<td>2. </td>
							<td><?php echo $applicant['secondary_school']; ?> </td>
							<td><?php echo 'Secondary Certificate'; ?></td>
							<td><?php echo $applicant['secondary_school_year']; ?> </td>
						</tr>


						</tr>
					</tbody>
				</table>
				<br>
				<?php if ($applicant['sitting'] == '1') { ?>
					<div class="col-md-12">
						<table width="920">

							<tbody>
								<tr>
									<th colspan="2">
										<center>O'Level Result</center>
									</th>
								</tr>
								<tr>
									<td colspan="2">
										<center><?php echo $applicant['title'] . " - " . $applicant['exam_no'] . " - (" . $applicant['exam_year'] . ")"; ?></center>
									</td>
								</tr>
								<tr>
									<td>
										<table width="700">
											<tbody>
												<tr>
													<th>S/No</th>
													<th>Subject </th>
													<th>Credit</th>


												</tr>

												<tr>
													<td><?php echo  '1'; ?></td>
													<td><?php echo $applicant['subject']; ?></td>

													<td><?php echo $applicant['grade']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '2'; ?></td>
													<td><?php echo $applicant['subject2']; ?></td>

													<td><?php echo $applicant['grade2']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '3'; ?></td>
													<td><?php echo $applicant['subject3']; ?></td>

													<td><?php echo $applicant['grade3']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '4'; ?></td>
													<td><?php echo $applicant['subject4']; ?></td>

													<td><?php echo $applicant['grade4']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '5'; ?></td>
													<td><?php echo $applicant['subject5']; ?></td>

													<td><?php echo $applicant['grade5']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '6'; ?></td>
													<td><?php echo $applicant['subject6']; ?></td>

													<td><?php echo $applicant['grade6']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '7'; ?></td>
													<td><?php echo $applicant['subject7']; ?></td>

													<td><?php echo $applicant['grade7']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '8'; ?></td>
													<td><?php echo $applicant['subject8']; ?></td>

													<td><?php echo $applicant['grade8']; ?></td>
												</tr>
												<tr>
													<td><?php echo  '9'; ?></td>
													<td><?php echo $applicant['subject9']; ?></td>

													<td><?php echo $applicant['grade9']; ?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } else { ?>
					<center>
						<div>
							<div align="center" class="float-left">
								<table width="500">
									<tbody>
										<tr>
											<th colspan="2">
												<center>O'Level Result</center>
											</th>
										</tr>
										<tr>
											<td colspan="2">
												<center><?php echo $applicant['title'] . " - " . $applicant['exam_no'] . " - (" . $applicant['exam_year'] . ")"; ?></center>
											</td>
										</tr>

										<tr>
											<th>S/No</th>
											<th>Subject </th>
											<th>Credit</th>


										</tr>

										<tr>
											<td><?php echo  '1'; ?></td>
											<td><?php echo $applicant['subject']; ?></td>

											<td><?php echo $applicant['grade']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '2'; ?></td>
											<td><?php echo $applicant['subject2']; ?></td>

											<td><?php echo $applicant['grade2']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '3'; ?></td>
											<td><?php echo $applicant['subject3']; ?></td>

											<td><?php echo $applicant['grade3']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '4'; ?></td>
											<td><?php echo $applicant['subject4']; ?></td>

											<td><?php echo $applicant['grade4']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '5'; ?></td>
											<td><?php echo $applicant['subject5']; ?></td>

											<td><?php echo $applicant['grade5']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '6'; ?></td>
											<td><?php echo $applicant['subject6']; ?></td>

											<td><?php echo $applicant['grade6']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '7'; ?></td>
											<td><?php echo $applicant['subject7']; ?></td>

											<td><?php echo $applicant['grade7']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '8'; ?></td>
											<td><?php echo $applicant['subject8']; ?></td>

											<td><?php echo $applicant['grade8']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '9'; ?></td>
											<td><?php echo $applicant['subject9']; ?></td>

											<td><?php echo $applicant['grade9']; ?></td>
										</tr>

									</tbody>
								</table>
							</div>

							<div align="center" class="float-left">
								<table width="500">
									<tbody>
										<tr>
											<th colspan="2">
												<center>O'Level Result</center>
											</th>
										</tr>
										<tr>
											<td colspan="2">
												<center><?php echo $applicant['title2'] . " -" . $applicant['exam_no2'] . " -(" . $applicant['exam_year2'] . ")"; ?></center>
											</td>
										</tr>

										<tr>
											<th>S/No</th>
											<th>Subject </th>
											<th>Credit</th>


										</tr>

										<tr>
											<td><?php echo  '1'; ?></td>
											<td><?php echo $applicant['subject11']; ?></td>

											<td><?php echo $applicant['grade11']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '2'; ?></td>
											<td><?php echo $applicant['subject22']; ?></td>

											<td><?php echo $applicant['grade22']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '3'; ?></td>
											<td><?php echo $applicant['subject33']; ?></td>

											<td><?php echo $applicant['grade33']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '4'; ?></td>
											<td><?php echo $applicant['subject44']; ?></td>

											<td><?php echo $applicant['grade44']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '5'; ?></td>
											<td><?php echo $applicant['subject55']; ?></td>

											<td><?php echo $applicant['grade55']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '6'; ?></td>
											<td><?php echo $applicant['subject66']; ?></td>

											<td><?php echo $applicant['grade66']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '7'; ?></td>
											<td><?php echo $applicant['subject77']; ?></td>

											<td><?php echo $applicant['grade77']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '8'; ?></td>
											<td><?php echo $applicant['subject88']; ?></td>

											<td><?php echo $applicant['grade88']; ?></td>
										</tr>
										<tr>
											<td><?php echo  '9'; ?></td>
											<td><?php echo $applicant['subject99']; ?></td>

											<td><?php echo $applicant['grade99']; ?></td>
										</tr>


									</tbody>
								</table>
							</div>
						</div>

					</center>

				<?php } ?>

				<div class="note">
					<h5><b>DECLARATION</b></h5>
					<span class="style25">
						I hereby declare that all information given above are correct
						to the best of my belief. The college has the right to withdraw me
						from the programme at any point is discovered that all or any part of the
						information given above is false.
					</span>
				</div>


			</div>
			<!-- 	<div class="diidol">
			Powered By Diidol
		</div> -->
			<div id="pageFooter"></div>
			</div>


		</body>

	</page>
