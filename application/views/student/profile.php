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
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Default</h1>
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
						<li class="breadcrumb-item text-muted">Dashboard</li>
						<!--end::Item-->
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page title-->

			</div>
			<!--end::Toolbar container-->
		</div>
		<!--end::Toolbar-->

		<!--begin::Content-->
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<!--begin::Content container-->
			<div id="kt_app_content_container" class="app-container container-xxl">
				<?php if ($this->session->flashdata('toast')) { ?>
					<?php echo $this->session->flashdata('toast') ?>
				<?php } ?>
				<?php if ($this->session->flashdata('msg')) { ?>
					<?php echo $this->session->flashdata('msg') ?>
				<?php } ?>

				<div id="alert"></div>
				<?php echo $this->customlib->getCSRF(); ?>
				<!--begin::Row-->
				<div class="row g-5 g-xl-10 mb-5 mb-xl-10">

					<!--begin::Col-->

					<div class="col-xl-12">
						<div class="card card-flush pt-3 mb-0">
							<form id="student_profile_update" class="form needs-validation" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
								<?php echo $this->customlib->getCSRF(); ?>
								<div class="card-header mb-6">
									<h6 class="card-title">Update Bio Data</h6>
								</div>
								<div class="row">
									<div class="col-lg-11 mx-auto">
										<div class="row">
											<div class="col-xl-3 col-lg-12 col-md-4">
												<div class="row mb-6">
													<!--begin::Label-->

													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8">
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
												<!-- <div class="upload mt-4 pr-md-4">
													<input type="file" id="input-file-max-fs" name="sign" class="dropify" data-default-file="<?php
																																				if (!empty($student['sign'])) {
																																					echo base_url() . $student['sign'];
																																				} else {
																																				}
																																				?>" data-max-file-size="2M" />
													<p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Signature</p>
												</div> -->

											</div>
											<div class="col-xl-8 col-lg-12 col-md-8 mt-md-0 mt-4">
												<div class="form">


													<div class="row">
														<div class="col-sm-6 mb-5">
															<div class="form-group">
																<label for="firstname" class="required col-form-label fw-semibold fs-6">First Name</label>

																<input id="firstname" name="firstname" placeholder="" type="text" class="form-control form-control-solid form-control-md" value="<?php echo set_value('firstname', $student['firstname']); ?>" readonly />
																<span class="text-danger"><?php echo form_error('firstname'); ?></span>
															</div>
														</div>
														<div class="col-sm-6 mb-5">
															<div class="form-group">
																<label for="lastname" class="required col-form-label fw-semibold fs-6">Surname</label>
																<input id="lastname" name="lastname" placeholder="" type="text" class="form-control form-control-md form-control-solid" value="<?php echo set_value('lastname', $student['lastname']); ?>" readonly />
																<span class="text-danger"><?php echo form_error('lastname'); ?></span>
															</div>
														</div>

														<div class="col-sm-6 mb-5">
															<div class="form-group">
																<label for="middlename" class="required col-form-label fw-semibold fs-6">Middle Name</label>

																<input id="middlename" name="middlename" placeholder="" type="text" class="form-control form-control-md" value="<?php echo set_value('middlename', $student['middlename']); ?>" />
																<span class="text-danger"><?php echo form_error('middlename'); ?></span>
																<div class="valid-feedback">
																	Looks good!
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<!--begin::Input group-->
														<div class="fv-row mb-5">
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
																			<input class="form-check-input" type="radio" name="gender" <?php if ($student['gender'] == "M") echo "checked"; ?> value="M" />
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
																			<input class="form-check-input" type="radio" name="gender" <?php if ($student['gender'] == "F") echo "checked"; ?> value="F" />
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
														<div class="col-sm-5 mb-5">
															<div class="form-group">
																<label for="email" class="required col-form-label fw-semibold fs-6">E-mail </label>

																<input id="email" name="email" placeholder="" type="email" class="form-control form-control-md" autocomplete="" value=" <?php echo set_value('email', $student['email']); ?>" required />
																<span id="msgbox" class="text-danger"><?php echo form_error('email'); ?></span>
															</div>
														</div>
														<div class="col-sm-5 mb-5">
															<div class="form-group">
																<label for="phone" class="required col-form-label fw-semibold fs-6">Mobile Num</label>

																<input id="phone" type="text" name="phone" placeholder="" class="form-control form-control-md" value=" <?php echo set_value('phone', $student['phone']); ?>" required />
																<span id="phoneMsgbox" class=" text-danger"><?php echo form_error('phone'); ?></span>
																<div class="valid-feedback">
																	Looks good!
																</div>
															</div>
														</div>


													</div>
													<div class="row">
														<!--begin::Input group-->
														<div class="fv-row mb-5">
															<!--begin::Label-->
															<label class="required fs-6 fw-semibold mb-2">Marital Status</label>
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
																			<input class="form-check-input" type="radio" name="marital_status" <?php if ($student['marital_status'] == "Single") echo "checked"; ?> value="Single" />
																		</span>
																		<!--end::Radio-->
																		<!--begin::Info-->
																		<span class="ms-5">
																			<span class="fs-4 fw-bold text-gray-800 d-block">Single</span>
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
																			<input class="form-check-input" type="radio" name="marital_status" <?php if ($student['marital_status'] == "Married") echo "checked"; ?> value="Married" />
																		</span>
																		<!--end::Radio-->
																		<!--begin::Info-->
																		<span class="ms-5">
																			<span class="fs-4 fw-bold text-gray-800 d-block">Married</span>
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
													</div>
													<div class="row">
														<div class="col-sm-5 mb-5">
															<div class="form-group">
																<label for="date_of_birth" class="required col-form-label fw-semibold fs-6">Date Of Birth</label>
																<input id="kt_dob" name="dob" value="<?php echo set_value('dob', $student['dob']); ?>" class="form-control form-control-md" type="text" placeholder="Select Date.." required>
																<span class="text-danger"><?php echo form_error('dob'); ?></span>
																<div class="valid-feedback">
																	Looks good!
																</div>
															</div>
														</div>
														<div class="col-sm-5 mb-4">
															<div class="form-group">
																<label class="required col-form-label fw-semibold fs-6">Religion</label>
																<select data-control="select2" data-placeholder="Select ..." class="form-select form-select-mb fw-semibold" name="religion" id="religion" aria-label="Select religion">
																	<option value=""><?php echo 'Select ...' ?></option>s
																	<?php
																	foreach ($religionList as $key => $value) {
																	?>
																		<option value="<?php echo $key; ?>" <?php if (set_value('religion', $student['religion'] == $key)) echo "selected"; ?>><?php echo $value; ?></option>
																	<?php
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-4 mb-5">
															<div class="form-group">
																<label for="tob" class="required col-form-label fw-semibold fs-6">Town of Birth</label>

																<input class="form-control form-control-md" name="tob" type="text" value="<?php echo set_value('tob', $student['tob']); ?>" id="tob" required>
															</div>
															<div class="valid-feedback">
																Looks good!
															</div>
														</div>
														<div class="col-sm-4 mb-5">
															<div class="form-group">
																<label for="state" class="required col-form-label fw-semibold fs-6">State of Origin</label>


																<select id="state_id" name="state_id" aria-label="Select state" data-control="select2" data-placeholder="Select state..." class="form-select form-select-solid form-select-md fw-semibold">
																	<option value="">Choose...</option>
																	<?php
																	foreach ($statelist as $state) {
																	?>
																		<option value="<?php echo $state['id'] ?>" <?php
																													if ($student['state_id'] == $state['id']) {
																														echo "selected =selected";
																													}
																													?>><?php echo $state['name'] ?></option>
																	<?php

																	}
																	?>
																</select>
																<span class="text-danger"><?php echo form_error('state_id'); ?></span>


																<div class="valid-feedback">
																	Looks good!
																</div>
															</div>
														</div>
														<div class="col-sm-4 mb-5">
															<div class="form-group">
																<label for="lga" class="required col-form-label fw-semibold fs-6">Local Govt</label>

																<select id="local_government_id" name="local_government_id" aria-label="Select LGA" data-control="select2" data-placeholder="Select LGA..." class="form-select form-select-solid form-select-md fw-semibold">
																	<option value=""></option>
																</select>
																<div class="valid-feedback">
																	Looks good!
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-6 mb-5">
															<div class="form-group">

																<label for="current_address" class="required col-form-label fw-semibold fs-6">Residential Address</label>

																<textarea class="form-control form-control-md" rows=" 2" name="current_address" cols="50" id="current_address"><?php echo $student['current_address'] ?></textarea>
															</div>
														</div>
														<div class="col-sm-6 mb-5">
															<div class="form-group">
																<label for="permanent_address" class="required col-form-label fw-semibold fs-6">Permanent Home Address</label>

																<textarea class="form-control form-control-md" rows=" 2" name="permanent_address" cols="50" id="permanent_address"><?php echo $student['permanent_address'] ?></textarea>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-4 mb-5">
															<div class="form-group">
																<label for="guardian_name" class="required col-form-label fw-semibold fs-6">Guardian Name</label>

																<input id="guardian_name" name="guardian_name" placeholder="" type="text" class="form-control form-control-md" value=" <?php echo set_value('guardian_name', $student['guardian_name']); ?>" />
															</div>
														</div>
														<div class="col-sm-4 mb-5">
															<div class="form-group">
																<label for="guardian_phone" class="required col-form-label fw-semibold fs-6">Guardian Phone</label>

																<input id="guardian_phone" name="guardian_phone" placeholder="" type="text" class="form-control form-control-md" value=" <?php echo set_value('guardian_phone', $student['guardian_phone']); ?>" />
															</div>
														</div>
														<div class="col-sm-4 mb-5">
															<label for="guardian_occupation" class="required col-form-label fw-semibold fs-6">Guardian Occupation</label>

															<input id="guardian_occupation" name="guardian_occupation" placeholder="" type="text" class="form-control form-control-md" value=" <?php echo set_value('guardian_occupation', $student['guardian_occupation']); ?>" />
														</div>
													</div>
													<div class="row">
														<div class="col-sm-4 mb-5">
															<div class="form-group">
																<label for="guardian_relation" class="required col-form-label fw-semibold fs-6">Guardian Relation</label>

																<input id="guardian_relation" name="guardian_relation" placeholder="" type="text" class="form-control form-control-md" value=" <?php echo set_value('guardian_relation', $student['guardian_relation']); ?>" />
															</div>
														</div>
														<div class="col-sm-4 mb-5">
															<div class="form-group">
																<label for="guardian_email" class="required col-form-label fw-semibold fs-6">Guardian Email</label>

																<input id="guardian_email" name="guardian_email" placeholder="" type="text" class="form-control form-control-md" value=" <?php echo set_value('guardian_email', $student['guardian_email']); ?>" />
															</div>
														</div>
														<div class="col-sm-6 mb-5">
															<div class="form-group">
																<label for="guardian_address" class="required col-form-label fw-semibold fs-6">Guardian Address</label>

																<textarea class="form-control form-control-md" rows=" 2" name="guardian_address" cols="50" id="guardian_address"><?php echo $student['guardian_address'] ?></textarea>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-9">
															<div class="form-group">
																<label for="mothers_name" class="required col-form-label fw-semibold fs-6">Mothers Maiden Name</label>

																<input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control form-control-md" value=" <?php echo set_value('mother_name', $student['mother_name']); ?>" />
															</div>
														</div>
													</div>
													<div class="row">
														<div class="card-footer">
															<div id="submitDiv" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																<button type="submit" id="btn_update" class="btn btn-lg btn-success" value="Update"> <i class="fa fa-save"></i>
																	Update Profile
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>