<form method="POST" class="row" id="cart_form">
    <div class="col-md-9">
        <div class="card pt-2">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h6 class="mb-0 text-primary">
                        <strong id="kode_tr">-</strong>
                    </h6>
                    <small>
                        <span>Hari ini: <?= date('d M Y') ?> </span>
                    </small>
                </div>
                <div class="d-flex align-items-start">
                    <input style="position:absolute;left:0;top:0;z-index:-1;opacity:0;" id="scan_barcode" placeholder="Scan Kode Barang">
                    <input type="text" class="form-control form-control-sm mr-2" id="src_kode_brg" placeholder="Kode Barang">
                    <a href="#modal_data_brg" data-toggle="modal" class="btn btn-light src_brg border">
                        <i class="fa fa-search"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="data_keranjang">
                        <thead class="bg-light text-center">
                            <th colspan="2">Item</th>
                            <th style="width: 130px">Jml</th>
                            <th style="width: 150px">Subharga</th>
                        </thead>
                        <tbody>
                            <?php  
                                $c = count(data_keranjang()); 
                                if($c > 0) :
                                    for($i = 1; $i <= $c; $i++) :
                            ?>                            
                                        <tr>
                                            <td style="width: 50px">
                                                <div class="load_card_1"></div>
                                            </td>
                                            <td>
                                                <div class="load_card_2">
                                                    <div class="_label"></div>
                                                    <div class="_nama"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="load_card_3"></div>
                                            </td>
                                            <td>
                                                <div class="load_card_3"></div>
                                            </td>
                                        </tr>
                                        
                                    <?php endfor; ?>
                                <?php else: ?>
                                    <tr>
                                        <th colspan="4">
                                            <div class="p-5 text-center load_card">
                                                <div class="_icon"></div>
                                                <div class="_text"></div>
                                            </div>
                                        </th>
                                    </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <small>
                        <strong>Tombol Aksi</strong>
                    </small>
                    <div class="mt-1">
                        <a href="" class="badge badge-danger empty_cart">
                            Kosongkan Keranjang
                        </a>
                                                
                        <?php if(admin()->level == 'Owner') : ?>
                            <span class="mx-2"> | </span>
                            <a href="#modal_data_toko" data-toggle="modal" class="badge badge-light border">
                                <i class="fa fa-store mr-1"></i> Pindah Toko
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-2">
            <div class="card-body">
                <p class="mb-1">Total Keranjang</p>
                <h4 class="text-danger total_cart">0</h4>
                <input type="hidden" name="status" id="status" value="<?= isset($_GET['status']) ? $_GET['status'] : '' ?>">
                <input type="hidden" class="total_cart_inp" value="0" name="total_keranjang">
                <div class="card-icon d-flex">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <p class="mb-1">Kembalian</p>
                <h4 class="text-warning total_kembalian">0</h4>
                <input type="hidden" class="total_kembalian_inp" name="total_kembalian" value="0">
                <div class="card-icon d-flex">
                    <i class="fa fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body form_pembayaran">
            
                <div class="form-group">
                    <label> Pelanggan </label>
                    <input disabled class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label> Kasir </label>
                    <input disabled class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Diskon</label>
                    <input disabled class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Bayar</label>
                    <input disabled class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label> Bank </label>
                    <input disabled class="form-control form-control-sm">
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary w-100" disabled>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modal_data_brg">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Barang
                    </h5>
                    <small>Data Barang</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_brg">
                        <thead class="bg-light">
                            <th></th>
                            <th>Barang</th>
                            <th>Harga</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_data_plg">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Pelanggan
                    </h5>
                    <small>Data pelanggan</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_plg">
                        <thead class="bg-light">
                            <th></th>
                            <th>Pelanggan</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_data_ksr">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Kasir
                    </h5>
                    <small>Data Kasir</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_ksr">
                        <thead class="bg-light">
                            <th></th>
                            <th>Kasir</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_data_trade">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Trade
                    </h5>
                    <small>Data Trade</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_trade">
                        <thead class="bg-light">
                            <th></th>
                            <th>Trade</th>
                            <th>Harga</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_data_diskon">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Diskon
                    </h5>
                    <small>Data Diskon</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_diskon">
                        <thead class="bg-light">
                            <th></th>
                            <th>Diskon</th>
                            <th>Nominal</th>
                            <th>Nilai</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_data_bank">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Bank
                    </h5>
                    <small>Data Bank</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_bank">
                        <thead class="bg-light">
                            <th></th>
                            <th>Bank</th>
                            <th>No Rekening</th>
                            <th>Nama Rekening</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_data_toko">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Toko
                    </h5>
                    <small>Data Toko</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_toko">
                        <thead class="bg-light">
                            <th></th>
                            <th>Toko</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_info">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Info
                    </h5>
                    <small>Info & Tutorial</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush dashed mb-3">
                    <li class="list-group-item py-3 bg-light">
                        <h6 class="mb-0">
                            <i class="fa fa-info-circle mr-1"></i>
                            <strong>Input barang ke keranjang</strong>
                        </h6>
                    </li>
                    <li class="list-group-item py-3">
                        <h6 class="mb-1">
                            <strong>Klik Icon</strong> 
                            <button class="badge badge-light border">
                                <i class="fa fa-search mx-1"></i>
                            </button>
                        </h6> 
                        <p class="mb-0">
                            Cara pertama adalah dengan klik icon cari. Setelah icon diklik, maka akan tampil data stok barang yang tersedia, kemudian klik icon <button class="badge badge-light border"><i class="fa fa-cart-plus mx-1"></i></button> untuk menambahkan barang ke keranjang. 
                        </p>                                    
                    </li>
                    <li class="list-group-item py-3">
                        <h6 class="mb-1">
                            <strong>
                                Input kode barang
                            </strong>
                        </h6>
                        <p class="mb-0">
                            Cara kedua dengan mengetikan kode barang pada inputan. Jika kode barang tersedia atau stok barang tidak kosong, maka barang akan masuk ke kerajang.
                        </p>
                    </li>
                    <li class="list-group-item py-3">
                        <h6 class="mb-1">
                            <strong>
                                Scan Barcode
                            </strong>
                        </h6>
                        <p class="mb-0">
                            Cara ketiga scan barcode dengan scanner. Arahkan scanner ke barcode hingga bunyi beep atau lampu indikator pada scanner menyala. Jika barang belum masuk ke keranjang, arahkan kembali barcode ke scanner. 
                        </p>
                    </li>
                </ul>
                
                <div class="table-responsive" id="info_tombol_aksi">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <th style="width: 130px;" class="text-center">Tombol</th>
                            <th>Fungsi</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <button class="badge badge-danger">
                                        Kosongkan keranjang
                                    </button>
                                </td>
                                <td>
                                    Menghapus semua item yang ada dikeranjang
                                </td>
                            </tr>
                            <?php if(admin()->level == 'Owner') : ?>
                            <tr>
                                <td class="text-center">
                                    <button class="badge badge-light border">
                                        <i class="fa fa-store mr-1"></i> 
                                        Pindah Toko
                                    </button>
                                </td>
                                <td>
                                    Pindah dari satu toko ke toko yang lain
                                </td>
                            </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <ul class="list-group list-group-flush dashed mb-3">
                    <li class="list-group-item py-3 bg-light">
                        <h6 class="mb-0">
                            <i class="fa fa-info-circle mr-1"></i>
                            <strong>Pelanggan</strong>
                        </h6>
                    </li>
                    <li class="list-group-item py-3">
                        <p class="mb-0">
                            Klik icon <span class="badge border"><i class="fa fa-search"></i></span> untuk mencari pelanggan yang sudah terdaftar pada aplikasi, kemudian Klik icon <span class="badge border"><i class="fa fa-user-plus"></i></span> untuk menambahkan pelanggan. Dan untuk mereset pelanggan ke pelanggan umum, klik pada form input pelanggan.  
                        </p>                                    
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>