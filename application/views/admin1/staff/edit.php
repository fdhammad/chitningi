<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-user"></i>
						Staff Directory
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link" href="<?php echo base_url('admin/staff') ?>" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>All Staff</a>
					</li>
					<li>
						<a class="nav-link active" href="<?php echo base_url('admin/staff/create') ?>" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-user-plus"></i>Add New Staff</a>
					</li>
				</ul>
			</div>
		</div>
	</header>
	<?php if ($this->session->flashdata('toast')) { ?>
		<?php echo $this->session->flashdata('toast') ?>
	<?php } ?>

	<div class="container-fluid my-3">
		<div id="alert"></div>
		<form id="staff_edit" class="needs-validation" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
			<?php echo $this->customlib->getCSRF(); ?>
			<input type="hidden" id="id" name="id" value="<?php echo $staff['id']; ?>">

			<div class="row">
				<div class="col-md-4">
					<div class="card card-profile card-secondary">
						<div class="card-header">
							<table class="table cell-vertical-align-middle table-condensed mb-1">
								<tbody>
									<tr class="no-b">
										<td>

											<a href="#Modal" class="btn btn-success btn-xs" data-toggle="tooltip" title="<?php echo 'Change Password' ?>">Change Password</a>
											<?php if ($staff['is_active'] == 1) { ?>
												<form method="post">
													<!--<a href="<?php echo base_url(); ?>admin/student/print_card" id="btn_save" class="btn btn-xs btn-primary"><i class="icon icon-print"></i>Print Exams Card</a> -->
													<input type="hidden" id="st_id" name="st_id" value="<?php echo $staff['id']; ?>">

													<button class="btn btn-xs btn-danger float-right disable" type="button" title="Suspend Staff"><i class="icon icon-print"></i>Disable Staff</button>
												</form>
											<?php } else { ?>
												<form method="post">
													<!--<a href="<?php echo base_url(); ?>admin/student/print_card" id="btn_save" class="btn btn-xs btn-primary"><i class="icon icon-print"></i>Print Exams Card</a> -->
													<input type="hidden" id="st_id" name="st_id" value="<?php echo $staff['id']; ?>">

													<button class="btn btn-xs btn-success float-right enable" type="button" title="Enable Staff"><i class="icon icon-print"></i>Enable Staff</button>
												</form>
											<?php } ?>
										</td>

									</tr>
								</tbody>
							</table>
						</div>
						<div class="card">
							<?php
							if (!empty($staff["image"])) {
								$image = $staff["image"];
							} else {
								$image = "uploads/staff_image/no_image.png";
							}
							?>
							<div class="card-header">
								<div>
									<input id="image" type="file" class="dropify" name="file" data-plugins="dropify" data-default-file="<?php echo base_url() . $image; ?>" data-max-file-size="1M" />
									<p class="text-muted text-center mt-2 mb-0">Upload Passport</p>
									<span class="text-danger"><?php echo form_error('file'); ?></span>
								</div>

							</div>
							<div class="card-body">
								<div class="user-profile text-center">
									<div class="name"> <a href="<?php echo base_url(); ?>admin/staff/profile/<?php echo $staff['id']; ?>"><?php echo $staff['firstname'] . " " . $staff['lastname']; ?>
										</a></div>
									<!-- 	<div class="job text-capitalize"><b><?php echo $staff['user_type']; ?></b></div>
 -->
								</div>
							</div>
							<div class="card-footer">
								<div class="row user-stats text-center">
									<div class="col">
										<div class="number"><b><?php echo $staff['employee_id']; ?></b></div>
										<div class="title">ID</div>
									</div>
									<div class="col">
										<div class="number"><b><?php echo $staff['contact_no']; ?></b></div>
										<div class="title">Contact No</div>
									</div>
								</div>

							</div>

						</div>

					</div>
				</div>
				<div class="col-md-8">
					<div class="card">
						<h5 class="card-header">EDIT PROFILE</h5>
						<div class="card-body">
							<?php if ($this->session->flashdata('msg')) { ?>
								<?php echo $this->session->flashdata('msg') ?>
							<?php } ?>
							<?php echo $this->customlib->getCSRF();
							//$staff_id = $this->customlib->getStaffID(); 
							?>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Staff ID</label>
										<input type="text" class="form-control" name="employee_id" placeholder="Name" value="<?php echo $staff["employee_id"] ?>">
										<span class="text-danger"><?php echo form_error('employee_id'); ?></span>
									</div>
								</div>
							</div>



							<div class="row mt-3">
								<div id="test" class="col-md-6">
									<div class="form-group form-group-default">
										<label for="school_id">SCHOOL</label>
										<select id="school_id" name="school_id" class="form-control">
											<option value="">Choose...</option>
											<?php
											foreach ($schoollist as $school) {
											?>
												<option value="<?php echo $school['id'] ?>" <?php if ($staff['school_id'] == $school['id']) echo "selected=selected" ?>><?php echo $school['school'] ?></option>
											<?php

											}
											?>
										</select>
										<span class="text-danger"><?php echo form_error('school_id'); ?></span>
									</div>
								</div>
								<div id="department" class="col-md-6">
									<div class="form-group form-group-default">
										<label for="department_id">DEPARTMENTS</label>
										<select id="department_id" name="department_id" class="form-control">
											<option value="">Choose...</option>

										</select>
										<span class="text-danger"><?php echo form_error('department_id'); ?></span>
									</div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Name</label>
										<input type="text" class="form-control" name="firstname" placeholder="Name" value="<?php echo $staff["firstname"] ?>">
										<span class="text-danger"><?php echo form_error('firstname'); ?></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Surname</label>
										<input type="text" class="form-control" name="lastname" placeholder="lastname" value="<?php echo $staff["lastname"] ?>">
										<span class="text-danger"><?php echo form_error('lastname'); ?></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Email</label>
										<input type="email" class="form-control" name="email" placeholder="Name" value="<?php echo $staff["email"] ?>">
										<span class="text-danger"><?php echo form_error('email'); ?></span>
									</div>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-md-4">
									<div class="form-group form-group-default">
										<label>Marital Status</label>
										<select class="form-control" name="marital_status">
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php foreach ($maritalStatus as $makey => $mavalue) {
											?>
												<option <?php
														if ($staff["marital_status"] == $mavalue) {
															echo "selected";
														}
														?> value="<?php echo $mavalue; ?>"><?php echo $mavalue; ?></option>
											<?php } ?>

										</select>
										<span class="text-danger"><?php echo form_error('marital_status'); ?></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-default">
										<label>Gender</label>
										<select class="form-control" name="gender">
											<option value=""><?php echo get_phrase('select'); ?></option>
											<?php
											foreach ($genderList as $key => $value) {
											?>
												<option value="<?php echo $key; ?>" <?php if ($staff['gender'] == $key) echo "selected"; ?>><?php echo $value; ?></option>
											<?php
											}
											?>
										</select>
										<span class="text-danger"><?php echo form_error('gender'); ?></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-default">
										<label>Phone</label>
										<input type="text" class="form-control" value="<?php echo $staff["contact_no"] ?>" name="contact_no" placeholder="Phone">
									</div>
								</div>
							</div>
							<div class="row mt-3">

								<div class="col-md-4">
									<div class="form-group form-group-default">
										<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select State</label>
										<select class="custom-select my-1 form-control r-0 light s-12" id="state_id" name="state_id">
											<option value="">Choose...</option>
											<?php
											foreach ($statelist as $state) {
											?>
												<option value="<?php echo $state['id'] ?>" <?php
																							if ($staff['state_id'] == $state['id']) {
																								echo "selected =selected";
																							}
																							?>><?php echo $state['name'] ?></option>
											<?php

											}
											?>
										</select>
										<span class="text-danger"><?php echo form_error('state_id'); ?></span>
									</div>
								</div>
								<div class="col-md-4">
									<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select LGA</label>
									<select class="custom-select my-1  form-control r-0 light s-12" id="local_government_id" name="local_government_id">
										<option selected>Choose...</option>

									</select>
									<span class="text-danger"><?php echo form_error('local_government_id'); ?></span>
								</div>


							</div>
							<div class="row mt-3">
								<div class="col-md-12">
									<div class="form-group form-group-default">
										<label>Address</label>
										<input type="text" class="form-control" value="<?php echo $staff["permanent_address"] ?>" name="permanent_address" placeholder="Address">
										<span class="text-danger"><?php echo form_error('permanent_address'); ?></span>
									</div>
								</div>
							</div>
							<div class="row mt-3 mb-1">
								<div class="col-md-12">
									<div class="form-group form-group-default">
										<label>About Me</label>
										<textarea class="form-control" name="note" placeholder="About Me" rows="3"><?php echo $staff["note"] ?></textarea>
										<span class="text-danger"><?php echo form_error('note'); ?></span>
									</div>
								</div>
							</div>
							<hr>
							<div class="text-right mt-3 mb-3">
								<button id="staff_edit_button" type="submit" class="btn btn-success">Save</button>
								<button type="button" class="btn btn-outline-danger" onclick="history.go(-1);"><i class="icon icon-arrow_back"></i> Go Back </button>

							</div>
						</div>
					</div>

				</div>
			</div>

		</form>
	</div>

