<div class="card pt-3">
    <div class="card-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="mb-0 text-primary">Pengeluaran</h2>
            <small>Data item</small>
        </div>
        <div>            
            <a href="javascript:void(0)" class="btn btn-primary btn_add_item">
                <i class="fa fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row data_item">
            
        </div>
    </div>
</div>

<form class="modal" id="modal_item">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mb-0">
                    Tambah
                </h5>
                <button class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Item</label>
                    <input type="hidden" name="type" value="<?= isset($_GET['user']) ? $_GET['user'] : 'Owner' ?>">
                    <input type="hidden" name="id" value="0">
                    <input type="text" class="form-control" name="nama" value="" required>
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