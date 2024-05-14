<div class="modal-header">
    <h5 class="modal-title" id="saldoModalLabel">Input Retur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="post" action="<?php echo site_url('penjualan/retur'); ?>">
    <div class="modal-body">
        <div class="form-group">
            <label for="saldoInput">Saldo:</label>
            <input type="text" value="<?=$id_keluar?>" name="kode">
            <input type="number" class="form-control" id="saldoInput" name="retur" placeholder="Masukkan Jumlah Retur">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>