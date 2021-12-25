<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Master Data</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">History Transaksi</h4>

                <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="listBill">
                    <thead class="table-info">
                        <tr>
                            <th>No</th>
                            <th>Bill</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Belanja</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Modal Bill Detail -->
<div class="modal fade" id="billDetail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="invoice-title">
                    <h4 class="float-end font-size-16" id="bill"></h4>
                    <div class="mb-4">
                        <?= $core['appName'] ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <address>
                            <strong>Nama Pemesan:</strong><br>
                            <span id="customerName"></span>
                        </address>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                    </div>
                </div>
                <div class="py-2 mt-3">
                    <h3 class="font-size-15 fw-bold">Detail Pesanan</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody id="billDetailItems">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>