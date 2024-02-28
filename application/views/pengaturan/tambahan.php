<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>

        <?php if($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>
        
        <form method="post" class="card">
            <div class="card-body">
                <ul class="list-group mt-3">
                    <li class="list-group-item">
                        <label classs="float-left">
                            Barang Kadaluarsa 
                            <br>
                            <small class="text-muted">Atur waktu barang kadaluarsa</small>
                        </label>
                        <div class="float-right">
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control form-control-sm text-center" style="width: 75px" value="<?= conf()->expired ?>" name="expired" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        Hari
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <label classs="float-left">
                            Batas Minimum 
                            <br>
                            <small class="text-muted">Atur Batas minimum stok barang</small>
                        </label>
                        <div class="float-right">
                            <input type="number" class="form-control form-control-sm text-center" min="0" style="width: 120px" value="<?= conf()->jml_min_brg ?>" name="jml_min" >
                        </div>
                    </li> 
                    <li class="list-group-item">
                        <label classs="float-left">
                            Kertas Termal
                            <br>
                            <small class="text-muted">Atur ukuran kertas termal</small>
                        </label>
                        <div class="float-right">
                            <select class="form-control form-control-sm select2" style="width: 120px" name="ukuran_kertas" >
                                <?php 
                                    $data_termal = [
                                        '52' => '52mm',
                                        '58' => '58mm',
                                        '74' => '74mm',
                                    ];

                                    foreach($data_termal as $code => $termal) :
                                        if($code == conf()->ukuran_kertas) :
                                ?>

                                            <option value="<?= $code ?>" selected>
                                                <?= $termal ?>
                                            </option>
                                        
                                        <?php else: ?>

                                            <option value="<?= $code ?>">
                                                <?= $termal ?>
                                            </option>

                                        <?php endif ?>
                                    <?php endforeach ?>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <label classs="float-left">
                            Jenis Kertas Barcode
                            <br>
                            <small class="text-muted">Atur jenis kertas saat cetak barcode</small>
                        </label>
                        <div class="float-right">
                            <select class="form-control form-control-sm select2" style="width: 120px" name="jenis_kertas" >
                                <?php 
                                    $data_cetak = ['Termal',  'HVS'];

                                    foreach($data_cetak as $cetak) :
                                        if($cetak == conf()->jenis_kertas) :
                                ?>

                                            <option value="<?= $cetak ?>" selected>
                                                <?= $cetak ?>
                                            </option>
                                        
                                        <?php else: ?>

                                            <option value="<?= $cetak ?>">
                                                <?= $cetak ?>
                                            </option>

                                        <?php endif ?>
                                    <?php endforeach ?>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <label classs="float-left">
                            Jenis Kertas Struk
                            <br>
                            <small class="text-muted">Atur jenis kertas saat cetak struk</small>
                        </label>
                        <div class="float-right">
                            <select class="form-control form-control-sm select2" style="width: 120px" name="jenis_kertas_struk" >
                                <?php 
                                    $data_cetak_struk = ['Termal',  'HVS'];

                                    foreach($data_cetak_struk as $cetak) :
                                        if($cetak == conf()->jenis_kertas_struk) :
                                ?>

                                            <option value="<?= $cetak ?>" selected>
                                                <?= $cetak ?>
                                            </option>
                                        
                                        <?php else: ?>

                                            <option value="<?= $cetak ?>">
                                                <?= $cetak ?>
                                            </option>

                                        <?php endif ?>
                                    <?php endforeach ?>
                            </select>
                        </div>
                    </li>                                       
                </ul>
                
            </div>
            <div class="card-footer pb-4">
                <button class="btn btn-primary" name="simpan">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>