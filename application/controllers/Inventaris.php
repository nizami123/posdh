<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaris extends CI_Controller {
	function __construct () {
		parent::__construct ();
		waktu_local();
		belum_login();

		$this->load->model (
			[
                'm_barang' => 'brg'
			]
		);
	}

	function index () {
		$conf = [
			'tabTitle' 		=> ' Data Barang | ' . webTitle (),
			'jml_stok_0' 	=> count($this->brg->data_stok_0 ()),
			'jml_hampir_0'  => count($this->brg->data_hampir_0 ()),
			'data_kategori' => $this->brg->data_kategori(),
			'data_satuan' => $this->brg->data_satuan(),
			'data_supplier' => $this->brg->data_supplier(),
			'webInfo'  		=> '
				<strong>'. __CLASS__ .'</strong>
				<span>Stok Barang</span>
			'
		];

		$this->layout->load('layout', 'barang/index', $conf);
	}
	
	function get_json($filter = null) {
		$toko = $this->session->userdata('sesi_toko');
		$exp  = conf ()->expired;
        $min  = conf ()->jml_min_brg;

		$this->load->library('datatables');
        $this->datatables->select('kode_brg, nama_brg, stok_tersedia, satuan, tgl_exp');
        $this->datatables->from('tb_barang');
		$this->db->order_by('id_brg', 'DESC');

		if($filter == 'stok-0') {
			$this->datatables->where ('stok_tersedia <= ', 0);

		} else if ($filter == 'hampir-0') {
			$this->datatables->where ('stok_tersedia <= ', $min);
			$this->datatables->where ('stok_tersedia > ', 0);
			
		} else if ($filter == 'stok-1') {
			$this->datatables->where ('stok_tersedia > ', 0);

		} else if ($filter == 'stok-exp') {
			$this->db->where ('DATEDIFF(tgl_exp, NOW()) <= ', $exp);
		}

		$this->datatables->where ('id_toko', $toko);
		$this->datatables->add_column(
			'aksi', 
			'
			<a href="#modal_ubah_brg" data-toggle="modal" class="btn btn-sm btn-primary btn_ubah_brg" data-id="$1">
				<i class="fa fa-edit"></i>
			</a>
			<a href="#modal_detail_brg" data-toggle="modal" data-id="$1" class="btn btn-sm btn-secondary btn_detail_brg">
				<i class="fa fa-eye"></i>
			</a>
			<a href="'.site_url('inventaris/hps_brg/$1').'" class="btn btn-sm btn-danger hps" data-text="<strong>$2</strong> akan dihapus dari daftar">
				<i class="fa fa-trash"></i>
			</a>
			'
			, 
			'kode_brg, nama_brg'
		);

		$this->datatables->add_column(
			'detail',
			'
				<div>
					<strong>$2</strong>
					<br>
					<small>$1</small>
					<small class="mx-2"> | </small>
					<small>
						Stok: $3 $4 
					</small>
				</div>
			',
			'kode_brg, nama_brg, stok_tersedia, satuan'
		);

		$this->datatables->add_column(
			'act',
			'
				<div class="mt-2">
					<a href="#modal_ubah_brg" data-toggle="modal" class="badge badge-primary btn_ubah_brg" data-id="$1">
						Ubah
					</a>
					<a href="#modal_detail_brg" data-toggle="modal" data-id="$1" class="badge badge-secondary btn_detail_brg">
						Detail
					</a>                                        
					
					<span class="mx-2 text-muted"> | </span>
					<a href="'.site_url('inventaris/hps_brg/$1').'" class="badge badge-danger hps" data-text="<strong>$2</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			',
			'kode_brg, nama_brg'
		);
		
		
		print_r($this->datatables->generate());
	}
	
	function load_data_brg($filter = null) {
		$list 	= $this->brg->data_brg('DESC', $filter);
		$data 	= [];
		$no 	= $this->input->post('start');
		foreach ($list as $item) { 
			$grosir = $item->is_grosir == 1 ? 'Tersedia' : 'Tidak tersedia'; 
			$exp 	= $item->tgl_exp ? tgl(date('d M Y', strtotime($item->tgl_exp))) : '-'; 
			$satuan = $item->satuan == 'Tidak ada satuan' || $item-> satuan  == '' ? ' ' :  $item->satuan;

			if($item->stok_tersedia < 1) {
				$text_color = 'text-danger';

			} else if($item->stok_tersedia <= conf()->jml_min_brg) {
				$text_color = 'text-warning';

			} else {
				$text_color = '';
			}
			
			$aksi = admin()->level != 'Kasir' ? '
				<div class="mt-2">
					<a href="#modal_ubah_brg" data-toggle="modal" class="badge badge-primary btn_ubah_brg" data-id="'.$item->id_brg.'">
						Ubah
					</a>
					<a href="#modal_detail_brg" data-toggle="modal" data-id="'.$item->id_brg.'" class="badge badge-secondary btn_detail_brg">
						Detail
					</a>                                        
					
					<span class="mx-2 text-muted"> | </span>
					<a href="'.site_url('inventaris/hps_brg/'.$item->id_brg).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_brg.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			' : '';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = '
				<div class="'.$text_color.'">
					<strong>
						'.$item->nama_brg.'
					</strong>
					<br>
					<small>
						'.$item->kode_brg.'
					</small>
					<small class="mx-2"> | </small>
					<small>
						Stok: '.$item->stok_tersedia.' '.$satuan.' 
					</small>
					<small class="mx-2"> | </small>
					<small>
						Grosir: '.$grosir.'
					</small>
					<small class="mx-2"> | </small>
					<small>
						kadaluarsa: '.$exp.'
					</small>
				</div>								
			' . $aksi ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_brg(),
			"recordsFiltered"  => $this->brg->count_brg(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function tes() {
		// $q = $this->brg->brg(8995757000828);
		// // $q = $this->brg->brg(5359260622);
		// $conf = [
		// 	'tabTitle' => '',
		// 	'webInfo' => '',
		// 	'data' => $q
		// ];
		// $this->layout->load('layout', 'tes', $conf);

        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128, 1, 30)) . '">';
	}

	function hitung() { 
		$inp = $this->input->post();
		$data = $this->brg->harga_grosir($inp['kode'], $inp['val']);
		
		print_r($data);
		
	}

	function detail_brg($id = null) {
		$data   	= $this->brg->brg($id);
		$generator  = new Picqer\Barcode\BarcodeGeneratorHTML();
		$is_retur   = $data->is_retur == 0 ? 'Tidak' : 'Ya';
		$exp 		= $data->tgl_exp ? tgl(date('d M Y', strtotime($data->tgl_exp))) : '';
		$satuan 	= $data->satuan == 'Tidak ada satuan' || $data-> satuan  == '' ? '' :  $data->satuan;

		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Detail Data Barang</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item">
						<a href="#d_cetak_barcode" data-toggle="collapse" class="text-dark text-decoration-none d_collps_brg">
							<div class="float-left child">
								Kode Barang
								<br>
								<i class="fa fa-chevron-down mr-1"></i> 
								<strong>'.$data->kode_brg.'</strong>
							</div>
							<div class="float-right">
								<strong>
									'.
										$generator->getBarcode($data->kode_brg, $generator::TYPE_CODE_128, 1, 35)
									.'
								</strong>
							</div>
						</a>
						<div class="clearfix"></div>
						<form method="post" class="row mt-3 collapse" id="d_cetak_barcode">
							<div class="col-md-4 input-group">
								<input type="hidden" min="1" id="print_id" class="form-control form-control-sm text-center" value="'.$data->id_brg.'" />
								<input type="number" min="1" id="print_jml" class="form-control form-control-sm text-center" value="1" />
								<div class="input-group-append">
									<button class="btn btn-sm btn-dark" id="submit_cetak_barcode">
										<i class="fa fa-print"></i>
									</button>
								</div>
							</div>
						</form>						
                    </li>
                    <li class="list-group-item">
                        <span>
                            Nama Barang
                        </span>
                        <br>
                        <strong>
                            '.$data->nama_brg.'
                        </strong>
                    </li>
					';

					if($data->kategori) {
						$html .= '
							<li class="list-group-item">
								<span class="float-left">
									Kategori
								</span>
								<strong class="float-right">
								'. $data->kategori .'
								</strong>
							</li>
						';
					}
					
					$html .= '
					<li class="list-group-item">
                        <span class="float-left">
                            Harga (Modal)
                        </span>
                        <strong class="float-right">
                           '.nf($data->harga_modal).'
                        </strong>
                    </li>
					<li class="list-group-item">
                        <span class="float-left">
                            Harga (Eceran)
                        </span>
                        <strong class="float-right">
                           '.nf($data->harga_eceran).'
                        </strong>
                    </li>
					';
					if($exp) {
						$html .= '
							<li class="list-group-item">
								<span class="float-left">
									Tgl Kadaluarsa
								</span>
								<strong class="float-right">
								'.$exp.'
								</strong>
							</li>
						';
					}

					if($data->etalase) {
						$html .= '
							<li class="list-group-item">
								<span class="float-left">
									Rak / Etalase
								</span>
								<strong class="float-right">
								'.$data->etalase.'
								</strong>
							</li>
						';
					}
					
					$html .= '
                    <li class="list-group-item">
                        <span class="float-left">
                            Stok Tersedia
                        </span>
                        <strong class="float-right">
                           '.$data->stok_tersedia.' '.$satuan.'
                        </strong>
                    </li>				
                    <li class="list-group-item">
                        <span class="float-left">
                            Retur Barang
                        </span>
                        <strong class="float-right">
                           '.$is_retur.'
                        </strong>
                    </li>				
					
		';

			if($data->is_grosir == 1) {
				$html .= '
					<li class="list-group-item">
						<a href="#d_harga_grosir" class="text-dark text-decoration-none d_collps_brg" data-toggle="collapse">
							<span class="float-left">
								Grosir
							</span>
							<span class="float-right child">
								<i class="fa fa-chevron-down ml-1"></i>
							</span>							
						</a>
						<div class="clearfix"></div>
						<div class="table-responsive mt-3 collapse" id="d_harga_grosir">
							<table class="table table-bordered table-sm">
								<thead class="text-center bg-light">
									<tr>
										<th>Pembelian Minimum</th>
										<th>Harga</th>
									</tr>
								</thead>
								<tbody>
								';
									$data_harga 	= $this->brg->data_harga_grosir($data->kode_brg);
																		
									foreach($data_harga as $grosir) {
										$html .= '
											<tr>
												<td class="text-center">'.$grosir->min_jml_grosir.'</td>
												<td class="text-right">'.nf($grosir->harga_grosir_brg).'</td>
											</tr>
										';
									}
								$html .= '
								</tbody>
							</table>
						</div>
					</li>
				';
			}

		$html .= '
                </ul>
            </div>
		';

		echo $html;
	}

	function form_grosir ($id = null) {
		$data_grosir = $this->brg->data_harga_grosir($id);

		if($data_grosir) {
			$html = '
				<div class="table-responsive col-sm-12">
					<table class="table table-bordered mb-0" id="tb_tambah_satuan">
			';

			foreach($data_grosir as $grosir) {
				$harga = $grosir->harga_grosir_brg;
				$min = $grosir->min_jml_grosir;

				$html .= '
					<tr>
						<td style="width: 120px">
							<input type="number" name="u_min_grosir[]" min="1" class="form-control form-control-sm text-center" placeholder="Min" value="'.$min.'" required>
							<input type="hidden" name="u_id_grosir[]" class="form-control form-control-sm text-center" placeholder="Min" required value="'.$grosir->id_grosir.'">
						</td>
						<td>
							<input type="number" name="u_harga_grosir[]" class="form-control form-control-sm" placeholder="Harga Grosir" value="'.$harga.'" required>
						</td>
					</tr>

				';

			}
						
			$html .= '
					</table>
				</div>
			';

		} else {
			$cek = $this->brg->brg($id);
			if($cek) {
				
				$html = '
					<div class="col-sm-12">
						<a href="" class="add_new_grosir btn btn-secondary mb-3">
							Tambah
						</a>
					</div>
					<div class="table-responsive col-sm-12">
						<table class="table table-bordered mb-0" id="tb_tambah_satuan">
							<tr>
								<td style="width: 120px">
									<input type="number" name="u_min_grosir[]" min="1" class="form-control form-control-sm text-center" placeholder="Min" value="" required>
								</td>
								<td>
									<input type="number" name="u_harga_grosir[]" class="form-control form-control-sm" placeholder="Harga Grosir" value="" required>
								</td>
							</tr>
						</table>
					</div>
				';
					
				

			} else {
				
				$html = '
						<div class="col-sm-12">
							<a href="" class="add_new_grosir btn btn-secondary mb-3">
								Tambah
							</a>
						</div>
						<div class="table-responsive col-sm-12">
							<table class="table table-bordered mb-0" id="tb_tambah_satuan">
								<tr>
									<td style="width: 120px">
										<input type="number" name="min_grosir[]" min="1" class="form-control form-control-sm text-center" placeholder="Min" value="" required>
									</td>
									<td>
										<input type="number" name="harga_grosir[]" class="form-control form-control-sm" placeholder="Harga Grosir" value="" required>
									</td>
								</tr>
							</table>
						</div>
					';
			}
		}


		echo $html;
	}

	function form_ubah_brg ($id = null) {
		$data 		   = $this->brg->brg($id);
		$data_satuan   = $this->brg->data_satuan();
		$data_kategori = $this->brg->data_kategori();
		$data_supplier = $this->brg->data_supplier();
		$kategori 	   = $data->kategori ? $data->kategori : 'Tidak berkategori';
		$satuan 	   = $data->satuan ? $data->satuan : 'Tidak ada satuan';
		$cek_grosir    = $data->is_grosir == 1 ? 'checked' : '';

		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Ubah Data Barang</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Kode Barang</label>
                        <input type="hidden" name="u_id_brg" value="'.$data->id_brg.'">
                        <input type="text" class="form-control form-control-sm" name="u_kode_brg" value="'.$data->kode_brg.'">
                        <small class="text-muted">Jika kode barang kosong, maka akan dibuatkan kode otomatis</small>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Nama Barang <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm" name="u_nama_brg" required value="'.$data->nama_brg.'">
                    </div>                    
                    <div class="form-group col-md-12">
                        <label for="">Harga (Modal) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="u_harga_modal" required value="'.$data->harga_modal.'">
                    </div>      
                    <div class="form-group col-md-12">
                        <label for="">Harga (Eceran) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="u_harga_eceran" required value="'.$data->harga_eceran.'">
                    </div>      
					<div class="form-group col-sm-12">
                        <label for="">Tgl Kadaluarsa</label>
                        <input type="date" class="form-control form-control-sm" name="u_tgl_exp" value="'.$data->tgl_exp.'" >
                    </div>                                 
                    <div class="form-group col-md-12">
                        <label for="">Kategori</label>
                        <select class="form-control form-control-sm select2" name="u_kategori_brg">
                            <option>
								'.$kategori.'
							</option>
			';
					foreach($data_kategori as $kategori) {
						
						$html .= '
							<option>
								'. $kategori->nama_kategori .'
							</option>
						';

						
					}

            $html .= '
                        </select>
                    </div>    
					
					<div class="form-group col-md-12">
                        <label for="">Satuan</label>
                        <select class="form-control form-control-sm select2" name="u_satuan_brg">
                            <option>
								'.$satuan.'
							</option>
		';

	
					foreach($data_satuan as $satuan) {
						
						$html .= '
							<option>
								'. $satuan->nama_satuan .'
							</option>
						';

						
					}

            $html .= '
                        </select>
                    </div>  
					<div class="form-group col-sm-12">
                        <label for="">Supplier</label>
                        <select class="form-control form-control-sm select2" name="u_supplier_brg">
                            <option value="">Pilih Supplier</option>
					';
                            foreach($data_supplier as $supplier) {
								$selected = $data->supplier_brg == $supplier->id_supplier ? 'selected' : '';
								$html .= '
									<option value="'.$supplier->id_supplier.'" '.$selected.'>
										'.$supplier->nama_supplier.'
									</option>
								';
							}
							
                    $html .= '
                        </select>
                    </div>
			
					<div class="form-group col-sm-12">
						<label for="">Rak / Etalase </label>
						<input type="text" class="form-control form-control-sm" name="u_etalase" value="'.$data->etalase.'" >
					</div>                                  
		';

		if($data->is_retur == 0) {
			$html .= '
				<div class="form-group col-md-12">
					<div class="d-flex justify-content-between">
						<label>Retur Barang</label>
						<div class="custom-control custom-switch">
							<input type="checkbox" id="u_sw_retur" name="u_is_retur" class="custom-control-input" value="0">
							<label for="u_sw_retur" class="custom-control-label">
								<small id="u_sw_retur_text">Nonaktif</small>
							</label>
						</div>                            
					</div>
				</div>
				';
				
			} else {
				$html .= '
					<div class="form-group col-md-12">
						<div class="d-flex justify-content-between">
							<label>Retur Barang</label>
							<div class="custom-control custom-switch">
								<input type="checkbox" id="u_sw_retur" name="u_is_retur" class="custom-control-input" value="1" checked>
								<label for="u_sw_retur" class="custom-control-label">
									<small id="u_sw_retur_text">Aktif</small>
								</label>
							</div>                            
						</div>
					</div>
				';
			}

		
		$html .= '
                            
                    <div class="form-group col-md-12 mt-2">
                        <div class="d-flex justify-content-between">
                            <label>Penjualan Grosir</label>
                            <div class="custom-control custom-switch">
		';
						if($data->is_grosir == 1) {
							$html .='
								<input type="checkbox" id="u_sw_grosir" name="u_is_grosir" data-id="'.$data->kode_brg.'" class="custom-control-input" value="1" checked>
								<label for="u_sw_grosir" class="custom-control-label">
                                    <small id="u_sw_grosir_text">Aktif</small>
                                </label>
							';
						} else {
							$html .='
								<input type="checkbox" id="u_sw_grosir" name="u_is_grosir" data-id="'.$data->kode_brg.'" class="custom-control-input" value="0">
								<label for="u_sw_grosir" class="custom-control-label">
                                    <small id="u_sw_grosir_text">Nonaktif</small>
                                </label>
							';

						}
		$html .= '
                                
                            </div>                            
                        </div>
                        <div class="form_ubah_inp_grosir row mt-3">
		';

							if($data->is_grosir == 1) {
								$html .= '
									<div class="table-responsive col-sm-12">
										<table class="table table-bordered mb-0" id="tb_tambah_satuan">
										';

										$data_harga 	= $this->brg->data_harga_grosir($data->kode_brg);
										foreach($data_harga as $grosir) {
											$html .= '
												<tr>
													<td style="width: 120px">
														<input type="number" name="u_min_grosir[]" class="form-control form-control-sm text-center" placeholder="Min" required value="'.$grosir->min_jml_grosir.'">
														<input type="hidden" name="u_id_grosir[]" class="form-control form-control-sm text-center" placeholder="Min" required value="'.$grosir->id_grosir.'">
													</td>
													<td>
														<input type="number" name="u_harga_grosir[]" class="form-control form-control-sm" placeholder="Harga Grosir" required value="'.$grosir->harga_grosir_brg.'">
													</td>
												</tr>
											';
										}

										$html .= '
										</table>
									</div>
								';
							}

		$html .= '
						</div>
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
		';

		echo $html;
	}

	public function barcode($sn){
		$this->zend->load('Zend/Barcode');
		$imageResource = Zend_Barcode::factory('code128','image', array('text'=>$sn), array())->draw();
		$imageName = $sn.'.jpg';
			// Define the image path based on the environment
			if ($_SERVER['SERVER_NAME'] == 'localhost') {
			  // Path for localhost
				$imagePath = './assets/dhdokumen/snbarcode/';
			} else {
				// Path for server
				$imagePath = 'https://live.akira.id/dev-dhtech/assets/dhdokumen/snbarcode/';
			}
		imagejpeg($imageResource, $imagePath.$imageName);
	}

	function proses_tambah_brg() {
		$uniqueId = uniqid('', true); // Include more entropy
		$randomNumericPart = rand(1000, 9999); // Generate a random 4-digit number using rand()
		
		$newID = 'DHP-' . str_pad($randomNumericPart, 4, '0', STR_PAD_LEFT);

		$input = $this->input->post(null, true);

		if(empty($input['nama_brg'])) {
			echo 'Nama barang belum diisi!';

		} else {

			$data = array(
				'id_brg'		=> $newID,
				'merk'			=> $input['merk'],
				'jenis'			=> $input['jenis'],
				'nama_brg'		=> $input['nama_brg'],
				'Status'		=> 1
			);

			$barang = $this->db->insert('tb_barang', $data);

			$data = array(
				'id_supplier'	=> 'DHSUPP-0001',
				'id_brg'		=> $newID,
				'tgl_masuk'		=> date('Y-m-d H:i:s'),
				'no_fm'			=> '123',
				'sn_brg'		=> $input['sn_brg'],
				'spek'			=> $input['spek'],
				'kondisi'		=> 'Bekas',
				'Status'		=> 1
			);

			$masuk = $this->db->insert('tb_brg_masuk', $data);

			$this->barcode($input['sn_brg']);

			$kode_masuk = $this->db->query("select id_masuk from tb_brg_masuk order by id_masuk desc limit 1")->row();
			$harga = str_replace('.', '', $input['harga']); // Hilangkan tanda titik sebagai pemisah ribuan
			$harga = (int) $harga;
			$data = array(
				'id_masuk	'	=> $kode_masuk->id_masuk,
				'id_toko'		=> $this->session->userdata('sesi_toko'),
				'tgl_keluar'	=> date('Y-m-d H:i:s'),
				'no_surat_keluar'=> '123',
				'hrg_hpp'		=> $harga,
				'Status'		=> 2
			);

			$keluar = $this->db->insert('tb_brg_keluar', $data);
		}
	}

	function proses_ubah_brg() {
		$input = $this->input->post(null, true);

		if(empty($input['u_nama_brg'])) {
			echo 'Nama barang belum diisi!';

		} else if(empty($input['u_harga_eceran'])) {
			echo 'Harga eceran belum diisi!';

		} else {
			if(filter_angka($input['u_harga_eceran']) == 0) {
				echo 'Inputan harga eceran harus angka';
				
			} else {
				$kode = $input['u_kode_brg'];
				$id_brg   = $input['u_id_brg'];
				$cek  = $this->brg->data_harga_grosir($kode);
				$toko = $this->session->userdata('sesi_toko');

				$toko      = $this->session->userdata('sesi_toko');
				$cek_kode  = $this->db->get_where('tb_barang', ['kode_brg' => $kode, 'id_toko' => $toko, 'id_brg != ' => $id_brg])->num_rows();

				if($cek_kode == 0) {
					if($cek) {
						if(isset($input['u_is_grosir'])) {
							foreach($input['u_id_grosir'] as $idx => $val) {
								$idg = $this->input->post('u_id_grosir['.$idx.']');
								$up_grosir = [
									'min_jml_grosir' => $this->input->post('u_min_grosir['.$idx.']'),
									'harga_grosir_brg' => $this->input->post('u_harga_grosir['.$idx.']'),
								];
								$this->brg->ubah_grosir($idg, $up_grosir);
								// print_r($idg);
							}
							
						}
	
					} else {
						if(isset($input['u_is_grosir'])) {
							$data_grosir = array_combine($input['u_harga_grosir'], $input['u_min_grosir']);
							$ins_grosir = [];
	
							foreach($data_grosir as $harga => $min) {
								$ins_grosir[] = [
									'kode_brg' => $kode,
									'min_jml_grosir' => $min,
									'harga_grosir_brg' => $harga,
									'id_toko' => $toko
								];
							}
							$this->brg->tambah_grosir($ins_grosir);
						}
					}
					
					$this->brg->ubah_barang($input);
					// print_r($input);

				} else {
					echo 'Kode barang sudah tersedia';
				}
			}
		}
	}

	function print_barcode_brg($id = null, $jml = null) {
		$generator  = new Picqer\Barcode\BarcodeGeneratorPNG();
		$data 		= $this->brg->data_brg();
		$width 		= conf()->jenis_kertas == 'HVS' ? '100%' : conf()->ukuran_kertas . 'mm';

		$html = '
			<html>
				<head>
					<title>Cetak Barcode</title>
					<style>
						@page {
							margin: 3px;
						}
						.print_area {
							width: 100%;
							max-width: '.$width.';
						}
		';
			if(conf()->jenis_kertas == 'Termal') {
				$html .= '
					.list {
						margin-bottom: 3px;
						border: 2px solid #000;
						padding: 7px 10px;
						text-align:center;
						max-width: 100%;
					}
				';

			} else {
				$html .= '
					.list {
						float:left;
						margin-left: 3px;
						margin-bottom: 3px;
						border: 2px solid #000;
						padding:7px 10px;
						min-width: 100px;
						text-align:center;
					}
				';
			}
		$html .= '
					</style>
				</head>
				<body>
				<div class="print_area">
		';

		if($id && $jml) {	
			$data = $this->brg->brg($id);
			if($data) {
				for($i = 1; $i <= $jml; $i++) {
		
					$html .= '<div class="list"><img style="margin: 0 auto 5px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->kode_brg, $generator::TYPE_CODE_128, 1, 35)) . '">' . '<br><small style="margin-top: 5px;">'.$data->kode_brg.'</small>' . '</div>';
				
				} 

			} else {
				redirect(strtolower(__CLASS__) . '/' . __FUNCTION__);
			}
			
		} else {	
					
			foreach($data as $data) {
				$html .= '<div class="list"><img style="margin: 0 auto 5px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->kode_brg, $generator::TYPE_CODE_128, 1, 35)) . '">' . '<br><small style="margin-top: 5px;">'.$data->kode_brg.'</small>' . '</div>';
			}

		}
		$html .= '
				</div>
				</body>
			</html>
		';

        echo $html;
		echo '<script>print()</script>';
	}

	function hps_brg ($id) {
		$this->brg->hps_brg ($id);
	}

	function brg_masuk() {
		$conf = [
			'tabTitle' 	=> 'Barang Masuk | ' . webTitle(),
			'data_brg'  => $this->brg->data_brg (),
			'data_supplier'  => $this->brg->data_supplier (),
			'webInfo' => '
				<strong>'. __CLASS__ .'</strong>
				<span>Barang Masuk</span>
			',
			'data_merk'  => $this->brg->merk(),
			'data_jenis'    => $this->brg->jenis(),
			
		];
		$this->layout->load('layout', 'barang/brg_masuk', $conf);
	}


	
	function brg_tambah($id) {
		
		$conf = [
			'tabTitle' 	=> 'Barang Masuk | ' . webTitle(),
			'data_brg'  => $this->brg->data_brg (),
			'nama_brg'  => $this->brg->nama_kat($id),
			'data_supplier'  => $this->brg->data_supplier (),
			'webInfo' => '
				<strong>'. __CLASS__ .'</strong>
				<span>Barang Masuk</span>
			',
			
		];
		$this->layout->load('layout', 'barang/brg_tambah', $conf);
	}

	function load_data_brgm() {
		$list = $this->brg->detail_kat();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$aksi = '
				<div>
					<a href="'.site_url('inventaris/brg_tambah/'.$item->id_brg).'" class="badge badge-secondary btn_load_brgm">
						Detail
					</a>
				</div>
			';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->nama_brg;
			$row[] = $item->jenis;
			$row[] = $item->merk;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_masuk(),
			"recordsFiltered"  => $this->brg->count_masuk(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_modal_data_brgm() {
		$list 	= $this->brg->detail_masuk();
		$data 	= [];
		$no 	= $this->input->post('start');
		foreach ($list as $item) { 
			$aksi = '
				<div>
					<a href="'.site_url('inventaris/brg_tambah/'.$item->id_brg).'" class="badge badge-danger btn_load_brgm">
						Hapus
					</a>
				</div>
			';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->nama_brg;
			$row[] = $item->merk . ' | '. $item->jenis;
			$row[] = $item->sn_brg;
			$row[] = $item->spek;
			$row[] = $item->kondisi;
			$row[] = $aksi;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_masuk(),
			"recordsFiltered"  => $this->brg->count_masuk(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function detail_masuk ($kode = null) {
		$data 	= $this->brg->brg_masuk ($kode)->result ();
		$detail = $this->brg->detail_brg_masuk ($kode);

		$html 	= '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Barang
                    </h5>
                    <small>Detail barang masuk</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
				<div class="table-responsive">
					<table class="table table-borderless table-sm w-100">
						<tr>
							<td style="width: 150px">Kode Masuk</td>
							<th style="width: 20px">:</th>
							<th>'.$detail->id_masuk.'</th>
						</tr>
						<tr>
							<td>Tgl Masuk</td>
							<th>:</th>
							<th>'.date('d M Y G:i', strtotime($detail->tgl_masuk)).'</th>
						</tr>
					</table>			
            	</div>
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="tb_form_add_brgm">
                        <thead class="text-center">
                            <th colspan="2">Barang</th>
                            <th style="width: 150px;">Harga Modal</th>
                            <th style="width: 100px">Masuk</th>
                            <th style="width: 150px;">Harga Beli</th>
                            <th style="width: 150px;">Subtotal</th>
                            <th style="width: 150px;">Supplier</th>
                            <th style="width: 250px;">Keterangan</th>
                        </thead>
                        <tbody>
			';
				$total = 0;
				foreach($data as $item) {
				    $brg = $this->brg->brg($item->id_brg);
				    $harga = $brg ? $brg->harga_modal : 0;
					$subtotal  = $item->stok_masuk * $harga;
					$total    += $subtotal; 
					$html 	 .= '
						<tr>
							<td style="width: 50px;text-align:center"> 
								<a href="'.site_url('inventaris/hps_brgm/'.$item->id_masuk).'" class="btn btn-danger hps_brgm">
									<i class="fa fa-trash"></i>
								</a>
							</td>
							<td>
								'.$item->nama_brg.'
							</td>							
							<td class="text-right">
								'.nf($item->harga_modal).'
							</td>
							<td class="text-right">
								'.nf($item->harga_beli).'
							</td>
							<td class="text-right">
								'.nf($subtotal).'
							</td>
							<td>
								'.$item->nama_supplier.'
							</td>
							<td>
								'.$item->keterangan.'
							</td>
						</tr>
					';
				}

			$html .= '
                        </tbody>
						
                        <tfoot>
							<tr>
								<th colspan="7" class="text-right">Grand total</th>
								<th>'.nf($total).'</th>
							</tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-light" data-dismiss="modal">
                    Tutup
                </a>
            </div>
		';

		echo $html;
	}

	function form_add_brgm () {
		$kode 			= $this->input->post('kode');
		$brg  			= $this->brg->brg_by_kode ($kode);
		$data_supplier  = $this->brg->data_supplier ();
		
		if($brg) {
			$html = '
				<tr class="tr_add_brgm" data-kode="'.$brg->id_brg.'">
					<td style="width: 50px;" class="text-center">
						<a href="" class="btn btn-danger hps_add_brgm" data-id="'.$brg->id_brg.'">
							<i class="fa fa-trash"></i>
						</a>
					</td>
					<td>
						<input type="text" class="form-control" value="'.$brg->nama_brg.'" disabled>
						<input type="hidden" class="form-control" value="'.$brg->kode_brg.'" name="nama_brgm[]">
					</td>
					
					<td>
						<input type="number" 
							   class="form-control harga_modal_brgm" 
							   id="modal_'.$brg->id_brg.'"
							   name="harga_modal[]" 
							   data-id="'.$brg->id_brg.'"  
							   value="'.$brg->harga_modal.'" 
							   readonly
							   required
						>
					</td>
					<td>
						<input type="number" 
							   class="form-control text-center qty_masuk" 
							   name="stok_masuk[]" 
							   data-id="'.$brg->id_brg.'"  
							   value="1" 
							   required
						>
					</td>
					<td>
						<input type="number" 
							   class="form-control subharga" 
							   name="harga[]" 
							   value="'.$brg->harga_modal.'" 
							   data-harga="'.$brg->harga_modal.'" 
							   id="harga_'.$brg->id_brg.'" 
							   required
						>
					</td>
					<td>
						<select class="form-control select2" name="supplier[]" >
							<option value="">Pilih</option>
							';
							foreach ($data_supplier as $supplier) {
								$selected = $supplier->id_supplier == $brg->supplier_brg ? 'selected' : '';
								$html .= '
									<option value="'.$supplier->id_supplier.'" '.$selected.'>
										'.$supplier->nama_supplier.'
									</option>
								';
							}
			$html .= '
						</select>
					</td>
					<td>
						<input type="text" class="form-control" name="ket[]">
					</td>
				</tr>
			';

		} else {
			$html = 'empty';
		}

		echo $html;
	}

	function proses_submit_brgm () {
		$id_toko = admin()->id_toko;
		$input 	 = $this->input->post (null);
		$kode 	 = $this->brg->kode_masuk ();
		$insert  = [];

		foreach ($input['nama_brgm'] as $k => $v) {
			$brg 	  = $this->brg->brg ($v);
			$jml 	  = $this->input->post ('stok_masuk['.$k.']');
			$insert[] = [
				'kode_masuk'	=> $kode,
				'kode_brg' 		=> $this->input->post ('nama_brgm['.$k.']'),
				'stok_masuk' 	=> $jml,
				'harga_beli' 	=> $this->input->post ('harga['.$k.']'),
				'id_supplier' 	=> $this->input->post ('supplier['.$k.']'),
				'keterangan' 	=> $this->input->post ('ket['.$k.']'),
			]; 

			$update = [
				'stok_tersedia' => $brg->stok_tersedia + $jml
			];

			$harga_modal = [
				'harga_modal' => $this->input->post ('harga_modal['.$k.']')
			];

			$where = [
				'kode_brg' => $v,
				'id_toko'  => $id_toko
			];

			$this->brg->update_harga_modal ($harga_modal, $where);
			$this->brg->update_stok_tersedia ($update, $where);
		}

		$detail = [
			'kode_masuk' => $kode,
			'tgl_masuk'  => date('Y-m-d G:i:s'),
			'id_admin' 	 => admin()->id_admin,
			'id_toko' 	 => $id_toko
		];

		$this->brg->tambah_brgm($insert);
		$this->brg->tambah_detail_brgm($detail);

	}

	function hps_masuk ($id = null) {
		$this->brg->hps_masuk ($id);
	}

	function hps_brgm ($id) {
		$this->brg->hps_brgm ($id);
	}

	function brg_keluar() {
		$conf = [
			'tabTitle' 	=> 'Barang keluar | ' . webTitle(),
			'data_brg'  => $this->brg->data_brg (),
			'webInfo' => '
				<strong>'. __CLASS__ .'</strong>
				<span>Barang keluar</span>
			',
			'data_brg'    => $this->brg->data_brg(),
			
		];

		if(admin()->level != 'Kasir' && admin()->level != 'Teknisi') {
			$this->layout->load('layout', 'barang/brg_keluar', $conf);

		} else {
			$this->load->view('404');
		}
	}

	function load_data_brgk() {
		$list = $this->brg->detail_keluar();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$jml_brg = $this->brg->count_jml_keluar ($item->kode_keluar);
			$total = $this->brg->total_harga_keluar ($item->kode_keluar);

			$aksi = '
				<div class="mt-2">
					<a href="'.site_url('inventaris/detail_keluar/'.$item->kode_keluar).'" data-target="#modal_detail_brgk" data-toggle="modal" class="badge badge-secondary btn_load_brgk">
						Detail
					</a>
					<a href="'.site_url('inventaris/hps_keluar/'.$item->kode_keluar).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_brg.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->kode_keluar .
				'<div>
					<small class="text-muted">
						<span>'.$jml_brg.' Barang</span>
						<span class="mx-2"> | </span>
						<span>Total: '.nf($total).'</span>
					</small>
				</div>								
			' . $aksi ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_keluar(),
			"recordsFiltered"  => $this->brg->count_keluar(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function detail_keluar ($kode = null) {
		$data 	= $this->brg->brg_keluar ($kode)->result ();
		$detail = $this->brg->detail_brg_keluar ($kode);

		$html 	= '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">
                        Barang
                    </h5>
                    <small>Detail barang keluar</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
				<div class="table-responsive">
					<table class="table table-borderless table-sm w-100">
						<tr>
							<td style="width: 150px">Kode keluar</td>
							<th style="width: 20px">:</th>
							<th>'.$detail->kode_keluar.'</th>
						</tr>
						<tr>
							<td>Tgl keluar</td>
							<th>:</th>
							<th>'.date('d M Y G:i', strtotime($detail->tgl_keluar)).'</th>
						</tr>
						<tr>
							<td>Admin</td>
							<th>:</th>
							<th>'.$detail->nama_admin.'</th>
						</tr>
					</table>			
            	</div>
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="tb_form_add_brgk">
                        <thead class="text-center">
                            <th colspan="2">Barang</th>
                            <th style="width: 120px">keluar</th>
                            <th style="width: 120px">Harga</th>
                            <th style="width: 120px">Subtotal</th>
                            <th style="width: 200px;">Keterangan</th>
                        </thead>
                        <tbody>
			';
				$total = 0;
				foreach($data as $item) {
					$brg = $this->brg->brg($item->kode_brg);
					$harga = $brg ? $brg->harga_modal : 0;
					$subtotal = $harga * $item->stok_keluar;
					$total += $subtotal;
					$html .= '
						<tr>
							<td style="width: 80px;text-align:center"> 
								<a href="'.site_url('inventaris/hps_brgk/'.$item->id_keluar).'" class="btn btn-danger hps_brgk">
									<i class="fa fa-trash"></i>
								</a>
							</td>
							<td>
								'.$item->nama_brg.'
							</td>
							<td class="text-center">
								'.$item->stok_keluar.'
							</td>
							<td class="text-right">
								'.nf($item->harga_modal).'
							</td>
							<td class="text-right">
								'.nf($subtotal).'
							</td>
							<td>
								'.$item->keterangan.'
							</td>
						</tr>
					';
				}

			$html .= '
                        </tbody>
						<tfoot>
							<tr>
								<th colspan="5" class="text-right">Grand total</th>
								<th>'.nf($total).'</th>
							</tr>
						</tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-light" data-dismiss="modal">
                    Tutup
                </a>
            </div>
		';

		echo $html;
	}

	function load_modal_data_brgk() {
		$list 	= $this->brg->data_brg('DESC', 'stok-1');
		$data 	= [];
		$no 	= $this->input->post('start');
		foreach ($list as $item) { 
			$satuan = $item->satuan == 'Tidak ada satuan' ? '' : $item->satuan;
			$row   = [];
			$row[] = '
				<a href="" 
				   class="btn btn-secondary _add_brgk"
				   data-id="'.$item->id_brg.'"
				   data-nama="'.$item->nama_brg.'"
				   data-kode="'.$item->kode_brg.'"
				>
					<i class="fa fa-plus"></i>
				</a>
			';
			$row[] = '
					<strong>'.$item->nama_brg.'</strong>
					<div>
						<small>
							<strong>'. $item->kode_brg .'</strong>
							<span class="mx-2"> | </span>
							<span>stok: '. $item->stok_tersedia .' '. $satuan .'</span>
						</small>
					</div>
				';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_brg(),
			"recordsFiltered"  => $this->brg->count_brg(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function form_add_brgk () {
		$kode = $this->input->post('kode');
		$brg  = $this->brg->brg_by_kode ($kode);

		if($brg) {
			$html = '
				<tr class="tr_add_brgk">
					<td style="width: 50px;" class="text-center">
						<a href="" class="btn btn-danger hps_add_brgk">
							<i class="fa fa-trash"></i>
						</a>
					</td>
					<td>
						<input type="text" value="'.$brg->nama_brg.'" class="form-control" disabled>
						<input type="hidden" value="'.$brg->kode_brg.'" class="form-control" name="nama_brgk[]">
					</td>
					<td>
						<input type="number" class="form-control text-center"  value="'.$brg->stok_tersedia.'" disabled>
					</td>
					<td>
						<input type="number" class="form-control "  value="'.$brg->harga_modal.'" disabled>
					</td>
					<td>
						<input type="number" class="form-control text-center" name="stok_keluar[]" max="'.$brg->stok_tersedia.'" value="1" min="1" required>
					</td>
					<td>
						<input type="text" class="form-control" name="ket[]" >
					</td>
				</tr>
			';

		} else {
			$html = 'empty';
		}

		echo $html;
	}

	function proses_submit_brgk () {
		$id_toko  	= admin ()->id_toko;
		$input 		= $this->input->post (null);
		$kode 		= $this->brg->kode_keluar ();
		$insert 	= [];

		foreach ($input['nama_brgk'] as $k => $v) {
			$brg 	  = $this->brg->brg ($v, $id_toko);
			$jml 	  = $this->input->post ('stok_keluar['.$k.']');
			$insert[] = [
				'kode_keluar'	=> $kode,
				'kode_brg' 		=> $this->input->post ('nama_brgk['.$k.']'),
				'stok_keluar' 	=> $jml,
				'keterangan' 	=> $this->input->post ('ket['.$k.']'),
			]; 

			$update = [
				'stok_tersedia' => $brg->stok_tersedia - $jml
			];

			$where = [
				'kode_brg' => $v,
				'id_toko'  => $id_toko
			];

			$this->brg->update_stok_tersedia ($update, $where);
		}

		$detail = [
			'kode_keluar' => $kode,
			'tgl_keluar'  => date('Y-m-d G:i:s'),
			'id_admin' 	  => admin()->id_admin,
			'id_toko' 	  => admin()->id_toko
		];

		$this->brg->tambah_brgk($insert);
		$this->brg->tambah_detail_brgk($detail);
	}

	function hps_keluar ($id = null) {
		$this->brg->hps_keluar ($id);
	}

	function hps_brgk ($id) {
		$this->brg->hps_brgk ($id);
	}
	
	function supplier() {		
		$conf = [
			'tabTitle' 	=> 'Supplier | ' . webTitle(),
			'webInfo' => '
				<strong>
					Inventaris
				</strong>
				<span>
					Supplier
				</span>
			',
		];
		if(admin()->level != 'Kasir') {
			$this->layout->load('layout', 'barang/data_supplier', $conf);

		} else {
			$this->load->view('404');
		}
	}

	function load_data_supplier() {
		$list = $this->brg->data_supplier('desc');
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$kontak = $item->kontak ? $item->kontak : '-';
			$aksi = '
				<div class="mt-2">
					<a href="#modal_ubah_supplier" data-toggle="modal" data-id="'.$item->id_supplier.'" class="badge badge-primary btn_ubah_supplier">
						Ubah
					</a>                                        
					
					<a href="'.site_url('inventaris/hps_supplier/'.$item->id_supplier).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_supplier.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->nama_supplier. ' <br> <small class="text-muted">'.$kontak.'</small>' . $aksi ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_supplier(),
			"recordsFiltered"  => $this->brg->count_supplier(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function form_ubah_supplier($id = null) {
		$data = $this->brg->supplier($id);
		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Ubah Data supplier</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama supplier <span class="text-danger">*</span> </label>
                    <input type="hidden" name="u_id_supplier" value="'.$data->id_supplier.'">
                    <input type="text" class="form-control form-control-sm" name="u_nama_supplier" value="'.$data->nama_supplier.'" required>
                </div>           
				<div class="form-group">
                    <label for="">Kontak supplier </label>
                    <input type="text" class="form-control form-control-sm" name="u_kontak_supplier" value="'.$data->kontak.'">
                </div>         
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
		';
		echo $html;
	}

	function proses_tambah_supplier() {
		$input = $this->input->post(null, true);

		if(empty($input['nama_supplier'])) {
			echo 'Nama supplier belum diisi!';

		} else {
			
			$this->brg->tambah_supplier($input);
			
		}
	}

	function proses_ubah_supplier() {
		$input = $this->input->post(null, true);

		if(empty($input['u_nama_supplier'])) {
			echo 'Nama supplier belum diisi!';

		} else {			
			$this->brg->ubah_supplier($input);			
		}
	}

	function hps_supplier($id =  null) {
		$this->brg->hps_supplier($id);
	}

	function satuan() {
		$conf = [
			'tabTitle' 	=> 'Data satuan | ' . webTitle(),
			'webInfo' => '
				<strong>
					Inventaris
				</strong>
				<span>
					Data satuan
				</span>
			',
		];
		if(admin()->level != 'Kasir') {
			$this->layout->load('layout', 'barang/data_satuan', $conf);

		} else {
			$this->load->view('404');
		}
	}

	function load_data_satuan() {
		$list = $this->brg->data_satuan('desc');
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$aksi = '
				<div class="mt-2">
					<a href="#modal_ubah_satuan" data-toggle="modal" data-id="'.$item->id_satuan.'" class="badge badge-primary btn_ubah_satuan">
						Ubah
					</a>                                        
					
					<a href="'.site_url('inventaris/hps_satuan/'.$item->id_satuan).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_satuan.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->nama_satuan . $aksi ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_satuan(),
			"recordsFiltered"  => $this->brg->count_satuan(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function form_ubah_satuan($id = null) {
		$data = $this->brg->satuan($id);
		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Ubah Data satuan</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama satuan <span class="text-danger">*</span> </label>
                    <input type="hidden" name="u_id_satuan" value="'.$data->id_satuan.'">
                    <input type="text" class="form-control form-control-sm" name="u_nama_satuan" value="'.$data->nama_satuan.'" required>
                </div>                    
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
		';
		echo $html;
	}

	function proses_tambah_satuan() {
		$input = $this->input->post(null, true);

		if(empty($input['nama_satuan'])) {
			echo 'Nama satuan belum diisi!';

		} else {
			
			$this->brg->tambah_satuan($input);
			
		}
	}

	function proses_ubah_satuan() {
		$input = $this->input->post(null, true);

		if(empty($input['u_nama_satuan'])) {
			echo 'Nama satuan belum diisi!';

		} else {
			
			$this->brg->ubah_satuan($input);
			
		}
	}

	function hps_satuan($id =  null) {
		$this->brg->hps_satuan($id);
	}

	function kategori() {		
		$conf = [
			'tabTitle' 	=> 'Kategori | ' . webTitle(),
			'webInfo' => '
				<strong>
					Inventaris
				</strong>
				<span>
					Kategori
				</span>
			',
		];
		if(admin()->level != 'Kasir') {
			$this->layout->load('layout', 'barang/data_kategori', $conf);

		} else {
			$this->load->view('404');
		}
	}

	function load_data_kategori() {
		$list = $this->brg->data_kategori('desc');
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$aksi = '
				<div class="mt-2">
					<a href="#modal_ubah_kategori" data-toggle="modal" data-id="'.$item->id_kategori.'" class="badge badge-primary btn_ubah_kategori">
						Ubah
					</a>                                        
					
					<a href="'.site_url('inventaris/hps_kategori/'.$item->id_kategori).'" class="badge badge-danger hps" data-text="<strong>'.$item->nama_kategori.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			';          
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->nama_kategori . $aksi ;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_kategori(),
			"recordsFiltered"  => $this->brg->count_kategori(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function form_ubah_kategori($id = null) {
		$data = $this->brg->kategori($id);
		$html = '
			<div class="modal-header">
                <div>
                    <h5 class="mb-0 text-primary">Barang</h5>
                    <small class="text-muted">Ubah Data Kategori</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Kategori <span class="text-danger">*</span> </label>
                    <input type="hidden" name="u_id_kategori" value="'.$data->id_kategori.'">
                    <input type="text" class="form-control form-control-sm" name="u_nama_kategori" value="'.$data->nama_kategori.'" required>
                </div>                    
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
		';
		echo $html;
	}

	function proses_tambah_kategori() {
		$input = $this->input->post(null, true);

		if(empty($input['nama_kategori'])) {
			echo 'Nama kategori belum diisi!';

		} else {
			
			$this->brg->tambah_kategori($input);
			
		}
	}

	function proses_ubah_kategori() {
		$input = $this->input->post(null, true);

		if(empty($input['u_nama_kategori'])) {
			echo 'Nama kategori belum diisi!';

		} else {
			
			$this->brg->ubah_kategori($input);
			
		}
	}

	function hps_kategori($id =  null) {
		$this->brg->hps_kategori($id);
	}

	function opname() {
		$conf = [
			'tabTitle' 	=> 'Opname | ' . webTitle(),
			'webInfo' => '
				<strong>
					Inventaris
				</strong>
				<span>
					Opname
				</span>
			',
			'kode' => $this->brg->kode_opname()
		];
		if(admin()->level != 'Kasir') {
			$this->layout->load('layout', 'barang/data_opname', $conf);

		} else {
			$this->load->view('404');
		}
	}

	function load_data_opname() {
		$list = $this->brg->data_opname('desc');
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 	
			$aksi = '
				<div class="mt-2">
					<a href="#modal_detail_opname" data-toggle="modal" data-id="'.$item->kode_opname.'" class="badge badge-secondary btn_detail_opname">
						Detail
					</a>                                        
					
					<a href="'.site_url('inventaris/hps_opname/'.$item->kode_opname).'" class="badge badge-danger hps" data-text="<strong>'.$item->kode_opname.'</strong> akan dihapus dari daftar">
						Hapus
					</a>
				</div>
			';		
			$no++;
			$row   = [];
			$row[] = $no;
			$row[] = $item->kode_opname. 
				'
					<div class="text-muted">
						<small> Tgl: '. tgl(date('d M Y', strtotime($item->tgl_opname))) . '</small>
						<small class="mx-2"> | </small>
						<small> Petugas: '. $item->nama_admin . '</small>
					</div> 
				' . 
				$aksi;
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_opname(),
			"recordsFiltered"  => $this->brg->count_opname(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function data_detail_opname($id = null) {
		$opname = $this->brg->opname($id);
		$info 	= $this->brg->info_opname($id);

		$html 	= '
			<div class="modal-header">
                <div>
                    <h5 class="text-primary mb-0">Opname</h5>
                    <small>Detail stok opname</small>
                </div>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card border mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <h5>Informasi</h5>
                        <a href="#data_info_opname" data-toggle="collapse" class="btn btn-secondary d_collps_opname">                           
                            <i class="fa fa-chevron-down"></i>                            
                        </a>
                    </div>
                    <div class="card-body collpase show" id="data_info_opname" style="position: relative">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0 bg-transparent">
                                <tr>
                                    <th style="width: 120px">
                                        Tgl Opname
                                    </th>
                                    <th style="width: 20px"> : </th>
                                    <th> 
                                        '. tgl(date('d M Y', strtotime($info->tgl_opname))) .'
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width: 120px">
                                        Kode
                                    </th>
                                    <th style="width: 20px"> : </th>
                                    <th> 
                                        '.  $info->kode_opname .'
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width: 120px">
                                        Petugas
                                    </th>
                                    <th style="width: 20px"> : </th>
                                    <th> 
                                        '.  $info->nama_admin .'
                                    </th>
                                </tr>
                            </table>
                        </div>

                        <div class="card-icon d-flex">
                            <i class="fa fa-info"></i>
                        </div>
                    </div>
                </div>

                <div class="card border mb-0">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Stok</h5>
                            <small class="text-muted">Data stok opname</small>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped w-100 mb-0">
                                <thead class="text-center">
                                    <th colspan="2">Barang</th>
                                    <th style="width: 100px">
                                        Stok
                                        <br>
                                        <small>Sistem</small>
                                    </th>
                                    <th style="width: 100px">
                                        Stok
                                        <br>
                                        <small>Fisik</small>
                                    </th>
                                    <th style="width: 100px">
                                        Selisih
                                        <br>
                                        <small>Fisik - Sistem</small>
                                    </th>
                                    <th style="width: 200px">
                                        Keterangan
                                    </th>
                                </thead>
                                <tbody>
		';
							$no = 1;
							foreach($opname as $data) {
								$selisih = $data->jml_fisik - $data->jml_system;
								$ket 	 = $data->keterangan ? $data->keterangan : '<div class="text-center"> - </div>';
								$html .= '
									<tr class="text-center">
										<td style="width: 50px"> '. $no++ .' </td>
										<td class="text-left">
											'. $data->nama_brg .'
										</td>
										<td>
											'. $data->jml_system .'
										</td>
										<td>
											'. $data->jml_fisik .'
										</td>
										<td>
											'. $selisih .'
										</td>
										<td class="text-left">
											'. $ket .'
										</td>
									</tr>
								';
							}
		
		$html .= '
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
		';
		echo $html;
	}

	function btn_submit_opname() {
		$cek = $this->brg->count_all_tambah_opname();

		if($cek > 0) {
			echo '
				<button class="btn btn-primary">
					<i class="fa fa-save mr-1"></i> Simpan
				</button>
			';
		}
	}

	function btn_tambah_brg_opname($id = null) {		
		$cek = $this->brg->cek_tambah_opname($id);
		if($cek > 0) {
			$aksi 	 = '
				<a href="'.site_url('inventaris/proses_hapus_brg_opname/'.$id).'" class="btn btn-primary add_list_check checked">
					<i class="fa fa-check"></i>
				</a>                                        
			';          

		} else {
			$aksi 	 = '
				<a href="'.site_url('inventaris/proses_tambah_brg_opname/'.$id).'" class="btn btn-secondary add_list_check">
					<i class="fa fa-plus"></i>
				</a>                                        
			';

		}

		return $aksi;
	}

	function load_list_brg_opname() {
		$list = $this->brg->data_brg('DESC', null);
		$data = [];
		foreach ($list as $item) { 			
			$row   = [];
			$row[] = $this->btn_tambah_brg_opname($item->id_brg);
			$row[] = $item->nama_brg .
				'<div>
					<small>
						<span>'.$item->kode_brg.'</span>
						<span class="mx-2"> | </span>
						<span>Stok: '.$item->stok_tersedia.'</span>
					</small>
				</div>								
			';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_brg(),
			"recordsFiltered"  => $this->brg->count_brg(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function load_data_tambah_opname() {	
		$list = $this->brg->data_tambah_opname();
		$data = [];
		$no = $this->input->post('start');
		foreach ($list as $item) { 
			$aksi = '
				<a href="'.site_url('inventaris/hps_tambah_opname/'.$item->id).'" data-id="'.$item->id.'" class="btn btn-danger hps" data-text="">
					<i class="fa fa-trash"></i>
				</a>                                        
			';          
			$no++;
			$row   = [];
			$row[] = $aksi;
			$row[] = $item->nama_brg .
				'<div>
					<small>
						<input type="hidden" name="id_brg[]" value="'.$item->id_brg.'">
						Kode: '.$item->kode_brg.'
					</small>					
				</div>								
			';
			$row[]  = $item->stok_tersedia . '<input type="hidden" name="jml_stok_system[]" class="jml_stok_system_'.$item->id_brg.'" value="'.$item->stok_tersedia.'">';
			$row[]  = '
				<input type="number" class="form-control form-control-sm text-center jml_stok_fisik" name="jml_stok_fisik[]" data-id="'.$item->id_brg.'">
			';
			$row[]  = '<span class="jml_selisih_stok_'.$item->id_brg.'">0</span>';
			$row[]  = '
				<input type="text" class="form-control form-control-sm" name="ket[]" >
			';
			$data[] = $row;
		}
		$output = [
			"draw"             => $this->input->post('draw'),
			"recordsTotal"     => $this->brg->count_all_tambah_opname(),
			"recordsFiltered"  => $this->brg->count_tambah_opname(),
			"data"             => $data,
		];
		echo json_encode($output);
	}

	function proses_tambah_brg_opname_scanner($kode = null) {
		$brg = $this->brg->brg_by_kode($kode);
		if($brg) {
			$this->brg->tambah_brg_opname($brg->id_brg);		
		} else {
			echo 'empty';
		}
	}

	function proses_tambah_brg_opname($id = null) {
		$this->brg->tambah_brg_opname($id, );		
	}

	function proses_hapus_brg_opname($id = null) {
		$this->brg->hapus_brg_opname($id, );		
	}

	function proses_submit_opname() {
		$kode    = $this->brg->kode_opname();
		$input   = $this->input->post(null, true);
		$brg     = []; 

		foreach($input['id_brg'] as $i => $v) {
			$id_brg 	= $this->input->post('id_brg['.$i.']');
			$stok_fisik = $this->input->post('jml_stok_fisik['.$i.']');

			$brg[] = [
				'kode_opname' => $kode,
				'id_brg' 	  => $id_brg,
				'keterangan'  => $this->input->post('ket['.$i.']'),
				'jml_system'  => $this->input->post('jml_stok_system['.$i.']'),
				'jml_fisik'   => $stok_fisik ? $stok_fisik : 0,
			];

			$update = [
				'stok_tersedia' => $stok_fisik ? $stok_fisik : 0
			]; 
			$where = [
				'id_brg' => $id_brg
			];

			$this->brg->update_stok_tersedia($update, $where);
		}

		$info = [
			'kode_opname' => $kode,
			'tgl_opname'  => $input['tgl_opname'] ? $input['tgl_opname'] : date('Y-m-d G:i:s'),
			'id_admin' 	  => admin()->id_admin,
			'id_toko'  	  => admin()->id_toko,
		];

		$this->brg->submit_opname($brg, );
		$this->brg->submit_info_opname($info);

	}

	function hps_tambah_opname($id = null) {
		$this->brg->hps_tambah_opname($id);
	}

	function hps_opname($id = null) {
        $this->brg->hps_opname($id);
    }
}