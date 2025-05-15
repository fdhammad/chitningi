<!DOCTYPE html>
<html lang="en">

<head>
<?php 
if($page_title =='Home'): 
    $title = 'Portal';
    
elseif ($page_title == 'Admission') : 
    $title = 'Online Application' ; 
    else : $title = $page_title; 
endif; 
?>
	<title><?php echo ucwords($title) . ' | ' . get_settings('system_name'); ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5.0, minimum-scale=0.86">
	<meta name="author" content="<?php echo get_settings('author') ?>" />
	<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>" />
	<meta name="description" content="<?php echo get_settings('website_description'); ?>" />
	<meta property="og:title" content="<?php echo ucwords($title) . ' | ' . get_settings('system_name'); ?>" />
	<meta property="og:image" content="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>">

	<meta property="og:url" content="<?php echo current_url(); ?>" />
	<meta property="og:type" content="School Portal" />
	<link name="favicon" type="image/x-icon" href="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" rel="shortcut icon" />
	<?php include 'layout/header.php'; ?>

</head>

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
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
	<?php
	if (get_frontend_settings('cookie_status') == 'active') :
	//include 'eu-cookie.php';
	endif;

	if ($page_name === null) {
		include $path;
	} else {
		include $page_name . '.php';
	}
	include 'layout/footer.php';
	//include 'includes_bottom.php';
	//include 'modal.php';
	include 'layout/scripts.php';
	?>

</body>
