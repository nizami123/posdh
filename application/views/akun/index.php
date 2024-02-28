<div class="row">
    <div class="col-md-4">
        <?php 
            $foto = admin()->foto ? 'upload/karyawan/'.admin()->foto : 'upload/no-img.png';
            if($this->session->flashdata('success')) : 
        ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>
        <?php if($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>
        <div class="card mb-3">
            <div class="card-body">
                <small>
                    Anda adalah: 
                </small>
                <br>
                <strong class="text-primary"><?= admin()->level ?></strong>
            </div>
            <div class="card-icon d-flex"><i class="fa fa-user"></i></div>
        </div>
        <form method="post" enctype="multipart/form-data" class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Karyawan</label>
                    <input type="text" class="form-control form-control-sm" name="u_nama" value="<?= admin()->nama_admin ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control form-control-sm" name="u_email" value="<?= admin()->email_admin ?>">
                </div>
                   
                <div class="form-group">
                    <label for="">Foto</label>
                    <div class="mt-2">
                        <div class="alert alert-light border">
                            <h6>Catatan: </h6>
                            <ol class="p-0 my-0 mx-3">
                                <li>Ukuran logo tidak boleh lebih dari <strong>1 MB</strong></li>
                                <li>Hanya mendukung format gambar <strong>jpg, jpeg, png</strong></li>
                            </ol>
                        </div>
                        <label for="inp_foto" class="upload_grup">
                            <div class="_img">
                                <img src="<?= base_url($foto) ?>" class="view_foto w-100">
                            </div>

                            <input type="file" name="u_foto" id="inp_foto" class="inp_foto" accept=".jpg, .jpeg, .png">
                            <label for="inp_foto" class="lab_foto">Unggah</label>
                        </label>
                    </div>
                </div>         
            </div>
            <div class="card-footer pb-4">
                <button class="btn btn-primary w-100" name="simpan">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>