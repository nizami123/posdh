<form method="POST" enctype="multipart/form-data" class="row">
    <div class="col-md-5">
        <div class="card pt-3">
            <div class="card-body">
                <?php if($this->session->flashdata ('danger')) : ?>
                    <div class="alert alert-danger">
                        <strong>Gagal Upload</strong>
                        <p class="mb-0">
                            <?= $this->session->flashdata ('danger') ?>
                        </p>
                        <div class="alert-icon d-flex">
                            <i class="fa fa-exclamation fa-2x"></i>
                        </div>
                    </div>
                <?php endif ?>
                <div class="alert alert border text-dark mb-4">
                    <strong>Catatan</strong>
                    <p class="mb-0">
                        Import data barang sesuai dengan format data yang sudah ditentukan. 
                    </p>
                    <div class="mt-2">
                        <a href="<?= base_url('upload/template_import_brg.xlsx') ?>" class="badge badge-success">
                            <i class="fa fa-download mr-1"></i>
                            Download Template Excel
                        </a>
                    </div>
                    <div class="alert-icon d-flex">
                         <i class="fa fa-info fa-2x mr-1"></i>
                    </div>
                </div>
                <div class="form-group">
                        <input type="file" name="file" class="d-none" id="inp_file" accept=".xls, .xlsx">
                        <label for="inp_file" id="inp_file_label">
                            <i class="fa fa-upload"></i> 
                            <br>
                            <span>
                                Unggah File
                            </span>
                        </label>
                    
                        <small id="view_file_name"></small>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" name="submit">
                        Simpan
                    </button>
                    <a href="<?= site_url('inventaris') ?>" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</form>
