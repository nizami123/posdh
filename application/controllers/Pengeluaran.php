<?php 

class Pengeluaran extends CI_Controller {
    function __construct() {
		parent::__construct();
		belum_login();
		waktu_local();
	}
    
    var $src = ['kode_pengeluaran'];

    private function __data () {
        if($_POST['user'] == 'owner') {
            $this->db->where('id_admin', 1);

        }

        if($_POST['user'] == 'kasir') {
            $toko = $this->session->userdata('sesi_toko');
            $this->db->where('id_admin != 1');
        }

        $this->db->from ('tb_pengeluaran');

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

    private function count() {
        $this->__data();
        return $this->db->get()->num_rows();
    }

    private function count_all() {
        $this->__data();
        return $this->db->count_all_results();
    }

	private function datatables() {
		$this->__data();
		return $this->db->get()->result();
	}

    function index($p = null) {
        $conf = [
			'tabTitle' 	=> 'Pengeluaran | ' . webTitle(),
			'webInfo' => '
				<strong>
					Pengeluaran
				</strong>
				<span>
					Data
				</span>
			',
		];
        
        if(admin()->level != 'Admin') {

            if($p == 'item') {
                $this->layout->load('layout', 'pengeluaran/item', $conf);

            } else if($p == 'tambah') {
                $this->layout->load('layout', 'pengeluaran/tambah', $conf);

            } else {
                $this->layout->load('layout', 'pengeluaran/main', $conf);
            }

		} else {
			$this->load->view('404');
		}
    }

    
    function load_data() {
		$list = $this->datatables();
		$data = [];
		$no = $this->input->post('start');

		foreach ($list as $item) {  
            $detail = $this->db->get_where('tb_pengeluaran_detail', ['kode_pengeluaran' => $item->kode_pengeluaran])->result();
            $jml_item = count($detail);
			$total  = 0;

			$no++;
			$row    = [];
			$row[]  = $no;
			$row[]  = $item->kode_pengeluaran . '
            <div class="mt-0">
                <small class="text-muted">
                    <span>'.$jml_item.' Barang</span>
                    <span class="mx-2"> | </span>
                    <span>Tanggal: '.date('d/m/Y', strtotime($item->tgl)).'</span>
                </small>
            </div>
            <div class="mt-2">
                <a href="javascript:detail('.$item->kode_pengeluaran.')" class="badge badge-primary">
                    Detail
                </a>
                <a href="javascript:hps_item('.$item->kode_pengeluaran.')" class="badge badge-danger">
                    Hapus
                </a>
            </div>
        ';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->count_all(),
			"recordsFiltered"  => $this->count(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

    function tambah() {
        $kode = date('ymdhis').rand(111, 999);

        foreach($_POST['nama'] as $i => $v) {
            $nama = $_POST['nama'][$i];
            $harga = $_POST['harga'][$i];
            
            $this->db->insert(
                'tb_pengeluaran_detail',
                [
                    'kode_pengeluaran'  => $kode,
                    'nama_barang'       => $nama,
                    'harga_modal'       => $harga,
                ]
            );
        }

        $this->db->insert(
            'tb_pengeluaran',
            [
                'kode_pengeluaran'  => $kode,
                'tgl'               => date('Y-m-d H:i:s'),
                'id_admin'          => admin()->id_admin,
                'id_toko'           => admin()->id_toko,
            ]
        );
    }

    function hapus() {
        $kode = $_POST['kode'];

        $this->db->delete('tb_pengeluaran', ['kode_pengeluaran' => $kode]);
        $this->db->delete('tb_pengeluaran_detail', ['kode_pengeluaran' => $kode]);
    }

    function detail() {
        $kode = $_POST['kode'];

        $this->load->view('pengeluaran/detail', ['kode' => $kode]);
    }

    function load_data_item($type = 'Owner') {
        $type = ucwords($type);
        $html = '';
        $this->db->order_by('id', 'DESC');
        $this->db->where('type', $type);
        $get = $this->db->get('tb_pengeluaran_item')->result();

        if($get) {
            foreach($get as $item) {
                $html .= '
                    <div class="col-sm-4">
                        <div class="card border mb-3">
                            <div class="card-body">
                                <strong>'.$item->nama.'</strong>
                                <div class="mt-2">
                                    <button class="badge badge-primary btn_edit_item" data-id="'.$item->id.'">
                                        Ubah
                                    </button>
                                    <button class="badge badge-danger btn_hps_item" data-id="'.$item->id.'">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }

        } else {
            $html = '
                <div class="col-sm-12">
                    <div class="card border">
                        <div class="card-body text-center">
                            Belum ada data
                        </div>
                    </div>
                </div>
            ';
        }

        echo $html;
    }

    function get_detail_item($id) {
        $this->db->where('id', $id);
        $data = $this->db->get('tb_pengeluaran_item')->row();

        echo json_encode($data);
    }

    function get_hps_item($id) {
        $this->db->where('id', $id);
        $data = $this->db->delete('tb_pengeluaran_item');
    }

    function submit_item() {
        $data['nama'] = $_POST['nama'];
        $data['type'] = $_POST['type'];

        if($_POST['id'] == 0) {
            $this->db->insert('tb_pengeluaran_item', $data);
        } else {
            $this->db->update('tb_pengeluaran_item', $data, ['id' => $_POST['id']]);
        }
    }

    function tes() {
        $this->db->select('id_menu, nama_menu');
        $this->db->where('id_menu > 1000');
        $data = $this->db->get('tb_master_menu',)->result();
        echo '<pre>';
        $no = 7;
        foreach($data as $item) {
            ++$no;
            print_r($item);
            $update['id_menu'] = $no;
            // $this->db->update('tb_master_menu', $update, ['id_menu' => $item->id_menu]);
        }



    }
}