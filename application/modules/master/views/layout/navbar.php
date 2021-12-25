<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index-2.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>assets/images/logo-light.svg" alt="" height="22">
                    </span>
                    <span class="logo-lg text-white">
                        <img src="<?= base_url() ?>assets/images/logo-light.svg" alt="" height="19">
                        <?= $core['appName'] ?>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?= base_url() ?>assets/images/avatar_male.png" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 data-adminName" key="t-henry"></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="logout()"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>
        </div>
    </div>
</header>