<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_barang extends CI_Model {
    private $barang             = 'tb_barang';
    private $grosir             = 'tb_harga_grosir';
    private $brg_masuk          = 'tb_brg_masuk';
    private $brg_keluar         = 'tb_brg_keluar';
    private $detail_brgm        = 'tb_detail_brgm';
    private $detail_brgk        = 'tb_detail_brgk';
    private $satuan             = 'tb_satuan';
    private $kategori           = 'tb_kategori';
    private $supplier           = 'tb_supplier';
    private $admin              = 'tb_admin';
    private $toko               = 'tb_toko';
    private $tb_info_opname     = 'tb_info_opname';
    private $tb_opname          = 'tb_stok_opname';
    private $tb_tambah_opname   = 'tb_tambah_opname';

    var $src_brg                = ['tbm.sn_brg', 'nama_brg'];
    var $src_satuan             = ['nama_satuan'];
    var $src_kategori           = ['nama_kategori'];
    var $src_supplier           = ['nama_supplier'];
    var $src_opname             = ['info.kode_opname', 'adm.nama_admin'];
    var $src_tambah_opname      = ['tbm.sn_brg', 'nama_brg'];

    function __data_brg () {
        $this->db->select ('*,tbk.hrg_jual harga_jual, tbk.hrg_cashback harga_cashback');
        $this->db->from('tb_brg_keluar tbk');
        $this->db->join('tb_brg_masuk tbm', 'tbk.id_masuk = tbm.id_masuk');
        $this->db->join('tb_barang tb', 'tb.id_brg = tbm.id_brg');
        $this->db->join('tb_toko tt', 'tbk.id_toko = tt.id_toko', 'LEFT');
        $this->db->where('tbk.status', '2');

        $i = 0;
        foreach ($this->src_brg as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_brg) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function __data_kat () {
        $this->db->from('tb_barang tbk');

        $i = 0;
        foreach ($this->src_brg as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_brg) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_masuk() {
       $this->db->from($this->brg_masuk . ' brgm');
       $this->db->join($this->barang . ' brg', 'brgm.id_brg = brg.id_brg');
       $this->db->join($this->supplier . ' supplier', 'brgm.id_supplier = supplier.id_supplier', 'left');
       $this->db->join($this->brg_keluar . ' tbk', 'brgm.id_masuk = tbk.id_masuk', 'left');
       $this->db->where('tbk.status', '2');

        $i = 0;
        foreach ($this->src_brg as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->src_brg) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_keluar () {
        $this->db->from ($this->barang . ' brg');
        $this->db->join ($this->brg_keluar . ' keluar', 'brg.kode_brg = keluar.kode_brg');
        $this->db->join ($this->detail_brgk . ' detail', 'detail.kode_keluar = keluar.kode_keluar');
        $this->db->join ($this->admin . ' admin', 'detail.id_admin = admin.id_admin', 'left');

        $i = 0;
        foreach ($this->src_brg as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->src_brg) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function __data_satuan () {
        $this->db->from ($this->satuan . ' satuan');
        // $this->db->join ($this->toko . ' toko', 'admin.id_toko = toko.id_toko', 'left');

        $i = 0;
        foreach ($this->src_satuan as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_satuan) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function __data_kategori () {
        $this->db->from ($this->kategori . ' kategori');
        // $this->db->join ($this->toko . ' toko', 'admin.id_toko = toko.id_toko', 'left');

        $i = 0;
        foreach ($this->src_kategori as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_kategori) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function __data_supplier () {
        $this->db->from ($this->supplier . ' supplier');
        // $this->db->join ($this->toko . ' toko', 'admin.id_toko = toko.id_toko', 'left');

        $i = 0;
        foreach ($this->src_supplier as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_supplier) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_opname() {
        $this->db->from($this->tb_opname . ' opname');
        $this->db->join($this->tb_info_opname . ' info', 'opname.kode_opname = info.kode_opname');
        $this->db->join($this->barang . ' brg', 'opname.id_brg = brg.id_brg');
        $this->db->join($this->admin . ' adm', 'info.id_admin = adm.id_admin', 'left');

        $i = 0;
        foreach ($this->src_opname as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->src_opname) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_tambah_opname() {
        $this->db->from($this->barang . ' brg');
        $this->db->join($this->tb_tambah_opname. ' op', 'brg.id_brg = op.id_brg');

        $i = 0;
        foreach ($this->src_tambah_opname as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->src_tambah_opname) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function count_brg() {
        $toko = $this->session->userdata('sesi_toko');
        $this->__data_brg();
        $this->db->where('tbk.id_toko', $toko);
        return $this->db->get()->num_rows();
    }

    function count_all_brg() {
        $toko = $this->session->userdata('sesi_toko');
        $this->__data_brg();
        $this->db->where('tbk.id_toko', $toko); 
        return $this->db->count_all_results();
    }

    function total_brg() {
        $toko = $this->session->userdata('sesi_toko');
        $this->db->from($this->barang);
        $this->db->where('tbk.id_toko', $toko);        
        return $this->db->count_all_results();
    }
    
    function data_brg ($ordering = 'ASC', $filter = null) {
        $toko = $this->session->userdata('sesi_toko');
        $this->__data_brg ();

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        $this->db->where ('tbk.id_toko', $toko);

        return $this->db->get()->result ();
    }
    
    function brg ($id) {
        $id_toko = $this->session->userdata('sesi_toko');
        $this->__data_brg ();       
        
        $this-> db->where ('tbk.id_toko', $id_toko);
        $this-> db->where ('tbm.id_brg', $id);

        return $this->db->get ()->row ();
    }
    

    function merk () {
        return $this->db->query ("select * from tb_kategori where kode = 'MRK'")->result();
    }

    function jenis () {
        return $this->db->query ("select * from tb_kategori where kode = 'JNS'")->result();
    }
    

    function brg_by_kode ($kode) {
        $id_toko = $this->session->userdata('sesi_toko');
        $this->__data_brg ();       
        
        $this-> db->where ('tbk.id_toko', $id_toko);
        $this-> db->where ('tbm.id_brg', $kode);

        return $this->db->get ()->row ();
    }
    
    function harga_grosir($kode, $val) {
        $rt = [];
        $toko = $this->session->userdata('sesi_toko');
        $brg = $this->db->get_where('tb_barang', ['kode_brg' => $kode, 'id_toko' => $toko])->row();

        if($brg->is_grosir == 0) {
            $rt['is_grosir'] = $brg->is_grosir;
            $rt['harga']     = $brg->harga_eceran;
            $rt['min']       = 1;

        } else {
           
            $max = $this->db->query("SELECT MAX(min_jml_grosir) as maxi FROM tb_harga_grosir WHERE kode_brg = '$kode' AND id_toko = '$toko' ")->row()->maxi;

            $this->db->where('kode_brg', $kode);
            $this->db->where('id_toko', $toko);
            $this->db->where('min_jml_grosir <= ', $val);
            $this->db->order_by('min_jml_grosir ', 'desc');
            $this->db->limit(1);
            
            $data =  $this->db->get($this->grosir)->row();
            if($data) {
                $rt['is_grosir'] = 1;
                $rt['harga']     = $data->harga_grosir_brg;
                $rt['min']       = $data->min_jml_grosir;
                $rt['eceran']    = $brg->harga_eceran;

            } else {
                $rt['is_grosir']  = 0;
                $rt['harga']      = $brg->harga_eceran;
                $rt['eceran']     = '';
            }
        }

        return json_encode($rt);

    }

    function detail_harga_grosir($kode, $val) {
        $rt = [];
        $toko = $this->session->userdata('sesi_toko');
        $data_brg = $this->db->get_where('tb_barang', ['kode_brg' => $kode, 'id_toko' => $toko])->result();
        return $data_brg;
    }
 
    function data_harga_grosir($kode) {
        $toko = $this->session->userdata('sesi_toko');
        $this->db->where('kode_brg', $kode);
        $this->db->where('id_toko', $toko);
        return $this->db->get($this->grosir)->result();
    }

    function kode_brg() {
        return rand(1000, 9999).date('dmy');
    }

    function tambah_barang ($input) {
        $data = [
            'kode_brg'      => $input['kode_brg'],
            'nama_brg'      => $input['nama_brg'],
            'harga_modal'   => $input['harga_modal'],
            'harga_eceran'  => $input['harga_eceran'],
            'stok_tersedia' => $input['stok_brg'],
            'satuan'        => $input['satuan_brg'],
            'kategori'      => $input['kategori_brg'],
            'tgl_exp'       => $input['tgl_exp'] ? $input['tgl_exp'] : '',
            'etalase'       => $input['etalase'],
            'supplier_brg'  => $input['supplier_brg'],
            'is_grosir'     => isset($input['is_grosir']) ? $input['is_grosir'] : 0,
            'is_retur'      => isset($input['is_retur']) ? $input['is_retur'] : 0,
            'id_toko'       => $this->session->userdata('sesi_toko')
        ];

        $this->db->insert ($this->barang, $data);
    }

    function tambah_grosir($input) {
        $this->db->insert_batch($this->grosir, $input);
    }
    
    function ubah_grosir($kode, $input) {
        $this->db->where('id_grosir', $kode);
        $this->db->update($this->grosir, $input);
    }

    function ubah_barang($input) {
        $id   = $input['u_id_brg'];
        $brg  = $this->brg($id);
        $data = [
            'kode_brg'      => $input['u_kode_brg'] ? $input['u_kode_brg'] : $brg->kode_brg,
            'nama_brg'      => $input['u_nama_brg'],
            'harga_modal'   => $input['u_harga_modal'],
            'harga_eceran'  => $input['u_harga_eceran'],
            'kategori'      => $input['u_kategori_brg'],
            'satuan'        => $input['u_satuan_brg'],
            'tgl_exp'       => $input['u_tgl_exp'],
            'etalase'       => $input['u_etalase'],
            'supplier_brg'  => $input['u_supplier_brg'],
            'is_grosir'     => isset($input['u_is_grosir']) ? $input['u_is_grosir'] : 0,
            'is_retur'      => isset($input['u_is_retur'])  ? $input['u_is_retur'] : 0,
        ];

        $this->db->where('id_brg', $id);
        $this->db->update($this->barang, $data);
    }

    function hps_brg ($id) {
        $toko = $this->session->userdata('sesi_toko');
        $this->db->delete ($this->barang, ['kode_brg' => $id, 'id_toko' => $toko]);
    }

    function data_stok_0 ($limit = null) {
        $id_toko = $this->session->userdata('sesi_toko');
        $this->__data_brg ();
        $this->db->where ('tbk.id_toko ', $id_toko);

        if($limit) {
            $this->db->limit ($limit);
        }

        return $this->db->get ()->result ();
    }

    function data_hampir_0 ($limit = null) {
        $id_toko = $this->session->userdata('sesi_toko');
        $min     = conf()->jml_min_brg;
        $this->__data_brg ();
        $this->db->where ('tbk.id_toko ', $id_toko);
        
        if($limit) {
            $this->db->limit ($limit);
        }

        return $this->db->get ()->result ();
    }
    
    
    function count_stok_brg ($limit, $brg) {
        $id_toko = $this->session->userdata('sesi_toko');
        $exp     = conf ()->expired;
        $this->__data_brg ();
        $this->db->where ('tbk.id_toko ', $id_toko);

        return $this->db->get ()->num_rows () - $limit;
    }

    function import_brg($data) {
        $this->db->insert_batch($this->barang, $data);
    }

    function update_import_brg ($data, $kode, $id_toko) {
        $this->db->update($this->barang, $data, ['kode_brg' => $kode, 'id_toko' => $id_toko]);
    }

    function kode_masuk() {
        $id_toko = $this->session->userdata('sesi_toko');
        $kd      = '';
        $m       = date('m');
        $y       = date('Y');

        $q = $this->db->query(
            "SELECT MAX(RIGHT(kode_masuk, 4)) AS kode FROM tb_detail_brgm WHERE id_toko = '$id_toko' AND MONTH(tgl_masuk) = '$m' AND YEAR(tgl_masuk) = '$y' "
        );
        
        if ($q->num_rows() > 0) {
            foreach($q->result() as $k) {
                $tmp = ((int) $k->kode) + 1;
                $kd  = sprintf('%04s', $tmp);
            }

        } else {
            $kd = 0001;
        }
       
        return 'BRGM'.date('my'). $id_toko.$kd;
    }

    function brgm_by_admin() {
        $id_toko = $this->session->userdata('sesi_toko');
        $id      = $this->session->userdata('sesi_id_admin');
        
        $this->__data_masuk();
        $this->db->where ('tbk.id_toko', $id_toko);
        $this->db->limit (10);
        return $this->db->get()->result();
    }

    function count_masuk() {
        $toko = $this->session->userdata('sesi_toko');
        $this->__data_masuk();
        $this->db->where ('tbk.id_toko', $toko);
        if ($this->input->post('id_brg')){
            $this->db->where ('brg.id_brg', $this->input->post('id_brg'));
        }
        return $this->db->get()->num_rows();
    }

    function count_kat() {
        $toko = $this->session->userdata('sesi_toko');
        $this->__data_kat();
        return $this->db->get()->num_rows();
    }

    function nama_kat($id) {
        $this->__data_kat();
        $this->db->where ('id_brg', $id);
        return $this->db->get()->row();
    }

    function count_all_masuk() {
        $toko = $this->session->userdata('sesi_toko');
        $this->db-> from ($this->barang . ' brg');
        $this->db-> join ($this->brg_masuk . ' masuk', 'brg.id_brg = masuk.id_brg');
        $this->db-> join ($this->brg_keluar . ' tbk', 'tbk.id_masuk = masuk.id_masuk');
        $this->db->where ('tbk.id_toko', $toko);
        
        if ($this->input->post('id_brg')){
            $this->db->where ('brg.id_brg', $this->input->post('id_brg'));
        }

        return $this->db->get()->num_rows();
    }

    function count_jml_masuk ($kode) {
        return $this->db->get_where ($this->brg_masuk, ['id_masuk' => $kode])->num_rows ();
    }

    function total_harga_masuk ($kode) {
        $cek =  $this->db->get_where ($this->brg_masuk, ['id_masuk' => $kode])->result ();
        $total = 0;
        foreach($cek as $data) {
            $brg = $this->brg($data->id_brg);
            $harga = $brg ? $brg->harga_modal : 0;
            $subharga = $harga * 1;
            $total += $subharga; 
        }

        return $total;
    }

    function detail_kat() {
        $toko = $this->session->userdata('sesi_toko');
        $level = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');

        $this->__data_kat();

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result ();
    }

    function detail_masuk() {
        $toko = $this->session->userdata('sesi_toko');
        $level = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');

        $this->__data_masuk();

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        $this->db->order_by ('brgm.tgl_masuk', 'desc');
        $this->db->where ('tbk.id_toko', $toko);

        if ($this->input->post('id_brg')){
            $this->db->where ('brg.id_brg', $this->input->post('id_brg'));
        }

        return $this->db->get()->result ();
    }

    function brg_masuk($id) {
        $this->__data_masuk();
        $this->db->where ('brgm.id_brg', $id);
        $this->db->group_by('brgm.id_brg');
        return $this->db->get ();
    }

    function detail_brg_masuk($id) {
        $this->__data_masuk();
        $this->db->group_by ('brgm.id_brg');
        $this->db->where ('brgm.id_brg', $id);

        return $this->db->get ()->row ();
    }

    function tambah_brgm($insert) {
        $this->db->insert_batch ($this->brg_masuk, $insert);
    }

    function tambah_detail_brgm($insert) {
        $this->db->insert ($this->detail_brgm, $insert);
    }

    function update_stok_tersedia ($jml, $where) {
        $this->db->update ($this->barang, $jml, $where);
    }

    function update_harga_modal ($harga, $where) {
        $this->db->update ($this->barang, $harga, $where);
    }

    function hps_brgm ($id) {
        $this->db->delete ($this->brg_masuk, ['id_masuk' => $id]);
    }

    function hps_masuk ($id) {
        $this->db->delete ($this->brg_masuk, ['id_masuk' => $id]);
        $this->db->delete ($this->detail_brgm, ['id_masuk' => $id]);
    }

    function kode_keluar() {
        $id_toko = $this->session->userdata('sesi_toko');
        $kd      = '';
        $m       = date('m');
        $y       = date('Y');

        $q = $this->db->query(
            "SELECT MAX(RIGHT(kode_keluar, 4)) AS kode FROM tb_detail_brgk WHERE id_toko = '$id_toko' AND MONTH(tgl_keluar) = '$m' AND YEAR(tgl_keluar) = '$y' "
        );
        
        if ($q->num_rows() > 0) {
            foreach($q->result() as $k) {
                $tmp = ((int) $k->kode) + 1;
                $kd  = sprintf('%04s', $tmp);
            }

        } else {
            $kd = 0001;
        }
       
        return 'BRGK'.date('my'). $id_toko.$kd;
    }

    function detail_keluar() {
        $toko  = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level = $this->session->userdata('sesi_level');

        $this->__data_keluar();

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        $this->db->order_by ('tgl_keluar', 'desc');
        $this->db->group_by ('keluar.kode_keluar');
        $this->db->where ('detail.id_toko', $toko);
        
        if($level == 'Admin') {
            $this->db->where ('detail.id_admin', $id_admin);
        }

        return $this->db->get()->result ();
    }

    function brg_keluar($id) {
        $this->__data_keluar();
        $this->db->where ('keluar.kode_keluar', $id);
        $this->db->group_by ('brg.kode_brg');
        return $this->db->get ();
    }

    function detail_brg_keluar($id) {
        $this->__data_keluar();
        $this->db->group_by ('keluar.kode_keluar');
        $this->db->where ('detail.kode_keluar', $id);

        return $this->db->get ()->row ();
    }

    function count_keluar() {
        $toko = $this->session->userdata('sesi_toko');
        $this->__data_keluar();
        $this->db->where ('detail.id_toko', $toko);
        return $this->db->get()->num_rows();
    }

    function count_jml_keluar ($kode) {
        return $this->db->get_where ($this->brg_keluar, ['kode_keluar' => $kode])->num_rows ();
    }

    function count_all_keluar($tgl = null) {
        $toko = $this->session->userdata('sesi_toko');
        $this->db-> from ($this->barang . ' brg');
        $this->db-> join ($this->brg_keluar . ' keluar', 'brg.kode_brg = keluar.kode_brg');
        $this->db-> join ($this->detail_brgk . ' detail', 'detail.kode_keluar = keluar.kode_keluar');
        
        $this->db->where ('detail.id_toko', $toko);

        if($tgl) {
            $this->db->where('DATE(tgl_keluar)', date('Y-m-d'));
        }
        
        return $this->db->get()->num_rows();
    }

    function tambah_brgk($insert) {
        $this->db->insert_batch ($this->brg_keluar, $insert);
    }

    function tambah_detail_brgk($insert) {
        $this->db->insert ($this->detail_brgk, $insert);
    }

    function hps_brgk ($id) {
        $this->db->delete ($this->brg_keluar, ['id_keluar' => $id]);
    }

    function hps_keluar ($id) {
        $this->db->delete ($this->brg_keluar, ['kode_keluar' => $id]);
        $this->db->delete ($this->detail_brgk, ['kode_keluar' => $id]);
    }

    function total_harga_keluar ($kode) {
        $toko = $this->session->userdata('sesi_toko');
       
        $cek =  $this->db->get_where ($this->brg_keluar, ['kode_keluar' => $kode])->result ();
        $total = 0;
        foreach($cek as $data) {
            $where = [
                'kode_brg' => $data->kode_brg,
                'id_toko'  => $toko
            ];
            $get_brg = $this->db->get_where($this->barang, $where)->row();
            $harga   = $get_brg ? $get_brg->harga_modal : 0; 
            $subharga = $harga * $data->stok_keluar;
            $total += $subharga; 
        }

        return $total;
    }

    function data_supplier($ordering = null) {
        $this->__data_supplier();
        if($ordering) {
            $this->db->order_by('id_supplier', 'desc');
        }

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        return $this->db->get()->result();
    }

    function count_supplier() {
        $this->__data_supplier();
        return $this->db->get()->num_rows();
    }

    function count_all_supplier() {
        $this->db->from($this->supplier);
        return $this->db->count_all_results();
    }

    function supplier($id) {
        $this->__data_supplier();
        $this->db->where('id_supplier', $id);
        return $this->db->get()->row();
    }

    function tambah_supplier($input) {
        $data = [
            'nama_supplier'  => $input['nama_supplier'],
            'kontak'         => $input['kontak_supplier'],
        ];

        $this->db->insert($this->supplier, $data);
    }

    function ubah_supplier($input) {
        $data = [
            'nama_supplier'  => $input['u_nama_supplier'],
            'kontak'         => $input['u_kontak_supplier'],
        ];

        $this->db->where('id_supplier', $input['u_id_supplier']);
        $this->db->update($this->supplier, $data);
    }

    function hps_supplier($id) {
		$this->db->delete($this->supplier, ['id_supplier' => $id]);
	}

    function data_satuan($ordering = null) {
        $this->__data_satuan();
        
        if($ordering) {
            $this->db->order_by('id_satuan', 'desc');
        }

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        return $this->db->get()->result();
    }

    function satuan($id) {
        $this->db->where('id_satuan', $id);       
        return $this->db->get($this->satuan)->row();
    }

    function count_satuan() {
        $this->__data_satuan();
        return $this->db->get()->num_rows();
    }

    function count_all_satuan() {
        $this->db->from($this->satuan);
        return $this->db->count_all_results();
    }

    function tambah_satuan($input) {
        $data = [
            'nama_satuan'   => $input['nama_satuan'],
        ];

        $this->db->insert($this->satuan, $data);
    }

    function ubah_satuan($input) {
        $data = [
            'nama_satuan'      => $input['u_nama_satuan'],
        ];

        $this->db->where('id_satuan', $input['u_id_satuan']);
        $this->db->update($this->satuan, $data);
    }

    function hps_satuan($id) {
		$this->db->delete($this->satuan, ['id_satuan' => $id]);
	}

    function data_kategori($ordering = null) {
        $this->__data_kategori();
        if($ordering) {
            $this->db->order_by('id_kategori', 'desc');
        }

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        return $this->db->get()->result();
    }

    function count_kategori() {
        $this->__data_kategori();
        return $this->db->get()->num_rows();
    }

    function count_all_kategori() {
        $this->db->from($this->kategori);
        return $this->db->count_all_results();
    }

    function kategori($id) {
        $this->__data_kategori();
        $this->db->where('id_kategori', $id);
        return $this->db->get()->row();
    }

    function tambah_kategori($input) {
        $data = [
            'nama_kategori' => $input['nama_kategori'],
        ];

        $this->db->insert($this->kategori, $data);
    }

    function ubah_kategori($input) {
        $data = [
            'nama_kategori'      => $input['u_nama_kategori'],
        ];

        $this->db->where('id_kategori', $input['u_id_kategori']);
        $this->db->update($this->kategori, $data);
    }

    function hps_kategori($id) {
		$this->db->delete($this->kategori, ['id_kategori' => $id]);
	}

    function count_opname() {
        $id_toko = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level = $this->session->userdata('sesi_level');
        
        $this->__data_opname();
        $this->db->group_by('opname.kode_opname');
        $this->db->where('info.id_toko', $id_toko);

        if($level == 'Admin') {
            $this->db->where ('info.id_admin', $id_admin);
        }

        return $this->db->get()->num_rows();
    }

    function count_all_opname() {
        $id_toko = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level = $this->session->userdata('sesi_level');

        $this->db->from($this->tb_opname . ' opname');
        $this->db->join($this->tb_info_opname . ' info', 'opname.kode_opname = info.kode_opname');
        $this->db->join($this->barang . ' brg', 'opname.id_brg = brg.id_brg');
        $this->db->where('info.id_toko', $id_toko);

        if($level == 'Admin') {
            $this->db->where ('info.id_admin', $id_admin);
        }

        $this->db->group_by('opname.kode_opname');
        return $this->db->get()->num_rows();
    }

    function data_opname($ordering = null) {
        $id_toko  = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    = $this->session->userdata('sesi_level');

        $this->__data_opname();
        if($ordering) {
            $this->db->order_by('info.kode_opname', 'desc');
        }

        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        if($level == 'Admin') {
            $this->db->where ('info.id_admin', $id_admin);
        }

        $this->db->group_by('info.kode_opname');
        $this->db->where('info.id_toko', $id_toko);

        return $this->db->get()->result();
    }

    function opname($id) {
        $this->__data_opname();
        $this->db->where('info.kode_opname', $id);
        return $this->db->get()->result();
    }
    
    function info_opname($id) {
        $this->__data_opname();
        $this->db->where('info.kode_opname', $id);
        $this->db->group_by('info.kode_opname');
        return $this->db->get()->row();
    }
    
    function tambah_brg_opname($id) {
        $insert = [
            'id_brg' => $id,
            'id_toko' => $this->session->userdata('sesi_toko')
        ];
        $this->db->insert($this->tb_tambah_opname, $insert);
    }

    function hapus_brg_opname($id) {
        $where = [
            'id_brg' => $id,
            'id_toko' => $this->session->userdata('sesi_toko')
        ];
        $this->db->delete($this->tb_tambah_opname, $where);
    }
    
    function cek_tambah_opname($id) {
        $this->db->where('id_brg', $id);
        return $this->db->get($this->tb_tambah_opname)->num_rows();
    }

    function data_tambah_opname($cab = null) {
        $this->__data_tambah_opname();
        $this->db->order_by('id', 'desc');
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        return $this->db->get()->result();
    }

    function count_tambah_opname($cab = null) {
        $this->__data_tambah_opname();
        return $this->db->get()->num_rows();
    }

    function count_all_tambah_opname($cab = null) {
        $this->db->from($this->tb_tambah_opname);
        return $this->db->count_all_results();
    }

    function hps_tambah_opname($id) {
		$this->db->delete($this->tb_tambah_opname, ['id' => $id]);
	}

    function kode_opname() {
        $id_toko = $this->session->userdata('sesi_toko');
        $m = date('m');
        $y = date('Y');
        $q = $this->db->query("SELECT MAX(RIGHT(kode_opname, 4)) AS kode FROM tb_info_opname WHERE id_toko = '$id_toko' AND MONTH(tgl_opname) = '$m' AND YEAR(tgl_opname) = '$y' ");
        $kd = '';
        if($q->num_rows() > 0) {
            foreach($q->result() as $k) {
                $tmp = ((int) $k->kode) + 1;
                $kd = sprintf('%04s', $tmp);
            }
        } else {
            $kd = 0001;
        }
       
        return 'OPM'.$this->session->userdata('sesi_toko').date('my').$kd;
    }

    function submit_opname($data) {
        $where = [
            'id_toko' => $this->session->userdata('sesi_toko')
        ];
        $this->db->insert_batch($this->tb_opname, $data);
        $this->db->delete($this->tb_tambah_opname, $where);
    }
        
    function submit_info_opname($data) {
        $this->db->insert($this->tb_info_opname, $data);
    }

    function hps_opname($id) {
        $this->db->delete($this->tb_info_opname, ['kode_opname' => $id]);
        $this->db->delete($this->tb_opname, ['kode_opname' => $id]);
    }
}