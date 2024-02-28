<?php 
   $mulai   = $this->uri->segment(3);
   $selesai = $this->uri->segment(4);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Laporan</h5>
                    <small><?= $mulai ? 'Filter berdasarkan tgl' : 'Keuangan bulan ini' ?></small>
                </div>
                <div>
                     <a href="#modal_tambah_brg" data-toggle="modal" class="btn btn-secondary">
                        <i class="fa fa-filter mr-1"></i> 
                    </a>
                    <?php if($data) : ?>
                    <a href="<?= site_url('laporan/cetak/keuangan/'.$mulai.'/'.$selesai) ?>" target="_blank" class="btn btn-primary cetak">
                        <i class="fa fa-print mr-1"></i> 
                        Cetak
                    </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($mulai) : ?>
    <div class="alert bg-white text-dark">
        Menampilkan laporan dari tgl <?= $mulai ?> s/d <?= $selesai ?>. &nbsp; <a href="<?= site_url('laporan/keuangan') ?>" class="text-dark"><strong>Tampilkan semua</strong></a>
    </div>
<?php endif ?>

<div class="card">
    <div class="card-body">
        <table class="table table-sm table-borderless mb-0">
            <tr>
                <th colspan="4">
                    Rincian Pembelian Barang
                </th>
            </tr>

            <tr>
                <td style="width: 200px">
                    Jumlah
                </td>
                <td style="width: 20px"> : </td>
                <th>
                    <?= $data['jml_beli'] ?> Item
                </th>
            </tr>
            <tr>
                <td>
                    Total
                </td>
                <td style="width: 20px"> : </td>
                <th>
                    <?= nf($data['total_beli']) ?>
                </th>
            </tr>

            <tr>
                <th colspan="3" class="pt-3">
                    Rincian Penjualan Barang
                </th>
            </tr>

            <tr>
                <td>
                    Jumlah
                </td>
                <td style="width: 20px"> : </td>
                <th>
                    <?= $data['jml_jual'] ?> Item
                </th>
            </tr>
            <tr>
                <td>
                    Total
                </td>
                <td style="width: 20px"> : </td>
                <th>
                    <?= nf($data['total_jual']) ?>
                </th>
            </tr>
            <tr>
                <td colspan="3" class="pt-2"></td>
            </tr>
            <tr>
                <th>
                    Total Pengeluaran
                </th>
                <td style="width: 20px"> : </td>
                <th class="text-danger">
                    <?= nf($data['total_beli']) ?>
                </th>
            </tr>            
            <tr>
                <th>
                    Total Penjualan
                </th>
                <td style="width: 20px"> : </td>
                <th class="text-primary">
                    <?= nf($data['total_jual']) ?>
                </th>
            </tr>            
            <tr>
                <th>
                    Total Pendapatan
                </th>
                <td style="width: 20px"> : </td>
                <th class="text-success">
                    <?= nf($data['total_jual'] - $data['total_beli']) ?>
                </th>
            </tr>            

        </table>
    </div>
</div>

<form method="post" class="modal fade" id="modal_tambah_brg">
    <div class="modal-dialog modal-dialog-scrollable modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Filter</h5>
                    <small class="text-muted">Filter bersadarkan tgl</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Mulai Tgl</label>
                        <input type="date" class="form-control form-control-sm" name="mulai" value="<?= $mulai ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Sampai Tgl </label>
                        <input type="date" class="form-control form-control-sm" name="selesai" value="<?= $selesai ?>">
                    </div>                    
                        
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="submit">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>
