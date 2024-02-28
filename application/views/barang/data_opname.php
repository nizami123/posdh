<?php 
    $uri = $this->uri->segment(3);
    if($uri != 'tambah') : 
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Opname</h5>
                    <small>Data Stok Opanme</small>
                </div>
                <a href="<?= site_url('inventaris/opname/tambah') ?>" class="btn btn-primary">
                    <i class="fa fa-plus mr-1"></i> 
                    Tambah
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_opname">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: ?>

<form method="post" class="row" id="submit_stok_opname">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-start pt-4">
                <div>
                    <h5 class="mb-0 text-primary">Opname</h5>
                    <small class="text-muted">Tambah Stok Opname</small>
                </div>
                <a href="<?= site_url('inventaris/opname') ?>" class="btn btn-secondary">Kembali</a>
            </div>
            <div class="card-body">
                <div class="card border note_opname">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <h5>Catatan</h5>
                        <a href="#note_opname_body" data-toggle="collapse" class="btn btn-secondary d_collps_opname">                           
                            <i class="fa fa-chevron-down"></i>                            
                        </a>
                    </div>
                    <div class="card-body collapse show" id="note_opname_body" style="position: relative">                        
                        <li> Pastikan semua data sudah benar sebelum disimpan. </li>
                        <li> Data opname yang sudah disimpan tidak dapat diubah kembali. </li>
                        <li> Jika stok fisik kosong, maka jumlahnya akan sama dengan jumlah stok sistem. </li>

                        <div class="card-icon d-flex">
                            <i class="fa fa-bullhorn"></i>
                        </div>
                    </div>
                </div>

                <div class="card border">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <h5>Informasi</h5>
                        <a href="#data_info_opname" data-toggle="collapse" class="btn btn-secondary d_collps_opname">                           
                            <i class="fa fa-chevron-down"></i>                            
                        </a>
                    </div>
                    <div class="card-body collpase show" id="data_info_opname" style="position: relative">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0 bg-transparent">
                                <tr>
                                    <th style="width: 120px">
                                        Tgl Opname
                                    </th>
                                    <th style="width: 20px"> : </th>
                                    <th> 
                                        <input type="date" class="form-control form-control-sm" name="tgl_opname" value="<?= date('Y-m-d') ?>" style="width: 200px">
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width: 120px">
                                        Kode
                                    </th>
                                    <th style="width: 20px"> : </th>
                                    <th> 
                                        <?= $kode ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width: 120px">
                                        Petugas
                                    </th>
                                    <th style="width: 20px"> : </th>
                                    <th> 
                                        <?= admin()->nama_admin ?>
                                    </th>
                                </tr>
                            </table>
                        </div>

                        <div class="card-icon d-flex">
                            <i class="fa fa-info"></i>
                        </div>
                    </div>
                </div>

                <div class="card border mb-0">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Stok</h5>
                            <small class="text-muted">Data stok opname</small>
                        </div>
                        <div class="text-right">
                            <span id="btn_submit_opname"></span>
                            
                            <a href="#modal_tambah_brg_opname" data-toggle="modal" class="btn btn-secondary btn_tambah_list_brg">
                                <i class="fa fa-search mr-1"></i> Cari Barang
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="text" id="scan_barcode" style="position:absolute;left:0;top:0;z-index:-1;opacity:0;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100" id="data_tambah_opname">
                                <thead class="text-center">
                                    <th style="width: 50px"></th>
                                    <th>Barang</th>
                                    <th style="width: 100px">
                                        Stok
                                        <br>
                                        <small>Sistem</small>
                                    </th>
                                    <th style="width: 100px">
                                        Stok
                                        <br>
                                        <small>Fisik</small>
                                    </th>
                                    <th style="width: 100px">
                                        Selisih
                                        <br>
                                        <small>Fisik - Sistem</small>
                                    </th>
                                    <th style="width: 200px">
                                        Keterangan
                                    </th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" class="modal fade" id="modal_tambah_brg_opname">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Data Barang Tersedia</small>
                </div>
                <button class="close" data-dismiss="modal">&times</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="list_brg">
                        <thead class="bg-light">
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
</form>

<?php endif ?>

<form method="post" class="modal fade" id="modal_detail_opname">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            
        </div>
    </div>
</form>
