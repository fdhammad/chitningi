<div class="page has-sidebar-left">
	<header class="my-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<h1 class="s-24">
						<i class="icon-list"></i>
						Generate Tokens
					</h1>
				</div>
			</div>
		</div>
	</header>
	<div class="container-fluid my-3">
		<div class="row my-3">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<div class="card-title"><i class="icon icon-database"></i> <?php echo $page_title; ?>

						</div>
					</div>

					<div class="card-body">

						<?php if ($this->session->flashdata('msg')) { ?>
							<?php echo $this->session->flashdata('msg') ?>
						<?php } ?>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive mailbox-messages">
									<table class="table table-hover table-striped">
										<thead>
											<tr>
												<th>S/N</th>
												<th><?php echo 'Tokens Details'; ?></th>
												<th class="text-right" colspan="4">
													<?php echo site_phrase('action'); ?>
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$count = 1;
											foreach ($list as $value) { ?>
												<tr>
													<td><?php echo $count++ ?></td>
													<td>
														<?php echo "Number of Tokens Generated" . " <b>(" . $value['no_of_tokens'] . ")</b> <i class='float-right'>" . $value['name'] . " " . $value['lastname'] . "</i>"; ?>
													</td>
													<td class="text-right">
														<form method="post" action="<?php echo base_url(); ?>admin/tokens/print">
															<input type="hidden" name="id" id="id" class="form-control input-sm" value="<?php echo $value['id']; ?>">
															<button type="submit" name="print" class="btn btn-xs btn-warning print"><i class="icon-download"></i></button>
														</form>

													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
				<div class="col-md-4 col-sm-4">
					<div class="card">
						<div class="card-header with border">
							<div class="card-title"><i class="icon icon-upload"></i> <?php echo 'Add Amount' ?></div>
						</div>

						<form role="form" id="form1" action="<?php echo site_url('admin/tokens') ?>" method="post" enctype="multipart/form-data">
							<?php echo $this->customlib->getCSRF(); ?>
							<div class="card-body">
								<input class="form-control" type="number" name="number">
								<span class="text-danger"><?php echo form_error('number'); ?></span>
							</div>
							<div class="card-footer mb-4">
								<button class="btn btn-primary float-right" type="submit" name="generate" value="generate"><i class="icon icon-upload"></i> <?php echo site_phrase('upload'); ?></button>
							</div>
						</form>
					</div>

					<!--./box box-warning-->
				</div>
				<!--./col-md-4-->
				<!-- <div class="col-md-4"></div> -->
			

		</div>
	</div>
	