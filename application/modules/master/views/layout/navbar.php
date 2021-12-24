<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="<?= base_url() ?>" class="navbar-brand mr-0 mr-md-2 logo">
            <span class="logo-lg">
                <img src="<?= $core['full_logo'] ?>" alt="" height="70" />
                <span class="d-inline h6 ml-1 text-logo" style="font-style: italic;">
                    <?php if ($this->uri->segment(1) == 'chat') : ?>
                        Seller Chat Center
                    <?php else : ?>
                        Seller Center
                    <?php endif ?>
                </span>
            </span>
            <span class="logo-sm">
                <img src="<?= $core['mini_logo'] ?>" alt="" height="24">
            </span>
        </a>

        <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
            <li class="">
                <button class="button-menu-mobile open-left disable-btn">
                    <i data-feather="menu" class="menu-icon"></i>
                    <i data-feather="x" class="close-icon"></i>
                </button>
            </li>
        </ul>


        <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
            <?php if ($this->uri->segment(2) != 'buka_toko') : ?>
                <li class="notification-list" data-toggle="tooltip" data-placement="left" title="Chat">
                    <a href="<?= base_url() ?>chat" class="nav-link mr-0" aria-haspopup="false" aria-expanded="false">
                        <!-- <i data-feather="message-square"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-chat.png" alt="icon" class="mr-2" style="width: 19px; height: 16px;">

                        <span class="badge badge-warning" style=" border-radius:60%;" id="notifc"></span>
                        <input type="hidden" id="notifch">

                    </a>
                </li>
                <li class="dropdown notification-list" data-toggle="tooltip" data-placement="left">
                    <!-- <li class="dropdown notification-list" data-toggle="tooltip" data-placement="left" title="8 new unread notifications"> -->
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" onclick="ReadNotif()">
                        <!-- <i data-feather="bell"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-notif.png" alt="icon" class="mr-2" style="width: 16px; height: 16px;">
                        <!-- <span class="noti-icon-badge"></span> -->
                        <?php
                        $jumlah_notif = $this->master_model->select_data([
                            'field' => 'COUNT(id_notif) as jumlah',
                            'table' => 'notifikasi',
                            'where' => [
                                'id_toko' => $this->data['seller']->id_toko,
                                'notifikasi_seller' => 'T'
                            ]
                        ])->row()->jumlah;
                        ?>

                        <span class="badge badge-warning" style=" border-radius:60%;" id="notifh"></span>
                        <!-- <span class="badge badge-warning" style=" border-radius:60%;"><?= $jumlah_notif ?></span> -->
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">

                        <div class="noti-title border-bottom">
                            <h5 class="m-0 font-size-16">
                                <span class="float-right">
                                    <a href="#" class="text-dark">
                                        <!-- <small>Clear All</small> -->
                                    </a>
                                </span>Pemberitahuan
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">
                            <?php
                            $get_notif_wish = $this->master_model->select_data([
                                'field' => 'notifikasi.*,notifikasi.id_data as id_trans ,produk_wishlist.*,customer.*,transaksi.invoice, transaksi.alasan_tolak,transaksi.alasan_pembatalan, transaksi_token.grand_total',
                                'table' => 'notifikasi',
                                'join' => [
                                    [
                                        'table' => 'produk_wishlist',
                                        'on' => 'notifikasi.id_wish = produk_wishlist.id_data',
                                        'type' => 'left'
                                    ],
                                    [
                                        'table' => 'customer',
                                        'on' => 'customer.id_customer = notifikasi.id_user',
                                        'type' => 'left'
                                    ],
                                    [
                                        'table' => 'transaksi',
                                        'on' => 'transaksi.invoice = notifikasi.invoice',
                                        'type' => 'left'
                                    ],
                                    [
                                        'table' => 'transaksi_token',
                                        'on' => 'transaksi.order_id = transaksi_token.order_id',
                                        'type' => 'left'
                                    ]
                                ],
                                'where' => [
                                    'notifikasi.id_toko' => $this->data['seller']->id_toko,
                                    'notifikasi.notifikasi_seller' => 'T'
                                ],
                                'order_by' => [
                                    'notifikasi.id_notif' => 'desc'
                                ]
                            ])->result();

                            foreach ($get_notif_wish as $key) {
                                $text = NULL;
                                $message = NULL;
                                $icon = NULL;
                                $href = base_url() . 'penjualan/pesanan/detail/' . encrypt_text($key->id_trans);

                                switch ($key->text) {
                                    case 'Pesanan Dibatalkan':
                                        $message = 'Pesanan Dibatalkan <br>Yaahh :(  pembeli telah membatalkan Pesanan <b>#' . $key->invoice . ' </b> karena <b>' . $key->alasan_pembatalan . '</b>. ';
                                        $icon = '<img src="https://nimda.jaja.id/asset/images/icon-jaja/Icon caution-10.png" width=30px">';
                                        break;

                                    case 'Pesanan Telah Dibayar':
                                        $message = 'Pesanan Baru<br>Horeee Pesanan <b>#' . $key->invoice . ' </b>  telah dibayar !!! <br> Ayo segera konfirmasi pesanan ini.';
                                        $icon = '<img src="https://nimda.jaja.id/asset/images/icon-jaja/Icon Card-05.png" width=30px">';
                                        break;

                                    case 'Pesanan Belum Dibayar':
                                        $message = 'Pesanan Menunggu Pembayaran <br>Hai Pesanan baru <b>#' . $key->invoice . ' </b> belum dibayar sebesar Rp ' . number_format($key->grand_total) . '. <br>Silahkan menunggu pembayaran dari pembeli.';
                                        $icon = '<img src="https://nimda.jaja.id/asset/images/icon-jaja/Icon Cart-57.png" width=30px">';
                                        break;

                                    case 'Pembatalan Pesanan Menunggu Konfirmasi':
                                        $message = 'Pesanan Dibatalkan <br>Yaahh :( Pesanan <b>#' . $key->invoice . ' telah dibatalkan </b>.<br> Dana akan segera dikembalikan ke rekening pembeli';
                                        $icon = '<img src="https://nimda.jaja.id/asset/images/icon-jaja/Icon caution-10.png" width=30px">';
                                        break;

                                    case 'Pesanan Ditolak Penjual':
                                        $message = 'Pesanan Dibatalkan <br>Yaahh :(  Pesanan <b>#' . $key->invoice . ' </b> ditolak oleh penjual karena <b>.$key->alasan_tolak.</b>.<br>Dana akan segera dikembalikan ke rekening pembeli.';
                                        $icon = '<img src="https://nimda.jaja.id/asset/images/icon-jaja/Icon caution-10.png" width=30px">';
                                        break;

                                    case 'Pesanan Diterima':
                                        $message = 'Pesanan Selesai <br> Yeeayy :)  Pesanan <b>#' . $key->invoice . ' </b> telah diterima.<br>Dana akan segera ditambahkan ke dalam Saldo Toko mu.';
                                        $icon = '<img src="https://nimda.jaja.id/asset/images/icon-jaja/Icon Cart-15.png" width=30px">';
                                        break;

                                    case 'Favorit':
                                        $message = '<b>Favorit</b>
                                                    <br><span>Produk Toko mu ditambahkan ke favorit oleh <b>' . $key->nama_lengkap . '</b></span>
                                                    <small>' . $key->created_date . '</small>';
                                        $icon = '<i class="fas fa-heart" style="color: #f52c4d;"></i>';
                                        $href = 'https://jaja.id/produk/' . $key->produk_slug;

                                        break;

                                    default:
                                        break;
                                }

                            ?>
                                <a href="<?= $href ?>" class="dropdown-item notify-item border-bottom">
                                    <div class="notify-icon bg-default"><?= $icon ?></div>
                                    <p class="notify-details"><?= $message; ?>
                                    </p>
                                    <p align="right"><small style="background:#EBFFEF!important;color:#18B323!important;"><?= $text ?></small></p>
                                </a>


                            <?php } ?>


                        </div>
                        <!-- All-->
                        <a href="<?= base_url() . 'master/notifikasi' ?>" class="dropdown-item text-center text-primary notify-item notify-all border-top">
                            View all
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>
            <?php endif ?>

            <?php if ($this->uri->segment(2) != 'buka_toko') : ?>
                <li class="dropdown notification-list align-self-center">
                    <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <div class="media user-profile">
                            <?php if (!empty($core['seller']->foto)) : ?>
                                <img src="<?= base_url() ?>asset/front/images/file/<?= $core['seller']->foto ?>" alt="user-image" class="rounded-circle align-self-center" />
                            <?php else : ?>
                                <img src="<?= base_url() ?>asset/images/toko-default.png" alt="user-image" class="rounded-circle align-self-center" />
                            <?php endif ?>
                            <div class="media-body text-left">
                                <h6 class="pro-user-name ml-2 my-0">
                                    <span><?= $core['seller']->nama_toko ?></span>
                                    <?php
                                    if ($core['seller']->kategori_seller == 'Bronze') {
                                        $style_kategori_seller = 'background-color: #A97142;';
                                    } elseif ($core['seller']->kategori_seller == 'Platinum') {
                                        $style_kategori_seller = 'background-color: #CDD5E0;';
                                    } elseif ($core['seller']->kategori_seller == 'Diamond') {
                                        $style_kategori_seller = 'background-color: #70D1F4;';
                                    }
                                    ?>
                                    <span class="pro-user-desc text-white d-block mt-1 badge" style="<?= $style_kategori_seller ?>"><?= $core['seller']->kategori_seller ?></span>
                                </h6>
                            </div>
                            <span data-feather="chevron-down" class="ml-2 align-self-center"></span>
                        </div>
                    </a>
                    <div class="dropdown-menu profile-dropdown-items dropdown-menu-right">
                        <a href="https://jaja.id/" class="dropdown-item notify-item">
                            <i data-feather="arrow-up-left" class="icon-dual icon-xs mr-2"></i>
                            <span>Kembali ke Jaja.id</span>
                        </a>

                        <a href="<?= base_url() . 'pengaturan/toko' ?>" class="dropdown-item notify-item">
                            <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                            <span>Pengaturan Toko</span>
                        </a>
                    </div>
                </li>


            <?php else : ?>
                <li class="notification-list align-self-center">
                    <a href="https://jaja.id/" class="dropdown-item notify-item">
                        <i data-feather="arrow-up-left" class="icon-dual icon-xs mr-2"></i>
                        <span>Kembali ke Jaja.id</span>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </div>

</div>

<script>
    function ReadNotif() {

        var database = firebase.database();
        let notif = "";

        let fire = database.ref(`people/<?= $core['seller']->uid ?>`).limitToLast(20).on("value", function(snapshot) {
            let item = snapshot.val();
            // console.log(item)   

            database.ref(`/people/<?= $core['seller']->uid ?>/notif`).update({
                home: 0,
                orders: 0
            })
        });

    }
</script>