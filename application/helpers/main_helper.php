<?php 

function webTitle() {
    return admin ()->nama_toko;
}

function waktu_local () {
    return date_default_timezone_set('Asia/Jakarta');
}

function ucapan () {
    $waktu = date('G');
    $ucapan = 'Hai, ' . admin ()->level;

    if ($waktu >= 2 && $waktu < 11) {
        $ucapan = 'Selamat Pagi';

    } else if ($waktu >= 11 && $waktu < 15) {
        $ucapan = 'Selamat Siang';
        
    } else if ($waktu >= 15 && $waktu < 19) {
        $ucapan = 'Selamat Sore';
        
    } else {
        $ucapan = 'Selamat Malam';

    }

    return $ucapan;
}

function menu ($level, $kategori, $grup) {
    $CI =& get_instance();
    $CI->load->model ('m_conf', 'conf');

    return $CI->conf->data_menu_by_akses ($level, $kategori, $grup);
}

function submenu ($level, $menu) {
    $CI =& get_instance();
    $CI->load->model ('m_conf', 'conf');

    return $CI->conf->data_submenu_by_akses ($level, $menu);
}

function filter_angka($angka) {
    if($angka != 'true') {
        return preg_match("/^[0-9]+$/", $angka);
    } else {
        return 0;
    }
}

function nf ($angka) {
    return number_format ($angka, 0, ',', '.');
}

function sudah_login () {
    $CI =& get_instance();
    $sesi = $CI->session->userdata ('sesi_id_admin');

    if($sesi || !empty($sesi) ) {
        $msg = '
            <strong><i class="fa fa-exclamation-circle mr-1"></i> Peringatan</strong>
			<p class="mb-0 mt-1">
				Anda sudah login sebagai '. admin()->nama_admin .'
			</p>
        ';
        $CI->session->set_flashdata ('warning', $msg);
        redirect();
    } 
}

function belum_login () {
    $CI =& get_instance();
    $sesi = $CI->session->userdata ('sesi_id_admin');

    if(!$sesi || empty($sesi)) {
        $msg = '
            <strong><i class="fa fa-exclamation-circle mr-1"></i> Peringatan</strong>
            <p class="mb-0 mt-1">
                Anda belum login
            </p>
        ';
        $CI->session->set_flashdata ('warning', $msg);
        redirect('login');
    } 
}

function tgl($tgl){
    $en = [
        'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 
        'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec',
        'January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
    ];
    $indo = [
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu',
        'Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab',
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des',
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    return str_replace($en, $indo, trim($tgl));

}

function admin () {
    $CI =& get_instance();
    $CI->load->model ('m_admin', 'admin');
    $sesi = $CI->session->userdata ('sesi_id_admin');
    // print_r($sesi);die;
    return $CI->admin->admin ($sesi);
}

function conf () {
    $CI =& get_instance();
    $CI->load->model ('m_conf', 'conf');

    return $CI->conf->data_conf ();
}

function data_keranjang () {
    $CI =& get_instance();
    $CI->load->model ('m_penjualan', 'jual');

    return $CI->jual->data_keranjang ();
}

function cek_exp() {
    $CI =& get_instance();
    $CI->load->model ('m_barang', 'brg');

    $data = $CI->brg->data_brg ();
    $rt = [];
    foreach($data as $item) {
        if(!empty($item->tgl_exp)) {
            $skr  = date_create(date('Y-m-d'));
            $exp  = date_create(date($item->tgl_exp));			
            $diff = date_diff($exp, $skr);

            if($diff->invert == 0) {
                $rt[] = [
                    'kode_brg' => $item->kode_brg,
                    'nama_brg' => $item->nama_brg,
                    'tgl_exp'  => $item->tgl_exp,
                ]; 
            }
        }
    }	

    return $rt;
}