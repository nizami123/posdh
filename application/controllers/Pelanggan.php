<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
    function __construct() {
        parent::__construct();
		belum_login();
		waktu_local();
        $this->load->model('m_pelanggan', 'plg');
    }

    function index() {
        $conf = [
			'tabTitle' 	=> 'Data Pelanggan | ' . webTitle(),
			'webInfo' => '
				<strong>
					Pelanggan
				</strong>
				<span>
					Data
				</span>
			',
			
		];
		$this->layout->load('layout', 'pelanggan/index', $conf);
    }

    function load_data_plg() {
		$list = $this->plg->data_plg();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$ponsel = $item->no_ponsel ? $item->no_ponsel : '-';
			$aksi = admin()->level != 'Admin' ? '
				<div class="mt-2">                                       
					<a href="#modal_ubah_plg" data-toggle="modal" class="badge badge-primary btn_ubah_plg" data-id="'.$item->id_plg.'">
						Ubah
					</a>
					<a href="'.site_url('pelanggan/hapus/'.$item->id_plg).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_plg.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			' : '';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->nama_plg .
				'<div class="text-muted">
					<small>
						<span> '.$ponsel.' </span>
					</small>
					<small class="mx-2"> | </small>
					<small>
						<span> '.$item->alamat.' </span>
					</small>
				</div>								
			' . $aksi ;
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

    function form_ubah_plg($id = null) {
        $data = $this->plg->pelanggan($id);
        $html = '
            <div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Pelanggan</h5>
                    <small class="text-muted">Ubah Data Pelanggan</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Nama Pelanggan <span class="text-danger">*</span> </label>
                        <input type="hidden" name="u_id_plg" value="'.$data->id_plg.'" >
                        <input type="text" class="form-control form-control-sm" name="u_nama_plg" value="'.$data->nama_plg.'" required>
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">No Ponsel</label>
                        <input type="text" class="form-control form-control-sm" name="u_no_ponsel" value="'.$data->no_ponsel.'">
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control form-control-sm" name="u_alamat" value="'.$data->alamat.'">
                    </div>                      
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        ';
        echo $html;
    } 

	
    function generateid(){
        $data['lastID'] = $this->db->query("SELECT id_plg FROM tb_pelanggan ORDER BY id_plg DESC LIMIT 1")->result_array();
        
        if (!empty($data['lastID'][0]['id_plg'])) {
            $parts = explode('-', $data['lastID'][0]['id_plg']);
            $numericPart = isset($parts[1]) ? $parts[1] : '0000';
            $incrementedNumericPart = sprintf('%04d', intval($numericPart) + 1);
            $data['newID'] = 'H3TCUS-' . $incrementedNumericPart;
        } else {
            $data['newID'] = 'H3TCUS-0001';
        }

        return $data['newID'];
    }

	function proses_tambah_plg() {
    $input = $this->input->post(null, true);

    // Ambil ID pelanggan terakhir
    $last_id = $this->db->select('id_plg')
                        ->like('id_plg', 'H3TCUS-')
                        ->order_by('id_plg', 'DESC')
                        ->limit(1)
                        ->get('tb_pelanggan')
                        ->row();

    if ($last_id) {
        $last_number = (int)substr($last_id->id_plg, 7); // Ambil angka dari H3TCUS-0005 → 0005
        $new_number = $last_number + 1;
    } else {
        $new_number = 1;
    }

    // Format ID baru
    $new_id = 'H3TCUS-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);

    $data = [
        'id_plg'     => $new_id,
        'nama_plg'   => $input['nama_plg'],
        'no_ponsel'  => $input['no_ponsel'],
        'alamat'     => $input['alamat'],
        'tgl_lahir'  => $input['tgl_lahir'],
        'agama'      => $input['agama'],
        'email'      => $input['email'],
    ];

    $this->db->insert('tb_pelanggan', $data);
    return $data['id_plg'];
}


	function proses_ubah_plg() {
		$input = $this->input->post(null, true);
		$this->plg->ubah_plg($input);
	}

	function hapus($id = null) {
		$this->plg->hapus($id);
	}
}