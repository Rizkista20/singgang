<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('email')) {
		    redirect('home');
		}
		$this->load->model('M_dashboard', 'm_dashboard');
	}

	public function index(){
		$data_title['title'] = 'Dashboard'; 
		$profile['pengguna'] =  $this->m_dashboard->get_data_pengguna();
		$profile['pegawai'] = $this->m_dashboard->GetPegawai();
		$profile['kategori'] =  $this->m_dashboard->GetKategori();
		
		$this->load->view('header.php', $data_title + $profile);
		if($profile['pengguna']['id_permission'] == 1){
			$this->load->view('dashboard/super_dashboard.php',$profile);
		}else if($profile['pengguna']['id_permission'] == 2){
			$this->load->view('dashboard/admin_dashboard.php',$profile);
		}else if($profile['pengguna']['id_permission'] == 3){
			$this->load->view('dashboard/user_dashboard.php',$profile);
		}
        $this->load->view('footer.php');
	}
    
	public function kategori(){
		$data_title['title'] = 'Kategori'; 
		$profile['pengguna'] =  $this->m_dashboard->get_data_pengguna();
		
		$this->load->view('header.php', $data_title + $profile);
		$this->load->view('dashboard/kategori.php');
        $this->load->view('footer.php');
	}
    
	public function pegawai(){
		$data_title['title'] = 'Pegawai'; 
		$profile['pengguna'] =  $this->m_dashboard->get_data_pengguna();
		
		$this->load->view('header.php', $data_title + $profile);
		$this->load->view('dashboard/pegawai.php');
        $this->load->view('footer.php');
	}
    
	public function progress(){
		$data_title['title'] = 'Pegawai'; 
		$profile['pengguna'] =  $this->m_dashboard->get_data_pengguna();
		$progress['pegawai'] =  $this->m_dashboard->GetPegawai();
		$progress['kategori'] =  $this->m_dashboard->GetKategori();
		
		$this->load->view('header.php', $data_title + $profile);
		$this->load->view('dashboard/progress.php',$progress);
        $this->load->view('footer.php');
	}

	//------------------Kategori
	public function create_kategori(){
		if(!empty($_POST['kategori']) && !empty($_POST['sensor']) && !empty($_POST['socket'])){

			$data = [
				'nama_kategori' => $_POST['kategori'],
				'nama_sensor' => $_POST['sensor'],
				'nama_socket' => $_POST['socket'],
			];

			$this->m_dashboard->createIN('kategori',$data);
			echo "success";
			exit();
		}
	}
	
	public function read_kategori(){
		$kategori = $this->m_dashboard->readIN('kategori');

		$data = [];
		$no = 0;
		foreach ($kategori as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Kategori'] = $list->nama_kategori;
			$row['Sensor'] = $list->nama_sensor;
			$row['Socket'] = $list->nama_socket;
			$row['Aksi'] = $list->id_kategori;
			$data[] = $row; 
		}

		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function update_kategori(){    
		if(!empty($_POST['id_kategori']) && !empty($_POST['kategori']) && !empty($_POST['sensor']) && !empty($_POST['socket'])){
			$data = [
				'nama_kategori' => $_POST['kategori'],
				'nama_sensor' => $_POST['sensor'],
				'nama_socket' => $_POST['socket'],
			];
			$this->m_dashboard->updateIN('kategori','id_kategori',$_POST['id_kategori'],$data);
			echo "success";
			exit();
		}
	}

	public function delete_kategori(){
		if(!empty($_POST['id_kategori'])){
			$this->m_dashboard->deleteIN('kategori','id_kategori',$_POST['id_kategori']);
			echo "success";
			exit();
		}
	}

	//------------------Pegawai
	public function create_pegawai(){
		if(!empty($_POST['nama']) && !empty($_POST['email']) && !empty($_POST['alamat']) && !empty($_POST['no_hp']) && !empty($_POST['status'])){

			$data = [
				'id_permission' => '3',
				'nama' => $_POST['nama'],
				'email' => $_POST['email'],
				'no_hp' => $_POST['no_hp'],
				'alamat' => $_POST['alamat'],
				'foto' => 'profile.png',
				'status' => $_POST['status'],
				'password' => '$2y$10$X6q9jO3qVeLQUKPL0Y9Lj.QbJUp6SbtHWxSbnwheuKnuAKO8hYIz2',
			];

			$this->m_dashboard->createIN('pengguna',$data);
			echo "success";
			exit();
		}
	}
	
	public function read_pegawai(){
		$kategori = $this->m_dashboard->readIN('pengguna');

		$data = [];
		$no = 0;
		foreach ($kategori as $list) {
			if($list->id_permission == 3){
				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Nama'] = $list->nama;
				$row['Email'] = $list->email;
				$row['NoHp'] = $list->no_hp;
				$row['Alamat'] = $list->alamat;
				$row['Status'] = $list->status;
				$row['Aksi'] = $list->id_pengguna;
				$data[] = $row; 
			}
		}

		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function update_pegawai(){    
		if(!empty($_POST['id_pegawai']) && !empty($_POST['nama']) && !empty($_POST['no_hp']) && !empty($_POST['email']) && !empty($_POST['alamat']) && !empty($_POST['status'])){
			$data = [
				'nama' => $_POST['nama'],
				'email' => $_POST['email'],
				'no_hp' => $_POST['no_hp'],
				'alamat' => $_POST['alamat'],
				'status' => $_POST['status'],
			];
			$this->m_dashboard->updateIN('pengguna','id_pengguna',$_POST['id_pegawai'],$data);
			echo "success";
			exit();
		}
	}

	public function delete_pegawai(){
		if(!empty($_POST['id_pegawai'])){
			$this->m_dashboard->deleteIN('pengguna','id_pengguna',$_POST['id_pegawai']);
			echo "success";
			exit();
		}
	}

	//------------------Progress
	public function create_progress(){
		if(!empty($_POST['pegawai']) && !empty($_POST['kategori']) && !empty($_POST['jumlah']) && !empty($_POST['tanggal'])){

			$data = [
				'id_pengguna' => $_POST['pegawai'],
				'id_kategori' => $_POST['kategori'],
				'jumlah' => $_POST['jumlah'],
				'tanggal_progress' => $_POST['tanggal'],
			];
			$cek_progress = $this->m_dashboard->cek_progress($_POST['pegawai'],$_POST['tanggal']);
			if($cek_progress == false){
				$this->m_dashboard->createIN('progress',$data);
				echo "success";
			} else{
				echo "data_sudah_ada";
			}
			exit();
		}
	}
	
	public function read_progress(){
		$kategori = $this->m_dashboard->read_progress();

		$data = [];
		$no = 0;
		foreach ($kategori as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Pegawai'] = $list->nama;
			$row['Kategori'] = $list->nama_kategori;
			$row['Jumlah'] = $list->jumlah;
			$row['Tanggal'] = $list->tanggal_progress;
			$row['Aksi'] = $list->id_progress;
			$row['id_pengguna'] = $list->id_pengguna;
			$row['id_kategori'] = $list->id_kategori;
			$data[] = $row; 
		}

		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function update_progress(){
		if(!empty($_POST['id_progress']) && !empty($_POST['pegawai']) && !empty($_POST['kategori']) && !empty($_POST['jumlah']) && !empty($_POST['tanggal'])){
			
			$data = [
				'id_pengguna' => $_POST['pegawai'],
				'id_kategori' => $_POST['kategori'],
				'jumlah' => $_POST['jumlah'],
				'tanggal_progress' => $_POST['tanggal'],
			];

			$this->m_dashboard->updateIN('progress','id_progress',$_POST['id_progress'],$data);
			echo "success";
			exit();
		}
	}

	public function delete_progress(){
		if(!empty($_POST['id_progress'])){
			$this->m_dashboard->deleteIN('progress','id_progress',$_POST['id_progress']);
			echo "success";
			exit();
		}
	}

	//------------AJAX------------
	public function ajax_dashboard(){
		$pegawai = $_POST['pegawai'];
		$kategori = $_POST['kategori'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$month = date("m",strtotime($start_date));
		$years = date("Y",strtotime($start_date));
		$jumtanggal = cal_days_in_month(CAL_GREGORIAN,$month,$years);
		$donutColor = array(
			'#C45327','#DC864C','#927BE5','#52A5FF','#4DE7FF',
			'#D3AAEE','#5DDF5D','#7D44DA','#CFF4C8','#72E3C0',
			'#66B2E1','#969696','#3B3B3B','#A9873D','#8E6533',
			'#5D742A','#FFF457','#4F8F00','#9EF854','#DC4CA7'
		);
		
		//--------------------Total Sensor--------------------//
		$sensor = $this->m_dashboard->total_sensor($pegawai,$kategori,$start_date,$end_date);
		$total_sensor = number_format($sensor['total_sensor'],0,',','.');
		$month_sensor = date("d M",strtotime($start_date)) . ' - ' . date("d M",strtotime($end_date));

		//--------------------Diagram Morris--------------------//
		$data_morris = array();
		for($i=1; $i <= $jumtanggal; $i++){
			$tanggal= date('Y-m-d', mktime(0,0,0,$month,$i,$years));
			$rows = [];
			$rows['tanggal'] = $tanggal;
			$penyolderan = $this->m_dashboard->get_data_penyolderan($pegawai,$kategori,$tanggal);
			if($penyolderan['total'] > 0){
				$rows['value'] = intval($penyolderan['total']);
			}else{
				$rows['value'] = 0;
			}
			$data_morris[] =  $rows;
		}

		//--------------------Kategori Sensor--------------------//
		$Valkategori = $this->m_dashboard->GetKategori();
		$data_kategori = array();
		$i=0;
		$donut1=[];
		$donut2=[];
		$donut3=[];
		if($kategori == "*"){
			foreach($Valkategori as $list){
				$id_kategori = $list->id_kategori;
				$sumperKategori = $this->m_dashboard->sumper_kategori($pegawai,$id_kategori,$start_date,$end_date);
				if($sumperKategori['total'] > 0){
					$rows = [];
					$rows['kategori'] = $sumperKategori['nama_kategori'];
					$rows['value'] = intval($sumperKategori['total']);
					$data_kategori[] =  $rows;
					//data diagram donut
					$donut1[] = $sumperKategori['nama_kategori'];
					$donut2[] = intval($sumperKategori['total']);
					$donut3[] = $donutColor[$i++];
				}
			}
		}else{
			$sumperKategori = $this->m_dashboard->sumper_kategori($pegawai,$kategori,$start_date,$end_date);
			if($sumperKategori['total'] > 0){
				$rows = [];
				$rows['kategori'] = $sumperKategori['nama_kategori'];
				$rows['value'] = intval($sumperKategori['total']);
				$data_kategori[] =  $rows;
				//data diagram donut
				$donut1[] = $sumperKategori['nama_kategori'];
				$donut2[] = intval($sumperKategori['total']);
				$donut3[] = $donutColor[$i++];
			}
		}

		//--------------------Kategori Pegawai--------------------//
		$Valpegawai = $this->m_dashboard->GetPegawai();
		$data_pegawai = array();
		if($pegawai == "*"){
			foreach($Valpegawai as $list){
				$id_pegawai = $list->id_pengguna;
				$sumperPegawai = $this->m_dashboard->sumper_pegawai($id_pegawai,$kategori,$start_date,$end_date);
				if($sumperPegawai['total'] > 0){
					$rows = [];
					$rows['pegawai'] = $sumperPegawai['nama'];
					$rows['value'] = intval($sumperPegawai['total']);
					$data_pegawai[] =  $rows;
				}
			}
		}else{
			$sumperPegawai = $this->m_dashboard->sumper_pegawai($pegawai,$kategori,$start_date,$end_date);
			if($sumperPegawai['total'] > 0){
				$rows = [];
				$rows['pegawai'] = $sumperPegawai['nama'];
				$rows['value'] = intval($sumperPegawai['total']);
				$data_pegawai[] =  $rows;
			}
		}

		//--------------------Diagram Donut--------------------//
		$data_donut =array(
			'labels'=> $donut1,
			'datasets' => [array(
				'data'=> $donut2,
				'backgroundColor'=> $donut3,
			)],
		);

		//--------------------OUTPUT--------------------//
		$output = array(
			"massage" => "success",
			"monthSensor" => $month_sensor,
			"totalSensor" => $total_sensor,
			"dataMorris" => $data_morris,
			"dataDonut" => $data_donut,
			"dataKategori" => $data_kategori,
			"dataPegawai" => $data_pegawai,
		);
		echo json_encode($output);
		exit();
	}
}
