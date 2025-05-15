<link href="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" rel="shortcut icon" type="image/x-icon">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">

<script>
	function printpage() {
		window.print();
	}
</script>
<style type="text/css">
	body {
		font: "Times New Roman", Times, serif
	}

	@media print {
		/* 	.pagebreak {
			page-break-before: always;
		} */

		.pagebr {
			page-break-inside: avoid;
		}

		/* page-break-after works, as well */
	}



	body {
		margin: 0;
		padding: 0;
		font: 86% "Times New Roman", Times, serif;
		/*helvetica, verdana, "Trebuchet MS", tahoma, arial, sans-serif;*/
		line-height: 2em;
		/*background : #fff url(../images/bg.gif) repeat-x;*/
		background-position: 50% 0;

	}

	/*WRAP*/
	#container {
		width: 1100px;
		margin: 0 auto;

	}


	@media print {
		.noprint {
			visibility: hidden
		}
	}

	.border {
		border: 2px;
		border-color: gray;
		padding: 10px;
		margin-bottom: 25px;

	}

	.header {
		font: 14px "Times New Roman", Times, serif;
		margin-top: 0px;
		font-weight: 600;
		/*margin-bottom: -1;*/
		line-height: 0px;
	}

	.logo {
		margin: 1px;
	}

	b {
		margin-top: -2px;
		font-size: 18px;
	}
</style>

<body onload="window.print()">


	<table class="table">

		<tbody>
			<tr>
				<td>
					<center>

						<div class="container">
							<div class="pagebr row">
								<?php
								$count = 1;
								foreach ($tokens as $value) { ?>

									<div class="pagebr col-md-6">
										<div class="pagebr border">
											<div class="pagebr center" class="text-uppercase">
												<p class="logo"><img src="<?php echo base_url('uploads/system/' . get_frontend_settings('favicon')); ?>" width="40" height="40">
													<span class="header text-uppercase"><?php echo get_settings('system_name'); ?></span>
													</p>
													<P class="mt-2"><?=current_adm_session_name();?> ADMISSION APPLICATION TOKEN</P>
												
												<p class="text-left ml-5">
													USERNAME: <b><?php echo $value->application_no; ?></b></b>
												</p>
													<p class="text-left ml-5">
													PASSWORD: <b><?php echo $value->open_p; ?></b></b>
												</p>
												<p>
													<b>Link: https://portal.chtningi.com.ng/admission/login</b>
												</p>
												<!-- <b> <?php echo $value->token; ?></b> -->
											</div>
										</div>


									</div>
								<?php
								}
								?>

							</div>
							<div class="pagebreak"> </div>
						</div>


						<hr />
						<div class="noprint">
							<input type="submit" name="print" class="btn btn-success" id="print" value="Print The Tokens. Form" onclick="printpage()" />

							<a type="button" class="btn btn-primary" href="<?php echo base_url('admin/tokens') ?>"> Go Back </a>


						</div>
					</center>
				</td>
			</tr>
		</tbody>
	</table>


</body>
<!-- <script type="text/javascript">
	var string = "02076861111"
	var phone = string.replace(/(\d{3})(\d{4})(\d{4})/, '$1 $2 $3');
	console.log(phone);
</script>
 -->
