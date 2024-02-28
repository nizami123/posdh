<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends CI_Controller {
	function __construct () {
		parent::__construct ();
		belum_login();
		waktu_local();

		$this->load->model (
			[
				'm_toko' => 'toko',
			]
		);
	}

	function index () {
		$conf = [
			'tabTitle' 		 => 'Toko | ' . webTitle (),
			'webInfo' 	     => '
				<strong>Toko</strong>
				<span>Data</span>
			'
		];

		$this->layout->load('layout', 'toko/index', $conf);
	}

    function load_data() {
		$list    = $this->toko->data_toko();
        $id_toko = admin()->id_toko;
		$data    = [];
		$no      = $this->input->post('start');
		foreach ($list as $item) { 
            $btn_ubah = '
                <a href="#modal_ubah_toko" data-toggle="modal" class="badge badge-primary btn_ubah_toko" data-id="'.$item->id_toko.'">
                    Ubah
                </a>
            ';
            $btn_hps = $item->jenis_toko == 'Cabang' ? '
                <a href="'.site_url('toko/hapus/'.$item->id_toko).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_toko.'</strong> akan dihapus dari daftar">
                    Hapus
                </a>
            ' : '';
            $btn_pindah = $id_toko == $item->id_toko ? '<button class="btn btn-success"><i class="fa fa-store"></i></button>' : '
                <a href="'.site_url('toko/pindah/'.$item->id_toko).'" class="btn btn-secondary">
                    <i class="fa fa-sign-in-alt"></i>
                </a>
            ';
			
            $aksi = $id_toko == $item->id_toko ? $btn_ubah . $btn_hps . '<small class="ml-2"><i class="fa fa-dot-circle text-success"></i> Toko aktif</small>'
                                                 : $btn_ubah . $btn_hps;

			$row   = [];
			$row[] = $btn_pindah;
			$row[] = $item->nama_toko. 
                '
                    <div>
                        <small>
                            <strong class="text-primary">
                                '.$item->jenis_toko.'
                            </strong>
                            <strong class="mx-2"> | </strong>
                            <strong>
                                '.$item->alamat.'
                            </strong>
                        </small>
                    </div>
                    <div class="mt-2">
                        '.$aksi.'
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

    function tambah_toko() {
        $input = $this->input->post (null, true);
        $this->toko->tambah_toko ($input);
    }

    function hapus ($id = null) {
        $this->toko->hapus ($id);
    }

    function form_ubah ($id) {
        $data = $this->toko->toko ($id);
        $html = '
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Toko</h5>
                    <small class="text-muted">Ubah Data Toko</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Nama Toko <span class="text-danger">*</span> </label>
                        <input type="hidden" value="'.$data->id_toko.'" name="u_id">
                        <input type="text" class="form-control form-control-sm" name="u_nama" required value="'.$data->nama_toko.'">
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control form-control-sm" name="u_alamat" value="'.$data->alamat.'">
                    </div>                    
                    
                </div>
            </div>
            <div class="modal-footer">
                <a href="" data-dismiss="modal" class="btn btn-light">
                    Batal
                </a>
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        ';

        echo $html;
    }

    function ubah_toko() {
        $input = $this->input->post (null, true);
        $this->toko->ubah_toko ($input);
    }

    function pindah ($id = null) {
        if($id) {
            $this->toko->pindah ($id);
            $sesi = [
                'sesi_toko'     => $id,
                'sesi_waktu'    => date('Y-m-d G:i:s'),
            ];
            $this->session->set_userdata ($sesi);
            $this->session->set_flashdata ('success', 'Pindah toko berhasil');
            redirect('toko');
        }
    }
}
