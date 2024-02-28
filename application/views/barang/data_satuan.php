<div class="row">
    <div class="col-sm-12">
        <div class="card">
             <div class="card-header d-flex justify-content-between align-items-start pt-4">
                <div>
                    <h5 class="mb-0 text-primary">Satuan</h5>
                    <small>Data satuan</small>
                </div>
                <a href="#modal_tambah_satuan" data-toggle="modal" class="btn btn-primary">
                    <i class="fa fa-plus mr-1"></i> 
                    Tambah
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_satuan">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>satuan</th>
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

<form method="post" class="modal fade" id="modal_tambah_satuan">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Tambah Data satuan</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama satuan <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control form-control-sm" name="nama_satuan" required>
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

<form method="post" class="modal fade" id="modal_ubah_satuan">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            
        </div>
    </div>
</form>
