<?php 

class m_laporan extends CI_Model {
    private $tb_brg          = 'tb_barang';
    private $tb_brg_masuk    = 'tb_brg_masuk';
    private $tb_detail_brgm  = 'tb_detail_brgm';
    private $tb_brg_keluar   = 'tb_brg_keluar';
    private $tb_detail_brgk  = 'tb_detail_brgk';
    private $tb_penjualan    = 'tb_penjualan';
    private $tb_detail       = 'tb_detail_penjualan';
    private $tb_supplier     = 'tb_supplier';
    private $tb_plg          = 'tb_pelanggan';
    private $tb_admin        = 'tb_admin';
    private $tb_opname       = 'tb_stok_opname';
    private $tb_detail_op    = 'tb_info_opname';
    private $tb_retur        = 'tb_data_retur';

    var $src_jual = ['kode_penjualan', 'nama_plg', 'nama_admin'];
    var $order_jual = ['kode_penjualan' => 'desc'];
    var $column_order = array(null, 'tgl_transaksi', 'kode_penjualan', 'nama_plg', 'bayar', 'nama_admin', null);

    function stok_brg() {
        $toko = $this->session->userdata('sesi_toko');
        $this->db->from('tb_barang brg');
        $this->db->where('id_toko', $toko);
        return $this->db->get()->result();
    }

    function brg_masuk($mulai = null, $selesai = null) {
        $m = date('m');
        $toko = $this->session->userdata('sesi_toko');
        if($mulai) {
            $q  = $this->db->query("SELECT * FROM $this->tb_brg_masuk masuk 
                                             JOIN $this->tb_detail_brgm detail 
                                             ON masuk.kode_masuk = detail.kode_masuk

                                             JOIN $this->tb_brg brg 
                                             ON masuk.kode_brg = brg.kode_brg 

                                             LEFT JOIN $this->tb_supplier sup 
                                             ON masuk.id_supplier = sup.id_supplier

                                             WHERE brg.id_toko = '$toko' AND DATE(tgl_masuk) 
                                             BETWEEN '$mulai' AND '$selesai' 
                                             ORDER BY tgl_masuk DESC"
            )->result();

        } else {
            $q = $this->db->query("SELECT * FROM $this->tb_brg_masuk masuk 
                                            JOIN $this->tb_detail_brgm detail 
                                            ON masuk.kode_masuk = detail.kode_masuk 

                                            JOIN $this->tb_brg brg 
                                            ON masuk.kode_brg = brg.kode_brg 

                                            LEFT JOIN $this->tb_supplier sup 
                                            ON masuk.id_supplier = sup.id_supplier
                                            WHERE brg.id_toko = '$toko' AND MONTH(tgl_masuk) = '$m' 
                                            ORDER BY tgl_masuk DESC"
            )->result();

        }


        return $q;
    }

    function brg_keluar($mulai = null, $selesai = null) {
        $m = date('m');
        $toko = $this->session->userdata('sesi_toko');
        if($mulai) {
            $q  = $this->db->query("SELECT * FROM $this->tb_brg_keluar keluar 
                                             JOIN $this->tb_detail_brgk detail 
                                             ON keluar.kode_keluar = detail.kode_keluar

                                             JOIN $this->tb_brg brg 
                                             ON keluar.kode_brg = brg.kode_brg

                                             WHERE brg.id_toko = '$toko' AND DATE(tgl_keluar) 
                                             BETWEEN '$mulai' AND '$selesai' 
                                             
                                             ORDER BY tgl_keluar DESC"
            )->result();

        } else {
            $q = $this->db->query("SELECT * FROM $this->tb_brg_keluar keluar 
                                            JOIN $this->tb_detail_brgk detail 
                                            ON keluar.kode_keluar = detail.kode_keluar

                                            JOIN $this->tb_brg brg 
                                            ON keluar.kode_brg = brg.kode_brg 

                                            WHERE brg.id_toko = '$toko' AND MONTH(tgl_keluar) = '$m'
                                            ORDER BY tgl_keluar DESC"
            )->result();

        }


        return $q;
    }

    function _data_jual() {
        $this->db->from($this->tb_detail . ' detail');
        $this->db->join($this->tb_plg . ' plg', 'detail.id_plg = plg.id_plg', 'left');
        $this->db->join($this->tb_admin . ' adm', 'detail.id_admin = adm.id_admin', 'left');

        $i = 0;
        foreach ($this->src_jual as $item) {  
            if(@$_POST['search']['value']) { 
                if($i == 0) { 
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->src_jual) - 1 == $i) {
                    $this->db->group_end(); 
                }
            }
            $i++;
        }

