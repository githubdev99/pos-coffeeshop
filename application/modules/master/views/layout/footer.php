<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- dashboard init -->
<script src="assets/js/pages/dashboard.init.js"></script>

<script src="assets/libs/sweetalert2/dist/sweetalert2.min.js"></script>

<!-- App js -->
<script src="assets/custom/custom.js"></script>
<script src="assets/js/app.js"></script>

<?php if (!empty($get_script)) : ?>
	<?= $this->load->view($get_script); ?>
<?php endif ?>
</body>

</html>