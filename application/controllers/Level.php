<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Level extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        // is_login();
        $this->load->model('Level_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','user/tbl_level_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Level_model->json();
    }

    public function read($id) 
    {
        $row = $this->Level_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_user_level'      => $row->id_user_level,
		'nama_level'     => $row->nama_level,
	    );
            $this->template->load('template','user/tbl_user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function create() 
    {
        $data = array(
            'button'        => 'Create',
            'action'        => site_url('level/create_action'),
	    'id_user_level'      => set_value('id_user_level'),
	    'nama_level'     => set_value('nama_level'),
	);
        $this->template->load('template','user/tbl_level_form', $data);
    }
    
    
    public function create_action() 
    {
        $this->_rules();
        $foto = $this->upload_foto();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $password       = $this->input->post('password',TRUE);
            $options        = array("cost"=>4);
            $hashPassword   = password_hash($password,PASSWORD_BCRYPT,$options);
            
            $data = array(
		'nama_level'     => $this->input->post('nama_level',TRUE),
	    );

            $this->Level_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Update',
                'action'        => site_url('user/update_action'),
		'id_user_level'      => set_value('id_user_level', $row->id_user_level),
		'nama_level'     => set_value('nama_level', $row->nama_level),
	    );
            $this->template->load('template','user/tbl_user_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        // $foto = $this->upload_foto();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user_level', TRUE));
        } else {
            if($foto['file_name']==''){
                $data = array(
		'nama_level'     => $this->input->post('nama_level',TRUE));
		// 'email'         => $this->input->post('email',TRUE),
		// 'id_user_level' => $this->input->post('id_user_level',TRUE),
		// 'is_aktif'      => $this->input->post('is_aktif',TRUE));
            }else{
                $data = array(
		'nama_level'     => $this->input->post('nama_level',TRUE));
		// 'email'         => $this->input->post('email',TRUE),
        //         'images'        =>$foto['file_name'],
		// 'id_user_level' => $this->input->post('id_user_level',TRUE),
		// 'is_aktif'      => $this->input->post('is_aktif',TRUE));
                
                // ubah foto profil yang aktif
                // $this->session->set_userdata('images',$foto['file_name']);
            }

            $this->Level_model->update($this->input->post('id_user_level', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('level'));
        }
    }
    
    
    function upload_foto(){
        $config['upload_path']          = './assets/foto_profil';
        $config['allowed_types']        = 'gif|jpg|png';
        //$config['max_size']             = 100;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        $this->load->library('upload', $config);
        $this->upload->do_upload('images');
        return $this->upload->data();
    }
    
    public function delete($id) 
    {
        $row = $this->Level_model->get_by_id($id);

        if ($row) {
            $this->Level_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('level'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('level'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_level', 'full name', 'trim|required');
	$this->form_validation->set_rules('id_user_level', 'id_user_level', 'trim|required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}