        if(isset($_POST['order'])) { 
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }  else if(isset($this->order_jual)) {
            $order = $this->order_jual;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function count_jual($mulai = null, $selesai = null) {
        $this->_data_jual();

        $toko     = $this->session->userdata('sesi_toko');
        $level    = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $m        = date('m');

        $this->db->where('detail.id_toko', $toko);

        if($mulai) {
            $this->db->where("DATE(tgl_transaksi) BETWEEN '$mulai' AND '$selesai'");

        } else {
            $this->db->where("MONTH(tgl_transaksi)", $m);
        }

        if($level == 'Kasir') {
            $this->db->where("detail.id_admin", $id_admin);
        }

        return $this->db->get()->num_rows();
    }
    
    function count_all_jual($mulai = null, $selesai = null) {

        $toko     = $this->session->userdata('sesi_toko');
        $level    = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');
        $m        = date('m');

        $this->db->from('tb_detail_penjualan detail');
        $this->db->where('detail.id_toko', $toko);

        if($mulai) {
            $this->db->where("DATE(tgl_transaksi) BETWEEN '$mulai' AND '$selesai'");

        } else {
            $this->db->where("MONTH(tgl_transaksi)", $m);
        }

        if($level == 'Kasir') {
            $this->db->where("detail.id_admin", $id_admin);
        }

        return $this->db->count_all_results();
    }

    function penjualan($mulai = null, $selesai = null) {
        $this->_data_jual();
        
        $m        = date('m');
        $toko     = $this->session->userdata('sesi_toko');
        $level    = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');

        $this->db->order_by('tgl_transaksi', 'DESC');
        $this->db->where('detail.id_toko', $toko);

        if($mulai) {
            $this->db->where("DATE(tgl_transaksi) BETWEEN '$mulai' AND '$selesai'");

        } else {
            $this->db->where("MONTH(tgl_transaksi)", $m);
        }

        if($level == 'Kasir') {
            $this->db->where("detail.id_admin", $id_admin);
        }

        return $this->db->get()->result();
    }
    
    function terlaris($mulai = null, $selesai = null) {
        $this->db->select('detail.tgl_transaksi, detail.id_toko, jual.harga_jual, jual.jml ,SUM(jual.jml) as terjual, brg.*');
        $this->db->from($this->tb_detail . ' detail');
        $this->db->join($this->tb_penjualan . ' jual', 'detail.kode_penjualan = jual.kode_penjualan');
        $this->db->join($this->tb_brg . ' brg', 'jual.kode_brg = brg.kode_brg');
        $this->db->join($this->tb_admin . ' adm', 'detail.id_admin = adm.id_admin', 'left');
        $this->db->group_by('jual.kode_brg');
        $this->db->order_by('jml', 'DESC');

        $m        = date('m');
        $toko     = $this->session->userdata('sesi_toko');
        $level    = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');

        $this->db->order_by('tgl_transaksi', 'DESC');
        $this->db->where('detail.id_toko', $toko);

        if($mulai) {
            $this->db->where("DATE(tgl_transaksi) BETWEEN '$mulai' AND '$selesai'");

        } 
        // else {
        //     $this->db->where("MONTH(tgl_transaksi)", $m);
        // }

        // if($level == 'Kasir') {
        //     $this->db->where("detail.id_admin", $id_admin);
        // }

        return $this->db->get()->result();
    }

    function opname($mulai = null, $selesai = null) {
        $m = date('m');
        $toko = $this->session->userdata('sesi_toko');
        $level    = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');

        $this->db->from($this->tb_opname . ' opname');
        $this->db->join($this->tb_detail_op . ' detail', 'opname.kode_opname = detail.kode_opname');
        $this->db->join($this->tb_brg . ' brg', 'opname.id_brg = brg.id_brg');
        $this->db->join($this->tb_admin . ' adm', 'detail.id_admin = adm.id_admin', 'left');
        $this->db->order_by('tgl_opname', 'DESC');
        $this->db->where('brg.id_toko', $toko);

        if($mulai) {
            
            $this->db->where("DATE(tgl_opname) BETWEEN '$mulai' AND '$selesai'");

        } else {
            $this->db->where("MONTH(tgl_opname)", $m);
        }

        if($level == 'Admin') {
            $this->db->where("detail.id_admin", $id_admin);
        }

        return $this->db->get()->result();
    }
    
    function retur($mulai = null, $selesai = null) {
        $m        = date('m');
        $toko     = $this->session->userdata('sesi_toko');
        $level    = $this->session->userdata('sesi_level');
        $id_admin = $this->session->userdata('sesi_id_admin');

        $this->db->from($this->tb_retur . ' retur');
        $this->db->join($this->tb_brg . ' brg', 'retur.kode_brg = brg.kode_brg');
        $this->db->join($this->tb_admin . ' adm', 'retur.id_admin = adm.id_admin', 'left');
        $this->db->order_by('tgl_retur', 'DESC');
        $this->db->where('brg.id_toko', $toko);
        $this->db->where('retur.id_toko', $toko);

        if($mulai) {
            $this->db->where("DATE(tgl_retur) BETWEEN '$mulai' AND '$selesai'");

        } else {
            $this->db->where("MONTH(tgl_retur)", $m);
        }

        if($level == 'Kasir') {
            $this->db->where("retur.id_admin", $id_admin);
        }
        
        return $this->db->get()->result();
    }
    
    function keuangan($mulai = null, $selesai = null) {
        $date = date('m');
        $toko = $this->session->userdata('sesi_toko');

        if($mulai) {
            $data_beli       = $this->db->query("SELECT * FROM $this->tb_brg_masuk masuk 
                                                          JOIN $this->tb_detail_brgm detail 
                                                          ON masuk.kode_masuk = detail.kode_masuk 

                                                          JOIN $this->tb_brg brg 
                                                          ON masuk.kode_brg = brg.kode_brg 
                                                          
                                                          WHERE brg.id_toko = '$toko' AND DATE(tgl_masuk) 
                                                          BETWEEN '$mulai' AND '$selesai'"
                                                      
            )->result();
    
            $data_jual       = $this->db->query("SELECT * FROM $this->tb_penjualan jual 
                                                        JOIN $this->tb_detail detail 
                                                        ON jual.kode_penjualan = detail.kode_penjualan
                                                        
                                                        JOIN $this->tb_brg brg 
                                                        ON jual.kode_brg = brg.kode_brg
                                                        WHERE brg.id_toko = '$toko' AND jml > 0 AND DATE(tgl_transaksi) 
                                                        BETWEEN '$mulai' AND '$selesai' "
            )->result();

            $data_keluar       = $this->db->query("SELECT * FROM tb_pengeluaran k 
                                                        JOIN tb_pengeluaran_detail d 
                                                        ON k.kode_pengeluaran = d.kode_pengeluaran
                                                        
                                                        WHERE k.id_toko = '$toko' AND DATE(tgl) 
                                                        BETWEEN '$mulai' AND '$selesai' "
            )->result();

        } else {
            $data_beli       = $this->db->query("SELECT * FROM $this->tb_brg_masuk masuk 
                                                          JOIN $this->tb_detail_brgm detail 
                                                          ON masuk.kode_masuk = detail.kode_masuk

                                                          JOIN $this->tb_brg brg 
                                                          ON masuk.kode_brg = brg.kode_brg 
                                                          WHERE brg.id_toko = '$toko' AND MONTH(tgl_masuk) = '$date'"
            )->result();
    
            $data_jual       = $this->db->query("SELECT * FROM $this->tb_penjualan jual 
                                                        JOIN $this->tb_detail detail 
                                                        ON jual.kode_penjualan = detail.kode_penjualan
                                                        
                                                        JOIN $this->tb_brg brg 
                                                        ON jual.kode_brg = brg.kode_brg
                                                        WHERE brg.id_toko = '$toko' AND MONTH(tgl_transaksi) = '$date'"
            )->result();

            $data_keluar       = $this->db->query("SELECT * FROM tb_pengeluaran k 
                                                        JOIN tb_pengeluaran_detail d 
                                                        ON k.kode_pengeluaran = d.kode_pengeluaran
                                                        
                                                        WHERE k.id_toko = '$toko' AND MONTH(tgl) = '$date'"
            )->result();
            
        }

        $total = 0;
        $jml   = 0;
        foreach($data_keluar as $keluar) {
            $total += $keluar->harga_modal; 
            ++$jml;
        }

        $q['jml_beli']      = $jml;
        $q['jml_jual']      = 0;
        $q['jml_keluar']    = 0;

        $q['total_beli']    = $total ; 
        $q['total_jual']    = 0; 
        $q['total_profit']  = 0; 


        foreach($data_beli as $beli) {
            $q['jml_beli']   += $beli->stok_masuk;
            $q['total_beli'] += ($beli->stok_masuk * $beli->harga_modal);
        }
        
        foreach($data_jual as $jual) {
            $total_harga         =  $jual->jml * $jual->harga_jual;
            $q['jml_jual']      += $jual->jml;
            $q['total_jual']    += $total_harga;
            $q['total_profit']  += $total_harga - ($jual->jml * $jual->harga_modal);
        }

        return $q;
    }

    function pemasukan_today() {
        $toko = $this->session->userdata('sesi_toko');
        $q    = $this->db->query("SELECT * FROM $this->tb_detail tdp
        join tb_penjualan tp on tdp.kode_penjualan = tp.kode_penjualan 
        WHERE id_toko = '$toko' AND DATE(tgl_transaksi) = '".date('Y-m-d')."' and status in (1,2)")->result();

        return $q;
    }
    
    function lap_pembelian($cab) {
        $y = date('Y');
        return $this->db->query("SELECT MONTH(tgl_masuk) AS tgl_m, SUM(jml_masuk) AS jml FROM $this->tb_brg brg JOIN $this->tb_brg_masuk masuk ON brg.id_brg = masuk.id_brg WHERE  masuk.id_cabang = '$cab' AND YEAR(tgl_masuk) = '$y'  GROUP BY tgl_m ORDER BY tgl_m ASC")->result();
    }
    
    function lap_penjualan($cab) {
        $y = date('Y');
        return $this->db->query("SELECT MONTH(detail.tgl_transaksi) AS tgl_t, SUM(jml) AS jml FROM $this->tb_brg brg JOIN $this->tb_penjualan jual ON brg.kode_brg = jual.kode_brg JOIN $this->tb_detail detail ON jual.kode_transaksi = detail.kode_transaksi WHERE detail.id_cabang = '$cab' AND YEAR(detail.tgl_transaksi) = '$y' GROUP BY tgl_t ORDER BY tgl_t ASC")->result();
    }

}