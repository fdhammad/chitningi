<div class="container-fluid">
	<div class="row my-3">
		<div class="col-12 col-xl-12">
			<div class="card shadow">
				<div class="card-header danger text-white text-uppercase text-center">
					<h4 class="download_label"><?php echo  'Applicant Report'; ?></h4>
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


							<!-- <div class="float-right"> <a href="<?php echo base_url(); ?>admin/applicants/generatePDF2/<?php echo $course_id . '/' . $class_id ?>" class="btn btn-outline-primary btn-sm" type="button" name="generate" title="Generate List"><i class="icon-download"></i> <?php echo 'Generate applicant List'; ?></a></div>
								<div class="float-right"> <a href="<?php echo base_url(); ?>admin/applicants/pdf" class="btn btn-outline-primary btn-sm mr-3" type="button" name="generate" target="_blank" title="Generate List by Level"><i class="icon-download"></i> <?php echo 'Generate List by Level'; ?></a></div>
							 -->
							<a href="<?php echo base_url('admin/applicants/applicant_pdf_sorted/') ?>" class="btn btn-outline-primary pdfurl mb-3 float-right" target="_blank"><i class="icon-download"></i> Generate PDF List</a>

							<div class="table-responsive">
								<table id="basic" class="table table-bordered table-hover">
									<thead>
										<tr>
											<!-- 	<th><input type="checkbox" id="select_all" /></th> -->
											<th>APPLICATION NO</th>
											<!-- <th>JAMB NO</th> -->
											<th>NAME</th>
											<th>COURSE</th>

											<th>GENDER</th>
											<th>PHONE</th>
											<th>STATE</th>
											<th>L.G.A</th>
											<th>DATE</th>
											<th>APP STATUS</th>
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
											foreach ($result as $applicant) {
												$datetime = $applicant['created_at'];
												$formattedDate = date("d/m/Y", strtotime($datetime));
												//echo $formattedDate; // Output: 22/12/2024

											?>

												<tr>
													<!-- <td class="text-center"><input type="checkbox" class="checkbox center-block" name="check" data-student_id="<?php echo $applicant['id'] ?>" value="<?php echo $applicant['id'] ?>">
													</td> -->
													<td><?php echo $applicant['application_no']; ?></td>

													<td class="text-uppercase">
														<a href="<?php echo base_url(); ?>admin/applicants/view/<?php echo $applicant['id']; ?>"><?php echo $applicant['firstname'] . " " . $applicant['lastname'] . " " . $applicant['middlename']; ?>
														</a>
													</td>
													<td><?php echo  $applicant['course'] ?></td>

													<td><?php echo $applicant['gender'] ?></td>
													<td><?php echo $applicant['phone'] ?></td>
													<td><?php if ($applicant['state_id'] == 5) { ?><span class="r-3 badge badge-success"><?php echo $applicant['state']; ?></span>
														<?php
														} else { ?><span class="r-3 badge badge-warning text-capitalize"><?php echo $applicant['state']; ?></span> <?php }; ?></td>
													<td> <?php echo $applicant['local_g'] ?></td>
													<td><?php echo $formattedDate;  ?></td>
													<td><?php if ($applicant['status'] == 'submitted') { ?><span class="r-3 badge badge-success text-capitalize"><?php echo $applicant['status']; ?></span>
														<?php
														} else { ?><span class="r-3 badge badge-warning "><?php echo $applicant['status']; ?></span> <?php }; ?></td>
													<td>




														<!-- <a href="<?php echo base_url(); ?>admin/applicants/edit/<?php echo $applicant['id'] ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit applicant" data-original-title="Edit applicant">
															<i class="icon-pencil"></i>
														</a> -->
														<?php if ($applicant["status"] == "submitted") { ?>

															<a href="<?php echo base_url(); ?>admin/applicants/admit/<?php echo $applicant['id'] ?>" class="btn btn-xs btn-success admit" id="<?php echo $applicant['id']; ?>" data-toggle="tooltip" title="Admit" data-original-title="Admit">
																<i class="icon-check"></i>
															</a>

															<a href="<?php echo base_url(); ?>admin/applicants/edit/<?php echo $applicant['id'] ?>" class="btn btn-xs btn-warning" id="<?php echo $applicant['id']; ?>" data-toggle="tooltip" title="Decline" data-original-title="Decline">
																<i class="icon-pencil"></i>
															</a>
														<?php } ?>
														<a href="<?php echo base_url(); ?>admin/applicants/view/<?php echo $applicant['id'] ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="View applicant Details" data-original-title="View">
															<i class="icon-eye"></i>
														</a>

														<!-- 
														<button type="submit" class="btn btn-danger btn-xs delete" id="<?php echo $applicant['id']; ?>"> <i class="icon-trash"></i></button>
 -->
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
									foreach ($result as $applicant) { ?>
										<div class="col-md-4 mb-4">
											<div class="card shadow p-4">
												<div>
													<div class="image mr-4 avatar-xl float-left">
														<img class="avatar-xl circle" src="<?php if (!empty($applicant['image'])) {
																								echo base_url() . $applicant['image'];
																							} else {
																								echo base_url() . "uploads/applicant_images/no_image.png";
																							} ?>" alt="applicant Image"></span>
													</div>
													<div class=" text-left mt-1">
														<div>
															<strong><?php echo $applicant['application_no']; ?></strong>
														</div>
														<div>
															<strong class="text-uppsercase"><?php echo $applicant['firstname'] . " " . $applicant['lastname'] . " " . $applicant['middlename']; ?></strong>
														</div>
														<small> <?php echo  $applicant['code'] ?></small>

														<div class="">
															<small> <?php if ($applicant['state_id'] == 5) { ?><span class="r-3 badge badge-success"><?php echo $applicant['state']; ?></span>
																<?php
																	} else { ?><span class="r-3 badge badge-warning "><?php echo $applicant['state']; ?></span> <?php }; ?></small>
														</div>
														<small> <?php echo $applicant['local_g'] ?></small>
														<small><?php if ($applicant['status'] == 'submitted') { ?><span class="r-3 badge badge-success text-capitalize"><?php echo $applicant['status']; ?></span>
															<?php
																} else { ?><span class="r-3 badge badge-warning "><?php echo $applicant['status']; ?></span> <?php }; ?></small>

														<div class="mt-1">
															<a href="<?php echo base_url('admin/applicants/view/' . $applicant['id']); ?>" class="btn btn-xs btn-primary">View Profile</a>
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