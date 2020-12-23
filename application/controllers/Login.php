<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('login/login.php');
	}
	function cheklogin(){
		$email      = $this->input->post('email');
		//$password   = $this->input->post('password');
		$password = $this->input->post('password',TRUE);
		$hashPass = password_hash($password,PASSWORD_DEFAULT);
		$test     = password_verify($password, $hashPass);
		// query chek users
		$this->db->where('email',$email);
		//$this->db->where('password',  $test);
		$users       = $this->db->get('tbl_user');
		if($users->num_rows()>0){
			$user = $users->row_array();
			if(password_verify($password,$user['password'])){
				// retrive user data to session
				$this->session->set_userdata($user);
				redirect('Welcome_message');
			}else{
				redirect('login');
			}
		}else{
			$this->session->set_flashdata('status_login','email atau password yang anda input salah');
			redirect('login');
		}
	}
}
