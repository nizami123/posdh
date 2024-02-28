<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
	function __construct() {
		parent::__construct();
        belum_login();
		waktu_local();
		$this->load->model('m_conf', 'conf');
	}
	
	function index() {
		$conf = [
			'tabTitle' 	=> 'Pengaturan Umum | ' . webTitle(),
			'webInfo' => '
				<strong>
					Pengaturan
				</strong>
				<span>
					Umum
				</span>
			',
		];
        
        if(admin()->level != 'Admin' && admin()->level != 'Kasir') {
            $this->layout->load('layout', 'pengaturan/index', $conf);

		} else {
			$this->load->view('404');
		}

        if(isset($_POST['simpan'])) {
            $input          = $this->input->post(null, true);
            $input['logo']  = conf()->logo ? conf()->logo : 'logo.png';

            if(!empty(@$_FILES['logo']['name'])) {
                $config['file_name']     = conf()->logo ? conf()->logo : 'logo.png'; 
                $config['upload_path']   = 'upload/'; 
                $config['allowed_types'] = 'jpeg|jpg|png'; 
                $config['file_size']     = 1024;
                $config['overwrite'] 	 = true;
    
                $this->load->library('upload', $config);

                if(file_exists('upload/'.conf()->logo) && conf()->logo != '') {
                    unlink('upload/'.conf()->logo);
                }
    
                if($this->upload->do_upload('logo')) {
                    $input['logo'] = $this->upload->data('file_name');	
                    $this->conf->update_conf($input);
                    
                    $this->session->set_flashdata('success', 'Update berhasil');

                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors('<span>', '</span>'));                   
                }
    
            } else {
                $this->conf->update_conf($input);
                $this->session->set_flashdata('success', 'Update berhasil');    
            }

            redirect(strtolower(__CLASS__));
        }
	}
    
    function tambahan() {
		$conf = [
			'tabTitle' 	=> 'Pengaturan Tambahan | ' . webTitle(),
			'webInfo' => '
				<strong>
					Pengaturan
				</strong>
				<span>
					Tambahan
				</span>
			',
		];
        if(admin()->level != 'Admin' && admin()->level != 'Kasir') {
            $this->layout->load('layout', 'pengaturan/tambahan', $conf);

		} else {
			$this->load->view('404');
		}

        if(isset($_POST['simpan'])) {
            $input = $this->input->post(null, true);
            $this->conf->update_tambahan($input);
            $this->session->set_flashdata('success', 'Pengaturan tambahan diupdate');
            redirect('pengaturan/tambahan');
        }
	}
    
    function pembaharuan() {
		$conf = [
			'tabTitle' 	=> 'Pembaharuan Aplikasi | ' . webTitle(),
			'webInfo' => '
				<strong>
					Pengaturan
				</strong>
				<span>
                Pembaharuan
				</span>
			',
		];
        if(admin()->level != 'Admin' && admin()->level != 'Kasir') {
            $this->layout->load('layout', 'pengaturan/pembaharuan', $conf);

            if(isset($_POST['update'])) {
                $name       = $_FILES['file']['name'];
                $explode    = explode('.', $name);
                $filename   = $explode[0];
                $ext        = $explode[1];
    
                if($ext == 'zip') {
                    $path = './';
                    $location = $path . $name;
    
                    if(move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
                        $zip = new ZipArchive;
                        if($zip->open($location)) {
                            $zip->extractTo($path);
                            $zip->close();
    
                            $this->session->set_flashdata('success2', 'Aplikasi sudah diperbarui');
                            
                        } else {
                            $this->session->set_flashdata('error2', 'Gagal Update');
                        }
    
                        unlink($location);
                    }
                } else {
                    $this->session->set_flashdata('error2', 'Hanya mendukung format .zip');
                }
                redirect('pengaturan/pembaharuan');
            }    

		} else {
			$this->load->view('404');
		}

        if(isset($_POST['simpan'])) {
            $input = $this->input->post(null, true);
            $this->conf->update_tambahan($input);
            $this->session->set_flashdata('success', 'Pengaturan tambahan diupdate');
            redirect('pengaturan/tambahan');
        }
	}

    function hps_menu($id = null) {
        $this->conf->hps_menu($id);
        $this->session->set_flashdata('hapus', 'Data menu sudah dihapus');
        redirect('pengaturan/menu');
    }

    function hps_sub($id = null) {
        $this->conf->hps_submenu($id);
        $this->session->set_flashdata('hapus', 'Data submenu sudah dihapus');
        redirect('pengaturan/menu');
    }

}
