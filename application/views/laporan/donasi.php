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
                    <small><?= $mulai ? 'Filter berdasarkan tgl' : 'Donasi' ?></small>
                </div>
                <div>
                    <a href="#modal_tambah_brg" data-toggle="modal" class="btn btn-secondary">
                        <i class="fa fa-filter mr-1"></i> 
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if($mulai) : ?>
                <div class="alert alert-light border mb-4">
                    Menampilkan laporan dari tgl <?= $mulai ?> s/d <?= $selesai ?>. &nbsp; <a href="<?= site_url('laporan/donasi') ?>" class="alert-link">Tampilkan semua</a>
                </div>
                <?php endif ?>
                <div class="table-responsive">
                    <input type="hidden" name="get_mulai"  id="get_mulai" value="<?= $this->uri->segment(3) ?>">
                    <input type="hidden" name="get_selesai" id="get_selesai"  value="<?= $this->uri->segment(4) ?>">

                    <table class="table table-bordered w-100" id="data_lap_terlaris">
                        <thead class="bg-light">
                            <tr>
                                <th style="width:80px" class="text-center">No</th>
                                <th style="width:150px">Invoice</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $total = 0;
                                foreach($data as $i => $item) {
                                    $i++;
                                   $total += $item->jml;
                                    echo '
                                        <tr>
                                            <td class="text-center">'.$i.'</td>
                                            <td>'.$item->invoice.'</td>
                                            <td>'.date('d/m/Y', strtotime($item->tgl_donasi)).'</td>
                                            <td>'.nf($item->jml).'</td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                        <?php if($data) : ?>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="text-right">Total</th>
                                <th><?= nf($total) ?></th>
                            </tr>
                        <?php endif ?>
                        </tfoot>
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
            <?php 
                if(isset($_POST['submit'])) {
                    $tglm = $_POST['mulai'];
                    $tgls = $_POST['selesai'];

                    redirect('laporan/donasi/'.$tglm.'/'.$tgls);
                }
            ?>
        </div>
    </div>
</form>

<div class="modal fade" id="modal_detail">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            
        </div>
    </div>
</div>
