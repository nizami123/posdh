<?php 
    if(admin ()->level != 'Kasir' ) :
        $uri3 = $this->uri->segment (3);
        if($this->session->flashdata ('success_up')) : 
?>
            <div class="alert alert-success">
                <?= $this->session->flashdata ('success_up') ?>
                <button class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif ?>

        <?php if($this->session->flashdata ('success_add')) : ?>

            <div class="alert alert-success">
                <?= $this->session->flashdata ('success_add') ?>
                <button class="close" data-dismiss="alert">&times;</button>
            </div>

        <?php endif ?>

        <?php if($jml_stok_0) : ?>

            <a href="<?= site_url('inventaris/index/stok-0') ?>#data_brg" class="alert alert-danger d-block text-white text-decoration-none" title="klik untuk melihat daftar stok barang">
                Ditemukan <span class="badge badge-light text-danger mx-1"><?= $jml_stok_0 ?></span> stok barang <strong>kosong</strong>    
            </a>

        <?php endif ?>

        <?php if($jml_hampir_0) : ?>

            <a href="<?= site_url('inventaris/index/hampir-0') ?>#data_brg" class="alert alert-warning d-block text-white text-decoration-none" title="klik untuk melihat daftar stok barang">
                Ditemukan <span class="badge badge-light text-warning mx-1"><?= $jml_hampir_0 ?></span> stok barang <strong>hampir habis</strong>    
            </a>

        <?php endif ?>

        <?php 
            if(count(cek_exp()) > 0) : 
        ?>

            <a href="<?= site_url('inventaris/index/stok-exp') ?>#data_brg" class="alert alert-danger d-block text-white text-decoration-none">
                Ditemukan <span class="badge badge-light text-danger mx-1"><?= count(cek_exp()) ?></span> barang <strong>Kadaluarsa</strong>    
            </a>

        <?php endif ?>

<?php endif ?>

<?php if (admin()->level != 'Kasir') :  ?>
    <div class="card mb-3">
        <div class="card-body py-3">
            <h6>
                <strong>
                    Tombol Aksi
                </strong>
            </h6>
            <a href="<?= site_url('excel/export/' . $uri3) ?>" class="btn btn-danger">
                <i class="fa fa-download mr-1"></i>
                Export
            </a>
            <a href="<?= site_url('excel/import') ?>" class="btn btn-success">
                <i class="fa fa-upload mr-1"></i>
                Import
            </a>
            <a href="#modal_tambah_brg" data-toggle="modal" class="btn btn-primary" title="Tambah stok barang">
                <i class="fa fa-plus"></i>
            </a>
            <a href="<?= site_url('inventaris/print_barcode_brg') ?>" target="__blank" class="btn btn-info" title="cetak barcode">
                <i class="fa fa-qrcode"></i>
            </a>            
            <a href="#modal_info" data-toggle="modal" class="btn btn-light dashed">
                <i class="fa fa-info-circle mr-1"></i> Info & Tutorial
            </a>
        </div>
    </div>
<?php endif ?>
<div class="card pt-3">
    <div class="card-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="mb-0 text-primary">Data</h2>
            <small>Data stok barang</small>
        </div>

        <?php if (admin()->level != 'Kasir') :  ?>
            <div>
                <select id="filter_stok" class="form-control">
                    <option value="">Filter Barang</option>
                    <?php 
                        $data_filter = [
                            'stok-0'    => 'Stok Kosong',
                            'hampir-0'  => 'Hampir Habis',
                            'stok-exp'  => 'Barang Kadaluarsa',
                        ];

                        foreach ($data_filter as $k => $filter) :
                            if($this->uri->segment (3) == $k) :
                    ?>

                            <option value="<?= $k ?>" selected>
                                <?= $filter ?>
                            </option>
                    
                        <?php else: ?>

                            <option value="<?= $k ?>">
                                <?= $filter ?>
                            </option>

                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
        <?php endif ?>
        
    </div>
    <div class="card-body">
        <?php if($this->uri->segment (3)) : ?>
        <div class="alert alert-secondary mb-4">
            Menampilkan stok berdasarkan filter &nbsp; <a href="<?= site_url($this->uri->segment (1) . '/') ?>#data_brg" class="badge badge-light">Tampilkan semua</a> 
        </div>
        <?php endif ?>
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="data_brg">
                <thead class="bg-light">
                    <!-- <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th></th>
                    </tr> -->
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<form method="POST" class="modal fade" id="modal_tambah_brg">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Barang
                    </h5>
                    <small>Tambah stok barang baru</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="">Kode Barang</label>
                        <input type="text" class="form-control form-control-sm" name="kode_brg" value="">
                        <small class="text-muted">Kode barang akan diisi otomtis jika kosong</small>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="nama_brg" value="" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="">Stok</label>
                        <input type="number" class="form-control form-control-sm text-center" name="stok_brg" value="">
                    </div>
                    <div class="form-group col-sm-8">
                        <label for="">Satuan</label>
                        <select class="form-control form-control-sm select2" name="satuan_brg" >
                            <option value="">Pilih Satuan</option>
                            <?php foreach($data_satuan as $satuan) : ?>
                                <option>
                                    <?= $satuan->nama_satuan ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>                    
                    <div class="form-group col-sm-12">
                        <label for="">Harga (Modal) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="harga_modal" value="" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Harga (Eceran) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="harga_eceran" value="" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Tgl Kadaluarsa</label>
                        <input type="date" class="form-control form-control-sm" name="tgl_exp" value="" >
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Kategori</label>
                        <select class="form-control form-control-sm select2" name="kategori_brg">
                            <option value="">Pilih Kategori</option>
                            <?php foreach($data_kategori as $kategori) : ?>
                                <option value="<?= $kategori->id_kategori ?>">
                                    <?= $kategori->nama_kategori ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Supplier</label>
                        <select class="form-control form-control-sm select2" name="supplier_brg">
                            <option value="">Pilih Supplier</option>
                            <?php foreach($data_supplier as $supplier) : ?>
                                <option value="<?= $supplier->id_supplier ?>">
                                    <?= $supplier->nama_supplier ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Rak / Etalase</label>
                        <input type="text" class="form-control form-control-sm" name="etalase" value="" >
                    </div>
                    <div class="form-group col-md-12">
                        <div class="d-flex justify-content-between">
                            <label>
                                Retur Barang
                                <br>
                                <small class="text-muted">Aktifkan jika item ini bisa dikembalikan</small>
                            </label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" id="sw_retur" name="is_retur" class="custom-control-input" value="0">
                                <label for="sw_retur" class="custom-control-label">
                                    <small id="sw_retur_text">Nonaktif</small>
                                </label>
                            </div>                            
                        </div>
                    </div>  
                    <div class="form-group col-md-12 mt-2">
                        <div class="d-flex justify-content-between">
                            <label>
                                Penjualan Grosir
                                <br>
                                <small class="text-muted">Aktifkan jika item ini mendukung penjualan grosir</small>
                            </label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" id="sw_grosir" name="is_grosir" class="custom-control-input" value="0">
                                <label for="sw_grosir" class="custom-control-label">
                                    <small id="sw_grosir_text">Nonaktif</small>
                                </label>
                            </div>                            
                        </div>
                        <div class="form_inp_grosir row mt-3"></div>
                    </div>  
                </div>
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

