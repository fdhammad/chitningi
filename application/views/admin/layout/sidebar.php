<?php
$admin_details = $this->staff_model->get_admin($this->session->userdata('user_id'))->row_array();
$name = $admin_details['firstname'] . ' ' . $admin_details['lastname'];
$id = $admin_details['id'];
$role = $this->session->userdata('role');
?>
<aside class="main-sidebar fixed offcanvas shadow" data-toggle='offcanvas'>
	<section class="sidebar">
		<div class="w-120px mt-3 mb-3 ml-3">
			<a href="<?php echo base_url(); ?>admin/dashboard">
				<img src="<?php echo base_url(); ?>assets/img/logo/ningi.png" height="40" alt="">
			</a>
		</div>
		<div class="relative">
			<a data-toggle="collapse" href="#userSettingsCollapse" role="button" aria-expanded="false" aria-controls="userSettingsCollapse" class="btn-fab btn-fab-sm absolute fab-right-bottom fab-top btn-primary shadow1 ">
				<i class="icon icon-cogs"></i>
			</a>
			<div class="user-panel p-3 light mb-2">
				<div>
					<div class="float-left image">
						<img class="user_avatar" src="<?php echo $this->staff_model->get_admin_image_url($this->session->userdata('user_id')); ?>" alt="User Image">
					</div>
					<div class="float-left info">
						<h6 class="font-weight-light mt-2 mb-1"><?php echo $name; ?></h6>

						<a href="#"><i class="icon-circle text-primary blink"></i> <?php echo $role; ?></a>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="collapse multi-collapse" id="userSettingsCollapse">
					<div class="list-group mt-3 shadow">

						<a href="<?php echo base_url() . "admin/staff/edit/" . $id ?>" class="list-group-item list-group-item-action ">
							<i class="mr-2 icon-umbrella text-blue"></i>Profile
						</a>

						<a href="<?php echo base_url() . "admin/staff/changepass/" . $id ?>" class="list-group-item list-group-item-action"><i class="mr-2 icon-security text-purple"></i>Change Password</a>
						<a href="<?php echo base_url(); ?>staff/logout" class="list-group-item list-group-item-action"><i class="mr-2 icon-cogs text-yellow"></i>Logout</a>
					</div>
				</div>
			</div>
		</div>
		<ul class="sidebar-menu">
			<li class="header"><strong>MAIN NAVIGATION</strong></li>
			<li class="treeview <?php if ($page_name == 'dashboard')
									echo 'active';
								?>"><a href="<?php echo base_url(); ?>admin/dashboard">
					<i class=" icon icon-home2 orange-text s-18"></i> <span>Dashboard</span>
				</a>
			</li>
			<?php if (has_permission('applicants')) : ?>
				<li class="treeview <?php if ($page_name == 'applicants/search')
										echo 'active';
									?>">
					<a href=" #">
						<i class="icon icon-account_box purple-text s-18"></i> <span>Applicants</span> <span class="pull-right"><i class="icon icon-angle-left s-18 pull-right"></i></span></a>
					<ul class="treeview-menu">

						<li class="<?php if ($page_name == 'applicants/search') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'applicants/search') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/applicants"><i class="icon icon-circle-o"></i>Search Applicants</a>
						</li>


					</ul>
				</li>
			<?php endif; ?>
			<?php if (has_permission('students')) : ?>
				<li class="treeview <?php if ($page_name == 'students/create' || $page_name == 'students/list' || $page_name == 'students/search' || $page_name == 'students/reg_student_search' || $page_name == 'students/adm_student_search') : ?> active <?php endif; ?> ">
					<a href="#">
						<i class="icon icon-account_box light-blue-text s-18"></i> <span>Students</span> <span class="pull-right"><i class="icon icon-angle-left s-18 pull-right"></i></span></a>
					<ul class="treeview-menu">

						<li class="<?php if ($page_name == 'students/search') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'students/search') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/students/search"><i class="icon icon-circle-o"></i>Search Students</a>
						</li>
						<li class="<?php if ($page_name == 'students/adm_student_search') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'students/adm_student_search') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/students/adm_students"><i class="icon icon-circle-o"></i>Students Admission</a>
						</li>
						<li class="<?php if ($page_name == 'students/reg_student_search') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'students/reg_student_search') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/students/reg_students"><i class="icon icon-circle-o"></i>Registered Students</a>
						</li>

						<li class="<?php if ($page_name == 'students/create') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'students/create') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/students/create"><i class="icon icon-add"></i>Add Student</a>
						</li>

						<li class="<?php if ($page_name == 'schools') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/students/idcard"><i class="icon icon-circle-o"></i>Student ID Cards</a>
						</li>

						<li class="<?php if ($page_name == 'schools') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/stdpromote"><i class="icon icon-circle-o"></i>Promote Students</a>
						</li>

						<li class="<?php if ($page_name == 'schools') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/students/spillover"><i class="icon icon-circle-o"></i>Spillover Students</a>
						</li>

					</ul>
				</li>
			<?php endif; ?>
			<?php if (has_permission('staff')) : ?>
				<li class="treeview <?php if ($page_name == 'admin/staff') echo 'active'; ?>">
					<a href="#">
						<i class="icon icon-person light-green-text s-18"></i> <span>Staff Directory</span> <span class="pull-right"><i class="icon icon-angle-left s-18 pull-right"></i></span></a>
					<ul class="treeview-menu">

						<li class="<?php if ($page_name == 'admin/staff') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/staff"><i class="icon icon-circle-o"></i>Staff List</a>
						</li>
						<li class="<?php if ($page_name == 'admin/staff') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/staff/disablestafflist"><i class="icon icon-circle-o"></i>Suspended Staff</a>
						</li>

					</ul>
				</li>
			<?php endif; ?>
			<?php if (has_permission('payments')) : ?>
				<li class="header light mt-3"><strong>PAYMENT NAVIGATION</strong></li>
				<li class="treeview" <?php if ($page_name == 'payments/application_trans') echo 'active'; ?>><a class="<?php if ($page_name == 'payments/application_trans') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/payments/application_trans">
						<i class=" icon icon-money-1 blue-text s-18"></i> <span>Application Trans History</span>
					</a>
				</li>
				<li class="treeview <?php if ($page_name == 'payments/report') echo 'active'; ?>">
					<a href="#">
						<i class="icon icon-money light-green-text s-18"></i> <span>Payment Reports</span> <span class="pull-right"><i class="icon icon-angle-left s-18 pull-right"></i></span></a>
					<ul class="treeview-menu">

						<li class="<?php if ($page_name == 'payments/search') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/payments/search"><i class="icon icon-circle-o"></i>Search & Verify RRR</a>
						</li>
						<li class="<?php if ($page_name == 'payments/semester_trans') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/payments/semester_trans"><i class="icon icon-circle-o"></i>Transaction History</a>
						</li>
						<li class="<?php if ($page_name == 'payments/reports') echo 'active'; ?>">
							<a href="<?php echo base_url(); ?>admin/payments/reports"><i class="icon icon-circle-o"></i>Reports</a>
						</li>

					</ul>
				</li>


			<?php endif; ?>
			<?php if (has_permission('exams')) : ?>

				<li class="header light mt-3"><strong>EXAMS NAVIGATION</strong></li>
				<!-- 	<li class="treeview" <?php if ($page_name == 'payments/application_trans') echo 'active'; ?>><a class="<?php if ($page_name == 'payments/application_trans') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/payments/application_trans">
						<i class=" icon icon-book-1 blue-text s-18"></i> <span>Application Trans History</span>
					</a>
				</li> -->
				<li class="treeview <?php if ($page_name == 'exams/index' || $page_name == 'exams/bulk' || $page_name == 'exams/course_result' || $page_name == 'exams/program_results') echo 'active'; ?>">
					<a href="#">
						<i class="icon icon-book red-text s-18"></i> <span>Exams</span> <span class="pull-right"><i class="icon icon-angle-left s-18 pull-right"></i></span></a>
					<ul class="treeview-menu">

						<li class="<?php if ($page_name == 'exams/index') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'exams/index') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/exams/index"><i class="icon icon-circle-o"></i>Add Marks</a>
						</li>
						<li class="<?php if ($page_name == 'exams/bulk') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'exams/bulk') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/exams/bulk"><i class="icon icon-circle-o"></i>Bulk Upload Marks</a>
						</li>
						<li class="<?php if ($page_name == 'exams/course_result') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'exams/course_result') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/exams/course_result"><i class="icon icon-circle-o"></i>Course Results</a>
						</li>
						<li class="<?php if ($page_name == 'exams/program_results') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'exams/program_results') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/exams/program_results"><i class="icon icon-circle-o"></i>Semester Results</a>
						</li>

					</ul>
				</li>

			<?php endif; ?>
			<?php if (has_permission('academics')) : ?>
				<li class="header light mt-3"><strong>ACADEMICS NAVIGATION</strong></li>
				<li class="treeview <?php if ($page_name == 'schools' || $page_name == 'borrow' || $page_name == 'departments' || $page_name == 'classes' || $page_name == 'courses' || $page_name == 'subjects') : ?> active <?php endif; ?>">
					<a href="#">
						<i class="icon icon-graduation blue-text s-18"></i> <span>Academics</span> <span class="pull-right"><i class="icon icon-angle-left s-18 pull-right"></i></span></a>
					<ul class="treeview-menu">

						<li class="<?php if ($page_name == 'schools') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'schools') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/schools"><i class="icon icon-circle-o"></i>Schools</a>
						</li>

						<li class="<?php if ($page_name == 'departments') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'departments') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/departments"><i class="icon icon-circle-o"></i>Departments</a>
						</li>

						<li class="<?php if ($page_name == 'classes') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'classes') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/classes"><i class="icon icon-circle-o"></i>Levels</a>
						</li>

						<li class="<?php if ($page_name == 'courses') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'courses') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/courses"><i class="icon icon-circle-o"></i>Programmes</a>
						</li>

						<li class="<?php if ($page_name == 'sug') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'sug') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/sug"><i class="icon icon-circle-o"></i>Assign Lecturer</a>
						</li>

						<li class="<?php if ($page_name == 'borrow') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'borrow') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/borrow_courses"><i class="icon icon-circle-o"></i>Registrable Courses</a>
						</li>
						<li class="<?php if ($page_name == 'subjects') echo 'active'; ?>">
							<a class="<?php if ($page_name == 'subjects') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/subjects"><i class="icon icon-circle-o"></i>Courses</a>
						</li>

					</ul>
				</li>
			<?php endif; ?>
			<?php if (has_permission('settings')) :

				if ($this->session->userdata('user_id') == 0 || $this->session->userdata('user_id') == 1) :

			?>

					<li class="header light mt-3"><strong>GENERAL NAVIGATION</strong></li>

					<li class="treeview <?php if ($page_name == 'settings' || $page_name == 'sessions' || $page_name == 'semesters' || $page_name == 'tokens') : ?> active <?php endif; ?>">
						<a href="javascript: void(0);">
							<i class="icon icon-cogs red-text s-18"></i> <span>General Settings</span> <span class="pull-right"><i class="icon icon-angle-left s-18 pull-right"></i></span></a>
						<ul class="treeview-menu ">


							<li class="<?php if ($page_name == 'settings') echo 'active'; ?>">
								<a class="<?php if ($page_name == 'settings') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/settings"><i class="icon icon-circle-o"></i>Settings</a>
							</li>
							<li class="treeview" <?php if ($page_name == 'payments/manage_amount') echo 'active'; ?>><a href="<?php echo base_url(); ?>admin/payments/manage_amounts">
									<i class=" icon icon-money-1 orange-text s-18"></i> <span>Manage Amounts</span>
								</a>
							</li>
							<li class="<?php if ($page_name == 'tokens') echo 'active'; ?>">
								<a class="<?php if ($page_name == 'tokens') echo 'text-danger'; ?>" href="<?php echo base_url(); ?>admin/tokens"><i class="icon icon-circle-o"></i>Generate Application Tokens</a>
							</li>
							<li class="">
								<a class="" href="<?php echo base_url(); ?>admin/switches"><i class="icon icon-circle-o"></i>Switches</a>
							</li>

							<!-- if ($staff_id == 0) { -->

							<li class="">
								<a href="<?php echo base_url(); ?>admin/backup"><i class="icon icon-circle-o"></i>Backup</a>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>admin/roles"><i class="icon icon-circle-o"></i>Roles</a>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>admin/emailconfig"><i class="icon icon-circle-o"></i>Email Config</a>
							</li>
							<li class="<?php if ($page_name == 'sessions') echo 'active'; ?>">
								<a class="<?php if ($page_name == 'sessions') echo 'text-primary'; ?>" href="<?php echo base_url(); ?>admin/sessions"><i class="icon icon-circle-o"></i>Sessions</a>
							</li>

							<li class="<?php if ($page_name == 'semesters') echo 'active'; ?>">
								<a class="<?php if ($page_name == 'semesters') echo 'text-primary'; ?>" href="<?php echo base_url(); ?>admin/semesters"><i class="icon icon-circle-o"></i>Semesters</a>
							</li>

						</ul>
					</li>

					<li class="treeview"><a href="<?php echo base_url(); ?>admin/userlog">
							<i class=" icon icon-list purple-text s-18"></i> <span>Userlog</span>
						</a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>

	</section>
</aside>