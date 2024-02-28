<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('success2')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success2') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>
        
        <?php if($this->session->flashdata('error2')) : ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error2') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>
        <form method="post" class="card" enctype="multipart/form-data">
            <div class="card-header">
                <div>
                    <h5 class="mb-0">
                        Update
                    </h5>
                    <small>Unggah update aplikasi</small>
                </div>
            </div>
            <div class="card-body">
                <input type="file" name="file" class="d-none" id="inp_file" accept=".zip">
                <label for="inp_file" id="inp_file_label">
                    <i class="fa fa-upload"></i> 
                    <br>
                    <span>
                        Unggah File
                    </span>
                </label>
            
                <small id="view_file_name"></small>
            </div>
            <div class="card-footer pb-4">
                <button class="btn btn-primary" name="update">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>