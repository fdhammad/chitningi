	<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->

	<?php if ($page_name == "admission") {; ?>

		<script type="text/javascript">
			var submitButton = document.querySelector('#kt_sign_up_submit');
			$('#reg').validate({

				rules: {
					/* 	program_id: {
							required: true
						}, */
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
					toc: {
						required: true
					}

				},
				messages: {
					/* 	program_id: {
							required: "<span class='text-danger'>Please enter some data</span>"
						}, */
					firstname: {
						required: "<span class='text-danger'>Please enter some data</span>"
					},
					lastname: {
						required: "<span class='text-danger'>Please provide some data</span>",
						email: '<span class="text-danger">The value is not a valid email address</span>'
					},
					phone: {
						required: "<span class='text-danger'>Please provide some data</span>"
					},
					email: {
						required: "<span class='text-danger'>Please provide some data</span>"
					},
					password: {
						required: "<span class='text-danger'>Please enter some data</span>"
					},
					confirm_password: {
						required: "<span class='text-danger'>Please enter some data</span>",
						equalTo: "<span class='text-danger'>Please enter the same value again.</span>"
					},
					toc: {
						required: "<span class='text-danger'>You must accept the terms and conditions</span>"
					}

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
									text: "Registration successful!",
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


			// Ajax post  
			/* $(document).ready(function() {
				submitButton = document.querySelector('#submit');
				$("#submit").click(function() {
					jQuery("div#staff_err_msg").hide();
					var email = $("#email").val();
					var password = $("#password").val();
					// Returns error message when submitted without req fields.  
					if (email == '' || password == '') {
						jQuery("div#err_msg").show();
						jQuery("div#msg").html("All fields are required");
					} else {
						// AJAX Code To Submit Form.  
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>" + "login/check_login",
							data: {
								email: email,
								password: password
							},
							cache: false,
							beforeSend: function() {
								submitButton.setAttribute('data-kt-indicator', 'on');
								submitButton.disabled = true;
							},
							success: function(result) {
								if (result == 2) {
									jQuery("div#err_msg").show();
									jQuery("div#msg").html("Your account is disabled please contact to administrator");
								} else if (result == 0) {
									jQuery("div#err_msg").show();
									jQuery("div#msg").html("Incorrect Email/Password");
								} else {
									// On success redirect.
									window.location.replace(result);
								}

							},

							complete: function() {
								submitButton.removeAttribute('data-kt-indicator');
								submitButton.disabled = false;
							}
						});
					}
					return false;
				});
			}); */
			/* $(document).ready(function() {
				$("#reg").validate({
					rules: {
						firstname: {
							required: true
						},
						lastname: {
							required: true
						}
					},
					messages: {
						firstname: {
							required: "Please enter some data"
						},
						lastname: {
							required: "Please provide some data"
						}
					},
					submitHandler: function(form, e) {
						e.preventDefault();
						alert('Form submitted');
						return false;
					}
				});
			}); */
		</script>
	<?php } elseif ($page_name == 'applicant_login') { ?>
		<script type="text/javascript">
			// Ajax post  
			$(document).ready(function() {
				submitButton = document.querySelector('#submit');
				$("#submit").click(function() {
					jQuery("div#err_msg").hide();
					var username = $("#username").val();
					var password = $("#password").val();
					// Returns error message when submitted without req fields.  
					if (username == '' || password == '') {
						jQuery("div#err_msg").show();
						jQuery("div#msg").html("All fields are required");
					} else {
						// AJAX Code To Submit Form.  
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>" + "admission/check_login",
							data: {
								username: username,
								password: password
							},
							cache: false,
							beforeSend: function() {
								submitButton.setAttribute('data-kt-indicator', 'on');
								submitButton.disabled = true;
							},
							success: function(result) {
								if (result == 0) {
									jQuery("div#err_msg").show();
									jQuery("div#msg").html("Incorrect Username/Password");
								} else {
									// On success redirect.
									window.location.replace(result);
								}

							},

							complete: function() {
								submitButton.removeAttribute('data-kt-indicator');
								submitButton.disabled = false;
							}
						});
					}
					return false;
				});
			});
		</script>
	<?php	} elseif ($page_name == 'staff_login') { ?>
		<script type="text/javascript">
			// Ajax post  
			$(document).ready(function() {
				submitButton = document.querySelector('#staff_submit');
				$("#staff_submit").click(function() {
					jQuery("div#staff_err_msg").hide();
					var email = $("#email").val();
					var password = $("#password").val();
					// Returns error message when submitted without req fields.  
					if (email == '' || password == '') {
						jQuery("div#staff_err_msg").show();
						jQuery("div#staff_msg").html("All fields are required");
					} else {
						// AJAX Code To Submit Form.  
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>" + "staff/check_login",
							data: {
								email: email,
								password: password
							},
							cache: false,
							beforeSend: function() {
								submitButton.setAttribute('data-kt-indicator', 'on');
								submitButton.disabled = true;
							},
							success: function(result) {
								if (result == 0) {
									jQuery("div#staff_err_msg").show();
									jQuery("div#staff_msg").html("Incorrect Email Address/Password");
								} else {
									// On success redirect.
									window.location.replace(result);
								}

							},

							complete: function() {
								submitButton.removeAttribute('data-kt-indicator');
								submitButton.disabled = false;
							}
						});
					}
					return false;
				});
			});
		</script>
	<?php } elseif ($page_name == 'login') { ?>
		<script type="text/javascript">
			// Ajax post  
			$(document).ready(function() {
				submitButton = document.querySelector('#submit');
				$("#submit").click(function() {
					jQuery("div#err_msg").hide();
					var username = $("#username").val();
					var password = $("#password").val();
					// Returns error message when submitted without req fields.  
					if (username == '' || password == '') {
						jQuery("div#err_msg").show();
						jQuery("div#msg").html("All fields are required");
					} else {
						// AJAX Code To Submit Form.  
						console.log(username);
						console.log(password);
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>" + "login/check_login",
							data: {
								username: username,
								password: password
							},
							cache: false,
							beforeSend: function() {
								submitButton.setAttribute('data-kt-indicator', 'on');
								submitButton.disabled = true;
							},
							success: function(result) {
								if (result == 0) {
									jQuery("div#err_msg").show();
									jQuery("div#msg").html("Incorrect Username/Password");
								} else {
									// On success redirect.
									window.location.replace(result);
								}

							},

							complete: function() {
								submitButton.removeAttribute('data-kt-indicator');
								submitButton.disabled = false;
							}
						});
					}
					return false;
				});
			});
		</script>
	<?php } elseif ($page_name == 'payment_success') { ?>
		<script type="text/javascript">
			// Ajax post  
			$(document).ready(function() {
				Swal.fire({
					title: 'Success!',
					text: "Payment Approve",
					icon: "success",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				});
			})
		</script>

	<?php	} ?>



	<script type="text/javascript">
		<?php if ($this->session->flashdata('success')) { ?> toastr.success("<?php echo $this->session->flashdata('success'); ?>");
		<?php } else if ($this->session->flashdata('error')) { ?> toastr.error("<?php echo $this->session->flashdata('error'); ?>");
		<?php } else if ($this->session->flashdata('warning')) { ?> toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
		<?php } else if ($this->session->flashdata('info')) { ?> toastr.info("<?php echo $this->session->flashdata('info'); ?>");
		<?php } ?>
	</script>
