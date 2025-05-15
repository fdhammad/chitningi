<?php
$this->current_session = current_session();
$total_applicants = $this->db->get_where('applicants', array('token_status' => 'taken'))->num_rows();
$total_prestudents = $this->db->get_where('student_session', array('session_id' => $this->current_session, 'role' => 'pre'))->num_rows();
$new_student = $this->db->get_where('student_session', array('session_id' => $this->current_session, 'role' => 'student', 'class_id' => 1))->num_rows();
$total_students = $this->db->get_where('student_session', array('session_id' => $this->current_session))->num_rows();
?>
<div class="page has-sidebar-left">
	<header class="my-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<h1 class="s-24">
						<i class="icon-home"></i>
						Dashboard <span class="s-14">Welcome Back</span>
					</h1>
				</div>
			</div>
		</div>
	</header>
	<?php
	if ($this->session->userdata('user_id') == 0 || $this->session->userdata('user_id') == 1) :

	?>
		<div class="container-fluid my-3">
			<div class="row my-3">
				<div class="col-md-3">
					<div class="counter-box white r-5 p-3">
						<div class="p-4">
							<div class="float-right">
								<span class="icon icon-school text-purple s-48"></span>
							</div>
							<div class="counter-title">Applicants</div>
							<h5 class="sc-counter mt-3"><?php echo $total_applicants; ?></h5>
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<div class="counter-box white r-5 p-3">
						<div class="p-4">
							<div class="float-right">
								<span class="icon icon-user text-green s-48"></span>
							</div>
							<div class="counter-title ">PRE-Wedding Students</div>
							<h5 class="sc-counter mt-3"><?php echo $total_prestudents; ?></h5>
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<div class="counter-box white r-5 p-3">
						<div class="p-4">
							<div class="float-right">
								<span class="icon icon-person_add s-48"></span>
							</div>
							<div class="counter-title">New Students</div>
							<h5 class="sc-counter mt-3"><?php echo $new_student; ?></h5>
						</div>

					</div>
				</div>

				<div class="col-md-3">
					<div class="counter-box white r-5 p-3">
						<div class="p-4">
							<div class="float-right">
								<span class="icon icon-users text-light-blue s-48"></span>
							</div>
							<div class="counter-title">Students</div>
							<h5 class="sc-counter mt-3"><?php echo $total_students; ?></h5>
						</div>

					</div>
				</div>

			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-lg-4 col-md-4">
					<div class="card r-3">
						<div class="p-4">
							<div class="float-right">
								<span class="icon-user-o text-light-blue s-48"></span>
							</div>
							<div class="counter-title">100L Students</div>
							<h5 class="sc-counter mt-3"><?= $level1; ?></h5>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="card r-3">
						<div class="p-4">
							<div class="float-right"><span class="icon-user-o text-green s-48"></span>
							</div>
							<div class="counter-title ">200L Students</div>
							<h5 class="sc-counter mt-3"><?= $level2; ?></h5>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="white card">
						<div class="p-4">
							<div class="float-right"><span class="icon-user-o text-red s-48"></span>
							</div>
							<div class="counter-title">300L Students</div>
							<h5 class="sc-counter mt-3"><?= $level3; ?></h5>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 mt-3">
					<div class="card r-3">
						<div class="p-4">
							<div class="float-right">
								<span class="icon-users text-green s-48"></span>
							</div>
							<div class="counter-title">Registered Students</div>
							<h5 class="sc-counter mt-3"><?= $registered ; ?></h5>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 mt-3">
					<div class="card r-3">
						<div class="p-4">
							<div class="float-right">
								<span class="icon-users text-red s-48"></span>
							</div>
							<div class="counter-title">Unregistered Students</div>
							<h5 class="sc-counter mt-3"><?= $unregistered; ?></h5>
						</div>
					</div>
				</div>
				<!-- <div class="col-lg-4 col-md-4 mt-3">
				<div class="card r-3">
					<div class="p-4">
						<div class="float-right"><span class="icon-user-o text-yellow s-48"></span>
						</div>
						<div class="counter-title ">SPILL Registered Students</div>
						<h5 class="sc-counter mt-3"><?= $RegisteredSPILL; ?></h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 mt-3">
				<div class="white card">
					<div class="p-4">
						<div class="float-right"><span class="icon-user-o text-grey s-48"></span>
						</div>
						<div class="counter-title">Defered Registered Students</div>
						<h5 class="sc-counter mt-3"><?= $RegisteredDEFER; ?></h5>
					</div>
				</div>
			</div> -->
			</div>
		</div>
	<?php endif ?>
	<div class="container-fluid animatedParent animateOnce my-3">

		<div class="d-flex row row-eq-height my-3">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header white">
						<h4>Students Statistics</h4>
					</div>
					<div class="card-body">
						<div class="row mx-auto">

							<div class="col-md-6">
								<div class="card">
									<div class="card-header white">
										<h6>Distribution By Departments</h6>
									</div>
									<div class="card-body">
										<div id="donutchart" style="width: 450px; height: 300px;"></div>

									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-header white">
										<h6>Distribution By Level</h6>
									</div>
									<div class="card-body">
										<div id="piechart" style="width: 450px; height: 300px;"></div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card mt-3">
									<div class="card-header white">
										<h6>Distribution By Gender</h6>
									</div>
									<div class="card-body">
										<div id="genderchart" style="width: 450px; height: 300px;"></div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card mt-3">
									<div class="card-header white">
										<h6>Distribution By Indigene</h6>
									</div>
									<div class="card-body">
										<div id="indigenechart" style="width: 450px; height: 300px;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>