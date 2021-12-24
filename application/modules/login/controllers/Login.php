<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->auth_seller();
    }

    public function index()
    {
        $title = 'Seller Dashboard';
        $data = [
            'core' => $this->core($title),
            'plugin' => ['flatpickr', 'moment', 'apexcharts', 'select2'],
            'get_view' => 'home/v_home',
            'get_script' => 'home/script_home'
        ];
        $this->master->template($data);
    }

    public function buka_toko()
    {
        $title = 'Buka Toko';
        $data = [
            'core' => $this->core($title),
            'plugin' => ['flatpickr', 'select2'],
            'get_view' => 'home/v_buka_toko',
            'get_script' => 'home/script_buka_toko'
        ];

        if (!$this->input->post()) {
            $this->master->template($data);
        } else {
            $checking = TRUE;

            if ($this->input->post('submit') == 'buka_toko') {
                $check_data = $this->master_model->select_data([
                    'field' => 'nama_toko',
                    'table' => 'toko',
                    'where' => [
                        'LOWER(nama_toko)' => trim(strtolower($this->input->post('nama_toko')))
                    ]
                ])->result();

                if (!empty($check_data)) {
                    $checking = FALSE;
                    $output = [
                        'error' => true,
                        'type' => 'error',
                        'message' => 'Nama toko ' . $this->input->post('nama_toko') . ' sudah pernah di gunakan.'
                    ];
                }

                if ($checking == TRUE) {
                    $query = $this->master_model->send_data([
                        'data' => [
                            'nama_toko' => $this->input->post('nama_toko'),
                            'slug_toko' => seo($this->input->post('nama_toko')),
                            'created_date' => date('Y-m-d'),
                            'created_time' => date('H:i:s'),
                            'id_user' => $this->session->userdata('id_customer'),
                            'nama_user' => $this->data['customer']->nama_lengkap,
                            'greating_message' => $this->input->post('greating_message'),
                            'deskripsi_toko' => $this->input->post('deskripsi_toko'),
                            'alamat_toko' => $this->input->post('alamat_toko'),
                            'provinsi' => decrypt_text($this->input->post('provinsi')),
                            'kota_kabupaten' => decrypt_text($this->input->post('kota_kabupaten')),
                            'kecamatan' => decrypt_text(explode(':', $this->input->post('kecamatan'))[0]),
                            'kelurahan' => decrypt_text($this->input->post('kelurahan')),
                            'kode_pos' => $this->input->post('kode_pos')
                        ],
                        'table' => 'toko'
                    ]);

                    if ($query == FALSE) {
                        $output = [
                            'error' => true,
                            'type' => 'error',
                            'message' => 'Data toko gagal di buat, silahkan coba lagi.',
                        ];
                    } else {
                        $last_id = $this->db->insert_id();

                        $this->master_model->send_data([
                            'where' => [
                                'id_toko' => $last_id
                            ],
                            'data' => [
                                'uid' => uniqid() . 'seller' . $last_id,
                            ],
                            'table' => 'toko'
                        ]);

                        $output = [
                            'error' => false,
                            'type' => 'info',
                            'message' => 'Toko sedang di buat, mohon tunggu...',
                            'callback' => base_url()
                        ];

                        $this->alert_popup([
                            'name' => 'success',
                            'swal' => [
                                'title' => 'Toko berhasil di buat, selamat datang di Jaja.id!',
                                'type' => 'success'
                            ]
                        ]);
                    }
                }
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }
}
