	<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->
	<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
	<?php if ($page_name == 'profile') { ?>
		<script type="text/javascript">
			function getLocal(state_id, local_government_id) {
				if (state_id != "" && local_government_id != "") {
					$('#local_government_id').html("");
					var base_url = '<?php echo base_url() ?>';
					var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
					$.ajax({
						type: "GET",
						url: base_url + "student/getByLocal",
						data: {
							'state_id': state_id
						},
						dataType: "json",
						beforeSend: function() {
							$('#local_government_id').addClass('dropdownloading');
						},
						success: function(data) {
							$.each(data, function(i, obj) {
								var sel = "";
								if (local_government_id == obj.id) {
									sel = "selected";
								}
								div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
							});
							$('#local_government_id').append(div_data);
						},
						complete: function() {
							$('#local_government_id').removeClass('dropdownloading');
						}
					});
				}
			}
			$(document).ready(function() {
				var state_id = $('#state_id').val();
				var local_government_id = '<?php echo set_value('local_government_id', $student['local_government_id']) ?>';
				getLocal(state_id, local_government_id);
				$(document).on('change', '#state_id', function(e) {
					$('#local_government_id').html("");
					var state_id = $(this).val();
					var base_url = '<?php echo base_url() ?>';
					var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
					$.ajax({
						type: "GET",
						url: base_url + "student/getByLocal",
						data: {
							'state_id': state_id
						},
						dataType: "json",
						beforeSend: function() {
							$('#local_government_id').addClass('dropdownloading');
						},
						success: function(data) {
							$.each(data, function(i, obj) {
								div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
							});
							$('#local_government_id').append(div_data);
						},
						complete: function() {
							$('#local_government_id').removeClass('dropdownloading');
						}
					});
				});
			})
		</script>

		<script type="text/javascript">
			$(document).ready(function() {

				$('.needs-validation').on('submit', function(e) {
					var form = document.querySelector('#student_profile_update');
					var formData = new FormData(document.getElementById('student_profile_update'));
					var subsubmit_button = document.querySelector('#btn_update');
					//var drEvent = $('#image').dropify();
					//drEvent = drEvent.data('dropify');
					$('#alert').html('');
					if (!this.checkValidity()) {
						e.preventDefault();
						e.stopPropagation();
					} else {
						e.preventDefault();

						$.ajax({
							url: '<?= base_url('student/update') ?>',
							method: "POST",
							data: new FormData(this),
							contentType: false,
							cache: true,
							processData: false,
							beforeSend: function() {
								//console.log(form.method);
								//console.log(form.action);
								console.log(formData);

								subsubmit_button.innerText = 'Loading ...';
								subsubmit_button.disabled = true;

							},
							success: function(data) {
								//$('#answers').html(response);
								var response = JSON.parse(data)
								console.log(response);

								//alert('It works');
								if (response.status == true) {
									toastr.success("" + response.notification + "");
									/* 	Swal.fire({
											text: "Registration successful!",
											icon: "success",
											timer: 1500,
										}) */
									//form.reset();
									//drEvent.resetPreview();
									//drEvent.clearElement();
									$('#alert').html(' <div role="alert" class="alert alert-success"><strong>Success!</strong> Profile Updated successfully. </div>')
									//window.location.reload();
								} else {
									toastr.error("" + response.notification + "");
								}

							},
							error: function(xhr, ajaxOptions, throwError) {
								//console.log(xhr);
								toastr.error("Unknown Error");
							},


							complete: function() {
								subsubmit_button.innerText = 'Update Profile';
								subsubmit_button.disabled = false;
							}
						});

						//alert('It works')
					}

					$(this).addClass('was-validated');
				});

			});



			(function() {
				'use strict'

				$("#kt_dob").flatpickr({
					onReady: function() {
						this.jumpToDate("01/01/2000")
					},
					dateFormat: "d/m/Y",
					disable: [{
							from: "01/01/2010",
							to: "01/12/2025"
						}
						/* ,
						    	    {
						    	        from: "2025-02-03",
						    	        to: "2025-02-15"
						    	    } */
					]
				});

				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.querySelectorAll('.needs-validation')

				// Loop over them and prevent submission
				Array.prototype.slice.call(forms)
					.forEach(function(form) {
						form.addEventListener('submit', function(event) {
							if (!form.checkValidity()) {
								event.preventDefault()
								event.stopPropagation()
							}

							form.classList.add('was-validated')
						}, false)
					})
			})()
		</script>

	<?php } elseif ($page_name == 'course_reg') { ?>
		<style>
			.removeRow {
				background-color: #e28388;
				color: #FFFFFF;
			}

			.addRow {
				background-color: #32e5a0;
				color: #FFFFFF;
			}

			.selected {
				background-color: #F1416C;
				color: #FFF;

			}
		</style>

		<script type="text/javascript">
			$(document).ready(function() {




			})
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$.ajax({
					url: '<?php echo site_url("student/reg_ajax") ?>',
					type: 'post',
					dataType: "json",

					success: function(response) {
						renderRegPage(response);
					}
				});
			});

			$(document).on('click', '.course_selected', function(e) {
				//var obj = $(this);
				var subsubmit_button = document.querySelector('.course_selected');
				e.preventDefault();
				var array_to_print = [];
				var student_id = $('#student_id').val();
				var reg_no = $('#reg_no').val();
				var class_id = $('#class_id').val();
				var session_id = $('#session_id').val();
				var semester_id = $('#semester_id').val();
				var course_id = $('#course_id').val();
				$.each($("input[name='check']:checked"), function() {
					var subjectId = $(this).data('subject_id');
					item = {}
					item["subject_id"] = subjectId;
					array_to_print.push(item);
				});
				if (array_to_print.length == 0) {
					toastr.error("No Course Selected");
				} else {
					$.ajax({
						url: '<?php echo site_url("student/store_course_reg") ?>',
						type: 'post',
						dataType: "json",
						data: {
							'data': JSON.stringify(array_to_print),
							'student_id': student_id,
							'reg_no': reg_no,
							'class_id': class_id,
							'session_id': session_id,
							'semester_id': semester_id,
							//'school_id': school_id,
							'course_id': course_id

						},
						beforeSend: function() {
							//console.log(JSON.stringify(array_to_print));
							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;
							$("#render").hide();
							$("#render").empty();

						},
						success: function(response) {
							//var response = JSON.parse(data)
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								//obj.closest('tr').remove();
								//$(array_to_print).closest('tr').fadeOut("slow");
								$("#render").show();
								//window.location.reload();
							}
							renderRegPage(response);
							//console.log(response)
						},
						complete: function() {
							subsubmit_button.innerText = 'Add Course(s)';
							subsubmit_button.disabled = false;
						}
					});
				}
			});

			function renderRegPage(response) {
				$('#render').html(response.render);
				$('#select_all').on('click', function() {
					if (this.checked) {
						$('.checkbox').each(function() {
							$(this).closest('tr').addClass('addRow');
							this.checked = true;
						});
					} else {
						$('.checkbox').each(function() {
							$(this).closest('tr').removeClass('addRow');
							this.checked = false;
						});
					}
				});

				$('.checkbox').on('click', function() {
					if ($('.checkbox:checked').length == $('.checkbox').length) {
						$('#select_all').prop('checked', true);
					} else {
						$('#select_all').prop('checked', false);
					}
				});
				$('.checkbox').click(function() {
					if ($(this).is(':checked')) {
						$(this).closest('tr').addClass('addRow');
					} else {
						$(this).closest('tr').removeClass('addRow');
					}
				});
				$("#table tr").click(function() {
					$(this).toggleClass('selected');
					var value = $(this).find('td:first').attr('id');
					//alert(value);
				});

				$('#delete_all').on('click', function(e) {
					var subsubmit_button = document.querySelector('#delete_all');
					var selected = [];
					$("#table tr.selected").each(function() {
						selected.push($('td:first', this).attr('id'));
					});
					if (selected.length == 0) {
						toastr.error("No Course Selected");
					} else {
						Swal.fire({
							icon: 'warning',
							title: 'Are you sure you want to Delete this record?',
							showDenyButton: false,
							showCancelButton: true,
							confirmButtonText: 'Yes'
						}).then((result) => {
							/* Read more about isConfirmed, isDenied below */
							if (result.isConfirmed) {
								$.ajax({
									url: '<?php echo site_url("student/delete_multiple_reg") ?>',
									type: 'post',
									dataType: "json",
									data: {
										'id': selected, //JSON.stringify(array_to_print),
									},

									beforeSend: function() {
										//console.log(JSON.stringify(selected));
										subsubmit_button.innerText = 'Loading ...';
										subsubmit_button.disabled = true;
										$("#render").hide();
										$("#render").empty();

									},
									success: function(response) {
										//var response = JSON.parse(data)
										if (response.status == true) {
											toastr.success("" + response.notification + "");
											//obj.closest('tr').remove();
											$(selected).closest('tr').fadeOut("slow");
											$("#render").show();
											//window.location.reload();
										}
										renderRegPage(response);
										//console.log(response)
									},

									complete: function() {
										subsubmit_button.innerText = 'Remove Seleted';
										subsubmit_button.disabled = false;
									}
								});
							};
						})

						/* $("#table tr.selected").each(function() {
							selected.push($('td:first', this).attr('id'));
						});
						alert(selected); */
					}
				});

				$('#register').submit(function(e) {
					e.preventDefault(); //
					var count = $('#count').val();
					var min = 24;
					if (count > min) {
						swal.fire({
							type: 'error',
							title: 'Oops! Something went wrong',
							text: 'You registered ' + count + ' units which is than ' + min + ' units. Please remove some courses and try again',
							showConfirmButton: false,
							confirmButtonText: 'OK',
							showCloseButton: true,
							closeOnConfirm: false

						})
					} else {
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
									url: "<?= base_url('student/register') ?>",
									type: "POST",
									data: {
										id: id
									},
									dataType: "json",
									success: function(data) {
										console.log(data);
										//var response = JSON.parse(data)
										if (data.status == true) {
											swal.fire("Done!", "Succesfully Finalize!", "success");
											//window.location.reload();
											window.location.replace("<?= base_url('student/semester_form') ?>");
										} else {

											swal.fire("Error!", "Please try again", "error");
											//window.location.reload();
										}

									},
									error: function(xhr, ajaxOptions, thrownError) {
										swal.fire("Error!", "Please try again", "error");
									}
								});
							};
						})
					}
				})

			};


			$(document).ready(function() {
				function ConfirmDelete() {
					var x = confirm("Are you sure you want to delete?");
					if (x)
						return true;
					else
						return false;
				}
				$(".delete").click(function(e) {
					var obj = $(this);
					e.preventDefault();
					//alert(); what's this do?
					if (ConfirmDelete() == false) {
						return false;
					}
					$.ajax({
						//alert(); this can't go here
						type: "POST",
						url: "<?php echo site_url("students/course_reg/delete") ?>",
						cache: false,
						data: {
							id: $(this).attr("id")
						},
						success: function(data) {
							//('#alert').html('<div class="toast" data-title="Success! "data-message="Course Added Successfully." data-type="success"></div>');
							// success(data.toast);
							//$('.data-tables').dataTable().ajax.reload();
							obj.closest('tr').remove();
							swal({
								title: 'Success!',
								text: "Data Deleted Successfully!",
								type: 'success',
								timer: 2000,
								padding: '2em'
							});
							window.location.reload();

						}
					});
				});
			});
			$(document).ready(function() {
				$(document).on('click', '.save_co', function() { //** on selecting an option based on ID you assigned
					var subject_id = $("#co option:selected").val(); //** get the selected option's value
					var student_id = $('#student_id').val();
					var reg_no = $('#reg_no').val();
					var class_id = $('#class_id').val();
					var session_id = $('#session_id').val();
					var semester_id = $('#semester_id').val();
					var course_id = $('#course_id').val();
					var school_id = $('#school_id').val();
					$.ajax({
						type: "POST", //**how data is send
						url: "<?php echo site_url("students/course_reg/carryover") ?>", //** where to send the option data so that it can be saved in DB
						data: {
							'subject_id': subject_id,
							'student_id': student_id,
							'reg_no': reg_no,
							'class_id': class_id,
							'session_id': session_id,
							'semester_id': semester_id,
							'school_id': school_id,
							'course_id': course_id
						}, //** send the selected option's value to above page
						dataType: "json",
						success: function(data) {

							swal({
								title: 'Success!',
								text: "Courses Saved Successfully!",
								type: 'success',
								timer: 2000,
								padding: '2em'
							});
							window.location.reload();
						},
						error: function(data) {
							swal({
								type: 'error',
								title: 'Oops...',
								text: 'You Have Already Registered this Course!',
								padding: '2em'
							})
						}

						//** what should do after value is saved to DB and returned from above URL page.

					});
				});
			});
		</script>
	<?php } elseif ($page_name == 'semester_forms') { ?>

		<script type="text/javascript">
			$(document).ready(function() {
				var session_id = $('#session_id').val();
				var semester_id = $('#semester_id').val();
				$.ajax({
					url: '<?php echo site_url("student/semester_form_ajax") ?>',
					type: 'post',
					data: {
						'session_id': session_id,
						'semester_id': semester_id,
					},
					dataType: "json",

					success: function(response) {
						renderSemesterPage(response);
						//$("#render").show();
						console.log(response)
					}
				});
			});

			function renderSemesterPage(response) {
				$('#render').html(response.render);
			}
			$(document).on('click', '#request', function(e) {
				//var obj = $(this);
				var submitButton = document.querySelector('#request');
				e.preventDefault();
				var session_id = $('#session_id').val();
				var semester_id = $('#semester_id').val();
				$.ajax({
					url: '<?php echo site_url("student/semester_form_ajax") ?>',
					type: 'post',
					data: {
						'session_id': session_id,
						'semester_id': semester_id,
					},
					dataType: "json",
					beforeSend: function() {
						submitButton.setAttribute('data-kt-indicator', 'on');
						submitButton.disabled = true;
					},

					success: function(response) {
						renderSemesterPage(response);
						//$("#render").show();
						//console.log(response)
					},

					complete: function() {
						submitButton.removeAttribute('data-kt-indicator');
						submitButton.disabled = false;
					}
				});

			})
		</script>
		<?php } elseif ($page_name == 'semester_results') { ?>

		<script type="text/javascript">
			$(document).ready(function() {
				var session_id = $('#session_id').val();
				var semester_id = $('#semester_id').val();
				$.ajax({
					url: '<?php echo site_url("student/semester_result_ajax") ?>',
					type: 'post',
					data: {
						'session_id': session_id,
						'semester_id': semester_id,
					},
					dataType: "json",

					success: function(response) {
						renderSemesterPage(response);
						//$("#render").show();
						console.log(response)
					}
				});
			});

			function renderSemesterPage(response) {
				$('#render').html(response.render);
			}
			$(document).on('click', '#request', function(e) {
				//var obj = $(this);
				var submitButton = document.querySelector('#request');
				e.preventDefault();
				var session_id = $('#session_id').val();
				var semester_id = $('#semester_id').val();
				$.ajax({
					url: '<?php echo site_url("student/semester_result_ajax") ?>',
					type: 'post',
					data: {
						'session_id': session_id,
						'semester_id': semester_id,
					},
					dataType: "json",
					beforeSend: function() {
						submitButton.setAttribute('data-kt-indicator', 'on');
						submitButton.disabled = true;
					},

					success: function(response) {
						renderSemesterPage(response);
						//$("#render").show();
						//console.log(response)
					},

					complete: function() {
						submitButton.removeAttribute('data-kt-indicator');
						submitButton.disabled = false;
					}
				});

			})
		</script>



	<?php } else { ?>
	

	<?php } ?>
	<script type="text/javascript">
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

			$('#adform_button').on('click', function(e) {
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

		});

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

		/* $("#table tr").click(function() {
			$(this).toggleClass('selected');
			var value = $(this).find('td:first').html();
			alert(value);
		});

		$('.ok').on('click', function(e) {
			var selected = [];
			$("#table tr.selected").each(function() {
				selected.push($('td:first', this).html());
			});
			alert(selected);
		}); */
		//	}
	</script>
	<script type="text/javascript">
		<?php if ($this->session->flashdata('success')) { ?> toastr.success("<?php echo $this->session->flashdata('success'); ?>");
		<?php } else if ($this->session->flashdata('error')) { ?> toastr.error("<?php echo $this->session->flashdata('error'); ?>");
		<?php } else if ($this->session->flashdata('warning')) { ?> toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
		<?php } else if ($this->session->flashdata('info')) { ?> toastr.info("<?php echo $this->session->flashdata('info'); ?>");
		<?php } ?>
	</script>