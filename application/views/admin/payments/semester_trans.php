
<div class="page  has-sidebar-left height-full">
	<header class="danger accent-3 relative">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4>
						<i class="icon-money"></i>
						<?=$page_title;?>
					</h4>
				</div>
			</div>
			<div class="row justify-content-between">
				<ul class="nav nav-material nav-material-white responsive-tab" id="v-pills-tab" role="tablist">
					<li>
						<a class="nav-link" href="<?php echo base_url(); ?>admin/payment/searchpayment" role="tab" aria-controls="v-pills-all"><i class="icon icon-search"></i>Search RRR</a>
					</li>
					<li class="float-right">
						<a class="nav-link" href="<?php echo base_url(); ?>admin/payment/report"><i class="icon icon-documents"></i>Payments Report</a>
					</li>
					<li class="float-right">
						<a class="nav-link active" href="<?php echo base_url(); ?>admin/payment/check_rrr"><i class="icon icon-home"></i>All RRR</a>
					</li>
				</ul>
			</div>
		</div>
	</header>
	<?php if ($this->session->flashdata('toast')) { ?>
		<?php echo $this->session->flashdata('toast') ?>
	<?php } ?>
	<div class="container-fluid my-3">
		<div class="row">
			<div class="col-md-12">
				<?php if ($this->session->flashdata('msg')) { ?>
					<?php echo $this->session->flashdata('msg') ?>
				<?php } ?>

				<div id="response">

				</div>


			</div>

		</div>
	</div>
</div>
