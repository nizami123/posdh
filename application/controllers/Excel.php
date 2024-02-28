<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Excel extends CI_Controller {
	function __construct() {
		parent::__construct();
		belum_login();
		waktu_local ();
		$this->load->model('m_barang', 'brg');
	}
	
	function import() {
		$conf = [
			'tabTitle' 	=> 'Import Stok Barang | ' . webTitle(),
			'webInfo'  		=> '
				<strong>'. __CLASS__ .'</strong>
				<span> Import </span>
			'
		];
		$this->layout->load ('layout', 'barang/import', $conf);

		if (isset($_POST['submit'])) {
			$file 		= $_FILES['file'];
			$file_name  = $file['name'];
			$file_tmp   = $file['tmp_name'];
			$import 	= [];
			$error 		= '';
			
			if (empty($file_name)) {
				$this->session->set_flashdata ('danger', 'File belum diupload');
				redirect(strtolower(__CLASS__) . '/' . __FUNCTION__);

			} else {
				$reader 	 = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				$spreadsheet = $reader->load($file_tmp);
				$sheetData 	 = $spreadsheet->getActiveSheet()->toArray();
				$id_toko  	 = admin()->id_toko;
				
				$jmlAdd  = 0;
				$jmlUp 	 = 0;

				for ($i = 1; $i < count($sheetData) ; $i++) { 
					$kode_brg = $sheetData[$i][0];
					$stok_brg = $sheetData[$i][2];
					$cek_brg  = $this->brg->brg ($kode_brg, $id_toko);

					if ($cek_brg) {
						$update  = [
							'nama_brg' 		=> $sheetData[$i][1],
							'stok_tersedia' => $stok_brg == $cek_brg->stok_tersedia ?  $cek_brg->stok_tersedia : $stok_brg,
							'satuan' 		=> $sheetData[$i][3],
							'harga_eceran' 	=> $sheetData[$i][4],
							'harga_modal' 	=> $sheetData[$i][5],
							'tgl_exp' 		=> $sheetData[$i][6],
							'etalase' 		=> $sheetData[$i][7],
							'kategori' 		=> $sheetData[$i][8],
						];

						$this->brg->update_import_brg ($update, $kode_brg, $id_toko);
						$jmlUp++;

					} else {

						$import[] = [
							'kode_brg' 		=> $sheetData[$i][0] ? $sheetData[$i][0] : rand(1000, 9999).date('dmy'),
							'nama_brg' 		=> $sheetData[$i][1],
							'stok_tersedia' => $sheetData[$i][2],
							'satuan' 		=> $sheetData[$i][3],
							'harga_eceran' 	=> $sheetData[$i][4],
							'harga_modal' 	=> $sheetData[$i][5],
							'tgl_exp' 		=> $sheetData[$i][6],
							'etalase' 		=> $sheetData[$i][7],
							'kategori' 		=> $sheetData[$i][8],
							'id_toko' 		=> $id_toko,
						];

						$jmlAdd++;

					}
				}
			
				if ($jmlUp > 0) {
					$this->session->set_flashdata('success_up', '<span class="badge badge-light text-success mx-1"><i class="fa fa-check-circle"></i> ' . $jmlUp . ' barang </span> diupdate');
				} 
				
				if ($jmlAdd > 0) {
					$this->brg->import_brg($import);
					$this->session-> set_flashdata('success_add', '<span class="badge badge-light text-success mx-1"><i class="fa fa-check-circle"></i> ' . $jmlAdd . ' barang </span> ditambahkan');
				}
				
				unlink($file_tmp);
				redirect('inventaris');
			}
		}
	}

	public function export($filter = null) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$style_col = [
			'font' => ['bold' => true], // Set font nya jadi bold
			'alignment' => [
				'horizontal'  => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' 	  => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
		];

		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue ('A1', "Kode Barang"); 
		$sheet->setCellValue ('B1', "Nama Barang"); 
		$sheet->setCellValue ('C1', "Stok"); 
		$sheet->setCellValue ('D1', "Satuan");
		$sheet->setCellValue ('E1', "Harga Eceran"); 
		$sheet->setCellValue ('F1', "Harga Modal"); 
		$sheet->setCellValue ('G1', "Tgl Kadaluarsa"); 
		$sheet->setCellValue ('H1', "Etalase"); 
		$sheet->setCellValue ('I1', "Kategori"); 

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A1')->applyFromArray($style_col);
		$sheet->getStyle('B1')->applyFromArray($style_col);
		$sheet->getStyle('C1')->applyFromArray($style_col);
		$sheet->getStyle('D1')->applyFromArray($style_col);
		$sheet->getStyle('E1')->applyFromArray($style_col);
		$sheet->getStyle('F1')->applyFromArray($style_col);
		$sheet->getStyle('G1')->applyFromArray($style_col);
		$sheet->getStyle('H1')->applyFromArray($style_col);
		$sheet->getStyle('I1')->applyFromArray($style_col);

		$data_brg = $this->brg->data_brg('DESC', $filter);

		$no 	= 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($data_brg as $data) { 			
			$sheet->setCellValue('A' . $numrow, $data->kode_brg);
			$sheet->setCellValue('B' . $numrow, $data->nama_brg);
			$sheet->setCellValue('C' . $numrow, $data->stok_tersedia);
			$sheet->setCellValue('D' . $numrow, $data->satuan);
			$sheet->setCellValue('E' . $numrow, $data->harga_eceran);
			$sheet->setCellValue('F' . $numrow, $data->harga_modal);
			$sheet->setCellValue('G' . $numrow, $data->tgl_exp);
			$sheet->setCellValue('H' . $numrow, $data->etalase);
			$sheet->setCellValue('I' . $numrow, $data->kategori);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(15); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(10); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(12); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(16); // Set width kolom E
		$sheet->getColumnDimension('F')->setWidth(18); // Set width kolom F
		$sheet->getColumnDimension('G')->setWidth(18); // Set width kolom F
		$sheet->getColumnDimension('H')->setWidth(18); // Set width kolom G
		$sheet->getColumnDimension('I')->setWidth(18); // Set width kolom G

		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		// Set judul file excel nya
		$sheet->setTitle("Data Barang ". webTitle());

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Barang '. admin ()->nama_toko .' '.date('dmYGis').'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');

		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
	}
}