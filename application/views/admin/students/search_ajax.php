<div class="container-fluid">
	<div class="row my-3">
		<div class="col-12 col-xl-12">
			<div class="card shadow">
				<div class="card-header danger text-white text-uppercase text-center download_label">
					<h4><?php echo  'Student Report'; ?></h4>
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

							<?php if ($searchby == "filter") { ?>
								<!-- <div class="float-right"> <a href="<?php echo base_url(); ?>admin/students/generatePDF2/<?php echo $course_id . '/' . $class_id ?>" class="btn btn-outline-primary btn-sm" type="button" name="generate" title="Generate List"><i class="icon-download"></i> <?php echo 'Generate Student List'; ?></a></div>
								<div class="float-right"> <a href="<?php echo base_url(); ?>admin/students/pdf" class="btn btn-outline-primary btn-sm mr-3" type="button" name="generate" target="_blank" title="Generate List by Level"><i class="icon-download"></i> <?php echo 'Generate List by Level'; ?></a></div>
							 --><?php } ?>
							<div class="float-right"> <a href="<?php echo base_url(); ?>admin/students/getListOfStudentsPDF/<?php echo $course_id . '/' . $class_id ?>" class="btn btn-outline-primary btn-sm mr-3" type="button" name="generate" target="_blank" title="Generate List by Level"><i class="icon-download"></i> <?php echo 'Generate List by Level'; ?></a></div>
							<table id="basic" class="table table-bordered table-hover">
								<div class="table-responsive">
									<thead>
										<tr>
											<th>COLLEGE NO</th>
											<!-- <th>JAMB NO</th> -->
											<th>NAME</th>
											<th>COURSE</th>
											<th>LEVEL</th>
											<th>GENDER</th>
											<th>STATE</th>
											<th>L.G.A</th>
											<th>ACTION</th>
										</tr>
									</thead>

									<tbody>
										<?php
										if (empty($result)) {
										?>
											<tr>
												<td colspan="12" class="text-danger text-center"><?php echo get_phrase('no_record_found'); ?></td>
											</tr>
											<?php
										} else {
											$count = 1;
											foreach ($result as $student) {
											?>
												<tr>
													<td><?php echo $student['reg_no']; ?></td>
													<!-- <td><?php echo $student['jamb_no']; ?></td> -->
													<td class="text-uppercase">
														<a href="<?php echo base_url(); ?>admin/students/view/<?php echo $student['id']; ?>"><?php echo $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename']; ?>
														</a>
													</td>
													<td><?php echo  $student['code'] ?></td>
													<td><?php echo $student['class'] ?></td>
													<td><?php echo $student['gender'] ?></td>
													<td><?php if ($student['state_id'] == 5) { ?><span class="r-3 badge badge-success"><?php echo $student['state']; ?></span>
														<?php
														} else { ?><span class="r-3 badge badge-warning "><?php echo $student['state']; ?></span> <?php }; ?></td>
													<td> <?php echo $student['local_g'] ?></td>
													<td>


														<a href="<?php echo base_url(); ?>admin/students/view/<?php echo $student['id'] ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="View Student Details" data-original-title="View">
															<i class="icon-eye"></i>
														</a>

														<a href="<?php echo base_url(); ?>admin/students/edit/<?php echo $student['id'] ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Student" data-original-title="Edit Student">
															<i class="icon-pencil"></i>
														</a>


														<button type="submit" class="btn btn-danger btn-xs delete" id="<?php echo $student['id']; ?>"> <i class="icon-trash"></i></button>

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
							if (empty($result)) {
							?>
								<h4 class="card header text-center"> No Record Found</h4>
								<?php
							} else {
								foreach ($result as $student) { ?>
									<div class="col-md-4 mb-4">
										<div class="card shadow p-4">
											<div>
												<div class="image mr-3 avatar-xl float-left">
													<img class="avatar-xl circle" src="<?php if (!empty($student['image'])) {
																							echo base_url() . $student['image'];
																						} else {
																							echo base_url() . "uploads/student_images/no_image.png";
																						} ?>" alt="Student Image"></span>
												</div>
												<div class=" text-left mt-1">
													<div>
														<strong><?php echo $student['reg_no']; ?></strong>
													</div>
													<div>
														<strong class="text-uppsercase"><?php echo $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename']; ?></strong>
													</div>
													<small> <?php echo  $student['code'] ?></small>
													<small> <?php echo $student['class'] ?></small>
													<div class="">
														<small> <?php if ($student['state_id'] == 5) { ?><span class="r-3 badge badge-success"><?php echo $student['state']; ?></span>
															<?php
																} else { ?><span class="r-3 badge badge-warning "><?php echo $student['state']; ?></span> <?php }; ?></small>
													</div>
													<small> <?php echo $student['local_g'] ?></small>
													<div class="mt-1">
														<a href="<?php echo base_url('admin/students/view/' . $student['id']); ?>" class="btn btn-xs btn-primary">View Profile</a>
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