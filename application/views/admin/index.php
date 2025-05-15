<!DOCTYPE html>
<html lang="en">
<?php
$system_name = $this->db->get_where('settings', array('key' => 'system_name'))->row()->value;
$system_title = $this->db->get_where('settings', array('key' => 'system_title'))->row()->value;
$admin_details = $this->staff_model->get_admin($this->session->userdata('user_id'))->row_array();
$text_align     = $this->db->get_where('settings', array('key' => 'text_align'))->row()->value;
$logged_in_user_role = strtolower($this->session->userdata('role'));

//$admin_details = $this->staff_model->get_admin($this->session->userdata('user_id'))->row_array();
$name = $admin_details['firstname'] . ' ' . $admin_details['lastname'];
$id = $admin_details['id'];
$role = $this->session->userdata('role');
?>

<head>

	<!-- <title><?php echo ucwords($page_title) . ' | ' . get_settings('system_name'); ?></title>
 -->
	<title><?php echo get_phrase($page_title); ?> | <?php echo $system_title; ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5.0, minimum-scale=0.86">
	<meta name="author" content="<?php echo get_settings('author') ?>" />
	<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>" />
	<meta name="description" content="<?php echo get_settings('website_description'); ?>" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:title" content="<?php echo $page_title; ?>" />
	<meta property="og:image" content="<?= base_url("uploads/system/" . get_frontend_settings('banner_image')); ?>">
	<meta property="og:url" content="<?php echo current_url(); ?>" />
	<meta property="og:type" content="School management system" />
	<link name="favicon" type="image/x-icon" href="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" rel="shortcut icon" />
	<?php include 'layout/header.php'; ?>

</head>

<body class="light">
	<!-- oncontextmenu="return false" -->
	<div id="loader" class="loader">
		<div class="plane-container">
			<div class="preloader-wrapper small active">
				<div class="spinner-layer spinner-danger">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-red">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-yellow">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-green">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="app">
		<?php include 'layout/sidebar.php';
		?>
		<div class="has-sidebar-left">
			<div class="pos-f-t">
				<div class="collapse" id="navbarToggleExternalContent">
					<div class="bg-dark pt-2 pb-2 pl-4 pr-2">
						<form role="form" action="<?php echo site_url('admin/students/glosearch') ?>" method="post" class="">
							<div class="search-bar">
								<input class="transparent s-24 text-white b-0 font-weight-lighter w-168 height-50" type="text" name="search_text" placeholder="start typing...">
							</div>
						</form>

						<a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
					</div>
				</div>
			</div>
			<div class="sticky">
				<div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar danger accent-3">
					<div class="relative">
						<a href="#" data-toggle="push-menu" class="paper-nav-toggle pp-nav-toggle">
							<i></i>
						</a>
					</div>

					<!--Top Menu Start -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="">
								<p class="session pt-10">
									<a href="#" id="changesession" name="changesession" style="color:white"> <?php echo current_session_name(); ?> / <?php echo current_semester_name(); ?></a>
								</p>

							</li>


							<li>
								<a class="nav-link " data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
									<i class=" icon-search3 "></i>
								</a>
							</li>
							<!-- Right Sidebar Toggle Button -->


							<!-- User Account-->

							<li class="dropdown custom-dropdown user user-menu">
								<a href="#" class="nav-link" data-toggle="dropdown">
									<img src="<?php echo $this->staff_model->get_admin_image_url($this->session->userdata('user_id')); ?>" class="user-image" alt="User Image">
									<i class="icon-more_vert "></i>
								</a>
								<div class="dropdown-menu p-4 dropdown-menu-right">
									<div class="row box justify-content-between my-4">

										<a href="<?php echo base_url() . "admin/staff/edit/" . $id ?>" class="list-group-item list-group-item-action ">
											<i class="mr-2 icon-umbrella text-danger"></i>Profile
										</a>

										<a href="<?php echo base_url() . "admin/staff/changepass/" . $id ?>" class="list-group-item list-group-item-action"><i class="mr-2 icon-security text-purple"></i>Change Password</a>
										<a href="<?php echo base_url(); ?>staff/logout" class="list-group-item list-group-item-action"><i class="mr-2 icon-cogs text-yellow"></i>Logout</a>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<?php
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
