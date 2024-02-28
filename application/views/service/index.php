<?php if($this->session->flashdata ('success')) : ?>

    <div class="alert alert-success">
         <?= $this->session->flashdata ('success') ?>
         <button class="close" data-dismiss="alert">&times;</button>
    </div>

<?php endif ?>

<div class="card pt-2">
    <div class="card-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="mb-0 text-primary">Data</h2>
            <small>Data Service</small>
        </div>

        <div>
            <a href="#modal_tambah_service" data-toggle="modal" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i>
                Tambah
            </a>
        </div>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="data_service">
                <thead>
                    <th>No</th>
                    <th>Service</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<form method="POST" class="modal fade" id="modal_tambah_service">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Service
                    </h5>
                    <small>Tambah service baru</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="float-left">
                            <h6 class="mb-0">
                                Nama Custumer
                                <span class="text-danger">*</span>
                            </h6>
                            <small class="text-muted">Isi dengan nama custumer</small>
                        </div>
                        <div class="float-right">
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="float-left">
                            <h6 class="mb-0">
                                No Ponsel
                                <span class="text-danger">*</span>
                            </h6>
                            <small class="text-muted">Pastikan no ponsel aktif</small>
                        </div>
                        <div class="float-right">
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="float-left">
                            <h6 class="mb-0">
                                Biaya Service
                            </h6>
                            <small class="text-muted">Pastikan no ponsel aktif</small>
                        </div>
                        <div class="float-right">
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="float-left">
                            <h6 class="mb-0">
                                DP 
                            </h6>
                            <small class="text-muted">Pastikan no ponsel aktif</small>
                        </div>
                        <div class="float-right">
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="float-left">
                            <h6 class="mb-0">
                                Teknisi 
                            </h6>
                            <small class="text-muted">Pastikan no ponsel aktif</small>
                        </div>
                        <div class="float-right">
                            <select class="form-control select2">
                                <option value="">Pilih Teknisi</option>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="float-left">
                            <h6 class="mb-0">
                                Deskripsi 
                            </h6>
                            <small class="text-muted">Tuliskan keluhan</small>
                        </div>
                        <div class="float-right">
                            <textarea class="form-control"></textarea>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-light" data-dismiss="modal">
                    Batal
                </a>
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>

<form action="" class="modal fade" id="modal_ubah_brg">
    <div class="modal-dialog modal-dialog-scrollable">
       <div class="modal-content">

       </div>
    </div>
</form>

<div class="modal fade" id="modal_detail_brg">
    <div class="modal-dialog modal-dialog-scrollable">
       <div class="modal-content">

       </div>
    </div>
</div>