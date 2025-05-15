</div>
<!-- Model for add edit product -->

<!-- jQuery  -->
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/dropify/js/dropify.min.js"></script>
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
