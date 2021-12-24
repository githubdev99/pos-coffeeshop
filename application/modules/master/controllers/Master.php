<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function template($data)
    {
        $this->load->view('template', $data);
    }
}
