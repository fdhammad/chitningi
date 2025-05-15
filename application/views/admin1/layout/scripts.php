<?php if ($page_name == "settings") { ?>

	<script type="text/javascript">
		$(document).ready(function() {

			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#setting');
				var subsubmit_button = document.querySelector('#setting_button');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/settings/update') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',


						beforeSend: function() {
							console.log(form.method);
							console.log(form.action);
							console.log($(form).serializeArray());
							/* submitButton.setAttribute('data-kt-indicator', 'on');
							submitButton.disabled = true; */
							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(response) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(response);

							///alert('It works');
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */
								//form.reset();
								//window.location.replace('<?= base_url('applicant/dashboard'); ?>');

							} else {
								toastr.error("" + response.notification + "");
							}
							//console.log()
							/* var redirectUrl = form.getAttribute('data-redirect-url');
	 					if (redirectUrl) {
	 						window.location.href = redirectUrl;
	 					}
 */
						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},

						//ee

						complete: function() {
							subsubmit_button.innerText = 'Submit';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>
	<script type="text/javascript">
		$('#favicon').on('submit', function(e) {
			var formData = new FormData(document.getElementById('favicon'));
			var submit_button = document.querySelector('#favicon_button');

			e.preventDefault();

			$.ajax({
				url: '<?= base_url('admin/settings/favicon') ?>',
				method: "POST",
				data: new FormData(this),
				contentType: false,
				cache: true,
				processData: false,
				beforeSend: function() {
					//console.log(form.method);
					//console.log(form.action);
					console.log(formData);

					submit_button.innerText = 'Loading ...';
					submit_button.disabled = true;

				},
				success: function(data) {
					//$('#answers').html(response);
					var response = JSON.parse(data)
					console.log(data);
					if (response.status == true) {
						toastr.success("" + response.notification + "");
						//$('#alert').html(' <div role="alert" class="alert alert-success"><strong>Success!</strong> Profile Updated successfully. </div>')

					} else {
						toastr.error("" + response.notification + "");
					}
				},
				error: function(xhr, ajaxOptions, throwError) {
					//console.log(xhr);
					toastr.error("Unknown Error");
				},


				complete: function() {
					submit_button.innerText = 'Save';
					submit_button.disabled = false;
				}
			});

			//alert('It works')
		})
	</script>
<?php } elseif ($page_name == "sessions") { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script>


	<script>
		$(document).ready(function() {
			var SITEURL = '<?php echo base_url(); ?>';
			$('#create-new-product').click(function() {
				$('#btn-save').val("create-product");
				$('#id').val('');
				$('#productForm').trigger("reset");
				$('#productCrudModal').html("Add New Product");
				$('#ajax-product-modal').modal('show');
			});

			/* When click edit user */

			$('body').on('click', '.edit-product', function() {

				var id = $(this).data("id");

				//console.log(id);

				$.ajax({
					type: "Post",
					url: SITEURL + "admin/sessions/get_by_id",
					data: {
						id: id
					},
					dataType: "json",
					success: function(res) {
						if (res.success == true) {
							//$('#amount-error').hide();
							//$('#status-error').hide();
							$('#productCrudModal').html("Edit Session");
							$('#btn-save').val("edit-product");
							$('#ajax-product-modal').modal('show');
							$('#modal_id').val(res.data.id);
							$('#modal_session').val(res.data.session);
							//$('#modal_code').val(res.data.code);

						}
					},
					error: function(data) {
						/* swal({
							type: 'error',
							title: 'Oops...',
							text: data,
							padding: '2em'
						}) */
						toastr.error("Unknown Error");
					}
				});
			});

			if ($("#productForm").length > 0) {
				$("#productForm").validate({
					submitHandler: function(form) {
						var actionType = $('#btn-save').val();
						$('#btn-save').html('Sending..');

						$.ajax({
							data: $('#productForm').serializeArray(),
							url: SITEURL + "admin/sessions/update",
							type: "POST",
							dataType: 'json',

							/* beforeSend: function() {
								console.log($('#productForm').serializeArray());
							}, */
							success: function(res) {
								$('#productForm').trigger("reset");
								$('#ajax-product-modal').modal('hide');
								$('#btn-save').html('Save Changes');

								$('#td_session-' + res.data.id).html(res.data.session);
								//$('#td_code-' + res.data.id).html(res.data.code);
								/* $('#productForm').reset(); */
								toastr.success("Session Edited successfully");
							},
							error: function(data) {
								toastr.error("Unknown Error");
								$('#btn-save').html('Save Changes');
							}

						});
						//window.location.reload();
					}
				})
			}

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {

						$(btn).closest('tr').fadeOut("slow");
						toastr.success("Deleted successfully");
					},
					error: function(response) {
						alert("Error");
						toastr.error("Unknown Error");
					}
				})
				//window.location.reload();
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#session');
				var subsubmit_button = document.querySelector('#session_button');

				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/sessions/add') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',

						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							//console.log($(form).serializeArray());

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(response) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(response);

							///alert('It works');
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */
								form.reset();
								window.location.reload();
							} else {
								toastr.error("" + response.notification + "");
							}
							//$('#myTable tr:last').after('<tr>' + $('#session').val() + '</tr>');

						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>
<?php } elseif ($page_name == "semesters") { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#semester');
				var subsubmit_button = document.querySelector('#semester_button');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/semesters/add') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',

						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							//console.log($(form).serializeArray());

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(response) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(response);

							///alert('It works');
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */
								form.reset();
								window.location.reload();
							} else {
								toastr.error("" + response.notification + "");
							}

						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>

	<script>
		$(document).ready(function() {
			var SITEURL = '<?php echo base_url(); ?>';
			$('#create-new-product').click(function() {
				$('#btn-save').val("create-product");
				$('#id').val('');
				$('#productForm').trigger("reset");
				$('#productCrudModal').html("Add New Product");
				$('#ajax-product-modal').modal('show');
			});

			/* When click edit user */

			$('body').on('click', '.edit-product', function() {

				var id = $(this).data("id");

				//console.log(id);

				$.ajax({
					type: "Post",
					url: SITEURL + "admin/semesters/get_by_id",
					data: {
						id: id
					},
					dataType: "json",
					success: function(res) {
						if (res.success == true) {
							//$('#amount-error').hide();
							//$('#status-error').hide();
							$('#productCrudModal').html("Edit Semester");
							$('#btn-save').val("edit-product");
							$('#ajax-product-modal').modal('show');
							$('#modal_id').val(res.data.id);
							$('#modal_semester').val(res.data.semester);
							//$('#modal_code').val(res.data.code);

						}
					},
					error: function(data) {
						/* swal({
							type: 'error',
							title: 'Oops...',
							text: data,
							padding: '2em'
						}) */
						toastr.error("Unknown Error");
					}
				});
			});

			if ($("#productForm").length > 0) {
				$("#productForm").validate({
					submitHandler: function(form) {
						var actionType = $('#btn-save').val();
						$('#btn-save').html('Sending..');

						$.ajax({
							data: $('#productForm').serializeArray(),
							url: SITEURL + "admin/semesters/update",
							type: "POST",
							dataType: 'json',

							/* beforeSend: function() {
								console.log($('#productForm').serializeArray());
							}, */
							success: function(res) {
								$('#productForm').trigger("reset");
								$('#ajax-product-modal').modal('hide');
								$('#btn-save').html('Save Changes');

								$('#td_semester-' + res.data.id).html(res.data.semester);
								//$('#td_code-' + res.data.id).html(res.data.code);
								/* $('#productForm').reset(); */
								toastr.success("Semester Edited successfully");
							},
							error: function(data) {
								toastr.error("Unknown Error");
								$('#btn-save').html('Save Changes');
							}

						});
						//window.location.reload();
					}
				})
			}

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {

						$(btn).closest('tr').fadeOut("slow");
						toastr.success("Deleted successfully");
					},
					error: function(response) {
						alert("Error");
						toastr.error("Unknown Error");
					}
				})
				//window.location.reload();
			});
		});
	</script>
