	<div class="modal fade" id="verifikasi_password" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content p-3">
				<form action="<?= base_url() ?>json/verifikasi_password" method="post" enctype="multipart/form-data" name="verifikasi">
					<div class="modal-body text-center">
						<span style="font-size: 15px;">Untuk melindungi keamanan akun Anda, mohon <br> masukkan password akun Anda untuk diverifikasi.</span>
						<br><br>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
							</div>
							<input type="password" name="password" class="form-control verifikasi" placeholder="Masukkan password" required>
						</div>
						<br>
						<div class="float-right">
							<input type="hidden" name="callback">
							<button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Batal</button>
							<button type="submit" name="verifikasi" value="verifikasi" class="btn btn-info">Verifikasi</button>
						</div>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Main JS -->
	<script src="<?= base_url() ?>asset/js/vendor.min.js"></script>

	<?php if (!empty($plugin)) : ?>
		<!-- Plugin JS -->

		<?php if (array_search('moment', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/moment/moment.min.js"></script>
		<?php endif ?>

		<?php if (array_search('apexcharts', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/apexcharts/apexcharts.min.js"></script>
		<?php endif ?>

		<?php if (array_search('flatpickr', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/flatpickr/flatpickr.min.js"></script>
		<?php endif ?>

		<?php if (array_search('datatables', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/datatables/jquery.dataTables.min.js"></script>
			<script src="<?= base_url() ?>asset/libs/datatables/dataTables.bootstrap4.min.js"></script>
			<script src="<?= base_url() ?>asset/libs/datatables/dataTables.responsive.min.js"></script>
			<script src="<?= base_url() ?>asset/libs/datatables/responsive.bootstrap4.min.js"></script>
		<?php endif ?>

		<?php if (array_search('tagsinput', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
		<?php endif ?>

		<?php if (array_search('multiselect', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/multiselect/jquery.multi-select.js"></script>
		<?php endif ?>

		<?php if (array_search('touchspin', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<?php endif ?>

		<?php if (array_search('magnific-popup', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
		<?php endif ?>

		<?php if (array_search('select2', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/select2/select2.min.js"></script>
		<?php endif ?>

		<?php if (array_search('croppie', $plugin) !== false) : ?>
			<script src="<?= base_url() ?>asset/libs/croppie/croppie.min.js"></script>
		<?php endif ?>
	<?php endif ?>

	<script src="<?= base_url() ?>asset/libs/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="<?= base_url() ?>asset/js/app.min.js"></script>

	<!-- Custom JS -->
	<script src="<?= base_url() ?>asset/custom/custom.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.2.3/firebase.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.2.3/firebase-analytics.js"></script>


	<script>
		var firebaseConfig = {
			apiKey: "AIzaSyAyK_jliLynwi05uVHLdImhfENldcg3jrM",
			authDomain: "jajachat-e052d.firebaseapp.com",
			databaseURL: "https://jajachat-e052d-default-rtdb.firebaseio.com",
			projectId: "jajachat-e052d",
			storageBucket: "jajachat-e052d.appspot.com",
			messagingSenderId: "284366139562",
			appId: "1:284366139562:web:9eed2959651b3e93e1a0d3",
			measurementId: "G-6T2NFH8YXW"
		};

		firebase.initializeApp(firebaseConfig);
		firebase.analytics();

		var database = firebase.database();

		let fire = database.ref(`people/<?= $core['seller']->uid ?>`).on("value", function(snapshot) {
			let item = snapshot.val();
			let notif;
			if (item) {
				if (item.notif) {
					notif = item.notif;
					$(".notif").val(JSON.stringify(notif))
					$('#notifh').html(JSON.parse(notif.home));
					$('#notifc').html(JSON.parse(notif.chat));
					$('#notifch').val(JSON.parse(notif.chat));

					console.log(notif);

				} else {
					database.ref(`/people/<?= $core['seller']->uid ?>/notif`).update({
						home: 0,
						chat: 0,
						orders: 0
					})
				}
			} else {
				database.ref('people/<?= $core['seller']->uid ?>').set({
					name: `<?= $core['seller']->nama_toko ?>`,
					photo: `<?= base_url() ?>asset/front/images/file/<?= $core['seller']->foto ?>`,
					token: 'null',
					notif: {
						home: notif.home,
						chat: notif.chat,
						orders: notif.orders
					}
				});

				database.ref(`people/<?= $core['seller']->uid ?>`).on("value", function(snapshot) {
					var item = snapshot.val();
					if (item.token == 'null') {
						database.ref(`people/<?= $core['seller']->uid ?>/`).set({
							name: `<?= $core['seller']->nama_toko ?>`,
							photo: `<?= base_url() ?>asset/front/images/file/<?= $core['seller']->foto ?>`,
							token: 'null',
							notif: {
								home: notif.home,
								chat: notif.chat,
								orders: notif.orders
							}
						});
						database.ref(`friend/<?= $core['seller']->uid ?>/null`).set({
							chat: 'null'
						});
					} else {
						database.ref(`people/<?= $core['seller']->uid ?>/`).set({
							name: `<?= $core['seller']->nama_toko ?>`,
							photo: `<?= base_url() ?>asset/front/images/file/<?= $core['seller']->foto ?>`,
							token: item.token,
							notif: {
								home: notif.home,
								chat: notif.chat,
								orders: notif.orders
							}
						});
						database.ref(`friend/<?= $core['seller']->uid ?>/null`).set({
							chat: 'null'
						});
					}
				});
			}
		})

		// Alert
		$(document).ready(function() {
			<?php if (!empty($this->session->flashdata('success'))) : ?>
				<?= $this->session->flashdata('success'); ?>
			<?php elseif (!empty($this->session->flashdata('failed'))) : ?>
				<?= $this->session->flashdata('failed'); ?>
			<?php elseif (!empty($this->session->flashdata('alert'))) : ?>
				<?= $this->session->flashdata('alert'); ?>
			<?php endif ?>

			trigger_enter({
				selector: '.verifikasi',
				target: 'button[name="verifikasi"]'
			});

			$('form[name="verifikasi"]').submit(function(e) {
				e.preventDefault();

				var active_element = $(document.activeElement);

				$('button[name="' + active_element.val() + '"]').attr('disabled', 'true');
				$('button[name="' + active_element.val() + '"]').html('<i class="fas fa-circle-notch fa-spin"></i>');

				$.ajax({
					type: $(this).attr('method'),
					url: $(this).attr('action'),
					data: $(this).serialize(),
					dataType: "json",
					success: function(response) {
						if (response.error == true) {
							show_alert({
								type: response.type,
								message: response.message,
								timer: 2000
							});

							$('button[name="' + active_element.val() + '"]').removeAttr('disabled');
							$('button[name="' + active_element.val() + '"]').html('Verifikasi');
						} else {
							setTimeout(function() {
								window.location = response.callback;
							}, 1000);
						}
					}
				});
			});
		});

		function verifikasi_password(url) {
			<?php if ($this->session->has_userdata('authorized') && $this->session->userdata('authorized') == true) : ?>
				window.location = url;
			<?php else : ?>
				$('#verifikasi_password input[name="callback"]').val(url);

				$('#verifikasi_password').modal({
					backdrop: 'static',
					keyboard: true,
					show: true
				});
			<?php endif ?>
		}

		function validate_kurir(url) {
			<?php if (!empty($this->data['seller']->pilihan_kurir)) : ?>
				window.location = url;
			<?php else : ?>
				Swal.fire({
					title: 'Info!',
					html: `Anda belum mengatur pengiriman, atur sekarang juga!`,
					icon: 'info',
					showCloseButton: true,
					confirmButtonColor: '#64B0C9',
					confirmButtonText: 'OK',
				}).then((result) => {
					if (result.value) {
						window.location = '<?= base_url() ?>pengaturan/toko?tab=pengiriman';
					}
				});
			<?php endif ?>
		}

		<?php if (!empty($core['data_libur_toko'])) : ?>
			<?php if (date('Y-m-d') > $core['data_libur_toko']['date_to']) : ?>
				$.ajax({
					url: '<?= $core['link_api'] ?>pengaturan/jadwal_toko/libur',
					type: 'POST',
					data: {
						id_toko: '<?= $core['seller']->id_toko ?>',
						data: null
					},
					dataType: 'json',
					success: function(response) {
						let paramAlert = {};
						if (response.status.code == 200) {
							paramAlert = {
								type: 'success',
								message: 'Toko berhasil dibuka, selamat berjualan!',
								timer: 2000,
							};

							<?php if (($this->uri->segment(1) == 'pengaturan') || (!empty($this->input->get('onUpdate')) && ($this->input->get('onUpdate') == 'libur-toko'))) : ?>
								paramAlert.callback = '<?= base_url() . 'pengaturan/toko?onUpdate=libur-toko' ?>';
							<?php endif ?>
						} else {
							paramAlert = {
								type: 'error',
								message: 'Toko gagal dibuka, silahkan coba lagi.',
								timer: 4000
							};
						}

						show_alert(paramAlert);
					}
				});
			<?php endif ?>
		<?php endif ?>
	</script>

	<?php if (!empty($get_script)) : ?>
		<?= $this->load->view($get_script); ?>
	<?php endif ?>
	</body>

	</html>