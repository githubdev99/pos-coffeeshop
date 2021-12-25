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
                <div class="row mb-4">
                    <div class="col-6">
                        <h4 class="card-title">Kategori Menu</h4>
                    </div>
                    <div class="col-6" style="text-align: right;">
                        <button type="button" class="btn btn-success waves-effect waves-light" onclick="showAddCategory()">Tambah Data</button>
                    </div>
                </div>

                <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="listCategory">
                    <thead class="table-info">
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Modal Add Category -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data" name="addCategory">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Tambah Menu Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Kategori Menu <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control addCategory" type="text" name="name">
                            <span class="text-danger body-name"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light" name="addCategory">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data" name="editCategory">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Edit Menu Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Kategori Menu <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input class="form-control editCategory" type="text" name="name">
                            <span class="text-danger body-name"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="form-control editCategory" type="hidden" name="id">

                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light" name="editCategory">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>