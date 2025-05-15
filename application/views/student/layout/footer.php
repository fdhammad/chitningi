</div>
<!--end::Content wrapper-->
<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer">
	<!--begin::Footer container-->
	<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
		<!--begin::Copyright-->
		<div class="text-dark order-2 order-md-1">
			<span class="text-muted fw-semibold me-1"><?= date('Y') ?>&copy;</span>
			<a href="https://portal.chtningi.com.ng" target="_blank" class="text-gray-800 text-hover-primary"><?php echo get_settings('system_name'); ?></a>
		</div>
		<!--end::Copyright-->
		<!--begin::Menu-->
		<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
			<li class="menu-item">
				<a href="https://diidol.com.ng" target="_blank" class="menu-link px-2">About</a>
			</li>
			<li class="menu-item">
				<a href="https://diidol.com.ng" target="_blank" class="menu-link px-2">Support</a>
			</li>

		</ul>
		<!--end::Menu-->
	</div>
	<!--end::Footer container-->
</div>
<!--end::Footer-->
</div>
<!--end:::Main-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::App-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
	<span class="svg-icon">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
		</svg>
	</span>
	<!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->
<!-- CONTENT AREA -->
<div id="faderightModal" class="modal animated fadeInRight custo-fadeInRight" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form id="passport" method="post" action='<?php echo base_url(); ?>/student/ajax_upload' enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Upload Passport</h5>
					<a href="<?php echo base_url('student/logout') ?>" type="button" class="close" aria-label="Close"></a>
					<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
						<line x1="18" y1="6" x2="6" y2="18"></line>
						<line x1="6" y1="6" x2="18" y2="18"></line>
					</svg>
					</button>
				</div>
				<div class="modal-body">
					<!--begin::Col-->
					<div class="col-lg-8 mx-auto">
						<!--begin::Image input-->
						<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?= base_url('') ?>assets/media/svg/avatars/blank.svg')">
							<!--begin::Preview existing avatar-->
							<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo $this->student_model->get_user_image_url($this->session->userdata('user_id')); ?>)"></div>
							<!--end::Preview existing avatar-->
							<!--begin::Label-->
							<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Photo">
								<i class="bi bi-pencil-fill fs-7"></i>
								<!--begin::Inputs-->
								<input type="file" name="file" accept=".png, .jpg, .jpeg" />
								<input type="hidden" name="avatar_remove" />
								<!--end::Inputs-->
							</label>
							<!--end::Label-->
							<!--begin::Cancel-->
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
								<i class="bi bi-x fs-2"></i>
							</span>
							<!--end::Cancel-->
							<!--begin::Remove-->
							<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Photo">
								<i class="bi bi-x fs-2"></i>
							</span>
							<!--end::Remove-->
						</div>
						<!--end::Image input-->
						<!--begin::Hint-->
						<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
						<!--end::Hint-->
					</div>
					<!--end::Col-->
				</div>
				<div class="modal-footer md-button">
					<a href="<?php echo base_url('student/logout') ?>" class="btn"><i class="flaticon-cancel-12"></i> Discard</a>
					<button id="upload" type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="zoomupModal" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Change Password</h5>

				<a href="<?php echo base_url('student/logout') ?>" type="button" class="close" aria-label="Close"></a>
				<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
				</button>
			</div>
			<form action="<?php echo base_url('student/modalchangepass') ?>" id="form-validation" name="passwordform" method="post" class="form-horizontal" novalidate="">
				<?php echo $this->customlib->getCSRF(); ?>
				<div class="modal-body">
					<p class="modal-text">

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
						<label class="control-label" for="new_pass"><?php echo 'New password'; ?>
						</label>
						<div class="">
							<input type="password" id="new_pass" class="form-control" name="new_pass" placeholder="" value="<?php echo set_value('new_pass'); ?>" class="form-control" required="required">
							<span class="text-danger"><?php echo form_error('new_pass'); ?></span>
						</div>
					</div>
					<div class="form-group <?php
											if (form_error('confirm_pass')) {
												echo 'has-error';
											}
											?>">
						<label class="control-label" for="confirm_pass"><?php echo 'Confirm password'; ?>
						</label>
						<div class="">
							<input type="password" id="confirm_pass" class="form-control" name="confirm_pass" placeholder="" value="<?php echo set_value('confirm_pass'); ?>">
							<span class="text-danger"><?php echo form_error('confirm_pass'); ?></span>
						</div>
					</div>
					</p>
				</div>
				<div class="modal-footer md-button">
					<a href="<?php echo base_url('student/logout') ?>" class="btn"><i class="flaticon-cancel-12"></i> Discard</a>
					<button type="submit" id="password" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade register-modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header" id="registerModalLabel">
				<h4 class="modal-title">Update Email And Mobile No</h4>
				<!-- 	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
						<line x1="18" y1="6" x2="6" y2="18"></line>
						<line x1="6" y1="6" x2="18" y2="18"></line>
					</svg></button> -->
			</div>
			<div class="modal-body">
				<form id="updateEmail" class="mt-0 needs-validation" novalidate method="post" accept-charset="utf-8">
					<input type="hidden" id="id" name="id" value="<?= $student['id']; ?>">
					<div class="form-group">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign">
							<circle cx="12" cy="12" r="4"></circle>
							<path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
						</svg>
						<input type="email" name="email" class="form-control mb-2" id="modalEmail" placeholder="Email" required>
						<span id="msgbox" class="text-danger"></span>
					</div>
					<div class="form-group">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign">
							<circle cx="12" cy="12" r="4"></circle>
							<path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
						</svg>
						<input type="tel" name="phone" class="form-control mb-2" id="modalMobileno" placeholder="Phone Number" required>
						<span id="mobileMsgbox" class="text-danger"></span>
					</div>
					<div id="updateSubmit">
						<button type="submit" id="updateEmail" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>
					</div>


				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" tabindex="-1" id="kt_modal_1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Modal title</h3>

				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
				</div>
				<!--end::Close-->
			</div>

			<div class="modal-body">
				<p>Modal body text goes here.</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>
