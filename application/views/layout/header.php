<link rel="favicon" href="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">
<link rel="apple-touch-icon" href="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">

<?php if ($page_name == "home1" || $page_name == "admission" || $page_name == "applicant_login" || $page_name == "staff_login" || $page_name == "login"): ?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="<?php echo base_url() ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

<?php elseif ($page_name == "home"): ?>

	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" type="text/css" />


<?php endif; ?>