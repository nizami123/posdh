<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_penjualan extends CI_Model {
    private $detail     = 'tb_detail_penjualan';
    private $penjualan  = 'tb_penjualan';
    private $keranjang  = 'tb_keranjang';
    private $barang     = 'tb_barang';
    private $admin      = 'tb_admin';
    private $pelanggan  = 'tb_pelanggan';
    private $retur      = 'tb_data_retur';

    var $src_riwayat    = ['tdp.kode_penjualan', 'tpp.nama_plg', 'tpp.id_plg'];
    var $src_retur      = ['nama_brg'];

    private function __data_riwayat() {
        $this->db->select('*, tdp.status status_penjualan, tpp.email email_pel');
        $this->db->from('tb_detail_penjualan tdp');
        $this->db->join('tb_admin ta', 'tdp.id_admin = ta.id_admin', 'LEFT');
        $this->db->join('tb_toko tt', 'ta.id_toko = tt.id_toko', 'LEFT');
        $this->db->join('tb_pelanggan tpp', 'tdp.id_plg = tpp.id_plg', 'LEFT');
        $this->db->join('tb_kasir tk', 'tdp.id_ksr = tk.id_ksr', 'LEFT');
        $this->db->join('tb_bank tbn', 'tdp.id_bank = tbn.id_bank', 'LEFT');

        $i = 0;
        foreach ($this->src_riwayat as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_riwayat) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_detail() {
        $this->db->select('*, tdp.status status_penjualan, tpp.email email_pel');
        $this->db->from('tb_detail_penjualan tdp');
        $this->db->join('tb_penjualan tp', 'tdp.kode_penjualan = tp.kode_penjualan');
        $this->db->join('tb_brg_keluar tbk', 'tp.id_keluar = tbk.id_keluar');
        $this->db->join('tb_brg_masuk tbm', 'tbk.id_masuk = tbm.id_masuk');
        $this->db->join('tb_barang tb', 'tb.id_brg = tbm.id_brg');
        $this->db->join('tb_toko tt', 'tbk.id_toko = tt.id_toko', 'LEFT');
        $this->db->join('tb_admin ta', 'tdp.id_admin = ta.id_admin', 'LEFT');
        $this->db->join('tb_pelanggan tpp', 'tdp.id_plg = tpp.id_plg', 'LEFT');
        $this->db->join('tb_kasir tk', 'tdp.id_ksr = tk.id_ksr', 'LEFT');
        $this->db->join('tb_bank tbn', 'tdp.id_bank = tbn.id_bank', 'LEFT');

        $i = 0;
        foreach ($this->src_riwayat as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_riwayat) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    private function __data_retur() {
        $this->db->from($this->retur . ' retur');
        $this->db->join($this->barang . ' brg', 'retur.kode_brg = brg.kode_brg');
        
        $i = 0;
        foreach ($this->src_retur as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_retur) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }
    }

    function kode() {
        $id_toko = $this->session->userdata('sesi_toko');
        $id_kasir = $this->session->userdata('sesi_kasir'); 
    
        // Get current month and year
        $month = date('m');
        $year = date('y');

        $cut_off = '2024-07-18';
        $q = $this->db->query(
            "SELECT MAX(LEFT(kode_penjualan, 4)) AS kode FROM tb_detail_penjualan where tgl_transaksi >= '".$cut_off."' "
        );
        $kd      = '';

        if($q->num_rows() > 0) {
            foreach($q->result() as $k) {
                $tmp = ((int) $k->kode) + 1;
                $kd  = sprintf('%04s', $tmp);
            }
        } else {
            $kd = 0001;
        }

        $q = $this->db->query(
            "SELECT SUBSTRING(kode_penjualan, 6, 2) AS kode FROM tb_detail_penjualan order by tgl_transaksi desc limit 1"
        );
        $mnt      = '';

        if($q->num_rows() > 0) {
            foreach($q->result() as $k) {
                if ($k->kode == $month){
                    $mnt = $month;
                }else{
                    $tmp = ((int) $k->kode) + 1;
                    $mnt  = sprintf('%02s', $tmp);
                    $kd = 0001;
                }
            }
        } else {
            $mnt = $month;
        }

        return $kd.'/'.$mnt.'/'.$year.'/'.$id_toko.'/'.$id_kasir;
    }
    
    function data_keranjang() {
        $id_toko = $this->session->userdata('sesi_toko');
        $admin   = $this->session->userdata('sesi_id_admin');
        $this->db->select ('*,tbk.hrg_jual harga_jual, tbk.hrg_cashback harga_cashback');
        $this->db->from ($this->keranjang . ' cart');
        $this->db->join ('tb_brg_keluar tbk', 'cart.id_keluar = tbk.id_keluar');
        $this->db->join ('tb_brg_masuk tbm', 'tbk.id_masuk = tbm.id_masuk');
        $this->db->join ('tb_barang tb', 'tb.id_brg = tbm.id_brg');
        $this->db->join ('tb_toko tt', 'tbk.id_toko = tt.id_toko');
        $this->db->where('tt.id_toko', $id_toko);
        $this->db->where('cart.kasir', $admin);
        $this->db->order_by('id_keranjang', 'desc');
        return $this->db->get ()->result();
    }

    function update_stok($kode, $jml) {
        $where = [
            'kode_brg' => $kode,
            'id_toko'  => $this->session->userdata('sesi_toko'),
        ];

        $brg = $this->db->get_where($this->barang, $where)->row();

        $update = [
            'stok_tersedia' => (int) $brg->stok_tersedia - $jml
        ];
        
        $this->db->update ($this->barang, $update, $where);
    }

    function kosongkan_keranjang() {
        $id_toko = $this->session->userdata('sesi_toko');
        $admin   = $this->session->userdata('sesi_id_admin');
        $where   = ['id_toko' => $id_toko, 'kasir' => $admin];
        $cek     = $this->db->get_where ($this->keranjang, $where);

        if($cek ->num_rows() > 0) {
            
            foreach($cek->result() as $item) {
                $brg = $this->db->get_where($this->barang, ['kode_brg' => $item->kode_brg])->row();
                $upstok['stok_tersedia'] = $brg->stok_tersedia + $item->jml;
                $this->db->update($this->barang, $upstok, ['kode_brg' => $item->kode_brg]);
            }
            
            $this->db->delete($this->keranjang, $where);

        } else {
            return 'cart-0';
        }
    }

    function hps_keranjang($id) {
        $admin   = $this->session->userdata('sesi_id_admin');
        $cart    = $this->db->get_where($this->keranjang, ['id_keranjang' => $id, 'kasir' => $admin])->row();
        $upstok['status']  = 2;
        $this->db->update('tb_brg_keluar', $upstok, ['id_keluar' => $cart->id_keluar]);
        $this->db->delete($this->keranjang, ['id_keranjang' => $id, 'kasir' => $admin]);
    }

    function tambah_keranjang ($input) {
        $kode    = $input['kode'];
        $id_toko = $this->session->userdata('sesi_toko');
        $admin   = $this->session->userdata('sesi_id_admin');
        
        $where = [
            'id_keluar' => $kode, 
            'id_toko'  => $id_toko,
            'kasir'    => $admin
        ];
        
        $insert = [
            'id_keluar'       => $kode,
            'jml'             => 1,
            'id_toko'         => $id_toko,
            'kasir'           => $admin,    
            'diskon'          => $diskon
        ];
        
        $cek    = $this->db->get_where($this->keranjang, $where)->row();
        $this->db->insert($this->keranjang, $insert);
        $upstok['status']  = 3;
        $this->db->update('tb_brg_keluar', $upstok, ['id_keluar' => $kode]);
    }

    function tambah_keranjang_search ($input) {
        $kode    = $input['kode'];
        $id_toko = $this->session->userdata('sesi_toko');
        $admin   = $this->session->userdata('sesi_id_admin');
        
        $idKeluar = $this->db->query("select id_keluar from tb_brg_keluar tbk 
        join tb_brg_masuk tbm on tbk.id_masuk = tbm.id_masuk 
        where tbm.sn_brg = '".$kode."'")->row();

        $where = [
            'id_keluar' => $idKeluar->id_keluar, 
            'id_toko'  => $id_toko,
            'kasir'    => $admin
        ];
        
        $insert = [
            'id_keluar'       => $idKeluar->id_keluar,
            'jml'             => 1,
            'id_toko'         => $id_toko,
            'kasir'           => $admin,    
            'diskon'          => 0
        ];
        
        $cek    = $this->db->get_where($this->keranjang, $where)->row();
        $this->db->insert($this->keranjang, $insert);
        $upstok['status']  = 3;
        $this->db->update('tb_brg_keluar', $upstok, ['id_keluar' => $idKeluar->id_keluar]);
    }

    function submit_keranjang($data) {
        $where = [
            'id_toko' => $this->session->userdata('sesi_toko'),
            'kasir'   => $this->session->userdata('sesi_id_admin')
        ];
        $this->db->insert_batch($this->penjualan, $data);
        $this->db->delete($this->keranjang, $where);
    }

    function update_keranjang($data) {
        $this->db->trans_start(); // Start transaction
        // print_r($data);die;
        foreach ($data as $batch) {
            $where = [
                'id_toko' => $this->session->userdata('sesi_toko'),
                'kasir'   => $this->session->userdata('sesi_id_admin'),
                'id_keluar' => $batch['id_keluar'], // Assuming id_keluar is same for all records in each batch
            ];

            print_r($batch['harga_diskon']);
            if ($batch['harga_diskon'] == 0){
                $diskon = $this->db->query("SELECT nilai FROM tb_diskon WHERE kode_diskon = '".$batch['id_diskon']."' and kuota > 0")->result();
                if (empty($diskon[0]->nilai)){
                    $diskon_nilai = 0;
                }else{
                    $diskon_nilai =  $diskon[0]->nilai;
                }
            }else{
                $diskon_nilai = $batch['harga_diskon'];
            }

            $keranjang = [
                'id_keluar' => $batch['id_keluar'],
                'kasir'   => $this->session->userdata('sesi_id_admin'),
                'jml' => $batch['jml'],
                'jenis_penjualan' => 'Eceran',
                'diskon' => $batch['id_diskon'],
                'id_toko' => $this->session->userdata('sesi_toko'),
                'cashback' => $batch['harga_cashback'],
                'diskon_nilai' => $diskon_nilai
            ];
            $this->db->delete($this->keranjang, $where);
            $this->db->insert($this->keranjang, $keranjang);
            
        }

        $this->db->trans_complete(); // Complete transaction

        return $this->db->trans_status(); 
    }

    function submit_detail($data) {
        $this->db->insert($this->detail, $data);
    }

    function cek_jml_jual($kode) {
        return $this->db->get_where($this->penjualan, ['kode_penjualan' => $kode])->num_rows();
    }

    function count_riwayat() {
        $id_toko  = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    =  $this->session->userdata('sesi_level');

        $this->__data_riwayat();
        $this->db->where('ta.id_toko', $id_toko);
        $this->db->where('tdp.id_admin', $id_admin);

        return $this->db->get()->num_rows();
    }

    function count_all_riwayat() {
        $id_toko  = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    =  $this->session->userdata('sesi_level');

        $this->__data_riwayat();
        $this->db->group_by('tdp.kode_penjualan');
        $this->db->where('ta.id_toko', $id_toko);

        if($level == 'Kasir') {
            $this->db->where('tdp.id_admin', $id_admin);
        }

        return $this->db->get()->num_rows();
    }

    function data_riwayat($limit = null) {
        $id_toko  = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    =  $this->session->userdata('sesi_level');

        $this->__data_riwayat();
        $this->db->where('ta.id_toko', $id_toko);
        $this->db->order_by('tgl_transaksi', 'desc');
        $this->db->where('tdp.id_admin', $id_admin);

        if($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result();
    }

    function data_riwayat_today($limit = null) {
        $id_toko  = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    =  $this->session->userdata('sesi_level');

        $this->__data_riwayat();
        $this->db->where_in('tdp.status', [1,2]);
        $this->db->where('tt.id_toko', $id_toko);
        $this->db->where('DATE(tgl_transaksi)', date('Y-m-d'));
        $this->db->order_by('tgl_transaksi', 'desc');
        $this->db->where('tdp.id_admin', $id_admin);

        if($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result();
    }

    function detail($id) {
        $this->__data_detail();
        $this->db->group_by('tp.kode_penjualan');
        $this->db->where('tp.kode_penjualan', $id);

        return $this->db->get()->row();
    }

    function penjualan($id) {
        $id_toko = $this->session->userdata('sesi_toko');
        $this->__data_detail();
        $this->db->where('tp.kode_penjualan', $id);
        $this->db->where('tp.jml > ',  0);
        $this->db->where('tt.id_toko', $id_toko);
        return $this->db->get()->result();
    }

    function update_jml_penjualan($id, $jml) {
        $cek  = $this->db->get_where($this->penjualan, ['id_penjualan' => $id])->row()->jml;
        $data = [
            'jml' => (int) $cek - $jml
        ];
        $this->db->update($this->penjualan, $data, ['id_penjualan' => $id]);
    }

    function jml_penjualan() {
        $level   = $this->session->userdata('sesi_level');
        $id_toko = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');

        $this->__data_riwayat();
        $this->db->where_in('tdp.status', [1,2]);
        $this->db->where('DATE(tgl_transaksi)', date('Y-m-d'));
        $this->db->where('tt.id_toko', $id_toko);
        $this->db->where('tdp.id_admin', $id_admin);
        return $this->db->get()->num_rows();
    }

    function update_detail_bayar($kode, $total) {
        $where = [
            'kode_penjualan' => $kode,
        ];
        $cek  = $this->db->get_where($this->detail, $where)->row();
        $data = [
            'total_keranjang'   => (int) $cek->total_keranjang - $total,
            'bayar'             => (int) $cek->bayar - $total,
        ];
        $this->db->update($this->detail, $data, $where);
    }

    function hps_riwayat($id) {
        $this->db->delete($this->detail, ['kode_penjualan' => $id]);
        $this->db->delete($this->penjualan, ['kode_penjualan' => $id]);
    }

    function count_retur() {
        $id_toko = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    =  $this->session->userdata('sesi_level');

        $this->__data_retur();
        $this->db->where('retur.id_toko', $id_toko);
        $this->db->where('brg.id_toko', $id_toko);

        if($level == 'Kasir') {
            $this->db->where('id_admin', $id_admin);
        }

        return $this->db->get()->num_rows();
    }

    function count_all_retur() {
        $id_toko = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    =  $this->session->userdata('sesi_level');

        $this->db->from($this->retur . ' retur');
        $this->db->join($this->barang . ' brg', 'retur.kode_brg = brg.kode_brg');
        $this->db->where('retur.id_toko', $id_toko);
        $this->db->where('brg.id_toko', $id_toko);

        if($level == 'Kasir') {
            $this->db->where('id_admin', $id_admin);
        }

        return $this->db->get()->num_rows();
    }

    function data_retur() {
        $id_toko  = $this->session->userdata('sesi_toko');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $level    =  $this->session->userdata('sesi_level');

        $this->__data_retur();
        if(@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        if($level == 'Kasir') {
            $this->db->where('id_admin', $id_admin);
        }

        $this->db->where('retur.id_toko', $id_toko);
        $this->db->where('brg.id_toko', $id_toko);
        $this->db->order_by('id_retur', 'desc');
        return $this->db->get()->result();
    }

    function retur($id) {
        $this->__data_retur();
        $this->db->group_by('jual.kode_penjualan');
        $this->db->where('jual.kode_penjualan', $id);

        return $this->db->get()->row();
    }

    function hps_retur($id) {
        $this->db->delete($this->retur, ['id_retur' => $id]);
    }

    function submit_retur($brg) {
        $this->db->insert_batch($this->retur, $brg);
    }
}
