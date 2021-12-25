<?php $this->load->view('layout/header'); ?>
<div id="layout-wrapper">
    <?php if (!empty($this->uri->segment(1)) && ($this->uri->segment(1) != 'login')) : ?>
        <?php $this->load->view('layout/navbar'); ?>
        <?php $this->load->view('layout/sidebar'); ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php
                    if (!empty($get_view)) {
                        $this->load->view($get_view);
                    }
                    ?>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script> <?= $core['appName'] ?>. All right reserved
                    </div>
                </div>
            </div>
        </footer>
    <?php else : ?>
        <?php
        if (!empty($get_view)) {
            $this->load->view($get_view);
        }
        ?>
    <?php endif ?>
</div>
<?php $this->load->view('layout/footer'); ?>