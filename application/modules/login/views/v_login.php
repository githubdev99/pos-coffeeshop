<form action="<?= base_url() ?>home/buka_toko" method="post" enctype="multipart/form-data" name="buka_toko">
    <div class="row">
        <div class="col-6 col-center" style="margin-top: 10%;">
            <img src="<?= base_url() ?>asset/images/icons/buka-toko.png" alt="buka-toko" class="img-fluid" style="height: 500px; border-radius: 15px;">
        </div>
        <div class="col-6 col-center">
            <div class="card" style="width: 80%;">
                <div class="card-body p-3">
                    <h5 class="mb-4">Halo, <?= (!empty($core['customer']->nama_lengkap)) ? "<b>{$core['customer']->nama_lengkap}</b> " : ""; ?>ayo mulai buka tokomu!</h5>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Nama Toko <span class="text-danger">*</span></label>
                                <input type="text" name="nama_toko" class="form-control" placeholder="Masukkan Nama Toko" maxlength="25" onkeyup="show_maxlength('nama_toko');" required>
                                <span class="help-block float-right" id="maxlength_nama_toko">0/25</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Provinsi <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="provinsi" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Kota/Kabupaten <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="kota_kabupaten" required>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="kecamatan" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Kelurahan <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="kelurahan" required>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" name="kode_pos" class="form-control" placeholder="Masukkan Kode Pos" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Alamat Toko <span class="text-danger">*</span></label>
                                <textarea name="alamat_toko" class="form-control" placeholder="Masukkan Alamat Toko" required cols="20" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Greeting Message <span class="text-danger">*</span></label>
                                <input type="text" name="greating_message" class="form-control" placeholder="Masukkan Greeting Message" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <label>Deskripsi Toko <span class="text-danger">*</span></label>
                                <textarea name="deskripsi_toko" class="form-control" placeholder="Masukkan Deskripsi" required cols="20" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check" required>
                                    <label class="custom-control-label" for="check">Saya setuju dengan <a href="#">syarat dan ketentuan</a> serta <a href="#">kebijakan privasi</a> Jaja.id</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-3 mt-sm-0">
                                <button type="submit" class="btn btn-info btn-block btn-lg" name="buka_toko" value="buka_toko">Buka Tokomu Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>