<?php } elseif ($page_name == "classes") { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#class');
				var subsubmit_button = document.querySelector('#class_button');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/classes/add') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',

						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							//console.log($(form).serializeArray());

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(response) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(response);

							///alert('It works');
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */
								form.reset();
								window.location.reload();
							} else {
								toastr.error("" + response.notification + "");
							}

						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>

	<script>
		$(document).ready(function() {
			var SITEURL = '<?php echo base_url(); ?>';
			$('#create-new-product').click(function() {
				$('#btn-save').val("create-product");
				$('#id').val('');
				$('#productForm').trigger("reset");
				$('#productCrudModal').html("Add New Product");
				$('#ajax-product-modal').modal('show');
			});

			/* When click edit user */

			$('body').on('click', '.edit-product', function() {

				var id = $(this).data("id");

				//console.log(id);

				$.ajax({
					type: "Post",
					url: SITEURL + "admin/classes/get_by_id",
					data: {
						id: id
					},
					dataType: "json",
					success: function(res) {
						if (res.success == true) {
							//$('#amount-error').hide();
							//$('#status-error').hide();
							$('#productCrudModal').html("Edit class");
							$('#btn-save').val("edit-product");
							$('#ajax-product-modal').modal('show');
							$('#modal_id').val(res.data.id);
							$('#modal_class').val(res.data.class);
							//$('#modal_code').val(res.data.code);

						}
					},
					error: function(data) {
						/* swal({
							type: 'error',
							title: 'Oops...',
							text: data,
							padding: '2em'
						}) */
						toastr.error("Unknown Error");
					}
				});
			});

			if ($("#productForm").length > 0) {
				$("#productForm").validate({
					submitHandler: function(form) {
						var actionType = $('#btn-save').val();
						$('#btn-save').html('Sending..');

						$.ajax({
							data: $('#productForm').serializeArray(),
							url: SITEURL + "admin/classes/update",
							type: "POST",
							dataType: 'json',

							/* beforeSend: function() {
								console.log($('#productForm').serializeArray());
							}, */
							success: function(res) {
								$('#productForm').trigger("reset");
								$('#ajax-product-modal').modal('hide');
								$('#btn-save').html('Save Changes');

								$('#td_class-' + res.data.id).html(res.data.class);
								//$('#td_code-' + res.data.id).html(res.data.code);
								/* $('#productForm').reset(); */
								toastr.success("Level Edited successfully");
							},
							error: function(data) {
								toastr.error("Unknown Error");
								$('#btn-save').html('Save Changes');
							}

						});
						//window.location.reload();
					}
				})
			}

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {

						$(btn).closest('tr').fadeOut("slow");
						toastr.success("Deleted successfully");
					},
					error: function(response) {
						alert("Error");
						toastr.error("Unknown Error");
					}
				})
				//window.location.reload();
			});
		});
	</script>
<?php } elseif ($page_name == "schools") { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#school');
				var subsubmit_button = document.querySelector('#school_button');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/schools/add') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',

						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							console.log($(form).serializeArray());

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(response) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(response);

							///alert('It works');
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */
								form.reset();
								window.location.reload();
							} else {
								toastr.error("" + response.notification + "");
							}

						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>
	<script>
		$(document).ready(function() {
			var SITEURL = '<?php echo base_url(); ?>';
			$('#create-new-product').click(function() {
				$('#btn-save').val("create-product");
				$('#id').val('');
				$('#productForm').trigger("reset");
				$('#productCrudModal').html("Add New Product");
				$('#ajax-product-modal').modal('show');
			});

			/* When click edit user */

			$('body').on('click', '.edit-product', function() {

				var id = $(this).data("id");

				//console.log(id);

				$.ajax({
					type: "Post",
					url: SITEURL + "admin/schools/get_by_id",
					data: {
						id: id
					},
					dataType: "json",
					success: function(res) {
						if (res.success == true) {
							//$('#amount-error').hide();
							//$('#status-error').hide();
							$('#productCrudModal').html("Edit School");
							$('#btn-save').val("edit-product");
							$('#ajax-product-modal').modal('show');
							$('#modal_id').val(res.data.id);
							$('#modal_school').val(res.data.school);
							$('#modal_code').val(res.data.code);

						}
					},
					error: function(data) {
						/* swal({
							type: 'error',
							title: 'Oops...',
							text: data,
							padding: '2em'
						}) */
						toastr.error("Unknown Error");
					}
				});
			});

			if ($("#productForm").length > 0) {
				$("#productForm").validate({
					submitHandler: function(form) {
						var actionType = $('#btn-save').val();
						$('#btn-save').html('Sending..');

						$.ajax({
							data: $('#productForm').serializeArray(),
							url: SITEURL + "admin/schools/update",
							type: "POST",
							dataType: 'json',

							/* beforeSend: function() {
								console.log($('#productForm').serializeArray());
							}, */
							success: function(res) {
								$('#productForm').trigger("reset");
								$('#ajax-product-modal').modal('hide');
								$('#btn-save').html('Save Changes');

								$('#td_school-' + res.data.id).html(res.data.school);
								$('#td_code-' + res.data.id).html(res.data.code);
								/* $('#productForm').reset(); */
								toastr.success("School Edited successfully");
							},
							error: function(data) {
								toastr.error("Unknown Error");
								$('#btn-save').html('Save Changes');
							}

						});
						//window.location.reload();
					}
				})
			}

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {

						$(btn).closest('tr').fadeOut("slow");
						toastr.success("Deleted successfully");
					},
					error: function(response) {
						alert("Error");
						toastr.error("Unknown Error");
					}
				})
				//window.location.reload();
			});
		});
	</script>


