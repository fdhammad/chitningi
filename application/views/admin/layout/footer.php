</div>
<!-- Model for add edit product -->

<!-- jQuery  -->
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/dropify/js/dropify.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/exam.custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/autoNumeric-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-masks.init.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js//custom/custom.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.dropify').dropify();
		//$('#receipt').inputmask("9999-9999-9999");
	});
</script>
<!-- <script type="text/javascript">
	$(document).ready(function() {
		$('.dropify').dropify();
		//$('#receipt').inputmask("9999-9999-9999");
	});
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$('#changesession').on("click", function() {
			$('#changesession-modal').modal('show');
		});
	});
</script> -->

<script>
	(function($, d) {
		$.each(readyQ, function(i, f) {
			$(f)
		});
		$.each(bindReadyQ, function(i, f) {
			$(d).bind("ready", f)
		})
	})(jQuery, document)
</script>