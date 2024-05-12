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
				'm_pelanggan'	=> 'plg',
			]
		);
	}

	function index () {
		$limit = 2;
		$conf = [
			'tabTitle' 		  => 'Dashboard | ' . webTitle (),
			'pemasukan_today' => $this->pemasukan_today(),
			'uang_kasir'      => $this->uang_kasir('Saldo'),
			'status'	      => $this->uang_kasir('status'),
			'data_jual'  	  => $this->jual->data_riwayat_today (10),
			'total_jual'  	  => $this->jual->jml_penjualan(),
			'webInfo' 	      => '
				<strong>Dashboard</strong>
				<span>Halaman Utama</span>
			'
		];

		$this->layout->load('layout', 'dashboard', $conf);
	}

	function load_data_keluar() {
		$list = $this->db->query("select * from vbarangkeluar where status=2")->result();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$no++;
			$row   = [];
			$row[] = $no;
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
			$row[] = nf($item->hrg_jual);
			$row[] = nf($item->hrg_cashback);
			$row[] = $item->nama_toko;
			$row[] = $item->kondisi;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->plg->count_all_keluar(),
			"recordsFiltered"  => $this->plg->count_keluar(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function pemasukan_today() {
		$data = $this->lap->pemasukan_today();
		$total = 0;

		foreach($data as $item) {
			$total += $item->bayar;
		}

		return $total;
	}

	function uang_kasir($name) {
		if ($name == 'Saldo'){
			$data = $this->db->query("SELECT COALESCE(SUM(saldo), 0) AS saldo FROM tb_saldo WHERE tanggal = '".date('Y-m-d')."'")->row();
			return $data->saldo;
		}else{
			$data = $this->db->query("SELECT COALESCE(sum(status), 0) AS status FROM tb_saldo WHERE tanggal = '".date('Y-m-d')."'")->row();
			return $data->status;
		}
	}

	function simpan_saldo() {
        $saldo = $this->input->post('saldo'); // Mengambil nilai saldo dari formulir

        if (!empty($saldo)) {
            $data = array(
                'tanggal' => date('Y-m-d'),
                'saldo' => $saldo
            );

            $this->db->insert('tb_saldo', $data);

           redirect('Dashboard');
        } else {
            redirect('Dashboard');
        }
    }

	function tutup_toko() {
		$data = array(
			'status' => 1
		);
		$this->db->where('tanggal', date('Y-m-d'));
		$this->db->update('tb_saldo', $data);
		redirect('Dashboard');
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
