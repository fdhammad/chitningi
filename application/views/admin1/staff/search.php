<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-user"></i>
						Staff Directory
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" href="<?php echo base_url('admin/staff') ?>" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>All Staff</a>
					</li>
					<li>
						<a class="nav-link" href="<?php echo base_url('admin/staff/disablestafflist') ?>" role="tab" aria-controls="v-pills-all"><i class="icon icon-user-times"></i>Suspended Staff</a>
					</li>
					<li>
						<a class="nav-link" href="<?php echo base_url('admin/staff/create') ?>" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-user-plus"></i>Add New Staff</a>
					</li>

				</ul>
			</div>
		</div>
	</header>
	<?php if ($this->session->flashdata('toast')) { ?>
		<?php echo $this->session->flashdata('toast') ?>
	<?php } ?>
	<?php echo $this->customlib->getCSRF(); ?>
	<div class="container-fluid my-3">

		<div class="row">

			<div class="col-md-12">
				<?php if ($this->session->flashdata('msg')) { ?>
					<?php echo $this->session->flashdata('msg') ?>
				<?php } ?>
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							<a class="btn btn-primary float-right text-white" href="<?php echo base_url(); ?>/admin/staff/create"><i class="fas fa-plus"></i> Add New Staff</a>
						</div>
					</div>
					<div class="card-body">

						<div class="row">
							<div class="col-md-6">
								<form role="form" action="<?php echo site_url('admin/staff') ?>" method="post" class="">
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="col-sm-12">
										<div class="form-group">
											<label><?php echo get_phrase("role"); ?></label><small class="req"> *</small>
											<select name="role" class="form-control">
												<option value=""><?php echo get_phrase("select"); ?></option>
												<?php foreach ($role as $key => $role_value) {
												?>
													<option <?php
															if ($role_id == $role_value["type"]) {
																echo "selected";
															}
															?> value="<?php echo $role_value['type'] ?>"><?php echo $role_value['type'] ?></option>
												<?php }
												?>
											</select>
											<span class="text-danger"><?php echo form_error('role'); ?></span>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="icon icon-search"></i> <?php echo get_phrase('search'); ?></button>
										</div>
									</div>
							</div>
							</form>
							<div class="col-md-6">
								<form role="form" action="<?php echo site_url('admin/staff') ?>" method="post" class="">
									<?php echo $this->customlib->getCSRF(); ?>
									<div class="col-sm-12">
										<div class="form-group">
											<label><?php echo get_phrase('search_by_keyword'); ?></label>
											<input type="text" name="search_text" class="form-control" placeholder="<?php echo get_phrase('search_by_staff'); ?>">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="search" value="search_full" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="icon icon-search"></i> <?php echo get_phrase('search'); ?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row my-3">
			<div class="col-12 col-xl-12">
				<div class="card shadow">
					<div class="card-header bg-primary text-white text-uppercase text-center download_label">
						<h4><?php echo  'Staff List'; ?></h4>
						<div class="row justify-content-end">
							<div class="col">
								<ul id="myTab4" role="tablist" class="nav nav-tabs card-header-tabs nav-material nav-material-white float-left">
									<li class="nav-item">
										<a class="nav-link active show" id="tab1" data-toggle="tab" href="#v-pills-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="true">List</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="tab2" data-toggle="tab" href="#v-pills-tab2" role="tab" aria-controls="tab2" aria-selected="false">Grid</a>
									</li>

								</ul>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1">


								<div class="table-responsive">
									<table id="basic" class="table table-bordered table-hover">
										<thead>
											<tr>
												<!-- <th>COLLEGE NO</th> -->
												<th>#</th>
												<th>NAME</th>
												<!-- <th>COURSE</th> -->

												<th>GENDER</th>
												<th>EMAIL</th>
												<th>PHONE</th>
												<th>ACTION</th>
											</tr>
										</thead>

										<tbody>
											<?php
											if (empty($resultlist)) {
											?>
												<tr>
													<td colspan="12" class="text-danger text-center"><?php echo get_phrase('no_record_found'); ?></td>
												</tr>
												<?php
											} else {
												$count = 1;
												foreach ($resultlist as $staff) {
												?>
													<tr>
														<td>
															<div class="image mr-3 avatar-md float-left">
																<img class="avatar-md circle" src="<?php if (!empty($staff['image'])) {
																										echo base_url() . $staff['image'];
																									} else {
																										echo base_url() . "uploads/staff_image/no_image.png";
																									} ?>" alt="Staff Image"></span>
															</div>
														</td>
														<td class="text-uppercase">
															<a href="<?php echo base_url(); ?>admin/staff/view/<?php echo $staff['id']; ?>"><?php echo $staff['firstname'] . " " . $staff['lastname']; ?>
															</a>
														</td>
														<td><?php echo $staff['gender'] ?></td>
														<td><?php echo $staff['email'] ?></td>
														<td><?php echo $staff['contact_no'] ?></td>

														<td>


															<a href="<?php echo base_url(); ?>admin/staff/view/<?php echo $staff['id'] ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="View Student Details" data-original-title="View">
																<i class="icon-eye"></i>
															</a>

															<a href="<?php echo base_url(); ?>admin/staff/edit/<?php echo $staff['id'] ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Student" data-original-title="Edit Student">
																<i class="icon-pencil"></i>
															</a>


															<button type="submit" class="btn btn-danger btn-xs delete" id="<?php echo $staff['id']; ?>"> <i class="icon-trash"></i></button>

														</td>
													</tr>
											<?php }
											}; ?>
										</tbody>

									</table>

								</div>
							</div>
							<div class="tab-pane fade text-center p-5" id="v-pills-tab2" role="tabpanel" aria-labelledby="v-pills-tab2">
								<div class="row">
									<?php
									if (empty($resultlist)) {
									?>
										<h4 class="card header text-center"> No Record Found</h4>
										<?php
									} else {
										foreach ($resultlist as $staff) { ?>
											<div class="col-md-4 mb-4">
												<div class="card shadow p-4">
													<div>
														<div class="image mr-3 avatar-xl float-left">
															<img class="avatar-xl circle" src="<?php if (!empty($staff['image'])) {
																									echo base_url() . $staff['image'];
																								} else {
																									echo base_url() . "uploads/staff_image/no_image.png";
																								} ?>" alt="Staff Image"></span>
														</div>
														<div class=" text-left mt-1">

															<div>
																<strong class="text-uppsercase"><?php echo $staff['firstname'] . " " . $staff['lastname']; ?></strong>
															</div>
															<div>
																<strong><?php echo $staff['email']; ?></strong>
															</div>
															<small> <?php echo  $staff['contact_no'] ?></small>


															<div class="mt-1">
																<a href="<?php echo base_url('admin/staff/view/' . $staff['id']); ?>" class="btn btn-xs btn-primary">View Profile</a>
															</div>
														</div>
													</div>
												</div>
											</div>
									<?php }
									} ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
