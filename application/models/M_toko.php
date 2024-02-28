<?php 

class m_toko extends CI_Model {
    private $tb_toko  = 'tb_toko';
    private $tb_brg   = 'tb_barang';
    private $tb_retur = 'tb_data_retur';
    private $tb_brgk  = 'tb_detail_brgk';
    private $tb_brgm  = 'tb_detail_brgm';
    private $tb_penjualan = 'tb_detail_penjualan';
    private $tb_opname    = 'tb_info_opname';

    var $src_toko    = ['nama_toko'];

    private function __data_toko() {
        $this->db->from($this->tb_toko . ' toko');
        
        $i = 0;
        foreach ($this->src_toko as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_toko) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function count() {
        $this->__data_toko();
        return $this->db->get()->num_rows();
    }

    function count_all() {
        $this->db->from($this->tb_toko);
        return $this->db->count_all_results();
    }

    function data_toko($ordering = 'ASC') {
        $this->__data_toko();
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        $this->db->order_by('id_toko', $ordering);
        return $this->db->get()->result();
    }

    function toko($id) {
        $this->__data_toko();
        $this->db->where('id_toko', $id);
        return $this->db->get()->row();
    }

    function tambah_toko($input) {
        $data = [
            'nama_toko'  => $input['nama'],
            'alamat'     => $input['alamat'],
            'jenis_toko' => 'Cabang'
        ];

        $this->db->insert($this->tb_toko, $data);
    }

    function ubah_toko($input) {
        $id = $input['u_id'];
        $data = [
            'nama_toko'  => $input['u_nama'],
            'alamat'     => $input['u_alamat'],
        ];

        $this->db->where('id_toko', $id);
        $this->db->update($this->tb_toko, $data);
    }

    function hapus($id) {
        $this->db->delete($this->tb_toko, ['id_toko' => $id]);
        $this->db->delete($this->tb_brg, ['id_toko' => $id]);
        $this->db->delete($this->tb_retur, ['id_toko' => $id]);
        $this->db->delete($this->tb_brgm, ['id_toko' => $id]);
        $this->db->delete($this->tb_brgk, ['id_toko' => $id]);
        $this->db->delete($this->tb_penjualan, ['id_toko' => $id]);
        $this->db->delete($this->tb_opname, ['id_toko' => $id]);
    }

    function pindah ($id) {
        $data  = ['id_toko' => $id];
        $where = ['id_admin' => admin()->id_admin];
        $this->db->update ('tb_admin', $data, $where);
    }
}