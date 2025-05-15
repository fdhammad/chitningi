<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-time"></i>
						Semesters
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>All Semesters</a>
					</li>

				</ul>
			</div>
		</div>
	</header>
	<div class="container-fluid my-3">
		<div class="row">
			<div class="col-md-4">
				<?php if ($this->session->flashdata('toast')) { ?>
					<?php echo $this->session->flashdata('toast') ?>
				<?php } ?>
				<div class="card shadow r-0">
					<div class="card-header danger text-white text-uppercase">
						<h5 class="card-title"><i class="icon icon-pen"></i> Add Semester</h5>
					</div>
					<div class="card-body">

						<form id="semester" action="<?php echo site_url('admin/semesters/create') ?>" method="post" class="needs-validation" novalidate accept-charset="utf-8">

							<?php if ($this->session->flashdata('msg')) { ?>
								<?php echo $this->session->flashdata('msg') ?>
							<?php } ?>
							<?php echo $this->customlib->getCSRF(); ?>

							<div class="form-group">
								<label><?php echo 'Semester Name'; ?> </label><small class="req"> *</small>
								<input autofocus="" id="semester" name="semester" placeholder="" type="text" class="form-control" value="<?php echo set_value('semester'); ?>" required />
								<span class="text-danger"><?php echo form_error('semester'); ?></span>
							</div>
							<div class="card-footer">
								<button id="semester_button" type="submit" class="btn btn-info pull-right"><?php echo get_phrase('save'); ?></button>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card r-0 shadow">
					<div class="card-header danger text-white text-uppercase">
						<h5 class="card-title"><i class="icon icon-clipboard-list"></i> Semester List</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>S/N</th>
											<th><?php echo 'Name'; ?></th>
											<th><?php echo 'Status'; ?></th>
											<th class="text-right"><?php echo get_phrase('action'); ?></th>
										</tr>
									</thead>
									<tbody>

										<?php
										$count = 1;
										$s = 1;
										foreach ($semesterlist as $semester) {
										?>
											<tr>
												<td><?php echo $s++; ?> </td>
												<td id="td_semester-<?php echo $semester['id'] ?>"> <?php echo $semester['semester'] ?></td>
												<td><?php
													if ($semester['active'] != 0) {
													?>
														<span class="badge badge-count badge-success"><?php echo get_phrase('active'); ?></span>
													<?php
													} else {
													}
													?>
												</td>
												<td class="text-right">

													<a href="javascript:void(0)" data-id="<?php echo $semester['id']; ?>" id="<?php echo $semester['id']; ?>" class="edit-product" data-toggle="tooltip" title="Edit" data-original-title="Edit">
														<i class="icon-edit mr-3"></i>
													</a>

													<a href="<?php echo base_url(); ?>admin/semesters/delete/<?php echo $semester['id'] ?>" class="delete" id="<?php echo $semester['id']; ?>" data-toggle="tooltip" title="Delete" data-original-title="Delete">
														<i class="text-danger icon icon-trash mr-3"></i>
													</a>

												</td>
											</tr>
										<?php
										}
										$count++;
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Model for add edit product -->
<div class="modal fade" id="ajax-product-modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="productCrudModal"></h4>
			</div>
			<div class="modal-body">
				<form id="productForm" name="productForm" class="form-horizontal">
					<input type="hidden" name="modal_id" id="modal_id">

					<div class="form-group">
						<label for="semester" class="col-sm-2 control-label">Semester</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="modal_semester" name="modal_semester" placeholder="Semester" value="" required="">
						</div>
					</div>
					<!-- 
					<div class="form-group">
						<label for="cod" class="col-sm-2 control-label">Code</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="modal_code" name="modal_code" placeholder="School Code" value="" required="">
						</div>
					</div> -->


					<!-- <div class="form-group">
						<label for="name" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="status" name="status" placeholder="Enter Status" value="" required="">
						</div>
					</div> -->
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
						</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
