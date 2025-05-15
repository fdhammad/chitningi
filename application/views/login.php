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
	<!--begin::Authentication - Sign-in -->
	<div class="d-flex flex-column flex-lg-row flex-column-fluid">
		<!--begin::Aside-->
		<div class="d-flex flex-lg-row-fluid">
			<!--begin::Content-->
			<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
				<!--begin::Image-->
				<img class="theme-light-show mx-auto mw-100 w-100px w-lg-150px mb-10 mb-lg-20"
					src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="" />
				<img class="theme-dark-show mx-auto mw-100 w-100px w-lg-150px mb-10 mb-lg-20"
					src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" alt="" />
				<!--end::Image-->
				<!--begin::Title-->
				<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
					<?php echo get_settings('system_name'); ?>
				</h1>
				<!--end::Title-->
				<!--begin::Text-->
				<div class="text-gray-600 fs-base text-center fw-semibold">Students can access their respective portals
					and pay their fees, do online course registrations<br> apply for accommodation, check their semester
					results and more.
				</div>
				<!--end::Text-->
			</div>
			<!--end::Content-->
		</div>
		<!--begin::Aside-->
		<!--begin::Body-->
		<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
			<!--begin::Wrapper-->
			<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
				<!--begin::Content-->
				<div class="w-md-400px">
					<!--begin::Form-->
					<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-redirect-url="#"
						method="POST" action="<?= base_url('login/login') ?>">
						<!--begin::Heading-->
						<div class="text-center mb-11">
							<!--begin::Title-->
							<h1 class="text-dark fw-bolder mb-3">Student Login</h1>
							<!--end::Title-->
							<!--begin::Subtitle-->
							<!-- 	<div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div> -->
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
							<!-- <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span> -->
						</div>
						<!--end::Separator-->
						<!--begin::Input group=-->
						<div class="fv-row mb-8">
							<!--begin::Email-->
							<input id="username" type="text" placeholder="Reg Number" name="username" autocomplete="off"
								class="form-control bg-transparent" required />
							<!--end::Email-->
						</div>
						<!--end::Input group=-->
						<div class="fv-row mb-3">
							<!--begin::Password-->
							<input id="password" type="password" placeholder="Password" name="password"
								autocomplete="off" class="form-control bg-transparent" />
							<!--end::Password-->
						</div>
						<!--end::Input group=-->
						<!--begin::Wrapper-->
						<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
							<div></div>
							<!--begin::Link-->
							<a href="#" class="link-primary">Forgot Password ?</a>
							<!--end::Link-->
						</div>
						<!--end::Wrapper-->
						<!--begin::Submit button-->
						<div class="d-grid mb-10">
							<button type="submit" id="submit" class="btn btn-primary">
								<!--begin::Indicator label-->
								<span class="indicator-label">Sign In</span>
								<!--end::Indicator label-->
								<!--begin::Indicator progress-->
								<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								<!--end::Indicator progress-->
							</button>
						</div>
						<!--end::Submit button-->
						<!--begin::Sign up-->
						<!-- <div class="text-gray-500 text-center fw-semibold fs-6">Not an Applicant yet?
							<a href="<?= base_url('admission') ?>" class="link-primary">Register</a>
						</div> -->
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
	<!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->