<?php } elseif ($page_name == "subjects") { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#subject');
				var subsubmit_button = document.querySelector('#subject_button');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/subjects/add') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',

						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							console.log($(form).serializeArray());

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(res) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(res);

							///alert('It works');
							if (res.status == true) {
								toastr.success("" + res.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */

								$('#basic tr:last').after('<tr><td id="td_name-' + res.data.id + '">' + res.data.name + '</td><td id="td_code-' + res.data.id + '">' + res.data.code + '</td><td id="td_status-' + res.data.id + '">' + res.data.status + '</td><td id="td_unit-' + res.data.id + '">' + res.data.unit + '</td><td id="td_course-' + res.data.id + '">' + res.data.course + '</td><td id="td_class-' + res.data.id + '">' + res.data.class + '</td><td id="td_semester-' + res.data.id + '">' + res.data.semester + '</td><td class="text-right"><a href="javascript:void(0)" data-id="' + res.data.id + '" id="' + res.data.id + '" class="edit-product" data-toggle="tooltip" title="Edit" data-original-title="Edit"> <i class ="icon-edit mr-3"> </i> </a> <a href = "<?php echo base_url(); ?>admin/subjects/delete/' + res.data.id + '"class = "delete" id = "' + res.data.id + '"data-toggle ="tooltip" title ="Delete" data-original-title = "Delete" ><i class = "text-danger icon icon-trash mr-3"> </i> </a></td></tr> ');
								form.reset();
								//window.location.reload();
							} else {
								toastr.error("" + res.notification + "");
							}

						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>
	<script>
		$(document).ready(function() {
			var SITEURL = '<?php echo base_url(); ?>';
			$('#create-new-product').click(function() {
				$('#btn-save').val("create-product");
				$('#id').val('');
				$('#productForm').trigger("reset");
				$('#productCrudModal').html("Add New Product");
				$('#ajax-product-modal').modal('show');
			});

			/* When click edit user */

			$('body').on('click', '.edit-product', function() {

				var id = $(this).data("id");

				//console.log(id);

				$.ajax({
					type: "Post",
					url: SITEURL + "admin/subjects/get_by_id",
					data: {
						id: id
					},
					dataType: "json",
					success: function(res) {
						if (res.success == true) {
							//$('#amount-error').hide();
							//$('#status-error').hide();
							$('#productCrudModal').html("Edit Course");
							$('#btn-save').val("edit-product");
							$('#ajax-product-modal').modal('show');
							$('#modal_id').val(res.data.id);
							$('#modal_code').val(res.data.code);
							//$('#modal_school_id').val(res.data.school_id);
							$('#modal_name').val(res.data.name);
							$('#modal_unit').val(res.data.unit);
							//Var YouValue = "100";
							$("#modal_class_id > [value=" + res.data.class_id + "]").attr("selected", "true");
							$("#modal_semester_id > [value=" + res.data.semester_id + "]").attr("selected", "true");
							$("#modal_course_id > [value=" + res.data.course_id + "]").attr("selected", "true");

						}
					},
					error: function(data) {
						/* swal({
							type: 'error',
							title: 'Oops...',
							text: data,
							padding: '2em'
						}) */
						toastr.error("Unknown Error");
					}
				});
			});

			if ($("#productForm").length > 0) {
				$("#productForm").validate({
					submitHandler: function(form) {
						var actionType = $('#btn-save').val();
						$('#btn-save').html('Sending..');

						$.ajax({
							data: $('#productForm').serializeArray(),
							url: SITEURL + "admin/subjects/update",
							type: "POST",
							dataType: 'json',

							/* beforeSend: function() {
								console.log($('#productForm').serializeArray());
							}, */
							success: function(res) {
								$('#productForm').trigger("reset");
								$('#ajax-product-modal').modal('hide');
								$('#btn-save').html('Save Changes');

								$('#td_semester-' + res.data.id).html(res.data.semester);
								$('#td_name-' + res.data.id).html(res.data.name);
								$('#td_code-' + res.data.id).html(res.data.code);
								$('#td_unit-' + res.data.id).html(res.data.unit);
								$('#td_status-' + res.data.id).html(res.data.status);
								$('#td_class-' + res.data.id).html(res.data.class);
								$('#td_course-' + res.data.id).html(res.data.course);
								/* $('#productForm').reset(); */
								toastr.success("Course Edited successfully");
							},
							error: function(data) {
								toastr.error("Unknown Error");
								$('#btn-save').html('Save Changes');
							}

						});
						//window.location.reload();
					}
				})
			}

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {

						$(btn).closest('tr').fadeOut("slow");
						toastr.success("Deleted successfully");
					},
					error: function(response) {
						alert("Error");
						toastr.error("Unknown Error");
					}
				})
				//window.location.reload();
			});
		});
	</script>
<?php } elseif ($page_name == "courses") { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#course');
				var subsubmit_button = document.querySelector('#course_button');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/courses/add') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',

						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							console.log($(form).serializeArray());

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(response) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(response);

							///alert('It works');
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */
								form.reset();
								window.location.reload();
							} else {
								toastr.error("" + response.notification + "");
							}

						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>
	<script>
		$(document).ready(function() {
			var SITEURL = '<?php echo base_url(); ?>';
			$('#create-new-product').click(function() {
				$('#btn-save').val("create-product");
				$('#id').val('');
				$('#productForm').trigger("reset");
				$('#productCrudModal').html("Add New Product");
				$('#ajax-product-modal').modal('show');
			});

			/* When click edit user */

			$('body').on('click', '.edit-product', function() {

				var id = $(this).data("id");

				//console.log(id);

				$.ajax({
					type: "Post",
					url: SITEURL + "admin/courses/get_by_id",
					data: {
						id: id
					},
					dataType: "json",
					success: function(res) {
						if (res.success == true) {
							//$('#amount-error').hide();
							//$('#status-error').hide();
							$('#productCrudModal').html("Edit Course");
							$('#btn-save').val("edit-product");
							$('#ajax-product-modal').modal('show');
							$('#modal_id').val(res.data.id);
							$('#modal_school').val(res.data.school);
							//$('#modal_school_id').val(res.data.school_id);
							$('#modal_name').val(res.data.name);
							$('#modal_code').val(res.data.code);
							$('#modal_year').val(res.data.year);
							//Var YouValue = "100";

							$("#modal_school_id > [value=" + res.data.school_id + "]").attr("selected", "true");
							$("#modal_department_id > [value=" + res.data.department_id + "]").attr("selected", "true");

						}
					},
					error: function(data) {
						/* swal({
							type: 'error',
							title: 'Oops...',
							text: data,
							padding: '2em'
						}) */
						toastr.error("Unknown Error");
					}
				});
			});

			if ($("#productForm").length > 0) {
				$("#productForm").validate({
					submitHandler: function(form) {
						var actionType = $('#btn-save').val();
						$('#btn-save').html('Sending..');

						$.ajax({
							data: $('#productForm').serializeArray(),
							url: SITEURL + "admin/courses/update",
							type: "POST",
							dataType: 'json',

							/* beforeSend: function() {
								console.log($('#productForm').serializeArray());
							}, */
							success: function(res) {
								$('#productForm').trigger("reset");
								$('#ajax-product-modal').modal('hide');
								$('#btn-save').html('Save Changes');

								$('#td_school-' + res.data.id).html(res.data.school);
								$('#td_name-' + res.data.id).html(res.data.name);
								$('#td_code-' + res.data.id).html(res.data.code);
								$('#td_year-' + res.data.id).html(res.data.year);
								$('#td_department-' + res.data.id).html(res.data.department);
								/* $('#productForm').reset(); */
								toastr.success("Course Edited successfully");
							},
							error: function(data) {
								toastr.error("Unknown Error");
								$('#btn-save').html('Save Changes');
							}

						});
						//window.location.reload();
					}
				})
			}

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {

						$(btn).closest('tr').fadeOut("slow");
						toastr.success("Deleted successfully");
					},
					error: function(response) {
						alert("Error");
						toastr.error("Unknown Error");
					}
				})
				//window.location.reload();
			});
		});
	</script>
	<script type="text/javascript">
		function getDep(school_id, department_id) {
			if (school_id != "" && department_id != "") {
				$('#department_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getBySchool",
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
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
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
			var department_id = '<?php echo set_value('department_id') ?>';
			getDep(school_id, department_id);
			$(document).on('change', '#school_id', function(e) {
				$('#department_id').html("");
				var school_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getBySchool",
					data: {
						'school_id': school_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#department_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
						});
						$('#department_id').append(div_data);
					},
					complete: function() {
						$('#department_id').removeClass('dropdownloading');
					}
				});
			});
		});
	</script>
	<script type="text/javascript">
		function getModalDep(school_id, department_id) {
			if (school_id != "" && department_id != "") {
				$('#modal_department_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getBySchool",
					data: {
						'modal_school_id': school_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#modal_department_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (department_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#modal_department_id').append(div_data);
					},
					complete: function() {
						$('#modal_department_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var school_id = $('#modal_school_id').val();
			var department_id = '<?php echo set_value('modal_department_id') ?>';
			getModalDep(school_id, department_id);
			$(document).on('change', '#school_id', function(e) {
				$('#modal_department_id').html("");
				var school_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getBySchool",
					data: {
						'modal_school_id': school_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#modal_department_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
						});
						$('#modal_department_id').append(div_data);
					},
					complete: function() {
						$('#modal_department_id').removeClass('dropdownloading');
					}
				});
			});
		});
	</script>



