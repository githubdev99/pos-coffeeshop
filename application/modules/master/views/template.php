<?= $this->load->view('layout/header'); ?>
<div id="wrapper">
    <?php if ($this->uri->segment(2) == 'buka_toko') { ?>

        <?= $this->load->view('layout/navbar'); ?>

        <div class="container-fluid" style="margin-top: 100px;">
            <?php
            if (!empty($get_view)) {
                $this->load->view($get_view);
            }
            ?>
        </div>

        <div class="card" style="position: absolute; bottom: 0px; width: 100%; margin-bottom: 0px !important;">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            &copy; <?= date('Y') ?> Jaja ID All Rights Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } elseif ($this->uri->segment(1) == 'chat') { ?>
        <?= $this->load->view('layout/navbar'); ?>

        <?php
        if (!empty($get_view)) {
            $this->load->view($get_view);
        }
        ?>
    <?php } elseif ($this->uri->segment(1) == 'loginadmin') { ?>
        <?= $this->load->view('layout/navbarlogin'); ?>

        <div class="container-fluid">
            <?php
            if (!empty($get_view)) {
                $this->load->view($get_view);
            }
            ?>
        </div>

        <div class="card" style="position: absolute; bottom: 0px; width: 100%; margin-bottom: 0px !important;">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            &copy; <?= date('Y') ?> Jaja ID All Rights Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php } elseif ($this->uri->segment(3) == 'cetak_label') { ?>

        <?= $this->load->view('layout/navbar'); ?>
        <div class="content-page">

            <div class="col-6">
            </div>

            <div class="content-page">

                <?php
                if (!empty($get_view)) {
                    $this->load->view($get_view);
                }
                ?>

            </div>

            <div style="margin-bottom: 50px;"></div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            &copy; <?= date('Y') ?> Jaja ID All Rights Reserved.
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    <?php } else { ?>
        <?= $this->load->view('layout/navbar'); ?>
        <?= $this->load->view('layout/sidebar'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <?php
                    if (!empty($get_view)) {
                        $this->load->view($get_view);
                    }
                    ?>
                </div>
            </div>

            <div style="margin-bottom: 50px;"></div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            &copy; <?= date('Y') ?> Jaja ID All Rights Reserved.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    <?php } ?>
</div>


<?= $this->load->view('layout/footer'); ?>