</div>
<!-- The Modal -->
<div class="modal fade " id="Modal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><b>Change Password</b></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form action="<?php echo site_url('admin/staff/modalchangepass/' . $staff['id']); ?>" id="form-validation" name="passwordform" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
					<div class="modal-body">

						<?php if ($this->session->flashdata('msg')) { ?>
							<?php echo $this->session->flashdata('msg') ?>
						<?php } ?>
						<?php
						if (isset($error_message)) {
							echo $error_message;
						}
						?>
						<?php echo $this->customlib->getCSRF(); ?>

						<div class="form-group <?php
												if (form_error('new_pass')) {
													echo 'has-error';
												}
												?>">
							<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"><?php echo get_phrase('new_password'); ?>
							</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input class="form-control col-md-12 col-xs-12" id="new_pass" name="new_pass" placeholder="" type="password" value="<?php echo set_value('new_password'); ?>" required>
								<span class="text-danger"><?php echo form_error('new_pass'); ?></span>
							</div>
						</div>
						<div class="form-group <?php
												if (form_error('confirm_pass')) {
													echo 'has-error';
												}
												?>">
							<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"><?php echo get_phrase('confirm_password'); ?>
							</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input id="confirm_pass" name="confirm_pass" placeholder="" type="password" value="<?php echo set_value('confirm_password'); ?>" class="form-control col-md-12 col-xs-12" required>
								<span class="text-danger"><?php echo form_error('confirm_pass'); ?></span>
							</div>
						</div>
					</div> <!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div><!-- jQuery  -->

