<?php 
    if($this->session->flashdata('success')) {
        echo '
            <div class="alert alert-success">
                '.$this->session->flashdata('success').'
                <button class="close" data-dismiss="alert">&times;</button>
            </div>
        ';
    }
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Cabang</h5>
                    <small>Data Cabang</small>
                </div>
                <?php if(admin()->level != 'Kasir') : ?>
                <div class="text-right">
                     <a href="#modal_tambah_cab" data-toggle="modal" class="btn btn-secondary">
                        <i class="fa fa-plus-circle mr-1"></i> 
                        Tambah
                    </a>
                    
                </div>
                <?php endif ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_cab">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
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

<form method="post" class="modal fade" id="modal_tambah_cab">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Cabang</h5>
                    <small class="text-muted">Tambah Data Cabang Baru</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="form-group col-md-12">
                        <label for="">Nama Cabang <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm" name="nama" required>
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Alamat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="alamat" required>
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

<form method="post" class="modal fade" id="modal_ubah_cab">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            
        </div>
    </div>
</form>
