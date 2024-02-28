<div class="row">
    <div class="col-sm-12">
        <?php 
            $uri = $this->uri->segment(3);
            if($uri != 'tambah') : 
        ?>
        <div class="card">
            <div class="card-header pt-4 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-0 text-primary">Retur</h5>
                    <small>Penjualan</small>
                </div>
                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="data_retur">
                        <thead class="bg-light">
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
        <?php else: ?>
        
        <form method="post" id="form_tambah_retur" class="card">            
            <div class="card-header pt-4 d-flex justify-content-between align-items-start" >
                <div>
                    <h5 class="mb-0 text-primary">
                        Retur
                    </h5>
                    <small>
                        Tambah Retur Penjualan
                    </small>
                </div>
                <div>
                    <a href="<?= site_url('penjualan/riwayat') ?>" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>
            <?php if($data_riwayat) : ?>
            <div class="card-body">
                <div class="alert alert-light border mb-4">
                    <i class="fa fa-bullhorn mr-2"></i> 
                    Centang barang yang akan diretur
                </div>
                <div class="table-responsive">
                    <input type="hidden" 
                           name="kode"
                           value="<?= $this->uri->segment(4) ?>" 
                    >
                    <table class="table table-bordered w-100" id="data_tambah_retur">
                        <thead class="bg-light text-center">
                            <tr>
                                <th style="width:50px;">
                                    
                                </th>
                                <th class="text-left">Item</th>
                                <th style="width:100px;">Jml</th>
                                <th style="width:200px;">Jenis Retur</th>
                                <th style="width:250px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data_riwayat as $i => $riwayat) : 
                                    $harga = $riwayat->harga_jual; 
                                    if($riwayat->is_retur > 0) :
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">                                            
                                            <input type="hidden" 
                                                   value="<?= $harga ?>" 
                                                   name="harga[<?= $riwayat->id_penjualan ?>]"
                                            >
                                            <input type="checkbox" 
                                                   class="custom-control-input" 
                                                   name="check[]" 
                                                   id="label_<?= $i ?>" 
                                                   value="<?= $riwayat->id_penjualan ?>"  
                                            >
                                            <label for="label_<?= $i ?>" class="custom-control-label mr-n2"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>
                                            <?= $riwayat->nama_brg ?>
                                        </strong>

                                        <input type="hidden" 
                                               name="kode_brg[<?= $riwayat->id_penjualan ?>]" 
                                               value="<?= $riwayat->kode_brg ?>"
                                        >                                    

                                    </td>
                                    <td>
                                        <select name="jml[<?= $riwayat->id_penjualan ?>]" 
                                                class="form-control form-control-sm select2" 
                                        >
                                            <?php for($i = 1; $i <= $riwayat->jml; $i++) : ?>
                                                <option>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="jenis_retur[<?= $riwayat->id_penjualan ?>]" 
                                                class="form-control form-control-sm select2" 
                                        >
                                            <option value="ganti">
                                                Ganti Baru
                                            </option>
                                            <option value="refund">
                                                Uang Kembali
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" 
                                               class="form-control" 
                                               name="ket[<?= $riwayat->id_penjualan ?>]"
                                        >
                                    </td>
                                </tr>
                                
                                <?php else: ?>

                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">                                            
                                            <input type="checkbox" 
                                                    class="custom-control-input" 
                                                    disabled
                                            >
                                            <label for="label_<?= $i ?>" class="custom-control-label mr-n2"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $riwayat->nama_brg ?>

                                        <input type="hidden" 
                                                name="kode_brg[<?= $riwayat->id_penjualan ?>]" 
                                                value="<?= $riwayat->kode_brg ?>"
                                        >

                                        <div>
                                            <small>
                                                <strong class="text-danger">Tidak bisa ditembalikan</strong>
                                            </small>
                                        </div>

                                    </td>
                                    <td>
                                       <input type="text" 
                                                class="form-control" 
                                                disabled
                                        >
                                    </td>
                                    <td>
                                        <input type="text" 
                                                class="form-control" 
                                                disabled
                                        >
                                    </td>
                                    <td>
                                        <input type="text" 
                                                class="form-control" 
                                                disabled
                                        >
                                    </td>
                                </tr>

                            <?php endif ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end pb-4">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
            <?php else: ?>
                <div class="card-body">
                    <div class="alert alert-light border text-center">
                        Tidak ada data yang ditampilkan
                    </div>
                </div>
            <?php endif ?>
        </form>
                                        
        <?php endif ?>
    </div>
</div>
