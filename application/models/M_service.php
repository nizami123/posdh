<?php 

class m_service extends CI_Model {
    private $tb_service = 'tb_service';
    var $src_service    = ['nama_custumer'];

    private function __data_service() {
        $this->db->from($this->tb_service . ' serv');
        
        $i = 0;
        foreach ($this->src_service as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_service) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function count() {
        $this->__data_service();
        return $this->db->get()->num_rows();
    }

    function count_all() {
        $this->db->from($this->tb_service);
        return $this->db->count_all_results();
    }

    function data_service($ordering = 'ASC') {
        $this->__data_service();
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        $this->db->order_by('id_service', $ordering);
        return $this->db->get()->result();
    }

    function service($id) {
        $this->__data_service();
        $this->db->where('id_service', $id);
        return $this->db->get()->row();
    }

    function tambah_service($input) {
        $data = [
            'nama_service'  => $input['nama'],
            'alamat'     => $input['alamat'],
            'jenis_service' => 'Cabang'
        ];

        $this->db->insert($this->tb_service, $data);
    }

    function ubah_service($input) {
        $id = $input['u_id'];
        $data = [
            'nama_service'  => $input['u_nama'],
            'alamat'     => $input['u_alamat'],
        ];

        $this->db->where('id_service', $id);
        $this->db->update($this->tb_service, $data);
    }

    function hapus($id) {
        $this->db->delete($this->tb_service, ['id_service' => $id]);
    }

    function pindah ($id) {
        $data  = ['id_service' => $id];
        $where = ['id_admin' => admin()->id_admin];
        $this->db->update ('tb_admin', $data, $where);
    }
}