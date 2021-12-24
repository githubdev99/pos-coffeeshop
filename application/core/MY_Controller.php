<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{

	public $data = [];

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->module('master');

		$this->data['full_logo'] = base_url() . 'asset/images/logo-full.png';
		$this->data['mini_logo'] = base_url() . 'asset/images/logo-mini.png';
		$this->data['app_name'] = 'Seller Jaja ID';

		$this->data['link_api'] = $this->data['link_jaja'] . 'core/seller/';
	}

	public function core($title)
	{
		$this->data['title_page'] = $title . ' | ' . $this->data['app_name'];

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
