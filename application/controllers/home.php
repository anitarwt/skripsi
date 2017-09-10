<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Recaptcha');
    }

	public function index()
	{
		$this->template->load('static', 'profile');
		//$this->load->view('profile');
	}
	public function register(){

		 $this->template->load('static', 'register',[
          'captcha' => $this->recaptcha->getWidget(), // menampilkan recaptcha
            'script_captcha' => $this->recaptcha->getScriptTag()
            ]); // javascript recaptcha ditaruh di head
	}


    public function tambah_pegawaidb()
    {

        $this->load->model('mtabel_pegawai');
        // 
        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('jk', 'jenis kelamin', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'tgl', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'valid_email|required|');
        $this->form_validation->set_rules('hp', 'no handpone', 'numeric|required|');
        $this->form_validation->set_rules('pendidikan', 'pendidikan terakhir', 'trim|required|');
        $this->form_validation->set_rules('pengalaman', 'pengalaman kerja', 'trim|required|');
        $this->form_validation->set_rules('divisi', 'divisi', 'trim|required|');
        $this->form_validation->set_rules('g-recaptcha-response','Captcha','callback_recaptcha');
 
        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);

        if ($this->form_validation->run() == FALSE) {
            
            $this->template->load('static', 'register');

$this->session->set_flashdata('info', '<div class="alert alert-info"><h4>Data gagal dimasukan</h4></div>');
        } else {
            $this->load->library('upload');
            $nmfile = "file_" . time(); //nama file saya beri nama langsung dan diikuti fungsi time
            $config['upload_path'] = './uploads/'; //path folder
            $config['allowed_types'] = 'zip|rar|'; //type yang dapat diakses bisa anda sesuaikan
            $config['max_size'] = '3072'; //maksimum besar file 3M
            $config['file_name'] = $nmfile; //nama yang terupload nantinya

            $this->upload->initialize($config);  

            if ($this->upload->do_upload('file')) {
            $gbr = $this->upload->data();
            $this->mtabel_pegawai->tambah(); //akses model untuk menyimpan ke database    
            $this->session->set_flashdata('info', '<div class="alert alert-success"><h4>Data berhasil dimasukan</h4></div>');
            redirect('home/register');
                        
            } else {
                $this->session->set_flashdata('info', '<div class="alert alert-info"><h4>Data gagal dimasukan</h4></div>');
                redirect('home/register');
              
            }
         }

    }
}





/* End of file home.php */
/* Location: ./application/controllers/home.php */