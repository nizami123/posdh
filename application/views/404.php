<?php 
    $uri1 = $this->uri->segment(1);
    $uri2 = $this->uri->segment(2);
    $uri3 = $this->uri->segment(3);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tag -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- title -->
    <title>404 | Page Not Found</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>upload/logo.png" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/font/fa/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/mod.css">

    <style>
        body {
            background-color: var(--light);
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        .wrap {
            background-color: #fff;
            padding: 30px 20px 20px;
            border-radius: 1rem;
            width: 100%;
            max-width: 420px;
        }

    </style>

</head>
<body>

   <div class="wrap">
       <div class="body text-center">
           <i class="far fa-sad-cry fa-5x text-danger"></i>
           <h2 class=" mt-4 text-danger">404</h2>
           <p>Halaman tidak ditemukan</p>
            <a href="<?= site_url() ?>" class="btn btn-secondary px-4">
                Dashboard
            </a>
       </div>
   </div>

    <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>