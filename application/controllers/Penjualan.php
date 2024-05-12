<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {
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

	function index () {
		$conf = [
			'tabTitle' 	=> 'Penjualan | ' . webTitle (),
			'idPelanggan' => $this->generateid(),
			'webInfo' 	=> '
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<a href="' . site_url('penjualan') . '" class="btn ' . ((!isset($_GET['status']) || empty($_GET['status'])) ? 'dashed bg-black' : 'dashed bg-white') . '">
							Transaksi
						</a>
                        <a href="'.site_url('penjualan?status=dp').'" class="btn ' . (isset($_GET['status']) && $_GET['status'] == 'dp' ? 'dashed bg-black' : 'dashed bg-white') . '">
                            DP
                        </a>
						<a href="'.site_url('penjualan?status=trade').'" class="btn ' . (isset($_GET['status']) && $_GET['status'] == 'trade' ? 'dashed bg-black' : 'dashed bg-white') . '">
                            Trade In
                        </a>
                        <a href="'.site_url('penjualan/riwayat').'" class="btn bg-white dashed">
                            Riwayat
                        </a>
                        
                    </div>
					<div class="text-right">
						<a href="#modal_info" data-toggle="modal" class="btn dashed bg-white">
							<i class="fa fa-info-circle mr-1"></i>
                            Info & Tutorial
                        </a>
					</div>
                </div>
			'
		];

		$this->layout->load('layout', 'penjualan/index', $conf);
	}

	function load_kode() {
		echo '<i class="fa fa-receipt mr-2"></i>' . $this->jual->kode();
	}

	function load_data_brg() {
		$list 	= $this->brg->data_brg('DESC', 'stok-1');
		$data 	= [];
		$no 	= $this->input->post('start');
		// print_r($list);die;
		foreach ($list as $item) { 
			$row   = [];
			$row[] = '
				<a href="" 
				   class="btn btn-secondary _add_cart"
				   data-nama="'.$item->nama_brg.'"
				   data-kode="'.$item->id_keluar.'"
				>
					<i class="fa fa-cart-plus"></i>
				</a>
			';
			$row[] = '
					<strong>'.$item->nama_brg.'</strong>
					<div>
						<small>
							<strong>'. $item->merk .'</strong>
							<span class="mx-2"> | </span>
							<strong>'. $item->jenis .'</strong>
							<span class="mx-2"> | </span>
							<strong>'. $item->sn_brg .'</strong>
						</small>
					</div>
				';
			$row[] = nf($item->harga_jual);
			$row[] = '<input style="width:100%" type="text" name="diskon" class="diskon_pro" id="diskon_produk">';
			$row[] = nf($item->harga_cashback);
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_brg(),
			"recordsFiltered"  => $this->brg->count_brg(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_data_plg() {
		$list = $this->plg->data_plg();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) {         
			$row   = [];
			$row[] = '
				<a href="" 
				   data-id="'.$item->id_plg.'" 
				   data-nama="'.$item->nama_plg.'" 
				   class="btn btn-secondary _add_user"
				>
					<i class="fa fa-user-plus"></i>
				</a>
			';
			$row[] = '<strong>'. $item->nama_plg . '</strong>';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->plg->count_all_plg(),
			"recordsFiltered"  => $this->plg->count_plg(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_data_ksr() {
		$list = $this->plg->data_ksr();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) {         
			$row   = [];
			$row[] = '
				<a href="" 
				   data-id="'.$item->id_ksr.'" 
				   data-nama="'.$item->nama_ksr.'" 
				   class="btn btn-secondary _add_user_ksr"
				>
					<i class="fa fa-user-plus"></i>
				</a>
			';
			$row[] = '<strong>'. $item->nama_ksr . '</strong>';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->plg->count_all_ksr(),
			"recordsFiltered"  => $this->plg->count_ksr(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_data_trade() {
		$list = $this->plg->data_trade();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) {         
			$row   = [];
			$row[] = '
				<a href="" 
				   data-id="'.$item->id_trade.'" 
				   data-nama="'.$item->nama_trade.'" 
				   data-harga="'.$item->harga.'" 
				   class="btn btn-secondary _add_user_trade"
				>
					<i class="fa fa-user-plus"></i>
				</a>
			';
			$row[] = '<strong>'. $item->nama_trade . '</strong>';
			$row[] = nf($item->harga) ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->plg->count_all_trade(),
			"recordsFiltered"  => $this->plg->count_trade(),
			"data"             => $data,
		];
		echo json_encode($output);
	}


	function load_data_bank() {
		$list = $this->plg->data_bank();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) {         
			$row   = [];
			$row[] = '
				<a href="" 
				   data-id="'.$item->id_bank.'" 
				   data-nama="'.$item->nama_bank.'" 
				   class="btn btn-secondary _add_user_bank"
				>
					<i class="fa fa-user-plus"></i>
				</a>
			';
			$row[] = '<strong>'. $item->nama_bank . '</strong>';
			$row[] = $item->no_rek ;
			$row[] = $item->nama_rek ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->plg->count_all_bank(),
			"recordsFiltered"  => $this->plg->count_bank(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_data_diskon() {
		$list = $this->plg->data_diskon();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) {         
			$row   = [];
			$row[] = '
				<a href="" 
				   data-id="'.$item->kode_diskon.'" 
				   data-nama="'.$item->nilai.'" 
				   data-tipe="'.$item->tipe.'" 
				   class="btn btn-secondary _add_user_diskon"
				>
					<i class="fa fa-user-plus"></i>
				</a>
			';
			$row[] = '<strong>'. $item->kode_diskon . '</strong>';
			$row[] = $item->tipe ;
			$row[] = nf($item->nilai) ;
			$row[] = $item->id_keluar ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->plg->count_all_diskon(),
			"recordsFiltered"  => $this->plg->count_diskon(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_data_toko() {
		$list = $this->toko->data_toko();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) {  
			$toko  = $item->id_toko  == admin()->id_toko ? '<span class="mx-2"> | </span><span> <i class="fa fa-dot-circle text-success"></i> Toko aktif
			</span>' : '';   
			$btn =  $item->id_toko  == admin()->id_toko ? '<button class="btn btn-success"><i class="fa fa-store"></i></button>' : '
				<a href="'.site_url('penjualan/pindah_toko/'.$item->id_toko).'" 
				data-nama="'.$item->nama_toko.'" 
				class="btn btn-secondary pindah_toko"
				>
					<i class="fa fa-sign-in-alt"></i>
				</a>
			';   
			$row   = [];
			$row[] = $btn;
			$row[] = '
				<strong>'. $item->nama_toko . '</strong>
				<div>
					<small>
						<strong class="text-primary"> 
							'. $item->jenis_toko . '
						</strong>
						'.$toko.'
					</small>
				</div>
			';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->toko->count_all(),
			"recordsFiltered"  => $this->toko->count(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function data_keranjang() {
		$data = $this->jual->data_keranjang();
		// print_r($data);die;
		if($data) {
			foreach($data as $item) {
				
				if ($item->diskon <> ''){
					$diskon = $this->db->query("SELECT nilai FROM tb_diskon WHERE kode_diskon = '".$item->diskon."' and kuota > 0")->result();
					if (empty($diskon[0]->nilai)){
						$diskon_nilai = 0;
					}else{
						$diskon_nilai =  $diskon[0]->nilai;
					}
				}else{
					$diskon_nilai = 0;
				}
				$harga     = $item->harga_jual - $diskon_nilai - $item->harga_cashback;
				$subharga  = $harga * $item->jml;
				$jml 	   = $item->jenis_penjualan == 'Grosir' ? $item->min_grosir : $item->jml;
				$min 	   = $item->jenis_penjualan == 'Grosir' ? $item->min_grosir : 1;
				
				$html = '
					<tr>
						<td style="width: 50px" class="text-center">
							<a href="'.site_url('penjualan/hps_keranjang/'.$item->id_keranjang).'" 
							   class="btn btn-danger hps_cart"
							>
								<i class="fa fa-trash"></i>
							</a>
						</td>
						<td>
							<p class="mb-0">
								<strong>
									'.$item->nama_brg.' 
								</strong> 
								<input type="hidden" name="id_keluar[]" value="'.$item->id_keluar.'">
							</p>
							<small>'.$item->sn_brg.'</small>					
						</td>
						<td class="text-right">
							<p class="mb-0">
								<strong>
									'.$item->jml.' 
								</strong> 
								<input type="hidden" name="jml[]" value="1">
							</p>
						</td>
						<td class="text-right">
							<strong >
								'.nf($item->harga_jual).'
							</strong>
							<input type="hidden" name="jual[]" value="'.$item->harga_jual.'">
						</td>
						<td class="text-right">
							<strong >
								'.nf($diskon_nilai).'
							</strong>
							<input type="hidden" name="diskon_nilai[]" value="'.$diskon_nilai.'">
							<input type="hidden" name="diskon_id[]" value="'.$item->diskon.'">
						</td>
						<td class="text-right">
							<strong >
								'.nf($item->harga_cashback).'
							</strong>
							<input type="hidden" name="cashback[]" value="'.$item->harga_cashback.'">
						</td>
						<td class="text-right">
							<strong class="_harga" 
									id="_harga_'.$item->sn_brg.'"
									data-harga="'.$harga.'" 
									data-min="1" 
									data-subharga="'.$subharga.'" 
							>
								'.nf($subharga).'
							</strong>
							<p class="mb-0">
								<small class="text-muted" id="harga_eceran_'.$item->sn_brg.'" style="text-decoration:line-through"></small>
							</p>
							<input type="hidden" id="harga_jual_'.$item->sn_brg.'" name="harga_jual[]" value="'.$harga.'">
						</td>
						
					</tr>                            
				';
				echo $html;
			}

		} else {
			$html = '
				<tr>
					<th colspan="7">
						<div class="p-5 text-center">
							<i class="fa fa-shopping-basket fa-4x text-danger"></i>
							<div class="mt-3">
								<strong>Keranjang Kosong</strong>
							</div>
						</div>
					</th>
				</tr>
			';
			echo $html;
		}

	}

	function tambah_keranjang() {
		$input = $this->input->post(null);
		$this->jual->tambah_keranjang ($input);
	}

	function tambah_keranjang_search() {
		$input = $this->input->post(null);
		$this->jual->tambah_keranjang_search ($input);
	}

	function update_jml() {
		$input = $this->input->post (null);
		$this->jual->update_jml($input);
		
		
	}

	function update_jml_cart() {
		$input = $this->input->post (null);
		$cart   = $this->db->get_where('tb_keranjang', ['id_keranjang' =>  $_POST['id']])->row();
		$brg  = $this->db->get_where('tb_barang', ['kode_brg' =>  $cart->kode_brg])->row();
		$upstok['stok_tersedia'] = $brg->stok_tersedia - $_POST['jml'];
		
		$this->db->update('tb_barang', $upstok, ['kode_brg' => $cart->kode_brg]);
		$this->db->update('tb_keranjang', ['jml' => $_POST['jml']], ['id_keranjang' => $_POST['id']]);
	}

	function hps_keranjang($id) {
		$this->jual->hps_keranjang($id);
	}

	function generateid(){
        $data['lastID'] = $this->db->query("select id_plg from tb_pelanggan order by id_plg desc limit 1")->result_array();
        if (!empty($data['lastID'][0]['id_plg'])) {
          $numericPart = isset($data['lastID'][0]['id_plg']) ? preg_replace('/[^0-9]/', '', $data['lastID'][0]['id_plg']) : '';
          $incrementedNumericPart = sprintf('%04d', intval($numericPart) + 1);
          $data['newID'] = 'DHCS-' . $incrementedNumericPart;
        }else {
          $data['newID'] = 'DHCS-0001';
        }
        return $data['newID'];
        
    }
	
	function kosongkan_keranjang() {
		echo $this->jual->kosongkan_keranjang();
	}

	function form_pembayaran() {
		$cek = $this->jual->data_keranjang();

		if ($this->input->post('status') == 'trade'){

		$trade = '	<div class="form-group">
			<label> Trade Barang </label>
			<div class="input-group">
				<input readonly class="form-control form-control-sm nama_trade" required>
				<input type="hidden" class="id_trade" name="id_trade" required>
				<div class="input-group-append">
					<a class="btn btn-sm bg-white border px-3" 
							href="#modal_data_trade" 
							data-toggle="modal"
					>
						<i class="fa fa-search"></i>
					</a>
				</div>
			</div>
			<input type="hidden" class="form-control form-control-sm jenis_trade" id="jenis_trade" name="jenis_trade" placeholder="0">
			<input type="hidden" min="0" class="form-control form-control-sm bg-secondary _trade" id="trade" name="trade" placeholder="0">
		</div>';
		}else{
			$trade = '';
		}

		if($cek) {
			$html = '
				<div class="form-group">
					<label> Pelanggan </label>
					<div class="input-group">
						<input readonly class="form-control form-control-sm nama_plg" value="Umum">
						<input type="hidden" value="Umum" class="id_plg" name="id_plg">
						<div class="input-group-append">
							<a class="btn btn-sm bg-white border px-3" 
									href="#modal_data_plg" 
									data-toggle="modal"
							>
								<i class="fa fa-search"></i>
							</a>
							<a class="btn btn-sm bg-white border px-3" 
									href="#modal_tambah_plg" 
									data-toggle="modal"
							>
								<i class="fa fa-plus"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label> Kasir </label>
					<div class="input-group">
						<input readonly class="form-control form-control-sm nama_ksr" required>
						<input type="hidden" class="id_ksr" name="id_ksr" required>
						<div class="input-group-append">
							<a class="btn btn-sm bg-white border px-3" 
									href="#modal_data_ksr" 
									data-toggle="modal"
							>
								<i class="fa fa-search"></i>
							</a>
						</div>
					</div>
				</div>

				'.$trade.'
				<div class="form-group">
					<label class="mr-2">Bayar</label>
					<div class="input-group input-group-sm ui-widget">
						<div class="input-group-prepend">
							<div class="input-group-text bg-white px-3">
								Rp
							</div>
						</div>
						<input type="text"  class="form-control form-control-sm bg-secondary _bayar" name="bayar">
					</div>					
				</div>
				<div class="form-group">
					<label> Cara Bayar </label>
					<div class="input-group">
						<input readonly class="form-control form-control-sm nama_bank" value="Tunai">
						<input type="hidden" value="Tunai" class="id_bank" name="id_bank">
						<div class="input-group-append">
							<a class="btn btn-sm bg-white border px-3" 
									href="#modal_data_bank" 
									data-toggle="modal"
							>
								<i class="fa fa-search"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label> Tipe Penjualan </label>
					<div class="input-group">
						<select class="form-control form-control-sm select2" name="tipe_penjualan">
						<option value="Offline">Offline</option>
						<option value="Online">Online</option>
						</select>
					</div>
				</div>
				
				<div class="mt-4">
					<button class="btn btn-primary w-100" disabled id="btn_simpan">
						Simpan
					</button>
				</div>
			';

		} else {
			$html = '
				<div class="form-group">
                    <label> Pelanggan </label>
                    <input disabled class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Bayar</label>
                    <input disabled class="form-control form-control-sm">
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary w-100" disabled>
                        Simpan
                    </button>
                </div>
			';
		}

		echo $html;
	}

	function pindah_toko ($id = null) {
        if($id) {
            $this->toko->pindah ($id);
            $sesi = [
                'sesi_toko'     => $id,
                'sesi_waktu'    => date('Y-m-d G:i:s'),
            ];
            $this->session->set_userdata ($sesi);
        }
    }

	function submit_cart() {
		$id_toko = admin()->id_toko;
		$kode  	 = $this->jual->kode();
		$input 	 = $this->input->post(null, true);
		$brg   	 = [];
		$diskon_total = 0;
		$jual_total = 0;
		$cashback_total = 0;
		foreach($input['id_keluar'] as $i => $v) {
			$id_keluar = $this->input->post('id_keluar['.$i.']');
			$jml 	  = $this->input->post('jml['.$i.']');
			$harga 	  = $this->input->post('harga_jual['.$i.']');
			$jual 	  = $this->input->post('jual['.$i.']');
			$diskon_id 	  = $this->input->post('diskon_id['.$i.']');
			$diskon_nilai 	  = $this->input->post('diskon_nilai['.$i.']');
			$cashback 	  = $this->input->post('cashback['.$i.']');
			if ($input['status'] == 'dp') {
				$cara_bayar = 'DP';
				$upstok['status']  = 4;
        		$this->db->update('tb_brg_keluar', $upstok, ['id_keluar' => $id_keluar]);
			}elseif ($input['status'] == 'trade') {
				$cara_bayar = 'Trade In';
			} else {
				if ($input['id_bank'] > 0) {
					$cara_bayar = 'Transfer';
				} else {
					$cara_bayar = 'Tunai';
				}
			}
			$brg[] = [
				'kode_penjualan' => $kode,
				'id_keluar' 	 => $id_keluar,
				'jml'			 => $jml,
				'harga_jual'	 => $jual,
				'harga_diskon'	 => $diskon_nilai,
				'harga_bayar'	 => $harga,
				'harga_cashback' => $cashback,
				'cara_bayar'	 => $cara_bayar,
				'id_bank'		 => $input['id_bank'],
				'id_diskon'		 => $diskon_id,
				'id_trade'		 => isset($input['id_trade']) ? $input['id_trade'] : '',
				'tipe_penjualan' => $input['tipe_penjualan']
			];

			$diskon_total = $diskon_total + $diskon_nilai;
			$jual_total = $jual_total + $jual;
			$cashback_total = $cashback_total + $cashback;

			$this->db->query("update tb_diskon set kuota = kuota - 1 , total_diskon = total_diskon - nilai
			where kode_diskon = '".$diskon_id."'");

		}


		$is_donasi = isset($input['is_donasi']) ? 1 : 0;
		$detail = [
			'kode_penjualan' 	=> $kode,
			'id_admin' 		 	=> admin()->id_admin,
			'total_kembalian'   => $input['total_kembalian'],
			'total_keranjang'   => $input['total_keranjang'],
			'bayar'      	 	=> intval(preg_replace("/[^0-9]/", "", $input['bayar'])),
			'diskon'      	 	=> $diskon_total,
			'cashback'			=> $cashback_total,
			'total_penjualan'	=> $jual_total,
			'id_plg'      	 	=> $input['id_plg'],
			'id_ksr'      	 	=> $input['id_ksr'],
			'jenis_diskon'  	=> '',
			'is_donasi'  		=> $is_donasi,
			'jml_donasi'  		=> isset($input['is_donasi']) ? $input['jml_donasi'] : 0,
			'tgl_transaksi' 	=> date('Y-m-d G:i:s'),
			'id_toko' 			=> $id_toko
		];

		$this->jual->submit_keranjang($brg);
		$this->jual->submit_detail($detail);

		if($is_donasi == 1) {
			$kd_donasi = 'DNI' . date('ymdGis');
			$data_donasi = [
				'invoice' => $kd_donasi,
				'tgl_donasi' => date('Y-m-d G:i:s'),
				'jml' => $_POST['jml_donasi']
			];
			$this->db->insert('tb_donasi', $data_donasi);
		}

		echo $kode; 
	}

	function struk($id = null) {
		$detail 	= $this->jual->detail($id);
		$data_jual  = $this->jual->penjualan($id);
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
							<th style="text-align:left;">Total Belanja</th>
							<th style="text-align:left;padding-left: 10px;padding-right: 10px;">'.$tjml.'</th>
							<th></th>
							<th style="text-align:right;">'.nf($detail->total_keranjang).'</th>
						</tr>
						
						<tr>
							<th style="text-align:left;">Bayar</th>
							<th style="text-align:right;">'.nf($detail->bayar).'</th>
							<th></th>
							<th></th>
						</tr>
						
						<tr>
							<th style="text-align:left;">Cashback</th>
							<th style="text-align:right;">'.nf($detail->harga_cashback).'</th>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<th style="text-align:left;">Diskon</th>
							<th style="text-align:right;">'.nf($detail->diskon).'</th>
							<th></th>
							<th></th>
						</tr>
						';

						if($hemat > 0) {
							$html .= '
								<tr>
									<th style="text-align:left;">
										Hemat
									</th>
									<th style="text-align:right;">
										'.nf($hemat).'
									</th>
									<th></th>
							        <th></th>
								</tr>
							';
						}

						$html .= '
						<tr>
							<th style="text-align:left;">Kembalian</th>
							<th style="text-align:right;">'.nf($detail->total_kembalian - $detail->jml_donasi).'</th>
							<th></th>
							<th></th>
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

		echo $html;
		echo '<script>print()</script>';
	}

	function struk2($id = null) {
		$detail 	= $this->jual->detail($id);
		$data_jual  = $this->jual->penjualan($id);
		$width 		= conf()->jenis_kertas_struk == 'HVS' ? '100%' : conf()->ukuran_kertas . 'mm';
		
		if($detail) {
			$nama_plg = $detail->nama_plg ? $detail->nama_plg : 'Umum';
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
								font-size: 12px;
							}
							.print_area {
								width: '.$width.';
							}
							h1 {
								padding: 0;
								margin: 0 0 2px;
								font-size: 20px;
								font-weigth: normal;
							}
							header {
								text-align: center;
								margin-bottom: 10px;
								margin-top: 0px;
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
								margin-top: 10px;
								width: 100% !important;
							}
							.belanjaan td {
								padding-bottom: 3px;
							}
							
							.belanjaan tfoot {
								border-top: 1px dashed #000;
								border-bottom: 1px dashed #000;
							}

							@media print {
								@page {
									margin-left: 12px;
								}
							
							
							}
						</style>
					</head>
					<body>
						<div class="print_area">
							<header>
								<h1>'.admin()->nama_toko.'</h1>
								<small>'.admin()->alamat.'</small>
							</header>
							<table>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td>'.tgl(date('d M Y G:i', strtotime($detail->tgl_transaksi))).'</td>
								</tr>
								<tr>
									<td>Pelanggan</td>
									<td>:</td>
									<td>'.$nama_plg.'</td>
								</tr>
								<tr>
									<td>Kasir</td>
									<td>:</td>
									<td>'.$detail->nama_admin.'</td>
								</tr>
							</table>
							<table class="belanjaan w-100">
								<tbody>
						';
							$total_reg  = 0;
							$total_cart  = 0;
							foreach($data_jual as $jual) {
								$harga_reg 	 = $jual->harga_jual == $jual->harga_eceran ? '' : $jual->harga_eceran;
								$harga 		 = $jual->harga_jual;
								$reg 	 	 = $harga_reg == '' ? '' : nf($harga_reg);
								$sub_reg 	 = $harga_reg == '' ? '' : nf($jual->jml * $harga_reg);
								$sub 		 = (int) $jual->jml * $harga;
								$total_cart	+= (int) $sub;
								$total_reg	+= (int) $jual->jml * $jual->harga_eceran;
								$hemat		 = (int) ($total_reg - $total_cart) + $detail->diskon;
	
								$html .= '
									<tr>
										<td>
											'.$jual->nama_brg.'
											<div style="margin-top: 1px;">
												'.$jual->jml.' x '.nf($harga).'
											</div>
										</td>
										<td style="width: 80px;text-align:right;">
											'.nf($sub).'
										</td>
									</tr>
								';
							}
							
	
						$html .= '
									
								</tbody>
								<tfoot>
									<tr>
										<td style="text-align:right;">
											Total Belanja
										</td>
										<td style="text-align:right;">
											'.nf($detail->total_keranjang).'
										</td>
									</tr>
									<tr>
										<td style="text-align:right;">
											Diskon
										</td>
										<td style="text-align:right;">
											'.nf($detail->diskon).'
										</td>
									</tr>
									<tr>
										<td style="text-align:right;">
											Bayar
										</td>
										<td style="text-align:right;">
											'.nf($detail->bayar).'
										</td>
									</tr>
									<tr>
										<td style="text-align:right;">
											Kembalian
										</td>
										<td style="text-align:right;">
											'.nf($detail->total_kembalian - $detail->jml_donasi).'
										</td>
									</tr>
									';

									if($hemat > 0) {
										$html .= '
											<tr>
												<td style="text-align:right;">
													Hemat
												</td>
												<td style="text-align:right;">
													'.nf($hemat).'
												</td>
											</tr>
										';
									}
									
								$html .= '
								</tfoot>
							</table>
							<div style="text-align:center;padding-top:10px;margin-bottom:0px;">
								Terima kasih sudah berkunjung
							</div>
							
						</div>
					</body>
				</html>
			';
			
			echo $html;
			echo '<script>print()</script>';
		}
	}

	function riwayat() {
		$conf = [
			'tabTitle' 	=> 'Riwayat Penjualan | ' . webTitle(),
			'webInfo' 	=> ''
		];
		$this->layout->load('layout', 'penjualan/riwayat', $conf);
	}

	function load_data_riwayat() {
		$list = $this->jual->data_riwayat(null);
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$nama_plg = $item->id_plg ? $item->nama_plg : 'Umum';
			$jml = $this->jual->cek_jml_jual($item->kode_penjualan);
			$email = '';
			if ($item->status_penjualan == 0){
				$status_penjualan = '<span class="label label-warning">Menunggu Konfirmasi</span>';
				$hapus = '';
				$lunas = '';
				$cetak = '';
			}else if ($item->status_penjualan == 1){
				$status_penjualan = '<span class="label label-success">DP Konfirmasi</span>';
				$lunas = '<a href="' . site_url('penjualan/lunas/' . $item->kode_penjualan) . '" class="badge badge-success border btn-cetak-inv">Lunasi</a>';
				$hapus = '';
				if (strlen($item->email_pel) > 0){
					$email = '<a href="' . site_url('penjualan/lunas/' . $item->kode_penjualan) . '" class="badge badge-success border btn-cetak-inv">Email</a>';
				}
				$cetak = '<a href="' . site_url('penjualan/struk/' . $item->kode_penjualan) . '" target="_blank" class="badge badge-light border btn-cetak-inv">Cetak struk</a>';
			}else if ($item->status_penjualan == 2){
				$status_penjualan = '<span class="label label-success">Sudah Dikonfirmasi</span>';
				$hapus = '';
				$lunas = '';
				if (strlen($item->email_pel) > 0){
					$email = '<a href="' . site_url('email/send_email/'. $item->kode_penjualan) . '" class="badge badge-success border btn-cetak-inv">Email</a>';
				}
				$cetak = '<a href="' . site_url('penjualan/struk/' . $item->kode_penjualan) . '" target="_blank" class="badge badge-light border btn-cetak-inv">Cetak struk</a>';
			}else{
				$status_penjualan = '<span class="label label-danger">Ditolak</span>';
				$hapus = '<a href="'.site_url('penjualan/hps_riwayat/'.$item->kode_penjualan).'" data-text="Riwayat belanja <strong>'.$item->kode_penjualan.'</strong> akan dihapus dari daftar" class="badge badge-danger hps">
				Hapus</a> ';
				$lunas = '';
				$cetak = '';
			}
			$aksi 	  = '
				<div class="mt-2">
					'.$lunas.'
					'.$hapus.'
					<a href="#modal_detail_riwayat" data-toggle="modal" data-id="'.$item->kode_penjualan.'" class="badge badge-secondary btn_detail_riwayat">
						Detail
					</a>                                        
					'.$cetak.'    
					'.$email.'    
					<span class="mx-2"> | </span>                                     
					<a href="'.site_url('penjualan/retur/tambah/'.$item->kode_penjualan).'" class="badge badge-light border">
						Retur
					</a>   
				</div>
			';				
			
			$no++;
			$row    = [];
			$row[]  = $no;
			$row[]  = $item->tgl_transaksi;
			$row[]  = '
				<strong>'. $nama_plg.'</strong>
				<div>
					<small class="text-muted">
						<span>'.$item->kode_penjualan.'</span>
						<span class="mx-2"> | </span>
						<span>'.$jml.' Barang</span>
					</small>
				</div>
			';
			$row[]  = $item->cara_bayar;
			$row[]  = '
				<strong>'. $item->nama_bank.'</strong>
				<div>
					<small class="text-muted">
						<span>'.$item->no_rek.'</span>
						<span class="mx-2"> | </span>
						<span>'.$item->nama_rek.'</span>
					</small>
				</div>
			';
			$row[]  = $status_penjualan;
			$row[]  = $aksi;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->jual->count_all_riwayat(),
			"recordsFiltered"  => $this->jual->count_riwayat(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_detail_riwayat($id = null) {
		$jual = $this->jual->penjualan($id);
		$detail = $this->jual->detail($id);
		$nama_plg = $detail->id_plg ? $detail->nama_plg : 'Umum';

		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Riwayat
                    </h5>
                    <small>Riwayat Transaksi Penjualan</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
		';

		if($jual) {
			$html .= '
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-sm table-borderless">
							<tr>
								<td style="width: 130px">Kode Penjualan</td>
								<td style="width: 20px">:</td>
								<th>'.$detail->kode_penjualan.'</th>
							</tr>
							<tr>
								<td>Pelanggan</td>
								<td>:</td>
								<th>'.$nama_plg.'</th>
							</tr>
							<tr>
								<td>Kasir</td>
								<td>:</td>
								<th>'.$detail->nama_ksr.'</th>
							</tr>
						</table>
					</div>
					<h6>
						Detail Belanjaan
					</h6>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="text-center">
								<th style="width: 50px">No</th>
								<th>Item</th>
								<th style="width: 110px">Jml</th>
								<th style="width: 130px">Harga</th>
							</thead>
							<tbody>
		';
					foreach($jual as $no => $item) {
						$no++;
						$harga = $item->harga_jual;
						$subharga = $harga * $item->jml;
						$html .= '
							<tr>
								<td class="text-center">
									'.$no.'
								</td>
								<td>
									<strong>
										'.$item->nama_brg.'
									</strong>
								</td>
								<td class="text-center">'.$item->jml.'</td>
								<td class="text-right">'.nf($subharga).'</td>
							</tr>
						';
					}

		if ($jual[0]->cara_bayar == 'DP'){
			$table = '<tr>
				<th class="text-right" colspan="3">Sisa Belum Dibayar</th>
				<th class="text-right text-primary">'.nf($detail->total_keranjang - $detail->diskon - $detail->bayar).'</th>
			</tr>';
		}else{
			$table = '<tr>
				<th class="text-right" colspan="3">Kembalian</th>
				<th class="text-right text-primary">'.nf($detail->total_kembalian).'</th>
			</tr>';
		}

		
		if ($jual[0]->cara_bayar == 'Trade In'){
			$harga = $this->db->query("select * from tb_brg_keluar where id_keluar = ".$jual[0]->id_trade)->row();
			$trade = '<tr>
				<th class="text-right" colspan="3">Harga Barang</th>
				<th class="text-right text-primary">'.nf($harga->hrg_hpp).'</th>
			</tr>';
		}else{
			$trade = '';
		}
		$html .= '
						</tbody>  
						<tfoot>
							<tr>
								<th class="text-right" colspan="3">Total Belanja</th>
								<th class="text-right">'.nf($detail->total_keranjang).'</th>
							</tr>
							'.$trade.'
							<tr>
								<th class="text-right" colspan="3">Diskon</th>
								<th class="text-right text-danger">'.nf($detail->diskon).'</th>
							</tr>
							<tr>
								<th class="text-right" colspan="3">Bayar</th>
								<th class="text-right">'.nf($detail->bayar).'</th>
							</tr>
							'.$table.'
						</tfoot>                      
					</table>
				</div>
			</div>	
            <div class="modal-footer">
                <strong>
					'.tgl(date('d M Y G:i', strtotime($detail->tgl_transaksi))).'
                </strong>
            </div>
		';

		} else {
			$html .= '
				<div class="modal-body text-center py-5">
					<i class="fa fa-box-open fa-4x text-danger"></i>
					<h6 class="mb-0 mt-3">Tidak ada riwayat</h6>
				</div>
			';
		}

		echo $html;
	}

	function hps_riwayat($id = null) {
		$this->jual->hps_riwayat($id);
	}

	function retur($p = null, $id = null) {
		$conf = [
			'tabTitle' 	=> 'Retur Penjualan | ' . webTitle(),
			'webInfo' => '
				<div class="d-flex justify-content-between align-items-center">
                    <div>                        
                        <a href="'.site_url('penjualan').'" class="btn bg-white dashed">
                            <i class="fa fa-shopping-basket"></i>
                        </a>
						<a href="'.site_url('penjualan/riwayat').'" class="btn bg-white dashed">
                            Riwayat
                        </a>
                    </div>
                </div>
			',
			'data_riwayat' => $id ? $this->jual->penjualan($id) : null			
		];
		if(admin()->level != 'Admin') {
			$this->layout->load('layout', 'penjualan/retur', $conf);

		} else {
			$this->load->view('404');
		}
	}

	function load_data_retur() {
		$list = $this->jual->data_retur();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 	
			$jenis = $item->jenis_retur == 'refund' ? 'Uang kembali ' . nf($item->uang_kembali) : 'Ganti baru';
			$keterangan = $item->keterangan ? $item->keterangan : '-';
			$aksi 	 = '
				<div class="mt-2">                                        
					<a href="'.site_url('penjualan/hps_retur/'.$item->id_retur).'" 
					   data-text="<strong>'.$item->nama_brg.'</strong> akan dihapus dari daftar" 
					   class="badge badge-danger hps"
				>
						Hapus
					</a> 
				</div>
			';
			$no++;
			$row    = [];
			$row[]  = $no;
			$row[]  = '
				<strong>
					'.$item->nama_brg.'
				</strong>
				<div>
					<small class="text-muted">
						<span>'.tgl(date('d M Y G:i', strtotime($item->tgl_retur))).'  </span>
						<span class="mx-2"> | </span>
						<span>Jml: '.$item->jml.' </span>
						<span class="mx-2"> | </span>
						<span> '.$jenis.'</span>
						<span class="mx-2"> | </span>
						<span>Ket: '.$keterangan.' </span>
					</small>
				</div>
			' . $aksi;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->jual->count_all_retur(),
			"recordsFiltered"  => $this->jual->count_retur(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function submit_retur() {
		$id_toko = admin()->id_toko;
		$input   = $this->input->post(null, true);
		$data	 = isset($input['check']) ? $input['check'] : [];
		$kode    = $this->input->post('kode');
		$brg 	 = [];
		$total   = 0;

		if($data) {
			foreach($data as $item) {
				if($this->input->post('jenis_retur['.$item.']') == 'refund') {
					$total += $this->input->post('harga['.$item.']') * $this->input->post('jml['.$item.']');
					$this->jual->update_jml_penjualan($item, $this->input->post('jml['.$item.']'));
				}

				$brg[] = [
					'kode_transaksi'  => $kode,
					'kode_brg' 		  => $this->input->post('kode_brg['.$item.']'),
					'jml' 			  => $this->input->post('jml['.$item.']', true),
					'keterangan' 	  => $this->input->post('ket['.$item.']', true),
					'jenis_retur' 	  => $this->input->post('jenis_retur['.$item.']'),
					'id_admin' 	  	  => admin()->id_admin,
					'id_toko' 	  	  => admin()->id_toko,
					'uang_kembali'    => $total, 
				];			
				
			}

			$this->jual->update_detail_bayar($kode, $total);
			$this->jual->submit_retur($brg);
			
		} else {
			echo 'empty';
		}

	}

	function hps_retur($id = null) {
		$this->jual->hps_retur($id);
	}
}
