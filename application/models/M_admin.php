<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_admin extends CI_Model {
    private $admin = 'tb_admin';
    private $toko = 'tb_toko';

    var $src = ['nama_admin', 'level'];

    function __data_admin () {
        $this->db->from ($this->admin . ' admin');
        $this->db->join ($this->toko . ' toko', 'admin.id_toko = toko.id_toko', 'left');

        $i = 0;
        foreach ($this->src as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function data () {
        $this->__data_admin();
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        $this->db->order_by ('id_admin', 'desc');
        $this->db->where ('level != ', 'Owner');
        return $this->db->get()->result ();
    }

    function count() {
        $this->__data_admin();
        return $this->db->get()->num_rows();
    }

    function count_all() {
        $this->db->from($this->admin);
        return $this->db->count_all_results();
    }
    
    function admin ($id) {
        $this->__data_admin ();
        $this-> db->where ('id_admin', $id);
        return $this->db->get ()->row ();
    }
    
    function cek_admin ($username) {
        $this->__data_admin ();
        $this-> db->where ('email_admin', $username);
        return $this->db->get ();
    }

    function tambah_admin ($input) {
        $data = [
            'nama_admin'    => $input['nama'],
            'email_admin'   => $input['email'],
            'id_toko'       => $input['toko'],
            'level'         => $input['posisi'],
            'foto'          => $input['foto'],
            'password'      => $input['pass'],
        ];
        $this->db->insert($this->admin, $data);
    }

    function cek_email ($input) {
        $this->db->where('email_admin', $input['email']);
        
        if(isset($input['id'])) {
            $this->db->where('id_admin != ', $input['id']);
        }

        return $this->db->get($this->admin)->num_rows();
    }

    function ubah_admin($input) {
        $where = [
            'id_admin'      => $input['u_id'],
        ];
        $get = $this->db->get_where('tb_admin', $where)->row();
    
        $data = [            
            'nama_admin'    => $input['u_nama'],
            'email_admin'   => $input['u_email'],
            'id_toko'       => $input['u_toko'],
            'level'         => $input['u_posisi'],
            'foto'          => $input['u_foto'],
        ];

        if($input['u_pass']) {
            $data['password'] = $input['u_pass'];
        }

        $this->db->update($this->admin, $data, $where);
    }

    function hapus($id) {
        $this->db->delete($this->admin, ['id_admin' => $id]);
    }

    function ubah_sandi($sandi) {
        $where = [
            'id_admin' => admin()->id_admin
        ];
        $data = [
            'password' => $sandi
        ];

        $this->db->update($this->admin, $data, $where);
    }
}