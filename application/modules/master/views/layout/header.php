<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title><?= $core['title_page'] ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= $core['mini_logo'] ?>">

	<?php if (!empty($plugin)) : ?>
		<!-- Plugin CSS -->

		<?php if (array_search('flatpickr', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
		<?php endif ?>

		<?php if (array_search('datatables', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
			<link href="<?= base_url() ?>asset/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		<?php endif ?>

		<?php if (array_search('tagsinput', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
		<?php endif ?>

		<?php if (array_search('select2', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
		<?php endif ?>

		<?php if (array_search('multiselect', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
		<?php endif ?>

		<?php if (array_search('touchspin', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" />
		<?php endif ?>

		<?php if (array_search('magnific-popup', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
		<?php endif ?>

		<?php if (array_search('croppie', $plugin) !== false) : ?>
			<link href="<?= base_url() ?>asset/libs/croppie/croppie.min.css" rel="stylesheet" type="text/css" />
		<?php endif ?>
	<?php endif ?>

	<link href="<?= base_url() ?>asset/libs/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />

	<link href="<?= base_url() ?>asset/libs/placeholder-loading/placeholder-loading.min.css" rel="stylesheet" type="text/css" />

	<!-- Main CSS -->
	<link href="<?= base_url() ?>asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>asset/css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>asset/css/app.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>asset/libs/font-awesome/css/all.css" rel="stylesheet" type="text/css" />

	<!-- Custom CSS -->
	<link href="<?= base_url() ?>asset/custom/custom.css" rel="stylesheet" type="text/css" />
</head>

<body>