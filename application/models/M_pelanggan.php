<?php 

class m_pelanggan extends CI_Model {
    private $tb_plg = 'tb_pelanggan';
    var $src_plg    = ['nama_plg'];

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

    function count_plg() {
        $this->__data_plg();
        return $this->db->get()->num_rows();
    }

    function count_all_plg() {
        $this->db->from($this->tb_plg);
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

    function pelanggan($id) {
        $this->__data_plg();
        $this->db->where('id_plg', $id);
        return $this->db->get()->row();
    }

    function tambah_plg($input) {
        $data = [
            'nama_plg'   => $input['nama_plg'],
            'no_ponsel'  => $input['no_ponsel'],
            'alamat'     => $input['alamat'],
            'id_admin'   => admin()->id_admin
        ];

        $this->db->insert($this->tb_plg, $data);
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