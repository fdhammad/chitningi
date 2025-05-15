<!--begin::Theme mode setup on page load-->
<script>
	var defaultThemeMode = "light";
	var themeMode;
	if (document.documentElement) {
		if (document.documentElement.hasAttribute("data-theme-mode")) {
			themeMode = document.documentElement.getAttribute("data-theme-mode");
		} else {
			if (localStorage.getItem("data-theme") !== null) {
				themeMode = localStorage.getItem("data-theme");
			} else {
				themeMode = defaultThemeMode;
			}
		}
		if (themeMode === "system") {
			themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
		}
		document.documentElement.setAttribute("data-theme", themeMode);
	}
</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
	<!--begin::Page bg image-->
	<style>
		body {
			background-image: url('<?= base_url('') ?>assets/media/auth/bg10.jpeg');
		}

		[data-theme="dark"] body {
			background-image: url('<?= base_url('') ?>assets/media/auth/bg10-dark.jpeg');
		}
	</style>
	<!--end::Page bg image-->
	<!--begin::Authentication - Sign-up -->
	<div class="d-flex flex-column flex-lg-row flex-column-fluid">
		<!--begin::Aside-->
		<div class="d-flex flex-lg-row-fluid">
			<!--begin::Content-->
			<div class="d-flex flex-column flex-top pb-0 pb-sm-10 p-10 w-100">
				<!--begin::Image-->
				<img class="theme-light-show mx-auto mw-100 w-150px w-sm-80px mb-3 mb-sm-10"
					src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="" />
				<img class="theme-dark-show mx-auto mw-100 w-150px w-sm-80px mb-3 mb-sm-10"
					src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="" />
				<!--end::Image-->
				<!--begin::Title-->
				<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-2">Online Application Portal</h1>
				<!--end::Title-->
				<!--begin::Text-->
				<div class="text-gray-600 fs-base text-left fw-semibold p-10">
					<p class="">Start your application into
						<?= get_settings('system_name'); ?> here. We are available to answer
						all your questions and support you.
					</p>
					<!-- <a href="" class="btn btn-primary btn-block text-center mt-5"> Learn more about our programme</a> -->
					<!-- <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
					<br />and provides some background information about
					<a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
					<br />work following this is a transcript of the interview. -->

					<div class="row">
						<div class="col-xl-12">
							<!--begin::Block-->
							<div class="py-5">
								<div class="card shadow-sm">
									<div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
										data-bs-target="#kt_guideline">
										<h3 class="card-title">Application Guideline</h3>
										<div class="card-toolbar rotate-180">
											<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
											<span class="svg-icon svg-icon-1"><svg width="24" height="24"
													viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path
														d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
														fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
									</div>
									<div id="kt_guideline" class="collapse">
										<div class="card-body">
											<div class="row">
												<div class="col-md-6 col-sm-12">
													<h5><b>1. ACCOUNT ACTIVATION</b></h5>
													<ul>

														<li>
															Enter your Name, a valid email address and a valid phone
															number (ensure that it is your phone number for it will be
															used in subsequent communication with you).
														</li>
														<li>
															You will be redirected to the Welcome page.
														</li>
													</ul>
													<h5><b>2. PAYMENT</b></h5>
													<ul>
														<li>
															Verify the information you entered on the page, then choose
															a payment option. Following a successful transaction, you
															would continue by completing your application. Your names
															and other pertinent information must be included together
															with your personal data. The major method of communication
															for your application will be by phone, so you must have a
															working number.</li>

													</ul>

													<h5><b>3. UPLOADING PASSPORT</b></h5>
													<ul>
														<li>
															You are required to upload your recent passport photograph
															that is very clear and with a plain background. The picture
															should be a JPEG or PNG format.</li>
													</ul>
												</div>
												<div class="col-md-6 col-sm-12">
													<h5><b>4. CHOICE OF PROGRAMME</b></h5>
													<ul>
														<li>
															You are required to select the choice of your programme of
															study from the list of available programmes.</li>

													</ul>

													<h5><b>5. EDUCATIONAL QUALIFICATIONS</b></h5>
													<ul>
														<li>
															You are expected to enter not more than two sittings of
															O’level Examination results <br>
														</li>
														<li>
															In addition to the above, You are expected to enter grade
															details of relevant O’level results (SSCE/WAEC/GCE/NECO
															etc).
														</li>
														<li>
															You are also required to specify the centre number and exam
															number of all the results you have entered.
														</li>
													</ul>
													<h5><b>6. APPLICATION SUBMISSION</b></h5>
													<ul>
														<li>
															After filling all the necessary information, you should
															submit the application by clicking on the 'Submit' button.
															Before final submission of the application, cross check to
															ensure all the information are correct.
														</li>
													</ul>
													<h5><b>7. PRINTING OF APPLICATION FORM</b></h5>
													<ul>
														<li>
															After successful submission of the application, your
															application page is displayed. The Serial Number on your
															slip is your Application ID. Click on Print Application to
															print it..</li>
													</ul>
												</div>
											</div>

										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end::Block-->
					<div class="py-5">
						<div class="card shadow-sm">
							<div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
								data-bs-target="#kt_programme">
								<h3 class="card-title">Programmes</h3>
								<div class="card-toolbar rotate-180">
									<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
									<span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24"
											fill="none" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
												fill="currentColor" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
							</div>
							<div id="kt_programme" class="collapse">
								<div class="card-body">
									<div class="row">
										<?php $departments = $this->db->get('departments')->result();
										$count = 1;
										foreach ($departments as $key => $dept) {
											$courses = $this->db->get_where('courses', array('department_id' => $dept->id))->result();
											?>
											<div class="col-md-6 col-sm-12">
												<ul>
													<h3>
														<?= $count++ . ". Dept of " . $dept->name; ?>
													</h3>
													<?php foreach ($courses as $key => $course) { ?>
														<li>
															<?= $course->name ?>
														</li>
													<?php } ?>


												</ul>
											</div>
										<?php }
										?>


									</div>
								</div>

							</div>
						</div>
					</div>
					<div class="fv-row">
						<div class="row ">
							<div class="col-12">
								<span class="d-block fw-semibold text-center">
									<span class="text-muted fw-semibold fs-6">For any Inquiry contact</span>
									<span class="text-dark fw-bold d-block fs-4 mb-2">Info@chtningi.edu.ng.</br>
										0806 6880 055, 0806 221 8873, 0803 6152 791
									</span>
								</span>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!--end::Content-->
		</div>
		<!--begin::Aside-->
		<!--begin::Body-->
		<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
			<!--begin::Wrapper-->
			<div class="bg-body flex-center rounded-4 w-md-700px p-10">
				<!--begin::Content-->
				<div class="w-md-600px">
					<!--begin::Form-->
					<form class="form w-100" novalidate="novalidate" id="reg" method="POST"
						action="<?= base_url('admission/register') ?>">
						<!--begin::Heading-->
						<div class="text-center mb-11">
							<!--begin::Title-->
							<h1 class="text-dark fw-bolder mb-3">Register</h1>
							<!--end::Title-->
							<!--begin::Subtitle-->
							<div class="text-gray-500 fw-semibold fs-6">Create New Account</div>
							<!--end::Subtitle=-->
						</div>
						<!--begin::Heading-->
						<?php if (isset($error_message)) {
							echo "<div class='alert alert-danger'>" . $error_message . "</div>";
						} ?>
						<div id='err_msg' style='display: none'>
							<div id='content_result'>
								<div id='err_show' class="w3-text-red">
									<div id='msg' class='alert alert-danger'> </div></label>
								</div>
							</div>
						</div>
						<!--begin::Separator-->
						<div class="separator separator-content my-14">
							<span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
						</div>
						<!--end::Separator-->
						<!-- <div class="row g-9 mb-8">
							<div class="col-lg-8 fv-row">
								<select name="program_id" aria-label="Select a programme" data-control="select2" data-placeholder="Select a programme..." class="form-select form-select-solid form-select-lg fw-semibold">
									<option value="">Select Programme.</option>
									<option value="1">HND</option>
									<option value="2">National Diploma</option>
									<option value="3">Diploma</option>
								</select>
							</div>
						</div> -->

						<div class="row g-9 mb-8">
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label for="firstname" class="required fs-6 fw-semibold mb-2">First Name</label>
								<input type="text" placeholder="First Name" name="firstname" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label for="lastname" class="required fs-6 fw-semibold mb-2">Last Name</label>
								<input type="text" placeholder="Last name" name="lastname" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
						</div>

						<div class="row g-9 mb-8">
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label class="required fs-6 fw-semibold mb-2">Email</label>
								<input type="text" placeholder="Email" name="email" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-md-6 fv-row">
								<label class="required fs-6 fw-semibold mb-2">Phone Number</label>
								<input type="text" placeholder="Phone Number" name="phone" autocomplete="off"
									class="form-control bg-transparent" />
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-8">
							<!--  //data-kt-password-meter="true" -->
							<!--begin::Wrapper-->
							<div class="mb-1">
								<!--begin::Input wrapper-->
								<div class="position-relative mb-3">
									<input class="form-control bg-transparent" id="password" type="password"
										placeholder="Password" name="password" autocomplete="off" />
									<span
										class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
										<!-- data-kt-password-meter-control="visibility" -->
										<i class="bi bi-eye-slash fs-2"></i>
										<i class="bi bi-eye fs-2 d-none"></i>
									</span>
								</div>
								<!--end::Input wrapper-->
								<!--begin::Meter-->
								<!-- <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
									<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
								</div> -->
								<!--end::Meter-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Hint-->
							<!-- <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div> -->
							<!--end::Hint-->
						</div>
						<!--end::Input group=-->
						<!--end::Input group=-->
						<div class="fv-row mb-8">
							<!--begin::Repeat Password-->
							<input placeholder="Repeat Password" name="confirm_password" type="password"
								autocomplete="off" class="form-control bg-transparent" />
							<!--end::Repeat Password-->
						</div>
						<!--end::Input group=-->
						<!--begin::Accept-->
						<div class="fv-row mb-8">
							<label class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="toc" value="1" />
								<span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
									<a href="#" class="ms-1 link-primary">Terms and Conditions
									</a></span>
							</label>
						</div>
						<!--end::Accept-->
						<!--begin::Submit button-->
						<div class="d-grid mb-10">
							<button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
								<!--begin::Indicator label-->
								<span class="indicator-label">Register</span>
								<!--end::Indicator label-->
								<!--begin::Indicator progress-->
								<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								<!--end::Indicator progress-->
							</button>
						</div>
						<!--end::Submit button-->
						<!--begin::Sign up-->
						<div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
							<a href="<?= site_url('admission/login') ?>" class="link-primary fw-semibold">Login</a>
						</div>
						<!--end::Sign up-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Body-->
	</div>
	<!--end::Authentication - Sign-up-->
</div>
<!--end::Root-->
<!--begin::Javascript-->