<div class="modal fade" id="modal_info">
    <div class="modal-dialog modal-dialog-scrollable">
       <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Barang
                    </h5>
                    <small>Info & tutorial</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card mb-3 dashed" id="info_stok_brg">
                    <div class="card-body py-3">
                        <strong class="mb-1">
                            Info stok barang:
                        </strong>
                        <p class="mb-0 mt-1">
                            Stok barang yang ditandai <strong class="text-danger">warna merah</strong> adalah stok yang sudah habis, sedangkan stok barang yang ditandai <strong class="text-warning">warna kuning</strong> adalah stok barang yang sudah mencapai batas stok minimum
                        </p>
                    </div>
                </div>

                <div class="table-responsive" id="info_tombol_aksi">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <th style="width: 130px;" class="text-center">Tombol</th>
                            <th>Fungsi</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <button class="btn btn-danger">
                                        <i class="fa fa-download mr-1"></i>
                                        Export
                                    </button>
                                </td>
                                <td>
                                    Export data barang dalam bentuk excel
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <button class="btn btn-success">
                                        <i class="fa fa-upload mr-1"></i>
                                        Import
                                    </button>
                                </td>
                                <td>
                                    Import data barang dengan format excel
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td>
                                    Tambah stok barang
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <button class="btn btn-info">
                                        <i class="fa fa-qrcode"></i>
                                    </button>
                                </td>
                                <td>
                                    Cetak semua barcode barang
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card mb-3 dashed" id="filter_stok_brg">
                    <div class="card-body py-3">
                        <strong class="mb-1">
                            Filter Barang
                        </strong>
                        <p class="mb-0 mt-1">
                            Filter barang ada 3 pilihan, <strong>Stok kosong, Hampir habis, dan barang kadaluarsa</strong>. Data akan ditampilkan sesuai dengan filter yang dipilih
                        </p>
                    </div>
                </div>

                <?php if (admin()->level == 'Owner') :  ?>
                <div class="card mb-3 dashed" id="tutor_atur_stok_minimum">
                    <div class="card-body py-3">
                        <strong>
                            Mengatur stok minimum
                        </strong>
                        <p class="mb-0 mt-1">
                            Untuk mengatur batas stok minimum, anda bisa mengakses halaman <strong><a href="<?= site_url('pengaturan/tambahan') ?>" class="text-dark">Pengaturan > Tambahan</a></strong> 
                        </p>
                    </div>
                </div>
                <?php endif ?>

                <div class="card mb-3 dashed" id="tutor_cetak_per_brg">
                    <div class="card-body py-3">
                        <strong>Cetak Barcode per barang</strong>
                        <ol class="m-0 px-3 pb-0 pt-2">
                            <li>Klik <span class="badge badge-secondary">Detail</span></li>
                            <li>Selanjutnya akan tampil detail barang, kemudian Klik pada kode barang atau gambar barcode</li>
                            <li>Setelah itu akan tampil inputan jumlah barcode yang ingin dicetak</li>
                            <li>Klik <span class="badge badge-dark"><i class="fa fa-print"></i></span> untuk mulai mencetak</li>
                        </ol>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>