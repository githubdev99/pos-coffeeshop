<div class="left-side-menu">
    <div class="media user-profile mt-2 mb-2">
        <?php if (!empty($core['seller']->foto)) : ?>
            <img src="<?= base_url() ?>asset/front/images/file/<?= $core['seller']->foto ?>" class="avatar-sm rounded-circle mr-2" alt="user-image" />
            <img src="<?= base_url() ?>asset/front/images/file/<?= $core['seller']->foto ?>" class="avatar-xs rounded-circle mr-2" alt="user-image" />
        <?php else : ?>
            <img src="<?= base_url() ?>asset/images/toko-default.png" class="avatar-sm rounded-circle mr-2" alt="user-image" />
            <img src="<?= base_url() ?>asset/images/toko-default.png" class="avatar-xs rounded-circle mr-2" alt="user-image" />
        <?php endif ?>

        <div class="media-body">
            <?php
            if ($core['seller']->kategori_seller == 'Bronze') {
                $style_kategori_seller = 'background-color: #A97142;';
            } elseif ($core['seller']->kategori_seller == 'Platinum') {
                $style_kategori_seller = 'background-color: #CDD5E0;';
            } elseif ($core['seller']->kategori_seller == 'Diamond') {
                $style_kategori_seller = 'background-color: #70D1F4;';
            }
            ?>
            <h6 class="pro-user-name mt-0 mb-0"><?= $core['seller']->nama_toko ?></h6>
            <span class="pro-user-desc badge text-white" style="<?= $style_kategori_seller ?>"><?= $core['seller']->kategori_seller ?></span>
        </div>
        <div class="dropdown align-self-center profile-dropdown-menu">
            <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <span data-feather="chevron-down"></span>
            </a>
            <div class="dropdown-menu profile-dropdown">
                <a href="https://jaja.id/" class="dropdown-item notify-item">
                    <i data-feather="arrow-up-left" class="icon-dual icon-xs mr-2"></i>
                    <span>Kembali ke Jaja.id</span>
                </a>
                <a href="<?= base_url() . 'pengaturan/toko' ?>" class="dropdown-item notify-item">
                    <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                    <span>Pengaturan Toko</span>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li onclick="verifikasi_password('<?= base_url() ?>dompetku/saldo');">
                    <a class="btn btn-soft-info" href="javascript:;" style="border-radius: 0px !important;">
                        <div class="float-left">Saldo</div>
                        <div class="float-right"><?= rupiah($core['saldo_seller']['remaining']) ?></div>
                        <div class="clearfix"></div>
                    </a>
                </li>

                <li class="menu-title">Menu</li>

                <li class="<?= ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') ? '' : ''; ?>">
                    <a href="<?= base_url() ?>home">
                        <!-- <i data-feather="home"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-home.png" alt="icon" class="mr-2" style="width: 16px; height: 16px;">
                        <span> Beranda </span>
                    </a>
                </li>

                <li class="<?= ($this->uri->segment(1) == 'penjualan') ? '' : ''; ?>">
                    <a>
                        <!-- <i data-feather="file-text"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-file.png" alt="icon" class="mr-2" style="width: 16px; height: 16px;">
                        <span> Penjualan </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="<?= ($this->uri->segment(2) == 'pesanan') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>penjualan/pesanan" class="<?= ($this->uri->segment(2) == 'pesanan') ? 'active' : ''; ?>">Pesanan</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'resolusi') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>penjualan/resolusi" class="<?= ($this->uri->segment(2) == 'resolusi') ? 'active' : ''; ?>">Pusat Resolusi</a>
                        </li>
                    </ul>
                </li>

                <li class="<?= ($this->uri->segment(1) == 'produk') ? 'mm-active' : ''; ?>">
                    <a>
                        <!-- <i data-feather="package"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-cart.png" alt="icon" class="mr-2" style="width: 16px; height: 16px;">
                        <span> Produk </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="<?= ($this->uri->segment(1) == 'produk') ? 'true' : ''; ?>">
                        <li class="<?= ($this->uri->segment(2) == 'produk') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>produk" class="<?= ($this->uri->segment(2) == 'produk') ? 'active' : ''; ?>">
                                Daftar Produk
                                <?php if ($core['isGift']) : ?>
                                    &nbsp;<span class="badge badge-info">GIFT</span>
                                <?php endif ?>
                            </a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'tambah') ? 'mm-active' : ''; ?>" onclick="validate_kurir('<?= base_url() ?>produk/tambah');">
                            <a href="javascript:;" class="<?= ($this->uri->segment(2) == 'tambah') ? 'active' : ''; ?>">
                                Tambah Produk
                                <?php if ($core['isGift']) : ?>
                                    &nbsp;<span class="badge badge-info">GIFT</span>
                                <?php endif ?>
                            </a>
                        </li>
                        <!-- <li class="<?= ($this->uri->segment(2) == 'uploadmassal') ? '' : ''; ?>" onclick="validate_kurir('<?= base_url() ?>produk/uploadmassal');">
                            <a href="javascript:;" class="<?= ($this->uri->segment(2) == 'uploadmassal') ? 'active' : ''; ?>">Upload Massal</a>
                        </li> -->
                        <li class="<?= ($this->uri->segment(2) == 'brand') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>produk/brand" class="<?= ($this->uri->segment(2) == 'brand') ? 'active' : ''; ?>">Daftar Brand</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'etalase') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>produk/etalase" class="<?= ($this->uri->segment(2) == 'etalase') ? 'active' : ''; ?>">Daftar Etalase</a>
                        </li>
                    </ul>
                </li>

                <li class="<?= ($this->uri->segment(1) == 'promosi') ? '' : ''; ?>">
                    <a>
                        <!-- <i data-feather="percent"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-diskon.png" alt="icon" class="mr-2" style="width: 14px; height: 16px;">
                        <span> Promosi </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="<?= ($this->uri->segment(2) == 'voucher') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>promosi/voucher" class="<?= ($this->uri->segment(2) == 'voucher' || $this->uri->segment(3) == 'tambah') ? 'active"' : ''; ?>">Voucher Toko</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'diskon') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>promosi/diskon" class="<?= ($this->uri->segment(2) == 'diskon') ? 'active' : ''; ?>">Pengaturan Diskon</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'freeongkir') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>promosi/freeongkir" class="<?= ($this->uri->segment(2) == 'freeongkir') ? 'active' : ''; ?>">Program Gratis Ongkir</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'feed') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>promosi/feed" class="<?= ($this->uri->segment(2) == 'feed') ? 'active' : ''; ?>">Feed Post</a>
                        </li>

                        <!-- <li class="<?= ($this->uri->segment(2) == 'flashsale') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>promosi/flashsale" class="<?= ($this->uri->segment(2) == 'flashsale') ? 'active' : ''; ?>">Flashsale</a>
                        </li> -->

                        <li class="<?= ($this->uri->segment(2) == 'flashsale') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>promosi/flashsale" class="<?= ($this->uri->segment(2) == 'flashsale') ? 'active' : ''; ?>">Flashsale <br><span class="ml-2 badge badge-warning text-white" style="font-size: 12px;">Coming Soon</span></a>
                        </li>
                    </ul>
                </li>

                <li class="<?= ($this->uri->segment(1) == 'dompetku') ? '' : ''; ?>">
                    <a>
                        <!-- <i class="fas fa-wallet"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-dompet.png" alt="icon" class="mr-2" style="width: 16px; height: 16px;">
                        <span> Dompetku </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="<?= ($this->uri->segment(2) == 'penghasilan') ? '' : ''; ?>" onclick="verifikasi_password('<?= base_url() ?>dompetku/penghasilan');">
                            <a href="javascript:;" class="<?= ($this->uri->segment(2) == 'penghasilan') ? 'active' : ''; ?>">Penghasilan Toko</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'saldo') ? '' : ''; ?>" onclick="verifikasi_password('<?= base_url() ?>dompetku/saldo');">
                            <a href="javascript:;" class="<?= ($this->uri->segment(2) == 'saldo') ? 'active' : ''; ?>">Saldo Toko</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'rekening') ? '' : ''; ?>" onclick="verifikasi_password('<?= base_url() ?>dompetku/rekening');">
                            <a href="javascript:;" class="<?= ($this->uri->segment(2) == 'rekening') ? 'active' : ''; ?>">Rekening Bank</a>
                        </li>
                    </ul>
                </li>

                <li class="<?= ($this->uri->segment(1) == 'review') ? '' : ''; ?>">
                    <a>
                        <!-- <i class="fas fa-smile"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-info.png" alt="icon" class="mr-2" style="width: 16px; height: 16px;">
                        <span> Review </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="<?= ($this->uri->segment(2) == 'rating') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>review/rating" class="<?= ($this->uri->segment(2) == 'rating') ? 'active"' : ''; ?>">Rating Produk</a>
                        </li>
                        <li class="<?= ($this->uri->segment(2) == 'report') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>review/report" class="<?= ($this->uri->segment(2) == 'report') ? 'active' : ''; ?>">Report Produk</a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="<? //= ($this->uri->segment(1) == 'pengaturan') ? '' : ''; 
                                ?>"> -->
                <li class="<?= ($this->uri->segment(1) == 'pengaturan') ? '' : ''; ?>">
                    <a>
                        <!-- <i data-feather="settings"></i> -->
                        <img src="<?= base_url() ?>asset/images/icon-jaja/jaja-akun.png" alt="icon" style="width: 11px; height: 16px; margin-right: 13px;">
                        <span> Pengaturan </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="<?= ($this->uri->segment(2) == 'toko') ? '' : ''; ?>">
                            <a href="<?= base_url() ?>pengaturan/toko">Pengaturan Toko</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>