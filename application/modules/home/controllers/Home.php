
<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Home extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		ini_set("memory_limit","-1");
		date_default_timezone_set('Asia/Jakarta');
		        
        if(!$this->M_user->is_logged_in()){ redirect("login"); }
	}	

	public function index(){		
		$pemenang = $this->db->query("SELECT * from ta_peserta where status = 'MENANG'");
		$data['nama_pemenang'] = $pemenang;
		$list_pemenang = "";
		
		foreach($pemenang->result() as $item){
			if($list_pemenang != "")
            {
                $list_pemenang = $list_pemenang.",'".$item->ta_peserta_id."'";
            }
            else
            {
                $list_pemenang = "'".$item->ta_peserta_id."'";
            }
		}
		$data['ListPemenang'] = $list_pemenang;
		///
		$data['pengaturan'] = $this->db->get("pengaturan")->row();
		$data['hadiah'] = $this->db->get("ta_hadiah");
		$data['title'] = "Aplikasi Undian";
		$data["content"] = "index";
		$this->load->view('template', $data);
	}

	public function get_cabang($id) {
		// Ambil data hadiah berdasarkan ID dari tabel ta_hadiah
		$this->db->where('ta_hadiah_id', $id);  // Menambahkan where untuk mencocokkan ta_hadiah_id
		$query = $this->db->get('ta_hadiah');  // Query ke tabel ta_hadiah
	
		// Cek jika data ditemukan
		if ($query->num_rows() > 0) {
			// Ambil hasil query
			$hadiah = $query->row();  // Ambil baris pertama hasil query (karena kita mencari berdasarkan ID)
	
			// Jika ada data cabang, decode JSON dan kirimkan dalam format JSON
			if (!empty($hadiah->cabang)) {
				$cabangArray = json_decode($hadiah->cabang);
				echo json_encode(['cabang' => $cabangArray]);
			} else {
				// Jika tidak ada data cabang, kirimkan pesan error
				echo json_encode(['error' => 'Cabang tidak ditemukan untuk hadiah ini']);
			}
		} else {
			// Jika hadiah tidak ditemukan
			echo json_encode(['error' => 'Hadiah tidak ditemukan']);
		}
	}
	

	public function peserta_baru(){
		$records = 1000;		
		$peserta = $this->db->query("select A.no_undian from ta_peserta A									
									where A.status is null									
									ORDER BY RAND()
									LIMIT $records");
									
		foreach($peserta->result() as $item){
			$listPeserta = array();
			$listPeserta[] = $item->no_undian;  
			$data[] = $listPeserta;
		}   									
		echo json_encode($data);
	}

	
	public function get_peserta_by_cabang() {
		// Mendapatkan data cabang dari request
		$cabangArray = $this->input->post('cabang');  // Cabang yang dipilih
		
		// Menentukan jumlah peserta yang akan diambil
		$records = 1000;
	
		// Pastikan cabangArray valid dan bukan array kosong
		if (!empty($cabangArray) && is_array($cabangArray)) {
			// Menambahkan filter WHERE IN untuk cabang
			$this->db->where_in('cabang', $cabangArray);  // Filter berdasarkan cabang
		}
	
		// Query untuk mengambil peserta yang statusnya null
		$this->db->select('A.no_undian');
		$this->db->from('ta_peserta A');
		$this->db->where('A.status IS NULL');
		
		// Batasi hasil dengan limit
		$this->db->limit($records);
		
		// Menjalankan query
		$query = $this->db->get();
		
		// Menyimpan hasil peserta
		$data = [];
		foreach ($query->result() as $item) {
			$listPeserta = [];
			$listPeserta[] = $item->no_undian;
			$data[] = $listPeserta;
		}
	
		// Mengirimkan hasil sebagai JSON
		echo json_encode($data);
	}
	
	

	public function pemenang(){
		$data['title'] = "Aplikasi Undian";
		$data['pengaturan'] = $this->db->get("pengaturan")->row();
	 	$data["content"] = "pemenang";
	 	$this->load->view('template', $data);
	}

	function get_pemenang()
    {
    	$this->load->model('Pemenang_model');
        $list = $this->Pemenang_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();			
            $row[] = $field->no_undian;
            $row[] = $field->nama_peserta;
            $row[] = $field->no_hp;
            $row[] = $field->alamat;
			$row[] = $field->nama_hadiah;  			           
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Pemenang_model->count_all(),
            "recordsFiltered" => $this->Pemenang_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    } 		

	public function delete_pemenang(){		
		$this->db->query("UPDATE ta_peserta set status = null, pemenang_ke = null, kategori_hadiah = null, nama_hadiah = null, updated_time = null");	
		$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
	}

	public function delete_batal(){		
		$this->db->query("UPDATE ta_peserta set status = null where status = 'BATAL'");	
		$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
	}

	public function reset_batal_by_one(){	
		$ta_peserta_id = $this->input->post('id_delete');
		$this->db->query("UPDATE ta_peserta set status = null where ta_peserta_id = $ta_peserta_id ");	
		$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
	}

	public function delete_peserta(){		
		$this->db->truncate('ta_peserta');		
		$this->db->query("ALTER TABLE ta_peserta AUTO_INCREMENT = 1");
		
		$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
	}

	public function export_pemenang(){
		$data['pemenang'] = $this->db->query("SELECT * 
							from ta_peserta 
							where status = 'MENANG'");
		$this->load->view('export-pemenang', $data);
	}

	public function peserta()
	{				
		$data['title'] = "Aplikasi Undian";
		$data["content"] = "peserta";
		$data['pengaturan'] = $this->db->get("pengaturan")->row();
		$this->load->view('template', $data);
	}

	function get_peserta()
    {
    	$this->load->model('Peserta_model');
        $list = $this->Peserta_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $field->no_undian;
            $row[] = $field->nama_peserta;
            $row[] = $field->no_hp;
            $row[] = $field->alamat;   
            $row[] = $field->cabang;   
			$row[] = '<a href="javascript:void(0)" class="delete-by-one" id="'.$field->ta_peserta_id.'"><i class="fa fa-trash text-danger"></i></a>';                    
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Peserta_model->count_all(),
            "recordsFiltered" => $this->Peserta_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    } 	

	public function delete_peserta_by_one(){	
		$ta_peserta_id = $this->input->post('id_delete');
		$this->db->query("DELETE from ta_peserta where ta_peserta_id = $ta_peserta_id ");	
		$this->session->set_flashdata('success', 'Data berhasil di hapus');
		$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
	}

	public function peserta_save(){
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nama','nama', 'required');
		$this->form_validation->set_rules('nomor_undian','nomor undian', 'required');
		$this->form_validation->set_rules('alamat','alamat', 'required');
		if ($this->form_validation->run() == FALSE) {
		    /*echo validation_errors();*/
		    $arr = array(
			    'nama' => form_error('nama'),
			    'nomor_undian' => form_error('nomor_undian'),
			    'alamat' => form_error('alamat')
			);
			echo json_encode($result);
		} 
		else{
			/* cek jika nomor pernah tersimpan */
			$ta_undian_nama_id = $this->session->userdata('ta_undian_nama_id');
			$nomor = $this->security->xss_clean($this->input->post('nomor_undian'));
			$cek = $this->db->query("SELECT * FROM ta_undian_nama_list WHERE ta_undian_nama_id = ".$ta_undian_nama_id." and nomor_undian = '".$nomor."'");
			if($cek->num_rows() > 0){
				echo "error_code2";
			}
			else{
				$data = array(
					 'ta_undian_nama_id' => $this->session->userdata('ta_undian_nama_id'),				 
					 'nomor_undian' => $this->security->xss_clean($this->input->post('nomor_undian')),
					 'nama_peserta' => $this->security->xss_clean($this->input->post('nama')),
					 'alamat' => $this->security->xss_clean($this->input->post('alamat')),
					 'keterangan' => $this->security->xss_clean($this->input->post('keterangan'))
				);
				$this->db->insert('ta_undian_nama_list', $data);
				echo "success";
			}
			
		}
	}

	public function peserta_delete(){		
		$this->db->query("DELETE from ta_peserta");	
		$this->db->query("ALTER TABLE ta_peserta AUTO_INCREMENT = 1");			
		$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
	}

	public function get_undian_data(){
		$nomor = $this->input->post('nomor');
		$this->db->query("UPDATE ta_peserta set status = 'BATAL' where no_undian = '".$nomor."'");
		$data = $this->db->query("Select * from ta_peserta where no_undian = '".$nomor."'");
		if($data->num_rows() > 0){
			foreach($data->result() as $item){
				echo $item->nomor_undian."|".$item->nama_peserta."|".$item->alamat;
			}
		}
		else{
			echo "000000|[ NOMOR TIDAK ADA ]|-";
		}
	}

	public function save_result(){
		$nomor = $this->input->post('nomor');		
		$hadiah = $this->input->post('rewards');
		$pemenang_ke = $this->input->post('pemenang_ke');
		$tmp = explode("|", $hadiah);
		$ta_hadiah_id = $tmp[0];
		$tmp = $this->db->query("SELECT * from ta_hadiah where ta_hadiah_id = $ta_hadiah_id")->row();
		$nama_hadiah = $tmp->nama_hadiah;
		$kategori_hadiah = $tmp->kategori_hadiah;
		$data = array(
			'status' => 'MENANG',						 		 
			'pemenang_ke' => $pemenang_ke,
			'kategori_hadiah' => $kategori_hadiah,
			'nama_hadiah' => $nama_hadiah,
			'updated_time' => date('Y-m-d H:i:s')
		);
		$this->db->where('no_undian',$nomor);
		$this->db->update('ta_peserta', $data);
		echo $nama_hadiah;
	}

    // public function pengaturan(){
    // 	$data['hadiah'] = $this->db->get("ta_hadiah");
    // 	$data['pengaturan'] = $this->db->get("pengaturan")->row();
    // 	$data['cabang_by_peserta'] = $this->db->get("ta_peserta")->row();
	// 	var_dump($data);
    // 	$data['title'] = "Aplikasi Undian";
	// 	$data["content"] = "pengaturan";
	// 	$this->load->view('template', $data);
    // }

	public function pengaturan() {
		// Ambil data hadiah
		$data['hadiah'] = $this->db->get("ta_hadiah");
	
		// Ambil data pengaturan
		$data['pengaturan'] = $this->db->get("pengaturan")->row();
	
		// Ambil data peserta dan group by cabang
		$this->db->select('cabang, COUNT(*) as total');
		$this->db->from('ta_peserta');
		$this->db->group_by('cabang');
		$query = $this->db->get();
	
		$data['cabang_by_peserta'] = $query->result_array();
	
		$data['title'] = "Aplikasi Undian";
		$data["content"] = "pengaturan";
		$this->load->view('template', $data);
	}

	public function update_cabang() {
		$hadiah_id = $this->input->post('hadiah_id');
		$cabang = $this->input->post('cabang');
		$status = $this->input->post('status');
		
		// Ambil data hadiah berdasarkan ID
		$pengaturan = $this->db->get_where('ta_hadiah', ['ta_hadiah_id' => $hadiah_id])->row();
	
		// Decode array cabang dari database
		$selected_cabangs = json_decode($pengaturan->cabang ?? '[]');
	
		if ($status == 'true') {
			// Tambahkan cabang jika belum ada
			if (!in_array($cabang, $selected_cabangs)) {
				$selected_cabangs[] = $cabang;
			}
		} else {
			// Hapus cabang dari array jika unchecked
			$selected_cabangs = array_values(array_diff($selected_cabangs, [$cabang]));
		}
	
		// Update database
		$this->db->where('ta_hadiah_id', $hadiah_id);
		$this->db->update('ta_hadiah', ['cabang' => json_encode($selected_cabangs)]);
	
		echo json_encode([
			'status' => 'success',
			'msg' => 'Cabang berhasil diperbarui'
		]);
	}
	
	

    public function update_nama_undian(){
    	$this->form_validation->set_rules('nama_undian','Nama Undian', 'required');
    	if ($this->form_validation->run() == FALSE) {
		    //echo validation_errors();
		    $data = array(
		    	'nama_undian' => form_error('nama_undian')
            );
            echo json_encode($data);
		} 
		else{
			$nama_undian = $this->input->post("nama_undian");
			$this->db->query("UPDATE pengaturan set nama_undian = '".$nama_undian."'");
			
			$result = array(
				'status' => "reload",
				'msg' => ""
			);
			echo json_encode($result);
		}
    }

    public function update_waktu_undian(){
    	$this->form_validation->set_rules('jumlah_pemenang','Jumlah Pemenang', 'required');
    	$this->form_validation->set_rules('waktu_putaran','Waktu Putaran', 'required');
    	if ($this->form_validation->run() == FALSE) {
		    //echo validation_errors();
		    $data = array(
		    	'jumlah_pemenang' => form_error('jumlah_pemenang'),
		    	'waktu_putaran' => form_error('waktu_putaran')
            );
            echo json_encode($data);
		} 
		else{
			$jumlah_pemenang = $this->input->post("jumlah_pemenang");
			$waktu_putaran = $this->input->post("waktu_putaran");
			$this->db->query("UPDATE pengaturan set jumlah_pemenang = '".$jumlah_pemenang."', waktu_putaran = '".$waktu_putaran."' ");
			$result = array(
				'status' => "reload",
				'msg' => ""
			);
			echo json_encode($result);
		}
    }

    public function rewards_save(){
    	
    	$this->form_validation->set_rules('nama_hadiah','Nama Hadiah', 'required');
		$this->form_validation->set_rules('kategori_hadiah','Kategori', 'required');
		
		if ($this->form_validation->run() == FALSE) {
		    $arr = array(
			    'nama_hadiah' => form_error('nama_hadiah'),
			    'kategori_hadiah' => form_error('kategori_hadiah'),
			    
			);
			echo json_encode($arr);
		} 
		else{
			$config['upload_path']="./assets/img";
	        $config['allowed_types']='gif|jpg|png';
	        $this->load->library('upload',$config);
	        if($this->upload->do_upload("file")){
		        $data = array('upload_data' => $this->upload->data());
		        $img_name = $this->upload->data('file_name'); 
		        $data = array(
					 'kategori_hadiah' => $this->input->post("kategori_hadiah"),				 
					 'nama_hadiah' => $this->input->post("nama_hadiah"),
					 'gambar_hadiah' => $img_name
				);
				$this->db->insert('ta_hadiah', $data);
				
				$result = array(
					'status' => "reload",
					'msg' => ""
				);
				echo json_encode($result);
	        }
	        else{
	        	$arr = array(
				    'file' => $this->upload->display_errors()
				);
				echo json_encode($result);
	        }
		}
    }

    public function delete_rewards(){
    	$data = $this->input->post("id_delete");
    	$tmp = explode("|", $data);
    	$ta_hadiah_id = $tmp[0];
    	$gambar = $tmp[1];

    	$this->db->query("DELETE from ta_hadiah WHERE ta_hadiah_id = $ta_hadiah_id ");
    	if(file_exists("./assets/img/".$gambar)){
    		unlink("./assets/img/".$gambar);
    	}
    	$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
    }

    public function logo_save(){
    	$config['upload_path']="./assets/img";
        $config['allowed_types']='gif|jpg|png|jpeg';
        $this->load->library('upload',$config);
        if($this->upload->do_upload("file")){
	        $data = array('upload_data' => $this->upload->data());
	        $img_name = $this->upload->data('file_name'); 
	        
			$this->db->query("UPDATE pengaturan set logo = '".$img_name."'");
			
			$result = array(
				'status' => "reload",
				'msg' => ""
			);
			echo json_encode($result);
        }
        else{
        	$arr = array(
			    'file' => $this->upload->display_errors()
			);
			echo json_encode($arr);
        }
    }

	public function bg_save(){
    	$config['upload_path']="./assets/img";
        $config['allowed_types']='gif|jpg|png|jpeg';
        $this->load->library('upload',$config);
        if($this->upload->do_upload("file")){
	        $data = array('upload_data' => $this->upload->data());
	        $img_name = $this->upload->data('file_name'); 
	        
			$this->db->query("UPDATE pengaturan set background = '".$img_name."'");
			
			$result = array(
				'status' => "reload",
				'msg' => ""
			);
			echo json_encode($result);
        }
        else{
        	$arr = array(
			    'file' => $this->upload->display_errors()
			);
			echo json_encode($arr);
        }
    }

    public function pengaturan_save(){
		$ta_undian_nama_id = $this->session->userdata('ta_undian_nama_id');		
		$this->db->query("UPDATE ta_undian_nama set nama_undian = '".$this->input->post('nama_undian')."' where ta_undian_nama_id = $ta_undian_nama_id ");
		redirect("pengaturan");
	}

	public function pemenang_delete(){
		$this->db->set('tanggal_undian', null);	  
		$this->db->where('tanggal_undian is NOT NULL', NULL, FALSE);  
	    $this->db->update('ta_undian_nama_list');
	}
	
    public function import(){
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        if(isset($_FILES["upload_file"]["name"]) && in_array($_FILES["upload_file"]["type"], $file_mimes)) {
            $arr_file = explode(".", $_FILES["upload_file"]["name"]);
            $extension = end($arr_file);
            
            if("csv" == $extension){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            
            $spreadsheet = $reader->load($_FILES["upload_file"]["tmp_name"]);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $sheetCount = count($sheetData);
            $data = array();
    
            for ($i = 1; $i < $sheetCount; $i ++) {
                $no_undian = $sheetData[$i][0];
                $nama_peserta = $sheetData[$i][1];
                $no_hp = $sheetData[$i][2];
                $alamat = $sheetData[$i][3];
                $points = $sheetData[$i][4]; // Assuming Column E is the points column
                $cabang = $sheetData[$i][5]; // Assuming Column E is the points column
    
                // Loop based on the numeric value in Column D
                for ($j = 1; $j <= $points; $j++) {
                    $auto_numbered_no_undian = $no_undian . '-' . $j;
                    array_push($data, array(
                        'no_undian' => $auto_numbered_no_undian,
                        'nama_peserta' => $nama_peserta,
                        'no_hp' => $no_hp,
                        'alamat' => $alamat,
                        'cabang' => $cabang,
                    ));
                }
            }
    
            $this->db->trans_start();
            $_datas = array_chunk($data, 500);
    
            foreach ($_datas as $key => $split2) {
                $this->db->insert_batch("ta_peserta", $split2);
            }
    
            $this->db->trans_complete();
            $this->db->query("DELETE FROM ta_peserta WHERE no_undian IS NULL OR no_undian = ''");
    
            $result = array(
                'status' => "reload",
                'msg' => ""
            );
    
            echo json_encode($result);
        }
    }


	public function import_excel(){
		//require_once APPPATH . "/third_party/PHPExcel/PHPExcel.php";
		set_time_limit(0);
		ini_set('memory_limit', '-1');	
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $fileName = time().$_FILES['file']['name'];
         
        $config['upload_path'] = './assets/peserta/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('file');
        $img_name = $this->upload->data('file_name');
        $inputFileName = './assets/peserta/'.$img_name;
                
        try {
			$inputFileType = IOFactory::identify($inputFileName);
			$objReader = IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
 
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		
        $data = array();
		for ($row = 2; $row <= $highestRow; $row++){
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
											NULL,
											TRUE,
											FALSE);
															
			$no_undian = trim($rowData[0][0]);
			if($no_undian != ""){
				array_push($data,array(
					"no_undian"=> $rowData[0][0],
					"nama_peserta"=> $rowData[0][1],                    
					"alamat"=> $rowData[0][2],
				));
			}													
		}

        $this->db->trans_start();
        $_datas = array_chunk($data, 300);
        foreach ($_datas as $key => $split) {
            $this->db->insert_batch('ta_peserta', $split);
        }
        $this->db->trans_complete();

		$this->db->query("DELETE from ta_peserta where no_undian is null or no_undian = '' ");
		delete_files('./assets/peserta/');
		$result = array(
			'status' => "reload",
			'msg' => ""
		);
		echo json_encode($result);
    }

	public function upload_csv()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');        
    
        if ($this->input->post('importSubmit')) {
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            $insertCount = $updateCount = $rowCount = $notAddCount = 0;
    
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                $this->load->library('CSVReader');
                $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
    
                if (!empty($csvData)) {
                    $data = array();
    
                    foreach ($csvData as $row) {
                        $rowCount++;
    
                        // Get the number of points for the participant
                        $points = isset($row['points']) ? (int)$row['points'] : 1;
    
                        // Duplicate the participant based on the points
                        for ($i = 0; $i < $points; $i++) {
                            array_push($data, array(
                                'no_undian' => $row['nomor_undian'],
                                'nama_peserta' => $row['nama_peserta'],
                                'no_hp' => $row['no_hp'],
                                'alamat' => $row['alamat']
                            ));
                        }
                    }
    
                    $this->db->trans_start();
                    $_datas = array_chunk($data, 300);
    
                    foreach ($_datas as $key => $split) {
                        $this->db->insert_batch('ta_peserta', $split);
                    }
    
                    $this->db->trans_complete();
    
                    $result = array(
                        'status' => "reload",
                        'msg' => ""
                    );
                    echo json_encode($result);
                }
            } else {
                $result = array(
                    'status' => "alert",
                    'msg' => "Ada masalah, harap coba lagi"
                );
                echo json_encode($result);
            }
    
        } else {
            $result = array(
                'status' => "alert",
                'msg' => "Terdapat kesalahan !"
            );
            echo json_encode($result);
        }
    }
 
	public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }

    public function password(){
    	$this->form_validation->set_rules('pass_b','password baru', 'required');
		$this->form_validation->set_rules('pass_c','konfirmasi password', 'required|matches[pass_b]');

		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'pass_b' => form_error('pass_b'),
		    	'pass_c' => form_error('pass_c')
            );
            echo json_encode($data);		    
		} 
		else{
			$password = $this->input->post('pass_b',TRUE);

			$data = array(				
				'password' => password_hash($password, PASSWORD_DEFAULT)
			);
			$this->db->where('ta_user_id',1);
			$this->db->update('ta_user',$data);
			$this->session->set_flashdata('success', 'Password berhasil diubah');
			
			$result = array(
				'status' => "reload",
				'msg' => ""
			);
			echo json_encode($result);
		}
    }
	
	public function error(){
		$data['description'] = "";
		$data['title'] = "Kesalahan";
		$data['keywords'] = "";
		$data["content"] = "error";
		$this->load->view('template', $data);
	}

	public function batal()
	{				
		$data['title'] = "Aplikasi Undian";
		$data["content"] = "batal";
		$data['pengaturan'] = $this->db->get("pengaturan")->row();
		$this->load->view('template', $data);
	}

	function get_batal()
    {
    	$this->load->model('PesertaBatal_model');
        $list = $this->PesertaBatal_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $field->no_undian;
            $row[] = $field->nama_peserta;            
            $row[] = $field->alamat;   
			$row[] = '<a href="javascript:void(0)" class="delete-by-one" id="'.$field->ta_peserta_id.'"><i class="fa fa-trash text-danger"></i></a>';          
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PesertaBatal_model->count_all(),
            "recordsFiltered" => $this->PesertaBatal_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    } 	
	
}
