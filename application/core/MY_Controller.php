<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{

	public $data = [];

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->module('master');

		$this->data['miniLogo'] = base_url() . 'assets/images/favicon.ico';
		$this->data['appName'] = 'POS Coffeeshop';

		$this->data['apiUrl'] = 'http://localhost:3002/';
	}

	public function core($title)
	{
		$this->data['titlePage'] = $title . ' | ' . $this->data['appName'];

		return $this->data;
	}

	public function alert_popup($message)
	{
		$sweet_alert = '
		Swal.mixin({
			toast: true,
			position: "top",
			showCloseButton: !0,
			showConfirmButton: false,
			timer: 4000,
			onOpen: (toast) => {
				toast.addEventListener("mouseenter", Swal.stopTimer)
				toast.addEventListener("mouseleave", Swal.resumeTimer)
			}
		}).fire({
			icon: "' . $message['swal']['type'] . '",
			title: "' . $message['swal']['title'] . '"
		});
		';

		$this->session->set_flashdata($message['name'], $sweet_alert);
	}
}
