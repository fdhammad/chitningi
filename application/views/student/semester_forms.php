<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<!--begin::Content wrapper-->
	<div class="d-flex flex-column flex-column-fluid">
		<!--begin::Toolbar-->
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<!--begin::Toolbar container-->
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<!--begin::Title-->
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Payment</h1>
					<!--end::Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<!--begin::Item-->
						<li class="breadcrumb-item text-muted">
							<a href="?page=index" class="text-muted text-hover-primary">Home</a>
						</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item">
							<span class="bullet bg-gray-400 w-5px h-2px"></span>
						</li>
						<!--end::Item-->
						<!--begin::Item-->
						<li class="breadcrumb-item text-muted">Checkout</li>
						<!--end::Item-->
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page title-->

			</div>
			<!--end::Toolbar container-->
		</div>
		<!--end::Toolbar-->

		<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
			<!--begin::Content wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
				<?php if ($this->session->flashdata('toast')) { ?>
					<?php echo $this->session->flashdata('toast') ?>
				<?php } ?>
				<?php if ($this->session->flashdata('msg')) { ?>
					<?php echo $this->session->flashdata('msg') ?>
				<?php } ?>
				<?php echo $this->customlib->getCSRF(); ?>

				<!--begin::Content-->
				<div id="kt_app_content" class="app-content flex-column-fluid">
					<!--begin::Content container-->
					<div id="kt_app_content_container" class="app-container container-xxl">

						<!--begin::Row-->
						<div class="row g-5 g-xl-10 mb-5 mb-xl-10">

							<!--begin::Col-->

							<div class="col-xl-12">
								<?= form_open('', 'id="semester_form"') ?>
								<div class="card card-flush pt-3 mb-0">
									<!--end::Notice-->
									<div class="card-header">

										<!--begin::Card title-->
										<div class="card-title">
											<h2>Semester Form</h2>
										</div>
										<!--end::Card title-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0 fs-6">
										<div class="row">
											<div class="col-xl-6 col-md-6 col-sm-12 col-12 mx-auto">
												<div class="form-row mb-4">
													<div class="col">
														<label class="required form-label mb-3">Session</label>
														<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="session_id" id="session_id" aria-label="Select session">

															<option value="<?php echo $current_session_id; ?>"><?php echo 'Current session (' . $current_session_name . ')'; ?></option>
															<?php
															foreach ($sessionlist as $session) {
															?>
																<option value="<?php echo $session['id'] ?>" <?php if (set_value('session_id') == $session['id']) echo "selected=selected" ?>><?php echo $session['session'] ?></option>
															<?php
															}
															?>

														</select>
														<span class="text-danger"><?php echo form_error('session_id'); ?></span>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-md-6 col-sm-12">
												<div class="col"><label class="required form-label mb-3">Semester</label>
													<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="semester_id" id="semester_id" aria-label="Select semester">

														<option value="<?php echo $current_semester_id; ?>"><?php echo 'Current semester (' . $current_semester_name . ')'; ?></option>
														<?php
														foreach ($semesterlist as $semester) {
														?>
															<option value="<?php echo $semester['id'] ?>" <?php if (set_value('semester_id') == $semester['id']) echo "selected=selected" ?>><?php echo $semester['semester'] ?></option>
														<?php
														}
														?>
													</select>
													<span class="text-danger"><?php echo form_error('semester_id'); ?></span>
												</div>
											</div>
											<!-- <input type="submit" name="search" class="mb-4 btn btn-primary">
											 -->
											<button id="request" type="button" class="btn btn-primary">
												<!--begin::Indicator label-->
												<span class="indicator-label">Submit</span>
												<!--end::Indicator label-->
												<!--begin::Indicator progress-->
												<span class="indicator-progress">Please wait...
													<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
												<!--end::Indicator progress-->
											</button>
										</div>
									</div>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
						<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
							<div class="col-xl-12">
								<div id="render"></div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
