<form method="post">
    <div>
        <label for="">SubMenu</label>
        <select name="menu">
            <?php 
                foreach ($data_menu as $submenu) :
            ?>
                <option value="<?= $submenu->id_menu ?>">
                    <?= $submenu->nama_menu ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    
    <div>
        <br>
        <label>Level</label>
        <br>

        <input type="checkbox" name="level[]" value="Owner" id="owner">
        <label for="owner">Owner</label>

        <input type="checkbox" name="level[]" value="Admin" id="admin">
        <label for="admin">Admin</label>
        
        <input type="checkbox" name="level[]" value="Kasir" id="kasir">
        <label for="kasir">Kasir</label>
        
        <input type="checkbox" name="level[]" value="Teknisi" id="teknisi">
        <label for="teknisi">Teknisi</label>
    </div>
    <br>
    <br>
    <div>
        <button name="submit">Submit</button>
    </div>
</form>