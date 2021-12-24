	<!-- Main JS -->
	<script src="<?= base_url() ?>asset/js/vendor.min.js"></script>

	<!-- Plugin JS -->
	<script src="<?= base_url() ?>asset/libs/moment/moment.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/apexcharts/apexcharts.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/flatpickr/flatpickr.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/datatables/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/datatables/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/multiselect/jquery.multi-select.js"></script>
	<script src="<?= base_url() ?>asset/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/select2/select2.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/croppie/croppie.min.js"></script>
	<script src="<?= base_url() ?>asset/libs/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="<?= base_url() ?>asset/js/app.min.js"></script>

	<!-- Custom JS -->
	<script src="<?= base_url() ?>asset/custom/custom.js"></script>

	<script>
		// Alert
		$(document).ready(function() {
			<?php if (!empty($this->session->flashdata('alert'))) : ?>
				<?= $this->session->flashdata('alert'); ?>
			<?php endif ?>
		});
	</script>

	<?php if (!empty($get_script)) : ?>
		<?= $this->load->view($get_script); ?>
	<?php endif ?>
	</body>

	</html>