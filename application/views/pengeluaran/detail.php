<?php 

$data   = $this->db->get_where('tb_pengeluaran', ['kode_pengeluaran' => $kode])->row();
$detail = $this->db->get_where('tb_pengeluaran_detail', ['kode_pengeluaran' => $kode])->result();

?>

<div class="table-responsive">
    <table class="table table-sm table-borderless">
        <tr>
            <td style="width: 100px">Kode</td>
            <td style="width: 10px">:</td>
            <th>
                <?= $kode ?>
            </th>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <th>
                <?= date('d/m/Y', strtotime($data->tgl)) ?>
            </th>
        </tr>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="bg-light">
            <th style="width: 50px">No</th>
            <th>Barang</th>
            <th>Harga</th>
        </thead>
        <tbody>
            <?php $total = 0; foreach($detail as $no => $item) : $total += $item->harga_modal; ?>
                <tr>
                    <td>
                        <?= ++$no ?>
                    </td>
                    <td>
                        <?= $item->nama_barang ?>
                    </td>
                    <td>
                        Rp<?= nf($item->harga_modal) ?>
                    </td>
                    
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th>Rp<?= nf($total) ?></th>
            </tr>
        </tfoot>
    </table>
</div>