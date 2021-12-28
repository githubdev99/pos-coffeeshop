<!-- JAVASCRIPT -->
<script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

<!-- dashboard init -->
<script src="<?= base_url() ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/libs/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="<?= base_url() ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- App js -->
<script src="<?= base_url() ?>assets/custom/custom.js"></script>
<script src="<?= base_url() ?>assets/js/app.js"></script>

<script>
	const getProfile = async () => {
		if (localStorage.getItem('token')) {
			var myHeaders = new Headers();
			myHeaders.append("Authorization", localStorage.getItem('token'));

			var requestOptions = {
				method: 'GET',
				headers: myHeaders,
				redirect: 'follow'
			};

			return await fetch("http://localhost:3002/auth/profile", requestOptions)
				.then(response => response.json())
				.then(result => {
					let typeAlert = ''
					let titleAlert = ''
					if (result.status.code === 200) {
						typeAlert = 'success'
						titleAlert = 'Successfull!'
					} else if ((result.status.code === 400) || (result.status.code === 401)) {
						typeAlert = 'error'
						titleAlert = 'Failed!'
					} else if (result.status.code === 404) {
						typeAlert = 'warning'
						titleAlert = 'Warning!'
					}

					if (result.status.code !== 200) {} else {
						$('.data-adminName').html(result.data.name)

						return result.data
					}
				})
				.catch(error => {
					show_alert({
						type: 'error',
						title: 'Error!',
						timer: 2500,
						message: error
					});
				});
		} else {
			return {}
		}
	}

	const logout = () => {
		localStorage.removeItem('token')
		window.location.reload()
	}

	let dataProfile = {}
	$(async function() {
		dataProfile = await getProfile()

		let getFirstUrl = '<?= $this->uri->segment(1) ?>'
		if (localStorage.getItem('token') && dataProfile) {
			if (getFirstUrl != 'main') {
				window.location = "<?= base_url() ?>main/menu"
			}
		} else {
			if (getFirstUrl != 'login') {
				window.location = "<?= base_url() ?>login"
			}
		}
	});
</script>

<?php if (!empty($get_script)) : ?>
	<?= $this->load->view($get_script); ?>
<?php endif ?>
</body>

</html>