<?php 
    $uri1 = $this->uri->segment (1);
    $uri2 = $this->uri->segment (2);
    $uri3 = $this->uri->segment (3);

    $level = admin()->level;
    $data_submenu = submenu($level, $uri1);

    $collps_menu = $uri1 == 'excel' && $uri2 == 'import' || $uri1 == 'penjualan' || $uri1 == 'laporan' || $uri1 == 'akun' || $uri1 == 'inventaris' && $uri3 == 'tambah' ? 'collps-menu' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tag -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title><?= $tabTitle ?></title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('upload/'.conf()->logo) ?>" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/font/fa/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/select2/css/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/mod.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/media.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/animasi.css">

    <style>
        .wp-15 {
            width: 15% !important;
        }
        .wp-10 {
            width: 10% !important;
        }
        .wp-85 {
            width: 85% !important;
        }
        .wc-50 {
            width: 50px !important;
        }
        .wc-120 {
            width: 120px !important;
        }

        .table thead th {
            vertical-align: middle;
        }
        
        .auto-input {
            cursor: pointer;
        }
        
        #inp_file_label {
            width:100%;
            padding: 20px;
            border: 1px dashed #ddd;
            cursor:pointer;
            display:block;
            text-align:center;
            background-color: rgba(0,0,0,0.02);
        }
        #inp_file_label:hover {
            background-color: rgba(0,0,0,0.05);
        }
        #inp_file_label i {
            font-size: 1.8em;
            margin-bottom: 10px;
        }
        #inp_file_label span {
            color: rgba(0,0,0,0.7);
            font-size: 14px;
        }

        .upload_grup {
            width: 100px;
            position: relative;
            cursor: pointer;
        }
        .upload_grup ._img {
            width: 100%;
            height: 120px;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
        }
        .upload_grup ._img.logo {
            height: 100px;
        }
        .inp_foto {
            display: none;
        }
        .upload_grup ._img, .lab_foto {
            background-color: var(--light);
            border: 1px dashed #ddd; 
        }
        .lab_foto {
            display: block;
            text-align: center;
            padding: 7px 10px;
            cursor: pointer;
        }
        .lab_foto:hover {
            background-color: var(--secondary);
        }
        .view_foto {
            max-width: 100%;
            max-height: 100%;
            object-fit: scale-down;
        }

        .load_card ._icon, .load_card ._text, .load_card_1, .load_card_2 ._label, .load_card_2 ._nama, .load_card_3 {
            background-color: var(--secondary);
        }

        .load_card ._text, .load_card_2 ._label, .load_card_2 ._nama, .load_card_3 {
            width: 100%;
        }

        .load_card ._icon {
            width: 70px;
            height: 70px;
            border-radius: 100%;
            margin: 0 auto 20px;
        }
        .load_card ._text {
            max-width: 150px;
            height: 16px;
            margin: 0 auto;
        }

        .load_card_1 {
            width: 38px;
            height: 38px;
            margin: 0 auto;
        }
        .load_card_2 ._label {
            max-width: 150px;
            height: 15px;
            margin-bottom: 7px;
        }
        .load_card_2 ._nama {
            height: 20px;
        }
        .load_card_3 {
            height: 38px;
        }
        .dashed .list-group-item {
            border-style: dashed
        }

        @media screen and (max-width: 768px) {
            .mini-sidebar .navmenu ._icon {
                width: 55px;
            }
            .mini-sidebar .navmenu ._text {
                display: block;
            }
        }
    </style>

