<div class="card pt-3">
    <div class="card-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="mb-0 text-primary">Data</h2>
            <small>Pengeluaran</small>
        </div>
        <div>
            <a href="<?= site_url('pengeluaran/index/item?user=owner') ?>" class="btn btn-light border px-4">
                Data Item
            </a>
            <a href="<?= site_url('pengeluaran/index/tambah?user=owner') ?>" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="data_keluar">
                <thead>
                    <th style="width: 50px">No</th>
                    <th>Barang</th>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detail">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>