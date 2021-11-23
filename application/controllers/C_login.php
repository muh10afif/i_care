<?php
class C_login extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('model_login');
	}

	/*****************************************************************************************************/
    /*
    /*                                           LOGIN
    /*
    /*****************************************************************************************************/

	function index(){
		$this->load->library('Cek_login_lib');
        $this->cek_login_lib->logged_in_true();
		
		$this->load->view('V_login');
	}

	public function cek_login()
	{
		$u = $this->input->post('username', TRUE);
		$p = $this->input->post('password', TRUE);

		$username = $this->security->xss_clean(trim(htmlspecialchars($u, ENT_QUOTES))); 
		$password = $this->security->xss_clean(trim(htmlspecialchars($p, ENT_QUOTES))); 

		$cek_username = $this->model_login->cek_user_login($username);

		if ($cek_username->num_rows() != 0) {
			$data = $cek_username->row_array();
			
			// cek password dengan verify
			if (password_verify($password,$data['sha'])) {

				// if ($data['id_level'] == 2) {
				// 	$data_session = array(
				// 		'nama' 		=> $data['username'],
				// 		'masuk' 	=> 'i_care',
				// 		'level'		=> $data['level'],
				// 		'id_level'	=> $data['id_level']
				// 	);
				// 	$this->session->set_userdata($data_session);

				// 	// berhasil login
				// 	echo json_encode(['hasil' => 2]);
				// } else {
				// 	// bukan user i-care
				// 	echo json_encode(['hasil' => 3]);
				// }

				$data_session = array(
					'nama' 			=> $data['username'],
					'masuk' 		=> 'i_care',
					'level'			=> $data['level'],
					'id_level'		=> $data['id_level'],
					'id_pengguna'	=> $data['id_pengguna'],
				);
				$this->session->set_userdata($data_session);

				echo json_encode(['hasil' => 2]);
			
			} else {
				// password salah
				echo json_encode(['hasil'  => 1]);
			}

		} else {
			// username tidak ditemukan
			echo json_encode(['hasil'  => 0]);
		}

	}
	
	// aksi keluar
    function logout(){
        $us = $this->session->userdata('masuk');
        
        if ($us == 'i_care') {
            $this->session->sess_destroy();
            redirect(base_url());  
        } else {
            redirect(base_url());  
        }
	}
	
	public function tes()
	{
		echo $pass = password_hash('iic4r3', PASSWORD_DEFAULT);
	}

}
