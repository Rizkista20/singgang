<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
        
    function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('M_home', 'm_home');
    }

	public function index(){       
		if ($this->session->userdata('email')) {
            redirect('dashboard');
		}

		$this->form_validation->set_rules('email', 'E-Mail', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
			$this->load->view('login');
        } else {
            $this->login();
        }
	}

	public function login(){       
		$email = $this->input->post('email', true);
        $password = $this->input->post('password');
        $pengguna = $this->m_home->cek_pengguna($email);

		if($pengguna){
			if ($pengguna['status'] == 1){
                if (password_verify($password, $pengguna['password'])){
                    $data = [
						'email' => $pengguna['email'],
						'id_pengguna' => $pengguna['id_pengguna'],
                    ];
                    $this->session->set_userdata($data);
					redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Password salah!');
                    redirect('home');
                }
            } else {
                $this->session->set_flashdata('error', 'Email tidak aktif!');
                redirect('home');
            }
		} else {
            if($email){
                $this->session->set_flashdata('error', 'Akun tidak terdaftar!');
            }
            redirect('home');
        }
	}

    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->set_flashdata('success', 'Berhasil keluar dari akun Anda!');
        redirect('home');
    }

}