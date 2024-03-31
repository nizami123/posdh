<div class="card pt-3">
    <div class="card-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="mb-0 text-primary">Data <?=$nama_brg->nama_brg?></h2>
            <small>Barang Masuk</small>
        </div>
        <div>
            <a href="#modal_tambah_brg" data-toggle="modal" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> 
                Tambah
            </a>
        </div>
    </div>
    <input type="hidden" id="nama_brg_tambah" value="<?=$nama_brg->id_brg?>">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="brg_tambah">
                <thead>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Serial Number</th>
                    <th>Spesifikasi</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>
</div>

<form action="<?= site_url('inventaris/brg_masuk/tambah') ?>" method="post" class="modal fade" id="modal_tambah_brg">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Tambah Data Barang</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <input type="hidden" id="id_brg" name="id_brg" value="<?=$nama_brg->id_brg?>">
                        <label for="">Nama Barang <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm" name="nama_brg" required>
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Serial Number</label>
                        <input type="text" class="form-control form-control-sm" name="sn_brg" >
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Harga</label>
                        <input type="text" class="form-control form-control-sm" name="harga" onkeypress="return isNumberKey(event)" oninput="formatCurrency(this)">
                    </div>         
                    <div class="form-group col-md-12">
                        <label for="">Spesifikasi</label>
                        <textarea class="form-control form-control-sm" name="spek" id="spek" cols="30" rows="10"></textarea>
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

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function formatCurrency(input) {
        // Hapus semua karakter selain angka
        var value = input.value.replace(/\D/g, "");
        // Format ribuan dengan menambahkan tanda koma setiap 3 digit dari kanan
        var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Setel nilai input dengan format yang telah diformat
        input.value = formattedValue;
    }
</script>
