<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Pelanggan</h5>
                    <small>Data Pelanggan</small>
                </div>
                <div>
                     <a href="#modal_tambah_plg" data-toggle="modal" class="btn btn-primary">
                        <i class="fa fa-plus mr-1"></i> 
                        Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_plg">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
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

<form method="post" class="modal fade" id="modal_tambah_plg">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Pelanggan</h5>
                    <small class="text-muted">Tambah Data Pelanggan Baru</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Nama Pelanggan <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm" name="nama_plg" required>
                    </div>                
                    <div class="form-group col-md-12">
                        <label for="">No Ponsel</label>
                        <input type="text" class="form-control form-control-sm" name="no_ponsel" >
                    </div>   
                    <div class="form-group col-md-12">
                        <label for="">Email</label>
                        <input type="text" class="form-control form-control-sm" name="email" >
                    </div>  
                    <div class="form-group col-md-12">
                        <label for="">Tgl Lahir</label>
                        <input type="date" class="form-control form-control-sm" name="tgl_lahir">
                    </div>     
                    <div class="form-group col-md-12">
                        <label for="">Agama</label>
                        <select class="form-control form-control-sm" name="agama" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>                  
                    <div class="form-group col-md-12">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control form-control-sm" name="alamat">
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

<form method="post" class="modal fade" id="modal_ubah_plg">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            
        </div>
    </div>
</form>
