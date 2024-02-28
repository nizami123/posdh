<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	function __construct() {
		parent::__construct();
		belum_login();
		waktu_local();

		$this->load->model('m_barang', 'brg');
		$this->load->model('m_pelanggan', 'plg');
		$this->load->model('m_penjualan', 'jual');
		$this->load->model('m_laporan', 'lap');
	}

	function index() {
		$conf = [
			'tabTitle' 	=> 'Laporan Stok Barang | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					Stok Barang
				</span>
			',
			'data' => $this->lap->stok_brg()
		];
		$this->layout->load('layout', 'laporan/stok_brg', $conf);

		$level  = $this->session->userdata('sesi_level');
		if($level == 'Kasir') {
			redirect('laporan/penjualan');
		}
	}

	function donasi($tglm = '', $tgls = '') {
		$level  = $this->session->userdata('sesi_level');
		if($level == 'Admin') {
			$this->load->view('404');
		} else {
			if($tglm) {
				$this->db->where('DATE(tgl_donasi) >=', $tglm);
				$this->db->where('DATE(tgl_donasi) <=', $tgls);
			}
			$data = $this->db->get('tb_donasi')->result();
			$conf = [
				'tabTitle' 	=> 'Laporan Donasi | ' . webTitle(),
				'webInfo' => '
					<strong>
						Laporan
					</strong>
					<span>
						Donasi
					</span>
				',
				'data' => $data
			];
			$this->layout->load('layout', 'laporan/donasi', $conf);
		}
	}

	function brg_masuk($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Barang Masuk | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					Barang Masuk
				</span>
			',
			'data' => $this->lap->brg_masuk($mulai, $selesai)
		];
		if(admin()->level != 'Kasir') {
			$this->layout->load('layout', 'laporan/brg_masuk', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function brg_keluar($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Barang keluar | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					Barang keluar
				</span>
			',
			'data' => $this->lap->brg_keluar($mulai, $selesai)
		];

		if(admin()->level != 'Kasir') {
			$this->layout->load('layout', 'laporan/brg_keluar', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function penjualan($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Penjualan  | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					Penjualan
				</span>
			',
			'data' => $this->lap->penjualan($mulai, $selesai)
		];

		if(admin()->level != 'Admin') {
			$this->layout->load('layout', 'laporan/penjualan', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function terlaris($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Penjualan Terlaris  | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					Penjualan Terlaris
				</span>
			',
			'data' => $this->lap->terlaris($mulai, $selesai)
		];

		if(admin()->level != 'Admin') {
			$this->layout->load('layout', 'laporan/terlaris', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function load_lap_jual() {
		$mulai    = $this->input->post('mulai') ? $this->input->post('mulai') : null;
		$selesai  = $this->input->post('selesai') ? $this->input->post('selesai') : null;
		
		$list 	=  $this->lap->penjualan($mulai, $selesai);

		$data 	= [];
		$no 	= $this->input->post('start');

		foreach ($list as $item) { 
			$plg = $item->nama_plg ? $item->nama_plg : 'Umum';
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = tgl(date('d/m/Y', strtotime($item->tgl_transaksi)));
			$row[] = $item->kode_penjualan;
			$row[] = $plg;
			$row[] = nf($item->total_keranjang);
			$row[] = $item->nama_admin;
			$row[] = '
				<a href="#modal_detail" data-toggle="modal" class="btn btn-light border btn_detail" data-id="'.$item->kode_penjualan.'">
					<i class="fa fa-eye"></i>
				</a>
			';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->lap->count_jual($mulai, $selesai),
			"recordsFiltered"  => $this->lap->count_all_jual($mulai, $selesai),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_detail_jual($id = null) {
		$jual = $this->jual->penjualan($id);
		$detail = $this->jual->detail($id);
		$nama_plg = $detail ? $detail->nama_plg : 'Umum';

		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Laporan
                    </h5>
                    <small>Detail Penjualan</small>
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
								<td colspan="3" class="pb-4">
									<a href="'.site_url('laporan/cetak_penjualan/'.$detail->kode_penjualan).'" target="_blank" class="btn btn-sm btn-primary">
										Cetak
									</a>
								</td>
							</tr>
							<tr>
								<td style="width: 130px">Kode Penjualan</td>
								<td style="width: 20px">:</td>
								<th>'.$detail->kode_penjualan.'</th>
							</tr>
							<tr>
								<td style="width: 130px">Tgl Transaksi</td>
								<td style="width: 20px">:</td>
								<th>'.tgl(date('d/m/Y', strtotime($detail->tgl_transaksi))).'</th>
							</tr>
							<tr>
								<td>Pelanggan</td>
								<td>:</td>
								<th>'.$nama_plg.'</th>
							</tr>
							<tr>
								<td>Kasir</td>
								<td>:</td>
								<th>'.$detail->nama_admin.'</th>
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
									'.$item->nama_brg.'
								</td>
								<td class="text-center">'.$item->jml.'</td>
								<td class="text-right">'.nf($subharga).'</td>
							</tr>
						';
					}
							
		$html .= '
						</tbody>  
						<tfoot>
							<tr>
								<th class="text-right" colspan="3">Total Belanja</th>
								<th class="text-right">'.nf($detail->total_keranjang).'</th>
							</tr>
							<tr>
								<th class="text-right" colspan="3">Diskon</th>
								<th class="text-right text-danger">'.nf($detail->diskon).'</th>
							</tr>
							<tr>
								<th class="text-right" colspan="3">Bayar</th>
								<th class="text-right">'.nf($detail->bayar).'</th>
							</tr>
							<tr>
								<th class="text-right" colspan="3">Kembalian</th>
								<th class="text-right text-primary">'.nf($detail->total_kembalian).'</th>
							</tr>
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

	function opname($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Opname  | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					Opname
				</span>
			',
			'data' => $this->lap->opname($mulai, $selesai)
		];

		if(admin()->level != 'Kasir') {
			$this->layout->load('layout', 'laporan/opname', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function retur($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Retur  | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					retur
				</span>
			',
			'data' => $this->lap->retur($mulai, $selesai)
		];

		if(admin()->level != 'Admin') {
			$this->layout->load('layout', 'laporan/retur', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function keuangan($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Keuangan  | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					keuangan
				</span>
			',
			'data' => $this->lap->keuangan($mulai, $selesai)
		];

		if(admin()->level != 'Admin') {
			$this->layout->load('layout', 'laporan/keuangan', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function global($mulai = null, $selesai = null) {
		$conf = [
			'tabTitle' 	=> 'Laporan Global  | ' . webTitle(),
			'webInfo' => '
				<strong>
					Laporan
				</strong>
				<span>
					Global
				</span>
			',
			'data' => $this->hitung_global($mulai, $selesai)
		];

		if(admin()->level == 'Owner') {
			$this->layout->load('layout', 'laporan/global', $conf);

		} else {
			$this->load->view('404');
		}

		if(isset($_POST['submit'])) {
			$input   = $this->input->post(null);
			$mulai   = $input['mulai'] ? $input['mulai'] : date('Y-m-d');
			$selesai = $input['selesai'] ? $input['selesai'] : date('Y-m-d');

			redirect(strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . $mulai . '/' . $selesai));
		}
	}

	function hitung_global() {
		$bulan = date('m');

		$total_jual = 0;
		$this->db->where('MONTH(tgl_transaksi)', $bulan);
		$get_jual   = $this->db->get('tb_detail_penjualan')->result();
		foreach($get_jual as $row_jual) {
			$this->db->select('SUM(jml * harga_jual) as total');
			$detail_jual = $this->db->get_where('tb_penjualan', ['kode_penjualan' => $row_jual->kode_penjualan])->row();
			$total_jual += $detail_jual->total;
		}
		
		$total_keluar = 0;
		$this->db->where('MONTH(tgl)', $bulan);
		$get_keluar   = $this->db->get_where('tb_pengeluaran', ['id_admin' => 1])->result();
		foreach($get_keluar as $row_keluar) {
			$this->db->select('SUM(harga_modal) as total');
			$detail_keluar  = $this->db->get_where('tb_pengeluaran_detail', ['kode_pengeluaran' => $row_keluar->kode_pengeluaran])->row();
			$total_keluar  +=  $detail_keluar->total;
		}
		
		$this->db->where('MONTH(tgl_masuk)', $bulan);
		$get_beli 	= $this->db->get('tb_detail_brgm')->result();
		foreach($get_beli as $row_beli) {
			$this->db->select('SUM(stok_masuk * harga_beli) as total');
			$detail_beli = $this->db->get_where('tb_brg_masuk', ['kode_masuk' => $row_beli->kode_masuk])->row();
			$total_keluar += $detail_beli->total;
		}

		$total_profit = $total_jual - $total_keluar;

		return [
			'total_jual' => $total_jual,
			'total_beli' => $total_keluar,
			'total_profit' => $total_profit
		];

	}

	function cetak_stok_brg() {
		$data = $this->lap->stok_brg();
		$html = '
		<header class="text-center">
			<h1>'.webTitle().'</h1>
			<p>Laporan Stok Barang</p>
		</header>
		<div class="title text-center">
			Laporan Tanggal '.date('Y-m-d').' 
		</div>
		<table class="table table-bordered w-100" id="data_brg">
			<thead class="bg-light text-center">
				<tr>
					<th style="width:50px">No</th>
					<th style="width:180px">Kode Barang</th>
					<th>Nama Barang</th>
					<th style="width:120px">Stok</th>
					<th style="width:180px">Harga Barang</th>
				</tr>
			</thead>
			<tbody>
		';
		foreach($data as $no => $item) {
			$no++;
			$html .= '				
					<tr>
						<td class="text-center">
							'.$no.'
						</td>
						<td>
							'.$item->kode_brg.'
						</td>
						<td>
							'.$item->nama_brg.'
						</td>
						<td class="text-center">
							'.$item->stok_tersedia.' 
						</td>
						<td class="text-right">
							'.nf($item->harga_eceran).'
						</td>
					</tr>				
			';
		}

		$html .= '
			</tbody>
		</table>
		';

		return $html;
	}

	function cetak_brg_masuk($mulai = null, $selesai = null) {
		$data = $this->lap->brg_masuk($mulai, $selesai);
		$p    = [
			'mulai' => $mulai, 
			'selesai' => $selesai
		]; 

		$tgl = !empty($mulai) ? $p['mulai'] . ' s/d ' . $p['selesai'] : date('Y-m-d');

		$html = '
		<header class="text-center">
			<h1>'.webTitle().'</h1>
			<p>Laporan Barang Masuk</p>
		</header>
		<div class="title text-center">
			Laporan Tanggal '. $tgl .' 
		</div>
		<table class="table table-bordered w-100" id="data_brg">
			<thead class="bg-light text-center">
				<tr>
					<th style="width:50px">No</th>
					<th style="width:180px">Kode Transaksi</th>
					<th>Nama Barang</th>
					<th style="width:120px">Jml</th>
					<th style="width:180px">Harga Modal</th>
					<th style="width:180px">Subtotal</th>
					<th style="width:180px">Supplier</th>
					<th style="width:150px">Tgl Masuk</th>
				</tr>
			</thead>
			<tbody>
		';
		foreach($data as $no => $item) {
			$nama_supplier = $item->nama_supplier ? $item->nama_supplier : '-';
			$subtotal = $item->stok_masuk * $item->harga_modal; 
			$no++;
			$html .= '				
					<tr>
						<td class="text-center">
							'.$no.'
						</td>
						<td class="text-center">
							'.$item->kode_masuk.'
						</td>
						<td>
							'.$item->nama_brg.'
						</td>
						<td class="text-center">
							'.$item->stok_masuk.' 
						</td>
						<td class="text-right">
							'.nf($item->harga_modal).'
						</td>
						<td class="text-right">
							'.nf($subtotal).'
						</td>
						<td>
							'.$nama_supplier.'
						</td>
						<td class="text-center">
							'.date('d/m/Y', strtotime($item->tgl_masuk)).'
						</td>
					</tr>				
			';
		}

		$html .= '
			</tbody>
		</table>
		';

		return $html;
	}

	function cetak_brg_keluar($mulai = null, $selesai = null) {
		
		$data = $this->lap->brg_keluar($mulai, $selesai);
		$p    = [
			'mulai' => $mulai, 
			'selesai' => $selesai
		]; 

		$tgl = !empty($mulai) ? $p['mulai'] . ' s/d ' . $p['selesai'] : date('Y-m-d');

		$html = '
		<header class="text-center">
			<h1>'.webTitle().'</h1>
			<p>Laporan Barang keluar</p>
		</header>
		<div class="title text-center">
			Laporan Tanggal '. $tgl .' 
		</div>
		<table class="table table-bordered w-100" id="data_brg">
			<thead class="bg-light text-center">
				<tr>
					<th style="width:50px">No</th>
					<th style="width:180px">Kode Transaksi</th>
					<th>Nama Barang</th>
					<th style="width:120px">Jml</th>
					<th style="width:120px">Harga</th>
					<th style="width:120px">Subtotal</th>
					<th style="width:180px">Keterangan</th>
					<th style="width:150px">Tgl keluar</th>
				</tr>
			</thead>
			<tbody>
		';
		foreach($data as $no => $item) {
			$no++;
			$keterangan = $item->keterangan ? $item->keterangan : '-';
			$brg = $this->brg->brg($item->kode_brg);
			$harga = $brg ? $brg->harga_modal : 0;
			$subtotal = $harga * $item->stok_keluar; 

			$html .= '				
					<tr>
						<td class="text-center">
							'.$no.'
						</td>
						<td class="text-center">
							'.$item->kode_keluar.'
						</td>
						<td>
							'.$item->nama_brg.'
						</td>
						<td class="text-center">
							'.$item->stok_keluar.' 
						</td>						
						<td class="text-right">
							'.nf($brg->harga_modal).' 
						</td>						
						<td class="text-right">
							'.nf($subtotal).' 
						</td>						
						<td>
							'.$keterangan.'
						</td>
						<td class="text-center">
							'.date('d/m/Y', strtotime($item->tgl_keluar)).'
						</td>
					</tr>				
			';
		}

		$html .= '
			</tbody>
		</table>
		';

		return $html;
	}

	function cetak_penjualan($id = null) {
		$jual = $this->jual->penjualan($id);
		$detail = $this->jual->detail($id);
		$nama_plg = $detail->id_plg ? $detail->nama_plg : 'Umum';

		$html = '
		<!DOCTYPE html>
		<html>
			<head>
				<title>Cetak Laporan Penjualan</title>
				<link rel="stylesheet" href="'.base_url('assets/vendor/bootstrap/css/bootstrap.min.css').'">
				<style>
					th, tbody th {
						font-weight: 600;
					}
				</style>
			</head>
			<body>
			';

			if($jual) {
				$html .= '
					<div class="modal-body">
						<div class="text-center">
							<h2 class="mb-1">'.webTitle().'</h2>
							<p class="mb-0">
								Laporan Penjualan
							</p>
						</div>
						<hr>
						<div class="table-responsive mt-4">
							<table class="table table-sm table-borderless">
								<tr>
									<td style="width: 130px">Kode Penjualan</td>
									<td style="width: 20px">:</td>
									<th>'.$detail->kode_penjualan.'</th>
								</tr>
								<tr>
									<td style="width: 130px">Tgl Transaksi</td>
									<td style="width: 20px">:</td>
									<th>'.tgl(date('d/m/Y', strtotime($detail->tgl_transaksi))).'</th>
								</tr>
								<tr>
									<td>Pelanggan</td>
									<td>:</td>
									<th>'.$nama_plg.'</th>
								</tr>
								<tr>
									<td>Kasir</td>
									<td>:</td>
									<th>'.$detail->nama_admin.'</th>
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
							'.$item->nama_brg.'
						</td>
						<td class="text-center">'.$item->jml.'</td>
						<td class="text-right">'.nf($subharga).'</td>
					</tr>
				';
			}

			$html .= '
						</tbody>  
						<tfoot>
							<tr>
								<th class="text-right" colspan="3">Total</th>
								<th class="text-right">'.nf($detail->total_keranjang).'</th>
							</tr>
							<tr>
								<th class="text-right" colspan="3">Diskon</th>
								<th class="text-right text-danger">'.nf($detail->diskon).'</th>
							</tr>
							<tr>
								<th class="text-right" colspan="3">Bayar</th>
								<th class="text-right">'.nf($detail->bayar).'</th>
							</tr>
							<tr>
								<th class="text-right" colspan="3">Kembalian</th>
								<th class="text-right text-primary">'.nf($detail->total_kembalian).'</th>
							</tr>
						</tfoot>                      
					</table>
				</div>
			</div>	
		';
			
			$html .= '
				<script src="'.base_url('assets/vendor/jquery/jquery.min.js').'"></script>
				<script src="'.base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js').'"></script>

				<script>print()</script>
			</body>
		</html>
		';	
							
		}
		echo $html;
	}

	function cetak_opname($mulai = null, $selesai = null) {
		$data = $this->lap->opname($mulai, $selesai, );
		$p    = [
			'mulai' => $mulai, 
			'selesai' => $selesai
		]; 

		$tgl = !empty($mulai) ? $p['mulai'] . ' s/d ' . $p['selesai'] : date('Y-m-d');

		$html = '
		<header class="text-center">
			<h1>'.webTitle().'</h1>
			<p>Laporan Opname</p>
		</header>
		<div class="title text-center">
			Laporan Tanggal '. $tgl .' 
		</div>
		<table class="table table-bordered w-100" id="data_brg">
			<thead class="bg-light text-center">
				<tr>
					<th style="width:80px">No</th>
					<th style="width:150px">Kode Opname</th>
					<th>Nama Barang</th>
					<th style="width:120px">Jml Sistem</th>
					<th style="width:120px">Jml Fisik</th>
					<th>Petugas</th>
					<th style="width:150px">Keterangan</th>
					<th style="width:150px">Tgl Opname</th>
				</tr>
			</thead>
			<tbody>
		';
		$total = 0;
		foreach($data as $no => $item) {
			$no++;
			$ket = $item->keterangan ? $item->keterangan : ' - ';
			$html .= '				
					<tr>
						<td class="text-center">
							'.$no.'
						</td>
						<td class="text-center">
							'.$item->kode_opname.'
						</td>
						
						<td>
							'.$item->nama_brg.'
						</td>
						<td class="text-center">
							'.$item->jml_system.' 
						</td>						
						<td class="text-center">
							'.$item->jml_fisik.' 
						</td>
						<td>
							'.$item->nama_admin.'
						</td>						
						<td>
							'.$ket.' 
						</td>						
						<td class="text-center">
							'.date('d/m/Y', strtotime($item->tgl_opname)).'
						</td>
					</tr>				
			';
		}

		$html .= '
			</tbody>
		</table>
		';

		return $html;
	}

	function cetak_retur($mulai = null, $selesai = null) {
		
		$data = $this->lap->retur($mulai, $selesai, );
		$p    = [
			'mulai' => $mulai, 
			'selesai' => $selesai
		]; 

		$tgl = !empty($mulai) ? $p['mulai'] . ' s/d ' . $p['selesai'] : date('Y-m-d');

		$html = '
		<header class="text-center">
			<h1>'.webTitle().'</h1>
			<p>Laporan Retur Penjualan</p>
		</header>
		<div class="title text-center">
			Laporan Tanggal '. $tgl .' 
		</div>
		<table class="table table-bordered w-100" id="data_brg">
			<thead class="bg-light text-center">
				<tr>
					<th style="width:80px">No</th>
					<th>Nama Barang</th>
					<th style="width:120px">Jml </th>
					<th style="width:250px">Keterangan</th>
					<th style="width:150px">Tgl Retur</th>
				</tr>
			</thead>
			<tbody>
		';
		$total = 0;
		foreach($data as $no => $item) {
			$no++;
			$ket = $item->keterangan ? $item->keterangan : ' - ';
			$html .= '				
					<tr>
						<td class="text-center">
							'.$no.'
						</td>
						
						<td>
							'.$item->nama_brg.'
						</td>
						<td class="text-center">
							'.$item->jml.' 
						</td>											
						<td>
							'.$ket.' 
						</td>						
						<td class="text-center">
							'.date('d/m/Y', strtotime($item->tgl_retur)).'
						</td>
						
					</tr>				
			';
		}

		$html .= '
			</tbody>
		</table>
		';

		return $html;
	}

	function cetak_keuangan($mulai = null, $selesai = null) {
		
		$data = $this->lap->keuangan($mulai, $selesai, );
		$p    = [
			'mulai' => $mulai, 
			'selesai' => $selesai
		]; 

		$tgl = !empty($mulai) ? $p['mulai'] . ' s/d ' . $p['selesai'] : date('Y-m-d');

		$html = '
		<header class="text-center">
			<h1>'.webTitle().'</h1>
			<p>Laporan Keuangan</p>
		</header>
		<div class="title text-center">
			Laporan Tanggal '. $tgl .' 
		</div>
		<table class="tb_keuangan">
            <tr>
                <th colspan="4">
                    Rincian Pembelian Barang
                </th>
            </tr>

            <tr>
                <td style="width: 200px">
                    Jumlah
                </td>
                <th>
                    '.$data['jml_beli'].' Item
                </th>
            </tr>
            <tr>
                <td>
                    Total
                </td>
                <th>
                    '.nf($data['total_beli']).'
                </th>
            </tr>

            <tr>
                <th colspan="3" class="pt-3">
                    Rincian Penjualan Barang
                </th>
            </tr>

            <tr>
                <td>
                    Jumlah
                </td>
                
                <th>
                    '.$data['jml_jual'].' Item
                </th>
            </tr>
            <tr>
                <td>
                    Total
                </td>
                <th>
                    '.nf($data['total_jual']).'
                </th>
            </tr>
            <tr>
                <td colspan="3" class="pt-2"></td>
            </tr>
            <tr>
                <th>
                    Total Pengeluaran
                </th>
                <th>
                   '.nf($data['total_beli']).'
                </th>
            </tr>            
            <tr>
                <th>
                    Total Pemasukan
                </th>
                <th >
                   '.nf($data['total_jual']).'
                </th>
            </tr>            

        </table>
		';

		return $html;
	}

	function cetak($p = null, $mulai = null, $selesai = null) {		
		$html = '
			<!DOCTYPE html>
			<html>
				<head>
					<title>Cetak Laporan</title>
					<style>
						body {
							font-size: 16px;
						}
						table {
							width: 100%;
							border-collapse: collapse;
						}
						thead th {
							padding: 10px 7px;
						}
						th, td {
							border: 1px solid #000;
						}
						tbody td, tbody th {
							padding: 5px;
						}
						tfoot th {
							padding: 10px 5px;
						}
						.text-center {
							text-align: center;
						}
						.text-right {
							text-align: right;
						}
						.text-left {
							text-align: left;
						}
						h1, p {
							margin: 0;
						}
						header {
							margin-bottom: 30px;
							padding-bottom: 15px;
							border-bottom: 1px double #000;
						}
						.title {
							margin-bottom: 10px;
						}
						.tb_keuangan td, .tb_keuangan th {
							text-align: left;
						}
					</style>
				</head>
				<body>											
		';

		if($p == 'stok_brg') {
			$html .= $this->cetak_stok_brg();
			
		} else if($p == 'brg_masuk') {
			$html .= $this->cetak_brg_masuk($mulai, $selesai);

		} else if($p == 'brg_keluar') {
			$html .= $this->cetak_brg_keluar($mulai, $selesai);

		} else if($p == 'opname') {
			$html .= $this->cetak_opname($mulai, $selesai);

		} else if($p == 'retur') {
			$html .= $this->cetak_retur($mulai, $selesai);
				
		} else if($p == 'keuangan') {
			$html .= $this->cetak_keuangan($mulai, $selesai);

		}				

		$html .= '

					<script>
						print();
					</script>
				</body>
			</html>
		';

		echo $html;
	}
}
