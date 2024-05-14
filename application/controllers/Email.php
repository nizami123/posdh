<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php'; // Sesuaikan dengan path Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email extends CI_Controller {
    function __construct () {
		parent::__construct ();
		belum_login();
		waktu_local();

		$this->load->model (
			[
				'm_penjualan' => 'jual',
				'm_pelanggan' => 'plg',
				'm_barang' 	  => 'brg',		
				'm_toko' 	  => 'toko'		
			]
		);
	}

    public function send_email($id) {

        $detail	= $this->jual->detail($id);
		$data_jual = $this->jual->penjualan($id);
        $width 		= conf()->jenis_kertas_struk == 'HVS' ? '100%' : conf()->ukuran_kertas . 'mm';

		$html = '
		<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Struk Belanja</title>
			<style>
    			@font-face {
    				font-family: receipt;
    				src: url("../../assets/vendor/font/fake-receipt/fake-receipt.ttf");
    				font-display: block;
    			}
    			* {
    				font-family: receipt;
    				font-size: 10px;
    			}
    			.print_area {
    				width: 80mm;
    			}
    			h1 {
    				padding: 0;
    				margin: 0;
    				font-size: 20px;
    				font-weigth: normal;
    			}
    			header p {
    				margin: 0;
    			}
    			header {
    				margin-bottom: 10px;
    				margin-top: 0px;
    				text-align: center;
    			}
    			table {
    				border-collapse: collapse;
    				border-top: 1px dashed #000;
    				width: 100% !important;
    			}						
    			table td {
    				padding-top: 7px;
    				vertical-align: top; 
    			}
    			.belanjaan {
    				margin-top: 20px;
    				width: 100% !important;
    			}
    			.belanjaan td {
    				padding-bottom: 3px;
    			}
    			
    			.belanjaan tfoot {
    				border-top: 1px dashed #000;
    				border-bottom: 1px dashed #000;
    			}
    			.belanjaan  tr:first-child th {
    				padding-top: 15px;
    				padding-bottom: 7px;
    			}
    			.belanjaan  tr:not(:first-child) th {
    				padding-top: 3px;
    				padding-bottom: 4px;
    			}
    			.belanjaan  tr:nth-child(2) th {
    				padding-top: 20px;
    			}
			</style>
		</head>
		<body>
			<div class="print_area">
				<header>
					<h1>'.admin()->nama_toko.'</h1>
					<p>'.admin()->alamat.' '.admin()->kecamatan.' '.admin()->kabupaten.' '.admin()->provinsi.'</p>
					<p> Kode Pos '.admin()->kode_pos.'</p>
				</header>
				<div class="nota">
					<strong>'.$id.'</strong>
					<p style="margin:0;padding:0">
					    <span style="float:left">
						    Kasir: '.$detail->nama_ksr.'  
					    </span>
					    <span style="float:right">
						    '.tgl(date('d M Y G:i', strtotime($detail->tgl_transaksi))).'
					    </span>
					    <span style="clear:both;float:none"></span>
					</p>
				</div>
				<table class="belanjaan">
					<tbody>
					';
					
					$total_reg  = 0;
					$total_cart  = 0;
					$tjml  		= 0;
					foreach($data_jual as $jual) {
						$harga_reg 	 = $jual->harga_jual;
						$harga 		 = $jual->harga_jual;
						$reg 	 	 = $harga_reg == '' ? '' : nf($harga_reg);
						$sub_reg 	 = $harga_reg == '' ? '' : nf($jual->jml * $harga_reg);
						$sub 		 = (int) $jual->jml * $harga;
						$tjml 		 += $jual->jml;
						$total_cart	+= (int) $sub;
						$total_reg	+= (int) $jual->jml;
						$hemat		 = (int) ($total_reg - $total_cart) + $detail->diskon;

						$html .= '
							<tr>
								<td>
									'.$jual->nama_brg.' <br>
									<small>'.$jual->sn_brg.'</small>
								</td>
								<td style="text-align:left;padding-left: 10px;padding-right: 10px;">
									'.$jual->jml.'
								</td>
								<td style="text-align:right">
									'.nf($jual->harga_jual).'
								</td>
								<td style="text-align:right; padding-left: 20px">
									'.nf($sub).'
								</td>
							</tr>
							';
						}

						$html .= '
					</tbody>
					<tfoot>
						<tr>
							<th style="text-align:left;">Harga</th>
							<th style="text-align:left;padding-left: 10px;padding-right: 10px;">'.$tjml.'</th>
							<th></th>
							<th style="text-align:right;">'.nf($detail->harga_jual).'</th>
						</tr>
						
						<tr>
							<th style="text-align:left;">Cashback</th>
							<th></th>
							<th></th>
							<th style="text-align:right;">'.nf($detail->harga_cashback).'</th>
							
						</tr>
						<tr>
							<th style="text-align:left;">Diskon</th>
							<th></th>
							<th></th>
							<th style="text-align:right;">'.nf($detail->diskon).'</th>
							
						</tr>
						
						<tr>
							<th style="text-align:left;">Total</th>
							<th></th>
							<th></th>
							<th style="text-align:right;">'.nf($detail->total_keranjang	).'</th>
							
						</tr>

						<tr>
							<th style="text-align:left;">Bayar</th>
							<th></th>
							<th></th>
							<th style="text-align:right;">'.nf($detail->bayar).'</th>
							
						</tr>
						';

						$html .= '
						<tr>
							<th style="text-align:left;">Kembalian</th>
							<th></th>
							<th></th>
							<th style="text-align:right;">'.nf($detail->total_kembalian - $detail->jml_donasi).'</th>
							
						</tr>
					</tfoot>
				</table>

				<div style="text-align:center;padding-top:20px;margin-bottom:0px;">
					Terima kasih sudah berkunjung
				</div>
			</div>
		</body>
		</html>
		';

        $mail = new PHPMailer(true);

        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.akira.id';
        $mail->SMTPAuth = true;
        $mail->Username = 'nizam@akira.id';
        $mail->Password = 'Lamongan123';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Atur alamat pengirim, penerima, subjek, dan isi pesan
        $mail->setFrom('nizam@akira.id', 'DH Store');
        $mail->addAddress($detail->email_pel);
        $subject = 'INVOICE PENJUALAN';
        $message = $html;
        $mail->isHTML(true);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        try {
            $mail->send();
			redirect('penjualan/riwayat');
        } catch (Exception $e) {
            echo 'Email not sent. Error: ' . $mail->ErrorInfo;
            return false;
        }
    }

}
