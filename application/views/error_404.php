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
</head>

<body class="authentication-bg">
	<div class="account-pages my-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-4 col-lg-5 col-8">
					<div class="text-center">
						<div>
							<img src="<?= base_url() ?>asset/images/not-found.png" alt="" class="img-fluid" />
						</div>
					</div>

				</div>
			</div>

			<div class="row">
				<div class="col-12 text-center">
					<h3 class="mt-3">We couldn’t connect the url</h3>
					<p class="text-muted mb-5">This page was not found. <br /> You may have mistyped the address or the page may have moved.</p>

					<?php if ($this->agent->is_browser()) : ?>
						<a href="<?= base_url() ?>" class="btn btn-lg btn-primary mt-4">Take me back to Home</a>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Main JS -->
	<script src="<?= base_url() ?>asset/js/vendor.min.js"></script>
	<script src="<?= base_url() ?>asset/js/app.min.js"></script>
</body>

</html>