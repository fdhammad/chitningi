<div class="page has-sidebar-left bg-light height-full">
	<header class="danger accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row">
				<div class="col">
					<h3 class="my-3">
						<i class="icon icon-note-important"></i>
						<?php echo get_phrase('system_settings'); ?> <span class="s-14"> <a class="btn btn-outline-primary btn-xs" href="https://getbootstrap.com/docs/4.0/components/forms/" target="_blank"> View Plugin Docs</a> </span>
					</h3>
				</div>
			</div>
		</div>
	</header>
	<div class="container-fluid my-3">
		<div class="d-flex row">
			<div class="col-md-7">
				<!-- Basic Validation -->
				<div class="card mb-3 shadow no-b r-0">
					<div class="card-header white">
						<h6><?php echo get_phrase('update_system_settings'); ?></h6>
					</div>
					<div class="card-body">
						<form id="setting" href="<?= site_url('') ?>admin/settings/update/" method="POST" class="needs-validation" novalidate>
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="system_name"><?php echo get_phrase('system_name'); ?><span class="required">*</span></label>
									<input type="text" name="system_name" id="system_name" class="form-control" value="<?php echo get_settings('system_name');  ?>" required>
									<div class="valid-feedback">
										Looks good!
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<label for="system_title"><?php echo get_phrase('system_title'); ?><span class="required">*</span></label>
									<input type="text" name="system_title" id="system_title" class="form-control" value="<?php echo get_settings('system_title');  ?>" required>
									<div class="valid-feedback">
										Looks good!
									</div>
								</div>

							</div>
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="system_email"><?php echo get_phrase('system_email'); ?><span class="required">*</span></label>
									<input type="text" name="system_email" id="system_email" class="form-control" value="<?php echo get_settings('system_email');  ?>" required>
									<div class="valid-feedback">
										Looks good!
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<label for="phone"><?php echo get_phrase('phone'); ?></label>
									<input type="text" name="phone" id="phone" class="form-control" value="<?php echo get_settings('phone');  ?>">
									<div class="valid-feedback">
										Looks good!
									</div>

								</div>
								<div class="col-md-6 mb-3">
									<label for="website_description"><?php echo get_phrase('system_description'); ?></label>
									<textarea name="website_description" id="website_description" class="form-control" rows="5"><?php echo get_settings('website_description');  ?></textarea>
									<div class="valid-feedback">
										Looks good!
									</div>

								</div>
								<div class="col-md-6 mb-3">
									<label for="address"><?php echo get_phrase('address'); ?></label>
									<textarea name="address" id="address" class="form-control" rows="5"><?php echo get_settings('address');  ?></textarea>
									<div class="valid-feedback">
										Looks good!
									</div>

								</div>
							</div>
							<div class="form-row">
								<div class="col-md-5 mb-3">
									<div class="form-group">
										<label for=""><?php echo get_phrase('admission_session'); ?></label>
										<select class="form-control" name="adm_session" id="">
											<?php
											foreach ($sessionlist as $session) {
											?>
												<option value="<?php echo $session['id'] ?>"><?php echo $session['session'] ?></option>
											<?php
											}
											?>
										</select>
										<div class="valid-feedback">
											Looks good!
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-4 mb-3">
									<div class="form-group">
										<label for=""><?php echo get_phrase('session'); ?></label>
										<select class="form-control" name="session" id="">
											<?php
											foreach ($sessionlist as $session) {
											?>
												<option value="<?php echo $session['id'] ?>"><?php echo $session['session'] ?></option>
											<?php
											}
											?>
										</select>
										<div class="valid-feedback">
											Looks good!
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group">
										<label for=""><?php echo get_phrase('semester'); ?></label>
										<select class="form-control" name="semester" id="">
											<?php
											foreach ($semesterlist as $semester) {
											?>
												<option value="<?php echo $semester['id'] ?>"><?php echo $semester['semester'] ?></option>
											<?php
											}
											?>
										</select>
										<div class="valid-feedback">
											Looks good!
										</div>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6 mb-3">
									<div class="form-group">
										<label for="footer_text"><?php echo get_phrase('footer_text'); ?></label>
										<input type="text" name="footer_text" id="footer_text" class="form-control" value="<?php echo get_settings('footer_text');  ?>">
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<div class="form-group">
										<label for="footer_link"><?php echo get_phrase('footer_link'); ?></label>
										<input type="text" name="footer_link" id="footer_link" class="form-control" value="<?php echo get_settings('footer_link');  ?>">
									</div>
								</div>
							</div>

							<button class="btn btn-primary" id="setting_button" type="submit">Submit form</button>
						</form>


					</div>
				</div>
				<!-- #END# Basic Validation -->

			</div>
			<div class="col-md-5">

				<div class="card">
					<div class="card-header">
						<h4 class="mb-3 header-title"><?php echo get_phrase('update_favicon'); ?></h4>
					</div>
					<div class="card-body">
						<div class="col-lg-12">

							<div class="row justify-content-center">
								<form id="favicon" method="post" enctype="multipart/form-data" style="text-align: center;">
									<div class="form-group mb-2">

										<div class="box" style="width: 250px;">
											<input type="file" id="image" class="dropify" name="file" data-plugins="dropify" data-default-file="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" data-max-file-size="1M" />
											<p class="text-muted text-center mt-2 mb-0">Upload Favicon Logo</p>
											<span class="text-danger"><?php echo form_error('file'); ?></span>
										</div>
									</div>

									<button id="favicon_button" type="submit" class="btn btn-primary btn-block"><?php echo get_phrase('save_favicon'); ?></button>
								</form>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