<?php } elseif ($page_name == "subjects") { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#department');
				var subsubmit_button = document.querySelector('#department_button');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/subjects/add') ?>',
						type: form.method,
						data: $(form).serializeArray(), //$(form).serialize(),
						dataType: 'JSON',

						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							console.log($(form).serializeArray());

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;

						},
						success: function(response) {
							//$('#answers').html(response);
							//var obj = JSON.parse(response)
							console.log(response);

							///alert('It works');
							if (response.status == true) {
								toastr.success("" + response.notification + "");
								/* 	Swal.fire({
										text: "Registration successful!",
										icon: "success",
										timer: 1500,
									}) */
								form.reset();
								window.location.reload();
							} else {
								toastr.error("" + response.notification + "");
							}

						},
						error: function(xhr, ajaxOptions, throwError) {
							console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>
	<script>
		$(document).ready(function() {
			var SITEURL = '<?php echo base_url(); ?>';
			$('#create-new-product').click(function() {
				$('#btn-save').val("create-product");
				$('#id').val('');
				$('#productForm').trigger("reset");
				$('#productCrudModal').html("Add New Product");
				$('#ajax-product-modal').modal('show');
			});

			/* When click edit user */

			$('body').on('click', '.edit-product', function() {

				var id = $(this).data("id");

				//console.log(id);

				$.ajax({
					type: "Post",
					url: SITEURL + "admin/subjects/get_by_id",
					data: {
						id: id
					},
					dataType: "json",
					success: function(res) {
						if (res.success == true) {
							//$('#amount-error').hide();
							//$('#status-error').hide();
							$('#productCrudModal').html("Edit Department");
							$('#btn-save').val("edit-product");
							$('#ajax-product-modal').modal('show');
							$('#modal_id').val(res.data.id);
							$('#modal_school').val(res.data.school);
							//$('#modal_school_id').val(res.data.school_id);
							$('#modal_name').val(res.data.name);
							//Var YouValue = "100";

							$("#modal_school_id > [value=" + res.data.school_id + "]").attr("selected", "true");

						}
					},
					error: function(data) {
						/* swal({
							type: 'error',
							title: 'Oops...',
							text: data,
							padding: '2em'
						}) */
						toastr.error("Unknown Error");
					}
				});
			});

			if ($("#productForm").length > 0) {
				$("#productForm").validate({
					submitHandler: function(form) {
						var actionType = $('#btn-save').val();
						$('#btn-save').html('Sending..');

						$.ajax({
							data: $('#productForm').serializeArray(),
							url: SITEURL + "admin/subjects/update",
							type: "POST",
							dataType: 'json',

							/* beforeSend: function() {
								console.log($('#productForm').serializeArray());
							}, */
							success: function(res) {
								$('#productForm').trigger("reset");
								$('#ajax-product-modal').modal('hide');
								$('#btn-save').html('Save Changes');

								$('#td_school-' + res.data.id).html(res.data.school);
								$('#td_name-' + res.data.id).html(res.data.name);
								/* $('#productForm').reset(); */
								toastr.success("Department Edited successfully");
							},
							error: function(data) {
								toastr.error("Unknown Error");
								$('#btn-save').html('Save Changes');
							}

						});
						//window.location.reload();
					}
				})
			}

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {

						$(btn).closest('tr').fadeOut("slow");
						toastr.success("Deleted successfully");
					},
					error: function(response) {
						alert("Error");
						toastr.error("Unknown Error");
					}
				})
				//window.location.reload();
			});
		});
	</script>