</head>
<body class="o-hidden <?= $collps_menu ?>">
    <!-- loading -->
    <div class="loading">
        <div class="__inline">
            <div class="circle"></div>            
            <div class="text">
                Memuat Data
            </div>
        </div>
    </div>
    
    <!-- header area -->
    <header class="header">
        <div class="_inline d-flex justify-content-end">
            <div class="showhide-group d-flex align-items-center">
                <button class="__btn_showhide_nav"></button>
                <strong class="text-primary ml-3">
                    <?= admin ()->jenis_toko ?>
                </strong>
            </div>
            <div class="_left">
                <h1 class="webTitle mb-0">
                    <a href="<?= site_url() ?>">
                        <span class="_long">
                            <?= webTitle() ?>
                        </span>
                        <span class="_short">
                            POS
                        </span>
                    </a>
                </h1>
                <nav class="navmenu">
                    <h6>Menu Utama</h6>
                    <ul>
                        <?php 
                            foreach(menu($level, 'utama', 'main') as $menu) : 
                                $icon = $menu->icon_menu;
                                $slug = $menu->slug_menu;
                                $nama = $menu->nama_menu;
                                if ($uri2 == ''){
                                    $active = $uri1 == $slug ? 'active' : '';
                                }else{
                                    $active = $uri1.'/'.$uri2 == $slug ? 'active' : '';
                                }
                                
                        ?>
                        <li class="<?= $active ?>">
                            <a href="<?= site_url($slug) ?>">
                                <span class="_icon">
                                    <i class="fa fa-<?= $icon ?>"></i>
                                </span>
                                <span class="_text">
                                    <?= $nama ?>
                                </span>
                            </a>
                        </li>
                        <?php endforeach ?>
                    </ul>
                    
                    <?php if(admin ()->level == 'Owner') : ?>
                    <h6>Tambahan</h6>
                    <ul>
                        <?php 
                            foreach(menu($level, 'utama', 'tambahan') as $menu) : 
                                $icon = $menu->icon_menu;
                                $slug = $menu->slug_menu;
                                $nama = $menu->nama_menu;
                                $active = $uri1 == $slug ? 'active' : '';
                                
                        ?>
                        <li class="<?= $active ?>">
                            <a href="<?= site_url($slug) ?>">
                                <span class="_icon">
                                    <i class="fa fa-<?= $icon ?>"></i>
                                </span>
                                <span class="_text">
                                    <?= $nama ?>
                                </span>
                            </a>
                        </li>
                        <?php endforeach ?>
                        
                    </ul>
                    <?php endif ?>
                </nav>
            </div>
    
            <div class="_right">
                <ul>
                    <li>
                        <a href="" data-toggle="dropdown" id="menu-dropdown">
                            <div class="_img">
                                <img src="<?= base_url('upload/karyawan/'.admin()->foto) ?>" alt="img">
                            </div>
                            <div class="_text">
                                <small><?= ucapan() ?></small>
                                <p class="mb-0"><?= admin ()->nama_admin ?></p>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right"
                            aria-labelledby="menu-dropdown"
                        >
                            <li class="akun-menu-header">
                                Akun
                            </li>
                            
                            <li>
                                <a href="<?= site_url('akun') ?>">
                                    <i class="fa fa-user mr-2"></i> 
                                    Akun
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url('akun/ubah_sandi') ?>">
                                    <i class="fa fa-user-lock mr-2"></i> 
                                    Ubah sandi
                                </a>
                            </li>
                            <li class="logOut">
                                <a href="<?= site_url('akun/keluar') ?>">
                                    <i class="fa fa-sign-out-alt mr-2"></i> 
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <nav class="navInfo">
        <div class="_info">                
            <?= $webInfo ?>
        </div>
        <?php if($data_submenu) : ?>            
            <ul class="_menu">
                <?php 
                    foreach($data_submenu as $submenu) : 
                        $url    = $submenu->slug_menu;
                        $nama   = $submenu->nama_menu;
                        $active = $uri2 == $url ? 'active' : '';
                        
                ?>
                    <li class="<?= $active ?>">
                        <a href="<?= site_url($uri1 . '/' . $url) ?>">
                            <?= $nama ?>
                        </a>
                    </li>      
                <?php endforeach ?>
            </ul>
        <?php endif ?>
    </nav>

    <!-- main area -->
    <main class="main">
        <?php 
            echo $contents;
        ?>
    </main>

    <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/DataTables/datatables.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/sweetalert/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/select2/js/select2.full.min.js"></script>
    <!-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> -->
    <?php if($uri1 == 'lap_global') : ?>
        <script>
            let base_url = '<?= site_url() ?>';

            let data_keluar = $('#data_keluar').dataTable({
                pageLength: 50,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: base_url + 'pengeluaran/load_data',
                    data: {user: 'owner'}
                }
            });

            function hps_item(kode) {
                Swal.fire({
                    icon: 'question',
                    title: 'Apakah anda yakin?',
                    html: 'Item yang dihapus tidak dapat dikembalikan lagi',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false

                }).then(function(result) {
                    if(result.value) {
                        $.post({
                            url: base_url + 'pengeluaran/hapus',
                            data: {kode: kode},
                            success: data => {
                                if(data == '') {
                                    data_keluar.api().ajax.reload(null, true);
                                }
                            }
                        });
                    }
                });
            }

            function detail(kode) {
                $.post({
                    url: base_url + 'pengeluaran/detail',
                    data: {kode: kode},
                    success: data => {
                        $('#modal_detail').modal('show').find('.modal-body').html(data);
                    }
                });
            }
        </script>
    <?php endif ?>

    <?php if($uri1 == 'pengeluaran') : ?>
        <script>
            <?php if(isset($_GET['user'])) : ?>
                $('.navmenu li').removeClass('active');
            <?php endif ?>

            let base_url = '<?= site_url() ?>';

            let data_item = () => {
                let type = '<?= isset($_GET['user']) ? $_GET['user'] : 'Owner' ?>';
                $.get(base_url + 'pengeluaran/load_data_item/' + type, html => {
                    $('.data_item').html(html);
                } )
            }

            data_item();

            let data_keluar = $('#data_keluar').dataTable({
                pageLength: 50,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: base_url + 'pengeluaran/load_data',
                    data: {user: 'kasir'}
                }
            });

            $(document).on('click', '.btn_add_item', function() {
                $('#modal_item').modal('show').trigger('reset').find('.modal-header h5').text('Tambah');
                $('[name="id"]').val(0);
            });

            $(document).on('click', '.hps_item', function() {
                $(this).closest('tr').remove();
            });

            $(document).on('change', '.harga', function() {
                let total = 0;
                $('.harga').each(function() {
                    let harga = Number($(this).val());
                    total += harga;
                })

                $('.total_keluar').text(format(total));
            });
            
            $(document).on('submit', '#submit_tambah', function(e) {
                e.preventDefault();
               let form = $(this);
               $.post({
                    url: base_url + 'pengeluaran/tambah',
                    data: form.serialize(),
                    success: data => {
                        if(data == '') {
                            toast('success', 'Data sudah ditambahkan');
                            $('.modal').modal('hide');
                            <?php if(isset($_GET['user']) && $_GET['user'] == 'kasir') : ?>
                                window.location.href = base_url + 'pengeluaran'
                            <?php else: ?>
                                window.location.href = base_url + 'lap_global'
                            <?php endif ?>
                        }
                    }
               })
            });

            $(document).on('submit', '#modal_item', function(e) {
                e.preventDefault();
               let form = $(this);
               $.post({
                    url: base_url + 'pengeluaran/submit_item',
                    data: form.serialize(),
                    success: data => {
                        if(data == '') {
                            toast('success', 'Data sudah diperbarui');
                            $('.modal').modal('hide').trigger('reset');
                            data_item();
                        }
                    }
               })
            });

            $(document).on('click', '.btn_edit_item', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#modal_item h5').text('Edit')
                $.post({
                        url: base_url + 'pengeluaran/get_detail_item/' + id,
                        dataType: 'json',
                        success: data => {
                            $('[name="id"]').val(data.id);
                            $('[name="nama"]').val(data.nama);

                            $('#modal_item').modal('show')
                        }
                })
            });

            $(document).on('click', '.btn_hps_item', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.post({
                    url: base_url + 'pengeluaran/get_hps_item/' + id,
                    success: data => {
                        data_item();   
                    }
                })
            });

            function hps_item(kode) {
                Swal.fire({
                    icon: 'question',
                    title: 'Apakah anda yakin?',
                    html: 'Item yang dihapus tidak dapat dikembalikan lagi',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false

                }).then(function(result) {
                    if(result.value) {
                        $.post({
                            url: base_url + 'pengeluaran/hapus',
                            data: {kode: kode},
                            success: data => {
                                if(data == '') {
                                    data_keluar.api().ajax.reload(null, true);
                                }
                            }
                        });
                    }
                });
            }

            function detail(kode) {
                $.post({
                    url: base_url + 'pengeluaran/detail',
                    data: {kode: kode},
                    success: data => {
                        $('#modal_detail').modal('show').find('.modal-body').html(data);
                    }
                });
            }

            
            function new_data() {
                $('.add_kluar_body').append(
                    `
                        <tr>
                            <td style="width: 20px" class="text-center">
                                <a href="javascript:void(0)" class="btn btn-danger hps_item">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <td style="width: 250px">
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
                                <input type="text" class="form-control harga" name="harga[]">
                            </td>
                        </tr>
                    `
                );
                select2();
            }
        </script>
    <?php endif ?>

    <?php if($uri1 == 'inventaris') : ?>
        <script>
            let data_brg = $('#data_brg').dataTable({
                ordering: false,
                pageLength: 50,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '<?= site_url('inventaris/load_data_brg/') ?>' + '<?= $uri3 ?>',
                    type: 'post',
                    complete:  () => {
                        $('.hps').on('click', function (e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');

                            hps (href, text, data_brg);
                        });

                        $('.btn_detail_brg').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_detail_brg .modal-content').html(__modal_loading());
                            $.get(
                                '<?= site_url('inventaris/detail_brg/') ?>' + id,
                                function (data) {
                                    $('#modal_detail_brg .modal-content').html(data);

                                    $('#submit_cetak_barcode').on('click', function(e) {
                                        e.preventDefault();
                                        let id  = $('#print_id').val();
                                        let jml = $('#print_jml').val();

                                        window.open('<?= site_url('inventaris/print_barcode_brg/') ?>' + id + '/' + jml, '', 'width: 21mm'); 
                                    });

                                    $('.d_collps_brg').on('click', function() {
                                        $(this).toggleClass('show_detail_item');
                                        if($(this).hasClass('show_detail_item')) {
                                            $(this).children('.child').children('i').removeClass('fa-chevron-down');
                                            $(this).children('.child').children('i').addClass('fa-chevron-up');

                                        } else {
                                            $(this).children('.child').children('i').addClass('fa-chevron-down');
                                            $(this).children('.child').children('i').removeClass('fa-chevron-up');
                                        }
                                    });
                                
                                }
                            )
                        });

                        $('.btn_ubah_brg').on('click', function() {
                                let id = $(this).data('id');
                                $('#modal_ubah_brg .modal-content').html(__modal_loading());

                                $.get({
                                    url: '<?= site_url('inventaris/form_ubah_brg/') ?>' + id,
                                    success: function(data) {
                                        select2();
                                        $('#modal_ubah_brg .modal-content').html(data);
                                        $('#u_sw_retur').on('click', function() {
                                            if($(this).is(':checked')) {
                                                $(this).val(1);
                                                $('#u_sw_retur_text').text('Aktif');

                                            } else {
                                                $(this).val(0);
                                                $('#u_sw_retur_text').text('Nonaktif');
                                            }
                                        });

                                        $('#u_sw_grosir').on('click', function() {
                                            let id = $(this).data('id');
                                            if($(this).is(':checked')) {
                                                $(this).val(1);
                                                $('#u_sw_grosir_text').text('Aktif');
                                                $.get(
                                                    '<?= site_url('inventaris/form_grosir/') ?>' + id,
                                                    function(data) {
                                                        $('.form_ubah_inp_grosir').html(data);
                                                        $('.add_new_grosir').on('click', function(e) {
                                                            e.preventDefault();
                                                            $('#tb_tambah_satuan').append('<tr><td style="width: 120px"><input type="number" name="u_min_grosir[]" min="1" class="form-control form-control-sm text-center" placeholder="Min" required></td><td><input type="number" name="u_harga_grosir[]" class="form-control form-control-sm" placeholder="Harga Grosir" required></td></tr>')
                                                        })
                                                    }
                                                );

                                            } else {
                                                $(this).val(0);
                                                $('#u_sw_grosir_text').text('Nonaktif');
                                                $('.form_ubah_inp_grosir').html('');
                                            }                 
                                        });
                                    }
                                })
                            });
                    },
                },
                language: {
                    lengthMenu: "_MENU_",
                    zeroRecords: "No Data.",
                    info: "Page _PAGE_ dari _PAGES_",
                    infoEmpty: "",                    
                    infoFiltered: "(Filter from _MAX_ total data)"
                },
            });     
            
            let brg_masuk = $('#brg_masuk').dataTable({
                ordering: false,
                pageLength: 50,
                processing: true,
                servetSide: true,
                ajax: {
                    url: '<?= site_url('inventaris/load_data_brgm') ?>',
                    type: 'post',
                    complete:  () => {
                        $('.hps').on('click', function (e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');

                            hps (href, text, brg_masuk);
                        });

                        $('.btn_load_brgm').on('click', function () {
                            let href = $(this).attr('href');
                            $.get(
                                href,
                                function (data) {
                                    $('#modal_detail_brgm .modal-content').html(data);

                                    $('.hps_brgm').on('click', function (e) {
                                        e.preventDefault();
                                        let href = $(this).attr('href');
                                        $(this).closest('tr').remove(); 

                                        Swal.fire({
                                            icon: 'question',
                                            title: 'Apakah anda yakin?',
                                            showCancelButton: true,
                                            confirmButtonText: 'Hapus',
                                            cancelButtonText: 'Batal',
                                            buttonsStyling: false,
                                            customClass: {
                                                confirmButton: 'btn btn-danger mr-2',
                                                cancelButton: 'btn btn-secondary'
                                            },
                                        }).then(
                                            result => {
                                                if(result.isConfirmed) {
                                                    $.get(
                                                        href,
                                                        function() {
                                                            toast('success', 'Data barang masuk sudah dihapus');
                                                            brg_masuk.api().ajax.reload(null, true);
                                                        }
                                                    );
                                                }
                                            }
                                        );
                                        
                                    })
                                }
                            )
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: 0
                    },
                ]
            });

            let id_brg = $('#nama_brg_tambah').val();
            let brg_tambah = $('#brg_tambah').dataTable({
                ordering: false,
                pageLength: 50,
                processing: true,
                servetSide: true,
                ajax: {
                    url: '<?php echo site_url('inventaris/load_modal_data_brgm/'); ?>',
                    type: 'post',
                    data : {id_brg : id_brg},
                    complete:  () => {
                        $('.hps').on('click', function (e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');

                            hps (href, text, brg_tambah);
                        });

                        $('.btn_load_brgm').on('click', function () {
                            let href = $(this).attr('href');
                            $.get(
                                href,
                                function (data) {
                                    $('#modal_detail_brgm .modal-content').html(data);

                                    $('.hps_brgm').on('click', function (e) {
                                        e.preventDefault();
                                        let href = $(this).attr('href');
                                        $(this).closest('tr').remove(); 

                                        Swal.fire({
                                            icon: 'question',
                                            title: 'Apakah anda yakin?',
                                            showCancelButton: true,
                                            confirmButtonText: 'Hapus',
                                            cancelButtonText: 'Batal',
                                            buttonsStyling: false,
                                            customClass: {
                                                confirmButton: 'btn btn-danger mr-2',
                                                cancelButton: 'btn btn-secondary'
                                            },
                                        }).then(
                                            result => {
                                                if(result.isConfirmed) {
                                                    $.get(
                                                        href,
                                                        function() {
                                                            toast('success', 'Data barang masuk sudah dihapus');
                                                            brg_tambah.api().ajax.reload(null, true);
                                                        }
                                                    );
                                                }
                                            }
                                        );
                                        
                                    })
                                }
                            )
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: 0
                    },
                ]
            });


            let brg_keluar = $('#brg_keluar').dataTable({
                ordering: false,
                pageLength: 50,
                processing: true,
                servetSide: true,
                ajax: {
                    url: '<?= site_url('inventaris/load_data_brgk') ?>',
                    type: 'post',
                    complete:  () => {
                        $('.hps').on('click', function (e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');

                            hps (href, text, brg_keluar);
                        });

                        $('.btn_load_brgk').on('click', function () {
                            let href = $(this).attr('href');
                            $.get(
                                href,
                                function (data) {
                                    $('#modal_detail_brgk .modal-content').html(data);

                                    $('.hps_brgk').on('click', function (e) {
                                        e.preventDefault();
                                        let href = $(this).attr('href');
                                        $(this).closest('tr').remove(); 

                                        Swal.fire({
                                            icon: 'question',
                                            title: 'Apakah anda yakin?',
                                            showCancelButton: true,
                                            confirmButtonText: 'Hapus',
                                            cancelButtonText: 'Batal',
                                            buttonsStyling: false,
                                            customClass: {
                                                confirmButton: 'btn btn-danger mr-2',
                                                cancelButton: 'btn btn-secondary'
                                            },
                                        }).then(
                                            result => {
                                                if(result.isConfirmed) {
                                                    $.get(
                                                        href,
                                                        function() {
                                                            toast('success', 'Data barang keluar sudah dihapus');
                                                            brg_keluar.api().ajax.reload(null, true);
                                                        }
                                                    );
                                                }
                                            }
                                        );
                                        
                                    })
                                }
                            )
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: 0
                    },
                ]
            });

            let data_supplier = $('#data_supplier').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('inventaris/load_data_supplier') ?>',
                    complete: function() {
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_supplier);
                        });

                        $('.btn_ubah_supplier').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_ubah_supplier .modal-content').html(__modal_loading());
                            $.get({
                                url: '<?= site_url('inventaris/form_ubah_supplier/') ?>' + id,
                                success: function(data) {
                                    $('#modal_ubah_supplier .modal-content').html(data);
                                }
                            });
                        });
                    }      
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                    {
                        className: 'w-85',
                        targets: [1]
                    }
                ],
                
            });

            let data_satuan = $('#data_satuan').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('inventaris/load_data_satuan') ?>',
                    complete: function() {
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_satuan);
                        });

                        $('.btn_ubah_satuan').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_ubah_satuan .modal-content').html(__modal_loading());
                            $.get({
                                url: '<?= site_url('inventaris/form_ubah_satuan/') ?>' + id,
                                success: function(data) {
                                    $('#modal_ubah_satuan .modal-content').html(data);
                                }
                            });
                        });
                    }      
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                    {
                        className: 'w-85',
                        targets: [1]
                    }
                ],
                
            });

            let data_kategori = $('#data_kategori').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('inventaris/load_data_kategori') ?>',
                    complete: function() {
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_kategori);
                        });

                        $('.btn_ubah_kategori').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_ubah_kategori .modal-content').html(__modal_loading());
                            $.get({
                                url: '<?= site_url('inventaris/form_ubah_kategori/') ?>' + id,
                                success: function(data) {
                                    $('#modal_ubah_kategori .modal-content').html(data);
                                }
                            });
                        });
                    }      
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                    {
                        className: 'w-85',
                        targets: [1]
                    }
                ],
                
            }); 
            
            let data_opname = $('#data_opname').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('inventaris/load_data_opname') ?>',
                    complete: function() {
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_opname);
                        });

                        $('.btn_detail_opname').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_detail_opname .modal-content').html(__modal_loading());
                            $.get({
                                url: '<?= site_url('inventaris/data_detail_opname/') ?>' + id,
                                success: function(data) {
                                    $('#modal_detail_opname .modal-content').html(data);
                                }
                            });
                        });

                    }      
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                    {
                        className: 'w-85',
                        targets: [1]
                    }
                ],
                
            }); 
            
            let data_tambah_opname = $('#data_tambah_opname').dataTable({
                pageLength: 1,
                ordering: false,
                paginate: false,
                info: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('inventaris/load_data_tambah_opname') ?>',
                    complete: function() {
                        btn_submit_opname();
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let id   = $(this).data('id');
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            
                            Swal.fire({
                                icon: 'question',
                                title: 'Apakah anda yakin?',
                                showCancelButton: true,
                                confirmButtonText: 'Hapus',
                                confirmButtonColor: 'var(--danger)',
                                cancelButtonText: 'Batal',
                                customClass: {
                                    confirmButton: 'btn btn-danger mr-3',
                                    cancelButton: 'btn btn-secondary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                if(result.value) {  
                                    $(this).closest('tr').remove();
                                    $.get(
                                        href,
                                        function() {
                                            btn_submit_opname();  
                                            data_list_brg_opname.api().ajax.reload(null, true);
                                        }
                                    );

                                }
                            });
                        });

                        $('.jml_stok_fisik').on('input', function() {
                            let jml_fisik   = this.value;
                            let id          = $(this).data('id');
                            let jml_system  = $('.jml_stok_system_' + id).val();
                            let jml_selisih = parseInt(jml_fisik) - parseInt(jml_system);
                            
                            $('.jml_selisih_stok_' + id).text(jml_fisik != '' ? jml_selisih : 0);
                        })
                    }      
                },
                columnDefs: [
                    {
                        className: 'text-center',
                        targets: [0, 2, 3, 4]
                    },
                ],
                
            }); 
            
            let data_list_brg_opname = $('#list_brg').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('inventaris/load_list_brg_opname') ?>',
                    complete: function() {

                        $('.add_list_check').on('click', function(e) {
                            e.preventDefault();
                            let url = $(this).attr('href');
                            
                            if($(this).hasClass('checked')) {
                                $(this).removeClass('checked');
                                $(this).html(__btn_loading());

                                $.get({
                                    url: url,
                                    success: function(data) {                                       
                                        $(this).children('i').addClass('fa-plus');
                                        $(this).children('i').removeClass('fa-check');
                                        data_tambah_opname.api().ajax.reload(null, true);                                                              
                                        data_list_brg_opname.api().ajax.reload(null, true);
                                    }
                                });

                            } else {
                                $(this).addClass('checked');
                                $(this).html(__btn_loading());

                                $.get({
                                    url: url,
                                    success: function(data) {                                       
                                        $(this).children('i').removeClass('fa-plus');
                                        $(this).children('i').addClass('fa-check');
                                        data_tambah_opname.api().ajax.reload(null, true);                                                              
                                        data_list_brg_opname.api().ajax.reload(null, true);                                                              
                                        
                                    }
                                });
                            }                            
                            
                        })
                    }      
                },
                columnDefs: [
                    {
                        className: 'wp-15 text-center',
                        targets: [0]
                    },
                ],
                
            }); 

            let modal_data_add_brgm = $('#modal_data_add_brgm').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    url: '<?= site_url('inventaris/load_modal_data_brgm') ?>',
                    type: 'POST',
                    complete: function() {
                        
                        $('._add_brgm').on('click', function(e) {
                            e.preventDefault();
                            let kode = $(this).data('kode');
                            add_list_brgm(kode);
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            })

            let modal_data_add_brgk = $('#modal_data_add_brgk').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    url: '<?= site_url('inventaris/load_modal_data_brgk') ?>',
                    type: 'POST',
                    complete: function() {
                        
                        $('._add_brgk').on('click', function(e) {
                            e.preventDefault();
                            let kode = $(this).data('kode');
                            add_list_brgk(kode);
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            });
            
            $(window).on('keydown', function(e) {
                if(e.keyCode == 13) {
                    e.preventDefault();
                    let focus = $('.dataTables_filter input').focus();
                }
            });

            $('.d_collps_opname').on('click', function() {
                if($(this).hasClass('checked')) {
                    $(this).removeClass('checked');
                    $(this).children('i').removeClass('fa-chevron-up');
                    $(this).children('i').addClass('fa-chevron-down');

                } else {
                    $(this).addClass('checked');
                    $(this).children('i').addClass('fa-chevron-up');
                    $(this).children('i').addClass('fa-chevron-down');
                }

            });
            
            $('#filter_stok').on('change', function () {
                if(this.value == '') {
                window.location.href = '<?= site_url('inventaris/') ?>' + '#data_brg'

                } else {
                    window.location.href = '<?= site_url('inventaris/index/') ?>' + this.value + '#data_brg'
                }
            });

            $('#sw_grosir').on('click', function() {
                if($(this).is(':checked')) {
                    $(this).val(1);
                    $('#sw_grosir_text').text('Aktif');
                    
                    $.get(
                        '<?= site_url('inventaris/form_grosir') ?>',
                        function(data) {
                            $('.form_inp_grosir').html(data);
                            $('.add_new_grosir').on('click', function(e) {
                                e.preventDefault();
                                $('#tb_tambah_satuan').append('<tr><td style="width: 120px"><input type="number" name="min_grosir[]" min="1" class="form-control form-control-sm text-center" placeholder="Min" required></td><td><input type="number" name="harga_grosir[]" class="form-control form-control-sm" placeholder="Harga Grosir" required></td></tr>')
                            });
                        }
                    );

                } else {
                    $(this).val(0);
                    $('#sw_grosir_text').text('Nonaktif');
                    $('.form_inp_grosir').html('');
                }
            }); 
            
            $('#sw_retur').on('click', function() {
                if($(this).is(':checked')) {
                    $(this).val(1);
                    $('#sw_retur_text').text('Aktif');

                } else {
                    $(this).val(0);
                    $('#sw_retur_text').text('Nonaktif');
                }
            }); 

            $('.add_new_brgm').on('click', function(e) {
                e.preventDefault();
                $.get(
                    '<?= site_url('inventaris/form_add_brgm') ?>',
                    function(data) {
                        $('#tb_form_add_brgm tbody').append(data);
                        select2();

                        $('.hps_add_brgm').on('click', function (e) {
                            e.preventDefault();
                            $(this).closest('tr').remove();
                        });


                    }
                );
            });

            $('.add_new_brgk').on('click', function(e) {
                e.preventDefault();
                $.get(
                    '<?= site_url('inventaris/form_add_brgk') ?>',
                    function(data) {
                        $('#tb_form_add_brgk tbody').append(data);
                        cek_add_brgk ();
                        select2();

                        $('.hps_add_brgk').on('click', function (e) {
                            e.preventDefault();
                            $(this).closest('tr').remove();
                        })
                    }
                );
            });

            <?php if($uri2 == 'brg_masuk' && $uri3 == 'tambah') : ?>
                $(window).on('keydown', function(e) {
                    if(e.keyCode == 13) {
                        let kode = $('#scan_barcode').focus().val();
                        if(kode != '') {
                            add_list_brgm(kode, 'scanner');
                        }
                    }
                });

                $('#src_brgm').on('input', function() {
                    let val = $(this).val();
                    if(val != '') {
                        add_list_brgm(val, 'input');
                    }
                });
            <?php endif ?>

            <?php if($uri2 == 'brg_keluar' && $uri3 == 'tambah') : ?>
                $(window).on('keydown', function(e) {
                    if(e.keyCode == 13) {
                        let kode = $('#scan_barcode').focus().val();
                        if(kode != '') {
                            add_list_brgk(kode, 'scanner');
                        }
                    }
                });

                $('#src_brgk').on('input', function() {
                    let val = $(this).val();
                    if(val != '') {
                        add_list_brgk(val, 'input');
                    }
                })
            <?php endif ?>

            <?php if($uri2 == 'opname' && $uri3 == 'tambah') : ?>
                $(window).on('keydown', function(e) {
                    if(e.keyCode == 13) {
                        let input = $('#scan_barcode');
                        let kode = input.focus().val();
                        
                        if(kode != '') {
                            $.get('<?= site_url('inventaris/proses_tambah_brg_opname_scanner/') ?>' + kode, function(data) {
                                console.log(data);
                                input.val('');
                                if(data == '') {
                                    toast('success', 'Ditambahkan');
                                    data_tambah_opname.api().ajax.reload(null, true);                                                              
                                    data_list_brg_opname.api().ajax.reload(null, true);

                                } else if(data == 'empty') {
                                    toast('error', 'Produk tidak ditemukan');
                                }
                            });
                        }
                    }
                });
            <?php endif ?>

            $('#submit_tambah_brgm').on('submit', function (e) {
                e.preventDefault();
                let cek;
                
                $('.nama_brgm').each(function() {
                if(this.value == '') {
                        cek = 0;
                } else {
                        cek = 1;               
                    }
                });

                if(cek == 0) {
                    toast('warning', 'Upss, ada barang belum dipilih');

                } else {
                    Swal.fire({
                        icon: 'question',
                        title: 'Apakah anda yakin?',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-primary mr-2',
                            cancelButton: 'btn btn-secondary'
                        },
                    }).then (
                        result => {
                            if(result.isConfirmed) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Barang masuk sudah ditambahkan',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true,
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        $.post({
                                            url: '<?= site_url('inventaris/proses_submit_brgm') ?>',
                                            data: $('#submit_tambah_brgm').serialize(),
                                            success: function (data) {
                                                if(data == '') {
                                                    window.location.href = '<?= site_url('inventaris/brg_masuk') ?>';
                                                }
                                            }
                                        }); 
                                    }
                                });
                                                                                    
                            }
                        }
                    )
                }
            });

            $('#submit_tambah_brgk').on('submit', function (e) {
                e.preventDefault();
                let cek;
                
                $('.nama_brgk').each(function() {
                if(this.value == '') {
                        cek = 0;
                } else {
                        cek = 1;               
                    }
                });

                if(cek == 0) {
                    toast('warning', 'Upss, ada barang belum dipilih');

                } else {
                    Swal.fire({
                        icon: 'question',
                        title: 'Apakah anda yakin?',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-primary mr-2',
                            cancelButton: 'btn btn-secondary'
                        },
                    }).then (
                        result => {
                            if(result.isConfirmed) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Barang keluar sudah ditambahkan',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true,
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        $.post({
                                            url: '<?= site_url('inventaris/proses_submit_brgk') ?>',
                                            data: $('#submit_tambah_brgk').serialize(),
                                            success: function (data) {
                                                if(data == '') {
                                                    window.location.href = '<?= site_url('inventaris/brg_keluar') ?>';
                                                }
                                            }
                                        }); 
                                    }
                                });
                                                                                    
                            }
                        }
                    )
                }
            });

            $('#inp').on('input', function() {
                let kode = $(this).data('kode');
                
                $.post({
                    url: '<?= site_url('inventaris/hitung') ?>',
                    data: {
                        val: $(this).val(),
                        kode: kode,
                    },
                    // dataType: 'json',
                    success: function(data) {
                        console.log(data);
                    }
                })
            });

            $('#modal_tambah_brg').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_tambah_brg') ?>',
                    data: $(this).serialize(),

                }).done(function(data) { 
                    if(data == '') {
                        data_brg.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'Barang baru sudah ditambahkan');
                        brg_tambah.api().ajax.reload(null, true);
                        $('#sw_grosir').attr('checked', false);
                    } else {
                        toast('warning', data);
                    }
                    
                    // console.log(data);
                });
            });

            $('#modal_ubah_brg').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_ubah_brg') ?>',
                    data: $(this).serialize(),

                }).done(function(data) {
                    if(data == '') {
                        data_brg.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'Data barang sudah diupdate');
                        
                    } else {                        
                        toast('warning', data);
                    }
                    // console.log(data);
                });
            });

            $('#modal_tambah_supplier').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_tambah_supplier') ?>',
                    data: $(this).serialize(),

                }).done(function(data) {

                    if(data == '') {
                        data_supplier.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'Data supplier sudah ditambahkan');
                        
                    } else {
                        toast('warning', data);
                    }
                });
            });

            $('#modal_ubah_supplier').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_ubah_supplier') ?>',
                    data: $(this).serialize(),

                }).done(function(data) {
                    if(data == '') {
                        data_supplier.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'Data supplier sudah diupdate');
                        
                    } else {                        
                        toast('warning', data);
                    }
                });
            });

            $('#modal_tambah_satuan').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_tambah_satuan') ?>',
                    data: $(this).serialize(),

                }).done(function(data) {

                    if(data == '') {
                        data_satuan.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'satuan sudah ditambahkan');
                        
                    } else {

                        toast('warning', data);

                    }
                });
            });

            $('#modal_ubah_satuan').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_ubah_satuan') ?>',
                    data: $(this).serialize(),

                }).done(function(data) {
                    if(data == '') {
                        data_satuan.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'Data satuan sudah diupdate');
                        
                    } else {                        
                        toast('warning', data);
                    }
                });
            });

            $('#modal_tambah_kategori').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_tambah_kategori') ?>',
                    data: $(this).serialize(),

                }).done(function(data) {

                    if(data == '') {
                        data_kategori.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'Kategori sudah ditambahkan');
                        
                    } else {

                        toast('warning', data);

                    }
                });
            });

            $('#modal_ubah_kategori').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('inventaris/proses_ubah_kategori') ?>',
                    data: $(this).serialize(),

                }).done(function(data) {
                    if(data == '') {
                        data_kategori.api().ajax.reload(null, true);
                        $('.modal').trigger('reset').modal('hide');
                        toast('success', 'Data kategori sudah diupdate');
                        
                    } else {                        
                        toast('warning', data);
                    }
                });
            });

            $('#submit_stok_opname').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Data yang sudah disimpan tidak bisa diubah kembali. Periksa kembali data opname sebelum disimpan',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-primary mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false,                    
                }).then(
                    function(result) {
                        if(result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data stok opname sudah disimpan',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    $.post({
                                        url: '<?= site_url('inventaris/proses_submit_opname') ?>',
                                        data: $('#submit_stok_opname').serialize(),
                                        success: function(data) {
                                            window.location.href = '<?= site_url('inventaris/opname') ?>';
                                        }
                                    });
                                }
                            })
                        }
                    }
                ); 
            });

            $('.datatables').dataTable({
                pageLength: 1,
                ordering: false,
                paginate: false,
                info: false,
                searching: false
            });

            function btn_submit_opname() {
                $('#btn_submit_opname').load('<?= site_url('inventaris/btn_submit_opname') ?>');
            }

            function add_list_brgm(kode, p) {
                $.post({
                    url: '<?= site_url('inventaris/form_add_brgm') ?>',
                    data: {
                        kode: kode
                    },
                    success: function(data) { 
                        if(p == 'scanner') {
                            $('#scan_barcode').val('');
                        }

                        if(data == 'empty') {
                            if(p != 'input') {
                                toast('error', 'Produk tidak tesedia');
                            }

                        } else {
                            if(p == 'input') {
                                $('#src_brgm').val('');
                            } 

                            $('.dataTables_empty').remove();
                            $('#tb_form_add_brgm tbody').prepend(data);
                            toast('success', 'Barang ditambahkan');
    
                        }

                        $('.harga_modal_brgm').on('click', function() {
                            $(this).removeAttr('readonly');
                        });

                        $('.harga_modal_brgm').blur(function() {
                            $(this).attr('readonly', true);
                        });

                        $('.harga_modal_brgm').on('input', function() {
                            let id       = $(this).data('id');
                            let val      = $('.qty_masuk').val() ? $('.qty_masuk').val() : 1;
                            let modal    = $(this).val();
                            let subharga = parseInt(val) * parseInt(modal);

                            $('#harga_' + id).val(subharga);
                            hitung_total_brgm();
                        });

                        $('.hps_add_brgm').on('click', function(e) {
                            e.preventDefault();
                            $(this).closest('.tr_add_brgm').remove();
                            toast('success', 'Barang dihapus')

                            hitung_total_brgm()
                        });     
                        
                        $('.qty_masuk').on('input', function() {
                            let val      = $(this).val() ? $(this).val() : 1;
                            let id       = $(this).data('id'); 
                            let harga    = $('#harga_' + id);
                            let modal    = $('#modal_' + id).val();
                            let subharga = parseInt(val) * parseInt(modal);
        
                            harga.val(subharga);
                            hitung_total_brgm();
                        });
                        
                        $('.subharga').on('input', function() {
                            hitung_total_brgm();
                        });
                        
                        hitung_total_brgm();
                    }
                })
            }

            function hitung_total_brgm() {
                let total = 0;
                $('.subharga').each(function() {
                    total += parseInt(this.value);
                });

                $('.total_brgm').html(format(total));

                if(total > 0) {
                    $('.tfoot-brgm').removeClass('d-none');
                } else {
                    $('.tfoot-brgm').addClass('d-none');
                }
            }

            function add_list_brgk(kode, p) {
                $.post({
                    url: '<?= site_url('inventaris/form_add_brgk') ?>',
                    data: {
                        kode: kode
                    },
                    success: function(data) { 
                        if(p == 'scanner') {
                            $('#scan_barcode').val('');
                        }

                        if(data == 'empty') {
                            if(p != 'input') {
                                toast('error', 'Produk tidak tesedia');
                            }

                        } else {                            
                            if(p == 'input') {
                                $('#src_brgk').val('');
                            }
                            $('.dataTables_empty').remove();
                            $('#tb_form_add_brgk tbody').prepend(data);
                            toast('success', 'Barang ditambahkan');
    
                        }

                        $('.hps_add_brgk').on('click', function(e) {
                            e.preventDefault();
                            $(this).closest('.tr_add_brgk').remove();
                            toast('success', 'Barang dihapus')
                        });  
                        
                    }
                })
            }

        </script>
    <?php endif ?>
    
    <?php if($uri1 == 'pelanggan') : ?>
        <script>
            let data_plg = $('#data_plg').dataTable({
                pageLength: 50,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('pelanggan/load_data_plg') ?>',
                    complete: function() {
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_plg);
                        });                         

                        $('.btn_ubah_plg').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_ubah_plg .modal-content').html(__modal_loading());

                            $.get({
                                url: '<?= site_url('pelanggan/form_ubah_plg/') ?>' + id,
                                success: function(data) {
                                    $('#modal_ubah_plg .modal-content').html(data);
                                }
                            })
                        });                      

                    }
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                    {
                        className: 'w-85',
                        targets: [1]
                    }
                ]
            });

            $('#modal_tambah_plg').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('pelanggan/proses_tambah_plg') ?>',
                    data: $(this).serialize(),

                }).done(function() {
                    data_plg.api().ajax.reload(null, true);
                    $('.modal').trigger('reset').modal('hide');
                    toast('success', 'Pelanggan baru sudah ditambahkan');
                });
            });
            
            $('#modal_ubah_plg').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('pelanggan/proses_ubah_plg') ?>',
                    data: $(this).serialize(),

                }).done(function() {
                    data_plg.api().ajax.reload(null, true);
                    $('.modal').trigger('reset').modal('hide');
                    toast('success', 'Data pelanggan sudah diupdate');
                });
            });

        </script>
    <?php endif ?>

    <?php if($uri1 == 'penjualan') : ?>
        <script>
            $('#modal_data_brg').on('shown.bs.modal', function (e) {
                data_brg.api().ajax.reload();
            });
            let data_plg = $('#data_plg').dataTable({
                pageLength: 25, 
                ordering: false,
                serverSide: true,
                processing: true, 
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_plg') ?>',
                    complete: function() {
                        $('._add_user').on('click', function(e) {
                            e.preventDefault();
                            let nama = $(this).data('nama');
                            let id   = $(this).data('id');

                            $('.id_plg').val(id);
                            $('.nama_plg').val(nama);

                            $('.modal').modal('hide');
                            toast('info', 'Plg ' + nama + ' ditambahkan');
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            });

            let data_ksr = $('#data_ksr').dataTable({
                pageLength: 25, 
                ordering: false,
                serverSide: true,
                processing: true, 
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_ksr') ?>',
                    complete: function() {
                        $('._add_user_ksr').on('click', function(e) {
                            e.preventDefault();
                            let nama = $(this).data('nama');
                            let id   = $(this).data('id');

                            $('.id_ksr').val(id);
                            $('.nama_ksr').val(nama);

                            $('.modal').modal('hide');
                            toast('info', 'Kasir ' + nama + ' ditambahkan');
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            });

            let data_trade = $('#data_trade').dataTable({
                pageLength: 25, 
                ordering: false,
                serverSide: true,
                processing: true, 
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_trade') ?>',
                    complete: function() {
                        $('._add_user_trade').on('click', function(e) {
                            e.preventDefault();
                            let nama = $(this).data('nama');
                            let id   = $(this).data('id');
                            let harga   = $(this).data('harga');

                            $('.id_trade').val(id);
                            $('.nama_trade').val(nama);

                            $('#trade').val(harga);
                            $('#jenis_trade').val(nama);
                            $('.modal').modal('hide');
                            hitung_pembayaran();
                            toast('info', 'Barang ' + nama + ' ditambahkan');
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            });

            let data_bank = $('#data_bank').dataTable({
                pageLength: 25, 
                ordering: false,
                serverSide: true,
                processing: true, 
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_bank') ?>',
                    complete: function() {
                        $('._add_user_bank').on('click', function(e) {
                            e.preventDefault();
                            let nama = $(this).data('nama');
                            let id   = $(this).data('id');

                            $('.id_bank').val(id);
                            $('.nama_bank').val(nama);

                            $('.modal').modal('hide');
                            toast('info', 'Bank ' + nama + ' ditambahkan');
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            });

            let data_brg = $('#data_brg').dataTable({
                pageLength: 25, 
                ordering: false,
                serverSide: true,
                processing: true, 
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_brg') ?>',
                    complete: function() {
                        $('._add_cart').on('click', function(e) {
                            e.preventDefault();
                            let kode  = $(this).data('kode');
                            let nama  = $(this).data('nama');
                            let diskon  = $('.diskon_pro').val();

                            console.log(diskon);
                            
                            $.post({
                                url: '<?= site_url('penjualan/tambah_keranjang') ?>',
                                data: {
                                    kode: kode,
                                    diskon: diskon,
                                    nama :nama
                                }
                            }).done(
                                function(data) {
                                    if(data == 'grosir-0') {
                                        toast('warning', nama + ' tidak tersedia penjualan grosir');
                                    } else {
                                        data_keranjang();
                                        $('.total_kembalian').text(0);
                                        $('.total_kembalian_inp').val(0);
                                        toast('info', nama + ' sudah ditambahkan ke keranjang');
                                        data_brg.api().ajax.reload();
                                    }
                                }
                            );
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            });

            let data_toko = $('#data_toko').dataTable({
                pageLength: 25, 
                ordering: false,
                serverSide: true,
                processing: true, 
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_toko') ?>',
                    complete: function() {
                        $('.pindah_toko').on('click', function(e) {
                            e.preventDefault();
                            let href  = $(this).attr('href');
                            let nama  = $(this).data('nama');

                            $('.modal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Pindah toko berhasil',
                                showConfirmButton: false,
                                timer: 1200,
                                timerProgressBar: true,
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    $.get(
                                        href,
                                        function() {
                                            setTimeout(function() {
                                                location.reload();
                                            }, 1200)
                                        }
                                    );
                                }
                            }).then(result);
                        })
                    }
                },
                columnDefs: [
                    {
                        className: 'wp-10 text-center',
                        targets: 0
                    }
                ]
            });

            let data_riwayat = $('#data_riwayat').dataTable({
                pageLength: 50,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_riwayat') ?>',
                    complete: function() {    
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_riwayat);
                        }); 

                        $('.btn_detail_riwayat').on('click', function(e) {
                            let id   = $(this).data('id');
                            $('#modal_detail_riwayat .modal-content').html(__modal_loading());

                            $.get(
                                '<?= site_url('penjualan/load_detail_riwayat/') ?>' + id,
                                function(data) {
                                    $('#modal_detail_riwayat .modal-content').html(data);
                                }
                            );
                        });

                        $('.btn_retur').on('click', function(e) {
                            let id   = $(this).data('id');
                            $.get(
                                '<?= site_url('penjualan/load_retur/') ?>' + id,
                                function(data) {
                                    $('#modal_retur .modal-content').html(data);
                                }
                            );
                        });

                    }      
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                    
                ]
                
            });

            let data_retur = $('#data_retur').dataTable({
                pageLength: 50,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('penjualan/load_data_retur') ?>',
                    complete: function() {    
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_retur);
                        }); 
                    }      
                },
                columnDefs: [
                    {
                        className: 'wc-50 text-center',
                        targets: [0]
                    },
                    
                ],
                
            });

            $('#modal_tambah_plg').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serializeArray(); 
                let nama, id;
                formData.forEach(function(item) {
                    if (item.name === 'nama_plg') {
                        nama = item.value;
                    }
                    if (item.name === 'id_plg') {
                        id = item.value;
                    }
                });
                $.post({
                    url: '<?= site_url('pelanggan/proses_tambah_plg') ?>',
                    data: $(this).serialize(),

                }).done(function() {
                    data_plg.api().ajax.reload(null, true);
                    let option = new Option(nama, id);
                    $('select[name="id_plg"]').append(option).val(id);
                    $('.modal').trigger('reset').modal('hide');
                    toast('success', 'Pelanggan baru sudah ditambahkan');
                    // tambahkan d
                });
            });
            
            $('#src_kode_brg').focus();

            $(window).on('keydown', function(e) {
                if(e.keyCode == 13) {
                    e.preventDefault();
                    $('#cart_form').blur();

                    let focus = $('#scan_barcode').focus();
                    let val   = $('#scan_barcode').val();

                    if(val != '') {
                        $.post({
                            url: '<?= site_url('penjualan/tambah_keranjang') ?>',
                            data: {
                                kode: val,
                            }
                        }).done(
                            function(data) {                            
                                if(data == 'brg-0') {
                                    toast('warning', 'Item tidak ditemukan');

                                } else {
                                    if(data == '') {
                                        data_keranjang();     
                                        $('.total_kembalian').text(0);
                                        $('.total_kembalian_inp').val(0);                                   
                                        toast('info', 'Item sudah ditambahkan ke keranjang');
                                    }
                                }
                                    
                                $('#scan_barcode').val('');
                            }
                        );
                    }
                    
                }
            });

            $('#src_kode_brg').on('input', function() {
                let val = this.value;
                if(val != '' && val.length >= 3) {
                    $.post({
                        url: '<?= site_url('penjualan/tambah_keranjang_search') ?>',
                        data: {
                            kode: val,
                        }
                    }).done(
                        function(data) {
                            if(data == 'grosir-0') {
                                toast('warning', 'Item tidak tersedia penjualan grosir');
                            } else {
                                if(data == '') {
                                    data_keranjang();
                                    $('.total_kembalian').text(0);
                                    $('.total_kembalian_inp').val(0);
                                    $('#src_kode_brg').val('').blur();
                                    toast('info', 'Item sudah ditambahkan ke keranjang');
                                }
                            }
                        }
                    );
                }
            });

            $('#diskon_id134').on('input', function() {
                let val = this.value;
                if(val != '' && val.length >= 3) {
                    $.post({
                        url: '<?= site_url('penjualan/tambah_keranjang_search') ?>',
                        data: {
                            kode: val,
                        }
                    }).done(
                        function(data) {
                            if(data == '') {
                                data_keranjang();
                                $('.total_kembalian').text(0);
                                $('.total_kembalian_inp').val(0);
                            }
                        }
                    );
                }
            });
            
            $('.empty_cart').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    icon: 'question',
                    title: 'Apakah anda yakin?',
                    html: 'Data keranjang akan dikosongkan',
                    showCancelButton: true,
                    confirmButtonText: 'Kosongkan',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then(
                    result => {
                        if(result.isConfirmed) {
                            $.get(
                                '<?= site_url('penjualan/kosongkan_keranjang') ?>', 
                                function(data) {
                                    if(data == 'cart-0') {
                                        toast('info', 'Keranjang masih kosong');
                                    } else {
                                        toast('info', 'Keranjang dikosongkan');
                                        data_keranjang();
                                        $('.total_kembalian_inp').val(0);
                                        $('.total_kembalian').text(0);
                                    }
                                }
                            )
                        }
                    }
                )
            });

            $('#btn_keranjang').on('click', function(e) {
                e.preventDefault();

                $.post({
                    url: '<?= site_url('penjualan/submit_keranjang') ?>',
                    data: $('#cart_form').serialize()
                }).done(function(data) {
                    window.location.href = '<?= site_url('penjualan/') ?>';
                });
            });

          

            $('#cart_form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'question',
                    title: 'Apakah anda yakin?',
                    text: 'Semua item akan disimpan dan dihapus dari keranjang',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-primary mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then (
                    result => {
                        if(result.isConfirmed) {
                            $.post({
                                url: '<?= site_url('penjualan/submit_cart') ?>',
                                data: $(this).serialize(),

                            }).done(function (data) {
                                data_keranjang();
                                $('.total_kembalian').text(0);
                                $('.total_kembalian_inp').val(0);
                                data_brg.api().ajax.reload(null, true);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Disimpan',
                                    text: 'Semua item sudah berhasil disimpan',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false,
                                }).then(
                                    res => {
                                        if(res.isConfirmed) {
                                            window.location.href = '<?= site_url('penjualan/riwayat/') ?>';
                                        }
                                    }
                                )

                            });
                        }
                    }
                );                
            });

            $('#form_tambah_retur').on('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    icon: 'question',
                    title: 'Apakah anda yakin?',
                    text: 'Data item yang dipilih akan disimpan, pastikan semua data diisi dengan benar sebelum disimpan',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-primary mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false

                }).then(
                    (res) => {
                        if(res.isConfirmed) {
                            $.post({
                                url: '<?= site_url('penjualan/submit_retur') ?>',
                                data: $(this).serialize(),
                                success: function(data) {
                                    if(data == '') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: 'Data data retur penjualan sudah disimpan',
                                            showConfirmButton: false,
                                            timer: 1500,
                                            timerProgressBar: true,
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,                                            
                                        }).then(
                                            () => {                                                                        
                                                window.location.href = '<?= site_url('penjualan/riwayat') ?>';
                                            } 
                                        ); 

                                    } else if('empty') {
                                        toast('warning', 'Tidak ada item yang dipilih');

                                    } else {
                                        console.log(data);
                                    }
                                } 
                            });
                        }
                    }
                );
            });

            // var pusher = new Pusher('298818e8899389cf44aa', {
            //     cluster: 'ap1',
            // });

            // var channel = pusher.subscribe('my-channel');
            // channel.bind('my-event', function(data) {
            //     if(data.message === 'success') {
            //         data_keranjang();
            //     }
            // });
            
            data_keranjang();
            function data_keranjang() {
                $('#data_keranjang tbody').load(
                    '<?= site_url('penjualan/data_keranjang') ?>',
                    function() {
                        $('.hps_cart').on('click', function(e) {
                            e.preventDefault();                            

                            let href = $(this).attr('href');
                            let row  = $('#data_keranjang tbody tr').length;

                            $.get(href);
                            
                            if(parseInt(row) - 1 == 0) {
                                data_keranjang();
                            }

                            $(this).closest('tr').remove();
                            hitung_total();
                            hitung_pembayaran();
                        });

                        $('._jml').on('click', function() {
                            $(this).select(); 
                        });

                        $('._jml').on('input', function() {
                            hitung_subtotal($(this));
                            
                            let jml   = this.value;
                            let id    = $(this).data('id');
                                                       
                            if(parseInt(jml) < 0) {
                                $(this).val('');

                            } else {
                                $.post({
                                    url: '<?= site_url('penjualan/update_jml_cart') ?>',
                                    data: {
                                        id: id,
                                        jml: jml
                                    }
                                });
                            }
                        });

                        load_kode();
                        hitung_total();
                        form_pembayaran();
                    }
                );
                
            }

            function load_kode() {
                $('#kode_tr').load('<?= site_url('penjualan/load_kode') ?>');
            }

            function hitung_subtotal(input) {
                let jml      = input.val() ? input.val() : 1;
                let id       = input.data('id');
                let kode     = $(input).data('kode');
                let min      = input.attr('min');
                let max      = input.attr('max');
                let harga    = $('#_harga_' + id).data('harga');
                let subtotal;

                if(parseInt(jml) == 0 || parseInt(jml) < parseInt(min) && parseInt(jml) != 0) {
                    input.addClass('is-invalid');
                    
                } else {
                    input.removeClass('is-invalid');
                } 
                             
                if(parseInt(jml) > parseInt(max)) {
                    input.val(max);
                    subtotal = parseInt(max) * parseInt(harga);
                    toast('warning', 'Jml tidak boleh lebih dari ' + max);

                } else {
                    subtotal = parseInt(jml) * parseInt(harga);
                }      

                if(parseInt(jml) < parseInt(min) && parseInt(jml) != 0) {
                    toast('warning', 'Jml tidak boleh kurang dari ' + min);
                }               

                if(parseInt(jml) > 0) {
                                    
                    $.post({
                        url: '<?= site_url('inventaris/hitung') ?>',
                        data: {
                            val: jml,
                            kode: kode,
                        },
                        dataType: 'json',
                        success: function(data) {
                            if(data != 'undefined') {
                                $('#_harga_' + kode).attr('data-harga', data.harga);
                                let subharga = parseInt(jml) * parseInt(data.harga);
                                
                                if(parseInt(jml) > parseInt(max)) {
                                    subharga = parseInt(max) * parseInt(data.harga);
                                    $('#_harga_' + kode).attr('data-subharga', subharga);
                                    $('#_harga_' + kode).text(format(subharga));

                                } else {
                                    $('#_harga_' + kode).attr('data-subharga', subharga);
                                    $('#_harga_' + kode).text(format(subharga));

                                }

                                $('#harga_eceran_' + kode).text(format(parseInt(data.eceran) * parseInt(jml)));
                                $('#harga_jual_' + kode).val(data.harga);

                                $('.total_kembalian').text(0);
                                $('.total_kembalian_inp').val(0);
                                $('._diskon').val('');
                                $('._bayar').val('');
                                $('.inp_donasi input').val('');

                                if(data.is_grosir == 1) {
                                    $('#_harga_' + kode).addClass('text-danger');
                                } else {
                                    $('#_harga_' + kode).removeClass('text-danger');
                                }
                                hitung_total();
                            }
                        }
                    });
                }  
                
                hitung_pembayaran();            
            }

            function hitung_total() {
                let total = 0;   

                $('._harga').each(function() {
                    total += parseInt($(this).attr('data-subharga'));
                });  

                $('.total_cart').text(format(total));          
                $('.total_cart_inp').val(total);          
            }
            
            function form_pembayaran() {
                var status = getParameterByName('status');
                $('.form_pembayaran').load(
                    '<?= site_url('penjualan/form_pembayaran') ?>',
                    { status: status },
                    function() {
                        $('#bayarK').hide();
                        $('#bayarB').hide();
                        $('#bayarT').hide();
                        $('#bayar,#bayarTunai,#bayarKredit,#bayarBank, ._diskon').on('input',  function() {
                            hitung_pembayaran();
                            $(this).val(format_rupiah(this.value));
                        });

                        $('.jenis_diskon').on('change', function() {
                            hitung_pembayaran();
                        });

                        $('.jenis_trade').on('change', function() {
                            hitung_pembayaran();
                        });

                        $('.nama_plg').on('click', function () {
                            let val = this.value;
                            if(val != 'Umum') {
                                $(this).val("Umum");
                                $('.id_plg').val("Umum");
                                toast('info', 'Plg Umum ditambahkan');
                            }
                        });
                        
                        $('.auto-input').on('click', function() {
                            $('._bayar').val($(this).data('value'));
                            hitung_pembayaran();
                        });

                        $('#is_donasi').on('click', function() {
                           if($(this).is(':checked')) {
                                $('.inp_donasi').removeClass('d-none');
                            } else {
                               $('.inp_donasi').addClass('d-none');
                            }
                        });

                        $('#id_tipe').change(function() {
                            var selectedOption = $(this).val();
                            // Menampilkan elemen yang sesuai dengan pilihan yang dipilih
                            if (selectedOption === 'Tunai') {
                                $('#bayarT').show();
                                $('#bayarK').hide();
                                $('#bayarB').hide();
                            } else if (selectedOption === 'Transfer') {
                                $('#bayarB').show();
                                $('#bayarK').hide();
                                $('#bayarT').hide();
                            } else {
                                $('#bayarK').show();
                                $('#bayarB').show();
                                $('#bayarT').show();
                            }
                        });
                    }
                );
            }

            function getParameterByName(name, url) {
                if (!url) url = window.location.href;
                name = name.replace(/[\[\]]/g, '\\$&');
                var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            }

            function format_rupiah(angka) {
                let number_string = angka.toString().replace(/[^0-9]/g, '');
                let split	      = number_string.split(',');
                let sisa 	      = split[0].length % 3;
                let rupiah 	      = split[0].substr(0, sisa);
                let ribuan 	      = split[0].substr(sisa).match(/\d{3}/g);
                    
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                
                return rupiah
            }

            function hitung_pembayaran() {
                let bayarB            = parseFloat($("#bayarBank").val().replace(/\D/g, ''));
                let bayarT            = parseFloat($("#bayarTunai").val().replace(/\D/g, ''));
                let bayarK            = parseFloat($("#bayarKredit").val().replace(/\D/g, ''));
                let diskon           = $('._diskon').val() ? $('._diskon').val() : 0;
                let jenis_diskon     = $('.jenis_diskon').val();
                let trade           = $('._trade').val() ? $('._trade').val() : 0;
                let jenis_trade     = $('.jenis_trade').val();
                let total            = $('.total_cart_inp').val();
                let total_inp        = $('.total_cart_inp').val();
                let hitung_diskon;
                let hitung_kembalian;

                bayar = (parseInt(bayarB) || 0) + (parseInt(bayarT) || 0) + (parseInt(bayarK) || 0);

                total = parseInt(total) - parseInt(trade);
                if(jenis_diskon == 'Nominal') {
                    hitung_diskon    = parseInt(diskon) > parseInt(total) ? parseInt(total) : parseInt(total) - parseInt(diskon);

                } else {
                    hitung_diskon    = parseInt(diskon) > 100 ?  parseInt(total) : parseInt(total) - (parseInt(total * diskon) / 100);
                }

                
                hitung_kembalian = parseInt(bayar) > parseInt(hitung_diskon) ?  parseInt(bayar) - parseInt(hitung_diskon) : 0;

                if (parseInt(trade) > parseInt(total_inp)) {
                    hitung_diskon = 0;
                }

                $('.total_kembalian_inp').val(hitung_kembalian);
                $('[name="jml_donasi"]').val(hitung_kembalian);
                $('.total_kembalian').text(format(hitung_kembalian));
                $('.total_cart').text(format(hitung_diskon));     

                if(parseInt(diskon) > parseInt(total) && jenis_diskon == 'Nominal' || parseInt(diskon) > 100 && jenis_diskon == 'persen') {
                    $('._diskon').val('');
                    toast('warning', 'Diskon tidak valid');
                }           

                var status = getParameterByName('status');

                if (status === 'dp') {
                    $('#btn_simpan').removeAttr('disabled');
                } else if (parseInt(bayar) >= parseInt(hitung_diskon) && parseInt(total_inp) > 0) {
                    $('#btn_simpan').removeAttr('disabled');
                } else {
                    $('#btn_simpan').prop('disabled', true);
                }


                // form_pembayaran();
            }

        </script>
    <?php endif ?>

    <?php if($uri1 == 'laporan') : ?>
        <script>
            $(window).on('keydown', function(e) {
                if(e.keyCode == 13) {
                    e.preventDefault();
                    
                    let focus = $('.dataTables_filter input').focus();
                }
            });
            <?php if($data) : ?>
                $('#data_lap').dataTable({
                    ordering: false,
                    pageLength: 25,
                });
                
                let get_mulai = $('#get_mulai').val();
                let get_selesai = $('#get_selesai').val();

                $('#data_lap_jual').dataTable({
                    pageLength: 1,
                    processing: true,
                    serverSide: true,
                    info: false,
                    lengthChange: false,
                    paging: false,
                    ajax: {
                        url: '<?= site_url('laporan/load_lap_jual/') ?>',
                        type: 'post',
                        data: {
                            mulai: get_mulai,
                            selesai: get_selesai
                        },
                        complete: function() {
                            $('.btn_detail').on('click', function(e) {
                                e.preventDefault();
                                let id = $(this).data('id');
                                $('#modal_detail .modal-content').html(__modal_loading());
                                $('#modal_detail .modal-content').load('<?= site_url('laporan/load_detail_jual/') ?>' + id);
                            })
                        }
                    },
                    columnDefs: [
                        {
                            targets: [0,1,2,6],
                            className: 'text-center'
                        },
                        {
                            targets: [4],
                            className: 'text-right'
                        },
                    ],
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api();
 
                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ? i.replace('.', '') : typeof i === 'number' ? i : 0;
                        };  
                        // Total over this page
                        pageTotal = api
                            .column(4, { page: 'current' })
                            .data()
                            .reduce(function (a, b) {
                                return parseInt(intVal(a)) + parseInt(intVal(b));
                            }, 0);
            
                        // Update footer
                        $(api.column(6).footer()).html(format(pageTotal));
                    }
                });

                $('#data_lap_terlaris').DataTable({
                    pageLength: 50,
                    columnDefs: [
                        {targets: 0, orderable: false, searchable: false} 
                    ]
                })
            <?php endif ?>
        </script>
    <?php endif ?>

    <?php if($uri1 == 'karyawan') : ?>
        <script>
            let data_karyawan = $('#data_karyawan').dataTable({
                pageLength: 25,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('karyawan/load_data') ?>',
                    complete: function() {
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_karyawan);
                        });
                        
                        $('.btn_ubah').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_ubah_karyawan .modal-content').html(__modal_loading());
                            $.get({
                                url: '<?= site_url('karyawan/form_ubah/') ?>' + id,
                                success: function(data) {
                                    $('#modal_ubah_karyawan .modal-content').html(data);
                                    inp_foto();
                                    $('.showPass').on('click', function(e) {
                                        e.preventDefault();
                                        if($('#u_pass').hasClass('readonly')) {
                                            $('#u_pass').removeClass('readonly');
                                            $('#u_pass').removeAttr('readonly');
                                            
                                        } else {
                                            $('#u_pass').addClass('readonly')
                                            $('#u_pass').attr('readonly', true);
                                        }
                                    });
                                }
                            });
                        });
                        
                    }      
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                    
                ],
                
            });

            $('#modal_tambah_karyawan').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('karyawan/submit_karyawan') ?>',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if(data == '') {
                            data_karyawan.api().ajax.reload(null, true);
                            $('.modal').modal('hide').trigger('reset');
                            toast('success', 'Karyawan baru sudah ditambahkan');

                        } else if(data == 'email_tersedia') {
                            toast('warning', 'Email sudah digunakan');

                        } else {
                            toast('warning', data);
                            console.log(data);
                        }
                    }
                })
            })

            $('#modal_ubah_karyawan').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('karyawan/proses_ubah') ?>',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if(data == '') {
                            data_karyawan.api().ajax.reload(null, true);
                            $('.modal').trigger('reset').modal('hide');
                            toast('success', 'Data karyawan sudah diupdate');

                        } else if(data == 'email_tersedia') {
                            toast('warning', 'Email sudah digunakan');

                        } else {
                            toast('warning', data);
                            console.log(data);
                        }
                    }
                })
            })
        </script>
    <?php endif ?>

    <?php if($uri1 == 'toko') : ?>
        <script>
            let data_toko = $('#data_toko').dataTable({
                pageLength: 50,
                ordering: false,
                serverSide: true,
                processing: true,
                ajax: {
                    type: 'post',
                    url: '<?= site_url('toko/load_data') ?>',
                    complete: function() {
                        $('.hps').on('click', function(e) {
                            e.preventDefault();
                            let text = $(this).data('text');
                            let href = $(this).attr('href');
                            hps(href, text, data_toko);
                        });                         

                        $('.btn_ubah_toko').on('click', function() {
                            let id = $(this).data('id');
                            $('#modal_ubah_toko .modal-content').html(__modal_loading());

                            $.get({
                                url: '<?= site_url('toko/form_ubah/') ?>' + id,
                                success: function(data) {
                                    $('#modal_ubah_toko .modal-content').html(data);
                                }
                            })
                        });                      

                    }
                },
                columnDefs: [
                    {
                        className: 'text-center wc-50',
                        targets: [0]
                    },
                ]
            });

            $('#modal_tambah_toko').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('toko/tambah_toko') ?>',
                    data: $(this).serialize(),

                }).done(function() {
                    data_toko.api().ajax.reload(null, true);
                    $('.modal').trigger('reset').modal('hide');
                    toast('success', 'Toko baru sudah ditambahkan');
                });
            });
            
            $('#modal_ubah_toko').on('submit', function(e) {
                e.preventDefault();
                $.post({
                    url: '<?= site_url('toko/ubah_toko') ?>',
                    data: $(this).serialize(),

                }).done(function() {
                    data_toko.api().ajax.reload(null, true);
                    $('.modal').trigger('reset').modal('hide');
                    toast('success', 'Data toko sudah diupdate');
                });
            });

        </script>
    <?php endif ?>

    <script>
        select2();
        $('#pelanggan_cek').select2({
            theme: 'bootstrap4'
        });    

        function select2() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        }
        

        let data_keluar = $('#data_keluar').dataTable({
            pageLength: 50,
            ordering: false,
            serverSide: true,
            processing: true,
            ajax: {
                type: 'post',
                url: '<?= site_url('dashboard/load_data_keluar') ?>'
            },
            columnDefs: [
                {
                    className: 'text-center wc-50',
                    targets: [0]
                },
                {
                    className: 'w-85',
                    targets: [1]
                }
            ]
        });

        function toast(icon, title) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                timer: 1500,
                showConfirmButton: false,
            })
            Toast.fire({
                icon: icon,
                title: title
            });
        }

        function hps(url, text, tb) {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                html: text,
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if(result.value) {
                    $.get(
                        url, 
                        function() {
                            toast('success', 'Data berhasil dihapus');
                            tb.api().ajax.reload(null, true);                     
                        }
                    );
                }
            });
        }   

        function __btn_loading() {
            let html =  '<span class="spinner-border spinner-border-sm" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                        '</span>';   
                        
            return html;
        }

        function __modal_loading() {
            let html =  '<div class="modal-body text-center p-5">' +
                            '<h5 class="mb-3">Memuat Data</h5>' +
                            '<div class="spinner-border text-primary" role="status">' +
                                '<span class="sr-only">Loading...</span>' +
                            '</div>' +    
                        '</div>'
            return html;
        } 

        $('.modal').on('shown.bs.modal', function() {
            $('.modal .form-control')[0].focus();
        })

        $('.__btn_showhide_nav').on('click', function() {
            $('body').toggleClass('mini-sidebar');            
        });

        $(window).on('load', function() {
            $('.loading').fadeOut('fast', function() {
                $('body').removeClass('o-hidden');
            });
        });

        if($('.navInfo').children('ul').length > 0) {
            $('main').css(
                {
                    paddingTop: '115px'
                }
            );
        }

        $('.logOut a').on('click', function(e) {
            e.preventDefault();
            let href = $(this).attr('href');
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Anda akan meninggalkan halaman ini',
                showCancelButton: true,
                confirmButtonText: 'Keluar',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger mr-3',
                    cancelButton: 'btn btn-light'
                },
                buttonsStyling: false
            }).then(
                result => {
                    if(result.isConfirmed) {
                        window.location.href = href
                    }
                }
            )
        });

        $('#inp_file').on('change', function() {
            let file = this.files[0];
            $('#view_file_name').html(
                'Nama file: ' + file.name + '<br>' +
                'Ukuran: ' + Math.floor(parseInt(file.size) / 1000) + ' KB'
            );
        });

        function view_img(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.view_foto').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }

        }

        inp_foto();
        function inp_foto() {
            $('.inp_foto').on('change', function() {
                let berkas = this.files[0];
                if(this.value != '') {
                    if(berkas.size > 1024000) {
                        toast('warning', 'Ukuran file lebih dari 1 MB');
                        $(this).val('');

                    } else {
                        view_img(this);
                    }
                }
            });
        }

        $('._uang').on('input', function() {
            $(this).val(format(this.value));
        });

        function format(angka) {
            let number_string = angka.toString().replace(/[^0-9]/g, '');
            let split	      = number_string.split(',');
            let sisa 	      = split[0].length % 3;
            let rupiah 	      = split[0].substr(0, sisa);
            let ribuan 	      = split[0].substr(sisa).match(/\d{3}/g);
                
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            return rupiah
        }
    </script>

</body>
</html>