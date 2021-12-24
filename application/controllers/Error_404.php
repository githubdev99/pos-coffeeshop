<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error_404 extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$title = 'Error 404';
		$data = [
			'core' => $this->core($title)
		];

		$this->load->view('error_404', $data);
	}

}

/* End of file Error_404.php */