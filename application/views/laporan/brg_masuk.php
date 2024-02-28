<?php 
   $mulai   = $this->uri->segment(3);
   $selesai = $this->uri->segment(4);


?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Laporan</h5>
                    <small><?= $mulai ? 'Filter berdasarkan tgl' : 'Barang masuk bulan ini' ?></small>
                </div>
                <div>
                     <a href="#modal_tambah_brg" data-toggle="modal" class="btn btn-secondary">
                        <i class="fa fa-filter mr-1"></i> 
                    </a>
                    <?php if($data) : ?>
                    <a href="<?= site_url('laporan/cetak/brg_masuk/'.$mulai.'/'.$selesai) ?>" class="btn btn-primary cetak">
                        <i class="fa fa-print mr-1"></i> 
                        Cetak
                    </a>
                    <?php endif ?>
                </div>
            </div>
            <div class="card-body">
                <?php if($mulai) : ?>
                <div class="alert alert-light border mb-4">
                    Menampilkan laporan dari tgl <?= $mulai ?> s/d <?= $selesai ?>. &nbsp; <a href="<?= site_url('laporan/brg_masuk') ?>" class="alert-link">Tampilkan semua</a>
                </div>
                <?php endif ?>
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_lap">
                        <thead class="bg-light text-center">
                            <tr>
                                <th style="width:80px">No</th>
                                <th style="width:180px">Kode Transaksi</th>
                                <th>Nama Barang</th>
                                <th style="width:120px">Jml</th>
                                <th style="width:180px">Harga Beli</th>
                                <th style="width:180px">Subtotal</th>
                                <th style="width:200px">Supplier</th>
                                <th style="width:150px">Tgl Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data) : ?>
                                <?php foreach($data as $no => $item) : 
                                    $no++;
                                    $sup = $item->id_supplier ? $item->nama_supplier : ' - ';  
                                    $subtotal = $item->stok_masuk * $item->harga_beli;
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $no ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $item->kode_masuk ?>
                                    </td>
                                    <td>
                                        <?= $item->nama_brg ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $item->stok_masuk ?>
                                    </td>
                                    <td class="text-right">
                                        <?= nf($item->harga_beli) ?>
                                    </td>
                                    <td class="text-right">
                                        <?= nf($subtotal) ?>
                                    </td>
                                    <td>
                                        <?= $sup ?>
                                    </td>                                
                                    <td class="text-center">
                                        <?= date('d/m/Y', strtotime($item->tgl_masuk)) ?>
                                    </td>                                
                                </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <th colspan="7" class="text-center">
                                        Tidak ada data
                                    </th>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
