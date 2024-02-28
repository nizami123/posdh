<?php 
    $uri3 = $this->uri->segment (3);
    if($uri3 != 'tambah') :
?>

<div class="card pt-3">
    <div class="card-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="mb-0 text-primary">Data</h2>
            <small>Barang Masuk</small>
        </div>
        <div>
            <a href="<?= site_url('inventaris/brg_masuk/tambah') ?>" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="brg_masuk">
                <thead>
                    <th>No</th>
                    <th>Barang</th>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php else: ?>

<form method="POST" class="card" id="submit_tambah_brgm">    
    <div class="card-header">
        <div>
            <h5 class="mb-0 text-primary">
                Barang
            </h5>
            <small>Tambah barang masuk</small>
        </div>
    </div>
    <div class="card-body">
        <div class="clearfix">
            <a href="#modal_add_brgm" data-toggle="modal" class="btn btn-secondary mb-3 float-left">
                <i class="fa fa-plus mr-1"></i> Tambah Brg
            </a>
            <input type="text" class="form-control form-control-sm float-right" id="src_brgm" style="width: 200px" placeholder="Ketikan kode barang">
        </div>
        <input type="text" id="scan_barcode" style="position:absolute;left:0;top:0;z-index:-1;opacity:0;">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100 datatables" id="tb_form_add_brgm">
                <thead class="text-center">
                    <th> </th>
                    <th>Barang </th>
                    <th style="width: 150px;">Harga Modal <span class="text-danger">*</span></th>
                    <th style="width: 120px">Masuk <span class="text-danger">*</span></th>
                    <th style="width: 150px;">Subtotal <span class="text-danger">*</span></th>
                    <th style="width: 200px;">Supplier</th>
                    <th style="width: 200px;">Keterangan</th>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot class="tfoot-brgm d-none">
                    <tr>
                        <th colspan="6" class="text-right">Total</th>
                        <th class="text-right total_brgm">0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="<?= site_url('inventaris/brg_masuk') ?>" class="btn btn-light mr-2">
            Kembali
        </a>
        <button class="btn btn-primary">
            Simpan
        </button>
    </div> 
</form>

<?php endif; ?>

<div class="modal fade" id="modal_add_brgm">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Barang
                    </h5>
                    <small>Tambah barang masuk</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">  
                    <table class="table table-bordered w-100" id="modal_data_add_brgm">
                        <thead>
                            <th></th>
                            <th>Barang</th>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detail_brgm">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            
        </div>
    </div>
</div>