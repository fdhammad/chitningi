<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-university"></i>
						Departments
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all"><i class="icon icon-home2"></i>All department</a>
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
						<h5 class="card-title"><i class="icon icon-pen"></i> Add Department</h5>
					</div>
					<div class="card-body">

						<form id="department" method="post" class="needs-validation" novalidate accept-charset="utf-8">

							<?php if ($this->session->flashdata('msg')) { ?>
								<?php echo $this->session->flashdata('msg') ?>
							<?php } ?>
							<?php echo $this->customlib->getCSRF(); ?>

							<div class="form-group">
								<label><?php echo 'Department Name'; ?> </label><small class="req"> *</small>
								<input autofocus="" id="name" name="name" placeholder="" type="text" class="form-control" value="<?php echo set_value('name'); ?>" required />
								<span class="text-danger"><?php echo form_error('name'); ?></span>
							</div>
							<div class="form-group">
								<label><?php echo get_phrase('school'); ?></label>

								<select autofocus="" id="school_id" name="school_id" class="form-control" required>
									<option value=""><?php echo get_phrase('select'); ?></option>
									<?php
									foreach ($schoollist as $school) {
									?>
										<option value="<?php echo $school['id'] ?>" <?php
																					if (set_value('school_id') == $school['id']) {
																						echo "selected = selected";
																					}
																					?>><?php echo $school['school'] ?></option>

									<?php

									}
									?>
								</select>

							</div>
							<div class="card-footer">
								<button id="department_button" type="submit" class="btn btn-info pull-right"><?php echo get_phrase('save'); ?></button>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card r-0 shadow">
					<div class="card-header danger text-white text-uppercase">
						<h5 class="card-title"><i class="icon icon-clipboard-list"></i> Department List</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>S/N</th>
											<th><?php echo 'Name'; ?></th>
											<th><?php echo 'School'; ?></th>
											<th class="text-right"><?php echo get_phrase('action'); ?></th>
										</tr>
									</thead>
									<tbody>

										<?php
										$count = 1;
										$s = 1;
										foreach ($departmentlist as $department) {
										?>
											<tr>
												<td><?php echo $s++; ?> </td>
												<td id="td_department-<?php echo $department['id'] ?>"> <?php echo $department['name'] ?></td>
												<td id="td_school-<?php echo $department['id'] ?>"> <?php echo $department['school'] ?></td>
												<td class="text-right">


													<a href="javascript:void(0)" data-id="<?php echo $department['id']; ?>" id="<?php echo $department['id']; ?>" class="edit-product" data-toggle="tooltip" title="Edit" data-original-title="Edit">
														<i class="icon-edit mr-3"></i>
													</a>

													<a href="<?php echo base_url(); ?>admin/departments/delete/<?php echo $department['id'] ?>" class="delete" id="<?php echo $department['id']; ?>" data-toggle="tooltip" title="Delete" data-original-title="DeleteDelete">
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
						<label for="department" class="col-sm-2 control-label">Department</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="modal_name" name="modal_name" placeholder="Department Name" value="" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="cod" class="col-sm-2 control-label">School</label>
						<div class="col-sm-12">
							<div class="form-group">
								<label for=""></label>
								<select autofocus="" id="modal_school_id" name="modal_school_id" class="form-control" required>
									<option value=""><?php echo get_phrase('select'); ?></option>
									<?php
									foreach ($schoollist as $school) {
									?>
										<option value="<?php echo $school['id'] ?>" <?php
																					if (set_value('school_id') == $school['id']) {
																						echo "selected = selected";
																					}
																					?>><?php echo $school['school'] ?></option>

									<?php

									}
									?>
								</select>
							</div>
						</div>
					</div>


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