<?php } elseif ($page_name == "students/create") { ?>
	<!-- <script type="text/javascript">
		$(document).ready(function(e) {
			$('.edit-product').on("click", function() {
				$('#ajax-product-modal').modal('show');
			});
		});
	</script> -->
	<script type="text/javascript">
		$(document).ready(function() {

			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#student_add');
				var formData = new FormData(document.getElementById('student_add'));
				var subsubmit_button = document.querySelector('#btn_save');
				var drEvent = $('#image').dropify();
				drEvent = drEvent.data('dropify');
				$('#alert').html('');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/students/add') ?>',
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
								form.reset();
								drEvent.resetPreview();
								drEvent.clearElement();
								$('#alert').html(' <div role="alert" class="alert alert-success"><strong>Success!</strong> New User Added successfully. </div>')
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
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>

	<script type="text/javascript">
		function getCourse(department_id, course_id) {
			if (department_id != "" && course_id != "") {
				$('#course_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (course_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var department_id = $('#department_id').val();
			var course_id = '<?php echo set_value('course_id') ?>';
			getCourse(department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
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
		function getLGA(state_id, local_government_id) {
			if (state_id != "" && local_government_id != "") {
				$('#local_government_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
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
			var local_government_id = '<?php echo set_value('local_government_id') ?>';
			getLGA(state_id, local_government_id);
			$(document).on('change', '#state_id', function(e) {
				$('#local_government_id').html("");
				var state_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/students/getByLocal",
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
		});
	</script>
<?php } elseif ($page_name == "students/search") { ?>
	<script type="text/javascript">
		function getCourse(department_id, course_id) {
			if (department_id != "" && course_id != "") {
				$('#course_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (course_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var department_id = $('#department_id').val();
			var course_id = '<?php echo set_value('course_id') ?>';
			getCourse(department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
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

	<script type='text/javascript'>
		$(document).ready(function() {

			$("#show").click(function() {
				//$(".response").hide();
				var class_id = $('#class_id').val();
				var department_id = $('#department_id').val();
				var course_id = $('#course_id').val();
				//var search_text = $('#search_text').val();
				//if ($.trim($('#department_id').val()) == '') {
				//	alert('School Field can not be left blank');
				//} else if ($.trim($('#class_id').val()) == '') {
				//	alert('Level Field can not be left blank');
				//} else if ($.trim($('#course_id').val()) == '') {
				//	alert('Course Field can not be left blank');
				//	} else {
				$.ajax({
					url: '<?php echo base_url('admin/students/search_ajax'); ?>',
					type: 'post',
					data: {
						'department_id': department_id,
						'course_id': course_id,
						'class_id': class_id
					},
					beforeSend: function() {
						// Show image container
						//$("div[id='searchDiv']").html('<button id="show" value="search_filter" class="btn btn-primary r-20 pull-right" disabled><i class="icon icon-spinner icon-spin"></i>  Loading...</button>');

						$("#loader").show();
						$("#response").hide();

					},
					success: function(data) {

						var response = JSON.parse(data);
						$("#loader").hide();
						$("#response").show();
						renderLoder(response);
						//$("div[id='searchDiv']").html('<button type="button" id="show" value="search_filter" class="btn btn-primary r-20 pull-right"><i class="icon icon-search"></i> Search</button>');

					}
					/* complete: function(data) {

						// Hide image container
						$("#loader").hide();
						$("#response").show();
						
							//$("#v-pills-tabContent").hide();
						}*/
				});
				//}

			});

		});

		function renderLoder(response) {
			$('#response').html(response.render);
			$('#basic').DataTable({
				"aaSorting": [],

				rowReorder: {
					selector: 'td:nth-child(2)'
				},
				pageLength: 100,
				//responsive: 'true',
				//paging: false,
				dom: "Bfrtip",
				buttons: [

					/* {
						extend: 'copy',
						text: '<i class="icon icon-copy"></i>',
						titleAttr: 'Copy',
						title: $('.download_label').html(),
						exportOptions: {
							columns: 'th:not(:last-child)'
						}
					}, */

					{
						extend: 'excel',
						text: '<i class="icon icon-file-excel-o"></i>Excel',
						titleAttr: 'Excel',

						title: $('.download_label').html(),
						exportOptions: {
							columns: 'th:not(:last-child)'
						}
					},

					/* 	{
							extend: 'csv',
							text: '<i class="icon icon-file-code-o"></i>',
							titleAttr: 'CSV',
							title: $('.download_label').html(),
							exportOptions: {
								columns: 'th:not(:last-child)'
							}
						}, */

					/* 	{
							extend: 'pdf',
							text: '<i class="icon icon-file-pdf-o"></i>',
							titleAttr: 'PDF',
							title: $('.download_label').html(),
							exportOptions: {
								columns: 'th:not(:last-child)'

							}
						}, */

					{
						extend: 'print',
						text: '<i class="icon icon-print"></i>Print',
						titleAttr: 'Print',
						title: $('.download_label').html(),
						customize: function(win) {
							$(win.document.body)
								.css('font-size', '10pt');

							$(win.document.body).find('table')
								.addClass('compact')
								.css('font-size', 'inherit');

						},
						exportOptions: {
							columns: 'th:not(:last-child)'
						}
					},



					/* 	{
							extend: 'pageLength',
							//text: '<i class="icon-columns"></i>',
							titleAttr: 'Number of Rows',
							className: 'selectTable'
						} */
				]
			})

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
					url: "<?php echo site_url('admin/students/delete'); ?>",
					cache: false,
					data: {
						id: $(this).attr("id")
					},
					success: function(data) {
						//('#alert').html('<div class="toast" data-title="Success! "data-message="Course Added Successfully." data-type="success"></div>');
						// success(data.toast);
						//$('.data-tables').dataTable().ajax.reload();
						obj.closest('tr').remove();
						alert('Student Deleted Successfully');
						//window.location.reload();

					}
				});
			});

		}
	</script>
<?php } elseif ($page_name == "students/edit") { ?>
	<script type="text/javascript">
		function getDept(department_id, course_id) {
			if (department_id != "" && course_id != "") {
				$('#course_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (course_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var department_id = $('#department_id').val();
			var course_id = '<?php echo set_value('course_id', $student['course_id']) ?>';
			getDept(department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
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
		function getLocal(state_id, local_government_id) {
			if (state_id != "" && local_government_id != "") {
				$('#local_government_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/students/getByLocal",
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
					url: base_url + "admin/students/getByLocal",
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
				var form = document.querySelector('#student_edit');
				var formData = new FormData(document.getElementById('student_edit'));
				var subsubmit_button = document.querySelector('#btn_save');
				var drEvent = $('#image').dropify();
				drEvent = drEvent.data('dropify');
				$('#alert').html('');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/students/update') ?>',
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
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>

<?php } elseif ($page_name == "staff/edit") { ?>
	<script type="text/javascript">
		function getDept(department_id, course_id) {
			if (department_id != "" && course_id != "") {
				$('#course_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (course_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var department_id = $('#department_id').val();
			var course_id = '<?php echo set_value('department_id', $staff['department_id']) ?>';
			getDept(department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
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
		function getLocal(state_id, local_government_id) {
			if (state_id != "" && local_government_id != "") {
				$('#local_government_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/students/getByLocal",
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
			var local_government_id = '<?php echo set_value('local_government_id', $staff['local_government_id']) ?>';
			getLocal(state_id, local_government_id);
			$(document).on('change', '#state_id', function(e) {
				$('#local_government_id').html("");
				var state_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/students/getByLocal",
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
				var formData = new FormData(document.getElementById('staff_edit'));
				var subsubmit_button = document.querySelector('#staff_edit_button');
				var drEvent = $('#image').dropify();
				drEvent = drEvent.data('dropify');
				$('#alert').html('');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/staff/update') ?>',
						method: "POST",
						data: new FormData(this),
						contentType: false,
						cache: true,
						processData: false,
						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							//console.log(formData);

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
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>

<?php } elseif ($page_name == "staff/create") { ?>
	<script type="text/javascript">
		function getDept(department_id, course_id) {
			if (department_id != "" && course_id != "") {
				$('#course_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (course_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var department_id = $('#department_id').val();
			var course_id = '<?php echo set_value('department_id') ?>';
			getDept(department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
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
		function getLocal(state_id, local_government_id) {
			if (state_id != "" && local_government_id != "") {
				$('#local_government_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/students/getByLocal",
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
			var local_government_id = '<?php echo set_value('local_government_id') ?>';
			getLocal(state_id, local_government_id);
			$(document).on('change', '#state_id', function(e) {
				$('#local_government_id').html("");
				var state_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo get_phrase('select'); ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/students/getByLocal",
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
				var form = document.querySelector('#staff_create');
				var formData = new FormData(document.getElementById('staff_create'));
				var subsubmit_button = document.querySelector('#staff_create_button');
				var drEvent = $('#image').dropify();
				drEvent = drEvent.data('dropify');
				$('#alert').html('');
				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else if (document.getElementById("password").value != document.getElementById("password_confirm").value) {
					alert("Password mismatch");
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/staff/add') ?>',
						method: "POST",
						data: new FormData(this),
						contentType: false,
						cache: true,
						processData: false,
						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							//console.log(formData);

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
								form.reset();
								drEvent.resetPreview();
								drEvent.clearElement();
								$('#alert').html(' <div role="alert" class="alert alert-success"><strong>Success!</strong> Profile Created successfully. </div>')
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
							subsubmit_button.innerText = 'Save';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});

		});
	</script>

<?php } elseif ($page_name == "applicants/search") { ?>
	<script type="text/javascript">
		function getCourse(department_id, course_id) {
			if (department_id != "" && course_id != "") {
				$('#course_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (course_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var department_id = $('#department_id').val();
			var course_id = '<?php echo set_value('course_id') ?>';
			getCourse(department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
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

	<script type='text/javascript'>
		function list() {
			$.ajax({
				url: '<?php echo base_url('admin/applicants/ajax'); ?>',
				type: 'post',
				data: {
					'id': '1',
				},

				success: function(data) {

					var response = JSON.parse(data);
					$("#loader").hide();
					$("#response").show();
					renderLoder(response);
					//$("div[id='searchDiv']").html('<button type="button" id="show" value="search_filter" class="btn btn-primary r-20 pull-right"><i class="icon icon-search"></i> Search</button>');

				}

			});
		}
		$(document).ready(function() {

			$("#show").click(function() {
				//$(".response").hide();

				var department_id = $('#department_id').val();
				var course_id = $('#course_id').val();
				//var search_text = $('#search_text').val();
				//if ($.trim($('#department_id').val()) == '') {
				//	alert('School Field can not be left blank');
				//} else if ($.trim($('#class_id').val()) == '') {
				//	alert('Level Field can not be left blank');
				//} else if ($.trim($('#course_id').val()) == '') {
				//	alert('Course Field can not be left blank');
				//	} else {
				$.ajax({
					url: '<?php echo base_url('admin/applicants/search_ajax'); ?>',
					type: 'post',
					data: {
						'department_id': department_id,
						'course_id': course_id,

					},
					beforeSend: function() {
						// Show image container
						//$("div[id='searchDiv']").html('<button id="show" value="search_filter" class="btn btn-primary r-20 pull-right" disabled><i class="icon icon-spinner icon-spin"></i>  Loading...</button>');

						$("#loader").show();
						$("#response").hide();

					},
					success: function(data) {

						var response = JSON.parse(data);
						$("#loader").hide();
						$("#response").show();
						renderLoder(response);
						//$("div[id='searchDiv']").html('<button type="button" id="show" value="search_filter" class="btn btn-primary r-20 pull-right"><i class="icon icon-search"></i> Search</button>');

					}
					/* complete: function(data) {

						// Hide image container
						$("#loader").hide();
						$("#response").show();
						
							//$("#v-pills-tabContent").hide();
						}*/
				});
				//}

			});

			return list();

		});

		function renderLoder(response) {
			$('#response').html(response.render);
			$('#basic').DataTable({
				"aaSorting": [],

				rowReorder: {
					selector: 'td:nth-child(2)'
				},
				pageLength: 100,
				//responsive: 'true',
				//paging: false,
				dom: "Bfrtip",
				buttons: [

					/* {
						extend: 'copy',
						text: '<i class="icon icon-copy"></i>',
						titleAttr: 'Copy',
						title: $('.download_label').html(),
						exportOptions: {
							columns: 'th:not(:last-child)'
						}
					}, */

					{
						extend: 'excel',
						text: '<i class="icon icon-file-excel-o"></i>Excel',
						titleAttr: 'Excel',

						title: $('.download_label').html(),
						exportOptions: {
							columns: 'th:not(:last-child)'
						}
					},

					 	{
							extend: 'csv',
							text: '<i class="icon icon-file-code-o"></i>',
							titleAttr: 'CSV',
							title: $('.download_label').html(),
							exportOptions: {
								columns: 'th:not(:last-child)'
							}
						}, 

					 	{
							extend: 'pdf',
							text: '<i class="icon icon-file-pdf-o"></i>',
							titleAttr: 'PDF',
							title: $('.download_label').html(),
							exportOptions: {
								columns: 'th:not(:last-child)'

							}
						}, 

					{
						extend: 'print',
						text: '<i class="icon icon-print"></i>Print',
						titleAttr: 'Print',
						title: $('.download_label').html(),
						customize: function(win) {
							$(win.document.body)
								.css('font-size', '10pt');

							$(win.document.body).find('table')
								.addClass('compact')
								.css('font-size', 'inherit');

						},
						exportOptions: {
							columns: 'th:not(:last-child)'
						}
					},



					/* 	{
							extend: 'pageLength',
							//text: '<i class="icon-columns"></i>',
							titleAttr: 'Number of Rows',
							className: 'selectTable'
						} */
				]
			})

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
					url: "<?php echo site_url('admin/applicants/delete'); ?>",
					cache: false,
					data: {
						id: $(this).attr("id")
					},
					success: function(data) {
						//('#alert').html('<div class="toast" data-title="Success! "data-message="Course Added Successfully." data-type="success"></div>');
						// success(data.toast);
						//$('.data-tables').dataTable().ajax.reload();
						obj.closest('tr').remove();
						alert('Student Deleted Successfully');
						//window.location.reload();

					}
				});
			});

			function ConfirmAdmit() {
				var x = confirm("Are you sure you want to Admit this Applicant? This Process cant be undone");
				if (x)
					return true;
				else
					return false;
			}
			$(".admit").click(function(e) {
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmAdmit() == false) {
					return false;
				}
				var href = $(this).attr("href")
				var btn = this;

				$.ajax({
					type: "GET",
					url: href,
					success: function(response) {
						alert('Applicant admitted');

						//$(btn).closest('tr').fadeOut("slow");

					}
				})
				//event.preventDefault();
				window.location.reload();
			});

		}
	</script>
<?php } elseif ($page_name == "payments/manage_amount") { ?>

	<script type="text/javascript">
		$(document).ready(function() {
			//$("#loader").show();
			$("#department").hide();
			$("#course").hide();
			$("#class").hide();
			$("#semester").hide();
			$("#indigene_field").hide();
			//var category = $('#Category').val();
			$(document).on('change', '#payment_type', function(e) {
				if ($.trim($('#payment_type').val()) == 'application') {
					//$("#for_semester").hide();
					$("#department").hide();
					$("#course").hide();
					$("#class").hide();
					$("#semester").hide();
					$("#indigene_field").hide();
				} else if ($.trim($('#payment_type').val()) == 'pre_weeding') {
					//$("#class").hide("slow");
					$("#department").show("slow");
					$("#course").show("slow");
					$("#class").hide("slow");
					$("#semester").hide("slow");
					$("#indigene_field").hide();
				} else if ($.trim($('#payment_type').val()) == 'post_weeding') {
					$("#department").show("slow");
					$("#course").show("slow");
					$("#class").hide("slow");
					$("#semester").hide("slow");
					$("#indigene_field").hide("slow");
				} else if ($.trim($('#payment_type').val()) == 'semester') {
					$("#department").show("slow");
					$("#course").show("slow");
					$("#class").show("slow");
					$("#semester").show("slow");
					$("#indigene_field").show("slow");
				} else {
					$("#department").hide("slow");
					$("#course").hide("slow");
					$("#class").hide("slow");
					$("#semester").hide("slow");
					$("#indigene_field").hide("slow");
				}
			});


			/* 	$(document).on('change', '#school_id', function(e) {
					if ($.trim($('#school_id').val()) == '1') {
						//$("#for_semester").hide();
						$("#class").show("slow");
					} else {
						$("#class").hide("slow");
					}
				});
				$(document).on('change', '#school_id', function(e) {
					if ($.trim($('#school_id').val()) == '1') {
						$("#for_semester").show("slow");
						$("#class").show("slow");
					} else if ($.trim($('#school_id').val()) == '2' || $.trim($('#school_id').val()) == '3') {
						$("#for_semester").show("slow");
						$("#class").hide("slow");
					} else {
						$("#class").hide("slow");
						$("#for_semester").hide();
					}
				}); */
		})
	</script>

	<script type="text/javascript">
		$(function() {
			$(document).on("click", "#btnAdd", function() {
				var lenght_div = $('#TextBoxContainer .app').length;
				var div = GetDynamicTextBox(lenght_div);
				$("#TextBoxContainer").append(div);
			});
			$(document).on("click", "#btnGet", function() {
				var values = "";
				$("input[name=DynamicTextBox]").each(function() {
					values += $(this).val() + "\n";
				});
			});
			$("body").on("click", ".remove", function() {
				$(this).closest("div").remove();
			});
		});

		function GetDynamicTextBox(value) {
			var row = "";
			row += '<div class="form-group app">';
			row += '<input type="hidden" name="i[]" value="' + value + '"/>';
			row += '<input type="hidden" name="row_id_' + value + '" value="0"/>';
			row += '<div class="col-md-12">';
			row += '<div class="form-group row">';
			row += '<label for="inputValue" class="col-md-1 control-label">Item Name</label>';
			row += '<div class="col-md-3">';
			row += '<input type="text"  id="name' + value + '" name="name_' + value + '" " value="" class="form-control" >';

			row += '</div>';
			row += '<label for="inputKey" class="col-md-1 control-label">Amount</label>';

			row += '<div class="col-md-2">';
			row += '<input type="number"  id="amount' + value + '" name="amount_' + value + '" " value="" class="form-control" >';

			row += '</div>';

			row += '<label for="inputKey" class="col-md-1 control-label">Type</label>';

			row += '<div class="col-md-2">';
			row += '<select  id="type_' + value + '" name="type_' + value + '" class="form-control" >';
			row += '<option value=""><?php echo get_phrase('select'); ?></option>';
			<?php
			foreach ($tax as $key => $value) {
			?>
				row += '<option value="<?php echo $key; ?>" <?php if (set_value('type') == $key) echo "selected"; ?>> <?php echo $value; ?></option>';
			<?php

			}
			?>
			row += '</select>';
			row += '</div>';

			row += '<div class="col-md-2"><button id="btnRemove" style="" class="btn btn-sm btn-danger" type="button"><i class="icon icon-trash"></i></button></div>';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			return row;
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#btnAdd').hide();
			$(".assign_teacher_form").submit(function(e) {
				$("#TextBoxContainer").html("");
				$("input[class$='_error']").html("");
				var payment_type = $('#payment_type').val();
				var department_id = $('#department_id').val();
				var course_id = $('#course_id').val();
				var class_id = $('#class_id').val();
				var semester_id = $('#semester_id').val();
				var indigene = $('#indigene').val();
				var postData = $(this).serializeArray();
				var formURL = $(this).attr("action");
				$.ajax({
					url: formURL,
					type: "POST",
					data: postData,
					dataType: 'json',
					success: function(data, textStatus, jqXHR) {
						if (data.st === 1) {
							$.each(data.msg, function(key, value) {
								$('.' + key + "_error").html(value);
							});
						} else {
							var response = data.msg;
							if (response && response.length > 0) {
								for (i = 0; i < response.length; ++i) {
									var name = response[i].name;
									var amount = response[i].amount;
									var type = response[i].type;
									var row_id = response[i].id;
									appendRow(name, amount, type, row_id);
								}
							} else {
								appendRow(0, 0, 0);
							}
							$('#post_payment_type').val(payment_type);
							$('#post_department_id').val(department_id);
							$('#post_course_id').val(course_id);
							$('#post_class_id').val(class_id);
							$('#post_semester_id').val(semester_id);
							$('#post_indigene').val(indigene);
							$('#btnAdd').show();
							$('#box_display').show();
							$('.save_button').show();
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {}
				});

				e.preventDefault();

			});


		});

		function appendRow(name, amount, type, row_id) {
			var value = $('#TextBoxContainer .app').length;
			var row = "";
			row += '<div class="form-group app">';
			row += '<input type="hidden" name="i[]" value="' + value + '"/>';
			row += '<input type="hidden" name="row_id_' + value + '" value="' + row_id + '"/>';
			row += '<div class="col-md-12">';
			row += '<div class="form-group row">';
			row += '<label for="inputValue" class="col-md-1 control-label">Item name</label>';
			row += '<div class="col-md-3">';

			row += '<input type="text"  id="name' + value + '" name="name_' + value + '" " value="' + name + '" class="form-control" >';

			row += '</div>';
			row += '<label for="inputKey" class="col-md-1 control-label">Amount</label>';
			row += '<div class="col-md-2">';

			row += '<input type="number"  id="amount' + value + '" name="amount_' + value + '" " value="' + amount + '" class="form-control" >';


			row += '</div>';
			row += '<label for="inputKey" class="col-md-1 control-label">Type</label>';

			row += '<div class="col-md-2">';
			row += '<select  id="type_' + value + '" name="type_' + value + '" class="form-control" >';
			row += '<option value=""><?php echo get_phrase('select'); ?></option>';
			<?php
			foreach ($tax as $key => $value) {
			?>
				var selected = "";
				if (type === '<?php echo $key ?>') {
					selected = "selected";
				}
				row += '<option value="<?php echo $key; ?>" ' + selected + '> <?php echo $value; ?></option>';
			<?php

			}
			?>
			row += '</select>';
			row += '</div>';

			row += '<div class="col-md-2"><button id="btnRemove" style="" class="btn btn-sm btn-danger" type="button"><i class="icon icon-trash"></i></button></div>';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			$("#TextBoxContainer").append(row);
		}

		$(document).on('change', '#semester_id', function(e) {
			resetForm();
		});

		function resetForm() {
			$('#TextBoxContainer').html("");
			$('#btnAdd').hide();
			$('.save_button').hide();
		}

		$(document).on('click', '#btnRemove', function() {
			$(this).parents('.form-group').remove();
		});
	</script>
	<script type="text/javascript">
		function getCourse(department_id, course_id) {
			if (department_id != "" && course_id != "") {
				$('#course_id').html("");
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							var sel = "";
							if (course_id == obj.id) {
								sel = "selected";
							}
							div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + "</option>";
						});
						$('#course_id').append(div_data);
					},
					complete: function() {
						$('#course_id').removeClass('dropdownloading');
					}
				});
			}
		}
		$(document).ready(function() {
			var department_id = $('#department_id').val();
			var course_id = '<?php echo set_value('course_id') ?>';
			getCourse(department_id, course_id);
			$(document).on('change', '#department_id', function(e) {
				$('#course_id').html("");
				var department_id = $(this).val();
				var base_url = '<?php echo base_url() ?>';
				var div_data = '<option value=""><?php echo 'Select...'; ?></option>';
				$.ajax({
					type: "GET",
					url: base_url + "admin/courses/getByDept",
					data: {
						'department_id': department_id
					},
					dataType: "json",
					beforeSend: function() {
						$('#course_id').addClass('dropdownloading');
					},
					success: function(data) {
						$.each(data, function(i, obj) {
							div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";
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

<?php } elseif ($page_name == "borrow") { ?>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.needs-validation').on('submit', function(e) {
				var form = document.querySelector('#search_borrow');
				var formData = new FormData(document.getElementById('search_borrow'));
				var subsubmit_button = document.querySelector('#show');

				if (!this.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				} else {
					e.preventDefault();

					$.ajax({
						url: '<?= base_url('admin/borrow_courses/course_ajax') ?>',
						method: "POST",
						data: new FormData(this),
						contentType: false,
						cache: true,
						processData: false,
						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							//console.log(formData);

							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;
							//$("#loader").show();
							$("#result").hide();
							$("#course").hide();
							$("#result").empty();
							$("#course").empty();

						},
						success: function(data) {
							//$('#answers').html(response);
							var response = JSON.parse(data)
							console.log(response);

							//$("#loader").hide();
							$("#result").show();
							$("#course").show();
							renderCoursesPage(response);
							//alert('It works');
						},
						error: function(xhr, ajaxOptions, throwError) {
							//console.log(xhr);
							toastr.error("Unknown Error");
						},


						complete: function() {
							subsubmit_button.innerText = 'Search';
							subsubmit_button.disabled = false;
						}
					});

					//alert('It works')
				}

				$(this).addClass('was-validated');
			});



		});

		function renderCoursesPage(response) {
			$('#result').html(response.departmental);
			$('#course').html(response.course);

			$('#select_all').on('click', function() {
				if (this.checked) {
					$('.checkbox').each(function() {
						this.checked = true;
					});
				} else {
					$('.checkbox').each(function() {
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
			$(document).on('click', '.printSelected', function(e) {
				var subsubmit_button = document.querySelector('#add_reg');
				e.preventDefault();
				var array_to_print = [];
				var class_id = $('#class_id').val();
				var semester_id = $('#semester_id').val();
				var course_id = $('#course_id').val();
				$.each($("input[name='check']:checked"), function() {
					var subjectId = $(this).data('subject_id');
					item = {}
					item["subject_id"] = subjectId;
					array_to_print.push(item);
				});
				if (array_to_print.length == 0) {
					//alert('No Course Selected')
					$("#result").empty();
					$("#course").empty();
					toastr.error("No Course Selected");
				} else {
					$.ajax({
						url: '<?php echo site_url("admin/borrow_courses/store") ?>',
						type: 'post',
						dataType: "json",
						data: {
							'data': JSON.stringify(array_to_print),
							'class_id': class_id,
							'semester_id': semester_id,
							'course_id': course_id

						},
						beforeSend: function() {
							//console.log(form.method);
							//console.log(form.action);
							console.log(JSON.stringify(array_to_print));
							subsubmit_button.innerText = 'Loading ...';
							subsubmit_button.disabled = true;
							//$("#loader").show();
							$("#result").hide();
							$("#course").hide();
							$("#result").empty();
							$("#course").empty();

						},
						success: function(response) {
							//var response = JSON.parse(data)
							if (response.status == true) {
								$("#result").show();
								$("#course").show();
								renderCoursesPage(response);
								toastr.success("Course(s) added successfully");
							} else {
								toastr.error("" + response.notification + "");
							}
						},


						complete: function() {
							subsubmit_button.innerText = 'Add Course(s)';
							subsubmit_button.disabled = false;
						}
					});
				}
			});
			$(document).on('click', '.save_co', function(e) { //** on selecting an option based on ID you assigned
				//var subsubmit_button = document.querySelector('.save_co');
				e.preventDefault();
				var subject_id = $("#sug option:selected").val(); //** get the selected option's value
				var class_id = $('#class_id').val();
				var semester_id = $('#semester_id').val();
				var course_id = $('#course_id').val();
				if ($("#sug").val() == 0) {
					toastr.error("No Course Selected");
				} else {
					$.ajax({
						type: "POST", //**how data is send
						url: "<?php echo site_url("admin/borrow_courses/suggest") ?>", //** where to send the option data so that it can be saved in DB
						data: {
							'subject_id': subject_id,
							'class_id': class_id,
							'semester_id': semester_id,
							'course_id': course_id
						}, //** send the selected option's value to above page
						dataType: "json",

						success: function(data) {
							//alert(data.status)

							//window.location.reload();
							// var response = JSON.parse(data)
							var response = data;
							if (response.status == true) {
								//obj.closest('tr').remove();
								toastr.success("Course Added to Registrable successfully");
								$("#result").show();
								$("#course").show();
								renderCoursesPage(response);

							} else {
								toastr.error("" + response.notification + "");
							}
						},
						error: function(data) {
							toastr.error("Unknown Error!!!");
						}
						/* complete: function() {
							subsubmit_button.innerText = 'Add Course';
							subsubmit_button.disabled = false;
						} */

						//** what should do after value is saved to DB and returned from above URL page.

					});
				}
			});

			function ConfirmDelete() {
				var x = confirm("Are you sure you want to delete?");
				if (x)
					return true;
				else
					return false;
			}
			$(".delete").click(function(e) {
				var subsubmit_button = $(this).attr("id");
				var class_id = $('#class_id').val();
				var semester_id = $('#semester_id').val();
				var course_id = $('#course_id').val();
				var obj = $(this);
				e.preventDefault();
				//alert(); what's this do?
				if (ConfirmDelete() == false) {
					return false;
				}
				$.ajax({
					//alert(); this can't go here
					type: "POST",
					url: "<?php echo site_url("admin/borrow_courses/delete") ?>",
					cache: false,
					data: {
						id: $(this).attr("id"),
						'class_id': class_id,
						'semester_id': semester_id,
						'course_id': course_id
					},
					beforeSend: function() {
						//console.log(form.method);
						//console.log(form.action);

						subsubmit_button.innerText = 'Loading ...';
						subsubmit_button.disabled = true;
						//$("#loader").show();
						$("#result").hide();
						$("#course").hide();
						$("#result").empty();
						$("#course").empty();

					},
					success: function(data) {
						var response = JSON.parse(data)
						//('#alert').html('<div class="toast" data-title="Success! "data-message="Course Added Successfully." data-type="success"></div>');
						// success(data.toast);
						//$('.data-tables').dataTable().ajax.reload();
						//alert(response.status);
						//window.location.reload();
						if (response.status == true) {
							//obj.closest('tr').remove();
							toastr.success("Course removed successfully");
							$("#result").show();
							$("#course").show();
							renderCoursesPage(response);

						} else {
							toastr.error("" + response.notification + "");
						}

					},
					complete: function() {
						subsubmit_button.innerText = 'Remove';
						subsubmit_button.disabled = false;
					}
				});
			});
		}
		$(document).ready(function() {

		});
	</script>

<?php } elseif ($page_name == "dashboard") { ?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
			['Level', 'By Value'],
			['SAS', <?php echo $SAS ?>],
			['SOECCE', <?php echo $SOECCE ?>],
			['SOL', <?php echo $SOL; ?>],
			['SOS', <?php echo $SOS; ?>],
			['SOVTE', <?php echo $VTE; ?>]

		]);

		var options = {
			title: 'Students Population based on School',
			//legend: 'none',
			//pieSliceText: 'value',
			pieHole: 0.3,
			//pieStartAngle: 100
		};

		var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

		chart.draw(data, options);
	}
</script>

<script type="text/javascript">
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
			['Level', 'By Value'],
			['Male', <?php echo $male ?>],
			['Female', <?php echo $female ?>],


		]);

		var options = {
			title: 'Students Population based on Gender',
			//legend: 'none',
			//pieSliceText: 'value',
			pieHole: 0.3,
			//pieStartAngle: 100
		};

		var chart = new google.visualization.PieChart(document.getElementById('genderchart'));

		chart.draw(data, options);
	}
</script>

<script type="text/javascript">
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
			['Level', 'By Value'],
			['Indigene', <?php echo $INDIGENE ?>],
			['Non-Indigene', <?php echo $NONINDIGENE ?>],


		]);

		var options = {
			title: 'Students Population based on Indigene',
			//legend: 'none',
			//pieSliceText: 'value',
			pieHole: 0.3,
			//pieStartAngle: 100
		};

		var chart = new google.visualization.PieChart(document.getElementById('indigenechart'));

		chart.draw(data, options);
	}
</script>
<script type="text/javascript">
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
			['Level', 'By Value'],
			['PRE-Weeding', <?php echo $total_prestudents; ?>],
			['100 Level', <?php echo $level1; ?>],
			['200 Level', <?php echo $level2; ?>],
			['300 Level', <?php echo $level3; ?>]

		]);

		var options = {
			title: 'Students Population based on Level',
			//legend: 'none',
			//pieSliceText: 'value',
			//pieHole: 0.4,
			pieHole: 0.3,
			pieStartAngle: 100
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);
	}
</script>

<script type="text/javascript">
	
	Morris.Donut({
		element: "pie-chart",
		data: [{
				label: "Male",
				value: <?php echo $male ?>
			},
			{
				label: "Female",
				value: <?php echo $female ?>
			}
		],
		colors: ["#2979ff", "#Eb4034"],

	});
</script>
<?php } elseif ($page_name == "tokens") { ?>
	<script type="text/javascript">
		$('#form1').submit(function() {
			var c = confirm("Are you sure want to Generate these Tokens?");
			return c;
		});
		$('.formdelete').submit(function() {
			var c = confirm("Are you sure want to delete backup?");
			return c;
		});
		$('.formrestore').submit(function() {
			var c = confirm("Are you sure want to restore backup?");
			return c;
		});

		function showkey() {

			$("#cronkey").show();
			$("#showbtn").html("<i class='icon icon-eye-slash'></i>");
			$("#showbtn").attr("onclick", "hidekey()");

		}

		function hidekey() {

			$("#cronkey").hide();
			$("#showbtn").html("<i class='icon icon-eye'></i>");
			$("#showbtn").attr("onclick", "showkey()");

		}
	</script>


	<script type="text/javascript">
		$(document).ready(function() {
			$(document).on('click', '.print', function() {
				var id = $('#id').val();
				//var class_id = $('#class_id').val();
				$.ajax({
					url: '<?php echo site_url("admin/tokens/print") ?>',
					type: 'post',
					dataType: "html",
					data: {
						//'data': JSON,
						'id': id,
						//'class_id': class_id,
					},
					success: function(response) {
						//alert(response)
						Popup(response);

					}
				});

			});
		});
	</script>


	<script type="text/javascript">
		var base_url = '<?php echo base_url() ?>';

		function Popup(data) {

			var frame1 = $('<iframe />');
			frame1[0].name = "frame1";

			$("body").append(frame1);
			var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
			frameDoc.document.open();
			//Create a new HTML document.
			frameDoc.document.write('<html>');
			frameDoc.document.write('<head>');
			frameDoc.document.write('<title></title>');
			// frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'ascoe/dist/css/idcard.css">');

			frameDoc.document.write('</head>');
			frameDoc.document.write('<body>');
			frameDoc.document.write(data);
			frameDoc.document.write('</body>');
			frameDoc.document.write('</html>');
			frameDoc.document.close();
			setTimeout(function() {
				window.frames["frame1"].focus();
				window.frames["frame1"].print();
				frame1.remove();
			}, 500);


			return true;
		}
	</script>
		<?php } elseif ($page_name == "payments/application_trans") { ?>

<script type='text/javascript'>
	$(document).ready(function() {
		$.ajax({
			url: '<?php echo base_url('admin/payments/application_trans_ajax'); ?>',
			type: 'post',
			beforeSend: function() {
				// Show image container
				$("#loader").show();
				//$("#response").hide();
			},
			success: function(data) {
				var response = JSON.parse(data);
				renderLoder(response);
				$("#loader").hide();
			}

		});

	});

	function renderLoder(response) {
		$('#response').html(response.render);
		$('#basic').DataTable({
			"aaSorting": [],

			rowReorder: {
				selector: 'td:nth-child(2)'
			},
			pageLength: 100,
			//responsive: 'true',
			//paging: false,
			dom: "Bfrtip",
			buttons: [{
				extend: 'excel',
				text: '<i class="icon icon-file-excel-o"></i>Excel',
				titleAttr: 'Excel',

				title: $('.download_label').html(),
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			}, ]
		})
	}
</script>

<?php }; ?>
