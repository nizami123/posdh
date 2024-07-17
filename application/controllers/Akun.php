<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {
	function __construct () {
		parent::__construct ();
		waktu_local();

		$this->load->model (
			[
				'm_conf' => 'conf',
                'm_admin' => 'admin'
			]
		);
	}

	function index () {
        belum_login();
		$conf = [
			'tabTitle' => 'Akun | ' . webTitle (),
			'webInfo'  => '
				<strong>'.__CLASS__.'</strong>
				<span>Ubah</span>
			'
		];

		$this->layout->load('layout', 'akun/index', $conf);

        if(isset($_POST['simpan'])) {
			$input 			    = $this->input->post(null, true);
			$input['u_posisi']  = admin()->level;
			$input['u_toko']    = admin()->id_toko;
			$input['u_id']   	= admin()->id_admin;

			$email['id']   		= admin()->id_admin;
			$email['email']   	= $input['u_email'];
			$cek_email 		 	= $this->admin->cek_email($email);

			if($cek_email > 0) {
				$this->session->set_flashdata('error', 'Email <strong>'.$input['u_email'].'</strong> sudah digunakan');

			} else {
				if(!empty(@$_FILES['u_foto']['name'])) {
					$config['file_name'] 	 =  time(); 
					$config['upload_path'] 	 = 'upload/karyawan'; 
					$config['allowed_types'] = 'jpeg|jpg|png'; 
					$config['file_size'] 	 = 1024;

					$this->load->library('upload', $config);
	
					if(file_exists('upload/karyawan/'.admin()->foto) && admin()->foto != '') {
						unlink('upload/karyawan/'.admin()->foto);
					}
	
					if($this->upload->do_upload('u_foto')) {
						$input['u_foto'] = $this->upload->data('file_name');	
						$this->admin->ubah_admin($input);
						$this->session->set_flashdata('success', 'Akun sudah diupdate');
	
					} else {
						$this->session->set_flashdata('error', $this->upload->display_errors('<span>', '</span>'));
					}
					
	
				} else {
					$input['u_foto'] = admin()->foto;
					$this->admin->ubah_admin($input);
					$this->session->set_flashdata('success', 'Akun sudah diupdate');
				}

			}
			
			redirect(strtolower(__CLASS__));
		}
	}

    function ubah_sandi() {
		$conf = [
			'tabTitle' 	=> 'Ubah sandi | ' . webTitle(),
			'webInfo' => '
				<strong>
					Akun
				</strong>
				<span>
					Ubah Sandi
				</span>
			',
		];

		$this->layout->load('layout', 'akun/ubah_sandi', $conf);

		if(isset($_POST['simpan'])) {
			$input = $this->input->post(null, true);
			
			$cek = $this->admin->admin(admin()->id_admin);

			if($cek->password <> $input['pass_lama']) {
				$this->session->set_flashdata('error', 'Sandi lama tidak sesuai');
				
			} else {
				if($input['pass_baru'] <> $input['confirm']) {
					$this->session->set_flashdata('error', 'Sandi baru tidak sesuai');
					
				} else {
					$this->admin->ubah_sandi($input['pass_baru']);
					$this->session->set_flashdata('success', 'Sandi sudah diupdate');
				}
			}

			redirect('akun/ubah_sandi');
		}
	}

	function login () {
		$conf = [
			'tabTitle' => 'Login',
            'error'    => ''
		];

        $this->load->library ('form_validation');

        $rules = [
            [
                'field' => 'username',
                'label' => 'username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} belum diisi'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} belum diisi'
                ]
            ],
        ];

        $this->form_validation->set_rules ($rules);

        if ($this->form_validation->run () == false) {
            $this->load->view ('akun/login', $conf);

        } else {
            $username = $this->input->post ('username', true);
            $password = $this->input->post ('password', true);
            $data     = $this->admin->cek_admin ($username);

            if($data->num_rows () == 0) {
                $conf['error'] = 'Akun tidak terdaftar';
                $this->load->view ('akun/login', $conf);
            } else {
                if($data->row ()->email_admin <> $username) {
                    $conf['error'] = 'Username & password salah';
                    $this->load->view ('akun/login', $conf);

                } else {
                    if($data->row ()->password <> $password) {
                        $conf['error'] = 'Username & password salah';
                        $this->load->view ('akun/login', $conf);   

                    } else {
                        $sesi = [
                            'sesi_id_admin' => $data->row ()->id_admin,
                            'sesi_toko'     => $data->row ()->id_toko,
                            'sesi_level'    => $data->row ()->level,
			    'sesi_kasir'    => $data->row ()->id_karyawan,
                            'sesi_waktu'    => date('Y-m-d G:i:s'),
                        ];
                        $success = '
                            <strong><i class="fa fa-check-circle mr-1"></i> Login Berhasil</strong>
                            <p class="mb-0 mt-1">
                                Hai '. $data->row ()->nama_admin .', Anda login sebagai '. $data->row ()->level .'
                            </p>
                        ';

                        $this->session->set_userdata ($sesi);
                        $this->session->set_flashdata ('success', $success);

                        redirect ();
                    }
                }
            }
        }

	}

    function keluar () {
        session_destroy();
        $msg = '
            <p class="mb-0">
                Anda sudah keluar, silahkan login
            </p>
        ';
        $this->session->set_flashdata ('success', $msg);
        redirect('akun/login/tx');
    }
}