<!--begin::Javascript-->
<script>
	var hostUrl = "<?= base_url(); ?>assets/";
</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="<?= base_url(); ?>assets/plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url(); ?>assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used by this page)-->
<script src="<?= base_url(); ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="<?= base_url(); ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>

<!-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> -->
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used by this page)-->
<script src="<?= base_url(); ?>assets/js/widgets.bundle.js"></script>
<script src="<?= base_url(); ?>assets/js/ajax-form.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom/widgets.js"></script>
<!-- 
<script src="<?= base_url(); ?>assets/js/adform.js"></script> -->

<script src="<?= base_url(); ?>assets/js/custom/utilities/modals/create-campaign.js"></script>
<script src="<?= base_url(); ?>assets/js/custom/apps/chat/chat.js"></script>
<script src="<?= base_url(); ?>assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="<?= base_url(); ?>assets/js/custom/utilities/modals/create-app.js"></script>
<script src="<?= base_url(); ?>assets/js/custom/utilities/modals/new-target.js"></script>
<script src="<?= base_url(); ?>assets/js/custom/utilities/modals/users-search.js"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
<!-- <script>
	$(document).ready(function() {
		$('#kt_modal_1').modal('show')
	});
</script> -->
<script>
	<?php
	$student_id = $this->session->userdata('user_id');
	$details = $this->student_model->get($student_id);
	if ($details['open_p'] != 'password') { ?>
	<?php } else { ?>
		$(window).on('load', function() {

			$('#zoomupModal').modal('show')
		});
	<?php } ?>
</script>
<?php
if ($details['image'] == '' && $details['open_p'] == 'password' || $details['open_p'] == '') { ?>
<?php } elseif ($details['image'] == '' && $details['open_p'] != 'password') { ?>
	<script>
		$(window).on('load', function() {
			$('#faderightModal').modal('show')
		});
	</script>
<?php } else { ?>

	<?php }
