<?php if ($page_name == "admission" || $page_name == "applicant_login" || $page_name == "staff_login" || $page_name == "login"): ?>

	<script src="<?= base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url() ?>assets/js/scripts.bundle.js"></script>
	<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>

<?php elseif ($page_name == "home"): ?>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<?php endif; ?>

