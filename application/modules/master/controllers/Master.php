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

    public function notifikasi()
    {
        $get_notif = $this->master_model->select_data([
            'field' => 'transaksi.*',
            'table' => 'transaksi',
            'where' => [
                'id_toko' => $this->data['seller']->id_toko
            ]
        ])->result();

        $title = 'Notifikasi';
        $data = [
            'core' => $this->core($title),
            'plugin' => ['flatpickr', 'select2', 'croppie'],
            'get_view' => 'master/notifikasi/notifikasi_all',
            'get_notif' => $get_notif

        ];


        if ($this->input->post('submit') == 'notif') {
            $querystatus = $this->master_model->send_data([
                'where' => [
                    'id_data' => '535'
                ],
                'data' => [
                    'notifikasi_seller' => 'Y'
                ],
                'table' => 'transaksi'
            ]);
        }

        $this->master->template($data);
    }
}
