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
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Application</h1>
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
						<li class="breadcrumb-item text-muted">Form</li>
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


				<!--begin::Content-->
				<div id="kt_app_content" class="app-content flex-column-fluid">
					<!--begin::Content container-->
					<div id="kt_app_content_container" class="app-container container-xxl">
						<div id="alert"></div>
						<!--begin::Row-->
						<div class="row g-5 g-xl-10 mb-5 mb-xl-10">

							<!--begin::Col-->

							<div class="col-xl-12">
								<div class="card">
									<div class="card-header">

									</div>
									<div class="card-body scroll-y m-5">
										<!--begin::Stepper-->
										<div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_campaign_stepper">
											<!--begin::Nav-->
											<div class="stepper-nav justify-content-center py-2">
												<!--begin::Step 1-->
												<div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
													<h3 class="stepper-title">BioData Details</h3>
												</div>
												<!--end::Step 1-->
												<!--begin::Step 2-->
												<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
													<h3 class="stepper-title">Guardian/Parent</h3>
												</div>
												<!--end::Step 2-->
												<!--begin::Step 3-->
												<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
													<h3 class="stepper-title">Academics</h3>
												</div>
												<!--end::Step 3-->
												<!--begin::Step 4-->
												<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
													<h3 class="stepper-title">Choice Course</h3>
												</div>
												<!--end::Step 4-->
												<!--begin::Step 5-->
												<div class="stepper-item" data-kt-stepper-element="nav">
													<h3 class="stepper-title">Completed</h3>
												</div>
												<!--end::Step 5-->
											</div>
											<!--end::Nav-->
											<!--begin::Form-->

											<!--begin::Step 1-->
											<!-- <?=
													form_open('', 'class="adform mx-auto w-100 mw-800px pt-15 pb-10" method="POST" novalidate="novalidate" id="kt_modal_create_campaign_stepper_form" enctype="multipart/form-data"');
													?> -->
											<form href="" class="adform mx-auto w-100 mw-800px pt-15 pb-10" method="POST" novalidate="novalidate" id="kt_modal_create_campaign_stepper_form" enctype="multipart/form-data">
												<div class="current" data-kt-stepper-element="content">
													<!--begin::Wrapper-->
													<div class="w-100">
														<!--begin::Heading-->
														<div class="pb-10 pb-lg-15">
															<!--begin::Title-->
															<h2 class="fw-bold d-flex align-items-center text-dark">Fill the Application Form
																<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Campaign name will be used as reference within your campaign reports"></i>
															</h2>
															<!--end::Title-->
															<!--begin::Notice-->
															<div class="text-muted fw-semibold fs-6">Fill your Bio data and make sure its valid
																<!-- <a href="#" class="link-primary fw-bold">Help Page</a>. -->
															</div>
															<!--end::Notice-->
														</div>
														<!--end::Heading-->
														<!--begin::Input group-->
														<div class="mb-10 row">

															<div class="col">
																<label class="required form-label mb-3">First Name</label>
																<input type="text" class="form-control form-control-lg form-control-solid" name="firstname" value="<?php echo set_value('firstname', $applicant['firstname']); ?> " readonly="" />
																<input type="hidden" id="applicant_id" name="applicant_id" value="<?php echo $applicant["id"] ?>">
															</div>
															<div class="col">
																<label class="required form-label mb-3">Surname</label>
																<input type="text" class="form-control form-control-lg form-control-solid" name="lastname" value="<?php echo set_value('lastname', $applicant['lastname']); ?> " readonly="" />

															</div>
															<div class="col">
																<label class="form-label mb-3">Last Name</label>
																<input type="text" class="form-control form-control-lg" id="middlename" name="middlename focus" value="<?php echo set_value('middlename', $applicant['middlename']); ?> " />

															</div>
															<!--end::Input-->
														</div>
														<div class="row mb-4">
															<div class="col">

																<label class="required form-label mb-3"><?php echo 'Email'; ?></label>
																<input id="email" name="email" placeholder="" type="email" class="form-control form-control-lg" value="<?php echo set_value('email', $applicant['email']); ?>" />

															</div>
															<div class="col">

																<label class="required form-label mb-3"><?php echo 'Phone Number'; ?></label>
																<input id="phone" name="phone" placeholder="" type="tel" class="form-control form-control-lg form-control-solid" value="<?php echo set_value('phone', $applicant['phone']); ?>" readonly="" />

															</div>
														</div>
														<!--end::Input group-->

														<!--begin::Input group-->
														<div class="fv-row mb-10">
															<!--begin::Label-->
															<label class="required fs-6 fw-semibold mb-2">Gender</label>
															<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Show your ads to either men or women, or select 'All' for both"></i></label>
														 -->
															<!--End::Label-->
															<!--begin::Row-->
															<div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">

																<!--begin::Col-->
																<div class="col">
																	<!--begin::Option-->
																	<label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6" data-kt-button="true">
																		<!--begin::Radio-->
																		<span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																			<input class="form-check-input" type="radio" name="gender" <?php if ($applicant['gender'] == "M") echo "checked"; ?> value="M" />
																		</span>
																		<!--end::Radio-->
																		<!--begin::Info-->
																		<span class="ms-5">
																			<span class="fs-4 fw-bold text-gray-800 d-block">Male</span>
																		</span>
																		<!--end::Info-->
																	</label>
																	<!--end::Option-->
																</div>
																<!--end::Col-->
																<!--begin::Col-->
																<div class="col">
																	<!--begin::Option-->
																	<label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6" data-kt-button="true">
																		<!--begin::Radio-->
																		<span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																			<input class="form-check-input" type="radio" name="gender" <?php if ($applicant['gender'] == "F") echo "checked"; ?> value="F" />
																		</span>
																		<!--end::Radio-->
																		<!--begin::Info-->
																		<span class="ms-5">
																			<span class="fs-4 fw-bold text-gray-800 d-block">Female</span>
																		</span>
																		<!--end::Info-->
																	</label>
																	<!--end::Option-->
																</div>
																<!--end::Col-->
															</div>
															<!--end::Row-->
														</div>
														<!--end::Input group-->

														<div class="row mb-5">
															<div class="col col-4">
																<label class="required form-label mb-3">Date of birth</label>
																<input class="form-control form-control-solid" name="dob" value="<?php echo set_value('dob', $applicant['dob']); ?>" placeholder="Pick a date" id="kt_dob" />
															</div>
															<div class="col col-4">
																<div class="form-group">
																	<label class="required form-label mb-3">Religion</label>
																	<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="religion" id="religion" aria-label="Select religion">
																		<option value=""><?php echo 'Select ...' ?></option>s
																		<?php
																		foreach ($religionList as $key => $value) {
																		?>
																			<option value="<?php echo $key; ?>" <?php if (set_value('religion', $applicant['religion'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																		<?php
																		}
																		?>
																	</select>
																</div>
															</div>
															<div class="col col-4">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Marital Status'; ?></label>
																	<select name="marital_status" id="marital_status" aria-label="Select Marital Status" data-control="select2" data-placeholder="Select Marital status ..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<option value=""><?php echo 'Select ...' ?></option>
																		<?php foreach ($maritalStatus as $key => $value) {
																		?>
																			<option value="<?php echo $key; ?>" <?php if (set_value('marital_status', $applicant['marital_status'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>

																		<?php } ?>
																	</select>


																</div>
															</div>
														</div>

														<div class="row mb-4">
															<div class="col col-md-4 col-sm-4 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'State'; ?></label>

																	<select id="state_id" name="state_id" aria-label="Select state" data-control="select2" data-placeholder="Select state..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<option value="">Choose...</option>
																		<?php
																		foreach ($statelist as $state) {
																		?>
																			<option value="<?php echo $state['id'] ?>" <?php
																														if ($applicant['state_id'] == $state['id']) {
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
															<div class="col col-md-4 col-sm-5 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Local government'; ?></label>

																	<select id="local_government_id" name="local_government_id" aria-label="Select LGA" data-control="select2" data-placeholder="Select LGA..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<option value=""></option>
																	</select>
																	<span class="text-danger"><?php echo form_error('local_government_id'); ?></span>
																</div>
															</div>
															<div class="col col-md-4">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Home Town'; ?></label>
																	<input id="kt_tob" name="tob" placeholder="" type="text" class="form-control" value="<?php echo set_value('tob', $applicant['tob']); ?>" required />
																	<span class="text-danger"><?php echo form_error('tob'); ?></span>
																</div>
															</div>
														</div>

														<div class="row mb-4">
															<div class="col col-md-6 col-sm-6 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Current Address'; ?></label>
																	<textarea id="current_address" name="current_address" placeholder="" class="form-control" required><?php echo set_value('current_address', $applicant['current_address']); ?></textarea>
																	<span style="color: #FF0000"><?php echo form_error('current_address'); ?></span>
																</div>
															</div>
															<div class="col col-md-6 col-sm-6 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Permanent Address'; ?></label>
																	<textarea id="permanent_address" name="permanent_address" placeholder="" class="form-control"><?php echo set_value('permanent_address', $applicant['permanent_address']); ?></textarea>
																	<span class="text-danger"><?php echo form_error('permanent_address'); ?></span>
																</div>
															</div>

														</div>
														<!--begin::Input group-->
														<div class="fv-row mb-10">
															<div class="col">
																<!--begin::Label-->
																<label class="d-block fw-semibold fs-6 mb-5">
																	<span class="">Photograph</span>
																	<i class=" fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="E.g. Select a Passport that is 2mb in size."></i>
																</label>
																<!--end::Label-->
																<!--begin::Image input placeholder-->
																<style>
																	.image-input-placeholder {
																		background-image: url('<?php echo $this->applicant_model->get_user_image_url($this->session->userdata('user_id')); ?>');
																	}

																	[data-theme="dark"] .image-input-placeholder {
																		background-image: url('<?php echo $this->applicant_model->get_user_image_url($this->session->userdata('user_id')); ?>');
																	}
																</style>
																<!--end::Image input placeholder-->
																<!--begin::Image input-->
																<div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
																	<!--begin::Preview existing avatar-->
																	<div class="image-input-wrapper w-125px h-125px"></div>
																	<!--end::Preview existing avatar-->
																	<!--begin::Label-->
																	<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Passport">
																		<i class="bi bi-pencil-fill fs-7"></i>
																		<!--begin::Inputs-->
																		<input type="file" name="file" accept=".png, .jpg, .jpeg" />
																		<input type="hidden" name="avatar_remove" />
																		<!--end::Inputs-->
																	</label>
																	<!--end::Label-->
																	<!--begin::Cancel-->
																	<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel Passport">
																		<i class="bi bi-x fs-2"></i>
																	</span>
																	<!--end::Cancel-->
																	<!--begin::Remove-->
																	<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Passport">
																		<i class="bi bi-x fs-2"></i>
																	</span>
																	<!--end::Remove-->
																</div>
																<!--end::Image input-->
																<!--begin::Hint-->
																<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
																<!--end::Hint-->
															</div>
														</div>
														<!--end::Input group-->

													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Step 1-->
												<!--begin::Step 2-->
												<div data-kt-stepper-element="content">
													<!--begin::Wrapper-->
													<div class="w-100">
														<!--begin::Heading-->
														<div class="pb-10 pb-lg-12">
															<!--begin::Title-->
															<h1 class="fw-bold text-dark">Sponsor|Guardian|Parent</h1>
															<!--end::Title-->
															<!--begin::Description-->
															<div class="text-muted fw-semibold fs-4">Details of Guardian, Sponsor or Parent
																<!-- <a href="#" class="link-primary">Campaign Guidelines</a> -->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Heading-->
														<!--begin::Input group-->
														<div class="row mb-4">
															<div class="col col-md-6 col-sm-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Guardian name'; ?></label>
																	<small class="req"> *</small>
																	<input id="guardian_name" name="guardian_name" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_name', $applicant['guardian_name']); ?>" />
																	<span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
																</div>
															</div>

															<div class="col col-md-3 col-sm-3">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Guardian relation'; ?></label>
																	<input id="guardian_relation" name="guardian_relation" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_relation', $applicant['guardian_relation']); ?>" />
																	<span class="text-danger"><?php echo form_error('guardian_relation'); ?></span>
																</div>
															</div>
															<div class="col col-md-3 col-sm-3 ">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Guardian phone'; ?></label>
																	<small class="req"> *</small>
																	<input id="guardian_phone" name="guardian_phone" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_phone', $applicant['guardian_phone']); ?>" />
																	<span class="text-danger"><?php echo form_error('guardian_phone'); ?></span>
																</div>
															</div>
														</div>
														<div class="row mb-4">

															<div class="col col-md-4 col-sm-3">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Guardian email'; ?></label>
																	<input id="guardian_email" name="guardian_email" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_email', $applicant['guardian_email']); ?>" />
																	<span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
																</div>
															</div>
															<div class="col col-md-5">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Guardian address'; ?></label>
																	<textarea id="guardian_address" name="guardian_address" placeholder="" class="form-control" rows="4"><?php echo set_value('guardian_address', $applicant['guardian_address']); ?></textarea>
																	<span class="text-danger"><?php echo form_error('guardian_address'); ?></span>
																</div>
															</div>

														</div>
														<!--end::Input group-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Step 2-->
												<!--begin::Step 3-->
												<div data-kt-stepper-element="content">
													<!--begin::Wrapper-->
													<div class="w-100">
														<!--begin::Heading-->
														<div class="pb-10 pb-lg-12">
															<!--begin::Title-->
															<h1 class="fw-bold text-dark">Academic Details</h1>
															<!--end::Title-->
															<!--begin::Description-->
															<!-- <div class="text-muted fw-semibold fs-4">If you need more info, please check
																<a href="#" class="link-primary">Campaign Guidelines</a>
															</div> -->
															<!--end::Description-->
														</div>
														<!--end::Heading-->
														<div class="row mb-4">
															<div class="col col-md-6">
																<div class="form-group">
																	<label class="required form-label mb-3">Primary School Attended</label>
																	<textarea id="primary_school" name="primary_school" placeholder="" class="form-control" rows="4"><?php echo set_value('primary_school', $applicant['primary_school']); ?></textarea>
																	<span class="text-danger"><?php echo form_error('primary_school'); ?></span>
																</div>
															</div>

															<div class="col col-md-4 col-sm-6">
																<div class="form-group">
																	<label class="required form-label mb-3">Primary School Attended year</label><small class="req"> *</small>
																	<input id="primary_school_year" name="primary_school_year" placeholder="" type="text" class="form-control" value="<?php echo set_value('primary_school_year', $applicant['primary_school_year']); ?>" />
																	<span class="text-danger"><?php echo form_error('primary_school_year'); ?></span>
																</div>
															</div>

														</div>
														<div class="row mb-3">
															<div class="col col-md-6">
																<div class="form-group">
																	<label class="required form-label mb-3">Secondary School Attended</label>
																	<textarea id="secondary_school" name="secondary_school" placeholder="" class="form-control" rows="4"><?php echo set_value('secondary_school', $applicant['secondary_school']); ?></textarea>
																	<span class="text-danger"><?php echo form_error('secondary_school'); ?></span>
																</div>
															</div>

															<div class="col col-md-4">
																<div class="form-group">
																	<label class="required form-label mb-3">Secondary School Attended year</label><small class="req"> *</small>
																	<input id="secondary_school_year" name="secondary_school_year" placeholder="" type="text" class="form-control" value="<?php echo set_value('secondary_school_year', $applicant['secondary_school_year']); ?>" />
																	<span class="text-danger"><?php echo form_error('secondary_school_year'); ?></span>
																</div>
															</div>

														</div>
														<h5>O'LEVEL </h5>
														<hr />
														<div class="fv-row mb-10">
															<!--begin::Label-->
															<!-- 	<label class="required fs-6 fw-semibold mb-2">No of Sittings</label> -->
															<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Show your ads to either men or women, or select 'All' for both"></i></label>
														 -->
															<!--End::Label-->
															<div class="col form-group col-md-3">
																<label class="required fs-6 fw-semibold mb-2">No of Sittings</label>
																<select id="sitting" data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="sitting">
																	<option value=""><?php echo get_phrase('select'); ?></option>
																	<?php
																	foreach ($sittings as $key => $value) {
																	?>
																		<option value="<?php echo $key; ?>" <?php if (set_value('sitting', $applicant['sitting'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																	<?php
																	}
																	?>
																</select>
																<span class="text-danger"><?php echo form_error('sitting'); ?></span>

															</div>
														</div>

														<div id="once">
															<div class="row mb-3">
																<div class="col form-group col-md-3">
																	<label class="required form-label mb-3"><?php echo 'Select OLevel Exam'; ?></label>
																	<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="title">
																		<option value=""><?php echo get_phrase('select'); ?></option>
																		<?php
																		foreach ($olevelList as $key => $value) {
																		?>
																			<option value="<?php echo $key; ?>" <?php if (set_value('title', $applicant['title'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																		<?php
																		}
																		?>
																	</select>
																	<span class="text-danger"><?php echo form_error('title'); ?></span>

																</div>

															</div>

															<br>
															<div class="row mb-3">
																<div class="col col-md-2 col-md-offset-0 col-sm-4 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('exam_year'); ?></label>
																		<input id="exam_year" name="exam_year" placeholder="" type="text" class="form-control" value="<?php echo set_value('exam_year', $applicant['exam_year']); ?>" />
																		<span class="text-danger"><?php echo form_error('exam_year'); ?></span>
																	</div>
																</div>
																<div class="col col-md-5 col-md-5 col-md-offset-1 col-sm-5 col-xs-7">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('exam_no'); ?></label>
																		<input id="exam_no" name="exam_no" placeholder="" type="text" class="form-control" value="<?php echo set_value('exam_no', $applicant['exam_no']); ?>" maxlength="15" minlength="8" autofocus="" />
																		<span class="text-danger"><?php echo form_error('exam_no'); ?></span>
																	</div>
																</div>
															</div>
															<hr>
															<br>

															<div class="row mb-3">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<input id="subject" name="subject" placeholder="" type="text" class="form-control form-control-solid" value="English" readonly='' />
																		<span class="text-danger"><?php echo form_error('subject'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade', $applicant['grade'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<input id="subject2" name="subject2" placeholder="" type="text" class="form-control form-control-solid" value="Mathematics" readonly='' />
																		<span class="text-danger"><?php echo form_error('subject2'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade2">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade2', $applicant['grade2'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade2'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row mb-3">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject3">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject3', $applicant['subject3'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject3'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade3">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade3', $applicant['grade3'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade3'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject4">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject4', $applicant['subject4'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject4'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade4">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade4', $applicant['grade4'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade4'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row mb-3">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject5">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject5', $applicant['subject5'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject5'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade5">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade5', $applicant['grade5'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade5'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject6">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject6', $applicant['subject6'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject6'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade6">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade6', $applicant['grade6'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade6'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row mb-3">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject7">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject7', $applicant['subject7'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject7'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade7">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade7', $applicant['grade7'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade7'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject8">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject8', $applicant['subject8'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject8'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade8">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade8', $applicant['grade8'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade8'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row mb-3">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject9">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject9', $applicant['subject9'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject9'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade9">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade9', $applicant['grade9'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade9'); ?></span>

																	</div>
																</div>

															</div>
														</div>
														<hr />
														<div id="twice">
															<div class="row mt-2">
																<div class="col form-group col-md-3">
																	<label class="required form-label mb-3"><?php echo 'Select OLevel Exam'; ?></label>
																	<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="title2">
																		<option value=""><?php echo get_phrase('select'); ?></option>
																		<?php
																		foreach ($olevelList as $key => $value) {
																		?>
																			<option value="<?php echo $key; ?>" <?php if (set_value('title2', $applicant['title2'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																		<?php
																		}
																		?>
																	</select>
																	<span class="text-danger"><?php echo form_error('title2'); ?></span>

																</div>

															</div>
															<div class="row mb-3">
																<div class="col col-md-2 col-md-offset-0 col-sm-4 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('exam_year'); ?></label>
																		<input id="exam_year" name="exam_year2" placeholder="" type="text" class="form-control" value="<?php echo set_value('exam_year2', $applicant['exam_year2']); ?>" />
																		<span class="text-danger"><?php echo form_error('exam_year'); ?></span>
																	</div>
																</div>
																<div class="col col-md-5 col-md-5 col-md-offset-1 col-sm-5 col-xs-7">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('exam_no'); ?></label>
																		<input id="exam_no" name="exam_no2" placeholder="" type="text" class="form-control" value="<?php echo set_value('exam_no2', $applicant['exam_no2']); ?>" maxlength="15" minlength="8" autofocus="" />
																		<span class="text-danger"><?php echo form_error('exam_no'); ?></span>
																	</div>
																</div>
															</div>
															<br>
															<div class="row">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<input id="subject11" name="subject11" placeholder="" type="text" class="form-control form-control-sm" value="English" readonly='' />
																		<span class="text-danger"><?php echo form_error('subject11'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade11">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade11', $applicant['grade11'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade11'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<input id="subject22" name="subject22" placeholder="" type="text" class="form-control form-control-sm" value="Mathematics" readonly='' />
																		<span class="text-danger"><?php echo form_error('subject22'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade22">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade22', $applicant['grade22'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade22'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject33">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject33', $applicant['subject33'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject33'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade33">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade33', $applicant['grade33'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade33'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject44">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject44', $applicant['subject44'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject44'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade44">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade44', $applicant['grade44'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade44'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject55">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject55', $applicant['subject55'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject55'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade55">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade55', $applicant['grade55'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade55'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject66">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject66', $applicant['subject66'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject66'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade66">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade66', $applicant['grade66'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade66'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject77">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject77', $applicant['subject77'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject77'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade77">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade77', $applicant['grade77'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade77'); ?></span>

																	</div>
																</div>
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject88">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject88', $applicant['subject88'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject88'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade88">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade88', $applicant['grade88'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade88'); ?></span>

																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col col-md-3 col-sm-4 col-xs-6">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('subject'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="subject99">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($subjectList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('subject99', $applicant['subject99'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('subject99'); ?></span>

																	</div>
																</div>
																<div class="col col-md-2 col-sm-3 col-xs-4">
																	<div class="form-group">
																		<label class="required form-label mb-3"><?php echo get_phrase('grade'); ?></label>
																		<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid form-select-sm fw-semibold" name="grade99">
																			<option value=""><?php echo get_phrase('select'); ?></option>
																			<?php
																			foreach ($creditList as $key => $value) {
																			?>
																				<option value="<?php echo $key; ?>" <?php if (set_value('grade99', $applicant['grade99'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																			<?php
																			}
																			?>
																		</select>
																		<span class="text-danger"><?php echo form_error('grade99'); ?></span>

																	</div>
																</div>

															</div>
															<hr>
														</div>

														<!--end::Input group-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Step 3-->
												<!--begin::Step 4-->
												<div data-kt-stepper-element="content">
													<!--begin::Wrapper-->
													<div class="w-120">
														<h3>FIRST CHOICE</h3>
														<div class="row mb-4 mt-3">
															<div class="col col-md-4 col-sm-4 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'School'; ?></label>

																	<select id="school_id" name="school_id" aria-label="Select School" data-control="select2" data-placeholder="Select School..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<option value=""></option>
																		<?php
																		foreach ($schoollist as $school) {
																		?>
																			<option value="<?php echo $school['id'] ?>" <?php if ($choice1['school_id'] == $school['id']) echo "selected=selected" ?>><?php echo $school['school'] ?></option>
																		<?php

																		}
																		?>
																		<!-- <option value="5"> School Health Information Management</option>
																		<option value="8"> School of General Health Science</option> -->
																	</select>
																	<span class="text-danger"><?php echo form_error('school_id'); ?></span>
																</div>
															</div>
															<div class="col col-md-4 col-sm-5 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Department'; ?></label>

																	<select id="department_id" name="department_id" aria-label="Select Dept" data-control="select2" data-placeholder="Select Dept..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<option value="10"></option>
																	</select>
																	<span class="text-danger"><?php echo form_error('department_id'); ?></span>
																</div>
															</div>
															<div class="col col-md-12 col-sm-12 col-xs-12">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Course'; ?></label>

																	<select id="course_id" name="course_id" aria-label="Select Course" data-control="select2" data-placeholder="Select Course..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<?php if ($choice1['course_id'] == 9) { ?>
																			<option value=""></option>
																			<option value="9" selected="selected">Higher National Diploma in Health Information Management</option>
																			<option value="19">Higher National Diploma in Nutrition and Dietetics</option>

																		<?php } elseif ($choice1['course_id'] == 19) { ?>
																			<option value=""></option>
																			<option value="9">Higher National Diploma in Health Information Management</option>
																			<option value="19" selected="selected">Higher National Diploma in Nutrition and Dietetics</option>

																		<?php } else { ?>
																			<option value=""></option>
																			<option value="9">Higher National Diploma in Health Information Management</option>
																			<option value="19">Higher National Diploma in Nutrition and Dietetics</option>

																		<?php } ?>

																	</select>
																	<span class="text-danger"><?php echo form_error('course_id'); ?></span>
																</div>
															</div>
														</div>
														<h3>SECOND CHOICE</h3>
														<div class="row mb-4 mt-3">
															<div class="col col-md-4 col-sm-4 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'School'; ?></label>

																	<select id="school_id2" name="school_id2" aria-label="Select School" data-control="select2" data-placeholder="Select School..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<option value=""></option>
																		<?php
																		foreach ($schoollist as $school) {
																		?>
																			<option value="<?php echo $school['id'] ?>" <?php if ($choice2['school_id'] == $school['id']) echo "selected=selected" ?>><?php echo $school['school'] ?></option>
																		<?php

																		}
																		?>
																		<!-- <option value="5"> School Health Information Management</option>
																		<option value="8"> School of General Health Science</option> -->
																	</select>
																	<span class="text-danger"><?php echo form_error('school_id2'); ?></span>
																</div>
															</div>
															<div class="col col-md-4 col-sm-5 col-xs-6">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Department'; ?></label>

																	<select id="department_id2" name="department_id2" aria-label="Select Dept" data-control="select2" data-placeholder="Select Dept..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<option value=""></option>
																	</select>
																	<span class="text-danger"><?php echo form_error('department_id2'); ?></span>
																</div>
															</div>
															<div class="col col-md-12 col-sm-12 col-xs-12">
																<div class="form-group">
																	<label class="required form-label mb-3"><?php echo 'Course'; ?></label>

																	<select id="course_id2" name="course_id2" aria-label="Select Course" data-control="select2" data-placeholder="Select Course..." class="form-select form-select-solid form-select-sm fw-semibold">
																		<?php if ($choice2['course_id'] == 9) { ?>
																			<option value=""></option>
																			<option value="9" selected="selected">Higher National Diploma in Health Information Management</option>
																			<option value="19">Higher National Diploma in Nutrition and Dietetics</option>

																		<?php } elseif ($choice2['course_id'] == 19) { ?>
																			<option value=""></option>
																			<option value="9">Higher National Diploma in Health Information Management</option>
																			<option value="19" selected="selected">Higher National Diploma in Nutrition and Dietetics</option>

																		<?php } else { ?>
																			<option value=""></option>
																			<option value="9">Higher National Diploma in Health Information Management</option>
																			<option value="19">Higher National Diploma in Nutrition and Dietetics</option>

																		<?php } ?>
																	</select>
																	<span class="text-danger"><?php echo form_error('course_id2'); ?></span>
																</div>
															</div>
														</div>
														<!--end::Wrapper-->
													</div>
												</div>
												<!--end::Step 4-->
												<!--begin::Step 5-->
												<div data-kt-stepper-element="content">
													<!--begin::Wrapper-->
													<div class="w-100">
														<!--begin::Heading-->
														<div class="pb-12 text-center">
															<!--begin::Title-->
															<h1 class="fw-bold text-dark">Form Review</h1>
															<!--end::Title-->
															<!--begin::Description-->
															<div class="fw-semibold text-muted fs-4">You will receive an email with with the summary of your newly created campaign!</div>
															<!--end::Description-->
														</div>
														<!--end::Heading-->
														<!--begin::Actions-->
														<!-- <div class="d-flex flex-center pb-20"> -->
														<div id="response"></div>
														<div class="text-center">

															<!-- 
															<a href="<?php echo base_url('applicant_students/dashboard') ?>" class="btn btn-primary mt-3 mr-5">Save for Later</a> -->
															<button type="button" class="btn btn-success mt-3 finalize"><i class="fa fa-check"></i> Submit & Finalize </button>
														</div>
														<!-- </div> -->
														<!--end::Actions-->

													</div>
												</div>
												<!--end::Step 5-->
												<!--begin::Actions-->
												<div class="d-flex flex-stack pt-10">
													<!--begin::Wrapper-->
													<div class="me-2">
														<button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
															<span class="svg-icon svg-icon-3 me-1">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
																	<path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon-->Back
														</button>
													</div>
													<!--end::Wrapper-->
													<!--begin::Wrapper-->
													<div>

														<button type="submit" id="adform_button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
															<span class="indicator-label">Submit
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-3 ms-2 me-0">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<span class="indicator-progress">Please wait...
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														</button>
														<button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
															<span class="svg-icon svg-icon-3 ms-1 me-0">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																	<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</button>
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Actions-->
												<?=
												form_close();
												?>
												<!--end::Form-->
										</div>
										<!--end::Stepper-->
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>