if ($details['image'] != '' && $details['open_p'] != 'password') {
	if ($details['email'] == "" || $details['phone'] == "") { ?>
		<script>
			$(window).on('load', function() {

				$('#registerModal').modal({
					backdrop: 'static',
					keyboard: false
				})
			});
		</script>
<?php }
} ?>
<script>
	$(document).ready(function() {
		App.init();
	});
	$(document).ready(function() {
		$("#modalEmail").keyup(function() {
			//remove all the class add the messagebox classes and start fading
			$("#msgbox").removeClass().addClass('badge badge-primary').text('Checking...').fadeIn("slow");
			//check the username exists or not from ajax
			$("div[id='updateSubmit']").html('<button type="submit" id="updateEmail" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

			var email = $(this).val();
			$.ajax({
				url: "<?= base_url() ?>student/check_user_email",
				data: {
					email: email
				},
				type: 'POST',

				success: function(data) {
					if (data == 0) {
						$("#msgbox").fadeTo(200, 0.1, function() { //start fading the messagebox

							//add message and change the class of the box and start fading
							$(this).html('This Email Already exists').addClass('badge badge-danger').fadeTo(900, 1);
							$("div[id='updateSubmit']").html('<button type="submit" id="updateEmail" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

						});
					} else if (data == 1) {
						$("#msgbox").fadeTo(200, 0.1, function() { //start fading the messagebox

							//add message and change the class of the box and start fading
							$(this).html('Email Available for Update').addClass('badge badge-success').fadeTo(900, 1);
							$("div[id='updateSubmit']").html('<button type="submit" id="updateEmail" class="btn btn-success mt-2 mb-2 btn-block">Update</button>');

						});

					} else if (data == -1) {
						$("#msgbox").fadeTo(200, 0.1, function() { //start fading the messagebox

							//add message and change the class of the box and start fading
							$(this).html('Field Cannot be empty').addClass('badge badge-warning').fadeTo(900, 1);
							$("div[id='updateSubmit']").html('<button type="submit" id="updateEmail" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

						});
					} else {
						alert("Some error occured! Check Console");
						$("div[id='updateSubmit']").html('<button type="submit" id="updateEmail" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

					}
				}
			});
		});

	});
	$(document).ready(function() {
		$("#modalMobileno").keyup(function() {
			//remove all the class add the messagebox classes and start fading
			$("#mobileMsgbox").removeClass().addClass('badge badge-primary').text('Checking...').fadeIn("slow");
			//check the username exists or not from ajax
			$("div[id='updateSubmit']").html('<button type="submit" id="update" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

			var phone = $(this).val();
			$.ajax({
				url: "<?= base_url() ?>student/check_user_phone",
				data: {
					phone: phone
				},
				type: 'POST',
				beforeSend: function() {
					$("div[id='updateSubmit']").html('<button class="btn btn-info mt-2 mb-2 btn-block disabled"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin mr-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>');
					//resetFields($this.attr('value'));
				},

				success: function(data) {
					if (data == 0) {
						$("#mobileMsgbox").fadeTo(200, 0.1, function() { //start fading the messagebox

							//add message and change the class of the box and start fading
							$(this).html('This Mobile No is already used by another Student').addClass('badge badge-danger').fadeTo(900, 1);
							$("div[id='updateSubmit']").html('<button type="submit" id="update" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

						});
					} else if (data == 1) {
						$("#mobileMsgbox").fadeTo(200, 0.1, function() { //start fading the messagebox

							//add message and change the class of the box and start fading
							$(this).html('Mobile No Available').addClass('badge badge-success').fadeTo(900, 1);
							$("div[id='updateSubmit']").html('<button type="submit" id="updateEmail" class="btn btn-success mt-2 mb-2 btn-block">Update</button>');

						});

					} else if (data == -1) {
						$("#mobileMsgbox").fadeTo(200, 0.1, function() { //start fading the messagebox

							//add message and change the class of the box and start fading
							$(this).html('Field Cannot be empty').addClass('badge badge-warning').fadeTo(900, 1);
							$("div[id='updateSubmit']").html('<button type="submit" id="update" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

						});
					} else {
						alert("Some error occured! Check Console");
						$("div[id='updateSubmit']").html('<button type="submit" id="update" class="btn btn-primary mt-2 mb-2 btn-block" disabled>Update</button>');

					}
				}
			});
		});

	});
	$(document).ready(function() {
		$(document).on('submit', '#updateEmail', function(e) {
			//var obj = $(this);
			e.preventDefault();
			//alert(); what's this do?

			var id = $('#id').val();
			var email = $('#modalEmail').val();
			var phone = $('#modalMobileno').val();

			$.ajax({
				type: 'POST',
				url: '<?php echo base_url('student/update_emailAndMobile') ?>',
				data: {
					'email': email,
					'phone': phone,
				},
				beforeSend: function() {
					$("div[id='updateSubmit']").html('<button class="btn btn-info mt-2 mb-2 btn-block disabled"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin mr-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>');
					//resetFields($this.attr('value'));
				},
				success: function(data) {
					swal('Submitted', 'Submitted Successfully', 'success');
					window.location.reload();
				},
				error: function(data) {
					swal('Error!', 'Not Submitted', 'error');
				}
			});


		});
	});
</script>
<script>
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


<script>
	$(document).ready(function() {

		$('#upload').click(function() {

			var fd = new FormData();
			var files = $('#file')[0].files[0];
			fd.append('file', files);

			// AJAX request
			$.ajax({
				url: '<?php echo base_url(); ?>student/ajax_upload',
				type: 'post',
				data: fd,
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					window.location.reload();
				}
			});
		});
		document.onkeydown = function(e) {
			if (event.keyCode == 123) {
				return false;
			}
			if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
				return false;
			}
			if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
				return false;
			}
			if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
				return false;
			}
			if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
				return false;
			}
		}
	});
</script>
</body>
<!--end::Body-->

</html>