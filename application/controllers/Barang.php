<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
	function __construct() {
		parent::__construct();
		belum_login();
		waktu_local();
		$this->load->model(
			[
				'm_admin' => 'admin',
				'm_toko'  => 'toko'
			]
		);
		
	}
	
	function index() {
		$conf = [
			'tabTitle' 	=> 'Data Barang | ' . webTitle(),
			'data_toko' => $this->toko->data_toko(),
			'webInfo' => '
				<strong>
					Barang Tersedia
				</strong>
				<span>
					Data
				</span>
			',
		];
			$this->layout->load('layout', 'barang/index', $conf);
	}

	function load_data() {
		$list = $this->admin->data();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$foto = $item->foto ? 'upload/karyawan/'.$item->foto : 'upload/no-img.png';
			$aksi = '
				<div class="mt-2">
					<a href="#modal_ubah_karyawan" data-toggle="modal" data-id="'.$item->id_admin.'" class="badge badge-primary btn_ubah">
						Ubah
					</a>                                        
					
					<a href="'.site_url('karyawan/hapus/'.$item->id_admin).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_admin.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = '
				<div class="d-flex flex-wrap">
					<div style="width: 100px;height:120px;border:1px dashed #ddd;margin-right: 20px;position:relative;overflow:hidden;">
						<img src="'.$foto.'" class="w-100" style="max-height: 100%; object-fit: scale-down;">
					</div>
					<div style="width: calc(100% - 100px - 20px);">
						'.$item->nama_admin .'
							<div>
								<small>
									<strong class="text-primary"> '.$item->level.' </strong>
								</small>
								<small class="mx-2"> | </small>
								<small>
									Email: <strong> '.$item->email_admin.' </strong>
								</small>
								
							</div>								
						' . $aksi .'
					</div>
				</div>';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->admin->count_all(),
			"recordsFiltered"  => $this->admin->count(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function submit_karyawan() {
		$input 		 	= $this->input->post(null, true);

		if($input['pass'] == '') {
			$input['pass']  = $input['posisi'] == 'Kasir' ? 'Kasir' : 'Admin';
		}

		$input['foto']  = '';
		$cek 			= $this->admin->cek_email($input);

		if($cek > 0) {
			echo 'email_tersedia';
			
		} else {
			if(!empty(@$_FILES['foto']['name'])) {
				$config['file_name'] 	 = time(); 
				$config['upload_path']   = 'upload/karyawan'; 
				$config['allowed_types'] = 'jpeg|jpg|png'; 
				$config['file_size'] 	 = 1024;
	
				$this->load->library('upload', $config);
	
				if($this->upload->do_upload('foto')) {
					$input['foto'] = $this->upload->data('file_name');	
					$this->admin->tambah_admin($input);
	
				} else {
					echo $this->upload->display_errors('<span>', '</span>');
				}
	
			} else {				
				$this->admin->tambah_admin($input);	
			}
		}

	}

	function hapus($id) {
		$data = $this->admin->admin($id);
		unlink('upload/karyawan/'.$data->foto);

		$this->admin->hapus($id);
	}

	function form_ubah($id = null) {
		$data = $this->admin->admin($id);
		$foto = $data->foto ? 'upload/karyawan/' . $data->foto : 'upload/no-img.png';
		$data_toko = $this->toko->data_toko();

		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Karyawan</h5>
                    <small class="text-muted">Ubah data karyawan</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Nama Karyawan <span class="text-danger">*</span> </label>
                        <input type="hidden" name="u_id" value="'.$data->id_admin.'">
                        <input type="text" class="form-control form-control-sm" name="u_nama" value="'.$data->nama_admin.'" required>
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="u_email" value="'.$data->email_admin.'" required>
                    </div>
					<div class="form-group col-sm-12">
                        <label for="">Password</label>
						<div class="input-group">
							<input type="password" name="u_pass" class="form-control form-control-sm readonly" readonly id="u_pass">
							<div class="input-group-append">
								<button class="showPass btn btn-sm btn-dark">
									<i class="fa fa-edit"></i>
								</button>
							</div>
						</div>
                    </div>       
                    <div class="form-group col-sm-12">
                        <label for="">Nama Toko</label>
                        <select name="u_toko"  class="form-control form-control-sm select2">
		';
                            foreach($data_toko as $toko) {
								if($toko->id_toko == $data->id_toko) {
									$html .= '
										<option value="'.$toko->id_toko.'" selected>
											'.$toko->nama_toko.'
										</option>
									';
									
								} else {
									$html .= '
										<option value="'.$toko->id_toko.'">
											'.$toko->nama_toko.'
										</option>
									';
								}
							}
        $html .= '
                        </select>
                    </div>            
                    <div class="form-group col-md-12">
                        <label for="">Posisi</label>

		';
                		$data_pos = ['Admin', 'Kasir'];
                		foreach($data_pos as $i => $pos) { 
                    		if($pos == $data->level) {
        $html .= '
                                <div class="custom-control custom-radio">
                                    <input type="radio" 
                                        name="u_posisi" id="u_'.$pos.'" 
                                        value="'.$pos.'" 
                                        class="custom-control-input"
                                        checked
                                    >
                                    <label for="u_'.$pos.'" 
                                        class="custom-control-label"
                                    >
                                        '.$pos.'
                                    </label>
                                </div>
		';

							} else {
		$html .= '

                                <div class="custom-control custom-radio">
                                    <input type="radio" 
                                        name="u_posisi" id="u_'.$pos.'" 
                                        value="'.$pos.'" 
                                        class="custom-control-input"
                                        
                                    >
                                    <label for="u_'.$pos.'" 
                                        class="custom-control-label"
                                    >
                                        '.$pos.'
                                    </label>
                                </div>
								';
							}
						}
		$html .= '
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="">Foto</label>
                        <div class="mt-2">
                            <div class="alert alert-light border">
                                Ukuran gambar tidak boleh lebih dari <strong>1MB</strong> dan hanya mendukung format gambar <strong>jpg, jpeg, png</strong>
                            </div>
                            <label for="u_inp_foto" class="upload_grup">
                                <div class="_img">
                                    <img src="'.base_url($foto).'" class="view_foto w-100">
                                </div>

                                <input type="file" name="u_foto" id="u_inp_foto" class="inp_foto" accept=".jpg, .jpeg, .png">
                                <label for="u_inp_foto" class="lab_foto">Unggah</label>
                            </label>
                        </div>
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

	function proses_ubah() {
		$input 	= $this->input->post(null, true);
		$data  	= $this->admin->admin($input['u_id']);
		
		$email['email']  = $input['u_email']; 
		$email['id']  	 = $input['u_id']; 

		$cek = $this->admin->cek_email($email);

		if($cek > 0) {
			echo 'email_tersedia';

		} else {
			if(!empty(@$_FILES['u_foto']['name'])) {
				$config['file_name'] 	 = $data->foto ?  $data->foto : time(); 
				$config['upload_path'] 	 = 'upload/karyawan'; 
				$config['allowed_types'] = 'jpeg|jpg|png'; 
				$config['file_size'] 	 = 1024;
				$config['overwrite'] 	 = true;
	
				$this->load->library('upload', $config);
	
				if(file_exists('upload/karyawan/'.$data->foto) && $data->foto != '') {
					unlink('upload/karyawan/'.$data->foto);
				}
	
				if($this->upload->do_upload('u_foto')) {
					$input['u_foto'] = $this->upload->data('file_name');	
					$this->admin->ubah_admin($input);
	
				} else {
					echo $this->upload->display_errors('<span>', '</span>');
				}
	
			} else {
				$input['u_foto'] = $data->foto;
				$this->admin->ubah_admin($input);
	
			}
		}
	} 

}
