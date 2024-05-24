<div class="row">
    <div class="col-md-12">
        <?php if($this->session->flashdata('success')) : ?>
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

        <form method="post" class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Sandi Lama</label>
                    <input type="password" class="form-control form-control-sm" name="pass_lama" required>
                </div>
                <div class="form-group">
                    <label>Sandi Baru</label>
                    <input type="password" class="form-control form-control-sm" name="pass_baru" required>
                </div>
                <div class="form-group">
                    <label>Ulangi Sandi Baru</label>
                    <input type="password" class="form-control form-control-sm" name="confirm" required>
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