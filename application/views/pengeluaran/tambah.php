
<form method="POST" class="card" id="submit_tambah">    
    <div class="card-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="mb-0 text-primary">Pengeluaran</h2>
            <small>Tambah</small>
        </div>
        <div>
            <a href="javascript:new_data()" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100 datatables" id="tb_form_add_brgm">
                <thead class="text-center">
                    <th> </th>
                    <th>Barang  <span class="text-danger">*</span></th>
                    <th style="width: 150px;">Harga <span class="text-danger">*</span></th>
                </thead>
                <tbody class="add_kluar_body">
                    <tr>
                        <td style="width: 20px" class="text-center">
                            <a href="javascript:void(0)" class="btn btn-danger disabled">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                        <td>
                            <select class="select2" style="width: 300px" name="nama[]" required>
                                <option value="">Pilih</option>
                                
                                <?php 
                                    $get = $this->db->get('tb_pengeluaran_item')->result();
                                    foreach($get as $item) {
                                        echo '
                                            <option>'.$item->nama.'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control harga" name="harga[]" required>
                        </td>
                    </tr>
                </tbody>
                <tfoot class="tfoot-keluar">
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th class="text-right total_keluar">0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <div class="d-flex justify-content-end">
            <a href="<?= site_url('pengeluaran/') ?>" class="btn btn-light mr-2">
                Kembali
            </a>
            <button class="btn btn-primary">
                Simpan
            </button>
        </div>
    </div> 
</form>
