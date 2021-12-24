<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="<?= base_url() ?>" class="navbar-brand mr-0 mr-md-2 logo">
            <span class="logo-lg">
                <span class="d-inline h6 ml-1 text-logo badge" style="font-style: italic; color: #A97142;">
                    <?= $core['appName'] ?> <?= $this->uri->segment(1) ?>
                </span>
            </span>
            <span class="logo-sm">
                POS
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
            <li class="dropdown notification-list align-self-center">
                <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <div class="media user-profile">
                        <img src="<?= base_url() ?>asset/images/avatar_male.png" alt="user-image" class="rounded-circle align-self-center" />
                        <div class="media-body text-left">
                            <h6 class="pro-user-name ml-2 my-0">
                                <span class="dataAdminName">ascsac</span>
                                <span class="pro-user-desc text-white d-block mt-1 badge" style="background-color: #A97142;">Admin</span>
                            </h6>
                        </div>
                        <span data-feather="chevron-down" class="ml-2 align-self-center"></span>
                    </div>
                </a>
                <div class="dropdown-menu profile-dropdown-items dropdown-menu-right">
                    <a href="javascript:void(0)" class="dropdown-item notify-item">
                        <i data-feather="arrow-up-left" class="icon-dual icon-xs mr-2"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>

</div>