<!-- <script>
	$(document).ready(function() {
		$('#test').hide();
		$('#department').hide();
		var selected_option = $('#role').val();
		$("#role").change(function() {

			if (selected_option === '2') {
				$('#test').show();
				$('#department').hide();
			} else if (selected_option === '9') {
				$('#test').hide();
				$('#department').show();
			} else {
				$('#test').hide();
				$('#department').hide();
			}
		})
	});
</script> -->
<script type="text/javascript">
	$(document).ready(function() {
		//$("#loader").show();
		if ($.trim($('#role').val()) == '2') {
			$('#test').show("slow");
			$('#department').hide("slow");
		} else if ($.trim($('#role').val()) == '9') {
			$('#test').show("slow");
			$('#department').show("slow");
		} else {
			$('#test').hide();
			$('#department').hide("slow");
		}

		var class_id = $('#role').val();
		$(document).on('change', '#role', function(e) {
			if ($.trim($('#role').val()) == '2') {
				$('#test').show("slow");
				$('#department').hide("slow");
			} else if ($.trim($('#role').val()) == '9') {
				$('#test').show("slow");
				$('#department').show("slow");
			} else {
				$('#test').hide("slow");
				$('#department').hide("slow");
			}

		})
	})
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$('a[href$="#Modal"]').on("click", function() {
			$('#Modal').modal('show');
		});
	});

	var form = document.getElementById("form-validation");
	form.addEventListener("submit", function(event) {
		if (document.getElementById("new_pass").value != document.getElementById("confirm_pass").value) {
			alert("Password mismatch");
			event.preventDefault();
			event.stopPropagation();
		} else if (form.checkValidity() == false) {
			event.preventDefault();
			event.stopPropagation();
		}
		form.classList.add("was-validated");
	}, false);
</script>

<script type="text/javascript">
	$(document).ready(function() {
		function ConfirmDisable() {
			var x = confirm("Are you sure you want to Disable this Staff?");
			if (x)
				return true;
			else
				return false;
		}
		$(document).on('click', '.disable', function(e) {
			e.preventDefault();
			if (ConfirmDisable() == false) {
				return false;
			}

			var st_id = $('#st_id').val();

			$.ajax({
				url: '<?php echo site_url("admin/staff/disable") ?>',
				type: "POST",
				dataType: "JSON",
				data: {
					//'data': JSON,
					'st_id': st_id,

				},
				success: function() {
					alert("Success! Staff Suspended Successfully")

				},
				error: function() {
					alert('Error! Please try Again');
				}

			});
			window.location.reload();


		});
	})
</script>
<script type="text/javascript">
	$(document).ready(function() {
		function ConfirmEnable() {
			var x = confirm("Are you sure you want to Enable this Staff?");
			if (x)
				return true;
			else
				return false;
		}
		$(document).on('click', '.enable', function(e) {
			e.preventDefault();
			if (ConfirmEnable() == false) {
				return false;
			}

			var st_id = $('#st_id').val();

			$.ajax({
				url: '<?php echo site_url("admin/staff/enable") ?>',
				type: "POST",
				dataType: "JSON",
				data: {
					//'data': JSON,
					'st_id': st_id,

				},
				success: function() {
					alert("Success! Staff Enabled Successfully")

				},
				error: function() {
					alert('Error! Please try Again');
				}

			});
			window.location.reload();

		})
	})
</script>
</body>

</html>
