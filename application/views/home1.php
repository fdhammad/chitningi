<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('<?= base_url(); ?>assets/media/auth/bg.jpg');
            }

            [data-bs-theme="dark"] body {
                background-image: url('<?= base_url(); ?>assets/media/auth/bg.jpg');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-md-1000px py-5 shadow">
                    <div class="card-body py-15 py-lg-10">
                        <!--begin::Logo-->
                        <div class="mb-7">
                            <a href="<?= base_url(); ?>" class="">
                                <img alt="Logo" src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" class="h-100px w-100px" />
                            </a>
                        </div>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h1 class="fw-bolder text-gray-900 mb-5">Welcome to <span class="text-primary">
                                <?php echo get_settings('system_code'); ?>
                            </span> Student Portal
                        </h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed rounded-3 p-6 mb-5">
                           
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                
                                <!--begin::Content-->
                                <h5 class="fv-row fw-semibold text-right">

                                    <!--<marquee behavior=scroll><strong>
                                            <font color=green>***** <?= current_adm_session_name() ?> SEMESTER REGISTRATION NOW IS OPEN. THANKS *****</font>
                                           
                                        </strong></marquee>--><!--
 <strong><h1 class="text-center text-danger" id="demo"></h1></strong>-->

                                </h5>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Text-->
                        <!--begin::Illustration-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <!--begin::Option-->
                                    <a href="<?= base_url('admission'); ?>" class="">
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                                            <span class="svg-icon svg-icon-3x me-5">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor" />
                                                    <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Info-->
                                            <span class="d-block fw-semibold text-start">
                                                <span class="text-dark fw-bold d-block fs-4 mb-2">Online
                                                    Application</span>
                                                <span class="text-muted fw-semibold fs-6">If you need more info, please
                                                    check it out</span>
                                            </span>
                                            <!--end::Info-->
                                        </label>
                                        <!--end::Option-->
                                    </a>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <!--begin::Option-->
                                    <a href="<?= base_url(); ?>login" class="">

                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="kt_create_account_form_account_type_corporate">
                                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                            <span class="svg-icon svg-icon-3x me-5">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor" />
                                                    <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Info-->
                                            <span class="d-block fw-semibold text-start">
                                                <span class="text-dark fw-bold d-block fs-4 mb-2">Pre-weeding
                                                    Students</span>
                                                <span class="text-muted fw-semibold fs-6">Login for Pre-weeding
                                                    students</span>
                                            </span>
                                            <!--end::Info-->
                                        </label>
                                        <!--end::Option-->
                                    </a>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <!--begin::Option-->
                                    <a href="<?= site_url('login'); ?>" class="">

                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="kt_create_account_form_account_type_corporate">
                                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                            <span class="svg-icon svg-icon-3x me-5">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor" />
                                                    <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Info-->
                                            <span class="d-block fw-semibold text-start">
                                                <span class="text-dark fw-bold d-block fs-4 mb-2">Current
                                                    Students</span>
                                                <span class="text-muted fw-semibold fs-6">Login for Current
                                                    students</span>
                                            </span>
                                            <!--end::Info-->
                                        </label>
                                        <!--end::Option-->
                                    </a>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
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
                    <!--end::Input group-->
                    <!--end::Link-->
                </div>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Signup Welcome Message-->
    </div>
  <div class="modal modal-lg fade" id="ajax-product-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="fs-2x fw-semibold modal-title text-center"> Notice to All Dental Surgery Students</h4>
                </div>
                <div class="modal-body">
                
                    <div class="col-sm-12 pe-0 mb-5 mb-sm-0">
                      
                        <div class="d-flex justify-content-between h-100 flex-column pt-xl-5 pb-xl-2 ps-xl-7">
                           
                            <div class="mb-4">

                                <p><br>



We are pleased to inform you that the 100 Level First Semester results for Dental Surgery have been published. You can now access your results on the student portal.

Please log in to your student account to view your grades. If you encounter any issues or have any questions, do not hesitate to contact the ICT office for assistance.<br>

Thank you, and best of luck with your studies!</p>


<!--<h1 class="text-center"><p class="text-center" id="demo"></p></h1>-->



                              <!--  <p>This is to Inform the Public that Weeding Registration has been Commenced. Use the Guide Below to Register. Thank you</p>-->
                              <!--  <ul class="">
                                    <li class="">
                                        <span class="fw-semibold opacity-75">
                                            1. Check your Name on the Weeding List. Click on this Link to Check Your Name <a href="<?php echo base_url('home/exportweedingfile') ?>" class=" text-active-danger"><span>Weeding List</span></a>
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="fw-semibold opacity-75">
                                            2. Click on this Link to Login <a href="<?php echo base_url('login') ?>" class=" text-active-danger"><span>Login as Pre-weeding student</span></a>
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="fw-semibold opacity-75">
                                            3. Use your Weeding number to as username and password to Login.
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="fw-semibold opacity-75">
                                            4. Change your password and Update your Profile. Note that your recent passport photograph is required.
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="fw-semibold opacity-75">
                                            5. Pay your Weeding Registration fee with ATM Card, USSD, or Bank transfer.
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="fw-semibold opacity-75">
                                            6. Print your Receipt. Done
                                        </span>
                                    </li>
                                </ul>-->
                           </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">-->
                  <!--  <a name="" id="" class="btn btn-primary" href="<?php echo base_url('home/exportweedingfile') ?>" role="button">
                        Check Weeding List
                    </a>-->
                   <!-- <a href="<?php echo base_url('admission') ?>" class="btn btn-success">Apply now</a>
                    <a href="<?php echo base_url('') ?>" class="btn btn-default">Close</a>-->
                </div>
            </div>
        </div>
    </div>

    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "<?= base_url(); ?>assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="<?= base_url(); ?>assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url(); ?>assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
  <script type="text/javascript">
        $(document).ready(function(e) {
            // $('.edit-product').on("click", function() {
            $('#ajax-product-modal').modal('show');
            // });
        });
    </script> 
    	 	<script>
		// Set the date we're counting down to
		//var countDownDate = new Date("Nov 2, 2020 00:00:00").getTime();
		var countDownDate = new Date("Jul 5, 2024 23:59:59").getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {

			// Get today's date and time
			var now = new Date().getTime();

			// Find the distance between now and the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Display the result in the element with id="demo"
			//document.getElementById("demo").innerHTML = "Undergraduate, NCE & PRE-NCE 2nd Semester Registration will commence in " + days + "d " + hours + "h " +
			//minutes + "m " + seconds + "s ";

			document.getElementById("demo").innerHTML = "Admission Application ends in " + days + "d " + hours + "h " +
				minutes + "m " + seconds + "s ";

			// If the count down is finished, write some text
			if (distance < 0) {
				clearInterval(x);
				//document.getElementById("demo").innerHTML = "Registration in Progress";
				document.getElementById("demo").innerHTML = "Application is now Closed, Thank you";
			}
		}, 1000);
	</script> 
</body>
<!--end::Body-->