<?php 

class Lap_global extends CI_Controller {
	function __construct() {
		parent::__construct();
		belum_login();
		waktu_local();
	}

    function index() {
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
		];

		if(admin()->level == 'Owner') {
			$this->layout->load('layout', 'global/data', $conf);

		} else {
			$this->load->view('404');
		}
    }

	function laporan($mulai = null, $selesai = null) {
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
}