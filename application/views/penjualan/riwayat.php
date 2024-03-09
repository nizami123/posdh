<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Riwayat</h5>
                    <small>Penjualan</small>
                </div>
                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_riwayat">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Cara Bayar</th>
                                <th>Bank</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" class="modal fade" id="modal_tambah_brg">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Tambah Data Barang Baru</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Kode Barang</label>
                        <input type="text" class="form-control form-control-sm" name="kode_brg">
                        <small class="text-muted">Jika kode barang kosong, maka akan dibuatkan kode otomatis</small>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Nama Barang <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm" name="nama_brg" required>
                    </div>                    
                    <div class="form-group col-md-8">
                        <label for="">Harga (Eceran) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="harga_eceran" required>
                    </div>                    
                    <div class="form-group col-md-4">
                        <label for="">Stok Brg</label>
                        <input type="text" class="form-control form-control-sm text-center" name="stok_brg">
                    </div>                    
                    <div class="form-group col-md-6">
                        <label for="">Kategori</label>
                        <select class="form-control form-control-sm select2" name="kategori_brg">
                            <option value="">Pilih Kategori</option>
                            <?php foreach($data_kategori as $kategori) : ?>
                                <option value="<?= $kategori->id_kategori ?>">
                                    <?= $kategori->nama_kategori ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>                                    
                    <div class="form-group col-md-6">
                        <label for="">Satuan <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm select2" name="satuan_brg" required>
                            <?php foreach($data_satuan as $satuan) : ?>
                                <option value="<?= $satuan->id_satuan ?>">
                                    <?= $satuan->nama_satuan ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                            
                    <div class="form-group col-md-12 mt-2">
                        <div class="d-flex justify-content-between">
                            <label>Penjualan Grosir</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" id="sw_grosir" name="is_grosir" class="custom-control-input" value="0">
                                <label for="sw_grosir" class="custom-control-label">
                                    <small id="sw_grosir_text">Nonaktif</small>
                                </label>
                            </div>                            
                        </div>
                        <div class="form_inp_grosir row mt-3"></div>
                    </div>  
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modal_detail_riwayat">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<form method="post" class="modal fade" id="modal_ubah_brg">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            
        </div>
    </div>
</form>
