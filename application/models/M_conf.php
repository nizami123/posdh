<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_conf extends CI_Model {
    private $master_menu = 'tb_master_menu';
    private $akses_menu  = 'tb_akses_menu';
    private $conf        = 'tb_conf';

    function data_conf() {
        return $this->db->get ($this->conf)->row ();
    }

    function data_menu () {
        $this->db->from ($this->master_menu);
        return $this->db->get()->result ();
    }

    function data_submenu () {
        $this->db->from ($this->master_menu . ' master');

        $this->db->where ('kategori_menu',  'sub');

        return $this->db->get()->result ();
    }

    function data_menu_by_akses ($level, $kategori, $grup) {
        $this->db->from ($this->master_menu . ' master');
        $this->db->join ($this->akses_menu . ' akses', 'master.id_menu = akses.id_menu');

        $this->db->where ('level',  $level);
        $this->db->where ('kategori_menu',  $kategori);
        $this->db->where ('grup_menu',  $grup);

        return $this->db->get()->result ();
    }

    function data_submenu_by_akses ($level, $menu) {
        $this->db->from ($this->master_menu . ' master');
        $this->db->join ($this->akses_menu . ' akses', 'master.id_menu = akses.id_menu');

        $this->db->where ('level',  $level);
        $this->db->where ('menu_utama',  $menu);
        $this->db->where ('kategori_menu',  'sub');
        $this->db->group_by ('akses.id_menu');

        return $this->db->get()->result ();
    }

    function tambah_akses_menu ($data) {
        $this->db->insert_batch ($this->akses_menu, $data);
    }

    function update_conf($input) {
        $data = [
            'logo' => $input['logo']
        ];
        $this->db->update ($this->conf, $data);
    }

    function update_tambahan($input) {
        $data = [
            'ukuran_kertas'       => $input['ukuran_kertas'],
            'jenis_kertas'        => $input['jenis_kertas'],
            'jenis_kertas_struk'  => $input['jenis_kertas_struk'],
            'jml_min_brg'         => $input['jml_min'],
            'expired'             => $input['expired'],
        ];
        $this->db->update ($this->conf, $data);
    }
}