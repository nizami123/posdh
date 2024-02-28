<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Karyawan</h5>
                    <small>Data Karyawan</small>
                </div>
                <div>
                     <a href="#modal_tambah_karyawan" data-toggle="modal" class="btn btn-primary">
                        <i class="fa fa-plus mr-1"></i> 
                        Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_karyawan">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Karyawan</th>
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

<form method="post" enctype="multipart/form-data" class="modal fade" id="modal_tambah_karyawan">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Karyawan</h5>
                    <small class="text-muted">Tambah Data Karyawan Baru</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Nama Karyawan <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm" name="nama" required>
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="email" required>
                    </div>         
                    <div class="form-group col-sm-12">
                        <label for="">Password</label>
                        <input type="password" name="pass" class="form-control form-control-sm">
                        <small class="text-muted">
                            *Jika dikosongkan maka password diset otomatis sesuai posisi
                            <br>
                            - Admin : Admin
                            <br>
                            - Kasir : Kasir
                        </small>
                    </div>           
                    <div class="form-group col-sm-12">
                        <label for="">Nama Toko</label>
                        <select name="toko"  class="form-control form-control-sm select2">
                            <?php foreach($data_toko as $i => $toko) :  ?>
                                <option value="<?= $toko->id_toko ?>">
                                    <?= $toko->nama_toko ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>            
                    <div class="form-group col-md-12">
                        <label for="">Posisi</label>
                        <?php 
                            $data_pos = ['Admin', 'Kasir'];
                            foreach($data_pos as $i => $pos) : 
                                if(array_key_first($data_pos) == $i) :
                        ?>
                                <div class="custom-control custom-radio">
                                    <input type="radio" 
                                        name="posisi" id="<?= $pos ?>" 
                                        value="<?= $pos ?>" 
                                        class="custom-control-input"
                                        checked
                                    >
                                    <label for="<?= $pos ?>" 
                                        class="custom-control-label"
                                    >
                                        <?= $pos ?>
                                    </label>
                                </div>

                            <?php else: ?>

                                <div class="custom-control custom-radio">
                                    <input type="radio" 
                                        name="posisi" id="<?= $pos ?>" 
                                        value="<?= $pos ?>" 
                                        class="custom-control-input"
                                        
                                    >
                                    <label for="<?= $pos ?>" 
                                        class="custom-control-label"
                                    >
                                        <?= $pos ?>
                                    </label>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                      
                    <div class="form-group col-sm-12">
                        <label for="">Foto</label>
                        <div class="mt-2">
                            <div class="alert alert-light border">
                                Ukuran gambar tidak boleh lebih dari <strong>1MB</strong> dan hanya mendukung format gambar <strong>jpg, jpeg, png</strong>
                            </div>
                            <label for="inp_foto" class="upload_grup">
                                <div class="_img">
                                    <img src="<?= base_url('upload/no-img.png') ?>" class="view_foto w-100">
                                </div>

                                <input type="file" name="foto" id="inp_foto" class="inp_foto" accept=".jpg, .jpeg, .png">
                                <label for="inp_foto" class="lab_foto">Unggah</label>
                            </label>
                        </div>
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

<form method="post" enctype="multipart/form-data" class="modal fade" id="modal_ubah_karyawan">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            
        </div>
    </div>
</form>
