<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title><?= $core['title_page'] ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= $core['mini_logo'] ?>">

	<!-- Main CSS -->
	<link href="<?= base_url() ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>asset/css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>asset/css/app.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>asset/libs/font-awesome/css/all.css" rel="stylesheet" type="text/css" />

	<!-- Custom CSS -->
	<link href="<?= base_url() ?>asset/custom/custom.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php if ($type == 'bank') : ?>
		<?php if ($send_data == true) : ?>
			<div class="account-pages" style="margin-top: 120px;">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-4 col-lg-5 col-8">
							<div class="text-center">
								<div>
									<img src="<?= base_url() ?>asset/images/verification-success.png" alt="" class="img-fluid" />
								</div>
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<h3 class="mt-3">Verifikasi Bank Berhasil</h3>
							<p class="text-muted">Terima kasih telah melakukan verifikasi<br>Ayo tingkatkan terus semangat berjualan kamu di Seller Jaja ID</p>

							<?php if (!$this->agent->is_mobile()) : ?>
								<a href="<?= base_url() ?>" class="btn btn-lg btn-primary mt-4">Kembali ke Halaman Awal</a>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		<?php else : ?>
			<div class="account-pages" style="margin-top: 120px;">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-4 col-lg-5 col-8">
							<div class="text-center">
								<div>
									<img src="<?= base_url() ?>asset/images/verification-failed.png" alt="" class="img-fluid" />
								</div>
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<h3 class="mt-3">Verifikasi Bank Gagal</h3>
							<p class="text-muted">Yah maaf, verifikasi bank kamu gagal<br>Silahkan coba kirim ulang verifikasinya ya</p>

							<?php if (!$this->agent->is_mobile()) : ?>
								<a href="<?= base_url() ?>" class="btn btn-lg btn-primary mt-4">Kembali ke Halaman Awal</a>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	<?php elseif ($type == 'bank_customer') : ?>
		<?php if ($send_data == true) : ?>
			<div class="account-pages" style="margin-top: 120px;">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-4 col-lg-5 col-8">
							<div class="text-center">
								<div>
									<img src="<?= base_url() ?>asset/images/verification-success.png" alt="" class="img-fluid" />
								</div>
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<h3 class="mt-3">Verifikasi Bank Berhasil</h3>
							<p class="text-muted">Terima kasih telah melakukan verifikasi<br>Yuk mulai belanja di Jaja ID sekarang juga! Ada promo seru loh untuk kamu</p>

							<?php if (!$this->agent->is_mobile()) : ?>
								<a href="<?= $core['link_jaja'] ?>" class="btn btn-lg btn-primary mt-4">Kembali ke Halaman Awal</a>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		<?php else : ?>
			<div class="account-pages" style="margin-top: 120px;">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-4 col-lg-5 col-8">
							<div class="text-center">
								<div>
									<img src="<?= base_url() ?>asset/images/verification-failed.png" alt="" class="img-fluid" />
								</div>
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-12 text-center">
							<h3 class="mt-3">Verifikasi Bank Gagal</h3>
							<p class="text-muted">Yah maaf, verifikasi bank kamu gagal<br>Silahkan coba kirim ulang verifikasinya ya</p>

							<?php if (!$this->agent->is_mobile()) : ?>
								<a href="<?= $core['link_jaja'] ?>" class="btn btn-lg btn-primary mt-4">Kembali ke Halaman Awal</a>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	<?php endif ?>

	<!-- Main JS -->
	<script src="<?= base_url() ?>asset/js/vendor.min.js"></script>
	<script src="<?= base_url() ?>asset/js/app.min.js"></script>

	<!-- Custom JS -->
	<script src="<?= base_url() ?>asset/custom/custom.js"></script>
</body>

</html>