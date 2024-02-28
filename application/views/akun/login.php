<?php 
    sudah_login();
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
    <link rel="shortcut icon" href="<?= base_url() ?>upload/logo.png" type="image/x-icon">

    <meta content="#4570ce" name="msapplication-navbutton-color">
    <meta content="#4570ce" name="apple-mobile-web-app-status-bar-style">
    <meta content="#4570ce" name="theme-color">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/font/fa/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/mod.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/auth.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/media.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/animasi.css">

</head>
<body>
    <div class="loading">
        <div class="__inline">
            <div class="circle"></div>            
            <div class="text">
                Memuat Data
            </div>
        </div>
    </div>
   
    <div class="auth-wrap">
        <div class="_header">
            <h2>
                Login
            </h2>
        </div>
        <div class="_body">
            <?php if($this->session->flashdata ('warning')) : ?>
                <div class="alert alert-warning mb-4">
                    <?= $this->session->flashdata ('warning') ?>
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif ?>

            <?php if($this->uri->segment (3)) : ?>
                <div class="alert alert-success mb-4">
                    Anda sudah keluar, silahkan login
                    <a class="close" href="<?= site_url('login') ?>">&times;</a>
                </div>
            <?php endif ?>

            <?php if(!empty($error)) : ?>
            <div class="alert alert-danger mb-4">
                <strong><i class="fa fa-exclamation-circle mr-1"></i> Login Gagal</strong>
                <p class="mb-0 mt-1"><?= $error ?></p>
                <button class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php endif ?>
            <form action="" method="post">
                <div class="form-group mb-4">
                    <input type="text" 
                           class="_field" 
                           placeholder="Username" 
                           name="username" 
                           value="<?= set_value('username') ?>"
                    >
                    <?= form_error ('username', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <input type="password" 
                           class="_field" 
                           placeholder="Password" 
                           name="password" 
                           value="<?= set_value('password') ?>"
                    >
                    <?= form_error ('password', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="mt-5">
                    <button class="_btn">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="mb-0">
                        Modal
                    </h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    modal
                </div>
                <div class="modal-footer">
                    footer
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/sweetalert/sweetalert2.all.min.js"></script>

    <script>
        $(window).on('load', function() {
            $('.loading').fadeOut('fast');
        });
    </script>

</body>
</html>