<?php 

class m_pelanggan extends CI_Model {
    private $tb_plg = 'tb_pelanggan';
    var $src_plg    = ['nama_plg'];

    private $tb_keluar = 'vbarangkeluar';
    var $src_keluar    = ['sn_brg','nama_brg'];

    private $tb_ksr = 'tb_kasir';
    var $src_ksr    = ['nama_ksr'];

    private $tb_bank = 'tb_bank';
    var $src_bank    = ['nama_bank'];

    private $tb_diskon = 'tb_diskon';
    var $src_diskon    = ['kode_diskon'];

    private $tb_trade = 'v_bekas';
    var $src_trade    = ['nama_trade'];

    private function __data_plg() {
        $this->db->from($this->tb_plg . ' plg');
        
        $i = 0;
        foreach ($this->src_plg as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_plg) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_keluar() {
        $this->db->from($this->tb_keluar . ' plg');
        $this->db->where('status', 2);
        $this->db->where('hrg_jual > 0');
        
        $i = 0;
        foreach ($this->src_keluar as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_keluar) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_ksr() {
        $this->db->from($this->tb_ksr . ' ksr');
        
        $i = 0;
        foreach ($this->src_ksr as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_ksr) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_trade() {
        $this->db->from($this->tb_trade . ' trade');
        
        $i = 0;
        foreach ($this->src_trade as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_trade) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_bank() {
        $this->db->from($this->tb_bank . ' ksr');
        
        $i = 0;
        foreach ($this->src_bank as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_bank) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_diskon() {
        $this->db->from($this->tb_diskon . ' ksr');
        $this->db->join('tb_brg_keluar bk', 'ksr.id_keluar = bk.id_keluar', 'left');
        
        $i = 0;
        foreach ($this->src_diskon as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_diskon) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function count_plg() {
        $this->__data_plg();
        return $this->db->get()->num_rows();
    }

    function count_all_plg() {
        $this->db->from($this->tb_plg);
        return $this->db->count_all_results();
    }

    function count_keluar() {
        $this->__data_keluar();
        return $this->db->get()->num_rows();
    }

    function count_all_keluar() {
        $this->db->from($this->tb_keluar);
        return $this->db->count_all_results();
    }

    function data_plg() {
        $this->__data_plg();
        $this->db->order_by('id_plg', 'desc');
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result();
    }

    function data_keluar() {
        $this->__data_keluar();
        $this->db->order_by('tgl_keluar', 'desc');
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result();
    }

    function count_ksr() {
        $this->__data_ksr();
        return $this->db->get()->num_rows();
    }

    function count_all_ksr() {
        $this->db->from($this->tb_ksr);
        return $this->db->count_all_results();
    }

    function count_trade() {
        $this->__data_trade();
        return $this->db->get()->num_rows();
    }

    function count_all_trade() {
        $this->db->from($this->tb_trade);
        return $this->db->count_all_results();
    }

    function data_trade() {
        $this->__data_trade();
        $this->db->order_by('id_trade', 'desc');
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result();
    }

    function data_ksr() {
        $this->__data_ksr();
        $this->db->order_by('id_ksr', 'desc');
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result();
    }

    function count_bank() {
        $this->__data_bank();
        return $this->db->get()->num_rows();
    }

    function count_all_bank() {
        $this->db->from($this->tb_bank);
        return $this->db->count_all_results();
    }

    function data_bank() {
        $this->__data_bank();
        $this->db->order_by('id_bank', 'desc');
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result();
    }

    function count_diskon() {
        $this->__data_diskon();
        return $this->db->get()->num_rows();
    }

    function count_all_diskon() {
        $this->db->from($this->tb_diskon);
        return $this->db->count_all_results();
    }

    function data_diskon() {
        $this->__data_diskon();
        $this->db->order_by('kode_diskon', 'desc');
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result();
    }

    function pelanggan($id) {
        $this->__data_plg();
        $this->db->where('id_plg', $id);
        return $this->db->get()->row();
    }

    function tambah_plg($input) {
        $data = [
            'id_plg'    => $this->generateid(),
            'nama_plg'   => $input['nama_plg'],
            'no_ponsel'  => $input['no_ponsel'],
            'alamat'     => $input['alamat'],
            'email'      => $input['email'],
        ];

        $this->db->insert($this->tb_plg, $data);
        return $data['id_plg'];
    }

    function ubah_plg($input) {
        $id = $input['u_id_plg'];
        $data = [
            'nama_plg'   => $input['u_nama_plg'],
            'no_ponsel'  => $input['u_no_ponsel'],
            'alamat'     => $input['u_alamat'],
            'id_admin'   => admin()->id_admin
        ];

        $this->db->where('id_plg', $id);
        $this->db->update($this->tb_plg, $data);
    }

    function hapus($id) {
        $this->db->delete($this->tb_plg, ['id_plg' => $id]);
    }
}