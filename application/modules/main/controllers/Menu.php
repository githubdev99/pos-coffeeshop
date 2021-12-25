<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $title = 'Menu';
        $data = [
            'core' => $this->core($title),
            'get_view' => 'main/v_menu',
            'get_script' => 'main/script_menu'
        ];
        $this->master->template($data);
    }

    public function category()
    {
        $title = 'Kategori Menu';
        $data = [
            'core' => $this->core($title),
            'get_view' => 'main/v_menu_category',
            'get_script' => 'main/script_menu_category'
        ];
        $this->master->template($data);
    }
}
