<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
</head>
<page backtop="7mm" backbottom="7mm" footer="page">
	<?php $system_name = $this->db->get_where('settings', array('key' => 'system_name'))->row()->value; ?>
	<?php $system_address = $this->db->get_where('settings', array('key' => 'address'))->row()->value; ?>

	<body>
		<page_header>

			<div id="bg">
				<img class="bg" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">
			</div>
			<div class=" mainstudentsessionreport">
				<div class="studentsession-headers">
					<div class="studentsession-logo">
						<img src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="" width="85" height="85">
					</div>

					<div class="school-name">
						<h2 style="text-transform: uppercase;">BAUCHI STATE OF NIGERIA </h2>

						<h2 style="text-transform: uppercase;"><?= $system_name; ?> </h2>
						<h2 style="text-transform: uppercase;"><?= $system_address; ?> </h2>
						<h2 style="color: red;"> SEMESTER REGISTRATION FORM</h2>

					</div>

				</div>
		</page_header>
		<div class="studentsession-contents studentsessionreporttable">
			<table width="928">
				<tbody>
					<tr>
						<th id="semester" colspan="5" style="font-size: 16px; text-transform: uppercase;">SEMESTER: <?php echo $semester['semester']; ?></th>

						<td id="session" colspan="2" style="font-size: 16px; text-transform: uppercase;"><strong> SESSION: <?php echo $session['session']; ?></strong></td>
					</tr>
					<tr>
						<th colspan="5" style="text-align: center; font-size: 16px">STUDENT DETAILS</th>
						<td width="226" rowspan="6" align="center">
							<p style="align-content: center;"><img src="<?php echo base_url() . $student['image']; ?>" width="140" height="150" align="center" /></p>
						</td>
					</tr>
					<tr>
						<th width="150">Reg Number</th>
						<td><span class="collno" style="text-transform: uppercase;"><strong><?php echo $student['reg_no']; ?></strong></span></td>
						<td colspan="2">Gender</td>
						<td><span class="contents"><strong><?php echo $student['gender']; ?></strong></span></td>
					</tr>
					<tr>
						<th>Full-Name</th>
						<td colspan="4"><span class="name" style="text-transform: uppercase;"><b><?php echo  $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'] ?></b></span></td>
					</tr>

					<tr>
						<th>Department</th>
						<td colspan="4"><span class="contents"><b><?php echo $student['depart']; ?></b></span></td>

					</tr>
					<tr>
						<th>Course</th>
						<td><span class="contents"><b><?php echo $student['course']; ?></b></span></td>
						<td colspan="2" width="111" valign="top">Current Level</td>
						<td width="166" valign="top"><span class="contents"><b><?php echo $student['class']; ?></b></span></td>
					</tr>
					 <tr>
						<th>State of Origin</th>
						<td><strong><?php echo $student['state']; ?>
							</strong></td>
						<td colspan="2" valign="top">L.G.A</td>
						<td valign="top"><strong><?php echo $student['local_g']; ?></strong></td>
					</tr> 
					<tr>
						<th>Phone Number</th>
						<td><strong><?php echo $student['phone']; ?>
							</strong></td>

						<td colspan="2" valign="top">Date Registered</td>
						<td valign="top"><strong><?php echo date('d/m/Y'); ?></strong></td>
					</tr>
				</tbody>
			</table>
			<br>
			<table>
				<tbody>

					<tr>
						<th>S/No</th>
						<th>Course code </th>
						<th>Course Description</th>

						<th>Unit</th>
						<th>Signature </th>
						<th>Remark</th>

					</tr>

					<?php
					$count = 1;
					if (customCompute($registered)) {
						foreach ($registered as $reg) {	?>
							<tr>
								<td style="text-align: center;"><?= $count++ ?></td>
								<td><?= $reg->code ?></td>
								<td><?= $reg->subject ?></td>

								<td style="text-align: center;"><?= $reg->unit ?></td>
								<td width="180"></td>
								<td width="120"></td>
							</tr>

					<?php
						}
					} ?>



					<tr>
						<th colspan="3">
							<div align="right"><strong>Total:</strong> </div>
						</th>
						<td><b><u><?= $total; ?></u></b></td>
						<td></td>
					</tr>

				</tbody>
			</table>
			<!-- 	<table>
				<tbody>
					<tr>
						<th colspan="6">
							<center>Registered Courses</center>
						</th>
					</tr>


					<tr>
						<th>S/No</th>
						<th>Course code </th>
						<th>Course Description</th>

						<th>Unit</th>
						<th>Signature </th>
						<th>Remark</th>

					</tr>

					<?php
					$count = 1;
					if (customCompute($registered)) {
						foreach ($registered as $reg) {	?>
							<tr>
								<td style="text-align: center;"><?= $count++ ?></td>
								<td><?= $reg->code ?></td>
								<td><?= $reg->subject ?></td>

								<td style="text-align: center;"><?= $reg->unit ?></td>
								<td width="180"></td>
								<td width="120"></td>
							</tr>

					<?php
						}
					} ?>



					<tr>
						<th colspan="3">
							<div align="right"><strong>Total:</strong> </div>
						</th>
						<td><b><u><?= $total; ?></u></b></td>
						<td></td>
					</tr>

				</tbody>
			</table> -->
			<br>
			<table width="920">
				<tbody>
					<tr>
						<td id="sign"><br /><br />

							...................................................................................................<br />
							STUDENT'S SIGNATURE AND DATE

						</td>
						<td id="sign"><br /><br />

							....................................................................................................<br />
							HOD'S SIGNATURE AND DATE

						</td>
					</tr>


					<tr>

						<td id="sign"><br /><br />

							...................................................................................................<br />
							REGISTRAR'S SIGNATURE AND DATE

						</td>
						<td id="sign"></td>
					</tr>
				</tbody>
			</table>
			<div class="note">
				<span class="style25">CC.<br>HOD <br>REGISTRAR
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