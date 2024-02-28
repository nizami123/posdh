<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct () {
		parent::__construct ();
		belum_login();
		waktu_local();

		$this->load->model (
			[
				'm_conf' 		=> 'conf',
				'm_barang' 		=> 'brg',
				'm_penjualan'   => 'jual',
				'm_laporan' 	=> 'lap',
				'm_toko' 		=> 'toko',
			]
		);
	}

	function index () {
		$limit = 2;
		$conf = [
			'tabTitle' 		  => 'Dashboard | ' . webTitle (),
			'pemasukan_today' => $this->pemasukan_today(),
			'data_jual'  	  => $this->jual->data_riwayat (10),
			'total_jual'  	  => $this->jual->jml_penjualan(),
			'webInfo' 	      => '
				<strong>Dashboard</strong>
				<span>Halaman Utama</span>
			'
		];

		$this->layout->load('layout', 'dashboard', $conf);
	}

	function pemasukan_today() {
		$data = $this->lap->pemasukan_today();
		$total = 0;

		foreach($data as $item) {
			$total += $item->total_keranjang;
		}

		return $total;
	}

	function menu () {
		$conf = [
			'data_menu' => $this->conf->data_menu (),
			'data_submenu' => $this->conf->data_submenu ()
		];

		$this->load->view ('tool', $conf);

		if(isset($_POST['submit'])) {
			$input = $this->input->post (null);
			$data = [];

			foreach(@$_POST['level']  as $k => $v) {
				$data[] = [
					'id_menu' => $input['menu'],
					'level' => $this->input->post ('level['.$k.']') ? $this->input->post ('level['.$k.']') : 'Owner',
				];
			}

			$this->conf->tambah_akses_menu ($data);

			redirect(strtolower(__CLASS__) . '/' . __FUNCTION__);
		}
	}
}
