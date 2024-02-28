<div class="row">
    <div class="col-sm-12">
        <?php if($this->session->flashdata('success')) : ?>
        <div class="alert alert-success mb-4">
            <p class="mb-0">
                <i class="fa fa-check mr-1"></i>
               <?= $this->session->flashdata('success') ?>
            </p>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Toko</h5>
                    <small>Data Toko</small>
                </div>
                <div>
                     <a href="#modal_tambah_toko" data-toggle="modal" class="btn btn-primary">
                        <i class="fa fa-plus mr-1"></i> 
                        Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_toko">
                        <thead class="bg-light">
                            <tr>
                                <th></th>
                                <th>Toko</th>
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

<form method="post" enctype="multipart/form-data" class="modal fade" id="modal_tambah_toko">
    <div class="modal-dialog modal-dialog-scrollable modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Toko</h5>
                    <small class="text-muted">Tambah Toko Baru</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Nama Toko <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm" name="nama" required>
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control form-control-sm" name="alamat">
                    </div>                    
                    
                </div>
            </div>
            <div class="modal-footer">
                <a href="" data-dismiss="modal" class="btn btn-light">
                    Batal
                </a>
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>

<form method="post" enctype="multipart/form-data" class="modal fade" id="modal_ubah_toko">
    <div class="modal-dialog modal-dialog-scrollable modal-sm">
        <div class="modal-content">
            
        </div>
    </div>
</form>
