<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Menu Coffeeshop</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-7">
        <ul class="nav nav-pills nav-justified mb-3" id="listCategory" role="tablist">
        </ul>
        <div class="row" id="listMenu">
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Keranjang Belanja</h4>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="listCart">
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
                <div class="row">
                    <div class="col mt-2">
                        <table border="0">
                            <tr>
                                <td>Total Kuantitas</td>
                                <td>&ensp;:&ensp;</td>
                                <td><span id="totalQty" style="font-weight: bold;"></span></td>
                            </tr>
                            <tr>
                                <td>Total Belanja</td>
                                <td>&ensp;:&ensp;</td>
                                <td><span id="totalPrice" style="font-weight: bold;"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col" style="text-align: right;">
                        <button type="button" class="btn btn-success waves-effect mt-3" onclick="showAddCheckout()">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="modal fade" id="addCheckout" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data" name="addCheckout">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-3 col-form-label">Nama Pemesan <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input class="form-control addCheckout" type="text" name="customerName">
                            <span class="text-danger body-customerName"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light" name="addCheckout">Checkout</button>
                </div>
            </div>
        </form>
    </div>
</div>