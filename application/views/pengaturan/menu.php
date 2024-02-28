<div class="row">
    <div class="col-md-4">
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
            <?php 
                $uri3 = $this->uri->segment(3);
                $uri4 = $this->uri->segment(4);
                $uri5 = $this->uri->segment(5);

                if($uri3 != 'ubah') : 

            ?>

            <div class="card-body">
                <div class="alert alert-light border">
                    <label for="">Jenis Menu</label>
                    <?php 
                        $data_jenis = ['Utama', 'Sub'];
                        foreach($data_jenis as $i => $jenis) : 
                            if(array_key_first($data_jenis) == $i) :
                                
                    ?>
                            <div class="custom-control custom-radio mb-1">
                                <input type="radio" 
                                    name="jenis" id="<?= $jenis ?>" 
                                    value="<?= $jenis ?>" 
                                    class="custom-control-input"
                                    checked
                                >
                                <label for="<?= $jenis ?>" 
                                    class="custom-control-label"
                                >
                                    <?= $jenis ?>
                                </label>
                            </div>

                        <?php else: ?>

                            <div class="custom-control custom-radio mb-1">
                                <input type="radio" 
                                    name="jenis" id="<?= $jenis ?>" 
                                    value="<?= $jenis ?>" 
                                    class="custom-control-input"
                                    
                                >
                                <label for="<?= $jenis ?>" 
                                    class="custom-control-label"
                                >
                                    <?= $jenis ?>
                                </label>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
                <div class="form-group menu_utama">
                    <label for="">Icon Menu</label>
                    <input type="text" class="form-control form-control-sm" name="icon_menu" value="">
                </div>
                <div class="form-group">
                    <label for="">Nama Menu</label>
                    <input type="text" class="form-control form-control-sm" name="nama_menu" value="" required>
                </div>
                <div class="form-group">
                    <label for="">Slug</label>
                    <input type="text" class="form-control form-control-sm" name="slug" value="" >
                </div>
                <div class="form-group d-none submenu">
                    <label for="">Menu Utama</label>
                    <select class="form-control form-control-sm select2" name="menu_utama">
                        <?php foreach($data as $item) : ?>
                            <option value="<?= $item->id_menu ?>"><?= $item->nama_menu ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary w-100" name="submit">
                    Simpan
                </button>
            </div>

            <?php 
                else: 
                    if($uri4 == 'sub') {
                        $get   = $this->conf->submenu($uri5);
                        $nama  = $get->nama_submenu;
                        $slug  = $get->slug_submenu;
                        $utama = $get->id_menu;
                        
                    } else {
                        $get   = $this->conf->menu($uri5);
                        $nama  = $get->nama_menu;
                        $slug  = $get->slug;
                        $icon  = $get->icon;

                    }

            ?>

            <div class="card-body">
                <input type="hidden" name="id_menu" value="<?= $uri5 ?>">
                <input type="hidden" name="jenis" value="<?= $uri4 ?>">
                <?php if($uri4 == 'utama') : ?>
                <div class="form-group">
                    <label for="">Icon Menu</label>
                    <input type="text" class="form-control form-control-sm" name="icon_menu" value="<?= $icon ?>">
                </div>
                <?php endif ?>
                <div class="form-group">
                    <label for="">Nama Menu</label>
                    <input type="text" class="form-control form-control-sm" name="nama_menu" value="<?= $nama ?>" required>
                </div>
                <div class="form-group">
                    <label for="">Slug</label>
                    <input type="text" class="form-control form-control-sm" name="slug" value="<?= $slug ?>" >
                </div>
                <?php if($uri4 == 'sub') : ?>
                <div class="form-group">
                    <label for="">Menu Utama</label>
                    <select class="form-control form-control-sm select2" name="menu_utama">
                        <?php 
                            foreach($data as $item) : 
                                if($item->id_menu == $utama) :   
                        ?>
                                <option value="<?= $item->id_menu ?>" selected><?= $item->nama_menu ?></option>
                            
                                <?php endif ?>

                                <option value="<?= $item->id_menu ?>"><?= $item->nama_menu ?></option>

                        <?php endforeach ?>
                    </select>
                </div>
                <?php endif ?>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary w-100" name="simpan">
                    Simpan
                </button>
                <a href="<?= site_url('pengaturan/menu') ?>" class="btn d-block mt-2" >
                    Batal
                </a>
            </div>
            <?php endif ?>
        </form>
    </div>

    <div class="col-md-8">
        <?php if($this->session->flashdata('hapus')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('hapus') ?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif ?>
        <div class="card">
            <div class="card-header">
                <h5>Data Menu</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach($data as $menu) : ?>
                    <li class="list-group-item">
                        <span class="float-left">
                            <i class="fa <?= $menu->icon ?> mr-2"></i>
                            <?= $menu->nama_menu ?>
                            <small class="smallest ml-1">
                                <?= $menu->slug ?>
                            </small>
                        </span>
                        <span class="float-right">
                            <a href="<?= site_url('pengaturan/menu/ubah/utama/'.$menu->id_menu) ?>" class="badge badge-primary">Ubah</a>
                            <a href="<?= site_url('pengaturan/hps_menu/'.$menu->id_menu) ?>" class="badge badge-danger">Hapus</a>
                        </span>

                        <div class="clearfix"></div>
                        
                        <?php  
                            $data_submenu = $this->conf->data_submenu($menu->id_menu)->result();
                            if($data_submenu) :                               
                        ?>
                        <ul class="list-group mt-3 mb-2 light dashed">
                            <?php  foreach($data_submenu as $submenu) : ?>
                            <li class="list-group-item">
                                <span class="float-left">
                                    <?= $submenu->nama_submenu ?> 
                                    <small class="smallest ml-1">
                                        <?= $submenu->slug_submenu ?>
                                    </small>
                                </span>
                                <span class="float-right">
                                    <a href="<?= site_url('pengaturan/menu/ubah/sub/'.$submenu->id_submenu) ?>" class="badge badge-primary">Ubah</a>
                                    <a href="<?= site_url('pengaturan/hps_sub/'.$submenu->id_submenu) ?>" class="badge badge-danger">Hapus</a>
                                </span>
                            </li>
                            <?php endforeach ?>
                        </ul>
                        <?php endif ?>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>