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
		$id = str_replace('O', '/', $id);
		$detail 	= $this->jual->detail($id);
		$data_jual  = $this->jual->penjualan($id);
		$width 		= conf()->jenis_kertas_struk == 'HVS' ? '100%' : conf()->ukuran_kertas . 'mm';
		$pelanggan  = strlen($detail->nama_plg) > 0 ? $detail->nama_plg : 'Umum';

		$html = '
		<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Struk Belanja</title>
			<style>
    			@font-face {
    				font-family: verdana;
    				src: url("../../assets/vendor/font/fake-receipt/fake-receipt.ttf");
    				font-display: block;
					font-size: 14px;
    			}
    			* {
    				font-family: verdana;
    				font-size: 14px;
					margin-left: 0;
					margin-right:0;
					margin-top: 0;
					margin-bottom :0;
    			}
    			.print_area {
					width: 100mm; /* Adjusted for A5 width */
					margin: 0 auto; /* Center the content */
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
    				padding-bottom: 4px;
    			}
    			.belanjaan  tr:not(:first-child) th {
    				padding-top: 3px;
    				padding-bottom: 4px;
    			}
			</style>
		</head>
		<body>
			<div class="print_area">
				<header>
					<img src="'.base_url().'/upload/logo.jpg" style="width:140px;height: 60px;" alt="Store Logo"> 
					<p style="padding-bottom: 5px;"> '.admin()->nama_toko.'</p>
					<p style="border-bottom: 1px dashed #000">'.admin()->alamat.' '.admin()->kecamatan.' '.admin()->kabupaten.' '.admin()->provinsi.' '.admin()->kode_pos.'</p>
				</header>
				<div class="nota">
					<strong>'.$id.'</strong>
					<p style="margin:0;padding:0">
					    <span style="float:left">
						    Chasier: '.$detail->nama_ksr.'  
					    </span><br>
						<span style="float:left">
						    Customer: '.$pelanggan.'  
					    </span><br>
					    <p style="text-align:center; padding-top: 5px;">
						    '.tgl(date('d M Y G:i', strtotime($detail->tgl_transaksi))).'
					    </p>
					    <span style="clear:both;float:none"></span>
					</p>
				</div>
				<table class="belanjaan">
					<tbody>
					';
					
					$total_jual = 0;
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
						$total_jual	+= (int) $jual->harga_jual;
						$hemat		 = (int) ($total_reg - $total_cart) + $detail->diskon;

						$html .= '
							<tr>
								<td style="width:50%">
									'.$jual->nama_brg.' <br>
									<small>'.$jual->sn_brg.'</small>
								</td>
								<td style="text-align:left;padding-left: 10px;padding-right: 10px;">
									'.$jual->jml.' Pcs
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
							<th style="text-align:left;">Sub Total</th>
							<th style="text-align:left;padding-left: 10px;padding-right: 10px;"></th>
							
							<th style="text-align:right;">'.nf($total_jual).'</th>
							<span style="clear:both;float:none"></span>
						</tr>
						<tr>
							<th style="text-align:left;">Jasa</th>
							<th></th>
							
							<th style="text-align:right;">'.nf($detail->jml_donasi).'</th>
							
						</tr>
						<tr>
							<th style="text-align:left;">Cashback</th>
							<th></th>
							
							<th style="text-align:right;">'.nf($detail->harga_cashback).'</th>
							
						</tr>
						<tr>
							<th style="text-align:left;">Diskon</th>
							
							<th></th>
							<th style="text-align:right;">'.nf($detail->diskon).'</th>
							
						</tr>

						<tr>
							<th style="text-align:left; padding-top: 15px;
							padding-bottom: 4px; ">Total</th>
							
							<th></th>
							<th style="text-align:right;padding-top: 15px;
							padding-bottom: 4px;">'.nf($detail->total_keranjang).'</th>
							
						</tr>


						
						<tr>
							<th style="text-align:left;">Tunai</th>
							
							<th></th>
							<th style="text-align:right;">'.nf($detail->tunai).'</th>
							
						</tr>

						<tr>
							<th style="text-align:left;">Kartu Kredit</th>
						
							<th></th>
							<th style="text-align:right;">'.nf($detail->kredit).'</th>
							
						</tr>

						<tr>
							<th style="text-align:left;">Kartu Debit</th>
							
							<th></th>
							<th style="text-align:right;">'.nf($detail->bank).'</th>
							
						</tr>
						';

						$html .= '
						<tr>
							<th style="text-align:left;">Kembalian</th>
						
							<th></th>
							<th style="text-align:right;">'.nf($detail->total_kembalian).'</th>
							
						</tr>
					</tfoot>
				</table>
				<div style="text-align:center;padding-top:20px;margin-bottom:0px; display: flex; justify-content: center; align-items: center;	">
					<img src="'.base_url().'/upload/qr.jpg" alt="Description of the image" width="100" height="100" style="margin-right: 10px;">
					<span>SCAN INI UNTUK TAU TENTANG DH STORE</span>
				</div>
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
        $mail->Host = 'mail.dhstore.id';
        $mail->SMTPAuth = true;
        $mail->Username = 'care@dhstore.id';
        $mail->Password = '@Mico7788!';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Atur alamat pengirim, penerima, subjek, dan isi pesan
        $mail->setFrom('care@dhstore.id', 'DH Store');
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
