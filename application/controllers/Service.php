<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {
	function __construct () {
		parent::__construct ();
		belum_login();
		waktu_local();

		$this->load->model (
			[
				'm_service' => 'serv',
			]
		);
	}

	function index () {
		$conf = [
			'tabTitle' 		 => 'Service | ' . webTitle (),
			'webInfo' 	     => '
				<strong>'.__CLASS__.'</strong>
				<span>Data</span>
			'
		];

		$this->layout->load('layout', 'service/index', $conf);
	}

    function load_data() {
        $list = $this->serv->data_service();
        $data = [];
        $no = $this->input->post('start');
        foreach ($list as $item) { 
            $aksi = admin()->level != 'Admin' ? '
                <div class="mt-2">                                       
                    <a href="#modal_ubah_plg" data-toggle="modal" class="badge badge-primary btn_ubah_plg" data-id="'.$item->id_service.'">
                        Ubah
                    </a>
                    <a href="'.site_url('pelanggan/hapus/'.$item->id_service).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_custumer.'</strong> akan dihapus dari daftar">
                        Hapus
                    </a>
                </div>
            ' : '';          
            $no++;
            $row   = [];
            $row[] = $no;
            $row[] = $item->nama_custumer . $aksi ;
            $data[] = $row;
        }
        $output = [
            "draw"             => $this->input->post('draw'),
            "recordsTotal"     => $this->serv->count_all(),
            "recordsFiltered"  => $this->serv->count(),
            "data"             => $data,
        ];
        echo json_encode($output);

    }

    function load_data_plg() {
	}
	
}
