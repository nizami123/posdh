<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            width: 100%;
        }

        .header, .footer {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .item-table th, .item-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .item-table th {
            background: #eee;
        }

        .info-pelanggan, .total-section {
            margin-top: 10px;
        }

        .total-section td {
            padding: 3px;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .terbilang {
            font-style: italic;
            margin-top: -30px;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            body {
                width: 95%;
                height: 148mm; /* setengah dari A4 (297mm) */
                overflow: hidden;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <table>
        <tr>
            <td style="width: 8%;">
                <img src="<?=base_url()?>assets/images/logo/logo-icon.png" alt="Logo" style="max-width: 100px;">
            </td>
            <td style="width: 52%;">
                <strong>H3T OFFICE</strong><br>
                SIDOTOPO WETAN BARU 2/33<br>
                Email : h3h3h3@gmail.com<br>
                NO TELEPON : 03137390409, 081333466614 <br>
                http://www.h3tcomputer.com
            </td>
            <td style="width: 40%; text-align: right;">
                <table>
                    <tr>
                        <td><strong>No. Nota</strong></td>
                        <td>: <?= $header->kode_penjualan ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td>: <?= date('d M Y', strtotime($header->tgl_transaksi)) ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <h4 style="text-align:center;">NOTA PENJUALAN</h4>
</div>

<div class="info-pelanggan">
    <strong>Kepada Yth:</strong><br>
    <?= $header->nama_plg ?><br>
    <?= $header->no_ponsel ?><br>
    <?= nl2br($header->alamat) ?>
</div>

<table class="item-table" style="margin-top:10px;">
    <thead>
        <tr>
        <th style="width:5%;">No</th>
            <th>Nama Barang</th>
            <th style="width:5%;">Garansi</th>
            <th style="width:5%;">Qty</th>
            <th style="width:12%;">Harga</th>
            <th style="width:12%;">Diskon</th>
            <th style="width:12%;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    $subtotal = 0;
    foreach ($items as $item):
        $diskon_rp = ($item['harga_diskon'] ?? 0);
        $harga_asli = $item['harga_jual'];
        $harga_akhir = $harga_asli - $diskon_rp;
        $total_item = $harga_akhir * $item['jml'];
        $subtotal += $total_item;
    ?>
    <tr>
        <td style="text-align: center;"><?= $no++ ?></td>
        <td><?= $item['nama_brg'] ?></td>
        <td></td>
        <td style="text-align: center;"><?= $item['jml'] ?></td>
        <td style="text-align: right;"><?= number_format($harga_asli, 0, ',', '.') ?></td>
        <td style="text-align: right;"><?= number_format($diskon_rp, 0, ',', '.') ?></td>
        <td style="text-align: right;"><?= number_format($total_item, 0, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!empty($header->jasa)): ?>
    <tr>
        <td colspan="7" style="font-size: 11px; color: #555;">
            Catatan : <?= nl2br($header->jasa) ?>
        </td>
    </tr>
    <?php endif; ?>
</tbody>

</table>

<table style="margin-top: 10px; width: 100%;">
    <tr>
        <td style="width: 60%; vertical-align: top;">
            <strong>Keterangan:</strong><br>
            <span>
                1. Masa garansi terhitung sejak tanggal pembelian <br>
                2. Garansi tidak berlaku jika barang mengalami cacat fisik, terbakar dan kerusakan yang disebabkan oleh salah pemakaian <br>
                3. Kami tidak bertanggungjawab atas software yang terinstall di hardware <br>
                4. Barang yang sudah dibeli tidak dapat dikembalikan/ditukar kecuali ada perjanjian terlebih dahulu
            </span>
        </td>
        <td style="width: 40%;">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align:right;"><strong>Subtotal:</strong></td>
                    <td style="text-align:right; width: 30%;">
                        <?= number_format($header->total_keranjang, 0, ',', '.') ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right;"><strong>Diskon:</strong></td>
                    <td style="text-align:right;">
                        - <?= number_format($header->diskon, 0, ',', '.') ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right;"><strong>Total:</strong></td>
                    <td style="text-align:right;"><strong>
                        <?= number_format($header->total_penjualan, 0, ',', '.') ?>
                    </strong></td>
                </tr>
                <?php if (!empty($bank->total)) { ?>
                <tr>
                    <td style="text-align:right;"><strong>Pembayaran Via:</strong></td>
                    <td style="text-align:right;"><strong>
                        Indodana <?= number_format($bank->total, 0, ',', '.') ?>
                    </strong></td>
                </tr>
                <?php } ?>
            </table>

            <!-- Tanda Tangan -->
            <table style="margin-top: 50px; width: 100%; text-align: center;">
                <tr>
                    <td style="width: 50%;">
                        Pembeli,
                        <br><br><br><br> <!-- Ruang untuk tanda tangan -->
                        (...................................)
                    </td>
                    <td style="width: 50%;">
                        Hormat Kami,
                        <br><br><br><br> <!-- Ruang untuk tanda tangan -->
                        (...................................)
                    </td>
                </tr>
            </table>
            <!-- End Tanda Tangan -->

        </td>
    </tr>
</table>


<script>
    window.print();
</script>

</body>
</html>
