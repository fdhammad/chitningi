	<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->
	<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
	<script type="text/javascript">
		<?php if ($applicant['firstname'] == null || $applicant['firstname'] == '') { ?>
			$(document).ready(function() {
				$("#kt_modal_pass").modal('show');
			});
		<?php } ?>

		$(document).ready(function() {
			//var id = $('#program').val();
			var base_url = '<?php echo base_url() ?>';
			$(document).on('change', '#program', function(e) {
				var id = $(this).val();
				$('#amount').html("<span class='spinner-border spinner-border-sm align-middle ms-2'></span></span>");
				$('#inputAmount').val("");
				$.ajax({
					//url: '<?php echo site_url("admin/students/summer_store") ?>',
					type: "GET",
					url: base_url + "applicant/getAppAmount",
					data: {

						'id': id

					},
					dataType: "json",
					beforeSend: function() {
						$('#amount').html("<span class='spinner-border spinner-border-sm align-middle ms-2'></span></span>");
					},
					success: function(response) {
						//alert('Course Added Successfully');
						$('#amount').html("₦" + response.app_amount);
						$('#modalAmount').html("₦" + response.app_amount);
						$('#inputAmount').val(response.app_amount);
						//console.log(response);
						//window.location.reload();
					}
				});
			});

		})
	</script>
	<script type="text/javascript">
		function getLocal(state_id, local_government_id) {
			if (state_id != "" && local_government_id != "") {
				$('#local_government_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getByLocal",
					data: {
						'state_id': state_id
					},
					dataType: "json",
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (local_government_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#local_government_id').append(div_data);
					}
				});
			}
		}
		$(document).ready(function() {
			var state_id = $('#state_id').val();
			var local_government_id = '<?php echo set_value('local_government_id', $applicant['local_government_id']) ?>';
			getLocal(state_id, local_government_id);
			$(document).on('change', '#state_id', function(e) {
				$('#local_government_id').html("");
				var state_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getByLocal",
					data: {
						'state_id': state_id
					},
					dataType: "json",
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
						});
						$('#local_government_id').append(div_data);
					}
				});
			});
		});
	</script>
	<script type="text/javascript">
		var submitButton = document.querySelector('#kt_submit');
		$('#update_name').validate({

			rules: {

				firstname: {
					required: true
				},
				lastname: {
					required: true
				},
				phone: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				password: {
					required: true
				},
				confirm_password: {
					required: true,
					equalTo: "#password"
				},

			},
			messages: {
				/* 	program_id: {
						required: "<span class='text-danger'>Please enter some data</span>"
					}, */
				firstname: {
					required: "<span class='text-danger'>Please enter some data</span>"
				},
				lastname: {
					required: "<span class='text-danger'>Please provide some data</span>"

				},
				phone: {
					required: "<span class='text-danger'>Please provide some data</span>"
				},
				email: {
					required: "<span class='text-danger'>Please provide some data</span>",
					email: '<span class="text-danger">The value is not a valid email address</span>'
				},
				password: {
					required: "<span class='text-danger'>Please enter some data</span>"
				},
				confirm_password: {
					required: "<span class='text-danger'>Please enter some data</span>",
					equalTo: "<span class='text-danger'>Please enter the same value again.</span>"
				},

			},

			submitHandler: function(form) {
				$.ajax({
					url: form.action,
					type: form.method,
					data: $(form).serialize(),
					dataType: 'JSON',
					beforeSend: function() {
						submitButton.setAttribute('data-kt-indicator', 'on');
						submitButton.disabled = true;
					},
					success: function(response) {
						//$('#answers').html(response);
						var obj = JSON.parse(response)
						console.log(obj);

						if (obj.status == true) {
							toastr.success("" + obj.notification + "");
							Swal.fire({
								text: "Data Updated successful!",
								icon: "success",
								timer: 1500,
							})
							form.reset();
							window.location.replace('<?= base_url('applicant/dashboard'); ?>');

						} else {
							toastr.error("" + obj.notification + "");
						}
						//console.log()
						/* var redirectUrl = form.getAttribute('data-redirect-url');
	 					if (redirectUrl) {
	 						window.location.href = redirectUrl;
	 					}
 */
					},
					error: function(response) {
						//swal('Error!', 'Not Submitted', 'error');
						//alert()
						toastr.error("Unknown Error");
					},

					//ee

					complete: function() {
						submitButton.removeAttribute('data-kt-indicator');
						submitButton.disabled = false;
					}
				});
			}
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			var submitButton = document.querySelector('#ktsubmit');
			$('#init_payment').validate({

				rules: {
					program: {
						required: true
					},
					method: {
						required: true
					},


				},
				messages: {
					program: {
						required: "<span class='text-danger'>Please enter some data</span>"
					},
					method: {
						required: "<span class='text-danger'>Please enter some data</span>"
					},


				},

				submitHandler: function(form) {
					$.ajax({
						url: form.action,
						type: form.method,
						data: $(form).serialize(),
						dataType: 'JSON',
						beforeSend: function() {
							submitButton.setAttribute('data-kt-indicator', 'on');
							submitButton.disabled = true;
						},
						success: function(response) {
							//$('#answers').html(response);
							var obj = JSON.parse(response)
							console.log(obj);

							/* if (obj.status == true) {
								toastr.success("" + obj.notification + "");
								Swal.fire({
									text: "Registration successful!",
									icon: "success",
									timer: 1500,
								})
								form.reset();
								window.location.replace('<?= base_url('applicant/dashboard'); ?>');

							} else {
								toastr.error("" + obj.notification + "");
							} */
							//console.log()
							/* var redirectUrl = form.getAttribute('data-redirect-url');
	 					if (redirectUrl) {
	 						window.location.href = redirectUrl;
	 					}
 					*/
						},

						complete: function() {
							submitButton.removeAttribute('data-kt-indicator');
							submitButton.disabled = false;
						}
					});
				}

			})
		})
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			if ($('#sitting').val() == '1') {
				$('#once').show();
				$('#twice').hide();
			} else if ($('#sitting').val() == '2') {
				$('#once').show();
				$('#twice').show();
			} else {
				$('#once').hide();
				$('#twice').hide();
			}
			$("#sitting").change(function() {
				var selected_option = $('#sitting').val();
				if (selected_option == '1') {
					$('#once').show();
					$('#twice').hide();

				} else if ($('#sitting').val() == '2') {
					$('#once').show();
					$('#twice').show();

				} else {
					$('#once').hide();
					$('#twice').hide();

				}
			})
			$(document).on('change', '#course_id', function(e) {
				var course_id = $(this).val();

				console.log(course_id);
			})
		});
	</script>

	<script type="text/javascript">
		function getSectionByClass(school_id, department_id, course_id) {
			if (school_id != "" && department_id != "" && course_id != "") {
				$('#department_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getBySchool",
					data: {
						'school_id': school_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#department_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (department_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + "Dept of " + obj.name + "</option>";
						});
						$('#department_id').append(div_data);
					},
					complete: function() {
						$('#department_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var school_id = $('#school_id').val();
			var department_id = '<?php echo set_value('department_id', $choice1['department_id']) ?>';
			var course_id = '<?php echo set_value('course_id', $choice1['course_id']) ?>';
			getSectionByClass(school_id, department_id, course_id);
			$(document).on('change', '#school_id', function(e) {
				$('#department_id').html("");
				var school_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getBySchool",
					data: {
						'school_id': school_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#department_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + "Dept of " + obj.name + "</option>";
						});
						$('#department_id').append(div_data);
					},
					complete: function() {
						$('#department_id').removeClass('dropdownloading');
					}
				});
			});
			var school_id = $('#school_id').val();
			var department_id = '<?php echo set_value('department_id', $choice1['department_id']) ?>';
			var course_id = '<?php echo set_value('course_id', $choice1['course_id']) ?>';
			getSectionByClass(school_id, department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();

				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getByDepartment",
					data: {

						'department_id': department_id

					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + ' ' + obj.code + ' (' + obj.year + ' years)' + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		function getSectionByClass2(school_id2, department_id2, course_id2) {
			if (school_id2 != "" && department_id2 != "" && course_id2 != "") {
				$('#department_id2').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getBySchool",
					data: {
						'school_id': school_id2
					},
					dataType: "json",
					beforeSend: function() {
						$('#department_id2').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (department_id2 == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + "Dept of " + obj.name + "</option>";
						});
						$('#department_id2').append(div_data);
					},
					complete: function() {
						$('#department_id2').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var school_id2 = $('#school_id2').val();
			var department_id2 = '<?php echo set_value('department_id2', $choice2['department_id']) ?>';
			var course_id2 = '<?php echo set_value('course_id2', $choice2['course_id']) ?>';
			getSectionByClass2(school_id2, department_id2, course_id2);
			$(document).on('change', '#school_id2', function(e) {
				$('#department_id2').html("");
				var school_id2 = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getBySchool",
					data: {
						'school_id': school_id2
					},
					dataType: "json",
					beforeSend: function() {
						$('#department_id2').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + "Dept of " + obj.name + "</option>";
						});
						$('#department_id2').append(div_data);
					},
					complete: function() {
						$('#department_id2').removeClass('dropdownloading');
					}
				});
			});
			var school_id2 = $('#school_id2').val();
			var department_id2 = '<?php echo set_value('department_id2', $choice2['department_id']) ?>';
			var course_id2 = '<?php echo set_value('course_id2', $choice2['course_id']) ?>';
			getSectionByClass2(school_id2, department_id2, course_id2);
			$(document).on('change', '#department_id2', function(e) {
				$('#course_id2').html("");
				var department_id2 = $(this).val();

				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "applicant/getByDepartment",
					data: {

						'department_id': department_id2

					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id2').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + ' ' + obj.code + ' (' + obj.year + ' years)' + "</option>";
						});
						$('#course_id2').append(div_data);
					},
					complete: function() {
						$('#course_id2').removeClass('dropdownloading');
					}
				});
			});
		});
	</script>
	<script type="text/javascript">
		//function test() {

		$(document).ready(function() {
			//code here
			console.log('It works');
			//$('#alert').html(' <div role="alert" class="alert alert-success"><strong>Success!</strong> Profile Created successfully. </div>')
			$('#adform_button').on('click', function(e) {
				var formData = new FormData(document.querySelector('.adform'));
				//var subsubmit_button = document.querySelector('#staff_edit_button');
				//var drEvent = $('#image').dropify();
				//drEvent = drEvent.data('dropify');
				var id = $('#applicant_id').val();
				$('#alert').html('');
				$("#response").hide();
				//	e.stopPropagation();
				//} else {
				e.preventDefault();

				$.ajax({
					url: '<?= base_url('applicant/addFormDetails') ?>',
					method: "POST",
					data: formData,
					contentType: false,
					cache: true,
					processData: false,

					success: function(data) {
						//$('#answers').html(response);
						var response = JSON.parse(data)
						console.log(data);

						//alert('It works');
						if (response.status == true) {
							toastr.success("" + response.notification + "");
							renderReview(id);
							//renderLoder(response);
							/* 	Swal.fire({
									text: "Registration successful!",
									icon: "success",
									timer: 1500,
								}) */
							//form.reset();
							//drEvent.resetPreview();
							//drEvent.clearElement();
							//$('#alert').html(' <div role="alert" class="alert alert-success"><strong>Success! </strong>Details Saved successfully. </div>')
							//window.location.reload();
						} else {
							toastr.error("" + response.notification + "");
						}

					},
					error: function(xhr, ajaxOptions, throwError) {
						//console.log(xhr);
						toastr.error("Unknown Error");
					}

				});

				//alert('It works')
				//}

				//$(this).addClass('was-validated');
			});

			/*	$('#adform_button').on('click', function(e) {
				var id = $('#applicant_id').val();

				console.log('Success it works');
				$.ajax({
					url: '<?= base_url('applicant/review') ?>',
					method: "POST",
					data: {
						'id': id
					},
					contentType: false,
					cache: true,
					processData: false,

					success: function(data) {
						var response = JSON.parse(data)
						renderLoder(response);
						$("#response").show();

					}
				})

			});
*/
		});

		function renderReview(id) {
			//var 

			console.log('Success it works');
			$.ajax({
				url: '<?= base_url('applicant/review') ?>',
				method: "POST",
				data: {
					'id': id
				},
				contentType: false,
				cache: true,
				processData: false,

				success: function(data) {
					var response = JSON.parse(data)
					renderLoder(response);
					$("#response").show();

				}
			})

		}

		function renderLoder(response) {
			$('#response').html(response.render);


		};

		$('.finalize').on('click', function(e) {
			var id = $('#id').val();
			Swal.fire({
				icon: 'warning',
				title: 'Are you sure you want to submit this record?',
				showDenyButton: false,
				showCancelButton: true,
				confirmButtonText: 'Yes'
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					$.ajax({
						url: "<?= base_url('applicant/finalize') ?>",
						type: "POST",
						data: {
							id: id
						},
						dataType: "html",
						success: function() {
							swal.fire("Done!", "It was succesfully Finalize!", "success");
							//window.location.reload();
							window.location.replace("<?= base_url('applicant/dashboard') ?>");
						},
						error: function(xhr, ajaxOptions, thrownError) {
							swal.fire("Error!", "Please try again", "error");
						}
					});
				};
			})
		})

		//	}
	</script>
	<script type="text/javascript">
		<?php if ($this->session->flashdata('success')) { ?> toastr.success("<?php echo $this->session->flashdata('success'); ?>");
		<?php } else if ($this->session->flashdata('error')) { ?> toastr.error("<?php echo $this->session->flashdata('error'); ?>");
		<?php } else if ($this->session->flashdata('warning')) { ?> toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
		<?php } else if ($this->session->flashdata('info')) { ?> toastr.info("<?php echo $this->session->flashdata('info'); ?>");
		<?php } ?>
	</script>