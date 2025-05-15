<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css">
<!-- 
<link href="<?php echo base_url(); ?>assets/css/dataTables.min.css" rel="stylesheet"> -->
<link href="<?php echo base_url(); ?>assets/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">

<style>
	.loader {
		position: fixed;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: #F5F8FA;
		z-index: 9998;
		text-align: center;
	}

	.plane-container {
		position: absolute;
		top: 50%;
		left: 50%;
	}

	.session {
		color: #ffff;
		font-size: 18px;
		font-weight: bold;
		margin-right: 320px;
		margin-top: 12px;
		text-align: center;

	}



	@media only screen and (min-device-width: 620px) and (max-device-width: 1280px) {
		.session {
			color: #ffff;
			font-size: 12px;
			font-weight: bold;
			margin-right: 9px;
			margin-top: 10px;
			text-align: center;

		}
	}

	@media screen and (max-width: 600px) {
		.session {
			color: #ffff;
			font-size: 10px;
			font-weight: bold;
			margin-right: 9px;
			margin-top: 10px;
			text-align: center;

		}
	}

	/* 	.download_label {
			display: none;
		} */

	.righttext {
		text-align: right !important
	}

	/*a#DataTables_Table_0_next {border-radius: 0px 4px 4px 0px;}*/
	select.dropdownloading {
		background: url('<?php echo base_url(); ?>assets/css/images/loading.gif') 99% 3px no-repeat;
		width: 100%;
		height: 28px;
		-moz-appearance: window;
		-webkit-appearance: none;
	}

	input.dropdownloading {
		background: url('<?php echo base_url(); ?>assets/css/images/loading.gif') 99% 3px no-repeat;
		width: 100%;
		height: 28px;
		-moz-appearance: window;
		-webkit-appearance: none;
	}

	@media (max-width: 767px) {
		.paddlr {
			padding: 6px 5px 6px 5px;
		}

		#btnRemove {
			margin-top: 10px;
		}

		.dataTables_wrapper {
			text-align: center;
		}

		table.dataTable {
			text-align: left;
		}

		.mailbox-controls {
			padding-bottom: 10px;
		}

		.col-eq {
			margin-right: 0px;
		}
	}

	@media (min-width: 768px) and (max-width: 991px) {
		#btnRemove {
			margin-top: 10px;
		}
	}

	.buttonload {
		/* 	background-color: #04AA6D; */
		/* Green background */
		border: none;
		/* Remove borders */
		color: white;
		/* White text */
		padding: 12px 24px;
		/* Some padding */
		font-size: 16px;
		/* Set a font-size */
	}
</style>

<script>
	(function(w, d, u) {
		w.readyQ = [];
		w.bindReadyQ = [];

		function p(x, y) {
			if (x == "ready") {
				w.bindReadyQ.push(y);
			} else {
				w.readyQ.push(x);
			}
		};
		var a = {
			ready: p,
			bind: p
		};
		w.$ = w.jQuery = function(f) {
			if (f === d || f === u) {
				return a
			} else {
				p(f)
			}
		}
	})(window, document)
</script>
