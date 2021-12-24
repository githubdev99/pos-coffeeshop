<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $title = 'Login';
        $data = [
            'core' => $this->core($title),
            'get_view' => 'login/v_login',
            'get_script' => 'login/script_login'
        ];
        $this->master->template($data);
    }
}
